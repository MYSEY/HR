<?php

namespace App\Http\Controllers\Admins;

use App\Models\Branchs;
use App\Models\Department;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Models\PerformanceDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class PerformanceAppraisalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            // Define the base query
            $query = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
                ->select(
                    'performances.*',
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
            ->where('performances.status', 'approved')
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
                    $q->where('performances.id', 'like', "%{$searchValue}%")
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
            $data = $query->orderBy('performances.id', 'desc')->offset($start)->limit($limit)->get();
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        $department = Department::all();
        return view('performance_appraisal.index',compact('branch','department'));
    }
    public function generateSalaryIncreasement(Request $request)
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
                'users.branch_id',
                'users.basic_salary',
                'users.date_of_commencement',
                'departments.name_english as dep_name',
                'positions.name_english as positions_name',
                'branchs.branch_name_en',
                'branchs.branch_name_kh',
            )
        ->where('performances.status', 'approved');
        $data = $query->get();
        $branch = Branchs::all();
        return view('performance_appraisal.increasement',compact('data','branch'));
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
        return view('performance_appraisal.edit',compact('data'));
    }
    public function progress(Request $request){
        $performance = Performance::with('PerformanceDetails')->where('employee_id',$request->employee_id)->where('id',$request->performance_id)->where('status','approve')->first();
        // dd($datas);
        
        // foreach ($datas as $performance) {
            foreach ($performance->PerformanceDetails as $detail) {
                $lines = explode("\n", trim($detail->goal));
                $goalType = $detail->goal_type; // Assume this field exists
                $score = 1; // Default score
        
                // Example input values (replace with real input)
                $inputValue = match ($goalType) {
                    'date'     => $detail->goal_achieved,
                    'percent'  => $detail->goal_achieved,
                    'currency' => $detail->goal_achieved,
                    'number'   => $detail->goal_achieved, // Assuming this is a numeric value
                };
                foreach ($lines as $index => $line) {
                    [$min, $max] = preg_split('/\s+/', trim($line));
                    // Normalize based on type
                    switch ($goalType) {
                        case 'date':
                            $min = strtotime($min);
                            $max = strtotime($max);
                            $input = strtotime($request->progress);
                            break;
        
                        case 'percent':
                            $min = floatval(str_replace('%', '', $min));
                            $max = floatval(str_replace('%', '', $max));
                            $input = floatval(str_replace('%', '', $request->progress));
                            break;
        
                        case 'currency':
                            $min = floatval(preg_replace('/[^\d.]/', '', $min));
                            $max = floatval(preg_replace('/[^\d.]/', '', $max));
                            $input = floatval(preg_replace('/[^\d.]/', '', $request->progress));
                            break;
        
                        case 'number':
                        default:
                            $min = floatval($min);
                            $max = floatval($max);
                            $input = floatval($request->progress);
                            break;
                    }
        
                    if ($input >= $min && $input <= $max) {
                        $score = $index + 1;
                        break;
                    }
                }
                // $score_achieved = ($detail->weight * $score) / 100;
                // echo("Type: $goalType | Input: $inputValue → Score: $score | Weight: $detail->weight | Score Achieved: $score_achieved <br>");
            }
        // }
        dd($score);
        return response()->json([
            'status' => 'success',
            'message' => 'Progress calculated successfully.',
            'score' => $score,
        ]);
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
            Performance::where('employee_id',$request->employee_id)->where('id',$request->id)->update([
                'total_score'  => $request->total_score,
                'total_score_live_staff'  => $request->total_personnel_score,
                'total_score_direct_chairman'  => $request->total_direct_chairman,
                'updated_by'  => Auth::id(),
            ]);

            foreach ($request->performanceDetail as $value) {
                PerformanceDetail::where('id',$value['performance_id'])->update([
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

    public function updateScorePerformance(Request $request){
        try {
            Performance::where('employee_id',$request->employee_id)->where('id',$request->id)->update([
                'total_score_direct_chairman'  => $request->total_score_direct_chairman,
                'noted'  => $request->noted,
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
}
