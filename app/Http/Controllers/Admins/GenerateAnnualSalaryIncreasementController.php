<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Branchs;
use App\Models\Payroll;
use App\Models\PerformanceAppraisal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\AnnualSalaryIncreasement;
use App\Models\GenerateAnnualSalaryIncreasement;
use App\Models\SalaryRequest;
use App\Repositories\Admin\ReportRepository;
use App\Exports\ExportAnnualSalaryIncreasement;
use Maatwebsite\Excel\Facades\Excel;


class GenerateAnnualSalaryIncreasementController extends Controller
{
    private $reportRepo;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Base query with joins
            $query = GenerateAnnualSalaryIncreasement::where("generate_annual_salary_increasements.status", "!=", "approved")->leftJoin('users', 'generate_annual_salary_increasements.employee_id', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
                ->leftJoin('performance_appraisals', 'generate_annual_salary_increasements.performance_id', '=', 'performance_appraisals.id')
                ->select(
                    'generate_annual_salary_increasements.*',
                    'users.number_employee',
                    'users.employee_name_kh',
                    'users.employee_name_en',
                    'users.date_of_commencement',
                    'departments.name_english as dep_name',
                    'positions.name_english as positions_name',
                    'branchs.branch_name_en',
                    'performance_appraisals.total_score',
                    'performance_appraisals.total_score_live_staff',
                    'performance_appraisals.total_score_direct_chairman',
                );
        
            // Search filter
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('users.employee_name_en', 'like', "%{$searchValue}%")
                      ->orWhere('users.number_employee', 'like', "%{$searchValue}%")
                      ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                      ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%")
                      ->orWhere('departments.name_english', 'like', "%{$searchValue}%");
                });
            }
        
            // Pagination
            $recordsTotal = GenerateAnnualSalaryIncreasement::count();
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $data = $query->orderBy('generate_annual_salary_increasements.id', 'desc')->offset($start)->limit($limit)->get();
            // ✅ Return JSON for DataTables
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }        
        $branch = Branchs::all();
        return view('generate_annual_salary_increasement.index',compact('branch'));
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
        try {
            DB::beginTransaction();
        
            [$year, $month] = explode('-', $request->increasement_year);
        
            // Get increasement settings for this year
            $data = AnnualSalaryIncreasement::where('increasement_year', $year)->orderBy('id')->get();
            if ($data->isEmpty()) {
                Toastr::error('Not annual salary increasement found for the selected year.', 'Error');
                return redirect()->back();
            }
            // Get all approved performance records for that year/month
            $PerformanceAppraisal = PerformanceAppraisal::whereYear('to_date', $year)->whereMonth('to_date', $month)->where('status', 'new')->get();
            if ($PerformanceAppraisal->isEmpty()) {
                Toastr::error('Not have kpi found for the selected year.', 'Error');
                return redirect()->back();
            }
            foreach ($PerformanceAppraisal as $kpiPerform) {
                $employeeId = $kpiPerform->employee_id;
        
                // Find related payroll for employee in same year/month
                $payroll = Payroll::where('employee_id', $employeeId)->whereYear('payment_date', $year)->whereMonth('payment_date', $month)->first();        
                if (!$payroll) {
                    Toastr::error('Not salary record found for this employee in the selected month and year.', 'Error');
                    return back();
                }
        
                // KPI Score
                $kpiScores = (float) $kpiPerform->total_score_direct_chairman;
                
                // Match KPI score with increasement range
                $interest = 0;
                $total_percentage = 0;
                foreach ($data as $item) {
                    [$min, $max] = array_map('floatval', explode('-', $item->total_score));
                    if ($kpiScores >= $min && $kpiScores <= $max) {
                        $interest = $item->percentage / 100;
                        $total_percentage = $item->percentage;
                        break;
                    }
                }
               
                $start = Carbon::parse($kpiPerform->from_date);
                $end   = Carbon::parse($kpiPerform->to_date);
                // swap if reversed
                if ($end->lt($start)) {
                    [$start, $end] = [$end, $start];
                }
                // Move start to 1st day of next month if it does not start on day 1
                if ($start->day > 1) {
                    $start = $start->copy()->startOfMonth()->addMonth();
                }
                // Move end to last day of previous month if it does not end on last day
                if ($end->day < $end->endOfMonth()->day) {
                    $end = $end->copy()->subMonth()->endOfMonth();
                }
                // Calculate full months only
                $kpiMonths = $start->diffInMonths($end) + 1;

                if ($kpiMonths >= 2) {
                    // Get employee start date
                    $user = User::find($employeeId);
                    $dateOfCommencement = $user && $user->date_of_commencement ? Carbon::parse($user->date_of_commencement) : Carbon::create($year, 1, 1);
                    $endOfYear = Carbon::create($year, 12, 31);
                    
                    $totalWorkingDays = $dateOfCommencement->diffInDays($endOfYear) + 1;
                    $daysInYear = 365;
                    // Final increasement calculation
                    $totalsSalaryIncreasement = ($payroll->basic_salary * $interest * $totalWorkingDays) / $daysInYear;
                    // dd([
                    //     'employee_id' => $employeeId,
                    //     'performance_id' => $kpiPerform->id,
                    //     'basic_salary' => $payroll->basic_salary,
                    //     'KPI Scores' => $kpiScores,
                    //     'totalWorkingDays' => $totalWorkingDays,
                    //     'increasement_of_year' => $request->increasement_year,
                    //     'salary_increasement' => $totalsSalaryIncreasement,
                    //     'percentage' => $total_percentage,
                    //     'status' => 'pending',
                    //     'created_by' => Auth::id(),
                    // ]);
                    // Remove old record if exists for this employee/year
                    GenerateAnnualSalaryIncreasement::where('employee_id', $employeeId)->where('increasement_of_year', $request->increasement_year)->delete();
                    // Insert new record
                    GenerateAnnualSalaryIncreasement::create([
                        'employee_id' => $employeeId,
                        'performance_id' => $kpiPerform->id,
                        'basic_salary' => $payroll->basic_salary,
                        'increasement_of_year' => $request->increasement_year,
                        'salary_increasement' => $totalsSalaryIncreasement,
                        'percentage' => $total_percentage,
                        'status' => 'pending',
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        
            DB::commit();
            Toastr::success('Generate annual salary increasement successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Generate annual salary increasement failed', 'Error');
            return redirect()->back();
        }        
    }

    public function annualSalaryIncreasementApproved(Request $request){
        try {
            DB::beginTransaction();
            $data = GenerateAnnualSalaryIncreasement::whereIn('id',explode(',', $request->id))->get();
            foreach ($data as $value) {
                // Get related salary request IDs
                $salaryRequest_ids = SalaryRequest::where('employee_id', $value->employee_id)->where('type', 0)->where('status', 1)->pluck('id')->toArray();
                // Update user salary
                User::where('id', $value->employee_id)->update([
                    'basic_salary' => $value->basic_salary + $value->salary_increasement + $value->total_salary_request,
                    'salary_increas' => $value->salary_increasement + $value->total_salary_request,
                ]);

                // Update GenerateAnnualSalaryIncreasement record
                $value->update([
                    'status'             => 'approved',
                    'salary_request_ids' => $salaryRequest_ids, // auto-cast to JSON if model has $casts
                    'salary_request'     => $value->total_salary_request,
                    'approved_by'        => Auth::id(),
                ]);

                // Update related SalaryRequests
                SalaryRequest::where('employee_id', $value->employee_id)
                ->where('type', 0)
                ->where('status', 1)
                ->update([
                    'status'     => 2, // consider using a constant like SalaryRequest::STATUS_APPROVED
                    'updated_by' => Auth::id(),
                ]);
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
                'error'     => 'Updated status failed.',
                'exception' => $exp->getMessage()
            ], 500);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    public function export(Request $request){
        $query = $this->reportRepo->getAnnualSalaryIncreasementReport($request);
        $data = $query->where("generate_annual_salary_increasements.status", "!=", "approved")->orderBy('generate_annual_salary_increasements.id', 'desc')->get();
        $export = new ExportAnnualSalaryIncreasement($data);
        return Excel::download($export, 'annual_salary_increasement.xlsx');
    }
}
