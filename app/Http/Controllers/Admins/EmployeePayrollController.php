<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Payroll;
use Faker\Calculator\Inn;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\NationalSocialSecurityFund;
use App\Repositories\Admin\PayrollRepository;
use Spatie\LaravelIgnition\Http\Controllers\HealthCheckController;

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
        return view('payrolls.index',compact('data','user'));
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
        // try{
            // get exchang rate
            $exChange= ExchangeRate::first();
            $amount_exchang =  $exChange->amount_riel;

            // $nowTimeDate = Carbon::now()->format('m');
            // dd($nowTimeDate == 05);

            // $employee = User::where('id',$request->employee_id)->where('emp_status',1)->first();
            // $months = Carbon::now()->diffInMonths($employee->fdc_date);
            // dd($months);

            //National Social Security Fund (NSSF) Formula
            $totalExchangeRielPreTax =  $amount_exchang * $request->net_salary;
            if ($totalExchangeRielPreTax >= 1200000) {
                $AverageWage    = 1200000;
            }else if($totalExchangeRielPreTax >= 400000){
                $AverageWage    = $totalExchangeRielPreTax;
            }
            $OccupationalRisk = (0.008 * $totalExchangeRielPreTax);
            $HealthCare = (0.026 * $totalExchangeRielPreTax);
            $WorkerContribution_usd = ($AverageWage * 0.02);
            $WorkerContribution_riel = (round($WorkerContribution_usd, -2) / $amount_exchang);
            // $dataNSSF = NationalSocialSecurityFund::create([
            //     'employee_id'   => $request->employee_id,
            //     'total_pre_tax_salary_usd'   => number_format($request->net_salary, 2),
            //     'total_pre_tax_salary_riel'   => number_format($totalExchangeRielPreTax),
            //     'total_average_wage'   => number_format($AverageWage),
            //     'total_occupational_risk'   => round($OccupationalRisk, -2),
            //     'total_health_care'   => round($HealthCare, -2),
            //     'pension_contribution_usd'   => round($WorkerContribution_usd, -2),
            //     'pension_contribution_riel'   => round($WorkerContribution_riel, 2),
            //     'corporate_contribution'   => round($WorkerContribution_usd, -2),
            //     'created_by'   => Auth::user()->id,
            // ]);

            //total NSSF
            $pension_contribution = '5.9';
            // $pension_contribution = $dataNSSF->pension_contribution_riel;
            
            //calculated khmer_new_year and pchumBen_bonus
            $employee = User::where('id',$request->employee_id)->first();
            $userJoinDate = $employee->date_of_commencement;
            $days = Carbon::now()->diffInDays($userJoinDate);
            dd($days);
            $years = Carbon::now()->diffInYears($userJoinDate);
            $dayOf365 = 365;
            if($request->khmer_new_year_pchum_ben_allowance != null){
                if ($years == 0) {
                    $totalSalaryDay = ($request->net_salary * $days) / $dayOf365;
                    $totalSalaryKhmerPchumBen = $totalSalaryDay + $request->net_salary;
                } else {
                    $percentSalary = ($request->net_salary * $request->khmer_new_year_pchum_ben_allowance) / 100;
                    $totalSalaryKhmerPchumBen = $percentSalary + $request->net_salary;
                }
            }
            
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
                $totalPaseSsalaryReceivedUsd = $totalSalaryKhmerPchumBen + $request->phone_allowance + $request->monthly_quarterly_bonuses + $request->annual_incentive_bonus + $request->other_allowances + $totalAmountChild - $pension_contribution;
            } else {
                $totalPaseSsalaryReceivedUsd = $request->net_salary + $request->phone_allowance + $request->monthly_quarterly_bonuses + $request->annual_incentive_bonus + $request->other_allowances + $totalAmountChild - $pension_contribution;
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
            $role_id = $employee->role_id;

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
            $data['employee_id']    = $request->employee_id;
            $data['role_id']    = $role_id;
            $data['net_salary']    = number_format($request->net_salary,2);
            $data['payment_amount']    = number_format($request->net_salary,2);
            $data['children']    = $children;
            $data['total_gross_salary']    = number_format($request->net_salary,2);
            $data['total_child_allowance']    = $totalAmountChild;
            $data['phone_allowance']    = $request->phone_allowance;
            $data['monthly_quarterly_bonuses']    = $request->monthly_quarterly_bonuses;
            $data['khmer_new_year_pchum_ben_allowance']    = $request->khmer_new_year_pchum_ben_allowance;
            $data['annual_incentive_bonus']    = $request->annual_incentive_bonus;
            $data['base_salary_received_usd']    = number_format($totalPaseSsalaryReceivedUsd,2);
            $data['base_salary_received_riel']    = number_format($totalExchangeRiel);
            $data['tax_base_riel']    = number_format($totalTtaxBbaseRiel);
            $data['total_charges_reduced']    = number_format($totalChargesReduced);
            $data['total_rate']    = $totalTax;
            $data['total_salary_tax_riel']    = number_format($totalSalaryTaxRiel);
            $data['total_salary_tax_usd']    = $totalSalaryTaxUsd;
            $data['total_salary']    = round($totalSalaryAfterTax,2);
            $data['created_by']    = Auth::user()->id;

            Payroll::create($data);
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
}
