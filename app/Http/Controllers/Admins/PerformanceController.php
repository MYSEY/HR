<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Title;
use App\Models\Purpose;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PerformanceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
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
        );
        if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO','HR','DHOD','DBM'])) {
            $query->where('performances.created_by', Auth::user()->id);
        }
        if (in_array(Auth::user()->RolePermission, ['Employee'])) {
            $query->where('performances.employee_id', Auth::user()->id);
        }
        // ->groupBy('performances.employee_id')
        // Fetch paginated data
        $data = $query->get();
        return view('performances.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = User::where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
        // $employee = User::where('line_manager',Auth::user()->line_manager)->where('emp_status','!=',null)->select('id','number_employee','employee_name_kh','employee_name_en')->get();
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
                    $user = User::where('id', $empId)->select('id', 'number_employee', 'employee_name_kh', 'employee_name_en', 'emp_status')->first();
                    $type = $user->emp_status === 'Probation' ? 'KPI Probation ' . Carbon::parse($request->from_date)->format('Y') : 'KPI Form ' . Carbon::parse($request->from_date)->format('Y');
                    $data = $request->all();
                    $data['created_by'] = Auth::id();
                    $data['employee_id'] = $empId;
                    $data['total_weight'] = $totalWeight;
                    $data['status'] = 'prepare';
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
        
                                foreach ($lines as $line) {
                                    $parts = preg_split('/\s+/', trim($line));
        
                                    if (count($parts) !== 2) { $isValidGoal = false; break; }
        
                                    [$min, $max] = $parts;
        
                                    switch ($goalType) {
                                        case 'number':
                                        case 'currency':
                                        case 'percent':
                                            if (!is_numeric($min) || !is_numeric($max)) {
                                                $isValidGoal = false;
                                            }
                                            break;
        
                                        case 'date':
                                            try {
                                                $d1 = \Carbon\Carbon::createFromFormat('Y-m-d', $min);
                                                $d2 = \Carbon\Carbon::createFromFormat('Y-m-d', $max);
        
                                                if ($d1->format('Y-m-d') !== $min || $d2->format('Y-m-d') !== $max) {
                                                    $isValidGoal = false;
                                                }
                                            } catch (\Exception $e) {
                                                $isValidGoal = false;
                                            }
                                            break;
        
                                        default:
                                            $isValidGoal = false;
                                    }
                                    if (!$isValidGoal) { break; }
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
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'error' => 'The total weight of all KPIs must equal 100%.',
                    'status' => 422
                ], 422);
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
        return view('performances.preview',compact('data'));
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
                foreach ($title['dataPurpose'] as $purpose) {
                    foreach ($purpose['dataKPi'] as $kpi) {
                        $totalWeight += (int) $kpi['weight'];
                    }
                }
            }

           
            if ($totalWeight <= 100) {
                /* -------------------------------------------------
                | 2. Update Performance header
                * ------------------------------------------------*/
                $performance = Performance::findOrFail($request->performance_id);
                $employee    = User::findOrFail($request->employee_id);

                $year = \Carbon\Carbon::parse($request->from_date)->format('Y');
                $type = $employee->emp_status === 'KPI Probation' ? "Probation $year" : "KPI Form $year";

                $performance->update([
                    'employee_id' => $request->employee_id,
                    'from_date'   => $request->from_date,
                    'to_date'     => $request->to_date,
                    'type'        => $type,
                    'total_weight' => $totalWeight,
                    'updated_by'  => Auth::id(),
                ]);

                /* -------------------------------------------------
                | 3. Remove old detail rows
                * ------------------------------------------------*/
                Title::where('performance_id', $performance->id)->delete();
                Purpose::where('performance_id', $performance->id)->delete();
                PerformanceDetail::where('performance_id', $performance->id)->delete();

                /* -------------------------------------------------
                | 4. Re-insert Titles › Purposes › KPI Details
                * ------------------------------------------------*/
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

                            foreach ($lines as $line) {
                                $parts = preg_split('/\s+/', trim($line));

                                if (count($parts) !== 2) { $isValidGoal = false; break; }

                                [$min, $max] = $parts;

                                switch ($goalType) {
                                    case 'number':
                                    case 'currency':
                                    case 'percent':
                                        if (!is_numeric($min) || !is_numeric($max)) {
                                            $isValidGoal = false;
                                        }
                                        break;

                                    case 'date':
                                        try {
                                            $d1 = \Carbon\Carbon::createFromFormat('Y-m-d', $min);
                                            $d2 = \Carbon\Carbon::createFromFormat('Y-m-d', $max);

                                            if ($d1->format('Y-m-d') !== $min || $d2->format('Y-m-d') !== $max) {
                                                $isValidGoal = false;
                                            }
                                        } catch (\Exception $e) {
                                            $isValidGoal = false;
                                        }
                                        break;

                                    default:
                                        $isValidGoal = false;
                                }
                                if (!$isValidGoal) { break; }
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
    public function performanceApprove($id)
    {
        try {
            DB::beginTransaction(); // ✅ Start transaction
            $performance = Performance::findOrFail($id);
            if ($performance->total_weight == 100) {
                $performance->update([
                    'status'     => 'approved',
                    'updated_by' => Auth::id(),
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
}
