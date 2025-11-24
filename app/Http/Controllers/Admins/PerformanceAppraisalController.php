<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Branchs;
use App\Models\PaDetail;
use App\Models\Department;
use App\Exports\ExportKpis;
use App\Models\Performance;
use App\Models\permissions;
use Illuminate\Http\Request;
use App\Exports\DownloadKpis;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PerformanceAppraisal;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PerformanceAppraisalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permission(){
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance-admin")->first();
        return $permission;
    }
    public function index(Request $request)
    {
        $permission = self::permission();
        if (!$permission) {
            return view('upgrade.access_page');
        }
        if (request()->ajax()) {
            // Define the base query
            $query = PerformanceAppraisal::leftJoin('users', 'performance_appraisals.employee_id', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
                ->leftJoin('users as reviewEmployee', 'performance_appraisals.review_employee_id', '=', 'reviewEmployee.id')
                ->select(
                    'performance_appraisals.*',
                    'users.position_id',
                    'users.department_id',
                    'users.branch_id',
                    'users.number_employee',
                    'users.employee_name_kh',
                    'users.employee_name_en',
                    'departments.name_english as dep_name',
                    'positions.name_english as positions_name',
                    'branchs.branch_name_en',
                    'branchs.branch_name_kh',
                    'reviewEmployee.number_employee as review_employee_number_employee',
                    'reviewEmployee.employee_name_kh as review_employee_name_kh',
                    'reviewEmployee.employee_name_en as review_employee_name_en',
                )
            ->when($request->employee_id, function ($query, $employee_id) {
                return $query->where('users.number_employee', $employee_id);
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', $employee_name);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                return $query->where('users.branch_id', $branch_id);
            })
            ->when($request->department_id, function ($query, $department_id) {
                return $query->where('users.department_id', $department_id);
            });
        
            // Search filter
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('performance_appraisals.id', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
                });
            }
            
            if (in_array(Auth::user()->RolePermission, ['HR'])) {
                $query->where("performance_appraisals.review_employee_id", Auth::user()->id);
                $query->whereNot('performance_appraisals.status', 'new');
                $query->whereNot('performance_appraisals.status', 'approved');
            }

            if (in_array(Auth::user()->RolePermission, ['BOD','CEO','HOD','DHOD','BM','DBM'])) {
                $query->where('performance_appraisals.review_employee_id', Auth::user()->id);
                $query->whereNot('performance_appraisals.status', 'new');
                $query->whereNot('performance_appraisals.status', 'approved');
            }

            if (in_array(Auth::user()->RolePermission, ['Employee'])) {
                $query->where('performance_appraisals.employee_id', Auth::user()->id);
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                // $query->whereIn('performance_appraisals.status', ['approved','new']);
            }
        
            $recordsTotal = PerformanceAppraisal::where('status', 'new')->count();  // total records without filter
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));

            $order = request()->input('order', []);
            $columns = request()->input('columns', []);
            if (!empty($order)) {
                foreach ($order as $ord) {
                    $colIndex = $ord['column'];
                    $colDir   = $ord['dir'];
                    $colName  = $columns[$colIndex]['name'] ?? null;

                    if ($colName && $columns[$colIndex]['orderable'] === 'true') {
                        $query->orderBy($colName, $colDir);
                    }
                }
            } else {
                // Default order
                $query->orderBy('performance_appraisals.id', 'desc');
            }

            $data = $query->orderBy('performance_appraisals.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'permission'=>$permission,
                'userIdLog'=>Auth::user()->id,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        $department = Department::all();
        return view('performance_appraisal.index',compact('branch','department'));
    }
    public function menualScore(Request $request)
    {
        if (request()->ajax()) {
            // Define the base query
            $query = PerformanceAppraisal::leftJoin('users', 'performance_appraisals.employee_id', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
                ->select(
                    'performance_appraisals.*',
                    'users.position_id',
                    'users.department_id',
                    'users.branch_id',
                    'users.number_employee',
                    'users.employee_name_kh',
                    'users.employee_name_en',
                    'users.branch_id',
                    'departments.name_english as dep_name',
                    'positions.name_english as positions_name',
                    'branchs.branch_name_en',
                    'branchs.branch_name_kh',
                )
            ->where('performance_appraisals.status', 'approved')
            ->when($request->employee_id, function ($query, $employee_id) {
                return $query->where('users.number_employee', $employee_id);
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', $employee_name);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                return $query->where('users.branch_id', $branch_id);
            });
        
            // Search filter
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('performance_appraisals.id', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
                });
            }
        
            $recordsTotal = Performance::where('status', 'approved')->count();  // total records without filter
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $data = $query->orderBy('performance_appraisals.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        $department = Department::all();
        return view('performance_appraisal.menual_score',compact('branch','department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PerformanceAppraisal::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performance_appraisals.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performance_appraisals.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performance_appraisals.id',$id)->first();
        return view('performance_appraisal.progress',compact('data'));
    }
    public function performanceAppraisalPreview($id)
    {
        $data = PerformanceAppraisal::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performance_appraisals.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performance_appraisals.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performance_appraisals.id',$id)->first();
        return view('performance_appraisal.preview',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PerformanceAppraisal::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performance_appraisals.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performance_appraisals.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performance_appraisals.id',$id)->first();
        return view('performance_appraisal.edit_menual_score',compact('data'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            PerformanceAppraisal::where('employee_id',$request->employee_id)->where('id',$request->id)->update([
                'total_score'  => $request->total_score,
                'total_score_live_staff'  => $request->total_personnel_score,
                'total_score_direct_chairman'  => $request->total_direct_chairman,
                'updated_by'  => Auth::id(),
            ]);

            foreach ($request->performanceDetail as $value) {
                PaDetail::where('id',$value['performance_id'])->update([
                    'progress' => $value['progress'],
                    'score_achieved' => $value['score_achieved'],
                    'score' => $value['score'],
                    'score_live_staff' => $value['personnel_score'],
                    'score_direct_chairman' => $value['direct_chairman'],
                    'easy_difficult_factors' => $value['easy_difficult_factors'],
                    'comment' => $value['comment'],
                    'updated_by' => Auth::id(),
                ]);
            }
            DB::commit();
            return response()->json([
                'message' => 'successfully'
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Performance created fail.','Error');
        }
    }

    public function paAsign(Request $request)
    {
        DB::beginTransaction();
        try{
            $performance = PerformanceAppraisal::findOrFail($request->id);
            $performance->update([
                'status'                => $request->actionAsign,
                'reason'                => $request->reason,
                'review_employee_id'    => $request->asign_employee_id,
                'review_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by'            => Auth::id(),
            ]);
            // ✅ Start service email
            self::sendEmail($request->asign_employee_id);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Asing successfully successfully!',
                'status'  => 200
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function paApproved(Request $request)
    {
        DB::beginTransaction();
        try{
            $performance = PerformanceAppraisal::findOrFail($request->id);
            $performance->update([
                'reason'        => $request->reason,
                'approved_by'   => Auth::id(),
                'status'        => $request->actionAsign,
                'approved_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by'    => Auth::id(),
            ]);
            // ✅ Start service email
            self::sendEmail($request->asign_employee_id);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Asing successfully successfully!',
                'status'  => 200
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function sendEmail($asign_employee_id){
        $user = User::where("id", $asign_employee_id)->first();
        $datasSendEmail = [
            'user'      => $user,
            'type'      => "kpi",
        ];
        // Mail::to($user->email)->queue(new SendEmail($datasSendEmail, false));
    }
    public function paReturn(Request $request)
    {
        DB::beginTransaction();
        try{
            $paPerformance = PerformanceAppraisal::findOrFail($request->id);
            $paPerformance->update([
                'status'                => $request->actionAsign,
                'review_employee_id'    => $request->asign_employee_id,
                'reason'                => $request->reason,
                'reject_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by'            => Auth::id(),
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Return successfully successfully!',
                'status'  => 200
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function updateKpiScore(Request $request){
        try {
            PerformanceAppraisal::where('employee_id',$request->employee_id)->where('id',$request->id)->update([
                'total_score_direct_chairman'  => $request->total_score_direct_chairman,
                'remark'  => $request->remark,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'successfully'
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Performance created fail.','Error');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function performanceAppraisalExport($id){
        return Excel::download(new ExportKpis($id), 'kpis.xlsx');
    }

    public function performanceAppraisalImport(Request $request){
        $file = $request->file;
        $filesize = $file->getSize(); // ✅ use getSize()
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        // $dataKPI =  $spreadsheet->getSheetByName('kpi')->toArray();
        $allSheets = $spreadsheet->getAllSheets();
        $dataKPI = $allSheets[0]->toArray(); // take first sheet
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            $dataUserLeaveArray = [];
            $employeeTotals = []; // hold totals for each employee
            $scoreAchieved = 0;
            foreach ($dataKPI as $item) {
                $i++;
                if ($i != 1) {
                    $employee = User::where("number_employee", $item[0])->first();
                    if ($employee) {
                        $goalText = trim($item[7] ?? '');
                        $lines = preg_split('/\r\n|\r|\n/', $goalText);
                        $scoreAchieved = null; // default
                        foreach ($lines as $index => $line) {
                            $parts = preg_split('/\s+/', trim($line));

                            // Expect exactly 2 numbers (min and max)
                            if (count($parts) !== 2) {
                                $isValidGoal = false;
                                break;
                            }

                            [$minRaw, $maxRaw] = $parts;

                            // Convert to numeric
                            $min = (float) $minRaw;
                            $max = (float) $maxRaw;
                            $progress = $item[9]; // the value to compare
                            
                            if ($progress >= $min && $progress < $max) {
                                $scoreAchieved = $index + 1; // mimic JS: index + 1
                                break; // stop looping once found
                            }else{
                                $scoreAchieved = 5;
                            }
                        }
                        
                        $totalScore = ($item[10] * $scoreAchieved) / 100;
                        $score  = $totalScore;
                        $live   = $totalScore;
                        $chair  = $totalScore;

                        // group sums per employee
                        $eid = $employee->id;
                        if (!isset($employeeTotals[$eid])) {
                            $employeeTotals[$eid] = ['s' => 0, 'ls' => 0, 'dc' => 0];
                        }
                        $employeeTotals[$eid]['s']  += $score;
                        $employeeTotals[$eid]['ls'] += $live;
                        $employeeTotals[$eid]['dc'] += $chair;

                        // ✅ After loop, apply sums per employee
                        foreach ($employeeTotals as $employeeId => $sum) {
                            PerformanceAppraisal::where('employee_id', $employeeId)->update([
                                'total_score'             => $sum['s'],
                                'total_score_live_staff'  => $sum['ls'],
                                'total_score_direct_chairman' => $sum['dc'],
                            ]);
                        }
                        
                        $updated = PaDetail::where('performance_id', $item[2])
                            ->where('title_id', $item[3])
                            ->where('purpose_id', $item[4])
                            ->where('key_kpi', $item[5]) // extra condition
                            ->update([
                                'progress' => !empty($item[9]) ? $item[9] : null,
                                'score_achieved' => $scoreAchieved,
                                'score' => $score,
                                'score_live_staff' => $live,
                                'score_direct_chairman' => $chair,
                            ]);
                        if (!$updated) {
                            $dataArray[] = ["Row $i: No detail found for KPI {$item[5]}"];
                        }



                        // $score  = (float)($item[12] ?? 0);
                        // $live   = (float)($item[13] ?? 0);
                        // $chair  = (float)($item[14] ?? 0);

                        // // group sums per employee
                        // $eid = $employee->id;
                        // if (!isset($employeeTotals[$eid])) {
                        //     $employeeTotals[$eid] = ['s' => 0, 'ls' => 0, 'dc' => 0];
                        // }
                        // $employeeTotals[$eid]['s']  += $score;
                        // $employeeTotals[$eid]['ls'] += $live;
                        // $employeeTotals[$eid]['dc'] += $chair;

                        // $updated = PaDetail::where('performance_id', $item[2])
                        //     ->where('title_id', $item[3])
                        //     ->where('purpose_id', $item[4])
                        //     ->where('key_kpi', $item[5]) // extra condition
                        //     ->update([
                        //         'progress' => !empty($item[9]) ? $item[9] : null,
                        //         'score_achieved' => !empty($item[10]) ? $item[10] : null,
                        //         'score' => !empty($item[12]) ? $item[12] : null,
                        //         'score_live_staff' => !empty($item[13]) ? $item[13] : null,
                        //         'score_direct_chairman' => !empty($item[14]) ? $item[14] : null,
                        //     ]);
                        // if (!$updated) {
                        //     $dataArray[] = ["Row $i: No detail found for KPI {$item[5]}"];
                        // }
                    } else {
                        $dataUserLeaveArray[] = [$item[0]]; // employee not found
                    }
                }
            }

            
            if($dataArray){
                return response()->json(['error'=>$dataArray]);
            }
            return 1;
        } else {
            return 0;
        }
    }

    public function performanceAppraisalDownload(Request $request){
        return Excel::download(new DownloadKpis($request), 'kpis.xlsx');
    }
}