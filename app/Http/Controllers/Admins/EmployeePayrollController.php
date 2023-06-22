<?php

namespace App\Http\Controllers\Admins;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Models\ExchangeRate;
use App\Models\SeverancePay;
use Illuminate\Http\Request;
use App\Models\ChildrenInfor;
use App\Models\GrossSalaryPay;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\NationalSocialSecurityFund;
use App\Repositories\Admin\PayrollRepository;

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
        $dataSeniority   = Seniority::with('users')->get();
        $exChangeRate= ExchangeRate::first();
        return view('payrolls.index',compact('data','user','dataNSSF','dataSeniority','exChangeRate'));
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
        // $severancePay = Payroll::where('employee_id',2)->get();
        // dd($severancePay);
        // $data = $this->payrollRepo->createPayroll($request);
        
        // try{
            // get exchang rate
            // $exChange= ExchangeRate::first();
            // $request->exchange_rate =  $exChange->amount_riel;
            
            $employee = User::where('date_of_commencement','<=',$request->payment_date)->whereIn('emp_status',['Probation','1','2'])->get();
            foreach ($employee as $item) {

                //function first month join work
                if (count(Payroll::where('employee_id',$item->id)->get()) == 0) {
                    //total day in months
                    $currentYear = Carbon::createFromDate($item->date_of_commencement)->format('Y-m');
                    $begin = new DateTime($currentYear.'-'.'01');
                    
                    //total day in months
                    $endMonth = Carbon::createFromDate($item->date_of_commencement)->format('m');
                    $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                    $end = new DateTime($currentYear.'-'.$totalDayInMonth);

                    $end = $end->modify('+1 day');
                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval, $end);

                    $holidays = [];
                    foreach ($daterange as $date) {
                        $sunday = date('w', strtotime($date->format("Y-m-d")));
                        if ($sunday == 0) {
                            $holidays[] = $date->format("Y-m-d");
                        } else {
                            echo'';
                        }
                    }
                    // dd($holidays);
                    $startDate = Carbon::parse($item->date_of_commencement);
                    $endDate = Carbon::parse($currentYear.'-'.$totalDayInMonth);
                    // dd($endDate);
                    $totalDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($holidays) {
                        return $date->isWeekday() && !in_array($date, $holidays);
                    }, $endDate) + 1;
                    $totalBasicSalary = $totalDays * ($item->basic_salary / 22);
                } else {
                    $totalBasicSalary = $item->basic_salary;
                }

                //National Social Security Fund (NSSF) Formula
                $totalExchangeRielPreTax =  $request->exchange_rate * round($totalBasicSalary, 2);
                if ($totalExchangeRielPreTax) {
                    if ($totalExchangeRielPreTax >= 1200000) {
                        $AverageWage    = 1200000;
                    }else if($totalExchangeRielPreTax >= 400000){
                        $AverageWage    = $totalExchangeRielPreTax;
                    }else{
                        $AverageWage = 400000;
                    }
                }else{
                    $AverageWage = 0;
                }
                
                $OccupationalRisk = (0.008 * $AverageWage);
                $HealthCare = (0.026 * $AverageWage);
                $WorkerContribution_usd = ($AverageWage * 0.02);
                $WorkerContribution_riel = (round($WorkerContribution_usd, -2) / $request->exchange_rate);
                $dataNSSF = NationalSocialSecurityFund::create([
                    'employee_id'   => $item->id,
                    'total_pre_tax_salary_usd'   => number_format($totalBasicSalary, 2),
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
                $totalBunus = 0;
                if ($item->emp_status == 1) {
                    $userJoinDate = $item->date_of_commencement;
                    $totdayDays = Carbon::now()->diffInDays($userJoinDate) + 1;
                    $years = Carbon::now()->diffInYears($userJoinDate);
                    $dayOf365 = 365;
                    $periodDate = '';
                    $totalFromDate= '';
                    $dataHolidayBunuse = Holiday::all();
                    foreach ($dataHolidayBunuse as $value) {
                        $periodDate = Carbon::parse($value->period_month);
                        $totalFromDate = Carbon::parse($value->from);
                        $totalDaysBunuse = $periodDate->diffInDays($totalFromDate) - 1;

                        $days = $totdayDays + $totalDaysBunuse;
                        if ($value->period_month == $request->payment_date) {
                            if ($years != 0) {
                                $percent = $value->amount_percent / 100;
                                $totalAllowance = ($totalBasicSalary * $percent);
                            } else {
                                $percent = $value->amount_percent / 100;
                                $totalPercent = ($totalBasicSalary * $percent);
                                $percentSalary = $totalPercent * $days;
                                $totalAllowance = $percentSalary / $dayOf365;
                            }
                            $dataBonus = Bonus::create([
                                'employee_id'   => $item->id,
                                'number_of_working_days'    => $days,
                                'base_salary'   => $totalBasicSalary,
                                'base_salary_received'  => $totalBasicSalary,
                                'total_allowance'   => $totalAllowance,
                                'bouns_type'   => $value->title,
                                'created_by'    => Auth::user()->id,
                            ]);
                        }
                        $totalBunus = $dataBonus->total_allowance ?? 0;
                    }
                }
                // dd($totalBunus);

                // sum benefit children < 18
                $dataDateOfBirth = [];
                $dataChildren = ChildrenInfor::where('employee_id',$item->id)->get();
                foreach ($dataChildren as $value) {
                    $yearsOfChild = Carbon::parse($value->date_of_birth)->age;
                    if ($yearsOfChild <= 18) {
                        $dataDateOfBirth[] = $value;
                    }
                }
                
                $number_of_children = count($dataDateOfBirth);
                if ($number_of_children) {
                    if ($number_of_children == null) {
                        $totalAmountChild = 0;
                    } else if($number_of_children == 1) {
                        $totalAmountChild = 10;
                    }else if($number_of_children == 2){
                        $totalAmountChild = 20;
                    }else if($number_of_children == 3){
                        $totalAmountChild = 30;
                    }else if($number_of_children == 4){
                        $totalAmountChild = 40;
                    }
                }else{
                    $totalAmountChild = 0;
                }
                
                $grossSalary = $totalBasicSalary + $totalBunus + $item->phone_allowance + $totalAmountChild - $pension_contribution;
                $dataGrossSalary = GrossSalaryPay::create([
                    'employee_id'           => $item->id,
                    'basic_salary'          => number_format($totalBasicSalary,2),
                    'total_gross_salary'    => $grossSalary,
                    'payment_date'          => $request->payment_date,
                    'created_by'            => Auth::user()->id
                ]);

                //function Seniority pay
                $PaymentOfMonth = Carbon::parse($request->payment_date)->format('M-Y');
                if ($item->emp_status == 2) {
                    $currentDate = Carbon::createFromDate($request->payment_date)->format('m');
                    if ($currentDate == 6 || $currentDate == 12) {
                        // $nextYear = Carbon::createFromDate($item->fdc_date)->format('Y');
                        $nextYear = Carbon::now()->format('Y');
                        $currentYear = null;
                        $currentMonth = null;
                        $preYear = Carbon::createFromDate($item->fdc_end)->format('Y');
                        if($currentDate == 6){
                            if ($preYear == $nextYear) {
                                $currentYear = $item->fdc_end;
                            }else{
                                $currentYear =  Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d');
                            }
                        }
                        if ($currentDate == 12) {
                            $currentMonth = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
                        }
                        
                        $totalSalary = GrossSalaryPay::where('employee_id', $item->id)->when($currentYear ,function ($query, $fdc_end) {
                            $query->where('payment_date', '>=',$fdc_end);
                        })->when($currentMonth, function($query, $currentMonth){
                            $query->where('payment_date', '>=',$currentMonth);
                        })->pluck('total_gross_salary')->avg();

                        $totalSalaryReceive = ($totalSalary / 22) * 7.5;
                        $totaltaxableSalary = $totalSalaryReceive - $totalSalaryReceive;
                        $paymentOfMonth = $PaymentOfMonth;
                        $seniority = Seniority::create([
                            'employee_id'   => $item->id,
                            'total_average_salary'  => $totalSalary,
                            'total_salary_receive'  => round($totalSalaryReceive, 2),
                            'tax_exemption_salary'  => round($totalSalaryReceive, 2),
                            'taxable_salary'        => $totaltaxableSalary,
                            'payment_of_month'        => $paymentOfMonth,
                            'created_by'        => Auth::user()->id,
                        ]);
                        $totalSeniority = $seniority->taxable_salary ?? 0;
                    }
                }
                
                //sum salary and sum other benefit
                $totalGrossSalary = $dataGrossSalary->total_gross_salary;

                //total exchange rate
                $totalExchangeRiel =  $request->exchange_rate * $totalGrossSalary;
                
                //total that បូកបន្ថែមលើបន្ទុកកូននិងប្រពន្ធ
                $totalChargesReducedChild = 150000;
                $totalChargesReducedSpouse = 150000;
                //not have child and sposes child 1
                if($number_of_children == null && $item->spouse == null){
                    $totalChargesReduced = 0;
                }else if($number_of_children == null && $item->spouse == null){
                    $totalChargesReduced = $totalChargesReducedSpouse;
                }else if($number_of_children == 1 && $item->spouse == null){
                    $totalChargesReduced = $totalChargesReducedChild;
                }else if($number_of_children == null && $item->spouse == 1){
                    $totalChargesReduced = $totalChargesReducedSpouse;
                }else if($number_of_children == 1 && $item->spouse == 1){
                    $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                }else if($number_of_children == 2 && $item->spouse == null){
                    $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
                }else if($number_of_children == 2 && $item->spouse == 1){
                    $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                }else if($number_of_children == 3 && $item->spouse == null){
                    $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
                }else if($number_of_children == 3 && $item->spouse == 1){
                    $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                }else if($number_of_children == 4 && $item->spouse == null){
                    $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
                }else if($number_of_children == 4 && $item->spouse == 1){
                    $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                }

                // dd($totalChargesReduced);

                //កាត់មូលដ្ឋានគិតពន្ធ
                if ($number_of_children == null && $item->spouse == null) {
                    $totalTtaxBbaseRiel = $totalExchangeRiel;
                } else if($number_of_children == 1 && $item->spouse == null) {
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == null && $item->spouse == 1) {
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == 1 && $item->spouse == 1) {
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == 2 &&  $item->spouse == null){
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == 2 &&  $item->spouse == 1){
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == 3 &&  $item->spouse == null){
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == 3 &&  $item->spouse == 1){
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == 4 &&  $item->spouse == null){
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }else if($number_of_children == 4 &&  $item->spouse == 1){
                    $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                }

                $children = $number_of_children;

                // អត្រា ពន្ធ(%)
                if ($number_of_children == null && $item->spouse == null) {
                    
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);

                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                } else if($number_of_children == 1 && $item->spouse == null) {

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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate, 2);

                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;

                }else if($number_of_children == 1 && $item->spouse == 1) {
        
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);
                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                }else if($number_of_children == 2 && $item->spouse == null){
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);
                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                }else if($number_of_children == 2 && $item->spouse == 1){
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);
                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                }else if($number_of_children == 3 && $item->spouse == null){
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);
                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                }else if($number_of_children == 3 && $item->spouse == 1){
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);
                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                }else if($number_of_children == 4 && $item->spouse == null){
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);
                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                }else if($number_of_children == 4 && $item->spouse == 1){
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
                    $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $request->exchange_rate,2);
                    //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                    $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
                }

                //function Severance Pay
                if ($item->emp_status == 1) {
                    $severancePay = GrossSalaryPay::where('employee_id',$item->id)->get();
                    if (count($severancePay) == 15) {
                        $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->where('payment_date', '>=',$item->fdc_date)->sum('total_gross_salary');
                        $totalContractSeverancePay = $dataSeveranc * 0.05;
                        $dataSeverance = SeverancePay::create([
                            'employee_id'                   => $item->id,
                            'total_severanec_pay'           => $dataSeveranc,
                            'total_contract_severance_pay'  => $totalContractSeverancePay,
                            'created_by'                    => Auth::user()->id,
                        ]);
                        $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
                    }else{
                        $totalSeverancePay = 0;
                    }
                }else{
                    $totalSeverancePay = 0;
                }
                
                $totalNetSalary = $totalSalaryAfterTax + $totalSeverancePay;

                $data   = $request->all();
                $data['employee_id']                    = $item->id;
                $data['basic_salary']                   = number_format($totalBasicSalary,2);
                $data['children']                       = $children;
                $data['total_gross_salary']             = number_format($grossSalary,2);
                $data['total_child_allowance']          = $totalAmountChild;
                $data['phone_allowance']                = $item->phone_allowance;
                $data['base_salary_received_usd']       = number_format($totalGrossSalary,2);
                $data['base_salary_received_riel']      = number_format($totalExchangeRiel);
                $data['total_tax_base_riel']            = number_format($totalTtaxBbaseRiel);
                $data['total_charges_reduced']          = number_format($totalChargesReduced);
                $data['total_rate']                     = $totalTax;
                $data['total_salary_tax_riel']          = number_format($totalSalaryTaxRiel);
                $data['total_salary_tax_usd']           = $totalSalaryTaxUsd;
                $data['total_salary']                   = round($totalNetSalary,2);
                $data['created_by']                     = Auth::user()->id;
                Payroll::create($data);
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
        $payslip = Payroll::with('users')->with('bunus')->with('NSSF')->with('seniority')->with('severancePay')
        ->where('employee_id',$request->employee_id)->first();
        return view('payrolls.payslip',compact('payslip'));
    }
}
