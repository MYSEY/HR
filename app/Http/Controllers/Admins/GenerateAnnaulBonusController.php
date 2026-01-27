<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Branchs;
use App\Models\Payroll;
use App\Models\AnnualBonu;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AnnualBonuBranch;
use App\Exports\ExportAnnualBonus;
use Illuminate\Support\Facades\DB;
use App\Models\GenerateAnnaulBonus;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PerformanceAppraisal;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Round;

class GenerateAnnaulBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Base query with joins
            $query = GenerateAnnaulBonus::leftJoin('users', 'generate_annaul_bonuses.employee_id', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
                ->leftJoin('performance_appraisals', 'generate_annaul_bonuses.performance_id', '=', 'performance_appraisals.id')
                ->select(
                    'generate_annaul_bonuses.*',
                    'users.id',
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
                )->where('generate_annaul_bonuses.status','pending');
            $query->when($request->employee_id, function ($query, $employee_id) {
                return $query->where('generate_annaul_bonuses.employee_id', $employee_id);
            });
            $query->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', $employee_name);
            });
            $query->when($request->branch_id, function ($query, $branch_id) {
                return $query->where('users.branch_id', $branch_id);
            });
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
            $recordsTotal = GenerateAnnaulBonus::where('generate_annaul_bonuses.status','pending')->count();
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $data = $query->orderBy('generate_annaul_bonuses.id', 'desc')->offset($start)->limit($limit)->get();
            // ✅ Return JSON for DataTables
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }  
        $branch = Branchs::all();
        return view('generate_annual_bonus.index',compact('branch'));
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
        try{
            [$year, $month] = explode('-', $request->increasement_year);
            // Get all approved performance records for that year/month
            $PerformanceAppraisal = PerformanceAppraisal::whereYear('to_date', $year)->whereMonth('to_date', $month)->where('status', 'approved')->get();
            foreach ($PerformanceAppraisal as $kpiPerform) {
                $employeeId = $kpiPerform->employee_id;
                // KPI Score
                $kpiScores = (float) $kpiPerform->total_score_direct_chairman;
                // Match KPI score with increasement range
                
               // Get increasement settings
                $dataBonusByEmployee = AnnualBonu::where('increasement_year', $year)->orderBy('id')->get();
                $ofIncentivebyPA = 0;
                foreach ($dataBonusByEmployee as $item) {
                    [$min, $max] = array_map('floatval', explode('-', $item->total_score));
                    if ($kpiScores >= $min && $kpiScores <= $max) {
                        $ofIncentivebyPA = $item->percentage;
                        break;
                    }
                }

                // Working days adjustment
                $employee = User::find($employeeId);
                $dataBonuByBranch = AnnualBonuBranch::where('branch_id', $employee->branch_id)->where('year', $request->increasement_year)->first();      // use first() instead of get()
                $percentageByBranch = $dataBonuByBranch ? $dataBonuByBranch->percentage : 0;

                // Find related payroll for employee in same year/month
                $payroll = Payroll::where('employee_id', $employeeId)->whereYear('payment_date', $year)->whereMonth('payment_date', $month)->first();        
                if (!$payroll) {
                    Toastr::error('Not salary record found for this employee in the selected month and year.', 'Error');
                    return back();
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
                    // Final result
                    $totalPercentage = ($ofIncentivebyPA * $percentageByBranch) / 100;
                    $NumberofMonthsReceived = $dataBonuByBranch ? $dataBonuByBranch->number_of_months_bereceived : 0;
                    // Incentive allowance for full year
                    $annualIncentiveAllowance = ($payroll->basic_salary * $totalPercentage / 100) * $NumberofMonthsReceived;
                    $dateOfCommencement = $employee && $employee->date_of_commencement ? Carbon::parse($employee->date_of_commencement) : Carbon::create($year, 1, 1);
                    $endOfYear = Carbon::create($year, 12, 31);
                    // Count working days inside the selected year
                    $workingDays = $dateOfCommencement->diffInDays($endOfYear) + 1;
                    $daysInYear = $endOfYear->isLeapYear() ? 365 : 365;
                    // Cap days if join date < selected year
                    if ($workingDays >= $daysInYear) {
                        $totalWorkingDays = $daysInYear;
                    }else{
                        $totalWorkingDays = $workingDays;
                    }
                    // Prorate bonus by number of days worked
                    $totalAnnaulBounus = (round($annualIncentiveAllowance,2) / $daysInYear) * $totalWorkingDays;
                    $workingDaysperYear = $dateOfCommencement->diffInDays($endOfYear) + 1;

                    // Save report info (debug)
                    // dd([
                    //     'employee_id' => $employeeId,
                    //     'performance_id' => $kpiPerform->id,
                    //     'basic_salary' => $payroll->basic_salary,
                    //     'working_days_per_year' => $workingDaysperYear,
                    //     '% Incentive' => $percentageByBranch,
                    //     'PA Score' => $kpiScores,
                    //     '% of Incentive by PA' => $ofIncentivebyPA,
                    //     '% Achieved vs. %PA' => $totalPercentage,
                    //     'Number of months to be received' => $NumberofMonthsReceived,
                    //     'total_bounus' => $totalAnnaulBounus,
                    //     'created_by' => Auth::id(),
                    // ]);

                    // Replace old record for this employee/year
                    GenerateAnnaulBonus::where('employee_id', $employeeId)->where('increasement_of_year', $request->increasement_year)->delete();
                    // Insert new calculation
                    GenerateAnnaulBonus::create([
                        "employee_id" => $employeeId,
                        "performance_id" => $kpiPerform->id,
                        "basice_salary" => $payroll->basic_salary,
                        "working_days_per_year" => $workingDaysperYear,
                        "incentive" => $percentageByBranch,
                        "pa_score" => $kpiScores,
                        "of_incentive_by_pa" => $ofIncentivebyPA,
                        "achieved_vs_pa" => $totalPercentage,
                        "number_months_received" => $NumberofMonthsReceived,
                        "increasement_of_year" => $request->increasement_year,
                        "total_annaul_bounus" => $totalAnnaulBounus,
                        "status" => 'pendding',
                        "created_by" => Auth::id(),
                    ]);
                }
            }
            DB::commit();
            Toastr::success('Generate annual bonus successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Generate annual bonus fail','Error');
            return redirect()->back();
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

    public function approved(Request $request)
    {
        DB::beginTransaction(); // ⬅ Start transaction
        try {
            $ids = explode(',', $request->id);
            GenerateAnnaulBonus::whereIn('id', $ids)->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
            DB::commit(); // ⬅ Save all
            return response()->json([
                'success' => true,
                'message' => 'Approve successfully!',
                'status'  => 200
            ]);
        } catch (\Throwable $exp) {
            DB::rollBack(); // ⬅ Roll back if error
            return response()->json([
                'error'     => 'Updated status failed.',
                'exception' => $exp->getMessage()
            ], 500);
        }
    }
    public function annaulBonusDownload(Request $request){
        return Excel::download(new ExportAnnualBonus($request), 'Annual Bonus.xlsx');
    }

    public function reportAnnualBonus(Request $request){
        if ($request->ajax()) {
            // Base query with joins
            $query = GenerateAnnaulBonus::leftJoin('users', 'generate_annaul_bonuses.employee_id', '=', 'users.id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
                ->leftJoin('performance_appraisals', 'generate_annaul_bonuses.performance_id', '=', 'performance_appraisals.id')
                ->select(
                    'generate_annaul_bonuses.*',
                    'users.id',
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
                )->where('generate_annaul_bonuses.status','approved');
            $query->when($request->employee_id, function ($query, $employee_id) {
                return $query->where('generate_annaul_bonuses.employee_id', $employee_id);
            });
            $query->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', $employee_name);
            });
            $query->when($request->branch_id, function ($query, $branch_id) {
                return $query->where('users.branch_id', $branch_id);
            });
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
            $recordsTotal = GenerateAnnaulBonus::where('generate_annaul_bonuses.status','approved')->count();
            $recordsFiltered = $query->count();
            $start = intval(request()->input('start', 0));
            $limit = intval(request()->input('length', 10));
            $data = $query->orderBy('generate_annaul_bonuses.id', 'desc')->offset($start)->limit($limit)->get();
            // ✅ Return JSON for DataTables
            return response()->json([
                'draw' => intval(request()->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        $branch = Branchs::all();
        return view('generate_annual_bonus.annual_bonus_report',compact('branch'));
    }
}