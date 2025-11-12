<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Title;
use App\Exports\ExporPerformanceDetail;
use App\Models\Branchs;
use App\Models\PaTitle;
use App\Models\Purpose;
use App\Models\PaDetail;
use App\Models\PaPurpose;
use App\Models\Department;
use App\Models\Performance;
use App\Models\permissions;
use App\Models\TitleHistory;
use Illuminate\Http\Request;
use App\Models\PurposeHistory;
use App\Models\PerformanceDetail;
use App\Exports\ExportPerformance;
use App\Models\PerformanceHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\PerformanceAppraisal;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PerformanceDetailHistory;
use App\Repositories\Admin\ReportRepository;
use Illuminate\Support\Facades\Mail;

class PerformanceAdminController extends Controller
{
    private $reportRepo;
    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }
    public function permission(){
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance-admin")->first();
        return $permission;
    }
    public function index(Request $request)
    {
        $permission = self::permission();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        if (request()->ajax()) {
            // Define the base query
            $query = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('users as reviewEmployee', 'performances.review_employee_id', '=', 'reviewEmployee.id')
            ->select(
                'performances.*',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.department_id',
                'users.branch_id',
                'users.line_manager',
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
                    $q->where('performances.id', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
                });
            }

            if (in_array(Auth::user()->RolePermission, ['HR']) && $permission->is_access != "1") {
                $query->where("performances.review_employee_id", Auth::user()->id);
                $query->whereNot('performances.status', 'preparing');
                $query->whereNot('performances.status', 'approved');
            }

            if (in_array(Auth::user()->RolePermission, ['BOD','CEO','HOD','DHOD','BM','DBM','Employee'])) {
                $query->where('performances.review_employee_id', Auth::user()->id);
                $query->whereNot('performances.status', 'preparing');
                $query->whereNot('performances.status', 'approved');
            }
            $recordsTotal = Performance::where('status', 'approved')->count();  // total records without filter
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $data = $query->orderBy('performances.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'permission'=>$permission,
                'userIdLog'=>Auth::user()->id,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        $department = Department::all();
        return view('performance_admins.index',compact('branch','department'));
        if (in_array(Auth::user()->RolePermission, ['Employee'])) {
            $query->where('performances.employee_id', Auth::user()->id);
        }
        // ->groupBy('performances.employee_id')
        // Fetch paginated data
        $data = $query->get();
        // dd($data);
        return view('performance_admins.index',compact('data'));
    }
    public function show($id,$url)
    {
        $permission = self::permission();
        $data = Performance::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performances.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->leftJoin('users as reviewEmployee', 'performances.review_employee_id', '=', 'reviewEmployee.id')
        ->select(
            'performances.*',
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
        )->where('performances.id',$id)->first();

        if($url == "kpi-report"){
            $url = 'performance-admin/kpi-report';
        }
        return view('performance_admins.preview',compact('data','permission','url'));
    }
    public function dataHistory(){
        $query = PerformanceHistory::with(['titles.purposes.performanceDetail'])
            ->leftJoin('users', 'performance_histories.employee_id', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('users as reviewEmployee', 'performance_histories.review_employee_id', '=', 'reviewEmployee.id')
            ->select(
                'performance_histories.*',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.department_id',
                'users.branch_id',
                'users.line_manager',
                'departments.name_english as dep_name',
                'positions.name_english as positions_name',
                'branchs.branch_name_en',
                'branchs.branch_name_kh',
                'reviewEmployee.number_employee as review_employee_number_employee',
                'reviewEmployee.employee_name_kh as review_employee_name_kh',
                'reviewEmployee.employee_name_en as review_employee_name_en',
            );
        return $query;
    }
    public function histories($id, $url)
    {
        if($url == 'kpi-report'){
            $url='performance-admin/kpi-report';
        }
        $query = self::dataHistory();
        $datas = $query->where("performance_histories.performance_id", $id)->get();
        return view('performance_admins.view_histories', compact('datas','url'));
    }
    public function historiesDetail($id, $url, $urlpage)
    {
        $permission = false;
        $query = self::dataHistory();
        $data = $query->where("performance_histories.id", $id)->first();
        return view('performance_admins.preview', compact('data','permission', 'url','urlpage'));
    }
   
    public function employees(Request $request)
    {
        $kpiUser = User::where("id", $request->get_employee_id)->select(
            'users.id',
            'users.number_employee',
            'users.department_id',
            'users.branch_id',
        )->first();

        $query = User::with(["branch","department"])
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'users.id',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'users.department_id',
            'users.branch_id',
            'users.emp_status',
            'branchs.abbreviations',
        );
        if (in_array(Auth::user()->RolePermission, ['Employee','DHOD','DBM'])) {
            $query->where("users.department_id", $kpiUser->department_id)->where("users.branch_id", $kpiUser->branch_id);
        }
        if (in_array(Auth::user()->RolePermission, ['HR']) && self::permission()->is_access != "1") {
            $query->where("users.department_id", $kpiUser->department_id)->where("users.branch_id", $kpiUser->branch_id);
        }
        if (in_array(Auth::user()->RolePermission, ['HOD'])) {
            $query->where('branchs.abbreviations', "HQ");
        }
        if (in_array(Auth::user()->RolePermission, ['BM'])) {
            $query->where("users.branch_id", $kpiUser->branch_id);
            $query->whereIn('users.emp_status', ['1','2','10','Probation']);
            $query->orWhere('branchs.abbreviations', "HQ");
        }
        
        $datas = $query->whereIn('users.emp_status', ['1','2','10','Probation'])->get();
        return response()->json([
            'datas' => $datas
        ]);
    }
    function createHistories($data)
    {
        DB::transaction(function () use ($data) {

            // 🔹 Convert Performance to array
            $dataHistory = $data->toArray();
            unset($dataHistory['id']);
            $dataHistory['performance_id'] = $data->id;

            // 🔹 Create PerformanceHistory
            $paHistory = PerformanceHistory::create($dataHistory);

            // 🔹 Get related Titles
            $titles = Title::where("performance_id", $data->id)->get();

            foreach ($titles as $titleItem) {
                $titleArray = $titleItem->toArray();
                unset($titleArray['id']);
                $titleArray['performance_histories_id'] = $paHistory->id;

                $tHistory = TitleHistory::create($titleArray);

                // 🔹 Get related Purposes for this title
                $purposes = Purpose::where("performance_id", $data->id)
                    ->where("title_id", $titleItem->id)
                    ->get();

                foreach ($purposes as $pp) {
                    $ppArray = $pp->toArray();
                    unset($ppArray['id']);
                    $ppArray['performance_histories_id'] = $paHistory->id;
                    $ppArray['title_histories_id'] = $tHistory->id;

                    $ppHistory = PurposeHistory::create($ppArray);

                    // 🔹 Get related PerformanceDetails
                    $details = PerformanceDetail::where("performance_id", $data->id)
                        ->where("title_id", $titleItem->id)
                        ->where("purpose_id", $pp->id)
                        ->get();

                    foreach ($details as $pd) {
                        $pdArray = $pd->toArray();
                        unset($pdArray['id']);
                        $pdArray['performance_histories_id'] = $paHistory->id;
                        $pdArray['title_histories_id'] = $tHistory->id;
                        $pdArray['purpose_histories_id'] = $ppHistory->id;

                        PerformanceDetailHistory::create($pdArray);
                    }
                }
            }
        });
    }

    public function sendEmail($asign_employee_id){
        $user = User::where("id", $asign_employee_id)->first();
        $datasSendEmail = [
            'user'      => $user,
            'type'      => "kpi",
        ];
        // Mail::to($user->email)->queue(new SendEmail($datasSendEmail, false));
    }
    public function asign(Request $request)
    {
        DB::beginTransaction();
        try{
            $performance = Performance::findOrFail($request->id);
            if ($performance->total_weight == 100) {
                self::createHistories($performance);
                $performance->update([
                    'status'                => $request->actionAsign,
                    'reason'                => $request->reason,
                    'review_employee_id'    => $request->asign_employee_id,
                    'review_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_by'            => Auth::id(),
                ]);
            } else {
                return response()->json([
                    'message' => 'weight_must_be_exactly'
                ]);
            }
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
    public function asigns(Request $request)
    {
        try{
            DB::beginTransaction(); // ✅ Start transaction
            $ids = explode(',', $request->performance_id);
            $approved = [];
            $skipped = [];
            foreach ($ids as $id) {
                $performance = Performance::findOrFail($id);
                if ($performance->total_weight == 100) {
                    self::createHistories($performance);
                    $performance->update([
                        'status'                => $request->actionAsign,
                        'reason'                => $request->reason,
                        'review_employee_id'    => $request->asign_employee_id,
                        'review_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_by'            => Auth::id(),
                    ]);
                    $approved[] = $id;
                } else {
                    $skipped[] = $id;
                    return response()->json([
                        'message' => 'weight_must_be_exactly'
                    ]);
                }
            }
            // ✅ Start service email
            self::sendEmail($request->asign_employee_id);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Asign successfully!',
                'status'  => 200
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function return(Request $request)
    {
        DB::beginTransaction();
        try{
            $performance = Performance::findOrFail($request->id);
            self::createHistories($performance);
            $performance->update([
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
    public function returns(Request $request)
    {
        try{
           DB::beginTransaction();
            $ids = explode(',', $request->performance_id);
            $approved = [];
            $skipped = [];
            foreach ($ids as $id) {
                $performance = Performance::findOrFail($id);
                if ($performance->total_weight == 100) {
                    self::createHistories($performance);
                    $performance->update([
                        'status'                => $request->actionAsign,
                        'review_employee_id'    => $request->asign_employee_id,
                        'reason'                => $request->reason,
                        'reject_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_by'            => Auth::id(),
                    ]);
                    $approved[] = $id;
                } else {
                    $skipped[] = $id;
                    return response()->json([
                        'message' => 'weight_must_be_exactly'
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Return successfully!',
                'status'  => 200
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function approved(Request $request)
    {
        DB::beginTransaction();
        try{
            $performance = Performance::with('titles')->findOrFail($request->id);
            // Copy selected fields
            self::createHistories($performance);
            $data = $performance->only([
                'employee_id',
                'from_date',
                'to_date',
                'total_weight',
                'total_score',
                'total_score_live_staff',
                'total_score_direct_chairman',
                'status',
                'type',
                'approved_by',
                'approved_date',
                'remark',
                'review_employee_id',
                'location_review',
                'position_review',
                'review_date',
                'approve_by',
                'approve_date',
                'reject_date',
                'reason',
                'created_by',
                'updated_by',
            ]);
            // Create new PerformanceAppraisal record
            $data['created_by'] = Auth::id();
            $data['status'] = 'new';
            $pa = PerformanceAppraisal::create($data);
            // ✅ Loop over related titles from the Performance model (not $data)
            foreach ($performance->titles as $titleItem) {
                $paTitle = PaTitle::create([
                    'performance_id' => $pa->id, // link to new appraisal
                    'title'          => $titleItem->title,
                    'created_by'     => $titleItem->created_by,
                ]);
                foreach ($titleItem->purposes as $purposeItem) {
                    $paPurpose = PaPurpose::create([
                        'performance_id' => $pa->id,
                        'title_id'       => $paTitle->id,
                        'name'           => $purposeItem->name,
                        'created_by'     => $purposeItem->created_by,
                    ]);

                    foreach ($purposeItem->performanceDetail as $kpi) {
                        PaDetail::create([
                            'performance_id' => $pa->id,
                            'title_id'       => $paTitle->id,
                            'purpose_id'     => $paPurpose->id,
                            'key_kpi'        => $kpi->key_kpi,
                            'action_plan'    => $kpi->action_plan,
                            'goal'           => $kpi->goal,
                            'weight'         => $kpi->weight,
                            'goal_type'      => $kpi->goal_type,
                            'is_lock'        => $kpi->is_lock,
                            'created_by'     => $kpi->created_by,
                        ]);
                    }
                }
            }
            
            if ($performance->total_weight == 100) {
                $performance->update([
                    'reason'        => $request->reason,
                    'approved_by'   => Auth::id(),
                    'status'        => $request->actionAsign,
                    'approved_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_by'    => Auth::id(),
                ]);
            } else {
                return response()->json([
                    'message' => 'weight_must_be_exactly'
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Approve successfully successfully!',
                'status'  => 200
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function approveds(Request $request)
    {
        try {
            DB::beginTransaction(); // ✅ Start transaction
            $ids = explode(',', $request->performance_id);
            $approved = [];
            $skipped = [];
            foreach ($ids as $id) {
                $performance = Performance::findOrFail($id);
                $data = $performance->only([
                    'employee_id',
                    'from_date',
                    'to_date',
                    'total_weight',
                    'total_score',
                    'total_score_live_staff',
                    'total_score_direct_chairman',
                    'status',
                    'type',
                    'approved_by',
                    'approved_date',
                    'remark',
                    'review_employee_id',
                    'location_review',
                    'position_review',
                    'review_date',
                    'approve_by',
                    'approve_date',
                    'reject_date',
                    'reason',
                    'created_by',
                    'updated_by',
                ]);
                $data['created_by'] = Auth::id();
                $data['status'] = 'new';
                $pa = PerformanceAppraisal::create($data);

                // ✅ Loop over related titles from the Performance model (not $data)
                foreach ($performance->titles as $titleItem) {
                    $paTitle = PaTitle::create([
                        'performance_id' => $pa->id, // link to new appraisal
                        'title'          => $titleItem->title,
                        'created_by'     => $titleItem->created_by,
                    ]);
                    foreach ($titleItem->purposes as $purposeItem) {
                        $paPurpose = PaPurpose::create([
                            'performance_id' => $pa->id,
                            'title_id'       => $paTitle->id,
                            'name'           => $purposeItem->name,
                            'created_by'     => $purposeItem->created_by,
                        ]);

                        foreach ($purposeItem->performanceDetail as $kpi) {
                            PaDetail::create([
                                'performance_id' => $pa->id,
                                'title_id'       => $paTitle->id,
                                'purpose_id'     => $paPurpose->id,
                                'key_kpi'        => $kpi->key_kpi,
                                'action_plan'    => $kpi->action_plan,
                                'goal'           => $kpi->goal,
                                'weight'         => $kpi->weight,
                                'goal_type'      => $kpi->goal_type,
                                'is_lock'        => $kpi->is_lock,
                                'created_by'     => $kpi->created_by,
                            ]);
                        }
                    }
                }
                
                if ($performance->total_weight == 100) {
                    self::createHistories($performance);
                    $performance->update([
                        'status'        => 'approved',
                        'reason'        => $request->reason,
                        'status'        => $request->actionAsign,
                        'approved_by'   => Auth::id(),
                        'approved_date' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_by'    => Auth::id(),
                    ]);
                    $approved[] = $id;
                } else {
                    $skipped[] = $id;
                    return response()->json([
                        'message' => 'weight_must_be_exactly'
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Approve successfully!',
                'status'  => 200
            ]);
        } catch (\Throwable $exp) {
            DB::rollBack();
            return response()->json([
                'error'     => 'Approve failed.',
                'exception' => $exp->getMessage()
            ], 500);
        }
    }
    public function kpiReport(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance-admin/kpi-report")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        if (request()->ajax()) {
            $query = $this->reportRepo->getKpiReport($request, $permission);
            $recordsTotal = Performance::where('status', 'approved')->count();  // total records without filter
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $data = $query->where('performances.status', 'approved')->orderBy('performances.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'permission'=>$permission,
                'userIdLog'=>Auth::user()->id,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        $department = Department::all();
        return view('reports.kpi_report',compact('branch','department','permission'));
        if (in_array(Auth::user()->RolePermission, ['Employee'])) {
            $query->where('performances.employee_id', Auth::user()->id);
        }
        // ->groupBy('performances.employee_id')
        // Fetch paginated data
        $data = $query->get();
        // dd($data);
        return view('reports.kpi_report',compact('data'));
    }
    public function reportExport(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance-admin/kpi-report")->first();
        $query = $this->reportRepo->getKpiReport($request, $permission);
        $data = $query->where('performances.status', 'approved')->orderBy('performances.id', 'desc')->get();
        $name_file = "Performance-Report.xlsx";
        $export = new ExportPerformance($data, $request);
        return Excel::download($export, $name_file);
    }
    public function kpiReportExportDetail(Request $request){
        $id = $request->id;
        $data = Performance::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performances.employee_id', '=', 'users.id')
        ->leftJoin('users as line_manager', 'users.line_manager', '=', 'line_manager.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performances.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'line_manager.employee_name_kh as line_manager_name_kh',
            'line_manager.employee_name_en as line_manager_name_en',
            'users.date_of_commencement',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'positions.name_khmer as positions_name_kh',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performances.id',$id)->first();
        return Excel::download(new ExporPerformanceDetail($data), 'performance_appraisal_'.$id.'.xlsx');
        
    }
}
