<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\PAFlow;
use App\Models\Performance;
use App\Models\PerformanceDetail;
use App\Models\PerformanceDetailHistory;
use App\Models\PerformanceGoal;
use App\Models\PerformanceHistory;
use App\Models\permissions;
use App\Models\Purpose;
use App\Models\PurposeHistory;
use App\Models\Title;
use App\Models\TitleHistory;
use App\Models\PerformanceGoalHistory;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use App\Repositories\Admin\EmployeeRepository;

class PerformanceController extends Controller
{
    private $employeeRepo;
    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepo = $employeeRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permission(){
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "performance")->first();
        return $permission;
    }
    public function index(Request $request)
    {
        $department_ids = $this->employeeRepo->getRoleHOD();
        $permission = self::permission();
        if (!$permission || $permission["is_view"] != 1) {
            return view('upgrade.access_page');
        }
        if (request()->ajax()) {
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
            ->whereNot('performances.status', 'approved')
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
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('performances.id', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
                });
            }
            if (in_array(Auth::user()->RolePermission, ['BOD','CEO'])){
                $query->where(function ($q) {
                    $q->where("users.line_manager", Auth::user()->id)
                    ->orWhere("performances.employee_id", Auth::user()->id);
                });
            }
            if (in_array(Auth::user()->RolePermission, ['HR']) && $permission["is_access"] != 1){
                $query->where(function ($q) {
                    $q->where("users.line_manager", Auth::user()->id)
                    ->orWhere('performances.employee_id', Auth::user()->id);
                });
            }
            if (in_array(Auth::user()->RolePermission, ['HOD'])) {
                $query->whereIn("users.department_id", $department_ids);
                if(Auth::user()->department->abbreviations == "CRD"){
                    $branch = Branchs::whereNot("id", Auth::user()->branch_id)->get();
                }
            }
            if (in_array(Auth::user()->RolePermission, ['BM'])){
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
            if (in_array(Auth::user()->RolePermission, ['DHOD','DBM'])){
                $query->where(function ($q) {
                    $q->where("users.line_manager", Auth::user()->id)
                    ->orWhere('performances.employee_id', Auth::user()->id);
                });
            }
            if (in_array(Auth::user()->RolePermission, ['Employee'])) {
                $query->where('performances.employee_id', Auth::user()->id);
            }
            $countPendingReview   = (clone $query)->where('performances.status', '1')->count();
            $countPendingAccepted = (clone $query)->where('performances.status', '2')->count();
            $countPendingVerify   = (clone $query)->where('performances.status', '3')->count();
            $countPendingApprove  = (clone $query)->where('performances.status', '4')->count();
            $countPendingReturn  = (clone $query)->where('performances.status', '5')->count();
            $query->when($request->status, function ($query, $status) {
                return $query->where('performances.status', $status);
            });
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
                $query->orderBy('performances.id', 'desc');
            }
            $data = $query->orderBy('performances.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsFiltered,
                'recordsFiltered' => $recordsFiltered,
                'userIdLog'=>Auth::user()->id,
                'permission'=>$permission,
                'data' => $data,
                'pendingReview'   => $countPendingReview,
                'pendingAccepted' => $countPendingAccepted,
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
        $employee = User::where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        return view('performances.index',compact('permission','branch','department','employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $employee= DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->select( 'users.*', 'roles.role_type',)
        ->whereIn('users.emp_status', ['Probation','1','2','10',])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'Employee'){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
            if (in_array($RolePermission, ['BM'])){
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['HR','HRAdmin','DHOD','HOD'])){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->orWhere("users.line_manager", Auth::user()->id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['DHOD','DBM'])){
                $query->where("users.line_manager", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BOD','CEO'])){
                $query->whereNot("users.id", Auth::user()->id);
                $query->whereNot("roles.role_type", "Employee");
            }
            })->get();
        return view('performances.create',compact('employee'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $totalWeight = 0;
            $data = $request->all();
            foreach ($request->data as $titleItem) {
                foreach ($titleItem['dataPurpose'] as $purposeItem) {
                    foreach ($purposeItem['dataKPi'] as $kpi) {
                        $totalWeight += (int) $kpi['weight'];
                    }
                }
            }
            if ($totalWeight <= 100) {
                foreach ($request->employee_id as $empId) {
                    $user = User::with("branch")->where('id', $empId)->select('id','department_id','branch_id','line_manager', 'number_employee', 'employee_name_kh', 'employee_name_en', 'emp_status')->first();
                    $type = $user->emp_status === 'Probation' ? 'KPI Probation ' . Carbon::parse($request->from_date)->format('Y') : 'KPI Form ' . Carbon::parse($request->from_date)->format('Y');
                    $data = $request->all();
                    $data['created_by'] = Auth::id();
                    $data['employee_id'] = $empId;
                    $data['total_weight'] = $totalWeight;
                    $data['status'] = 'preparing';
                    $data['type'] = $type;
                    $performance = Performance::create($data);
                    foreach ($request->data as $titleItem) {
                        $title = Title::create([
                            'performance_id' => $performance->id,
                            'title'          => $titleItem['title'],
                            'created_by'     => Auth::id(),
                        ]);
                        foreach ($titleItem['dataPurpose'] as $purposeItem) {
                            $purpose = Purpose::create([
                                'performance_id' => $performance->id,
                                'title_id'       => $title->id,
                                'name'           => $purposeItem['purpose'],
                                'created_by'     => Auth::id(),
                            ]);
                            foreach ($purposeItem['dataKPi'] as $kpiIndex => $kpi) {
                                $isValidGoal = true;
                                $goalType    = $kpi['goal_type'];
                                foreach ($kpi['goal'] as $g) {
                                    if (!isset($g['from'], $g['to'])) {
                                        $isValidGoal = false;
                                        break;
                                    }
                                    $min = $g['from'];
                                    $max = $g['to'];
                                    if (str_contains($goalType, 'number') ||
                                        str_contains($goalType, 'percent') ||
                                        str_contains($goalType, 'currency')) {
                                        if (!is_numeric($min) || !is_numeric($max)) {
                                            $isValidGoal = false;
                                            break;
                                        }
                                        $min = (float)$min;
                                        $max = (float)$max;
                                        if (str_contains($goalType, 'percent') && ($min < 0 || $max > 100)) {
                                            $isValidGoal = false;
                                            break;
                                        }
                                    } elseif (str_contains($goalType, 'date')) {
                                        try {
                                            $min = Carbon::parse($min);
                                            $max = Carbon::parse($max);
                                        } catch (\Exception $e) {
                                            $isValidGoal = false;
                                            break;
                                        }
                                    } else {
                                        $isValidGoal = false;
                                        break;
                                    }
                                    if ($min < $max)       $current = 'inc';
                                    elseif ($min > $max)   $current = 'dec';
                                    else                   $current = 'equal';
                                    $expected = str_contains($goalType, 'increment') ? 'inc' : 'dec';
                                    if ($current !== 'equal' && $current !== $expected) {
                                        $isValidGoal = false;
                                        break;
                                    }
                                }
                                if (!$isValidGoal) {
                                    DB::rollBack();
                                    return response()->json([
                                        'message'     => 'not_goal',
                                        'goal_type'   => $goalType,
                                        'kpi_index'   => $kpiIndex,
                                        'error'       => 'Invalid goal format for type '.$goalType
                                    ]);
                                }
                                $performanceDetail = PerformanceDetail::create([
                                    'performance_id' => $performance->id,
                                    'title_id'       => $title->id,
                                    'purpose_id'     => $purpose->id,
                                    'key_kpi'        => $kpi['key_kpi'],
                                    'action_plan'    => $kpi['action_plan'],
                                    'weight'         => $kpi['weight'],
                                    'goal_type'      => $goalType,
                                    'is_lock'        => $kpi['is_lock'],
                                    'created_by'     => Auth::id(),
                                ]);
                                foreach ($kpi['goal'] as $g) {
                                    $from = $g['from'];
                                    $to   = $g['to'];
                                    if ($from > $to) {
                                        [$from, $to] = [$to, $from];
                                    }
                                    PerformanceGoal::create([
                                        'performance_id'         => $performance->id,
                                        'title_id'               => $title->id,
                                        'purpose_id'             => $purpose->id,
                                        'performance_detail_id'  => $performanceDetail->id,
                                        'from'                   => $from,
                                        'to'                     => $to,
                                        'user_id'                => Auth::id(),
                                        'created_by'             => Auth::id(),
                                    ]);
                                }
                            }
                        }
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'The total weight of all KPIs must equal 100%.',
                    'status' => 422
                ]);
            }
        } catch (\Throwable $exp) {
            DB::rollback();
            Log::error('Performance creation failed: ' . $exp->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Performance created fail.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $data = Performance::with(['titles.purposes.performanceDetail'])
        ->leftJoin('users', 'performances.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performances.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performances.id',$id)->first();
        $employee = User::where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        return view('performances.preview',compact('data','employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $data = Performance::with(['titles.purposes.performanceDetail.performanceGoals'])
        ->leftJoin('users', 'performances.employee_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
        ->select(
            'performances.*',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'departments.name_english as dep_name',
            'positions.name_english as positions_name',
            'branchs.branch_name_en',
            'branchs.branch_name_kh',
        )->where('performances.id',$id)->first();
        $employee = User::where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        return view('performances.edit',compact('employee','data'));
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
                        $detailHistory = PerformanceDetailHistory::create($pdArray);

                        $pGoals = PerformanceGoal::where("performance_id", $data->id)
                        ->where("title_id", $titleItem->id)
                        ->where("purpose_id", $pp->id)
                        ->where("performance_detail_id", $pd->id)
                        ->get();
                        foreach ($pGoals as $goal) {
                            $pgArray = $goal->toArray();
                            unset($pgArray['id']);
                            $pgArray['performance_histories_id'] = $paHistory->id;
                            $pgArray['title_histories_id'] = $tHistory->id;
                            $pgArray['purpose_histories_id'] = $ppHistory->id;
                            $pgArray['performance_detail_histories_id'] = $detailHistory->id;
                            PerformanceGoalHistory::create($pgArray);
                        }
                    }
                }
            }
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $totalWeight = 0;
            foreach ($request->data as $title) {
                if (!empty($title['dataPurpose'])) {
                    foreach ($title['dataPurpose'] as $purpose) {
                        if (!empty($purpose['dataKPi'])) {
                            foreach ($purpose['dataKPi'] as $kpi) {
                                $totalWeight += (int) $kpi['weight'];
                            }
                        }
                    }
                }
            }

            if ($totalWeight <= 100) {
                $performance = Performance::findOrFail($request->performance_id);
                self::createHistories($performance);
                $employee = User::findOrFail($request->employee_id);
                $year = Carbon::parse($request->from_date)->format('Y');
                $type = $employee->emp_status === 'Probation' ? "KPI Probation $year" : "KPI Form $year";
                $performance->update([
                    'status'       => $performance->status != 'preparing'? $performance->status : "preparing",
                    'reason'       => '',
                    'employee_id'  => $request->employee_id,
                    'from_date'    => $request->from_date,
                    'to_date'      => $request->to_date,
                    'type'         => $type,
                    'total_weight' => $totalWeight,
                    'updated_by'   => Auth::id(),
                ]);

                PerformanceGoal::where('performance_id', $performance->id)->delete();
                PerformanceDetail::where('performance_id', $performance->id)->delete();
                Purpose::where('performance_id', $performance->id)->delete();
                Title::where('performance_id', $performance->id)->delete();

                foreach ($request->data as $titleItem) {
                    $title = Title::create([
                        'performance_id' => $performance->id,
                        'title'          => $titleItem['title'],
                        'created_by'     => Auth::id(),
                    ]);
                    if (!empty($titleItem['dataPurpose'])) {
                        foreach ($titleItem['dataPurpose'] as $purposeItem) {
                            $purpose = Purpose::create([
                                'performance_id' => $performance->id,
                                'title_id'       => $title->id,
                                'name'           => $purposeItem['purpose'],
                                'created_by'     => Auth::id(),
                            ]);

                            if (!empty($purposeItem['dataKPi'])) {
                                foreach ($purposeItem['dataKPi'] as $kpiIndex=>$kpi) {
                                    $isValidGoal = true;
                                    $goalType = $kpi['goal_type'];
                                    foreach ($kpi['goal'] as $g) {
                                        if (!isset($g['from'], $g['to'])) {
                                            $isValidGoal = false;
                                            break;
                                        }
                                        $min = $g['from'];
                                        $max = $g['to'];
                                        if (str_contains($goalType, 'number') ||
                                            str_contains($goalType, 'percent') ||
                                            str_contains($goalType, 'currency')) {
                                            if (!is_numeric($min) || !is_numeric($max)) {
                                                $isValidGoal = false;
                                                break;
                                            }
                                            $min = (float)$min;
                                            $max = (float)$max;
                                            if (str_contains($goalType, 'percent') && ($min < 0 || $max > 100)) {
                                                $isValidGoal = false;
                                                break;
                                            }
                                        } elseif (str_contains($goalType, 'date')) {
                                            try {
                                                $min = Carbon::parse($min);
                                                $max = Carbon::parse($max);
                                            } catch (\Exception $e) {
                                                $isValidGoal = false;
                                                break;
                                            }
                                        } else {
                                            $isValidGoal = false;
                                            break;
                                        }
                                        $current = $min < $max ? 'inc' : ($min > $max ? 'dec' : 'equal');
                                        $expected = str_contains($goalType, 'increment') ? 'inc' : 'dec';
                                        if ($current !== 'equal' && $current !== $expected) {
                                            $isValidGoal = false;
                                            break;
                                        }
                                    }
                                    if (!$isValidGoal) {
                                        DB::rollBack();
                                        return response()->json([
                                            'message'     => 'not_goal',
                                            'goal_type'   => $goalType,
                                            'kpi_index'   => $kpiIndex,
                                            'error'       => 'Invalid goal format for type '.$goalType
                                        ]);
                                    }
                                    $detail = PerformanceDetail::create([
                                        'performance_id' => $performance->id,
                                        'title_id'       => $title->id,
                                        'purpose_id'     => $purpose->id,
                                        'key_kpi'        => $kpi['key_kpi'],
                                        'action_plan'    => $kpi['action_plan'],
                                        'weight'         => $kpi['weight'],
                                        'goal_type'      => $goalType,
                                        'is_lock'        => $kpi['is_lock'],
                                        'updated_by'     => Auth::id(),
                                    ]);

                                    foreach ($kpi['goal'] as $g) {
                                        $from = $g['from'];
                                        $to   = $g['to'];
                                        $isIncrement = str_contains($goalType, 'increment');
                                        if ($isIncrement && $from > $to) {
                                            [$from, $to] = [$to, $from];
                                        }
                                        PerformanceGoal::create([
                                            'performance_id'        => $performance->id,
                                            'title_id'              => $title->id,
                                            'purpose_id'            => $purpose->id,
                                            'performance_detail_id' => $detail->id,
                                            'from'                  => $from,
                                            'to'                    => $to,
                                            'user_id'               => Auth::id(),
                                            'updated_by'            => Auth::id(),
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
                DB::commit();
                return response()->json(['message' => 'successfully']);
            } else {
                return response()->json([
                    'error' => 'The total weight of all KPIs must equal 100%'
                ]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'error'     => 'Performance update failed.',
                'exception' => $e->getMessage()
            ], 500);
        }
    }
    public function performanceAssign(Request $request)
    {
        try {
            DB::beginTransaction(); // ✅ Start transaction
            $performance = Performance::findOrFail($request->id);
            if ($performance->total_weight == 100) {
                $performance->update([
                    'status'                => $request->status,
                    'reason'                => $request->reason,
                    'review_employee_id'    => $request->employee_id,
                    'review_date'           => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_by'            => Auth::id(),
                ]);
            } else {
                return response()->json([
                    'message' => 'weight_must_be_exactly'
                ]);
            }

            DB::commit(); // ✅ Commit after successful update
            return response()->json([
                'success' => true,
                'message' => 'Updated performance status successfully!',
                'status'  => 200
            ]);
        } catch (\Throwable $exp) {
            DB::rollBack(); // ✅ Roll back only if transaction started
            return response()->json([
                'error'     => 'Updated performance status failed.',
                'exception' => $exp->getMessage()
            ], 500);
        }
    }

    public function performanceAccepted(Request $request)
    {
        try {
            DB::beginTransaction(); // ✅ Start transaction
            $performance = Performance::findOrFail($request->id);
            if ($performance->total_weight == 100) {
                $performance->update([
                    'review_employee_id'    => Auth::user()->line_manager,
                    'status'                => 'accepted',
                    'updated_by'            => Auth::id(),
                ]);
            } else {
                return response()->json([
                    'message' => 'weight_must_be_exactly'
                ]);
            }

            DB::commit(); // ✅ Commit after successful update
            return response()->json([
                'success' => true,
                'message' => 'Performance accepted successfully!',
                'status'  => 200
            ]);
        } catch (\Throwable $exp) {
            DB::rollBack(); // ✅ Roll back only if transaction started
            return response()->json([
                'error'     => 'Performance accepted failed.',
                'exception' => $exp->getMessage()
            ], 500);
        }
    }
    public function performanceAssignAll(Request $request)
    {
        try {
            DB::beginTransaction(); // ✅ Start transaction
            $ids = explode(',', $request->performance_id);
            $approved = [];
            $skipped = [];
            foreach ($ids as $id) {
                $performance = Performance::findOrFail($id);
                if ($performance->total_weight == 100 && $performance->status == 'accepted') {
                    $performance->update([
                        'status'             => $request->status,
                        'reason'             => $request->reason,
                        'review_employee_id' => $request->employee_id,
                        'review_date'        => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_by'         => Auth::id(),
                    ]);
                    $approved[] = $id;
                } else {
                    $skipped[] = $id;
                }
            }

            DB::commit(); // ✅ Commit after all pass
            return response()->json([
                'success'  => true,
                'message'  => 'Updated performance status successfully!',
                'approved' => $approved,
                'status'   => 200
            ]);

        } catch (\Throwable $exp) {
            DB::rollBack(); // ✅ Roll back on exception
            return response()->json([
                'error'     => 'Updated performance status failed.',
                'exception' => $exp->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $performance = Performance::findOrFail($request->id);
            Title::where('performance_id', $performance->id)->delete();
            Purpose::where('performance_id', $performance->id)->delete();
            PerformanceDetail::where('performance_id', $performance->id)->delete();
            PerformanceGoal::where('performance_id', $performance->id)->delete();
            $performance->delete();
            DB::commit();
            Toastr::success('Performance deleted successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Failed to delete performance');
            return redirect()->back();
        }
    }

    public function performanceImport(Request $request){
        DB::beginTransaction();
        try {
            // --- Performance Sheet ---
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            if (!in_array($extension, ["xlsx", "xls", "csv"])) {
                return back()->withErrors(["file" => "Invalid file format"]);
            }

            $spreadsheet = IOFactory::load($file->getPathname());
            $performanceSheet = $spreadsheet->getSheetByName('Performance');
            if ($performanceSheet) {
                $rows = $performanceSheet->toArray();
                foreach ($rows as $i => $row) {
                    if ($i == 0) continue; // skip header

                    $employee = User::where("number_employee", $row[0])->first();
                    if (!$employee) continue;

                    if($row[4] <= 100){
                        $performance = Performance::create([
                            'employee_id'  => $employee->id,
                            'from_date'    => Carbon::parse($row[1]),
                            'to_date'      => Carbon::parse($row[2]),
                            'type'         => $row[3],
                            'total_weight' => $row[4],
                            'status'       => 'preparing',
                            'created_by'   => Auth::id(),
                        ]);

                        // --- Title Sheet ---
                        $titleSheet = $spreadsheet->getSheetByName('Title');
                        if ($titleSheet) {
                            $rowsTitle = $titleSheet->toArray();
                            foreach ($rowsTitle as $j => $rowT) {
                                if ($j == 0) continue;

                                $title = $performance->titles()->create([
                                    'title'      => $rowT[0],
                                    'created_by' => Auth::id(),
                                ]);
                                // --- Purpose Sheet ---
                                $purposeSheet = $spreadsheet->getSheetByName('Purposes');
                                if ($purposeSheet) {
                                    $rowsPurpose = $purposeSheet->toArray();
                                    foreach ($rowsPurpose as $k => $rowP) {
                                        if ($k == 0) continue;

                                        // ✅ Match Title Ref in col[0] with current Title in rowT[0]
                                        // --- Purpose Sheet Loop ---
                                        if (trim($rowP[0]) == trim($rowT[0])) { // Match Purpose ទៅ Title
                                            $purpose = $title->purposes()->create([
                                                'performance_id' => $performance->id,
                                                'title_id'       => $title->id,
                                                'name'           => $rowP[1],
                                                'created_by'     => Auth::id(),
                                            ]);

                                            // --- Performance Detail Sheet ---
                                            $detailSheet = $spreadsheet->getSheetByName("Performance Detail");
                                            $highestRow  = $detailSheet->getHighestRow();

                                            // Variable សម្រាប់រក្សាទុកឈ្មោះ Purpose ចុងក្រោយដែលរកឃើញ (ដើម្បីដោះស្រាយ Merged Cells)
                                            $currentPurposesRef = null;
                                            $last_detail_id     = null;

                                            for ($row = 2; $row <= $highestRow; $row++) {
                                                $purposesRefValue = trim($detailSheet->getCell('A' . $row)->getValue() ?? '');

                                                // 🚀 Logic សំខាន់៖ បើជួរនេះមានឈ្មោះ Purpose ថ្មី ត្រូវប្តូរ currentPurposesRef
                                                // បើជួរនេះទទេ (Merged cell) វានឹងប្រើឈ្មោះ Purpose ចាស់ដដែល
                                                if (!empty($purposesRefValue)) {
                                                    $currentPurposesRef = $purposesRefValue;
                                                }

                                                // 🛑 ឆែកថា តើជួរនេះជារបស់ Purpose ដែលយើងកំពុង Loop ដែរឬទេ?
                                                // បើមិនមែនទេ គឺត្រូវ Skip ទៅជួរបន្ទាប់
                                                if ($currentPurposesRef !== $purpose->name) {
                                                    continue;
                                                }

                                                $keyKpiValue = trim($detailSheet->getCell('B' . $row)->getValue() ?? '');

                                                // ១. បង្កើត Performance Detail តែនៅជួរដែលមាន KPI Key ប៉ុណ្ណោះ
                                                if (!empty($keyKpiValue)) {
                                                    $newDetail = $purpose->performanceDetail()->create([
                                                        'performance_id' => $performance->id,
                                                        'title_id'       => $title->id,
                                                        'purpose_id'     => $purpose->id,
                                                        'key_kpi'        => $keyKpiValue,
                                                        'action_plan'    => trim($detailSheet->getCell('C' . $row)->getValue() ?? ''),
                                                        'goal_type'      => trim($detailSheet->getCell('F' . $row)->getValue() ?? ''),
                                                        'weight'         => trim($detailSheet->getCell('G' . $row)->getValue() ?? ''),
                                                        'is_lock'        => (trim($detailSheet->getCell('H' . $row)->getValue()) == 'Yes') ? 1 : 0,
                                                        'created_by'     => Auth::id(),
                                                    ]);
                                                    $last_detail_id = $newDetail->id;
                                                }

                                                // ២. បញ្ចូល From/To ទៅក្នុង performance_goals
                                                $fromValue = $detailSheet->getCell('D' . $row)->getValue();
                                                $toValue   = $detailSheet->getCell('E' . $row)->getValue();

                                                if ($fromValue !== null && $toValue !== null && $last_detail_id !== null) {
                                                    DB::table('performance_goals')->insert([
                                                        'performance_id'        => $performance->id,
                                                        'title_id'              => $title->id,
                                                        'purpose_id'            => $purpose->id,
                                                        'performance_detail_id' => $last_detail_id,
                                                        'from'                  => $fromValue,
                                                        'to'                    => $toValue,
                                                        'user_id'               => $employee->id,
                                                        'created_at'            => now(),
                                                        'updated_at'            => now(),
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }else{
                        return response()->json([
                            'message' => 'weight_must_be_exactly'
                        ]);
                    }
                }
            }

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error("Import failed: " . $e->getMessage(), "Error");
        }
    }

    public function kpiImportGoal(Request $request) {
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
            $currentKPI = null;
            $currentGoalType = null; // បន្ថែមថ្មី
            $goalIndex      = 0;

            for ($row = 2; $row <= $highestRow; $row++) {
                $forYearValue  = trim($sheet->getCell('A' . $row)->getValue());
                $purposeValue  = trim($sheet->getCell('B' . $row)->getValue());
                $kpiValue      = trim($sheet->getCell('C' . $row)->getValue());
                $fromValue     = $sheet->getCell('D' . $row)->getValue();
                $toValue       = $sheet->getCell('E' . $row)->getValue();
                $goalType      = trim($sheet->getCell('F' . $row)->getValue());
                $goalWeight    = trim($sheet->getCell('G' . $row)->getValue());
                $goalIslook    = trim($sheet->getCell('H' . $row)->getValue());

                if (!empty($forYearValue))  $currentForYear = $forYearValue;
                if (!empty($purposeValue))  $currentPurpose = $purposeValue;
                if (!empty($kpiValue)) {
                    $currentKPI = $kpiValue;
                    $goalIndex = 0; // Reset មក ០ វិញភ្លាម ពេលចាប់ផ្ដើម KPI ថ្មី
                }
                if (!empty($goalType)) {
                    $currentGoalType = $goalType;
                }

                // បើជួរនោះទទេទាំងស្រុង មិនបាច់ឆែកទេ
                if (empty($currentForYear) && empty($currentPurpose) && empty($currentKPI)) continue;

                if ((string)$fromValue === '' || (string)$toValue === '') {
                    // បើ User វាយលេខ 0 វានឹងមិនចូលក្នុង Error នេះទេ
                    $errors[] = "Sheet $id (Row $row): (From ឬ To) ខ្លះខ្វះទិន្នន័យ";
                    continue;
                }

                // ១. ស្វែងរក Performance
                $performance = Performance::where("employee_id", $employee->id)
                                ->where('type', $currentForYear)->first();
                if (!$performance) {
                    $errors[] = "Sheet $id: For Year ($currentForYear) រកមិនឃើញក្នុងប្រព័ន្ធ";
                    continue;
                }
                // បន្ថែមការឆែក Status "new"
                if ($performance->status !== "preparing") {
                    // បង្កើតសារ Error ឱ្យចំបញ្ហា
                    $errors[] = "Sheet $id: មិនអាច Upload បានទេ ព្រោះ Status គឺ '{$performance->status}' (អនុញ្ញាតបានតែ Status 'preparing' ប៉ុណ្ណោះ)";
                    continue;
                }

                // ២. ស្វែងរក Purpose
                $purpose = Purpose::where("performance_id", $performance->id)
                            ->where('name', $currentPurpose)->first();
                if (!$purpose) {
                    $errors[] = "Sheet $id: Purpose ($currentPurpose) រកមិនឃើញក្នុងប្រព័ន្ធ";
                    continue;
                }

                // ៣. ស្វែងរក PerformanceDetail
                $detail = PerformanceDetail::where("performance_id", $performance->id)
                            ->where("purpose_id", $purpose->id)
                            ->where('key_kpi', $currentKPI)->first();
                if (!$detail) {
                    $errors[] = "Sheet $id: KPI Key ($currentKPI) រកមិនឃើញក្នុងប្រព័ន្ធ";
                    continue;
                }
                if ($performance && $purpose && $detail) {
                    // កែសម្រួល PerformanceDetail បើមានការផ្លាស់ប្តូរ
                    if($goalType && $goalWeight && $goalIslook){
                        $newData = [
                            'goal_type' => $goalType,
                            'weight'    => is_numeric($goalWeight) ? (float)$goalWeight : 0,
                            'is_lock'   => ($goalIslook == 'Yes' || $goalIslook == '1') ? 1 : 0,
                        ];

                        // Update តែពេលណាទិន្នន័យខុសគ្នា (ដើម្បីល្បឿន)
                        if ($detail->goal_type != $newData['goal_type'] ||
                            $detail->weight != $newData['weight'] ||
                            $detail->is_lock != $newData['is_lock']) {
                            $detail->update($newData);
                        }
                    }

                    $existingGoals = DB::table('performance_goals')
                    ->where('performance_detail_id', $detail->id)
                    ->orderBy('id', 'asc')
                    ->get();
                    if ((string)$fromValue !== '' && (string)$toValue !== '') {
                        $goal_from = $fromValue;
                        $goal_to = $toValue;

                        if ($currentGoalType == "date_increment" || $currentGoalType == "date_decrement") {
                            try {
                                if (is_numeric($fromValue)) {
                                    // ១. បើជាលេខ Excel Serial (ឧទាហរណ៍: 46025)
                                    $dateFrom = Carbon::instance(Date::excelToDateTimeObject($fromValue));
                                } else {
                                    // ២. បើជាអក្សរ (String) - ព្យាយាម Parse តាម formats ដែលអាចមាន
                                    $trimmedFrom = trim($fromValue);

                                    // ឆែកមើលថាឆ្នាំមាន ២ ខ្ទង់ (26) ឬ ៤ ខ្ទង់ (2026)
                                    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{2}$/', $trimmedFrom)) {
                                        $dateFrom = Carbon::createFromFormat('d/m/y', $trimmedFrom); // ឆ្នាំ ២ ខ្ទង់ (y តូច)
                                    } else {
                                        $dateFrom = Carbon::createFromFormat('d/m/Y', $trimmedFrom); // ឆ្នាំ ៤ ខ្ទង់ (Y ធំ)
                                    }
                                }

                                // ធ្វើដូចគ្នាសម្រាប់ To Value
                                if (is_numeric($toValue)) {
                                    $dateTo = Carbon::instance(Date::excelToDateTimeObject($toValue));
                                } else {
                                    $trimmedTo = trim($toValue);
                                    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{2}$/', $trimmedTo)) {
                                        $dateTo = Carbon::createFromFormat('d/m/y', $trimmedTo);
                                    } else {
                                        $dateTo = Carbon::createFromFormat('d/m/Y', $trimmedTo);
                                    }
                                }

                                // ៣. បំប្លែងទៅជា Format Database ជានិច្ច (YYYY-MM-DD)
                                $goal_from = $dateFrom->format('Y-m-d');
                                $goal_to   = $dateTo->format('Y-m-d');

                            } catch (\Exception $e) {
                                $errors[] = "សន្លឹកកិច្ចការ $id (ជួរទី $row): ថ្ងៃខែមិនត្រឹមត្រូវ ($fromValue / $toValue)។";
                                $goalIndex++;
                                continue;
                            }
                        }

                        // --- ផ្នែក Update ចូល Database ---
                        if (isset($existingGoals[$goalIndex])) {
                            DB::table('performance_goals')
                                ->where('id', $existingGoals[$goalIndex]->id)
                                ->update([
                                    'from'       => (string)$goal_from,
                                    'to'         => (string)$goal_to,
                                    'updated_by' => Auth::id(),
                                    'updated_at' => now(),
                                ]);
                        }
                        $goalIndex++;
                    }
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
