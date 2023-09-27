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
use Illuminate\Support\Facades\Date;
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
        // $exChangeRate= ExchangeRate::where('type','Salary')->orderBy('id','desc')->first();
        $Monthly= Carbon::now()->format('m');
        $yearLy = Carbon::now()->format('Y');
        $exChangeRateSalary= ExchangeRate::where('type','Salary')->whereMonth("change_date", $Monthly)->whereYear("change_date", $yearLy)->orderBy('id','desc')->first();
        $exChangeRateNSSF= ExchangeRate::where('type','NSSF')->whereMonth("change_date", $Monthly)->whereYear("change_date", $yearLy)->orderBy('id','desc')->first();

        return view('payrolls.index',compact('data','user','branch','exChangeRateSalary', 'exChangeRateNSSF'));
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
        // try{
            $employee = User::where('date_of_commencement','<=',$request->payment_date)->whereIn('emp_status',['Probation','1','10','2'])->get();
            if (!$employee->isEmpty()) {
                foreach ($employee as $item) {
                    $PayMonthRequret = Payroll::where('employee_id',$item->id)->where('payment_date','=',$request->payment_date)->first();
                    if ($PayMonthRequret) {
                        DB::rollback();
                        Toastr::error('This month created payroll already','Error');
                        return redirect()->back();
                    } else {
                        //function first month join work
                        $totalFirstSeverancPay = 0;
                        if (count(Payroll::where('employee_id',$item->id)->get()) == 0) {
                            //total day in monthsd
                            $startMonth = Carbon::createFromDate($item->date_of_commencement)->format('m');
                            $startendMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth()->format('d');

                            $start_date = Carbon::createFromDate($item->date_of_commencement);
                            $endMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth();
                            $end_date = Date::createFromDate($endMonth);
                            $commencementDate   = Carbon::parse($start_date);
                            $resumptionDate     = Carbon::parse($end_date);
                            $toDays 		    = $resumptionDate->diffInWeekdays($commencementDate);
                            if ($toDays==0) {
                                $totalBasicSalary = $item->basic_salary;
                            } else {
                                if ($startMonth == 02 && $startendMonth == 28 || $startendMonth == 29) {
                                    if ($toDays == 20 || $toDays == 21) {
                                        $totalBasicSalary = $item->basic_salary;
                                    } else {
                                        $totalBasicSalary = ($item->basic_salary / 22) * $toDays;
                                    }
                                }else{
                                    if ($toDays >= 22) {
                                        $totalBasicSalary = $item->basic_salary;
                                    }else{
                                        $totalBasicSalary = ($item->basic_salary / 22) * $toDays;
                                    }
                                }
                            }
                        } else {
                            if($item->p_status == 1){
                                $totalBasicSalarySeveran = $item->total_current_salary == null ? $item->basic_salary : $item->total_current_salary;
                                //function get first severance pay
                                $endMonth = Carbon::createFromDate($item->fdc_date)->format('m');
                                $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                                //find start date employee join date
                                $date_of_month = Carbon::createFromDate($item->fdc_date)->format('Y-m');
                                $currentYear = $date_of_month.'-'.$totalDayInMonth;
                                //find total working day in month
                                $startDate = Carbon::parse($item->fdc_date);
                                $endDate = Carbon::parse($currentYear);
                                // new salary and new total days
                                $totalNewDays = $startDate->diffInDays($endDate) + 1;
                                $totalFirstSeverancPay = ($totalBasicSalarySeveran / $totalDayInMonth) * $totalNewDays;
                            }else{
                                $totalBasicSalary = $item->basic_salary;
                            }
                        }
                        // dd($totalFirstSeverancPay);
                        //calculated khmer_new_year and pchumBen_bonus
                        $totalBunus = 0;
                        if ($item->emp_status == 1 || $item->emp_status == 10 || $item->emp_status == 2) {
                            $dataHolidayBunuse = Holiday::where('type','bonus')->get();
                            foreach ($dataHolidayBunuse as $value) {
                                $userJoinDate = $item->date_of_commencement;
                                $startDate = Carbon::parse()->diffInDays($userJoinDate) + 1;
                                $dayOfYear = 365;
                                $fromDate = Carbon::parse($item->date_of_commencement);
                                $toDate = Carbon::parse($value->from);
                                $totalStartDays = $fromDate->diffInDays($toDate) - 1;

                                $hildayMonth = Carbon::createFromDate($value->period_month)->format('Y-m');
                                $hildayDays = Carbon::createFromDate($value->period_month)->format('d');
                                $payMonth = Carbon::createFromDate($request->payment_date)->format('Y-m');
                                $payDays = Carbon::createFromDate($request->payment_date)->format('d');
                                if($hildayMonth == $payMonth && $hildayDays >= $payDays){
                                    if ($totalStartDays > $dayOfYear) {
                                        $percent = $value->amount_percent / 100;
                                        $totalAllowanceBunus = ($item->basic_salary * $percent);
                                    } else {
                                        $totalPercent = ($item->basic_salary * $value->amount_percent) / 100;
                                        $percentSalary = $totalPercent * $totalStartDays;
                                        $totalAllowanceBunus = $percentSalary / $dayOfYear;
                                    }
                                    $dataBonus = Bonus::create([
                                        'employee_id'               => $item->id,
                                        'number_of_working_days'    => $totalStartDays,
                                        'base_salary'               => $item->basic_salary,
                                        'base_salary_received'      => $item->basic_salary,
                                        'total_allowance'           => $totalAllowanceBunus,
                                        'bouns_type'                => $value->title,
                                        'payment_date'              => $request->payment_date,
                                        'created_by'                => Auth::user()->id,
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
                        $totalChildAllowance = 0;
                        if ($item->emp_status == 1 || $item->emp_status == 10 || $item->emp_status == 2) {
                            if ($number_of_children) {
                                if ($number_of_children == 0) {
                                    $totalChildAllowance = 0;
                                } else if($number_of_children == 1) {
                                    $totalChildAllowance = $childrenAllowance->total_children_allowance * 1;
                                }else if($number_of_children == 2){
                                    $totalChildAllowance = $childrenAllowance->total_children_allowance * 2;
                                }else if($number_of_children == 3){
                                    $totalChildAllowance = $childrenAllowance->total_children_allowance * 3;
                                }else if($number_of_children == 4){
                                    $totalChildAllowance = $childrenAllowance->total_children_allowance * 4;
                                }
                            }
                        }
                        
                        //calcute last severance pay 12
                        $total_fdc1 = 0;
                        $type_fdc1 = null;
                        $type_fdc2 = null;
                        $total_fdc2 = 0;
                        $totalSeverancePay2 = 0;
                        if ($item->emp_status == 1) {
                            $dataGrossSalaryPay1 = GrossSalaryPay::where('employee_id',$item->id)->whereNotNull('type_fdc1')->count(); 
                            if($dataGrossSalaryPay1 == 12){
                                $endMonth = Carbon::createFromDate($item->udc_end_date)->format('m');
                                $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                                $date_of_month = Carbon::createFromDate($item->udc_end_date)->format('Y-m');
                                $currentYear = $date_of_month.'-'.$totalDayInMonth;
                            
                                // new salary and new total days
                                $startDate = Carbon::parse($item->udc_end_date);
                                $endDate = Carbon::parse($currentYear);
                                $totalNewDays = $startDate->diffInDays($endDate) + 1;
                                $total_fdc2 = ($item->basic_salary / $totalDayInMonth) * $totalNewDays;
        
                                //old salary and total old days
                                $totalOldDay = $totalDayInMonth - $totalNewDays;
                                $total_fdc1 = ($item->basic_salary / $totalDayInMonth) * $totalOldDay;
                                $type_fdc2 = 'fdc2';
                            }
                            $type_fdc1 = 'fdc1';
                            $totalSeverancePay2 = $total_fdc2;
                            $totalBasicSalary = $item->basic_salary;
                        }
                        
                        
                        $totalSeniority = 0;
                        $totalGrossSalary2 = 0;
                        if ($item->emp_status == 10) {
                            $dataGrossSalaryPay2 = GrossSalaryPay::where('employee_id',$item->id)->whereNotNull('type_fdc2')->count(); 
                            if($dataGrossSalaryPay2 == 12){
                                $endMonth = Carbon::createFromDate($item->udc_end_date)->format('m');
                                $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                                $date_of_month = Carbon::createFromDate($item->udc_end_date)->format('Y-m');
                                $currentYear = $date_of_month.'-'.$totalDayInMonth;
                            
                                // new salary and new total days
                                $startDate = Carbon::parse($item->udc_end_date);
                                $endDate = Carbon::parse($currentYear);
                                $totalNewDays = $startDate->diffInDays($endDate) + 1;
                                $totalSeniority = ($item->basic_salary / $totalDayInMonth) * $totalNewDays;
        
                                //old salary and total old days
                                $totalOldDay = $totalDayInMonth - $totalNewDays;
                                $totalGrossSalary2 = ($item->basic_salary / $totalDayInMonth) * $totalOldDay;
                                $totalSeverancePaySalary2 = $totalSeniority + $totalGrossSalary2;
                            }
                        }
                        
                        if($item->emp_status == 'Probation'){
                            $totalGrossSalaryTaxFree = $totalBasicSalary + $item->phone_allowance;
                            $totalSeverancePay1 =  $totalGrossSalaryTaxFree != null ? $totalGrossSalaryTaxFree : $totalGrossSalaryTaxFree;
                        }
                        $totalSeniority = 0;
                        if($item->emp_status == 2){
                            $type_fdc1 = 'fdc1';
                            $type_fdc2 = 'seniority';
                            $totalGrossSalaryTaxFree = $totalBasicSalary + $totalBunus + $item->phone_allowance + $totalChildAllowance;
                            $totalSeverancePay1 =  $totalFirstSeverancPay;
                            $totalSeniority =  $totalGrossSalaryTaxFree != null ? $totalGrossSalaryTaxFree : $totalGrossSalaryTaxFree;
                        }
                        if($item->p_status == 2){
                            $type_fdc2 = 'seniority';
                            $severancePay = $totalFirstSeverancPay == null ? $totalBasicSalary : $totalFirstSeverancPay;
                            $totalGrossSalaryTaxFree = $severancePay + $totalBunus + $item->phone_allowance + $totalChildAllowance;
                            $total_fdc = $total_fdc1 > $total_fdc2 ? $total_fdc2 : $total_fdc1;
                            $dataTotalSeverancePay1 = $totalFirstSeverancPay == null ? $total_fdc : $totalFirstSeverancPay;
                            $totalSeniority =  $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 + $totalBunus + $item->phone_allowance + $totalChildAllowance : $totalGrossSalaryTaxFree;
                        }
                        
                        if($item->emp_status == 1){
                            $severancePay = $totalFirstSeverancPay == null ? $totalBasicSalary : $totalFirstSeverancPay;
                            $totalGrossSalaryTaxFree = $severancePay + $totalBunus + $item->phone_allowance + $totalChildAllowance;
                            $total_fdc = $total_fdc1 > $total_fdc2 ? $total_fdc2 : $total_fdc1;
                            $dataTotalSeverancePay1 = $totalFirstSeverancPay == null ? $total_fdc : $totalFirstSeverancPay;
                            $totalSeverancePay1 =  $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 + $totalBunus + $item->phone_allowance + $totalChildAllowance : $totalGrossSalaryTaxFree;
                        }
                        
                        $totalSeverancePaySalary2 = 0;
                        if($item->emp_status == 10){
                            $type_fdc1 = null;
                            $type_fdc2 = 'fdc2';
                            $totalSeverancePay1 = 0;
                            $severancePay = $totalSeverancePaySalary2 == null ? $totalBasicSalary : $totalSeverancePaySalary2;
                            $totalGrossSalaryTaxFree = $severancePay + $totalBunus + $item->phone_allowance + $totalChildAllowance;
                            $dataTotalSeverancePay1 = $totalFirstSeverancPay == null ? $totalGrossSalary2 : $totalFirstSeverancPay;
                            $totalSeverancePay2 =  $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 + $totalBunus + $item->phone_allowance + $totalChildAllowance : $totalGrossSalaryTaxFree;
                            $totalSeniority =  $totalSeniority;
                        }

                        //sum salary and sum other benefit befor tax free
                        $dataGrossSalary = GrossSalaryPay::create([
                            'employee_id'               => $item->id,
                            'basic_salary'              => $item->basic_salary,
                            'total_gross_salary'        => $totalGrossSalaryTaxFree,
                            'total_fdc1'                => $totalSeverancePay1,
                            'total_fdc2'                => $totalSeverancePay2,
                            'total_seniority'           => $totalSeniority,
                            'payment_date'              => $request->payment_date,
                            'type_fdc1'                 => $type_fdc1,
                            'type_fdc2'                 => $type_fdc2,
                            'created_by'                => Auth::user()->id
                        ]);
        
                        // dd($dataGrossSalary);
                        if (count(Payroll::where('employee_id',$item->id)->get()) == 0) {
                            $totalGrossSalary = $totalGrossSalaryTaxFree;
                        }else{
                            $totalGrossSalary = $dataGrossSalary->total_gross_salary;
                        }

                        //National Social Security Fund (NSSF) Formula
                        $exchangNSSF = ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();
                        if ($exchangNSSF) {
                            $totalExchangeRielPreTax =  $exchangNSSF->amount_riel * $totalGrossSalary;
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
                            $workerContributionRiel = $workerContributionUsd / $exchangNSSF->amount_riel;
                            $dataNSSF = NationalSocialSecurityFund::create([
                                'employee_id'                   => $item->id,
                                'total_pre_tax_salary_usd'      => number_format($totalGrossSalary, 2),
                                'total_pre_tax_salary_riel'     => number_format($totalExchangeRielPreTax),
                                'total_average_wage'            => number_format($averageWage),
                                'total_occupational_risk'       => number_format($occupationalRisk),
                                'total_health_care'             => number_format($healthCare),
                                'pension_contribution_usd'      => number_format($workerContributionUsd),
                                'pension_contribution_riel'     => round($workerContributionRiel, 2),
                                'corporate_contribution'        => number_format($workerContributionUsd),
                                'payment_date'                  => $request->payment_date,
                                'created_by'                    => Auth::user()->id,
                            ]);
                        }
                        $pension_contribution = $dataNSSF->pension_contribution_riel;
    
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
                                
                                $totalSalary = GrossSalaryPay::where('employee_id', $item->id)->where('type_fdc2','seniority')->when($currentYear ,function ($query, $fdc_end) {
                                    $query->where('payment_date', '>=',$fdc_end);
                                })->when($currentMonth, function($query, $currentMonth){
                                    $query->where('payment_date', '>=',$currentMonth);
                                })->pluck('total_seniority')->avg();
                                
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
                                    'payment_date'          => $request->payment_date,
                                    'created_by'            => Auth::user()->id,
                                ]);
                                $seniorityPayableTax = $seniority->taxable_salary ?? 0;
                                $taxExemptionSalary = $seniority->tax_exemption_salary ?? 0;
                            }
                        }
        
                        //function ដក​ pensin fund
                        $baseSalaryReceivedUsd = $totalGrossSalary + $seniorityPayableTax - $pension_contribution;
                        // functin exchange riel rate gross salary after tax
                        $totalExchangeRiel = round($baseSalaryReceivedUsd, 2) * $request->exchange_rate;
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                            $taxRate = Taxes::where('from', '<=' ,$totalTtaxBbaseRiel)->where('to','>=',$totalTtaxBbaseRiel)->first();
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
                        if ($item->emp_status == 1) {
                            $dataGrossSalaryPay = GrossSalaryPay::where('employee_id',$item->id)->whereNotNull('type_fdc1')->count();
                            if ($dataGrossSalaryPay == 13) {
                                $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc1')->sum('total_fdc1');
                                $totalContractSeverancePay = $dataSeveranc * 0.05;
                                $dataSeverance = SeverancePay::create([
                                    'employee_id'                   => $item->id,
                                    'total_severanec_pay'           => $dataSeveranc,
                                    'total_contract_severance_pay'  => $totalContractSeverancePay,
                                    'payment_date'                  => $request->payment_date,
                                    'created_by'                    => Auth::user()->id,
                                ]);
                                $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
                            }
                        }
                        if($item->emp_status == 10){
                            $dataGrossSalaryPay = GrossSalaryPay::where('employee_id',$item->id)->whereNotNull('type_fdc2')->count();
                            if ($dataGrossSalaryPay == 13) {
                                $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc2')->sum('total_fdc2');
                                $totalContractSeverancePay = $dataSeveranc * 0.05;
                                $dataSeverance = SeverancePay::create([
                                    'employee_id'                   => $item->id,
                                    'total_severanec_pay'           => $dataSeveranc,
                                    'total_contract_severance_pay'  => $totalContractSeverancePay,
                                    'payment_date'                  => $request->payment_date,
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
                        $data['total_gross_salary']             = $totalBasicSalary;
                        $data['total_child_allowance']          = $totalChildAllowance;
                        $data['phone_allowance']                = $item->phone_allowance;
                        $data['total_kny_phcumben']             = $totalBunus;
                        $data['total_severance_pay']            = $totalSeverancePay;
                        $data['seniority_pay_included_tax']     = $seniorityPayableTax;
                        $data['total_gross']                    = $totalGrossSalary;
                        $data['total_pension_fund']             = $pension_contribution;
                        $data['base_salary_received_usd']       = $baseSalaryReceivedUsd;
                        $data['base_salary_received_riel']      = round($totalExchangeRiel, 3);
                        $data['total_tax_base_riel']            = round($totalTtaxBbaseRiel, 3);
                        $data['total_charges_reduced']          = $totalChargesReduced;
                        $data['total_rate']                     = $totalTax;
                        $data['seniority_pay_excluded_tax']     = $taxExemptionSalary;
                        $data['total_salary_tax_riel']          = round($totalSalaryTaxRiel, 3);
                        $data['total_salary_tax_usd']           = $totalSalaryTaxUsd;
                        $data['total_salary']                   = $totalNetSalary;
                        $data['exchange_rate']                  = $request->exchange_rate;
                        $data['created_by']                     = Auth::user()->id;
                        Payroll::create($data);
                    }
                    if ($item->p_status == 1 || $item->p_status == 2 || $item->p_status == 10) {
                        User::where('id',$item->id)->update([
                            'emp_status' => $item->p_status,
                            'p_status' => null
                        ]);
                    } else {
                        User::where('id',$item->id)->update([
                            'emp_status' => $item->emp_status,
                            'p_status' => null
                        ]);
                    }
                }
                // Toastr::success('Created payroll successfully.','Success');
                // return redirect()->back();
                return response()->json(['success'=>"success"]);
                DB::commit();
            } else {
                DB::rollback();
                Toastr::error('Can not employee payroll','Error');
                return redirect()->back();
            }
        // }catch(\Exception $e){
        //     DB::rollback();
        //     Toastr::error('Payroll created fail','Error');
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
    public function destroy(Request $request)
    {
        try{
            Payroll::find($request->id);
            Toastr::success('Payroll deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Payroll delete fail','Error');
            return redirect()->back();
        }
    }

    public function paySlip(Request $request){
        $payslip = Payroll::with('users')->where('employee_id',$request->employee_id)->orderBy('id','desc')->first();
        return view('payrolls.payslip',compact('payslip'));
    }
}
