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
use App\Mail\SendEmail;
use App\Models\PaDetailGoal;
use App\Models\PaDetailGoalHistory;
use App\Models\PaDetailHistory;
use App\Models\PaPurpose;
use App\Models\PaPurposeHistory;
use App\Models\PaReference;
use App\Models\PaTitle;
use App\Models\PaTitleHistory;
use App\Models\PerformanceAppraisal;
use App\Models\PerformanceAppraisalHistory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Admin\ReportRepository;

class PerformanceAppraisalController extends Controller
{
    private $reportRepo;
    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permission(){
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance-appraisal")->first();
        return $permission;
    }
    public function index(Request $request)
    {
        $permission = self::permission();
        if (!$permission || $permission['is_view'] != 1) {
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
            ->whereNot('performance_appraisals.status', 'approved')
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
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
                });
            }
            if (in_array(Auth::user()->RolePermission, ['HR']) && $permission["is_access"] != 1){
                $query->where(function ($q) {
                    $q->where("users.line_manager", Auth::user()->id)   // team under me
                    ->orWhere('performance_appraisals.employee_id', Auth::user()->id)
                    ->orWhere("performance_appraisals.review_employee_id", Auth::user()->id); // my own
                });
            }

            if (in_array(Auth::user()->RolePermission, ['HOD'])) {
                $query->where("users.department_id", Auth::user()->department_id);
                $query->orWhere("performance_appraisals.review_employee_id", Auth::user()->id);
            }

            if (in_array(Auth::user()->RolePermission, ['BM'])) {
                $query->where("users.branch_id", Auth::user()->branch_id);
            }

            if (in_array(Auth::user()->RolePermission, ['BOD','CEO','DHOD', 'DBM'])) {
                $query->where(function ($q) {
                    $q->where("users.line_manager", Auth::user()->id)   // team under me
                    ->orWhere('performance_appraisals.employee_id', Auth::user()->id)
                    ->orWhere("performance_appraisals.review_employee_id", Auth::user()->id); // my own
                });
            }

            if (in_array(Auth::user()->RolePermission, ['Employee'])) {
                $query->where(function ($q) {
                    $q->where('performance_appraisals.employee_id', Auth::user()->id)
                    ->orWhere("performance_appraisals.review_employee_id", Auth::user()->id);
                });
            }
            $countPendingReview   = (clone $query)->where('performance_appraisals.status', '1')->count();
            // $countPendingAccepted = (clone $query)->where('performance_appraisals.status', '2')->count();
            $countPendingVerify   = (clone $query)->where('performance_appraisals.status', '2')->count();
            $countPendingApprove  = (clone $query)->where('performance_appraisals.status', '3')->count();
            $countPendingReturn  = (clone $query)->where('performance_appraisals.status', '4')->count();
            $query->when($request->status, function ($query, $status) {
                return $query->where('performance_appraisals.status', $status);
            });

            $recordsTotal = $query->count();  // total records without filter
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
                'data' => $data,
                'pendingReview'   => $countPendingReview,
                // 'pendingAccepted' => $countPendingAccepted,
                'pendingVerify'   => $countPendingVerify,
                'pendingApprove'  => $countPendingApprove,
                'pendingReturn'   => $countPendingReturn,
            ]);
        }
        $branch = [];
        $department = [];
        if(Auth::user()->RolePermission == "DHOD" && Auth::user()->department->abbreviations == "CRD"){
            $branch = Branchs::whereNot("id", Auth::user()->branch_id)->get();
        }
        if(in_array(Auth::user()->RolePermission,['admin','HRAdmin','developer','BOD','CEO']) || (in_array(Auth::user()->RolePermission, ['HR']) && $permission["is_access"] == 1)){
            $branch = Branchs::all();
            $department = Department::all();
        }
        return view('performance_appraisal.index',compact('branch','department','permission'));
    }
    public function menualScore(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "menual/score")->first();
        if (!$permission || $permission['is_view'] != 1) {
            return view('upgrade.access_page');
        }
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
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
                });
            }
            if (in_array(Auth::user()->RolePermission, ['HR']) && $permission["is_access"] != 1){
                $query->where(function ($q) {
                    $q->where("users.line_manager", Auth::user()->id)   // team under me
                    ->orWhere('performance_appraisals.employee_id', Auth::user()->id);
                });
            }

            if (in_array(Auth::user()->RolePermission, ['HOD'])) {
                $query->where("users.department_id", Auth::user()->department_id);
            }

            if (in_array(Auth::user()->RolePermission, ['BM'])) {
                $query->where("users.branch_id", Auth::user()->branch_id);
            }

            if (in_array(Auth::user()->RolePermission, ['BOD','CEO','DHOD', 'DBM'])) {
                $query->where(function ($q) {
                    $q->where("users.line_manager", Auth::user()->id)   // team under me
                    ->orWhere('performance_appraisals.employee_id', Auth::user()->id);
                });
            }
            if (in_array(Auth::user()->RolePermission, ['Employee'])) {
                $query->where(function ($q) {
                    $q->where('performance_appraisals.employee_id', Auth::user()->id);
                });
            }

            $recordsTotal = PerformanceAppraisal::where('status', 'approved')->count();  // total records without filter
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
    public function uploadReference(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('reference')) {
                $file = $request->file('reference');
                $filename = $request->performance_id . $request->title_id . $request->purpose_id . $request->detail_id . '_' . $file->getClientOriginalName();

                $file->storeAs('', $filename, 'd_drive');

                // ចាប់យក object ដែលបង្កើតថ្មីដាក់ក្នុង variable $data
                $data = PaReference::create([
                    'performance_id' => $request->performance_id,
                    'title_id'       => $request->title_id,
                    'purpose_id'     => $request->purpose_id,
                    'detail_id'      => $request->detail_id,
                    'reference'      => $filename,
                    'created_by'     => Auth::user()->id,
                ]);

                DB::commit();
                // បញ្ជូន id ទៅឱ្យ JavaScript វិញ
                return response()->json([
                    'message' => 'Uploaded successfully.',
                    'status'  => 200,
                    'id'      => $data->id,
                    'file_name'      => $data->reference
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()], 500);
        }
    }
    public function viewReference($id) {
        $data = PaReference::findOrFail($id);
        $fileName = $data->reference;
        $rootPath = config('filesystems.disks.d_drive.root');
        $fullPath = $rootPath . DIRECTORY_SEPARATOR . $fileName;

        if (!file_exists($fullPath)) {
            return abort(404, "រកមិនឃើញ File ក្នុង Drive D ទេ");
        }

        // ទាញយក Extension ដើម្បីឆែកប្រភេទ File
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            // បើជា PDF ឱ្យបង្ហាញក្នុង Browser ផ្ទាល់ (Inline)
            return response()->file($fullPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$fileName.'"'
            ]);
        } else {
            // បើជា Excel, RAR, ZIP ឱ្យវា Download
            return response()->download($fullPath);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PerformanceAppraisal::with(['titles.purposes.performanceDetail'=> function($query) {
                $query->with(['performanceGoals', 'reference']);
            }])
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
        $data = PerformanceAppraisal::with([
            'titles.purposes.performanceDetail'=> function($query) {
                $query->with(['performanceGoals', 'reference']);
            }
        ])
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
        $data = PerformanceAppraisal::with(['titles.purposes.performanceDetail.performanceGoals'])
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
            $paPerformance = PerformanceAppraisal::where('employee_id', $request->employee_id)
                ->where('id', $request->id)
                ->firstOrFail(); // Using firstOrFail() helps catch missing records early

            // 2. Use update() instead of save()
            $paPerformance->update([
                'total_score'                 => $request->total_score,
                'total_score_live_staff'      => $request->total_personnel_score,
                'total_score_direct_chairman' => $request->total_direct_chairman,
                'updated_by'                  => Auth::id(),
            ]);

            self::createHistories($paPerformance);

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
            self::createHistories($performance);
            $performance->update([
                'status'                => $request->actionAsign,
                'reason'                => $request->reason,
                'review_employee_id'    => $request->asign_employee_id,
                'review_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by'            => Auth::id(),
            ]);
            DB::commit();
            // ✅ Start service email
            DB::afterCommit(function () use ($request) {
                try {
                    self::sendEmail($request->asign_employee_id);
                } catch (\Exception $e) {
                    Log::error("Email failed after commit: " . $e->getMessage());
                }
            });
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
            self::createHistories($performance);
            $performance->update([
                'reason'        => $request->reason,
                'approved_by'   => Auth::id(),
                'status'        => $request->actionAsign,
                'approved_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_by'    => Auth::id(),
            ]);
            DB::commit();
            // ✅ Start service email
            DB::afterCommit(function () use ($request) {
                try {
                    self::sendEmail($request->asign_employee_id);
                } catch (\Exception $e) {
                    Log::error("Email failed after commit: " . $e->getMessage());
                }
            });
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
        if ($user->email) {
           // Mail::to($user->email)->queue(new SendEmail($datasSendEmail, false));
        }
    }
    public function paReturn(Request $request)
    {
        DB::beginTransaction();
        try{
            $paPerformance = PerformanceAppraisal::findOrFail($request->id);
            self::createHistories($paPerformance);
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

    function createHistories($data)
    {
        DB::transaction(function () use ($data) {

            // 🔹 Convert Performance to array
            $dataHistory = $data->toArray();
            unset($dataHistory['id']);
            $dataHistory['pa_id'] = $data->id;

            // 🔹 Create PerformanceHistory
            $paHistory = PerformanceAppraisalHistory::create($dataHistory);

            // 🔹 Get related Titles
            $titles = PaTitle::where("performance_id", $data->id)->get();

            foreach ($titles as $titleItem) {
                $titleArray = $titleItem->toArray();
                unset($titleArray['id']);
                $titleArray['pa_histories_id'] = $paHistory->id;

                $tHistory = PaTitleHistory::create($titleArray);

                // 🔹 Get related Purposes for this title
                $purposes = PaPurpose::where("performance_id", $data->id)
                    ->where("title_id", $titleItem->id)
                    ->get();

                foreach ($purposes as $pp) {
                    $ppArray = $pp->toArray();
                    unset($ppArray['id']);
                    $ppArray['pa_histories_id'] = $paHistory->id;
                    $ppArray['title_histories_id'] = $tHistory->id;

                    $ppHistory = PaPurposeHistory::create($ppArray);

                    // 🔹 Get related PerformanceDetails
                    $details = PaDetail::where("performance_id", $data->id)
                        ->where("title_id", $titleItem->id)
                        ->where("purpose_id", $pp->id)
                        ->get();

                    foreach ($details as $pd) {
                        $pdArray = $pd->toArray();
                        unset($pdArray['id']);
                        $pdArray['pa_histories_id'] = $paHistory->id;
                        $pdArray['title_histories_id'] = $tHistory->id;
                        $pdArray['purpose_histories_id'] = $ppHistory->id;

                        $detailHistory = PaDetailHistory::create($pdArray);

                        $paGoals = PaDetailGoal::where("performance_id", $data->id)
                        ->where("title_id", $titleItem->id)
                        ->where("purpose_id", $pp->id)
                        ->where("pa_detail_id", $pd->id)
                        ->get();
                        foreach ($paGoals as $goal) {
                            $pgArray = $goal->toArray();
                            unset($pgArray['id']);
                            $pgArray['pa_histories_id'] = $paHistory->id;
                            $pgArray['title_histories_id'] = $tHistory->id;
                            $pgArray['purpose_histories_id'] = $ppHistory->id;
                            $pgArray['pa_detail_histories_id'] = $detailHistory->id;
                            PaDetailGoalHistory::create($pgArray);
                        }
                    }
                }
            }
        });
    }

    public function updateKpiScore(Request $request){
        try {

            $paPerformance = PerformanceAppraisal::where('employee_id',$request->employee_id)->where('id',$request->id)->first();
            self::createHistories($paPerformance);
             $paPerformance->update([
                'total_score_direct_chairman'  => $request->total_score_direct_chairman,
                'remark'  => $request->remark,
                'updated_by'            => Auth::id(),
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

    public function deleteReference($id)
    {
        try {
            $reference = PaReference::findOrFail($id);

            // ១. លុប File ចេញពី Drive D (ប្រើ disk d_drive)
            if (Storage::disk('d_drive')->exists($reference->reference)) {
                Storage::disk('d_drive')->delete($reference->reference);
            }

            // ២. លុប Record ចេញពី Database
            $reference->delete();

            return response()->json(['message' => 'Deleted successfully.', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function performanceAppraisalExport($id){
        return Excel::download(new ExportKpis($id), 'PA.xlsx');
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
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance-appraisal")->first();
        $query = $this->reportRepo->getPAReport($request, $permission);
        $data = $query->with(['users', 'performanceDetail'])->orderBy('performance_appraisals.id', 'desc')->get();
        return Excel::download(new DownloadKpis($data), 'PA.xlsx');
    }

    public function paResult(Request $request) {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (!in_array($extension, ["xlsx", "xls", "csv"])) {
            return back()->withErrors(["file" => "Invalid file format"]);
        }

        $spreadsheet = IOFactory::load($file);
        $sheetNames = $spreadsheet->getSheetNames();

        $notFoundIds = [];
        $errors = [];

        foreach ($sheetNames as $id) {
            $employee = User::where("number_employee", $id)->first();
            if (!$employee) {
                $notFoundIds[] = $id;
                continue;
            }

            $sheet = $spreadsheet->getSheetByName($id);
            $highestRow = $sheet->getHighestRow();

            $currentForYear = null;
            $currentPurpose = null;
            $currentPA = null;

            for ($row = 2; $row <= $highestRow; $row++) {
                $index = $row - 2;
                $forYearValue   = trim($sheet->getCell('A' . $row)->getValue());
                $purposeValue   = trim($sheet->getCell('B' . $row)->getValue());
                $paValue        = trim($sheet->getCell('C' . $row)->getValue());
                $paResult       = trim($sheet->getCell('I' . $row)->getValue());

                if (!empty($forYearValue))  $currentForYear = $forYearValue;
                if (!empty($purposeValue))  $currentPurpose = $purposeValue;
                if (!empty($paValue))      $currentPA     = $paValue;

                // បើជួរនោះទទេទាំងស្រុង មិនបាច់ឆែកទេ
                if (empty($currentForYear) && empty($currentPurpose) && empty($currentPA)) continue;

                // ១. ស្វែងរក PerformanceAppraisal
                $performance = PerformanceAppraisal::where("employee_id", $employee->id)
                                ->where('type', $currentForYear)->first();
                if (!$performance) {
                    $errors[] = "Sheet $id: For Year ($currentForYear) រកមិនឃើញក្នុងប្រព័ន្ធ";
                    continue;
                }

                // ២. ស្វែងរក Purpose
                $purpose = PaPurpose::where("performance_id", $performance->id)
                            ->where('name', $currentPurpose)->first();
                if (!$purpose) {
                    $errors[] = "Sheet $id: Purpose ($currentPurpose) រកមិនឃើញក្នុងប្រព័ន្ធ";
                    continue;
                }

                // ៣. ស្វែងរក PerformanceDetail
                $detail = PaDetail::where("performance_id", $performance->id)
                            ->where("purpose_id", $purpose->id)
                            ->where('key_kpi', $currentPA)->first();
                if (!$detail) {
                    $errors[] = "Sheet $id: KPI Key ($currentPA) រកមិនឃើញក្នុងប្រព័ន្ធ";
                    continue;
                }
                if($detail){
                    $detail->progress = $paResult;
                    $fromValue     = $sheet->getCell('D' . $row)->getValue();
                    $toValue       = $sheet->getCell('E' . $row)->getValue();

                    // if ($paResult <= $fromValue && $paResult >= $toValue) {
                    //     $scoreAchieved = $index + 1; // mimic JS: index + 1
                    //     // break; // stop looping once found
                    // }else{
                    //     $scoreAchieved = 5;
                    // }
                    $scoreAchieved = 1;

                    $totalScore = ($detail->weight * $scoreAchieved) / 100;
                    $score  = $totalScore;
                    $live   = $totalScore;
                    $chair  = $totalScore;

                    $detail->score_achieved         = $scoreAchieved;
                    $detail->score                  = $score;
                    $detail->score_live_staff       = $live;
                    $detail->score_direct_chairman  = $chair;


                    dd($detail);
                }
            }
        }

        // ចម្រាញ់យកតែ Error ដែលប្លែកៗគ្នា (Unique)
        $uniqueErrors = array_unique($errors);
        $uniqueStaffErrors = array_unique($notFoundIds);
        if (count($errors) > 0 || count($notFoundIds) > 0) {
            return response()->json([
                'status'  => 422,
                'message' => 'ការ Upload មានបញ្ហាមួយចំនួន៖',
                'invalid_staff' => array_values($uniqueStaffErrors),
                'row_errors'    => array_values($uniqueErrors)
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'បញ្ចូលទិន្នន័យជោគជ័យ']);
    }
}
