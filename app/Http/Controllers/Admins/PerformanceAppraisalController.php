<?php

namespace App\Http\Controllers\Admins;

use App\Models\Branchs;
use App\Models\Payroll;
use App\Models\Department;
use App\Exports\ExportKpis;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PerformanceDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AnnualSalaryIncreasement;

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
                'recordsTotal' => $recordsTotal,
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
        return view('performance_appraisal.menual_score',compact('branch','department'));
    }
    public function generateSalaryIncreasementIndex(Request $request)
    {
        $query = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('payrolls', 'users.id', '=', 'payrolls.employee_id')
            ->select(
                'performances.*',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.branch_id',
                'users.date_of_commencement',
                'departments.name_english as dep_name',
                'positions.name_english as positions_name',
                'branchs.branch_name_en',
                'branchs.branch_name_kh',
                'payrolls.basic_salary',
                'payrolls.payment_date',
            )
        ->where('performances.status', 'approved')->where('payrolls.payment_date','2024-12-25');
        $data = $query->get();
        $branch = Branchs::all();
        return view('performance_appraisal.increasement',compact('data','branch'));
    }
    public function generateSalaryIncreasement(Request $request)
    {
        $validated = $request->validate([
            'increasement_year' => 'required|date',
        ]);

        $yearOnly = Carbon::parse($request->increasement_year)->format('Y');
        $data = AnnualSalaryIncreasement::where('increasement_year',$yearOnly)->orderBy('id')->get();
        if ($request->filled('increasement_year')) {
            [$year, $month] = explode('-', $request->increasement_year);
            $payrolls = Payroll::where('employee_id',144)->whereYear('payment_date', $year)->whereMonth('payment_date', $month)->get();
            foreach ($payrolls as $payroll) {
                // Example: get average KPI score of employee
                // $kpiPerform = Performance::where('employee_id', 144)->get();
                // foreach ($kpiPerform as $value) {
                //     $kpiScores = (float) $value->total_score_direct_chairman;
                // }

                $kpiPerform = Performance::where('employee_id', 144)->orderBy('id', 'desc')->first();
                $kpiScores = $kpiPerform ? (float) $kpiPerform->total_score_direct_chairman : 0;
                $interest = 0;
                $total_percentage = 0;
                foreach ($data as $index => $item) {
                    [$min, $max] = explode('-', $item->total_score); 
                    $min = (float) $min;
                    $max = (float) $max;
                
                    if ($kpiScores >= $min && $kpiScores <= $max) {
                        $interest = $item->percentage / 100;
                        $total_percentage = $item->percentage;
                        break; // stop once matched
                    }
                }

                // Example: calculate total working days in that year
                $dateOfCommencement = \Carbon\Carbon::parse($payroll->date_of_commencement);
                $endOfYear = \Carbon\Carbon::create($year, 12, 31);
                $totalDay = $dateOfCommencement->diffInDays($endOfYear) + 1;
                if ($totalDay >= 365) {
                    $totalWorkingDays = 365; // or 366 for leap years
                }else {
                    $totalWorkingDays = $totalDay;
                }
                $totalsSalaryIncreasement = ($payroll->basic_salary * $interest * $totalWorkingDays) / 365;
                // 👉 save or push into array
                dd([    
                    'employee_id' => $payroll->employee_id,
                    'basic_salary' => $payroll->basic_salary,
                    'kpi_score' => $kpiScores,
                    'percentage' => $total_percentage,
                    'total working day' => $totalWorkingDays,
                    'salary_increasement' => number_format($totalsSalaryIncreasement,2),
                    'total salary' => $payroll->basic_salary + number_format($totalsSalaryIncreasement,2)
                ]);
            }
        }
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
        return view('performance_appraisal.progress',compact('data'));
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

    public function updateKpiScore(Request $request){
        try {
            Performance::where('employee_id',$request->employee_id)->where('id',$request->id)->update([
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
}
