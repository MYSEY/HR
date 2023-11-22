<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Bonus;
use App\Models\Taxes;
use App\Models\Branchs;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Models\ExchangeRate;
use App\Models\PreviewBonus;
use App\Models\SeverancePay;
use Illuminate\Http\Request;
use App\Models\ChildrenInfor;
use App\Models\GrossSalaryPay;
use App\Models\payrollPreview;
use Illuminate\Support\Carbon;
use App\Models\ChildrenAllowance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportEmployeeSalary;
use App\Exports\ExportReviewPayroll;
use App\Models\PreviewGrossSalaryPay;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\NationalSocialSecurityFund;
use App\Repositories\Admin\PayrollRepository;
use App\Models\PreviewNationalSocialSecurityFund;

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
        $exChangeRateSalary= ExchangeRate::where('type','Salary')->orderBy('id','desc')->first();
        $exChangeRateNSSF= ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();

        return view('payrolls.index',compact('data','user','branch','exChangeRateSalary', 'exChangeRateNSSF'));
    }
    public function payrollRview(Request $request){
        $data = $this->payrollRepo->getAllPayrollPreview($request);
        $user = User::all();
        $branch = Branchs::all();
        $exChangeRateSalary= ExchangeRate::where('type','Salary')->orderBy('id','desc')->first();
        $exChangeRateNSSF= ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();

        return view('payrolls.review',compact('data','user','branch','exChangeRateSalary', 'exChangeRateNSSF'));
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
        })->orderBy('id','DESC')->get();
        return response()->json([
            'success'=>$payroll,
        ]);
    }

    public function export(Request $request) {
        return Excel::download(new ExportEmployeeSalary($request), 'EmployeeSalary.xlsx');
    }

    public function payrollPreviwExport(Request $request) {
        return Excel::download(new ExportReviewPayroll($request), 'ReviewPayroll.xlsx');
    }
    public function payrollReviewSearch(Request $request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll = payrollPreview::with("users")
        ->join('users', 'payroll_previews.employee_id', '=', 'users.id')
        ->select(
            'payroll_previews.*',
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
        })->orderBy('id','DESC')->get();
        return response()->json([
            'success'=>$payroll,
        ]);
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
                    payrollPreview::where('employee_id',$item->id)->delete();
                    PreviewNationalSocialSecurityFund::where('employee_id',$item->id)->delete();
                    PreviewGrossSalaryPay::where('employee_id',$item->id)->delete();
                    PreviewBonus::where('employee_id',$item->id)->delete();
                    //function first month join work
                    $totalFirstSeverancPay = 0;
                    $totalBaseSalaryRecived = 0;
                    $totalBasicSalary = 0;
                    $joinDate = Carbon::createFromDate($item->date_of_commencement)->format('m-y');
                    $paymentDate = Carbon::createFromDate($request->payment_date)->format('m-y');
                    // dd($paymentDate);

                    if ($joinDate == $paymentDate) {
                        //total day in monthsd
                        $startMonth = Carbon::createFromDate($item->date_of_commencement)->format('m');
                        $startendMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth()->format('d');

                        $start_date = Carbon::createFromDate($item->date_of_commencement);
                        $endMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth();
                        $end_date = Date::createFromDate($endMonth);
                        $commencementDate   = Carbon::parse($start_date);
                        $resumptionDate     = Carbon::parse($end_date);
                        $toDays 		    = $resumptionDate->diffInWeekdays($commencementDate) + 1;
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
                        $monthToPay = Carbon::createFromDate($item->fdc_date)->format('Y-m');
                        $currentMonthToPay = Carbon::createFromDate($request->payment_date)->format('Y-m');
                        if($monthToPay == $currentMonthToPay){
                            //function get first severance pay
                            $endMonth = Carbon::createFromDate($item->fdc_date)->format('m');
                            $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                            //find start date employee join date
                            $date_of_month = Carbon::createFromDate($item->fdc_date)->format('Y-m');
                            $currentYear = $date_of_month.'-'.$totalDayInMonth;
                            //find total working day in month
                            $startDate = Carbon::parse($item->fdc_date);
                            $endDate = Carbon::parse($currentYear);

                            //total day in  passt probation and total salary passt probation days
                            $totalNewDays = $startDate->diffInDays($endDate) + 1;
                            $totalSeverancePayLast = ($item->basic_salary / $totalDayInMonth) * $totalNewDays;
                            
                            //total day in  probation and total salary in probation days
                            $totalOldDay = $totalDayInMonth - $totalNewDays;
                            $totalSeverancePayFirst = 0;
                            if ($totalOldDay) {
                                $totalSeverancePayFirst = ($item->pre_salary / $totalDayInMonth)  * $totalOldDay;
                            }
                            $totalBaseSalaryRecived = $totalSeverancePayLast + $totalSeverancePayFirst;
                            $totalFirstSeverancPay = round($totalSeverancePayLast,2);
                        }else{
                            $totalBasicSalary = $item->basic_salary;
                        }
                    }
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
                            $totalStartDays = $fromDate->diffInDays($toDate);

                            $hildayMonth = Carbon::createFromDate($value->period_month)->format('Y-m');
                            $hildayDays = Carbon::createFromDate($value->period_month)->format('d');
                            $payMonth = Carbon::createFromDate($request->payment_date)->format('Y-m');
                            $payDays = Carbon::createFromDate($request->payment_date)->format('d');
                            $bounsType = $value->title;
                            if($hildayMonth == $payMonth && $hildayDays >= $payDays){
                                if ($totalStartDays > $dayOfYear) {
                                    $percent = $value->amount_percent / 100;
                                    $totalAllowanceBunus = ($item->basic_salary * $percent);
                                } else {
                                    $totalPercent = ($item->basic_salary * $value->amount_percent) / 100;
                                    $percentSalary = $totalPercent * $totalStartDays;
                                    $totalAllowanceBunus = $percentSalary / $dayOfYear;
                                }
                                $dataBonus = PreviewBonus::create([
                                    'employee_id'               => $item->id,
                                    'number_employee'           => $item->number_employee,
                                    'number_of_working_days'    => $totalStartDays,
                                    'base_salary'               => $item->basic_salary,
                                    'base_salary_received'      => $item->basic_salary,
                                    'total_allowance'           => $totalAllowanceBunus,
                                    'bouns_type'                => $bounsType,
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
                    
                    //calcute last severance pay 1
                    $SeverancePay1 = null;
                    $SeverancePay2 = null;
                    $totalSeniority = 0;
                    $type_fdc1 = null;
                    $type_fdc2 = null;
                    $type_udc = null;

                    $totalSeverancyPaySalary = $totalBaseSalaryRecived != null ? $totalBaseSalaryRecived : $totalBasicSalary;
                    $totalSalarySeverancyPay = $totalSeverancyPaySalary + $totalBunus + $item->phone_allowance + $totalChildAllowance;

                    $totalSeverancePay = $totalFirstSeverancPay != null ? $totalFirstSeverancPay : $totalBasicSalary;
                    $totalOtherBenefit = $totalSeverancePay + $totalBunus + $item->phone_allowance + $totalChildAllowance;

                    $endContractDeadline= Carbon::createFromDate($item->fdc_end)->format('Y-m');
                    $paymentDate = Carbon::createFromDate($request->payment_date)->format('Y-m');
                    if($endContractDeadline == $paymentDate){
                        $endMonth = Carbon::createFromDate($item->fdc_end)->format('m');
                        $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                        $contract_deadline = Carbon::createFromDate($item->fdc_end)->format('Y-m');
                        $currentYear = $contract_deadline.'-'.$totalDayInMonth;
                        // new salary and new total days
                        $startDate = Carbon::parse($item->fdc_end);
                        $endDate = Carbon::parse($currentYear);
                        $totalNewDays = $startDate->diffInDays($endDate);
                        $SeverancePay2 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalNewDays;
                        //old salary and total old days
                        $totalOldDay = $totalDayInMonth - $totalNewDays;
                        $SeverancePay1 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalOldDay;

                        $type_fdc2 = 'fdc2';
                        $type_udc = 'seniority';
                        $totalSeniority = $totalSalarySeverancyPay;
                    }
                    
                    $dataTotalSeverancePay1 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
                    $totalSeverancePay1 =  $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 : $totalSalarySeverancyPay;
                    $totalSeverancePay2 = $SeverancePay2;
                    $totalBasicSalary = $totalBaseSalaryRecived != null ? $totalBaseSalaryRecived : $totalBasicSalary;
                    $dataTotalSeverancePay2 = $SeverancePay2 != null ? $SeverancePay2 : $totalOtherBenefit;
                    $totalSalaryNetPay = round($totalSeverancyPaySalary,2) + $totalBunus + $item->phone_allowance + $totalChildAllowance;
                    if ($item->emp_status == 'Probation') {
                        $type_fdc1 = null;
                        $totalSeverancePay1 = null;
                    } elseif($item->emp_status == 1) {
                        $type_fdc1 = 'fdc1';
                    }elseif($item->emp_status == 10){
                        $type_fdc1 = null;
                        $totalSeniority = null;
                        $type_fdc2 = 'fdc2';
                        $totalSeverancePay1 = null;
                        $totalSeverancePay2 = null;
                        $totalSeverancePay2 = $dataTotalSeverancePay2 != null ? $dataTotalSeverancePay2 : $totalSalarySeverancyPay;
                    }elseif($item->emp_status == 2){
                        $type_udc = 'seniority';
                        $totalSeverancePay1 = $totalSeverancePay1;
                        $totalSeverancePay2 = null;
                        $dataTotalSeverancePay1 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
                        $totalSeniority = $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 : $totalSalarySeverancyPay;
                    }
                    
                    //sum salary and sum other benefit befor tax free
                    $dataGrossSalary = PreviewGrossSalaryPay::create([
                        'employee_id'               => $item->id,
                        'number_employee'           => $item->number_employee,
                        'basic_salary'              => $item->basic_salary,
                        'total_gross_salary'        => round($totalSalaryNetPay,2),
                        'total_fdc1'                => round($totalSeverancePay1,2),
                        'total_fdc2'                => round($totalSeverancePay2,2),
                        'total_seniority'           => round($totalSeniority,2),
                        'payment_date'              => $request->payment_date,
                        'type_fdc1'                 => $type_fdc1,
                        'type_fdc2'                 => $type_fdc2,
                        'type_udc'                  => $type_udc,
                        'created_by'                => Auth::user()->id
                    ]);
                    if (count(Payroll::where('employee_id',$item->id)->get()) == 0) {
                        $totalGrossSalary = $totalSalaryNetPay;
                    }else{
                        $totalGrossSalary = $dataGrossSalary->total_gross_salary;
                    }
                    //National Social Security Fund (NSSF) Formula
                    $exchangNSSF = ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();
                    if ($exchangNSSF) {
                        $totalExchangeRielPreTax =  $exchangNSSF->amount_riel * round($totalGrossSalary,2);
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
                        $workerContributionRiel = round($workerContributionUsd,-2) / $exchangNSSF->amount_riel;
                        $dataNSSF = PreviewNationalSocialSecurityFund::create([
                            'employee_id'                   => $item->id,
                            'number_employee'               => $item->number_employee,
                            'total_pre_tax_salary_usd'      => $totalGrossSalary,
                            'total_pre_tax_salary_riel'     => $totalExchangeRielPreTax,
                            'total_average_wage'            => $averageWage,
                            'total_occupational_risk'       => round($occupationalRisk,-2),
                            'total_health_care'             => $healthCare,
                            'pension_contribution_usd'      => round($workerContributionUsd, -2),
                            'pension_contribution_riel'     => round($workerContributionRiel, 2),
                            'corporate_contribution'        => round($workerContributionUsd, -2),
                            'exchange_rate'                 => $exchangNSSF->amount_riel,
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
                            $nextYear = Carbon::parse($item->udc_end_date)->format('Y');
                            $currentYear = null;
                            $currentMonth = null;
                            $preYear = Carbon::createFromDate($item->udc_end_date)->format('Y');
                            if($currentDate == 6){  
                                if ($preYear == $nextYear) {
                                    $currentYear = $item->udc_end_date;
                                }else{
                                    $currentYear =  Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d');
                                }
                            }
                            if ($currentDate == 12) {
                                $currentMonth = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
                            }
                            $totalSalary = GrossSalaryPay::where('employee_id', $item->id)->where('type_udc','seniority')->when($currentYear ,function ($query, $udc_end_date) {
                                $query->where('payment_date', '>=',$udc_end_date);
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
                                'number_employee'       => $item->number_employee,
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;

                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }
                    //function Severance Pay ti 1
                    $totalSeverancePay = 0;
                    $monthEndDate = Carbon::createFromDate($item->fdc_end)->format('Y-m');
                    $paymentDate = Carbon::createFromDate($request->payment_date)->format('Y-m');
                    if($item->emp_status == 1){
                        if($monthEndDate == $paymentDate){
                            $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc1')->sum('total_fdc1');
                            $totalContractSeverancePay = $dataSeveranc * 0.05;
                            $dataSeverance = SeverancePay::create([
                                'employee_id'                   => $item->id,
                                'number_employee'               => $item->number_employee,
                                'total_severanec_pay'           => round($dataSeveranc,2),
                                'total_contract_severance_pay'  => round($totalContractSeverancePay,2),
                                'payment_date'                  => $request->payment_date,
                                'created_by'                    => Auth::user()->id,
                            ]);
                            $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
                        }
                    }

                    if($item->emp_status == 10){
                        if($monthEndDate == $paymentDate){
                            $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc2')->sum('total_fdc2');
                            $totalContractSeverancePay = $dataSeveranc * 0.05;
                            $dataSeverance = SeverancePay::create([
                                'employee_id'                   => $item->id,
                                'number_employee'               => $item->number_employee,
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
                    $data['number_employee']                = $item->number_employee;
                    $data['basic_salary']                   = $item->basic_salary;
                    $data['spouse']                         = $item->spouse;
                    $data['children']                       = $children;
                    $data['total_gross_salary']             = $totalBasicSalary;
                    $data['total_child_allowance']          = $totalChildAllowance;
                    $data['phone_allowance']                = $item->phone_allowance;
                    $data['total_kny_phcumben']             = $totalBunus;
                    $data['total_severance_pay']            = round($totalSeverancePay,3);
                    $data['seniority_pay_included_tax']     = $seniorityPayableTax;
                    $data['total_gross']                    = $totalGrossSalary;
                    $data['total_pension_fund']             = $pension_contribution;
                    $data['base_salary_received_usd']       = $baseSalaryReceivedUsd;
                    $data['base_salary_received_riel']      = round($totalExchangeRiel, 3);
                    $data['total_tax_base_riel']            = round($totalTtaxBbaseRiel, 3);
                    $data['total_charges_reduced']          = $totalChargesReduced;
                    $data['total_rate']                     = $totalTax;
                    $data['seniority_pay_excluded_tax']     = $taxExemptionSalary;
                    $data['total_salary_tax_riel']          = round($totalSalaryTaxRiel,3);
                    $data['total_salary_tax_usd']           = $totalSalaryTaxUsd;
                    $data['total_salary']                   = $totalNetSalary;
                    $data['exchange_rate']                  = $request->exchange_rate;
                    $data['created_by']                     = Auth::user()->id;
                    payrollPreview::create($data);
                }
                Toastr::success('Created payroll successfully.','Success');
                return redirect()->back();
                DB::commit();
            } else {
                DB::rollback();
                Toastr::error('Can not employee payroll','Error');
                return redirect()->back();
            }
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Payroll created fail','Error');
            return redirect()->back();
        }
    }

    public function payrollApproved(Request $request){
        try{
            $ids = $request->ids;
            $dataPayroll = payrollPreview::whereIn('id',explode(",",$ids))->get();
            $dataNssf = PreviewNationalSocialSecurityFund::whereIn('id',explode(",",$ids))->get();
            $dataGrossSalaryPay = PreviewGrossSalaryPay::whereIn('id',explode(",",$ids))->get();
            $dataBonus = PreviewBonus::whereIn('id',explode(",",$ids))->get();
            foreach ($dataBonus as $item) {
                Bonus::firstOrCreate([
                    'employee_id'             => $item->employee_id,
                    'number_employee'         => $item->number_employee,
                    'number_of_working_days'  => $item->number_of_working_days,
                    'base_salary'             => $item->base_salary,
                    'base_salary_received'    => $item->base_salary_received,
                    'total_allowance'         => $item->total_allowance,
                    'payment_date'            => $item->payment_date,
                    'bouns_type'              => $item->bouns_type,
                    'created_by'              => $item->created_by,
                ]);
                PreviewBonus::whereIn('id',explode(",",$ids))->delete();
            }
            foreach ($dataNssf as $item) {
                NationalSocialSecurityFund::firstOrCreate([
                    'employee_id'               => $item->employee_id,
                    'number_employee'           => $item->number_employee,
                    'total_pre_tax_salary_usd'  => $item->total_pre_tax_salary_usd,
                    'total_pre_tax_salary_riel' => $item->total_pre_tax_salary_riel,
                    'total_average_wage'        => $item->total_average_wage,
                    'total_occupational_risk'   => $item->total_occupational_risk,
                    'total_health_care'         => $item->total_health_care,
                    'pension_contribution_usd'  => $item->pension_contribution_usd,
                    'pension_contribution_riel' => $item->pension_contribution_riel,
                    'corporate_contribution'    => $item->corporate_contribution,
                    'exchange_rate'             => $item->exchange_rate,
                    'payment_date'              => $item->payment_date,
                    'created_by'                => $item->created_by,
                ]);
                PreviewNationalSocialSecurityFund::whereIn('id',explode(",",$ids))->delete();
            }
            foreach ($dataGrossSalaryPay as $item) {
                GrossSalaryPay::firstOrCreate([
                    'employee_id'           => $item->employee_id,
                    'number_employee'       => $item->number_employee,
                    'basic_salary'          => $item->basic_salary,
                    'total_gross_salary'    => $item->total_gross_salary,
                    'total_fdc1'            => $item->total_fdc1,
                    'type_fdc1'             => $item->type_fdc1,
                    'total_fdc2'            => $item->total_fdc2,
                    'type_fdc2'             => $item->type_fdc2,
                    'type_udc'              => $item->type_udc,
                    'total_seniority'       => $item->total_seniority,
                    'payment_date'          => $item->payment_date,
                    'payment_date'          => $item->payment_date,
                    'created_by'            => $item->created_by,
                ]);
                PreviewGrossSalaryPay::whereIn('id',explode(",",$ids))->delete();
            }
            foreach ($dataPayroll as $item) {
                Payroll::firstOrCreate([
                    'employee_id'               => $item->employee_id,
                    'number_employee'           => $item->number_employee,
                    'basic_salary'              => $item->basic_salary,
                    'total_gross_salary'        => $item->total_gross_salary,
                    'payment_date'              => $item->payment_date,
                    'total_child_allowance'     => $item->total_child_allowance,
                    'phone_allowance'           => $item->phone_allowance,
                    'monthly_quarterly_bonuses' => $item->monthly_quarterly_bonuses,
                    'total_kny_phcumben'        => $item->total_kny_phcumben,
                    'annual_incentive_bonus'    => $item->annual_incentive_bonus,
                    'total_gross'               => $item->total_gross,
                    'total_pension_fund'        => $item->total_pension_fund,
                    'seniority_pay_included_tax'=> $item->seniority_pay_included_tax,
                    'base_salary_received_usd'  => $item->base_salary_received_usd,
                    'base_salary_received_riel' => $item->base_salary_received_riel,
                    'spouse'                    => $item->spouse,
                    'children'                  => $item->children,
                    'total_charges_reduced'     => $item->total_charges_reduced,
                    'total_tax_base_riel'       => $item->total_tax_base_riel,
                    'total_rate'                => $item->total_rate,
                    'total_salary_tax_usd'      => $item->total_salary_tax_usd,
                    'total_salary_tax_riel'     => $item->total_salary_tax_riel,
                    'total_amount_reduced'      => $item->total_amount_reduced,
                    'seniority_pay_excluded_tax'=> $item->seniority_pay_excluded_tax,
                    'seniority_backford'        => $item->seniority_backford,
                    'total_severance_pay'       => $item->total_severance_pay,
                    'loan_amount'               => $item->loan_amount,
                    'total_amount_car'          => $item->total_amount_car,
                    'total_salary'              => $item->total_salary,
                    'exchange_rate'             => $item->exchange_rate,
                    'adjustment'                => $item->adjustment,
                    'leaves'                    => $item->leaves,
                    'created_by'                => $item->created_by,
                ]);
                payrollPreview::whereIn('id',explode(",",$ids))->delete();
            }
            Toastr::success('Approved payroll successfully.','Success');
            return redirect()->back();
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Approved Payroll fail','Error');
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

    public function importPayroll(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $AllPayroll =  $spreadsheet->getSheetByName('payroll')->toArray();
        // dd($AllPayroll);
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($AllPayroll as $item) {
                $i++;
                if ($i != 1) {
                    $employee = User::where("number_employee", $item[0])->first();
                    Payroll::firstOrCreate([
                        'employee_id'                   => $employee->id,
                        'number_employee'               => $item[0],
                        'basic_salary'                  => $item[2],
                        'total_gross_salary'            => $item[3],
                        'total_child_allowance'         => $item[4],
                        'phone_allowance'               => $item[5],
                        'monthly_quarterly_bonuses'     => $item[6],
                        'total_kny_phcumben'            => $item[7],
                        'annual_incentive_bonus'        => $item[8],
                        'seniority_pay_included_tax'    => $item[9],
                        'total_gross'                   => $item[10],
                        'total_pension_fund'            => $item[11],
                        'base_salary_received_usd'      => $item[12],
                        'base_salary_received_riel'     => $item[13],
                        'spouse'                        => $item[14],
                        'children'                      => $item[15],
                        'total_charges_reduced'         => $item[16],
                        'total_tax_base_riel'           => $item[17],
                        'total_rate'                    => $item[18],
                        'total_salary_tax_usd'          => $item[19],
                        'total_salary_tax_riel'         => $item[20],
                        'seniority_pay_excluded_tax'    => $item[21],
                        'seniority_backford'            => $item[22],
                        'total_severance_pay'           => $item[23],
                        'loan_amount'                   => $item[24],
                        'total_amount_car'              => $item[25],
                        'total_salary'                  => $item[26],
                        'payment_date'                  => $item[27],
                        'exchange_rate'                 => $item[28],
                        'created_by'                    => Auth::user()->id,
                    ]);
                }
            }
            if($dataArray){
                return response()->json(['error'=>$dataArray]);
            }
            return 1;
        } else {
            return 0;
        }
    }

    public function payrollReviewDelete(Request $request){
        try{
            $ids = $request->ids;
            payrollPreview::whereIn('id',explode(",",$ids))->delete();
            PreviewNationalSocialSecurityFund::whereIn('id',explode(",",$ids))->delete();
            PreviewGrossSalaryPay::whereIn('id',explode(",",$ids))->delete();
            PreviewBonus::whereIn('id',explode(",",$ids))->delete();
            Toastr::success('Payroll deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Payroll delete fail','Error');
            return redirect()->back();
        }
    }
}
