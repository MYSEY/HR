<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportEmployeeSalary;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Taxes;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Models\ExchangeRate;
use App\Models\SeverancePay;
use Illuminate\Http\Request;
use App\Models\ChildrenInfor;
use App\Models\GrossSalaryPay;
use Illuminate\Support\Carbon;
use App\Models\ChildrenAllowance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Branchs;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\NationalSocialSecurityFund;
use App\Repositories\Admin\PayrollRepository;
use Maatwebsite\Excel\Facades\Excel;

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
        $branch = Branchs::all();
        $exChangeRate= ExchangeRate::orderBy('id', 'desc')->first();
        return view('payrolls.index',compact('data','user','branch','exChangeRate'));
    }

    public function search(Request $request) {
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll = Payroll::with("users")
        ->join('users', 'payrolls.employee_id', '=', 'users.id')
        ->select(
            'payrolls.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.branch_id',
        )
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('users.branch_id', $branch_id);
        })
        ->when($Monthly, function ($query, $Monthly) {
            $query->whereMonth('payment_date', $Monthly);
        })
        ->when($yearLy, function ($query, $yearLy) {
            $query->whereYear('payment_date', $yearLy);
        })->get();
        return response()->json([
            'success'=>$payroll,
        ]);
    }

    public function export(Request $request) {
        return Excel::download(new ExportEmployeeSalary($request), 'EmployeeSalary.xlsx');
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
            $employee = User::where('date_of_commencement','<=',$request->payment_date)->whereIn('emp_status',['Probation','1','10','2'])->get();
            if (!$employee->isEmpty()) {
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
                        foreach ($daterange ?? [] as $date) {
                            $sunday = date('w', strtotime($date->format("Y-m-d")));
                            if ($sunday == 0) {
                                $holidays[] = $date->format("Y-m-d");
                            } else {
                                echo '';
                            }
                        }
                        $startDate = Carbon::parse($item->date_of_commencement);
                        $endDate = Carbon::parse($currentYear.'-'.$totalDayInMonth);
                        $toDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($holidays) {
                            return $date->isWeekday() && !in_array($date, $holidays);
                        }, $endDate) + 1;
                        
                        if(count($holidays) == 4){
                            $totalDays = $toDays;
                        }else if(count($holidays) == 3){
                            $totalDays = $toDays + 1;
                        }else{
                            $totalDays = $toDays + 1;
                        }
                   
                        if ($totalDays >= 22) {
                            $totalBasicSalary = $item->basic_salary;
                        }else{
                            $totalBasicSalary = ($item->basic_salary / 22) * $totalDays;
                        }
                    } else {
                        $monthToPay = Carbon::createFromDate($item->fdc_date)->format('Y-m');
                        $currentMonthToPay = Carbon::createFromDate($request->payment_date)->format('Y-m');
                        if($monthToPay == $currentMonthToPay){
                            $totalBasicSalary = $item->total_current_salary == null ? $item->basic_salary : $item->total_current_salary;
                        }else{
                            $totalBasicSalary = $item->basic_salary;
                        }
                    }
                    // dd($totalBasicSalary);
                    //National Social Security Fund (NSSF) Formula
                    $totalExchangeRielPreTax =  $request->exchange_rate * round($totalBasicSalary, 2);
                    
                    if ($totalExchangeRielPreTax) {
                        if ($totalExchangeRielPreTax >= 1200000) {
                            $averageWage    = 1200000;
                        }else if($totalExchangeRielPreTax >= 400000){
                            $averageWage    = $totalExchangeRielPreTax;
                        }else{
                            $averageWage = 400000;
                        }
                    }else{
                        $averageWage = 0;
                    }
                    
                    $occupationalRisk = (0.008 * $averageWage);
                    $healthCare = (0.026 * $averageWage);
                    $workerContributionUsd = ($averageWage * 0.02);
                    $workerContributionRiel = (round($workerContributionUsd, -2) / $request->exchange_rate);
                    $dataNSSF = NationalSocialSecurityFund::create([
                        'employee_id'   => $item->id,
                        'total_pre_tax_salary_usd'   => number_format($totalBasicSalary, 2),
                        'total_pre_tax_salary_riel'   => number_format($totalExchangeRielPreTax),
                        'total_average_wage'   => number_format($averageWage),
                        'total_occupational_risk'   => number_format($occupationalRisk),
                        'total_health_care'   => number_format($healthCare),
                        'pension_contribution_usd'   => number_format($workerContributionUsd),
                        'pension_contribution_riel'   => number_format($workerContributionRiel, 2),
                        'corporate_contribution'   => number_format($workerContributionUsd),
                        'created_by'   => Auth::user()->id,
                    ]);
                    
                    // $pension_contribution = '5.9';
                    $pension_contribution = $dataNSSF->pension_contribution_riel;
                    
                    //calculated khmer_new_year and pchumBen_bonus
                    $totalBunus = 0;
                    if ($item->emp_status == 1 || $item->emp_status == 10 || $item->emp_status == 2) {
                        $dataHolidayBunuse = Holiday::get();
                        foreach ($dataHolidayBunuse as $value) {
                            $userJoinDate = $item->date_of_commencement;
                            $startDate = Carbon::parse()->diffInDays($userJoinDate) + 1;
                            $dayOfYear = 365;
                            $fromDate = Carbon::parse($item->date_of_commencement);
                            $toDate = Carbon::parse($value->from);
                            $totalStartDays = $fromDate->diffInDays($toDate) - 1;
                            if($request->payment_date == $value->period_month){
                                if ($totalStartDays > $dayOfYear) {
                                    $percent = $value->amount_percent / 100;
                                    $totalAllowanceBunus = ($totalBasicSalary * $percent);
                                } else {
                                    $totalPercent = ($totalBasicSalary * $value->amount_percent) / 100;
                                    $percentSalary = $totalPercent * $totalStartDays;
                                    $totalAllowanceBunus = $percentSalary / $dayOfYear;
                                }
                                $dataBonus = Bonus::create([
                                    'employee_id'   => $item->id,
                                    'number_of_working_days'    => $totalStartDays,
                                    'base_salary'   => $totalBasicSalary,
                                    'base_salary_received'  => $totalBasicSalary,
                                    'total_allowance'   => $totalAllowanceBunus,
                                    'bouns_type'   => $value->title,
                                    'created_by'    => Auth::user()->id,
                                ]);
                            }
                            $totalBunus = $dataBonus->total_allowance ?? 0;
                        }
                    }
    
                    // function sum benefit age children <= 18
                    $dataDateOfBirth = [];
                    $dataChildren = ChildrenInfor::where('employee_id',$item->id)->get();
                    foreach ($dataChildren as $value) {
                        $yearsOfChild = Carbon::parse($value->date_of_birth)->age;
                        if ($yearsOfChild <= 18) {
                            $dataDateOfBirth[] = $value;
                        }
                    }
                    
                    //function children allowance
                    $number_of_children = count($dataDateOfBirth);
                    $childrenAllowance = ChildrenAllowance::first();
                    if ($number_of_children) {
                        if ($number_of_children == 0) {
                            $totalAmountChild = 0;
                        } else if($number_of_children == 1) {
                            $totalAmountChild = $childrenAllowance->total_children_allowance * 1;
                        }else if($number_of_children == 2){
                            $totalAmountChild = $childrenAllowance->total_children_allowance * 2;
                        }else if($number_of_children == 3){
                            $totalAmountChild = $childrenAllowance->total_children_allowance * 3;
                        }else if($number_of_children == 4){
                            $totalAmountChild = $childrenAllowance->total_children_allowance * 4;
                        }
                    }else{
                        $totalAmountChild = 0;
                    }
    
                    //calcute severance pay last end 12
                    $totalGrossOne = 0;
                    $totalGrossTwo = 0;
                    if ($item->emp_status == 1 || $item->emp_status == 10) {
                        $dataGrossSalaryPay = GrossSalaryPay::where('employee_id',$item->id)->whereDate('payment_date','>',$item->fdc_date)->whereDate('payment_date','<',$item->fdc_end)->get();
                        if (count($dataGrossSalaryPay) == 12 || count($dataGrossSalaryPay) == 24) {
                            $endMonth = Carbon::createFromDate($item->fdc_end)->format('m');
                            $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                            
                            $date_of_month = Carbon::createFromDate($item->fdc_end)->format('Y-m');
                            $currentYear = $date_of_month.'-'.$totalDayInMonth;
                            
                            // new salary and new total days
                            $startDate = Carbon::parse($item->fdc_end);
                            $endDate = Carbon::parse($currentYear);
                            $totalNewDays = $startDate->diffInDays($endDate) + 1;
                            $totalGrossOne = ($item->basic_salary / $totalDayInMonth) * $totalNewDays;
                            
                            //old salary and total old days
                            $totalOldDay = $totalDayInMonth - $totalNewDays;
                            $totalGrossTwo = ($item->basic_salary / $totalDayInMonth) * $totalOldDay;
                            $totalBasicSalary = $totalGrossOne + $totalGrossTwo;
                        }
                    }
    
                    $GrossSalary = $totalBasicSalary + $totalBunus + $item->phone_allowance + $totalAmountChild;
                    $dataGrossSalary = GrossSalaryPay::create([
                        'employee_id'               => $item->id,
                        'basic_salary'              => $item->basic_salary,
                        'total_gross_salary'        => $totalGrossOne == null ? $GrossSalary : $totalGrossOne,
                        'payment_date'              => $request->payment_date,
                        'created_by'                => Auth::user()->id
                    ]);
    
                    // dd($dataGrossSalary);
                    if (count(Payroll::where('employee_id',$item->id)->get()) == 0) {
                        $totalGrossSalary = $totalBasicSalary;
                    }else{
                        $totalGrossSalary = $dataGrossSalary->total_gross_salary;
                    }
                    
                    //function Seniority pay
                    $seniorityPayableTax = 0;
                    $taxExemptionSalary = 0;
                    if ($item->emp_status == 2) {
                        $currentDate = Carbon::createFromDate($request->payment_date)->format('m');
                        $PaymentOfMonth = Carbon::parse($request->payment_date)->format('M-Y');
                        if ($currentDate == 6 || $currentDate == 12) {
                            $nextYear = Carbon::parse($item->fdc_end)->format('Y');
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
                            $totalGrossExchange = 2000000 / $request->exchange_rate;
                            if ($totalSalaryReceive > $totalGrossExchange) {
                                $taxExemptionSalary = $totalGrossExchange;
                            } else {
                                $taxExemptionSalary = $totalSalaryReceive;
                            }
    
                            if ($totalSalaryReceive > $totalGrossExchange) {
                                $totaltaxableSalary = $totalSalaryReceive - $totalGrossExchange;
                            } else {
                                $totaltaxableSalary = 0;
                            }
                            $paymentOfMonth = $PaymentOfMonth;
                            $seniority = Seniority::create([
                                'employee_id'           => $item->id,
                                'total_average_salary'  => $totalSalary,
                                'total_salary_receive'  => number_format($totalSalaryReceive, 2),
                                'tax_exemption_salary'  => number_format($taxExemptionSalary, 2),
                                'taxable_salary'        => number_format($totaltaxableSalary, 2),
                                'payment_of_month'      => $paymentOfMonth,
                                'created_by'            => Auth::user()->id,
                            ]);
                            $seniorityPayableTax = $seniority->taxable_salary ?? 0;
                            $taxExemptionSalary = $seniority->tax_exemption_salary ?? 0;
                        }
                    }
    
                    
                    //sum salary and sum other benefit
                    $baseSalaryReceivedUsd = round($totalGrossSalary, 2) + $seniorityPayableTax - $pension_contribution;
                    //exchange rate
                    $totalExchangeRiel =  $request->exchange_rate * $baseSalaryReceivedUsd;
            
                    //total that បូកបន្ថែមលើបន្ទុកកូននិងប្រពន្ធ
                    $totalChargesReducedChild = $childrenAllowance->reduced_burden_children;
                    $totalChargesReducedSpouse = $childrenAllowance->spouse_allowance;
                    //not have child and sposes child 1
                    if($number_of_children == 0 && $item->spouse == 0){
                        $totalChargesReduced = 0;
                    }else if($number_of_children == 0 && $item->spouse == 0){
                        $totalChargesReduced = $totalChargesReducedSpouse;
                    }else if($number_of_children == 1 && $item->spouse == 0){
                        $totalChargesReduced = $totalChargesReducedChild;
                    }else if($number_of_children == 0 && $item->spouse == 1){
                        $totalChargesReduced = $totalChargesReducedSpouse;
                    }else if($number_of_children == 1 && $item->spouse == 1){
                        $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                    }else if($number_of_children == 2 && $item->spouse == 0){
                        $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
                    }else if($number_of_children == 2 && $item->spouse == 1){
                        $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                    }else if($number_of_children == 3 && $item->spouse == 0){
                        $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
                    }else if($number_of_children == 3 && $item->spouse == 1){
                        $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                    }else if($number_of_children == 4 && $item->spouse == 0){
                        $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
                    }else if($number_of_children == 4 && $item->spouse == 1){
                        $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
                    }
                    
                    //កាត់មូលដ្ឋានគិតពន្ធ
                    if ($number_of_children == 0 && $item->spouse == 0) {
                        $totalTtaxBbaseRiel = $totalExchangeRiel;
                    } else if($number_of_children == 1 && $item->spouse == 0) {
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 0 && $item->spouse == 1) {
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 1 && $item->spouse == 1) {
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 2 &&  $item->spouse == 0){
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 2 &&  $item->spouse == 1){
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 3 &&  $item->spouse == 0){
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 3 &&  $item->spouse == 1){
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 4 &&  $item->spouse == 0){
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }else if($number_of_children == 4 &&  $item->spouse == 1){
                        $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
                    }
                  
                    $children = $number_of_children;
                    // អត្រា ពន្ធ(%)
                    if ($number_of_children == 0 && $item->spouse == 0) {
                        $taxRate = Taxes::where('from', '<=' ,$totalExchangeRiel)->where('to','>=',$totalExchangeRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalExchangeRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalExchangeRiel > $taxRate->from && $totalExchangeRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalExchangeRiel > $taxRate->from && $totalExchangeRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalExchangeRiel > $taxRate->from && $totalExchangeRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
    
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    } else if($number_of_children == 1 && $item->spouse == 0) {
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
    
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 0 && $item->spouse == 1) {
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
    
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 1 && $item->spouse == 1) {
                        
                        //​cululate salaray Taxable
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 2 && $item->spouse == 0){
                        //​cululate salaray Taxable
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 2 && $item->spouse == 1){
                        //​cululate salaray Taxable
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 3 && $item->spouse == 0){
                        //​cululate salaray Taxable
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 3 && $item->spouse == 1){
                        //​cululate salaray Taxable
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 4 && $item->spouse == 0){
                        //​cululate salaray Taxable
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }else if($number_of_children == 4 && $item->spouse == 1){
                        //​cululate salaray Taxable
                        $taxRate = Taxes::where('from', '<=' ,(string)$totalTtaxBbaseRiel)->where('to','>=',(string)$totalTtaxBbaseRiel)->first();
                        $totalTax = $taxRate->tax_rate;
                        if($totalTtaxBbaseRiel >= $taxRate->to){
                            $totalSalaryTaxRiel = 0;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }elseif($totalTtaxBbaseRiel > $taxRate->from && $totalTtaxBbaseRiel <= $taxRate->to){
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }else{
                            $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - $taxRate->tax_deduction_amount;
                        }
                        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
                        $totalSalaryTaxUsd = $totalSalaryTaxRiel / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - $totalSalaryTaxUsd;
                    }
    
                    //function Severance Pay ti 1
                    $totalSeverancePay = 0;
                    if ($item->emp_status == 1 || $item->emp_status == 10) {
                        // $severancePay = GrossSalaryPay::where('employee_id',$item->id)->get();
                        $severancePay = GrossSalaryPay::where('employee_id',$item->id)->whereDate('payment_date','>',$item->fdc_date)->whereDate('payment_date','<',$item->fdc_end)->get();
                        if (count($severancePay) == 12 || count($severancePay) == 24) {
                            $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->where('payment_date', '>=',$item->fdc_date)->sum('total_gross_salary');
                            $totalContractSeverancePay = $dataSeveranc * 0.05;
                            $dataSeverance = SeverancePay::create([
                                'employee_id'                   => $item->id,
                                'total_severanec_pay'           => $dataSeveranc,
                                'total_contract_severance_pay'  => $totalContractSeverancePay,
                                'created_by'                    => Auth::user()->id,
                            ]);
                            $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
                        }
                    }
                    
                    $totalNetSalary = $totalSalaryAfterTax + $totalSeverancePay + $taxExemptionSalary;
    
                    $data   = $request->all();
                    $data['employee_id']                    = $item->id;
                    $data['basic_salary']                   = $item->basic_salary;
                    $data['spouse']                         = $item->spouse;
                    $data['children']                       = $children;
                    $data['total_gross_salary']             = $baseSalaryReceivedUsd;
                    $data['total_child_allowance']          = $totalAmountChild;
                    $data['phone_allowance']                = $item->phone_allowance;
                    $data['total_kny_phcumben']             = $totalBunus;
                    $data['total_severance_pay']            = $totalSeverancePay;
                    $data['seniority_payable_tax']          = $seniorityPayableTax;
                    $data['total_pension_fund']             = $pension_contribution;
                    $data['base_salary_received_usd']       = $baseSalaryReceivedUsd;
                    $data['base_salary_received_riel']      = number_format($totalExchangeRiel, 2);
                    $data['total_tax_base_riel']            = number_format($totalTtaxBbaseRiel, 2);
                    $data['total_charges_reduced']          = $totalChargesReduced;
                    $data['total_rate']                     = $totalTax;
                    $data['tax_free_seniority_allowance']   = $taxExemptionSalary;
                    $data['total_salary_tax_riel']          = number_format($totalSalaryTaxRiel, 2);
                    $data['total_salary_tax_usd']           = $totalSalaryTaxUsd;
                    $data['total_salary']                   = round($totalNetSalary, 2);
                    $data['exchange_rate']                  = $request->exchange_rate;
                    $data['created_by']                     = Auth::user()->id;
                    Payroll::create($data);
                }    
                Toastr::success('Created prayroll successfully.','Success');
                return redirect()->back();
                DB::commit();
            } else {
                DB::rollback();
                Toastr::error('Prayroll created fail','Error');
                return redirect()->back();
            }
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Prayroll created fail','Error');
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

    public function paySlip(Request $request){
        $payslip = Payroll::with('users')->where('employee_id',$request->employee_id)->orderBy('id','desc')->first();
        return view('payrolls.payslip',compact('payslip'));
    }
}
