<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Title;
use App\Models\PAFlow;
use App\Models\Branchs;
use App\Models\Purpose;
use App\Models\Department;
use App\Models\Performance;
use App\Models\permissions;
use App\Models\TitleHistory;
use Illuminate\Http\Request;
use App\Models\PurposeHistory;
use Illuminate\Support\Carbon;
use App\Models\PerformanceDetail;
use App\Models\PerformanceHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PerformanceDetailHistory;

class PerformanceController extends Controller
{
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
        $permission = self::permission();
        if (!$permission || $permission["is_view"] != 1) {
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
        
            // Search filter
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
                // $query->whereIn('performances.status', ['preparing','accepted']);
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
                $query->where("users.department_id", Auth::user()->department_id);
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
                $query->orderBy('performances.id', 'desc');
            }
            $data = $query->orderBy('performances.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsFiltered,
                'recordsFiltered' => $recordsFiltered,
                'userIdLog'=>Auth::user()->id,
                'permission'=>$permission,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        $department = Department::all();
        $employee = User::where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        return view('performances.index',compact('branch','department','employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
                $query->whereNot("users.id", Auth::user()->id);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        try {
            DB::beginTransaction();
            $totalWeight = 0;
            $data = $request->all();
            // Calculate total weight
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

                    // Create Performance
                    $performance = Performance::create($data);
                    // Loop through each title
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
        
                            foreach ($purposeItem['dataKPi'] as $kpi) {
                                /* ---- Validate goal lines -------------------------------- */
                                $isValidGoal = true;
                                $goalType    = $kpi['goal_type'];           // number|currency|percent|date
                                $lines       = explode("\n", $kpi['goal']);
        
                                // foreach ($lines as $line) {
                                //     $parts = preg_split('/\s+/', trim($line));
                                //     if (count($parts) !== 2) { $isValidGoal = false; break; }
                                //     [$min, $max] = $parts;
                                //     switch ($goalType) {
                                //         case 'number':
                                //         case 'currency':
                                //         case 'percent':
                                //             if (!is_numeric($min) || !is_numeric($max)) {
                                //                 $isValidGoal = false;
                                //             }
                                //             break;
                                //         case 'date':
                                //             try {
                                //                 $d1 = \Carbon\Carbon::createFromFormat('Y-m-d', $min);
                                //                 $d2 = \Carbon\Carbon::createFromFormat('Y-m-d', $max);
        
                                //                 if ($d1->format('Y-m-d') !== $min || $d2->format('Y-m-d') !== $max) {
                                //                     $isValidGoal = false;
                                //                 }
                                //             } catch (\Exception $e) {
                                //                 $isValidGoal = false;
                                //             }
                                //             break;
                                //         default:
                                //             $isValidGoal = false;
                                //     }
                                //     if (!$isValidGoal) { break; }
                                // }

                                // foreach ($lines as $line) {
                                //     $parts = preg_split('/\s+/', trim($line));
                                //     if (count($parts) !== 2) { $isValidGoal = false; break; }
                                //     [$min, $max] = $parts;
                                //     if (str_contains($goalType, 'number') || str_contains($goalType, 'percent') || str_contains($goalType, 'currency')) {
                                //         if (!is_numeric($min) || !is_numeric($max)) {
                                //             $isValidGoal = false;
                                //             break;
                                //         }
                                //     }
                                //     elseif (str_contains($goalType, 'date')) {
                                //         try {
                                //             $min = Carbon::parse($min);
                                //             $max = Carbon::parse($max);
                                //         } catch (\Exception $e) {
                                //             $isValidGoal = false;
                                //             break;
                                //         }
                                //     } else {
                                //         $isValidGoal = false;
                                //         break;
                                //     }

                                //     if ($min < $max)       $current = 'inc';
                                //     elseif ($min > $max)   $current = 'dec';
                                //     else                   $current = 'equal';
                                //     $expected = str_contains($goalType, 'number_increment') ? 'inc' : 'dec';

                                //     if ($current !== 'equal' && $current !== $expected) {
                                //         $isValidGoal = false;
                                //         break;
                                //     }
                                // }
        
                                

                                foreach ($lines as $line) {

                                    $line = trim($line);
                                    if ($line === '') continue; // skip empty lines

                                    $parts = preg_split('/\s+/', $line);

                                    if (count($parts) !== 2) {
                                        $isValidGoal = false;
                                        break;
                                    }

                                    [$min, $max] = $parts;

                                    if (
                                        str_contains($goalType, 'number') ||
                                        str_contains($goalType, 'percent') ||
                                        str_contains($goalType, 'currency')
                                    ) {

                                        if (!is_numeric($min) || !is_numeric($max)) {
                                            $isValidGoal = false;
                                            break;
                                        }

                                        $min = (float)$min;
                                        $max = (float)$max;

                                        // Optional percent validation
                                        if (str_contains($goalType, 'percent')) {
                                            if ($min < 0 || $max > 100) {
                                                $isValidGoal = false;
                                                break;
                                            }
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

                                    // ✅ FIXED HERE
                                    $expected = str_contains($goalType, 'increment') ? 'inc' : 'dec';

                                    if ($current !== 'equal' && $current !== $expected) {
                                        $isValidGoal = false;
                                        break;
                                    }
                                }

                                if (!$isValidGoal) {
                                    DB::rollBack();
                                    return response()->json([
                                        'message' => 'not_goal',
                                        'goal_type' => $goalType,
                                    ]);
                                }
        
                                /* ---- Passed validation → create row -------------------- */
                                PerformanceDetail::create([
                                    'performance_id' => $performance->id,
                                    'title_id'       => $title->id,
                                    'purpose_id'     => $purpose->id,
                                    'key_kpi'        => $kpi['key_kpi'],
                                    'action_plan'    => $kpi['action_plan'],
                                    'goal'           => $kpi['goal'],
                                    'weight'         => $kpi['weight'],
                                    'goal_type'      => $goalType,
                                    'is_lock'        => $kpi['is_lock'],
                                    'updated_by'     => Auth::id(),
                                ]);
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
            Toastr::error('Performance created fail.','Error');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

                        PerformanceDetailHistory::create($pdArray);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            /* -------------------------------------------------
            | 1. Check total KPI weight
            * ------------------------------------------------*/
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
                /* -------------------------------------------------
                | 2. Update Performance header
                * ------------------------------------------------*/
                $performance = Performance::findOrFail($request->performance_id);
                self::createHistories($performance);
                $employee    = User::findOrFail($request->employee_id);

                $year = \Carbon\Carbon::parse($request->from_date)->format('Y');
                $type = $employee->emp_status === 'KPI Probation' ? "Probation $year" : "KPI Form $year";

                $performance->update([
                    'status'        => 'preparing',
                    'reason'        => '',
                    'employee_id'   => $request->employee_id,
                    'from_date'     => $request->from_date,
                    'to_date'       => $request->to_date,
                    'type'          => $type,
                    'total_weight'  => $totalWeight,
                    'updated_by'    => Auth::id(),
                ]);

                /* -------------------------------------------------
                | 3. Remove old detail rows
                * ------------------------------------------------*/
                Title::where('performance_id', $performance->id)->delete();
                Purpose::where('performance_id', $performance->id)->delete();
                PerformanceDetail::where('performance_id', $performance->id)->delete();

                foreach ($request->data as $titleItem) {
                    $title = Title::create([
                        'performance_id' => $performance->id,
                        'title'          => $titleItem['title'],
                        'created_by'     => Auth::id(),
                    ]);
                
                    // Only loop if dataPurpose exists and is an array
                    if (!empty($titleItem['dataPurpose']) && is_array($titleItem['dataPurpose'])) {
                        foreach ($titleItem['dataPurpose'] as $purposeItem) {
                            $purpose = Purpose::create([
                                'performance_id' => $performance->id,
                                'title_id'       => $title->id,
                                'name'           => $purposeItem['purpose'],
                                'created_by'     => Auth::id(),
                            ]);
                
                            if (!empty($purposeItem['dataKPi']) && is_array($purposeItem['dataKPi'])) {
                                foreach ($purposeItem['dataKPi'] as $kpi) {
                                    // ✅ Your goal validation logic here (unchanged)
                                    $isValidGoal = true;
                                    $goalType    = $kpi['goal_type'];
                                    $lines       = explode("\n", $kpi['goal']);
                
                                    // foreach ($lines as $line) {
                                    //     $parts = preg_split('/\s+/', trim($line));
                
                                    //     if (count($parts) !== 2) { $isValidGoal = false; break; }
                
                                    //     [$min, $max] = $parts;
                
                                    //     switch ($goalType) {
                                    //         case 'number':
                                    //         case 'currency':
                                    //         case 'percent':
                                    //             if (!is_numeric($min) || !is_numeric($max)) {
                                    //                 $isValidGoal = false;
                                    //             }
                                    //             break;
                
                                    //         case 'date':
                                    //             try {
                                    //                 $d1 = \Carbon\Carbon::createFromFormat('Y-m-d', $min);
                                    //                 $d2 = \Carbon\Carbon::createFromFormat('Y-m-d', $max);
                
                                    //                 if ($d1->format('Y-m-d') !== $min || $d2->format('Y-m-d') !== $max) {
                                    //                     $isValidGoal = false;
                                    //                 }
                                    //             } catch (\Exception $e) {
                                    //                 $isValidGoal = false;
                                    //             }
                                    //             break;
                
                                    //         default:
                                    //             $isValidGoal = false;
                                    //     }
                                    //     if (!$isValidGoal) { break; }
                                    // }

                                    foreach ($lines as $line) {
                                        $parts = preg_split('/\s+/', trim($line));
                                        if (count($parts) !== 2) { $isValidGoal = false; break; }
                                        [$min, $max] = $parts;
                                        // Parse numeric/date types
                                        if (str_contains($goalType, 'number') || str_contains($goalType, 'percent') || str_contains($goalType, 'currency')) {
                                            if (!is_numeric($min) || !is_numeric($max)) {
                                                $isValidGoal = false;
                                                break;
                                            }
                                        }
                                        elseif (str_contains($goalType, 'date')) {
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

                                        // Determine increment or decrement
                                        if ($min < $max)       $current = 'inc';
                                        elseif ($min > $max)   $current = 'dec';
                                        else                   $current = 'equal';
                                        // Assign direction based on goal type
                                        $expected = str_contains($goalType, 'increment') ? 'inc' : 'dec';

                                        // "equal" is allowed for both increment & decrement
                                        if ($current !== 'equal' && $current !== $expected) {
                                            $isValidGoal = false;
                                            break;
                                        }
                                    }

                
                                    if (!$isValidGoal) {
                                        DB::rollBack();
                                        return response()->json([
                                            'message'   => 'not_goal',
                                            'goal_type' => $goalType,
                                        ]);
                                    }
                
                                    // ✅ Passed validation → create row
                                    PerformanceDetail::create([
                                        'performance_id' => $performance->id,
                                        'title_id'       => $title->id,
                                        'purpose_id'     => $purpose->id,
                                        'key_kpi'        => $kpi['key_kpi'],
                                        'action_plan'    => $kpi['action_plan'],
                                        'goal'           => $kpi['goal'],
                                        'weight'         => $kpi['weight'],
                                        'goal_type'      => $goalType,
                                        'is_lock'        => $kpi['is_lock'],
                                        'updated_by'     => Auth::id(),
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
                return response()->json(['error' => 'The total weight of all KPIs must equal 100%.']);
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
            // Delete performance details
            PerformanceDetail::where('performance_id', $performance->id)->delete();
            // Delete purposes
            Purpose::where('performance_id', $performance->id)->delete();
            // Delete titles
            Title::where('performance_id', $performance->id)->delete();
            // Finally delete performance
            $performance->delete();
            DB::commit();
            Toastr::success('Performance deleted successfully.','Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Failed to delete performance.','Error');
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
                                        if (trim($rowP[0]) == trim($rowT[0])) {
                                            $purpose = $title->purposes()->create([
                                                'performance_id' => $performance->id,
                                                'title_id'       => $title->id,
                                                'name'           => $rowP[1], // Purpose Name in Col B
                                                'created_by'     => Auth::id(),
                                            ]);

                                            // --- Performance Detail Sheet ---
                                            $detailSheet = $spreadsheet->getSheetByName('Performance Detail');
                                            if ($detailSheet) {
                                                $rowsDetail = $detailSheet->toArray();
                                                foreach ($rowsDetail as $m => $rowD) {
                                                    if ($m == 0) continue;

                                                    // ✅ Match Purpose Ref in detail with current Purpose
                                                    if (trim($rowD[0]) == trim($rowP[1])) {
                                                        $purpose->performanceDetail()->create([
                                                            'performance_id' => $performance->id,
                                                            'title_id'       => $title->id,
                                                            'purpose_id'     => $purpose->id,
                                                            'key_kpi'        => $rowD[1],
                                                            'action_plan'    => $rowD[2],
                                                            'goal'           => $rowD[3],
                                                            'goal_type'      => $rowD[4],
                                                            'weight'         => $rowD[5],
                                                            'is_lock'        => $rowD[6],
                                                            'created_by'     => Auth::id(),
                                                        ]);
                                                    }
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
}