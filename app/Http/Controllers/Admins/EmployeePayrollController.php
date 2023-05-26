<?php

namespace App\Http\Controllers\Admins;

use DateTime;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\NationalSocialSecurityFund;
use App\Repositories\Admin\PayrollRepository;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Averages;
use Illuminate\Support\Facades\Date;

class EmployeePayrollController extends Controller
{
    private $payrollRepo;
    public function __construct(PayrollRepository $payrollRepo)
    {
        $this->payrollRepo = $payrollRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->payrollRepo->getAllPayroll($request);
        $user = User::all();
        $dataNSSF   = NationalSocialSecurityFund::with('users')->get();
        return view('payrolls.index',compact('data','user','dataNSSF'));
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
        // $currentDate= Carbon::createFromDate($request->payment_date)->format('m');
        // if ($currentDate == 6 || $currentDate == 12) {
        //     $nextYear = Carbon::createFromDate($request->payment_date)->format('Y');
        //     $currentYear = null;
        //     $currentMonth = null;
        //     $employee = User::where('id',$request->employee_id)->first();
        //     $preYear = Carbon::createFromDate($employee->fdc_date)->format('Y');
        //     if($currentDate == 6){
        //         if ($preYear == $nextYear) {
        //             $currentYear = $employee->fdc_date;
        //         }else{
        //             $currentYear =  Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d') ;
        //         }
        //     }

        //     if ($currentDate == 12) {
        //         $currentMonth = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
        //     }
            
        //     $totalSalary = Payroll::where('employee_id', $request->employee_id)->when($currentYear ,function ($query, $fdc_date) {
        //         $query->where('payment_date', '>=',$fdc_date);
        //     })->when($currentMonth, function($query, $currentMonth){
        //         $query->where('payment_date', '>=',$currentMonth);
        //     })->pluck('total_gross_salary')->avg();
        // }

        // try{
            // get exchang rate
            $exChange= ExchangeRate::first();
            $amount_exchang =  $exChange->amount_riel;

            // $nowTimeDate = Carbon::now()->format('m');
            // dd($nowTimeDate == 05);
            
            // $employee = User::where('id',$request->employee_id)->where('emp_status','1')->first();
            // if ($employee->fdc_date != null) {
            //     $Ldate = new DateTime($employee->fdc_date);
            //     $totalLdate = (int)$Ldate->format('d');
            //     $payrolle = Payroll::where('employee_id',$request->employee_id)->first();
            //     if($totalLdate >= 1 || $totalLdate <= 15){
            //         $totalSalaryPrevious = $payrolle->basic_salary / 2;
            //     }
            //     $sDate = Carbon::now()->diffInDays($employee->fdc_date);
            //     dd($sDate);
            //     if ($sDate <= 30) {
            //         $totalSalaryCurrent  = $request->basic_salary / 2;
            //     }
            //     dd($totalSalaryCurrent);
            // }
         
           
            //National Social Security Fund (NSSF) Formula
            $totalExchangeRielPreTax =  $amount_exchang * $request->basic_salary;
            if ($totalExchangeRielPreTax >= 1200000) {
                $AverageWage    = 1200000;
            }else if($totalExchangeRielPreTax >= 400000){
                $AverageWage    = $totalExchangeRielPreTax;
            }else{
                $AverageWage = 400000;
            }
            $OccupationalRisk = (0.008 * $totalExchangeRielPreTax);
            $HealthCare = (0.026 * $totalExchangeRielPreTax);
            $WorkerContribution_usd = ($AverageWage * 0.02);
            $WorkerContribution_riel = (round($WorkerContribution_usd, -2) / $amount_exchang);
            $dataNSSF = NationalSocialSecurityFund::create([
                'employee_id'   => $request->employee_id,
                'total_pre_tax_salary_usd'   => number_format($request->basic_salary, 2),
                'total_pre_tax_salary_riel'   => number_format($totalExchangeRielPreTax),
                'total_average_wage'   => number_format($AverageWage),
                'total_occupational_risk'   => number_format($OccupationalRisk),
                'total_health_care'   => number_format($HealthCare),
                'pension_contribution_usd'   => number_format($WorkerContribution_usd),
                'pension_contribution_riel'   => round($WorkerContribution_riel, 2),
                'corporate_contribution'   => number_format($WorkerContribution_usd),
                'created_by'   => Auth::user()->id,
            ]);

            //total NSSF
            // $pension_contribution = '5.9';
            $pension_contribution = $dataNSSF->pension_contribution_riel;
            
            //calculated khmer_new_year and pchumBen_bonus
            $employee = User::where('id',$request->employee_id)->first();
            $userJoinDate = $employee->date_of_commencement;
            $days = Carbon::now()->diffInDays($userJoinDate) + 1;
            $years = Carbon::now()->diffInYears($userJoinDate);
            $dayOf365 = 365;
            $totalBunusKHBun = 0;
            if($request->khmer_new_year_pchum_ben_allowance != null){
                if ($years != 0) {
                    $percent = $request->khmer_new_year_pchum_ben_allowance / 100;
                    $totalAllowance = ($request->basic_salary * $percent);
                } else {
                    $percent = $request->khmer_new_year_pchum_ben_allowance / 100;
                    $totalPercent = ($request->basic_salary * $percent);
                    $percentSalary = $totalPercent * $days;
                    $totalAllowance = $percentSalary / $dayOf365;
                }
                $bonus = Bonus::create([
                    'employee_id'   => $request->employee_id,
                    'number_of_working_days'    => $days,
                    'base_salary'   => $request->basic_salary,
                    'base_salary_received'  => $request->basic_salary,
                    'total_allowance'   => $totalAllowance,
                    'created_by'    => Auth::user()->id,
                ]);
                $totalBunusKHBun = $bonus;
            }
            
            $totalBunus = $totalBunusKHBun;
            // sum benefit children
            if ($employee->number_of_children == null) {
                $totalAmountChild = 0;
            } else if($employee->number_of_children == 1) {
                $totalAmountChild = 10;
            }else if($employee->number_of_children == 2){
                $totalAmountChild = 20;
            }else if($employee->number_of_children == 3){
                $totalAmountChild = 30;
            }else if($employee->number_of_children == 4){
                $totalAmountChild = 40;
            }
    
            //sum salary and sum other benefit
            if ($request->khmer_new_year_pchum_ben_allowance != null) {
                $totalPaseSsalaryReceivedUsd = $request->basic_salary + $totalBunus->total_allowance + $request->phone_allowance + $request->monthly_quarterly_bonuses + $request->annual_incentive_bonus + $request->other_allowances + $totalAmountChild - $pension_contribution;
            } else {
                $totalPaseSsalaryReceivedUsd = $request->basic_salary + $request->phone_allowance + $request->monthly_quarterly_bonuses + $request->annual_incentive_bonus + $request->other_allowances + $totalAmountChild - $pension_contribution;
            }

            //total exchange rate
            $totalExchangeRiel =  $amount_exchang * $totalPaseSsalaryReceivedUsd;
            
            //total that បូកបន្ថែមលើបន្ទុកកូននិងប្រពន្ធ
            $totalChargesReducedChild = 150000;
            $totalChargesReducedSpouse = 150000;
            // dd($employee->number_of_children * $totalChargesReducedChild);
            //not have child and sposes child 1
            if($employee->number_of_children == null && $request->spouse == null){
                $totalChargesReduced = 0;
            }else if($employee->number_of_children == null && $request->spouse == null){
                $totalChargesReduced = $totalChargesReducedSpouse;
            }else if($employee->number_of_children == 1 && $request->spouse == null){
                $totalChargesReduced = $totalChargesReducedChild;
            }else if($employee->number_of_children == null && $request->spouse == 1){
                $totalChargesReduced = $totalChargesReducedSpouse;
            }else if($employee->number_of_children == 1 && $request->spouse == 1){
                $totalChargesReduced = ($employee->number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
            }else if($employee->number_of_children == 2 && $request->spouse == null){
                $totalChargesReduced = $employee->number_of_children * $totalChargesReducedChild;
            }else if($employee->number_of_children == 2 && $request->spouse == 1){
                $totalChargesReduced = ($employee->number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
            }else if($employee->number_of_children == 3 && $request->spouse == null){
                $totalChargesReduced = $employee->number_of_children * $totalChargesReducedChild;
            }else if($employee->number_of_children == 3 && $request->spouse == 1){
                $totalChargesReduced = ($employee->number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
            }else if($employee->number_of_children == 4 && $request->spouse == null){
                $totalChargesReduced = $employee->number_of_children * $totalChargesReducedChild;
            }else if($employee->number_of_children == 4 && $request->spouse == 1){
                $totalChargesReduced = ($employee->number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
            }

            // dd($totalChargesReduced);

            //កាត់មូលដ្ឋានគិតពន្ធ
            if ($employee->number_of_children == null && $request->spouse == null) {
                $totalTtaxBbaseRiel = $totalExchangeRiel;
            } else if($employee->number_of_children == 1 && $request->spouse == null) {
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == null && $request->spouse == 1) {
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == 1 && $request->spouse == 1) {
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == 2 &&  $request->spouse == null){
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == 2 &&  $request->spouse == 1){
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == 3 &&  $request->spouse == null){
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == 3 &&  $request->spouse == 1){
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == 4 &&  $request->spouse == null){
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }else if($employee->number_of_children == 4 &&  $request->spouse == 1){
                $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
            }
            // dd($totalTtaxBbaseRiel);
            $children = $employee->number_of_children;

            // អត្រា ពន្ធ(%)
            if ($employee->number_of_children == null && $request->spouse == null) {
                
                if($totalExchangeRiel >= 0 && $totalExchangeRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalExchangeRiel >= 1500001 && $totalExchangeRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalExchangeRiel >= 2000001 && $totalExchangeRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalExchangeRiel >= 8500001 && $totalExchangeRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
        
                //​cululate salaray Taxable
                if($totalExchangeRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalExchangeRiel > 1500001 && $totalExchangeRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 75000;
                }elseif($totalExchangeRiel > 2000001 && $totalExchangeRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 175000;
                }elseif($totalExchangeRiel > 8500001 && $totalExchangeRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 1225000;
                }

                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);

                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            } else if($employee->number_of_children == 1 && $request->spouse == null) {

                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }

                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang, 2);

                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;

            }else if($employee->number_of_children == 1 && $request->spouse == 1) {
    
                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                // dd($totalTax);
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }
                // dd($totalSalaryTaxRiel);
                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            }else if($employee->number_of_children == 2 && $request->spouse == null){
                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                // dd($totalTax);
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }
                // dd($totalSalaryTaxRiel);
                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            }else if($employee->number_of_children == 2 && $request->spouse == 1){
                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                // dd($totalTax);
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }
                // dd($totalSalaryTaxRiel);
                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            }else if($employee->number_of_children == 3 && $request->spouse == null){
                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                // dd($totalTax);
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }
                // dd($totalSalaryTaxRiel);
                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            }else if($employee->number_of_children == 3 && $request->spouse == 1){
                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                // dd($totalTax);
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }
                // dd($totalSalaryTaxRiel);
                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            }else if($employee->number_of_children == 4 && $request->spouse == null){
                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                // dd($totalTax);
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }
                // dd($totalSalaryTaxRiel);
                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            }else if($employee->number_of_children == 4 && $request->spouse == 1){
                if($totalTtaxBbaseRiel >= 0 && $totalTtaxBbaseRiel <= 1500000){
                    $totalTax = 0;
                }elseif($totalTtaxBbaseRiel >= 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalTax = 5;
                }elseif($totalTtaxBbaseRiel >= 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalTax = 10;
                }elseif($totalTtaxBbaseRiel >= 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalTax = 15;
                }else{
                    $totalTax = 20;
                }
                // dd($totalTax);
                //​cululate salaray Taxable
                if($totalTtaxBbaseRiel <= 1500000){
                    $totalSalaryTaxRiel = 0;
                }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
                }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
                }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
                }else{
                    $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
                }
                // dd($totalSalaryTaxRiel);
                //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
                //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                $totalSalaryAfterTax = $totalPaseSsalaryReceivedUsd - $totalSalaryTaxUsd;
            }
            // dd($children);

            $data   = $request->all();
            $data['employee_id']                    = $request->employee_id;
            $data['basic_salary']                   = number_format($request->basic_salary,2);
            $data['payment_amount']                 = 0;
            $data['payment_date']                   = $request->payment_date;
            $data['children']                       = $children;
            $data['total_gross_salary']             = number_format($request->basic_salary,2);
            $data['total_child_allowance']          = $totalAmountChild;
            $data['phone_allowance']                = $request->phone_allowance;
            $data['monthly_quarterly_bonuses']      = $request->monthly_quarterly_bonuses;
            $data['annual_incentive_bonus']         = $request->annual_incentive_bonus;
            $data['base_salary_received_usd']       = number_format($totalPaseSsalaryReceivedUsd,2);
            $data['base_salary_received_riel']      = number_format($totalExchangeRiel);
            $data['tax_base_riel']                  = number_format($totalTtaxBbaseRiel);
            $data['total_charges_reduced']          = number_format($totalChargesReduced);
            $data['total_rate']                     = $totalTax;
            $data['total_salary_tax_riel']          = number_format($totalSalaryTaxRiel);
            $data['total_salary_tax_usd']           = $totalSalaryTaxUsd;
            $data['total_salary']                   = round($totalSalaryAfterTax,2);
            $data['created_by']                     = Auth::user()->id;

            $payrolle = Payroll::create($data);

            //function create Seniority
            if ($payrolle) {
                $monthForPayment = Carbon::parse($request->payment_date)->format('M');
                $employee = User::where('id',$request->employee_id)->first();
                $totalSeniority = 0;
                if ($employee->emp_status == 1) {

                    $currentDate= Carbon::createFromDate($request->payment_date)->format('m');
                    if ($currentDate == 6 || $currentDate == 12) {
                        $nextYear = Carbon::createFromDate($request->payment_date)->format('Y');
                        $currentYear = null;
                        $currentMonth = null;
                        $preYear = Carbon::createFromDate($employee->fdc_date)->format('Y');
                        if($currentDate == 6){
                            if ($preYear == $nextYear) {
                                $currentYear = $employee->fdc_date;
                            }else{
                                $currentYear =  Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d') ;
                            }
                        }
            
                        if ($currentDate == 12) {
                            $currentMonth = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
                        }
                        
                        $totalSalary = Payroll::where('employee_id', $request->employee_id)->when($currentYear ,function ($query, $fdc_date) {
                            $query->where('payment_date', '>=',$fdc_date);
                        })->when($currentMonth, function($query, $currentMonth){
                            $query->where('payment_date', '>=',$currentMonth);
                        })->pluck('total_gross_salary')->avg();
                        $totalSalary = ($totalSalary / 22) * 7.5;
                        $totaltaxableSalary = $totalSalary - $totalSalary;
                        $paymentOfMonth = $monthForPayment;
                        $seniority = Seniority::create([
                            'employee_id'   => $request->employee_id,
                            'total_average_salary'  => $totalSalary,
                            'total_salary_receive'  => round($totalSalary, 2),
                            'tax_exemption_salary'  => round($totalSalary, 2),
                            'taxable_salary'        => $totaltaxableSalary,
                            'payment_of_month'        => $paymentOfMonth,
                            'created_by'        => Auth::user()->id,
                        ]);
                        $dataSeniority = $seniority;
                        $totalSeniority = $dataSeniority->total_salary_receive ?? 0;
                        $totalNetSalary = $totalSeniority + $payrolle->total_salary;
                        Payroll::where('id',$payrolle->id)->update([
                            'total_salary'  => $totalNetSalary, 
                        ]);
                    }
                }
            }
            //end function create Seniority
            Toastr::success('Created prayroll successfully.','Success');
            return redirect()->back();
            DB::commit();
        // }catch(\Exception $e){
        //     DB::rollback();
        //     Toastr::error('prayroll created fail','Error');
        //     return redirect()->back();
        // }
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

    public function paySlip(Request $request){
        $payslip = Payroll::with('users')->with('bunus')->with('NSSF')
        ->where('employee_id',$request->employee_id)->first();
        return view('payrolls.payslip',compact('payslip'));
    }
}
