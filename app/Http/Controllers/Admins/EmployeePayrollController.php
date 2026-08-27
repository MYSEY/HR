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
use App\Models\LeaveAllocation;
use App\Models\ChildrenAllowance;
use App\Models\ParyllStaffResign;
use App\Models\PayrollAdjustment;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportReviewPayroll;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportEmployeeSalary;
use App\Models\LeaveRequest;
use App\Models\PreviewGrossSalaryPay;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Spatie\Activitylog\Models\Activity;
use App\Models\NationalSocialSecurityFund;
use App\Repositories\Admin\PayrollRepository;
use App\Repositories\Admin\EmployeeRepository;
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
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if (permissionAccess("m4-s2","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $data = $this->payrollRepo->getAllPayroll();
        $branch = Branchs::all();
        $Monthly= Carbon::now()->format('m');
        $yearLy = Carbon::now()->format('Y');
        $exChangeRateSalary= ExchangeRate::where('type','Salary')->orderBy('id','desc')->first();
        $exChangeRateNSSF= ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();
        return view('payrolls.index',compact('data','branch','exChangeRateSalary', 'exChangeRateNSSF'));
    }
    
    public function payrollReview(Request $request){
        if (permissionAccess("m4-s1", "is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        if (request()->ajax()) {
            // Cheap, unfiltered count for DataTables' "recordsTotal".
            $recordsTotal = payrollPreview::count();
            $query = self::getDatas($request, false);
            $recordsFiltered = $query->count();
            $start = intval($request->input('start', 0));
            $limit = min(intval($request->input('length', 10)), 100); // hard cap
            $data = $query->offset($start)->limit($limit)->get();
            return response()->json([
                'draw'            => intval($request->input('draw')),
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]);
        }

        $branch = Branchs::all();
        $exChangeRateSalary = ExchangeRate::where('type', 'Salary')->orderBy('id', 'desc')->first();
        $exChangeRateNSSF   = ExchangeRate::where('type', 'NSSF')->orderBy('id', 'desc')->first();
        return view('payrolls.review', compact('branch', 'exChangeRateSalary', 'exChangeRateNSSF'));
    }
    public function payrollPreviwExport(Request $request) {
        if (permissionAccess("m4-s1", "is_export")->value != "1") {
            abort(403);
        }
        $query = self::getDatas($request, true);
        $data  = $query->get();
        return Excel::download(new ExportReviewPayroll($data), 'ReviewPayroll.xlsx');
    }
    // public static function getDatas($request){
    //     $query = payrollPreview::leftJoin('users', 'payroll_previews.employee_id', '=', 'users.id')
    //         ->leftJoin('positions','users.position_id','=','positions.id')
    //         ->leftJoin('departments','users.department_id','=','departments.id')
    //         ->leftJoin('branchs','users.branch_id','=','branchs.id')
    //         ->leftJoin('options', 'users.gender', '=', 'options.id')
    //         ->select(
    //             'payroll_previews.*',
    //             'users.position_id',
    //             'users.department_id',
    //             'users.branch_id',
    //             'users.number_employee',
    //             'users.employee_name_en',
    //             'users.employee_name_kh',
    //             'users.date_of_commencement',
    //             'users.basic_salary',
    //             'positions.name_khmer as post_name_kh',
    //             'positions.name_english as post_name_en',
    //             'departments.name_khmer as depart_name_kh',
    //             'departments.name_english as depart_name_en',
    //             'branchs.branch_name_kh',
    //             'branchs.branch_name_en',
    //             'options.name_khmer',
    //             'options.name_english',
    //         );
    //         $query->when($request->employee_name, function ($query, $employee_name) {
    //             return $query->where('users.employee_name_en', 'LIKE', "%$employee_name%");
    //         })
    //         ->when($request->number_employee, function ($query, $number_employee) {
    //             return $query->where('users.number_employee', $number_employee);
    //         })
    //         ->when($request->branch_id, function ($query, $branch_id) {
    //             return $query->where('users.branch_id', $branch_id);
    //         })
    //         ->when($request->filter_month, function ($query, $filter_month) {
    //             return $query->whereMonth('payroll_previews.payment_date', date('m', strtotime($filter_month)));
    //         })->orderBy('users.number_employee', 'ASC');

    //         $searchValue = request()->input('search.value');
    //         if (!empty($searchValue)) {
    //             $query->where(function ($q) use ($searchValue) {
    //                 $q->where('payroll_previews.id', 'like', "%{$searchValue}%")
    //                 ->orWhere('payroll_previews.number_employee', 'like', "%{$searchValue}%")
    //                 ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
    //                 ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
    //                 ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
    //                 ->orWhere('departments.name_english', 'like', "%{$searchValue}%")
    //                 ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%");
    //             });
    //         }
    //     return $query;
    // }

    public static function getDatas(Request $request, bool $forExport = false)
    {
        $query = payrollPreview::leftJoin('users', 'payroll_previews.employee_id', '=', 'users.id')
        ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id');

        $selectColumns = [
            'payroll_previews.*',
            'users.position_id',
            'users.department_id',
            'users.branch_id',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.date_of_commencement',
            'users.basic_salary',
            'positions.name_khmer as post_name_kh',
            'positions.name_english as post_name_en',
            'departments.name_khmer as depart_name_kh',
            'departments.name_english as depart_name_en',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
        ];

        if ($forExport) {
            $query->leftJoin('options', 'users.gender', '=', 'options.id')->with('users');
            $selectColumns[] = 'options.name_khmer';
            $selectColumns[] = 'options.name_english';
        }

        $query->select($selectColumns);
        $query->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', 'LIKE', "%$employee_name%");
            })
            ->when($request->number_employee, function ($query, $number_employee) {
                return $query->where('users.number_employee', $number_employee);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                return $query->where('users.branch_id', $branch_id);
            })
            ->when($request->filter_month, function ($query, $filter_month) {
                $monthly = Carbon::parse($filter_month);
                return $query->whereBetween('payroll_previews.payment_date', [
                    $monthly->copy()->startOfMonth(),
                    $monthly->copy()->endOfMonth(),
                ]);
            })
        ->orderBy('users.number_employee', 'ASC');
        if (!$forExport) {
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    if (is_numeric($searchValue)) {
                        $q->orWhere('payroll_previews.id', $searchValue);
                    }
                    $q->orWhere('payroll_previews.number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%");
                });
            }
        }
        return $query;
    }
    public function search(Request $request) {
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll = Payroll::with("users")
        ->leftJoin('users', 'payrolls.employee_id', '=', 'users.id')
        ->select(
            'payrolls.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.branch_id',
            'users.department_id',
            'users.line_manager',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                $query->where('users.id',Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                if (permissionAccess("m4-s2", "is_view_salary_staff")->value == 1) {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }else{
                    $query->where("users.id", Auth::user()->id);
                }
            }
            if (in_array($RolePermission, ['HR', 'DHOD', 'DBM'])) {
            // if($RolePermission == 'HR' ||  $RolePermission == 'DHOD' || $RolePermission == 'DBM'){
                $query->where("users.id", Auth::user()->id);
                if (optional(permissionAccess("m4-s2", "is_view_salary_staff"))->value == 1) {
                    $query->orWhere(function ($q) {
                        $q->where("users.line_manager", Auth::user()->id);
                    });
                }
            }
            if ($RolePermission == 'BM') {
                if (permissionAccess("m4-s2", "is_view_salary_staff")->value == 1) {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }else{
                    $query->where("users.id", Auth::user()->id);
                }
            }
        })
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
        })->whereIn('users.emp_status',['Probation','1','10','2'])->orderBy('payment_date','DESC')->orderBy('id','ASC')->get();
        return response()->json([
            'success'=>$payroll,
        ]);
    }

    public function payrollStaffResignSearch(Request $request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll = ParyllStaffResign::with("users")
        ->leftJoin('users', 'paryll_staff_resigns.employee_id', '=', 'users.id')
        ->select(
            'paryll_staff_resigns.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.branch_id',
            'users.department_id',
        )->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                $query->where('users.id',Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
            }
            if($RolePermission == 'HR' ||  $RolePermission == 'DHOD' || $RolePermission == 'DBM'){
                $query->where("users.id", Auth::user()->id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            }
            if ($RolePermission == 'BM') {
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
        })
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
        })->get();
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

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $paymentDateCarbon = Carbon::parse($request->payment_date);
            $paymentMonth      = $paymentDateCarbon->format('m-Y');   // for GrossSalaryPay/SeverancePay date match
            $paymentDateYm     = $paymentDateCarbon->format('Y-m');   // for fdc_end / fdc_date month match
            $paymentDateMy     = $paymentDateCarbon->format('m-y');   // for join-date match
    
            // ---------------------------------------------------------------
            // 1. Bulk-load all spreadsheet imports (annual bonus, other benefits,
            //    incentive, loan, staff book, parking allowance) with ONE employee
            //    lookup per file instead of one query per row.
            // ---------------------------------------------------------------
            $dadaArrayAnnualBonus       = $this->importSheetToEmployeeMap($request->annual_bonus, 'Annual Bonus', 'annual_bonus');
            $dadaArrayOtherBenefit      = $this->importSheetToEmployeeMap($request->other_benefits, 'Other Benefits', 'other_benefit');
            $dadaArrayIncentive         = $this->importSheetToEmployeeMap($request->file_incentive, 'Incentive Bonus', 'incentive');
            $dadaArrayLoan              = $this->importSheetToEmployeeMap($request->file_loan, 'Loan', 'laon_amount');
            $dadaArrayStaffBook         = $this->importSheetToEmployeeMap($request->staff_book, 'Staff Book', 'total_staff_book');
            $dadaArrayParkingAllowance  = $this->importSheetToEmployeeMap($request->parking_allowance, 'parking allowance', 'totalParkingAllowance');
    
            // ---------------------------------------------------------------
            // 2. Employees for this payroll run.
            // ---------------------------------------------------------------
            $employee = User::where('date_of_commencement', '<=', $request->payment_date)->whereIn('emp_status', ['Probation', '1', '10', '2'])->get();
    
            if ($employee->isEmpty()) {
                DB::rollback();
                Toastr::error('Can not employee payroll', 'Error');
                return redirect()->back();
            }
    
            $employeeIds = $employee->pluck('id');
    
            // ---------------------------------------------------------------
            // 3. Bulk-delete previous preview rows for this batch instead of
            //    per-employee deletes inside the loop.
            // ---------------------------------------------------------------
            payrollPreview::whereIn('employee_id', $employeeIds)->delete();
            PreviewNationalSocialSecurityFund::whereIn('employee_id', $employeeIds)->delete();
            PreviewBonus::whereIn('employee_id', $employeeIds)->delete();
            GrossSalaryPay::whereIn('number_employee', $employee->pluck('number_employee'))->whereRaw("DATE_FORMAT(payment_date, '%m-%Y') = ?", [$paymentMonth])->delete();
            SeverancePay::whereIn('number_employee', $employee->pluck('number_employee'))->whereRaw("DATE_FORMAT(payment_date, '%m-%Y') = ?", [$paymentMonth])->delete();
    
            // ---------------------------------------------------------------
            // 4. Employee-independent lookups — fetched ONCE, not per employee.
            // ---------------------------------------------------------------
            $dataHolidayBunuseAll = Holiday::where('type', 'bonus')->whereYear('from', now()->year)->get();
            $childrenAllowance    = ChildrenAllowance::first();
            $exchangNSSF          = ExchangeRate::where('type', 'NSSF')->orderBy('id', 'desc')->first();
    
            // Pre-load children for all employees in one query, grouped by employee_id,
            // instead of one ChildrenInfor query per employee.
            $childrenByEmployee = ChildrenInfor::whereIn('employee_id', $employeeIds)->get()->groupBy('employee_id');
            // Pre-load payroll adjustments for all employees in one query.
            $adjustmentsByEmployee = PayrollAdjustment::whereIn('employee_id', $employeeIds)->get()->groupBy('employee_id');
    
            // Whether each employee already has any Payroll rows (used for the
            // total_gross_salary_before_pension branch). One query instead of N.
            $employeesWithPayroll = Payroll::whereIn('employee_id', $employeeIds)->distinct()->pluck('employee_id')->flip(); // isset() lookup
    
            foreach ($employee as $item) {
                $totalFirstSeverancPay   = 0;
                $totalBaseSalaryRecived  = 0;
                $totalBasicSalary        = 0;
                $monthlyQuarterlyIncentive = 0;
    
                $joinDate = Carbon::parse($item->date_of_commencement)->format('m-y');
    
                // --- Payroll adjustments (from preloaded map) ---
                $adjustmentIncludeTaxe = 0;
                $adjustmentExcludeTaxe = 0;
                foreach ($adjustmentsByEmployee->get($item->id, collect()) as $valueAdjust) {
                    $adjustmentDate = Carbon::parse($valueAdjust->adjustment_date)->format('m-y');
                    if ($adjustmentDate == $paymentDateMy) {
                        if ($valueAdjust->adjustment_type === 'include_taxe') {
                            $adjustmentIncludeTaxe += $valueAdjust->amount;
                        } else {
                            $adjustmentExcludeTaxe += $valueAdjust->amount;
                        }
                    }
                }
    
                // --- First-month-of-employment / probation-passing basic salary logic (unchanged) ---
                if ($joinDate == $paymentDateMy) {
                    $start_date = Carbon::parse($item->date_of_commencement);
                    $end_date   = $start_date->copy()->endOfMonth();
                    $toDays = $start_date->diffInDaysFiltered(function (Carbon $date) {
                        return !$date->isWeekend();
                    }, $end_date);
    
                    $joinDay        = Carbon::parse($item->date_of_commencement)->format('d');
                    $startMonth     = Carbon::parse($item->date_of_commencement)->format('m');
                    $startendMonth  = Carbon::parse($item->date_of_commencement)->endOfMonth()->format('d');
    
                    if ($joinDay == 1) {
                        $totalBasicSalary = $item->basic_salary;
                    } else {
                        if ($startMonth == 02 && $startendMonth == 28 || $startendMonth == 29) {
                            $totalBasicSalary = ($toDays == 21) ? $item->basic_salary : ($item->basic_salary / 22) * $toDays;
                        } else {
                            $totalBasicSalary = ($toDays >= 22) ? $item->basic_salary : ($item->basic_salary / 22) * $toDays;
                        }
                    }
                } else {
                    if ($item->emp_status == 1) {
                        $joinPassProbation = Carbon::parse($item->fdc_date)->format('d');
                        if ($joinPassProbation == '01') {
                            $totalBasicSalary = $item->basic_salary;
                        } else {
                            $monthToPay        = Carbon::parse($item->fdc_date)->format('Y-m');
                            $currentMonthToPay = $paymentDateYm;
                            if ($monthToPay == $currentMonthToPay) {
                                $endMonth       = Carbon::parse($item->fdc_date)->format('m');
                                $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                                $date_of_month  = Carbon::parse($item->fdc_date)->format('Y-m');
                                $currentYear    = $date_of_month . '-' . $totalDayInMonth;
    
                                $startDate = Carbon::parse($item->fdc_date);
                                $endDate   = Carbon::parse($currentYear);
                                $totalNewDays = $startDate->diffInDays($endDate) + 1;
                                $totalOldDay  = $totalDayInMonth - $totalNewDays;
    
                                $oldSalary = ($item->pre_salary * $totalOldDay) / $totalDayInMonth;
                                $newSalary = $totalOldDay ? ($item->basic_salary * $totalNewDays) / $totalDayInMonth : 0;
    
                                $totalBaseSalaryRecived = round($oldSalary, 2) + round($newSalary, 2);
                                $totalFirstSeverancPay  = round($newSalary, 2);
                            } else {
                                $totalBasicSalary = $item->basic_salary;
                            }
                        }
                    } else {
                        $totalBasicSalary = $item->basic_salary;
                    }
                }
    
                // --- Import lookups (from preloaded maps, no per-row DB hits) ---
                $monthlyQuarterlyIncentive = $dadaArrayIncentive[$item->number_employee]['incentive'] ?? 0;
                $annualBonus               = $dadaArrayAnnualBonus[$item->number_employee]['annual_bonus'] ?? 0;
                $otherBenefit              = $dadaArrayOtherBenefit[$item->number_employee]['other_benefit'] ?? 0;
                $LoanAmount                = $dadaArrayLoan[$item->number_employee]['laon_amount'] ?? 0;
                $totalStaffBook            = $dadaArrayStaffBook[$item->number_employee]['total_staff_book'] ?? 0;
                $totalParkAllowance        = $dadaArrayParkingAllowance[$item->number_employee]['totalParkingAllowance'] ?? 0;
    
                // --- Holiday bonus (uses the preloaded $dataHolidayBunuseAll, not re-queried) ---
                $totalBunus = 0;
                if (in_array($item->emp_status, [1, 10, 2])) {
                    foreach ($dataHolidayBunuseAll as $value) {
                        $fromDate = Carbon::parse($item->date_of_commencement);
                        $toDate   = Carbon::parse($value->from);
                        $totalStartDays = $fromDate->diffInDays($toDate) + 1;
                        $dayOfYear = 365;
    
                        $hildayMonth = Carbon::parse($value->period_month)->format('Y-m');
                        $payMonth    = $paymentDateYm;
                        $bounsType   = $value->title;
    
                        if ($hildayMonth == $payMonth && $hildayMonth >= $payMonth) {
                            if ($totalStartDays > $dayOfYear) {
                                $totalAllowanceBunus = $item->basic_salary * ($value->amount_percent / 100);
                            } else {
                                $totalPercent  = ($item->basic_salary * $value->amount_percent) / 100;
                                $percentSalary = $totalPercent * $totalStartDays;
                                $totalAllowanceBunus = $percentSalary / $dayOfYear;
                            }
    
                            $dataBonus = PreviewBonus::create([
                                'employee_id'            => $item->id,
                                'number_employee'        => $item->number_employee,
                                'number_of_working_days' => $totalStartDays,
                                'base_salary'            => $item->basic_salary,
                                'base_salary_received'   => $item->basic_salary,
                                'total_allowance'        => $totalAllowanceBunus,
                                'bouns_type'             => $bounsType,
                                'payment_date'           => $request->payment_date,
                                'created_by'             => $userId,
                            ]);
                            $totalBunus = $dataBonus->total_allowance ?? 0;
                        }
                    }
                }
    
                // --- Children under 18 (from preloaded map, no per-employee query) ---
                $dataDateOfBirth = [];
                foreach ($childrenByEmployee->get($item->id, collect()) as $value) {
                    $age_years = (strtotime(date('Y-m-d')) - strtotime($value->date_of_birth)) / (60 * 60 * 24 * 365.25);
                    if (round($age_years) <= 18) {
                        $dataDateOfBirth[] = $value;
                    }
                }
                $number_of_children = count($dataDateOfBirth);
    
                $totalChildAllowance = 0;
                if (in_array($item->emp_status, [1, 10, 2]) && $number_of_children > 0) {
                    $totalChildAllowance = $childrenAllowance->total_children_allowance * min($number_of_children, 4); // original code only handled up to 4 anyway
                }
    
                // --- Severance-pay-in-progress bookkeeping (unchanged logic) ---
                $SeverancePay1 = null;
                $SeverancePay2 = null;
                $totalSeniority = 0;
                $type_fdc1 = null;
                $type_fdc2 = null;
                $type_udc  = null;
    
                $totalSeverancyPaySalary = $totalBaseSalaryRecived != 0 ? $totalBaseSalaryRecived : $totalBasicSalary;
                $totalSalarySeverancyPay = $totalSeverancyPaySalary + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $otherBenefit + $annualBonus + $totalBunus + $item->phone_allowance + $totalChildAllowance;
                $totalSeverancePay = $totalFirstSeverancPay != 0 ? $totalFirstSeverancPay : $totalBasicSalary;
                $totalOtherBenefit = $totalSeverancePay + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $annualBonus + $otherBenefit + $totalBunus + $item->phone_allowance + $totalChildAllowance;
    
                if (in_array($item->emp_status, [1, 10])) {
                    $endContractDeadline = Carbon::parse($item->fdc_end)->format('Y-m');
                    if ($endContractDeadline == $paymentDateYm) {
                        $endMonth        = Carbon::parse($item->fdc_end)->format('m');
                        $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
                        $currentYear     = Carbon::parse($item->fdc_end)->format('Y-m') . '-' . $totalDayInMonth;
    
                        $startDate = Carbon::parse($item->fdc_end);
                        $endDate   = Carbon::parse($currentYear);
                        $totalNewDays = $startDate->diffInDays($endDate);
                        $totalOldDay  = $totalDayInMonth - $totalNewDays;
    
                        $SeverancePay2 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalNewDays;
                        $SeverancePay1 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalOldDay;
                        $type_fdc2 = 'FDC-2';
                        if ($item->emp_status == 10) {
                            $type_fdc1 = 'FDC-1';
                        }
    
                        $start_working_day_date = Carbon::parse($item->fdc_end);
                        $end_working_day_date   = $start_working_day_date->copy()->endOfMonth();
                        $workingDays = $start_working_day_date->diffInWeekdays($end_working_day_date);
                        if (!$start_working_day_date->isWeekend()) {
                            $workingDays += 1;
                        }
                        if ($workingDays >= 21) {
                            $type_udc = 'UDC';
                        }
    
                        $totalSeniority = $totalSalarySeverancyPay;
                        $basic1 = ($item->basic_salary / $totalDayInMonth) * $totalOldDay;
                        $basic2 = ($item->basic_salary / $totalDayInMonth) * $totalNewDays;
                        $totalBaseSalaryRecived = $basic1 + $basic2;
                    }
                }
    
                $dataTotalSeverancePay1 = $SeverancePay1 ?? $totalOtherBenefit;
                $totalSeverancePay1     = $dataTotalSeverancePay1 ?? $totalSalarySeverancyPay;
                $totalSeverancePay2     = $SeverancePay2;
                $totalBasicSalaryLast   = $totalBaseSalaryRecived != 0 ? $totalBaseSalaryRecived : $totalBasicSalary;
                $totalGrossSalary = round($totalSeverancyPaySalary, 2) + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $otherBenefit + $annualBonus + $totalBunus + $item->phone_allowance + $totalChildAllowance;
    
                $dataTotalSeverancePay2 = null;
                if ($item->emp_status == 1) {
                    $dataTotalSeverancePay2 = $SeverancePay2 ?? $totalOtherBenefit;
                }
                if ($item->emp_status == 10) {
                    $dataTotalSeverancePay2 = $SeverancePay1 ?? $totalOtherBenefit;
                }
    
                if ($item->emp_status == 'Probation') {
                    $type_fdc1 = null;
                    $totalSeverancePay1 = 0;
                }
                if ($item->emp_status == 1) {
                    $type_fdc1 = 'FDC-1';
                }
                if ($item->emp_status == 10) {
                    $type_fdc1 = null;
                    $totalSeniority = $totalSalarySeverancyPay;
                    $type_fdc2 = 'FDC-2';
                    $totalSeverancePay1 = 0;
                    $totalSeverancePay2 = $dataTotalSeverancePay2 ?? $totalSalarySeverancyPay;
                }
                if ($item->emp_status == 2) {
                    $type_udc = 'UDC';
                    $dataTotalSeverancePay1 = $SeverancePay1 ?? $totalOtherBenefit;
                    $totalSeverancePay2 = 0;
                    $totalSeniority = $dataTotalSeverancePay1 ?? $totalSalarySeverancyPay;
                }
    
                $dataGrossSalary = GrossSalaryPay::create([
                    'employee_id'         => $item->id,
                    'number_employee'     => $item->number_employee,
                    'basic_salary'        => $item->basic_salary,
                    'total_gross_salary'  => round($totalGrossSalary, 2),
                    'total_fdc1'          => round($totalSeverancePay1, 2),
                    'total_fdc2'          => round($totalSeverancePay2, 2),
                    'total_seniority'     => round($totalSeniority, 2),
                    'payment_date'        => $request->payment_date,
                    'type_fdc1'           => $type_fdc1,
                    'type_fdc2'           => $type_fdc2,
                    'type_udc'            => $type_udc,
                    'created_by'          => $userId,
                ]);
    
                // --- Seniority tax (June / December UDC average, unchanged) ---
                $seniorityPayableTax = 0;
                $taxExemptionSalary  = 0;
                $totaltaxableSalary  = 0;
    
                if ($item->emp_status == 2) {
                    $currentDate = $paymentDateCarbon->format('m');
                    $PaymentOfMonth = $paymentDateCarbon->format('M-Y');
    
                    if ($currentDate == 6 || $currentDate == 12) {
                        $nextYear = $paymentDateCarbon->format('Y');
                        $currentYear  = $currentDate == 6 ? Carbon::parse($nextYear . '-01-01')->format('Y-m-d') : null;
                        $currentMonth = $currentDate == 12 ? Carbon::parse($nextYear . '-07-01')->format('Y-m-d') : null;
    
                        $totalSalary = GrossSalaryPay::where('employee_id', $item->id)->where('type_udc', 'UDC')->when($currentYear, fn ($q, $d) => $q->where('payment_date', '>=', $d))->when($currentMonth, fn ($q, $d) => $q->where('payment_date', '>=', $d))->pluck('total_seniority')->avg();
    
                        $totalAVG = (round($totalSalary, 2) * 7.5) / 22;
                        $totalSalaryReceive = $totalAVG;
                        $totalGrossExchange = 2000000 / $request->exchange_rate;
                        $totalGrossInclucTax = round($totalGrossExchange, 2);
    
                        $taxExemptionSalary = min($totalSalaryReceive, $totalGrossInclucTax);
                        $totaltaxableSalary = max($totalSalaryReceive - $totalGrossInclucTax, 0);
    
                        Seniority::where('number_employee', $item->number_employee)->where('payment_date', $request->payment_date)->delete();
    
                        $seniority = Seniority::create([
                            'employee_id'          => $item->id,
                            'number_employee'      => $item->number_employee,
                            'total_average_salary' => $totalSalary,
                            'total_salary_receive' => $totalSalaryReceive,
                            'tax_exemption_salary' => $taxExemptionSalary,
                            'taxable_salary'       => $totaltaxableSalary,
                            'payment_of_month'     => $PaymentOfMonth,
                            'payment_date'         => $request->payment_date,
                            'created_by'           => $userId,
                        ]);
                        $seniorityPayableTax = $seniority->taxable_salary ?? 0;
                        $taxExemptionSalary  = $seniority->tax_exemption_salary ?? 0;
                    }
                }
    
                $totalGrossSalaryBeforpension = isset($employeesWithPayroll[$item->id]) ? $dataGrossSalary->total_gross_salary + $totaltaxableSalary : $totalGrossSalary + $totaltaxableSalary;
    
                // --- NSSF pension contribution (uses preloaded $exchangNSSF) ---
                $pension_contribution = 0;
                $dataNSSF = null;
                if ($item->is_type_nssf != 1 && $exchangNSSF) {
                    $totalExchangeRielPreTax = $exchangNSSF->amount_riel * round($totalGrossSalaryBeforpension, 2);
    
                    if ($totalExchangeRielPreTax) {
                        if ($totalExchangeRielPreTax >= 1200000) {
                            $averageWage = 1200000;
                        } elseif ($totalExchangeRielPreTax >= 400000) {
                            $averageWage = $totalExchangeRielPreTax;
                        } else {
                            $averageWage = 400000;
                        }
                    } else {
                        $averageWage = 0;
                    }
    
                    $occupationalRisk = 0.008 * $averageWage;
                    $healthCare       = 0.026 * $averageWage;
                    $workerContributionUsd = $averageWage * 0.02;
    
                    $workerContributionRiel = 0;
                    $yearsOfEmployee = Carbon::parse($item->date_of_birth)->age;
                    if ($yearsOfEmployee < 60) {
                        $workerContributionRiel = round($workerContributionUsd, 0) / $exchangNSSF->amount_riel;
                    }
    
                    $dataNSSF = PreviewNationalSocialSecurityFund::create([
                        'employee_id'               => $item->id,
                        'number_employee'           => $item->number_employee,
                        'total_pre_tax_salary_usd'  => round($totalGrossSalaryBeforpension, 2),
                        'total_pre_tax_salary_riel' => $totalExchangeRielPreTax,
                        'total_average_wage'        => $averageWage,
                        'total_occupational_risk'   => $occupationalRisk,
                        'total_health_care'         => $healthCare,
                        'pension_contribution_usd'  => round($workerContributionUsd, 0),
                        'pension_contribution_riel' => $workerContributionRiel,
                        'corporate_contribution'    => round($workerContributionUsd, 0),
                        'exchange_rate'             => $exchangNSSF->amount_riel,
                        'payment_date'              => $request->payment_date,
                        'created_by'                => $userId,
                    ]);
                    $pension_contribution = round($dataNSSF->pension_contribution_riel, 2);
                }
    
                $totalGrossAfterPension = $totalGrossSalaryBeforpension - $pension_contribution;
                $totalExchangeRiel = round($totalGrossAfterPension, 2) * $request->exchange_rate;
    
                // --- Charges reduced (children/spouse allowance deduction base) ---
                $totalChargesReducedChild  = $childrenAllowance->reduced_burden_children;
                $totalChargesReducedSpouse = $childrenAllowance->spouse_allowance;
    
                $cappedChildren = min($number_of_children, 4);
                $hasSpouse = (bool) $item->spouse;
    
                // Reproduces the original branch table exactly:
                // 0 children + no spouse -> 0 (falls through to the "no reduction" cases below)
                if ($cappedChildren == 0 && !$hasSpouse) {
                    $totalChargesReduced = 0;
                } else {
                    $totalChargesReduced = ($cappedChildren * $totalChargesReducedChild) + ($hasSpouse ? $totalChargesReducedSpouse : 0);
                }
    
                $totalTtaxBbaseRiel = ($cappedChildren == 0 && !$hasSpouse) ? $totalExchangeRiel : $totalExchangeRiel - $totalChargesReduced;
    
                $children = $number_of_children;
    
                // Tax base differs only for the "0 children, no spouse" case (uses
                // $totalExchangeRiel directly instead of $totalTtaxBbaseRiel) — identical
                // to the original since $totalTtaxBbaseRiel == $totalExchangeRiel there anyway.
                [$totalTax, $totalSalaryTaxRiel, $totalSalaryTaxUsd, $totalSalaryAfterTax] = $this->calculateSalaryTax($totalTtaxBbaseRiel, $request->exchange_rate, $totalGrossAfterPension);
    
                // --- Contract-end severance pay (FDC-1 / FDC-2) ---
                $totalSeverancePay = 0;
                $monthEndDate = Carbon::parse($item->fdc_end)->format('Y-m');
    
                if ($item->emp_status == 1 && $monthEndDate == $paymentDateYm) {
                    $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc1')->sum('total_fdc1');
                    $totalContractSeverancePay = $dataSeveranc * 0.05;
                    $dataSeverance = SeverancePay::create([
                        'employee_id'                  => $item->id,
                        'number_employee'              => $item->number_employee,
                        'total_severanec_pay'          => round($dataSeveranc, 2),
                        'total_contract_severance_pay' => round($totalContractSeverancePay, 2),
                        'payment_date'                 => $request->payment_date,
                        'type'                         => 'FDC-1',
                        'created_by'                   => $userId,
                    ]);
                    $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
                }
    
                if ($item->emp_status == 10 && $monthEndDate == $paymentDateYm) {
                    $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->where('number_employee', $item->number_employee)->whereNotNull('type_fdc2')->sum('total_fdc2');
                    $totalContractSeverancePay = $dataSeveranc * 0.05;
                    $dataSeverance = SeverancePay::create([
                        'employee_id'                  => $item->id,
                        'number_employee'              => $item->number_employee,
                        'total_severanec_pay'          => round($dataSeveranc, 2),
                        'total_contract_severance_pay' => round($totalContractSeverancePay, 2),
                        'payment_date'                 => $request->payment_date,
                        'type'                         => 'FDC-2',
                        'created_by'                   => $userId,
                    ]);
                    $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
                }
    
                $totalSalaryBeforPension = $totalSalaryAfterTax + $totalSeverancePay + $adjustmentExcludeTaxe + $taxExemptionSalary + $totalParkAllowance;
                $totalNetSalary = $totalSalaryBeforPension - $LoanAmount - $totalStaffBook;
    
                $data = $request->all();
                $data['employee_id']                = $item->id;
                $data['number_employee']            = $item->number_employee;
                $data['basic_salary']               = $item->basic_salary;
                $data['spouse']                     = $item->spouse;
                $data['children']                   = $children;
                $data['total_gross_salary']         = $totalBasicSalaryLast;
                $data['total_child_allowance']      = $totalChildAllowance;
                $data['phone_allowance']            = $item->phone_allowance;
                $data['total_kny_phcumben']         = $totalBunus;
                $data['monthly_quarterly_bonuses']  = $monthlyQuarterlyIncentive;
                $data['annual_incentive_bonus']     = $annualBonus;
                $data['other_benefits']             = $otherBenefit;
                $data['total_severance_pay']        = round($totalSeverancePay, 3);
                $data['seniority_pay_included_tax'] = $seniorityPayableTax;
                $data['total_gross']                = $totalGrossSalaryBeforpension;
                $data['total_pension_fund']         = $pension_contribution;
                $data['base_salary_received_usd']   = $totalGrossAfterPension;
                $data['base_salary_received_riel']  = round($totalExchangeRiel, 3);
                $data['total_tax_base_riel']        = round($totalTtaxBbaseRiel, 3);
                $data['total_charges_reduced']      = $totalChargesReduced;
                $data['total_rate']                 = $totalTax;
                $data['seniority_pay_excluded_tax'] = $taxExemptionSalary;
                $data['total_salary_tax_riel']      = round($totalSalaryTaxRiel, 3);
                $data['total_salary_tax_usd']       = $totalSalaryTaxUsd;
                $data['loan_amount']                = $LoanAmount;
                $data['total_staff_book']           = $totalStaffBook;
                $data['adjustment']                 = $adjustmentExcludeTaxe;
                $data['adjustment_include_taxe']    = $adjustmentIncludeTaxe;
                $data['total_amount_car']           = $totalParkAllowance;
                $data['total_salary']               = $totalNetSalary;
                $data['exchange_rate']              = $request->exchange_rate;
                $data['created_by']                 = $userId;
    
                payrollPreview::create($data);
            }
    
            DB::commit();
            Toastr::success('Created payroll successfully.', 'Success');
            return redirect()->back();
    
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Payroll created fail', 'Error');
            // While debugging, consider logging the real exception rather than swallowing it:
            // \Log::error('Payroll store failed: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back();
        }
    }

    private function importSheetToEmployeeMap($uploadedFile, string $sheetName, string $valueKey): array
    {
        $result = [];
        if (!$uploadedFile || !($uploadedFile instanceof \Illuminate\Http\UploadedFile) || !$uploadedFile->isValid()) {
            return $result;
        }
        $extension = $uploadedFile->extension();
        if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
            return $result;
        }
        $spreadsheet = IOFactory::load($uploadedFile->getRealPath());
        $sheet = $spreadsheet->getSheetByName($sheetName);
        if (!$sheet) {
            return $result;
        }
        $rows = $sheet->toArray();
        if (count($rows) <= 1) {
            return $result; // header only / empty
        }
    
        // Row 0 is the header — skip it, collect the rest.
        $rows = array_slice($rows, 1);
        $numberEmployees = array_column($rows, 0);
        $employeesByNumber = User::whereIn('number_employee', $numberEmployees)->get()->keyBy('number_employee');
        foreach ($rows as $row) {
            $numberEmployee = $row[0] ?? null;
            if ($numberEmployee !== null && $employeesByNumber->has($numberEmployee)) {
                $result[$numberEmployee] = [$valueKey => $row[2] ?? null];
            }
        }
        return $result;
    }
    private function calculateSalaryTax(float $taxableBaseRiel, float $exchangeRate, float $grossAfterPension): array
    {
        if ($taxableBaseRiel > 0 && $taxableBaseRiel <= 1500000) {
            $rate = 0;
        } elseif ($taxableBaseRiel > 1500001 && $taxableBaseRiel <= 2000000) {
            $rate = 5;
        } elseif ($taxableBaseRiel > 2000001 && $taxableBaseRiel <= 8500000) {
            $rate = 10;
        } elseif ($taxableBaseRiel > 8500001 && $taxableBaseRiel <= 12500000) {
            $rate = 15;
        } else {
            $rate = 20;
        }
    
        if ($taxableBaseRiel <= 1500000) {
            $taxRiel = 0;
        } elseif ($taxableBaseRiel > 1500001 && $taxableBaseRiel <= 2000000) {
            $taxRiel = ($taxableBaseRiel * $rate) / 100 - 75000;
        } elseif ($taxableBaseRiel > 2000001 && $taxableBaseRiel <= 8500000) {
            $taxRiel = ($taxableBaseRiel * $rate) / 100 - 175000;
        } elseif ($taxableBaseRiel > 8500001 && $taxableBaseRiel <= 12500000) {
            $taxRiel = ($taxableBaseRiel * $rate) / 100 - 600000;
        } else {
            $taxRiel = ($taxableBaseRiel * $rate) / 100 - 1225000;
        }
    
        $taxUsd = round($taxRiel, 2) / $exchangeRate;
        $salaryAfterTax = $grossAfterPension - round($taxUsd, 2);

        return [$rate, $taxRiel, $taxUsd, $salaryAfterTax];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     try{
    //         $dadaArrayAnnualBonus = [];
    //         if (file_exists($request->annual_bonus)) {
    //             $file_annual_bonus = $request->annual_bonus;
    //             $extension = $request->annual_bonus->extension();
    //             $spreadsheet_annual_bonus = IOFactory::load($file_annual_bonus);
    //             $dataImportAnnualBonus =  $spreadsheet_annual_bonus->getSheetByName('Annual Bonus')->toArray();
    //             if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
    //                 $index = 0;
    //                 foreach ($dataImportAnnualBonus as $rowOther) {
    //                     $index++;
    //                     if ($index != 1) {
    //                         $dataAnnualBonus = User::where("number_employee", $rowOther[0])->first();
    //                         if($dataAnnualBonus){
    //                             $dadaArrayAnnualBonus[$dataAnnualBonus->number_employee] = [
    //                                 'annual_bonus' => $rowOther[2]
    //                             ];
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         $dadaArrayOtherBenefit = [];
    //         if (file_exists($request->other_benefits)) {
    //             $file_other_benefits = $request->other_benefits;
    //             $spreadsheet_other_benefits = IOFactory::load($file_other_benefits);
    //             $otherBenefits =  $spreadsheet_other_benefits->getSheetByName('Other Benefits')->toArray();
    //             $filesize = filesize($file_other_benefits);
    //             $extension = $request->other_benefits->extension();
    //             $index = 0;
    //             foreach ($otherBenefits as $rowOther) {
    //                 $index++;
    //                 if ($index != 1) {
    //                     $otherBenefitEmployee = User::where("number_employee", $rowOther[0])->first();
    //                     if($otherBenefitEmployee){
    //                         $dadaArrayOtherBenefit[$otherBenefitEmployee->number_employee] = [
    //                             'other_benefit' => $rowOther[2]
    //                         ];
    //                     }
    //                 }
    //             }
    //         }
    
    //         $dadaArrayIncentive = [];
    //         if (file_exists($request->file_incentive)) {
    //             $fileIincentive = $request->file_incentive;
    //             $spreadsheet = IOFactory::load($fileIincentive);
    //             $Incentive =  $spreadsheet->getSheetByName('Incentive Bonus')->toArray();
    //             $iIn = 0;
    //             foreach ($Incentive as $itemIncen) {
    //                 $iIn++;
    //                 if ($iIn != 1) {
    //                     $employeeIncentive = User::where("number_employee", $itemIncen[0])->first();
    //                     if($employeeIncentive){
    //                         $dadaArrayIncentive[$employeeIncentive->number_employee] = [
    //                             'incentive' => $itemIncen[2]
    //                         ];
    //                     }
    //                 }
    //             }
    //         }
    //         $dadaArrayLoan = [];
    //         if (file_exists($request->file_loan)) {
    //             $fileLoan = $request->file_loan;
    //             $spreadsheet = IOFactory::load($fileLoan);
    //             $staffLoan =  $spreadsheet->getSheetByName('Loan')->toArray();
    //             $iIn = 0;
    //             foreach ($staffLoan as $itemLoan) {
    //                 $iIn++;
    //                 if ($iIn != 1) {
    //                     $employeeIncentive = User::where("number_employee", $itemLoan[0])->first();
    //                     if($employeeIncentive){
    //                         $dadaArrayLoan[$employeeIncentive->number_employee] = [
    //                             'laon_amount' => $itemLoan[2]
    //                         ];
    //                     }
    //                 }
    //             }
    //         }
    //         $dadaArrayStaffBook = [];
    //         if (file_exists($request->staff_book)) {
    //             $file_staff_book = $request->staff_book;
    //             $extension = $request->staff_book->extension();
    //             $spreadsheet_staff_book = IOFactory::load($file_staff_book);
    //             $dataImportStaffBook =  $spreadsheet_staff_book->getSheetByName('Staff Book')->toArray();
    //             if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
    //                 $index = 0;
    //                 foreach ($dataImportStaffBook as $itemStaffBook) {
    //                     $index++;
    //                     if ($index != 1) {
    //                         $dataStaffBook = User::where("number_employee", $itemStaffBook[0])->first();
    //                         if($dataStaffBook){
    //                             $dadaArrayStaffBook[$dataStaffBook->number_employee] = [
    //                                 'total_staff_book' => $itemStaffBook[2]
    //                             ];
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         $dadaArrayParkingAllowance = [];
    //         if (file_exists($request->parking_allowance)) {
    //             $fileParkingAllowance = $request->parking_allowance;
    //             $extension = $request->parking_allowance->extension();
    //             $spreadsheet_parking_allowance = IOFactory::load($fileParkingAllowance);
    //             $parkingAllowance =  $spreadsheet_parking_allowance->getSheetByName('parking allowance')->toArray();
    //             if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
    //                 $index = 0;
    //                 foreach ($parkingAllowance as $itemPar) {
    //                     $index++;
    //                     if ($index != 1) {
    //                         $dataParkAll = User::where("number_employee", $itemPar[0])->first();
    //                         if($dataParkAll){
    //                             $dadaArrayParkingAllowance[$dataParkAll->number_employee] = [
    //                                 'totalParkingAllowance' => $itemPar[2]
    //                             ];
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $employee = User::where('date_of_commencement','<=',$request->payment_date)->whereIn('emp_status',['Probation','1','10','2'])->get();
    //         if (!$employee->isEmpty()) {
    //             foreach ($employee as $item) {
    //                 $paymentMonth = date('m-Y', strtotime($request->payment_date));
    //                 payrollPreview::where('employee_id', $item->id)->delete();
    //                 PreviewNationalSocialSecurityFund::where('employee_id', $item->id)->delete();
    //                 GrossSalaryPay::where('number_employee', $item->number_employee)->whereRaw("DATE_FORMAT(payment_date, '%m-%Y') = ?", [$paymentMonth])->delete();
    //                 SeverancePay::where('number_employee', $item->number_employee)->whereRaw("DATE_FORMAT(payment_date, '%m-%Y') = ?", [$paymentMonth])->delete();
    //                 PreviewBonus::where('employee_id', $item->id)->delete();
    //                 $totalFirstSeverancPay = 0;
    //                 $totalBaseSalaryRecived = 0;
    //                 $totalBasicSalary = 0;
    //                 $monthlyQuarterlyIncentive = 0;
    //                 $joinDate = Carbon::createFromDate($item->date_of_commencement)->format('m-y');
    //                 $paymentDate = Carbon::createFromDate($request->payment_date)->format('m-y');
    //                 $dataPayrollAdjustment = PayrollAdjustment::where('employee_id',$item->id)->get();
    //                 $adjustmentIncludeTaxe = 0;
    //                 $adjustmentExcludeTaxe = 0;
    //                 foreach ($dataPayrollAdjustment as $valueAdjust) {
    //                     $adjustmentDate = Carbon::createFromDate($valueAdjust->adjustment_date)->format('m-y');
    //                     if($adjustmentDate == $paymentDate){
    //                         if ($valueAdjust->adjustment_type === 'include_taxe') {
    //                             $adjustmentIncludeTaxe += $valueAdjust->amount;
    //                         } else {
    //                             $adjustmentExcludeTaxe += $valueAdjust->amount;
    //                         }
    //                     }
    //                 }
    //                 if ($joinDate == $paymentDate) {
    //                     //total day in monthsd
    //                     // $start_date = Carbon::createFromDate($item->date_of_commencement);
    //                     // $endMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth();
    //                     // $end_date = Date::createFromDate($endMonth);
    //                     // $commencementDate   = Carbon::parse($start_date);
    //                     // $resumptionDate     = Carbon::parse($end_date);
    //                     // $isCommencementWeekday = !$commencementDate->isWeekend();
    //                     // $toDays 		    = $resumptionDate->diffInWeekdays($commencementDate) + ($isCommencementWeekday ? 1 : 0);

    //                     $start_date = Carbon::parse($item->date_of_commencement);
    //                     $end_date   = $start_date->copy()->endOfMonth();
    //                     // Count working days (Mon–Fri)
    //                     $toDays = $start_date->diffInDaysFiltered(function (Carbon $date) {
    //                         return !$date->isWeekend(); // Exclude Saturday/Sunday
    //                     }, $end_date);

    //                     $joinDate = Carbon::createFromDate($item->date_of_commencement)->format('d');
    //                     $startMonth = Carbon::createFromDate($item->date_of_commencement)->format('m');
    //                     $startendMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth()->format('d');
    //                     if ($joinDate==1) {
    //                         $totalBasicSalary = $item->basic_salary;
    //                     } else {
    //                         if ($startMonth == 02 && $startendMonth == 28 || $startendMonth == 29) {
    //                             if ($toDays == 21) {
    //                                 $totalBasicSalary = $item->basic_salary;
    //                             } else {
    //                                 $totalBasicSalary = ($item->basic_salary / 22) * $toDays;
    //                             }
    //                         }else{
    //                             if ($toDays >= 22) {
    //                                 $totalBasicSalary = $item->basic_salary;
    //                             }else{
    //                                 $totalBasicSalary = ($item->basic_salary / 22) * $toDays;
    //                             }
    //                         }
    //                     }
    //                 } else {
    //                     if ($item->emp_status == 1) {
    //                         $joinPassProbation = Carbon::createFromDate($item->fdc_date)->format('d');
    //                         if($joinPassProbation == '01'){
    //                             $totalBasicSalary = $item->basic_salary;
    //                         }else{
    //                             $monthToPay = Carbon::createFromDate($item->fdc_date)->format('Y-m');
    //                             $currentMonthToPay = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                             if($monthToPay == $currentMonthToPay){
    //                                 //function get first severance pay
    //                                 $endMonth = Carbon::createFromDate($item->fdc_date)->format('m');
    //                                 $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
    //                                 //find start date employee join date
    //                                 $date_of_month = Carbon::createFromDate($item->fdc_date)->format('Y-m');
    //                                 $currentYear = $date_of_month.'-'.$totalDayInMonth;
    //                                 //find total working day in month
    //                                 $startDate = Carbon::parse($item->fdc_date);
    //                                 $endDate = Carbon::parse($currentYear);
    //                                 //total day in  passt probation and total salary passt probation days
    //                                 $totalNewDays = $startDate->diffInDays($endDate) + 1;
    //                                 //total day in  probation and total salary in probation days
    //                                 $totalOldDay = $totalDayInMonth - $totalNewDays;
    //                                 //old salary
    //                                 $oldSalary = ($item->pre_salary * $totalOldDay) / $totalDayInMonth;

    //                                 $newSalary = 0;
    //                                 if ($totalOldDay) {
    //                                     $newSalary = ($item->basic_salary * $totalNewDays) / $totalDayInMonth;
    //                                 }
    //                                 $totalBaseSalaryRecived = round($oldSalary,2) + round($newSalary,2);
    //                                 $totalFirstSeverancPay = round($newSalary,2);
    //                             }else{
    //                                 $totalBasicSalary = $item->basic_salary;
    //                             }
    //                         }
    //                     }else{
    //                         $totalBasicSalary = $item->basic_salary;
    //                     }
    //                 }
                    
    //                 if (array_key_exists($item->number_employee, $dadaArrayIncentive)) {
    //                     $monthlyQuarterlyIncentive = $dadaArrayIncentive[$item->number_employee]['incentive'];
    //                 } else {
    //                    $monthlyQuarterlyIncentive = 0;
    //                 }
    //                 if (array_key_exists($item->number_employee, $dadaArrayAnnualBonus)) {
    //                     $annualBonus = $dadaArrayAnnualBonus[$item->number_employee]['annual_bonus'];
    //                 } else {
    //                    $annualBonus = 0;
    //                 }
    //                 if (array_key_exists($item->number_employee, $dadaArrayOtherBenefit)) {
    //                     $otherBenefit = $dadaArrayOtherBenefit[$item->number_employee]['other_benefit'];
    //                 } else {
    //                    $otherBenefit = 0;
    //                 }
    //                 if (array_key_exists($item->number_employee, $dadaArrayLoan)) {
    //                     $LoanAmount = $dadaArrayLoan[$item->number_employee]['laon_amount'];
    //                 } else {
    //                    $LoanAmount = 0;
    //                 }
    //                 if (array_key_exists($item->number_employee, $dadaArrayStaffBook)) {
    //                     $totalStaffBook = $dadaArrayStaffBook[$item->number_employee]['total_staff_book'];
    //                 } else {
    //                    $totalStaffBook = 0;
    //                 }
    //                 if (array_key_exists($item->number_employee, $dadaArrayParkingAllowance)) {
    //                     $totalParkAllowance = $dadaArrayParkingAllowance[$item->number_employee]['totalParkingAllowance'];
    //                 } else {
    //                    $totalParkAllowance = 0;
    //                 }
                    
    //                 $totalBunus = 0;
    //                 if ($item->emp_status == 1 || $item->emp_status == 10 || $item->emp_status == 2) {
    //                     $dataHolidayBunuse = Holiday::where('type','bonus')->whereYear('from', now()->year)->get();
    //                     foreach ($dataHolidayBunuse as $value) {
    //                         $userJoinDate = $item->date_of_commencement;
    //                         $dayOfYear = 365;
    //                         $fromDate = Carbon::parse($userJoinDate);
    //                         $toDate = Carbon::parse($value->from);

    //                         $totalStartDays = $fromDate->diffInDays($toDate) + 1;
    //                         $hildayMonth = Carbon::createFromDate($value->period_month)->format('Y-m');
    //                         $hildayDays = Carbon::createFromDate($value->period_month)->format('Y-m');
    //                         $payMonth = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                         $payDays = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                         $bounsType = $value->title;
    //                         if($hildayMonth == $payMonth && $hildayDays >= $payDays){
    //                             if ($totalStartDays > $dayOfYear) {
    //                                 $percent = $value->amount_percent / 100;
    //                                 $totalAllowanceBunus = ($item->basic_salary * $percent);
    //                             } else {
    //                                 $totalPercent = ($item->basic_salary * $value->amount_percent) / 100;
    //                                 $percentSalary = $totalPercent * $totalStartDays;
    //                                 $totalAllowanceBunus = $percentSalary / $dayOfYear;
    //                             }
    //                             $dataBonus = PreviewBonus::create([
    //                                 'employee_id'               => $item->id,
    //                                 'number_employee'           => $item->number_employee,
    //                                 'number_of_working_days'    => $totalStartDays,
    //                                 'base_salary'               => $item->basic_salary,
    //                                 'base_salary_received'      => $item->basic_salary,
    //                                 'total_allowance'           => $totalAllowanceBunus,
    //                                 'bouns_type'                => $bounsType,
    //                                 'payment_date'              => $request->payment_date,
    //                                 'created_by'                => Auth::user()->id,
    //                             ]);
    //                         }
    //                         $totalBunus = $dataBonus->total_allowance ?? 0;
    //                     }
    //                 }

    //                 $dataDateOfBirth = [];
    //                 $dataChildren = ChildrenInfor::where('employee_id',$item->id)->get();
    //                 foreach ($dataChildren as $value) {
    //                     $birth_date = $value->date_of_birth;
    //                     $current_date = date('Y-m-d');
    //                     $birth_timestamp = strtotime($birth_date);
    //                     $current_timestamp = strtotime($current_date);
    //                     $diff_seconds = $current_timestamp - $birth_timestamp;
    //                     $age_years = $diff_seconds / (60 * 60 * 24 * 365.25);
    //                     $yearsOfChild = round($age_years);
    //                     if ($yearsOfChild <= 18) {
    //                         $dataDateOfBirth[] = $value;
    //                     }
    //                 }
                    
    //                 $number_of_children = count($dataDateOfBirth);
    //                 $childrenAllowance = ChildrenAllowance::first();
    //                 $totalChildAllowance = 0;
    //                 if ($item->emp_status == 1 || $item->emp_status == 10 || $item->emp_status == 2) {
    //                     if ($number_of_children) {
    //                         if ($number_of_children == 0) {
    //                             $totalChildAllowance = 0;
    //                         } else if($number_of_children == 1) {
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 1;
    //                         }else if($number_of_children == 2){
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 2;
    //                         }else if($number_of_children == 3){
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 3;
    //                         }else if($number_of_children == 4){
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 4;
    //                         }
    //                     }
    //                 }
                    
    //                 $SeverancePay1 = null;
    //                 $SeverancePay2 = null;
    //                 $totalSeniority = 0;
    //                 $basic1 = 0;
    //                 $basic2 = 0;
    //                 $type_fdc1 = null;
    //                 $type_fdc2 = null;
    //                 $type_udc = null;
    //                 $totalSeverancyPaySalary = $totalBaseSalaryRecived != 0 ? $totalBaseSalaryRecived : $totalBasicSalary;
    //                 $totalSalarySeverancyPay = $totalSeverancyPaySalary + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $otherBenefit + $annualBonus + $totalBunus + $item->phone_allowance + $totalChildAllowance;
    //                 $totalSeverancePay = $totalFirstSeverancPay != 0 ? $totalFirstSeverancPay : $totalBasicSalary;
    //                 $totalOtherBenefit = $totalSeverancePay + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $annualBonus + $otherBenefit + $totalBunus + $item->phone_allowance + $totalChildAllowance;
    //                 if ($item->emp_status == 1 || $item->emp_status == 10) {
    //                     $endContractDeadline= Carbon::createFromDate($item->fdc_end)->format('Y-m');
    //                     $paymentDate = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                     if($endContractDeadline == $paymentDate){
    //                         $endMonth = Carbon::createFromDate($item->fdc_end)->format('m');
    //                         $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
    //                         $contract_deadline = Carbon::createFromDate($item->fdc_end)->format('Y-m');
    //                         $currentYear = $contract_deadline.'-'.$totalDayInMonth;
    //                         $startDate = Carbon::parse($item->fdc_end);
    //                         $endDate = Carbon::parse($currentYear);
    //                         $totalNewDays = $startDate->diffInDays($endDate);
    //                         $SeverancePay2 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalNewDays;
    //                         $totalOldDay = $totalDayInMonth - $totalNewDays;
    //                         $SeverancePay1 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalOldDay;
    //                         $type_fdc2 = 'FDC-2';
    //                         if ($item->emp_status == 10) {
    //                             $type_fdc1 = 'FDC-1';
    //                         }

    //                         $start_working_day_date = Carbon::parse($item->fdc_end);
    //                         $end_working_day_date = $start_working_day_date->copy()->endOfMonth();
    //                         $workingDays = $start_working_day_date->diffInWeekdays($end_working_day_date);
    //                         if (!$start_working_day_date->isWeekend()) {
    //                             $workingDays += 1;
    //                         }
    //                         if ($workingDays >= 21) {
    //                             $type_udc = 'UDC';
    //                         }
                            
    //                         $totalSeniority = $totalSalarySeverancyPay;
    //                         $basic1 = ($item->basic_salary / $totalDayInMonth) * $totalOldDay;
    //                         $basic2 = ($item->basic_salary / $totalDayInMonth) * $totalNewDays;
    //                         $totalBaseSalaryRecived =  $basic1 + $basic2;
    //                     }
    //                 }
    //                 $dataTotalSeverancePay1 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
    //                 $totalSeverancePay1 =  $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 : $totalSalarySeverancyPay;
    //                 $totalSeverancePay2 = $SeverancePay2;
    //                 $totalBasicSalaryLast = $totalBaseSalaryRecived != 0 ? $totalBaseSalaryRecived : $totalBasicSalary;
    //                 $totalGrossSalary = (round($totalSeverancyPaySalary,2) + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $otherBenefit + $annualBonus + $totalBunus + $item->phone_allowance + $totalChildAllowance);
    //                 if($item->emp_status == 1){
    //                     $dataTotalSeverancePay2 = $SeverancePay2 != null ? $SeverancePay2 : $totalOtherBenefit;
    //                 }
    //                 if($item->emp_status == 10){
    //                     $dataTotalSeverancePay2 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
    //                 }
                    
    //                 if ($item->emp_status == 'Probation') {
    //                     $type_fdc1 = null;
    //                     $totalSeverancePay1 = 0;
    //                 } 
    //                 if($item->emp_status == 1) {
    //                     $type_fdc1 = 'FDC-1';
    //                 }
    //                 if($item->emp_status == 10){
    //                     $type_fdc1 = null;
    //                     $totalSeniority = $totalSalarySeverancyPay;
    //                     $type_fdc2 = 'FDC-2';
    //                     $totalSeverancePay1 = 0;
    //                     $totalSeverancePay2 = $dataTotalSeverancePay2 != null ? $dataTotalSeverancePay2 : $totalSalarySeverancyPay;
    //                 }
    //                 if($item->emp_status == 2){
    //                     $type_udc = 'UDC';
    //                     $totalSeverancePay1 = $totalSeverancePay1;
    //                     $totalSeverancePay2 = 0;
    //                     $dataTotalSeverancePay1 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
    //                     $totalSeniority = $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 : $totalSalarySeverancyPay;
    //                 }
                    
    //                 $dataGrossSalary = GrossSalaryPay::create([
    //                     'employee_id'               => $item->id,
    //                     'number_employee'           => $item->number_employee,
    //                     'basic_salary'              => $item->basic_salary,
    //                     'total_gross_salary'        => round($totalGrossSalary,2),
    //                     'total_fdc1'                => round($totalSeverancePay1,2),
    //                     'total_fdc2'                => round($totalSeverancePay2,2),
    //                     'total_seniority'           => round($totalSeniority,2),
    //                     'payment_date'              => $request->payment_date,
    //                     'type_fdc1'                 => $type_fdc1,
    //                     'type_fdc2'                 => $type_fdc2,
    //                     'type_udc'                  => $type_udc,
    //                     'created_by'                => Auth::user()->id
    //                 ]);

    //                 $seniorityPayableTax = 0;
    //                 $taxExemptionSalary = 0;
    //                 $totaltaxableSalary = 0;
    //                 if ($item->emp_status == 2) {
    //                     $currentDate = Carbon::createFromDate($request->payment_date)->format('m');
    //                     $PaymentOfMonth = Carbon::parse($request->payment_date)->format('M-Y');
    //                     if ($currentDate == 6 || $currentDate == 12) {
    //                         $nextYear = Carbon::createFromDate($request->payment_date)->format('Y');
    //                         $currentYear = null;
    //                         $currentMonth = null;
    //                         if($currentDate == 6){  
    //                             $currentYear =  Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d');
    //                         }
    //                         if ($currentDate == 12) {
    //                             $currentMonth = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
    //                         }
    //                         $totalSalary = GrossSalaryPay::where('employee_id', $item->id)->where('type_udc','UDC')->when($currentYear ,function ($query, $udc_end_date) {
    //                             $query->where('payment_date', '>=',$udc_end_date);
    //                         })->when($currentMonth, function($query, $currentMonth){
    //                             $query->where('payment_date', '>=',$currentMonth);
    //                         })->pluck('total_seniority')->avg();

    //                         $totalAVG = (round($totalSalary,2) * 7.5) / 22;
    //                         $totalSalaryReceive = $totalAVG;
    //                         $totalGrossExchange = 2000000 / $request->exchange_rate;
                            
    //                         $totalGrossInclucTax = round($totalGrossExchange,2);
    //                         if ($totalSalaryReceive > $totalGrossInclucTax) {
    //                             $taxExemptionSalary = $totalGrossInclucTax;
    //                         } else {
    //                             $taxExemptionSalary = $totalSalaryReceive;
    //                         }
    //                         if ($totalSalaryReceive > $totalGrossInclucTax) {
    //                             $totaltaxableSalary = $totalSalaryReceive - $totalGrossInclucTax;
    //                         } else {
    //                             $totaltaxableSalary = 0;
    //                         }
    //                         $paymentOfMonth = $PaymentOfMonth;
    //                         Seniority::where('number_employee',$item->number_employee)->where('payment_date',$request->payment_date)->delete();
    //                         $seniority = Seniority::create([
    //                             'employee_id'           => $item->id,
    //                             'number_employee'       => $item->number_employee,
    //                             'total_average_salary'  => $totalSalary,
    //                             'total_salary_receive'  => $totalSalaryReceive,
    //                             'tax_exemption_salary'  => $taxExemptionSalary,
    //                             'taxable_salary'        => $totaltaxableSalary,
    //                             'payment_of_month'      => $paymentOfMonth,
    //                             'payment_date'          => $request->payment_date,
    //                             'created_by'            => Auth::user()->id,
    //                         ]);
    //                         $seniorityPayableTax = $seniority->taxable_salary ?? 0;
    //                         $taxExemptionSalary = $seniority->tax_exemption_salary ?? 0;
    //                     }
    //                 }

    //                 if (count(Payroll::where('employee_id',$item->id)->get()) == 0) {
    //                     $totalGrossSalaryBeforpension = $totalGrossSalary + $totaltaxableSalary;
    //                 }else{
    //                     $totalGrossSalaryBeforpension = $dataGrossSalary->total_gross_salary + $totaltaxableSalary;
    //                 }
                    
    //                 $pension_contribution = 0;
    //                 if($item->is_type_nssf != 1){
    //                     $exchangNSSF = ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();
    //                     if ($exchangNSSF) {
    //                         $totalExchangeRielPreTax =  $exchangNSSF->amount_riel * round($totalGrossSalaryBeforpension,2);
    //                         if ($totalExchangeRielPreTax) {
    //                             if ($totalExchangeRielPreTax >= 1200000) {
    //                                 $averageWage    = 1200000;
    //                             }else if($totalExchangeRielPreTax >= 400000){
    //                                 $averageWage    = $totalExchangeRielPreTax;
    //                             }else{
    //                                 $averageWage = 400000;
    //                             }
    //                         }else{
    //                             $averageWage = 0;
    //                         }
    //                         $occupationalRisk = (0.008 * $averageWage);
    //                         $healthCare = (0.026 * $averageWage);
    //                         $workerContributionUsd = ($averageWage * 0.02);

    //                         $workerContributionRiel = 0;
    //                         $age = Carbon::createFromDate($item->date_of_birth)->format('Y-m-d');
    //                         $yearsOfEmployee = Carbon::parse($age)->age;
    //                         if($yearsOfEmployee < 60){
    //                             $workerContributionRiel = round($workerContributionUsd,0) / $exchangNSSF->amount_riel;
    //                         }
    //                         $dataNSSF = PreviewNationalSocialSecurityFund::create([
    //                             'employee_id'                   => $item->id,
    //                             'number_employee'               => $item->number_employee,
    //                             'total_pre_tax_salary_usd'      => round($totalGrossSalaryBeforpension,2),
    //                             'total_pre_tax_salary_riel'     => $totalExchangeRielPreTax,
    //                             'total_average_wage'            => $averageWage,
    //                             'total_occupational_risk'       => $occupationalRisk,
    //                             'total_health_care'             => $healthCare,
    //                             'pension_contribution_usd'      => round($workerContributionUsd,0),
    //                             'pension_contribution_riel'     => $workerContributionRiel,
    //                             'corporate_contribution'        => round($workerContributionUsd,0),
    //                             'exchange_rate'                 => $exchangNSSF->amount_riel,
    //                             'payment_date'                  => $request->payment_date,
    //                             'created_by'                    => Auth::user()->id,
    //                         ]);
    //                     }
    //                     $pension_contribution = round($dataNSSF->pension_contribution_riel,2);
    //                 }

    //                 $totalGrossAfterPension = $totalGrossSalaryBeforpension - $pension_contribution;
    //                 $totalExchangeRiel = round($totalGrossAfterPension, 2) * $request->exchange_rate;
    //                 $totalChargesReducedChild = $childrenAllowance->reduced_burden_children;
    //                 $totalChargesReducedSpouse = $childrenAllowance->spouse_allowance;
    //                 if($number_of_children == 0 && $item->spouse == 0){
    //                     $totalChargesReduced = 0;
    //                 }else if($number_of_children == 0 && $item->spouse == 0){
    //                     $totalChargesReduced = $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 1 && $item->spouse == 0){
    //                     $totalChargesReduced = $totalChargesReducedChild;
    //                 }else if($number_of_children == 0 && $item->spouse == 1){
    //                     $totalChargesReduced = $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 1 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 2 && $item->spouse == 0){
    //                     $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
    //                 }else if($number_of_children == 2 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 3 && $item->spouse == 0){
    //                     $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
    //                 }else if($number_of_children == 3 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 4 && $item->spouse == 0){
    //                     $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
    //                 }else if($number_of_children == 4 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }
                    
    //                 if ($number_of_children == 0 && $item->spouse == 0) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel;
    //                 } else if($number_of_children == 1 && $item->spouse == 0) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 0 && $item->spouse == 1) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 1 && $item->spouse == 1) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 2 &&  $item->spouse == 0){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 2 &&  $item->spouse == 1){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 3 &&  $item->spouse == 0){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 3 &&  $item->spouse == 1){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 4 &&  $item->spouse == 0){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 4 &&  $item->spouse == 1){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }
                    
    //                 $children = $number_of_children;
    //                 if ($number_of_children == 0 && $item->spouse == 0) {
    //                     if($totalExchangeRiel > 0 && $totalExchangeRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalExchangeRiel > 1500001 && $totalExchangeRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalExchangeRiel > 2000001 && $totalExchangeRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalExchangeRiel > 8500001 && $totalExchangeRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalExchangeRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalExchangeRiel > 1500001 && $totalExchangeRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalExchangeRiel > 2000001 && $totalExchangeRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalExchangeRiel > 8500001 && $totalExchangeRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;

    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 } else if($number_of_children == 1 && $item->spouse == 0) {
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }

    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 0 && $item->spouse == 1) {
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 1 && $item->spouse == 1) {
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 2 && $item->spouse == 0){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 2 && $item->spouse == 1){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 3 && $item->spouse == 0){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }

    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 3 && $item->spouse == 1){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 4 && $item->spouse == 0){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 4 && $item->spouse == 1){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }
    //                 $totalSeverancePay = 0;
    //                 $monthEndDate = Carbon::createFromDate($item->fdc_end)->format('Y-m');
    //                 $paymentDate = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                 if($item->emp_status == 1){
    //                     if($monthEndDate == $paymentDate){
    //                         $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc1')->sum('total_fdc1');
    //                         $totalContractSeverancePay = $dataSeveranc * 0.05;
    //                         $dataSeverance = SeverancePay::create([
    //                             'employee_id'                   => $item->id,
    //                             'number_employee'               => $item->number_employee,
    //                             'total_severanec_pay'           => round($dataSeveranc,2),
    //                             'total_contract_severance_pay'  => round($totalContractSeverancePay,2),
    //                             'payment_date'                  => $request->payment_date,
    //                             'type'                          => 'FDC-1',
    //                             'created_by'                    => Auth::user()->id,
    //                         ]);
    //                         $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
    //                     }
    //                 }

    //                 if($item->emp_status == 10){
    //                     if($monthEndDate == $paymentDate){
    //                         $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->where('number_employee',$item->number_employee)->whereNotNull('type_fdc2')->sum('total_fdc2');
    //                         $totalContractSeverancePay = $dataSeveranc * 0.05;
    //                         $dataSeverance = SeverancePay::create([
    //                             'employee_id'                   => $item->id,
    //                             'number_employee'               => $item->number_employee,
    //                             'total_severanec_pay'           => round($dataSeveranc,2),
    //                             'total_contract_severance_pay'  => round($totalContractSeverancePay,2),
    //                             'payment_date'                  => $request->payment_date,
    //                             'type'                          => 'FDC-2',
    //                             'created_by'                    => Auth::user()->id,
    //                         ]);
    //                         $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
    //                     }
    //                 }
    //                 $totalSalaryBeforPension = $totalSalaryAfterTax + $totalSeverancePay + $adjustmentExcludeTaxe + $taxExemptionSalary + $totalParkAllowance;
    //                 $totalNetSalary = $totalSalaryBeforPension - $LoanAmount - $totalStaffBook;
    //                 $data   = $request->all();
    //                 $data['employee_id']                    = $item->id;
    //                 $data['number_employee']                = $item->number_employee;
    //                 $data['basic_salary']                   = $item->basic_salary;
    //                 $data['spouse']                         = $item->spouse;
    //                 $data['children']                       = $children;
    //                 $data['total_gross_salary']             = $totalBasicSalaryLast;
    //                 $data['total_child_allowance']          = $totalChildAllowance;
    //                 $data['phone_allowance']                = $item->phone_allowance;
    //                 $data['total_kny_phcumben']             = $totalBunus;
    //                 $data['monthly_quarterly_bonuses']      = $monthlyQuarterlyIncentive;
    //                 $data['annual_incentive_bonus']         = $annualBonus;
    //                 $data['other_benefits']                 = $otherBenefit;
    //                 $data['total_severance_pay']            = round($totalSeverancePay,3);
    //                 $data['seniority_pay_included_tax']     = $seniorityPayableTax;
    //                 $data['total_gross']                    = $totalGrossSalaryBeforpension;
    //                 $data['total_pension_fund']             = $pension_contribution;
    //                 $data['base_salary_received_usd']       = $totalGrossAfterPension;
    //                 $data['base_salary_received_riel']      = round($totalExchangeRiel, 3);
    //                 $data['total_tax_base_riel']            = round($totalTtaxBbaseRiel, 3);
    //                 $data['total_charges_reduced']          = $totalChargesReduced;
    //                 $data['total_rate']                     = $totalTax;
    //                 $data['seniority_pay_excluded_tax']     = $taxExemptionSalary;
    //                 $data['total_salary_tax_riel']          = round($totalSalaryTaxRiel,3);
    //                 $data['total_salary_tax_usd']           = $totalSalaryTaxUsd;
    //                 $data['loan_amount']                    = $LoanAmount;
    //                 $data['total_staff_book']               = $totalStaffBook;
    //                 $data['adjustment']                     = $adjustmentExcludeTaxe;
    //                 $data['adjustment_include_taxe']        = $adjustmentIncludeTaxe;
    //                 $data['total_amount_car']               = $totalParkAllowance;
    //                 $data['total_salary']                   = $totalNetSalary;
    //                 $data['exchange_rate']                  = $request->exchange_rate;
    //                 $data['created_by']                     = Auth::user()->id;
    //                 payrollPreview::create($data);
    //             }
    //             Toastr::success('Created payroll successfully.','Success');
    //             return redirect()->back();
    //             DB::commit();
    //         } else {
    //             DB::rollback();
    //             Toastr::error('Can not employee payroll','Error');
    //             return redirect()->back();
    //         }
    //     }catch(\Exception $e){
    //         DB::rollback();
    //         Toastr::error('Payroll created fail','Error');
    //         return redirect()->back();
    //     }
    // }
    // public function store(Request $request)
    // {
    //     try{
    //         //function import annual_bonus
    //         $dadaArrayAnnualBonus = [];
    //         if (file_exists($request->annual_bonus)) {
    //             $file_annual_bonus = $request->annual_bonus;
    //             $extension = $request->annual_bonus->extension();
    //             $spreadsheet_annual_bonus = IOFactory::load($file_annual_bonus);
    //             $dataImportAnnualBonus =  $spreadsheet_annual_bonus->getSheetByName('Annual Bonus')->toArray();
    //             if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
    //                 $index = 0;
    //                 foreach ($dataImportAnnualBonus as $rowOther) {
    //                     $index++;
    //                     if ($index != 1) {
    //                         $dataAnnualBonus = User::where("number_employee", $rowOther[0])->first();
    //                         if($dataAnnualBonus){
    //                             $dadaArrayAnnualBonus[$dataAnnualBonus->number_employee] = [
    //                                 'annual_bonus' => $rowOther[2]
    //                             ];
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         //function import other benefit
    //         $dadaArrayOtherBenefit = [];
    //         if (file_exists($request->other_benefits)) {
    //             $file_other_benefits = $request->other_benefits;
    //             $spreadsheet_other_benefits = IOFactory::load($file_other_benefits);
    //             $otherBenefits =  $spreadsheet_other_benefits->getSheetByName('Other Benefits')->toArray();
    //             $filesize = filesize($file_other_benefits);
    //             $extension = $request->other_benefits->extension();
    //             $index = 0;
    //             foreach ($otherBenefits as $rowOther) {
    //                 $index++;
    //                 if ($index != 1) {
    //                     $otherBenefitEmployee = User::where("number_employee", $rowOther[0])->first();
    //                     if($otherBenefitEmployee){
    //                         $dadaArrayOtherBenefit[$otherBenefitEmployee->number_employee] = [
    //                             'other_benefit' => $rowOther[2]
    //                         ];
    //                     }
    //                 }
    //             }
    //         }
        
    //         // function import incentive
    //         $dadaArrayIncentive = [];
    //         if (file_exists($request->file_incentive)) {
    //             $fileIincentive = $request->file_incentive;
    //             $spreadsheet = IOFactory::load($fileIincentive);
    //             $Incentive =  $spreadsheet->getSheetByName('Incentive Bonus')->toArray();
    //             $iIn = 0;
    //             foreach ($Incentive as $itemIncen) {
    //                 $iIn++;
    //                 if ($iIn != 1) {
    //                     $employeeIncentive = User::where("number_employee", $itemIncen[0])->first();
    //                     if($employeeIncentive){
    //                         $dadaArrayIncentive[$employeeIncentive->number_employee] = [
    //                             'incentive' => $itemIncen[2]
    //                         ];
    //                     }
    //                 }
    //             }
    //         }
    //         // function import Loan
    //         $dadaArrayLoan = [];
    //         if (file_exists($request->file_loan)) {
    //             $fileLoan = $request->file_loan;
    //             $spreadsheet = IOFactory::load($fileLoan);
    //             $staffLoan =  $spreadsheet->getSheetByName('Loan')->toArray();
    //             $iIn = 0;
    //             foreach ($staffLoan as $itemLoan) {
    //                 $iIn++;
    //                 if ($iIn != 1) {
    //                     $employeeIncentive = User::where("number_employee", $itemLoan[0])->first();
    //                     if($employeeIncentive){
    //                         $dadaArrayLoan[$employeeIncentive->number_employee] = [
    //                             'laon_amount' => $itemLoan[2]
    //                         ];
    //                     }
    //                 }
    //             }
    //         }

    //         //function upload staff book amount
    //         $dadaArrayStaffBook = [];
    //         if (file_exists($request->staff_book)) {
    //             $file_staff_book = $request->staff_book;
    //             $extension = $request->staff_book->extension();
    //             $spreadsheet_staff_book = IOFactory::load($file_staff_book);
    //             $dataImportStaffBook =  $spreadsheet_staff_book->getSheetByName('Staff Book')->toArray();
    //             if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
    //                 $index = 0;
    //                 foreach ($dataImportStaffBook as $itemStaffBook) {
    //                     $index++;
    //                     if ($index != 1) {
    //                         $dataStaffBook = User::where("number_employee", $itemStaffBook[0])->first();
    //                         if($dataStaffBook){
    //                             $dadaArrayStaffBook[$dataStaffBook->number_employee] = [
    //                                 'total_staff_book' => $itemStaffBook[2]
    //                             ];
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         //function upload parking allowance
    //         $dadaArrayParkingAllowance = [];
    //         if (file_exists($request->parking_allowance)) {
    //             $fileParkingAllowance = $request->parking_allowance;
    //             $extension = $request->parking_allowance->extension();
    //             $spreadsheet_parking_allowance = IOFactory::load($fileParkingAllowance);
    //             $parkingAllowance =  $spreadsheet_parking_allowance->getSheetByName('parking allowance')->toArray();
    //             if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
    //                 $index = 0;
    //                 foreach ($parkingAllowance as $itemPar) {
    //                     $index++;
    //                     if ($index != 1) {
    //                         $dataParkAll = User::where("number_employee", $itemPar[0])->first();
    //                         if($dataParkAll){
    //                             $dadaArrayParkingAllowance[$dataParkAll->number_employee] = [
    //                                 'totalParkingAllowance' => $itemPar[2]
    //                             ];
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $employee = User::where('date_of_commencement','<=',$request->payment_date)->whereIn('emp_status',['Probation','1','10','2'])->get();
    //         if (!$employee->isEmpty()) {
    //             foreach ($employee as $item) {
    //                 // payrollPreview::where('employee_id',$item->id)->delete();
    //                 // PreviewNationalSocialSecurityFund::where('employee_id',$item->id)->delete();
    //                 // GrossSalaryPay::where('number_employee',$item->number_employee)->where('payment_date',$request->payment_date)->delete();
    //                 // SeverancePay::where('number_employee',$item->number_employee)->where('payment_date',$request->payment_date)->delete();
    //                 // PreviewBonus::where('employee_id',$item->id)->delete();
    //                 $paymentMonth = date('m-Y', strtotime($request->payment_date));
    //                 payrollPreview::where('employee_id', $item->id)->delete();
    //                 PreviewNationalSocialSecurityFund::where('employee_id', $item->id)->delete();
    //                 GrossSalaryPay::where('number_employee', $item->number_employee)->whereRaw("DATE_FORMAT(payment_date, '%m-%Y') = ?", [$paymentMonth])->delete();
    //                 SeverancePay::where('number_employee', $item->number_employee)->whereRaw("DATE_FORMAT(payment_date, '%m-%Y') = ?", [$paymentMonth])->delete();
    //                 PreviewBonus::where('employee_id', $item->id)->delete();

    //                 //function first month join work
    //                 $totalFirstSeverancPay = 0;
    //                 $totalBaseSalaryRecived = 0;
    //                 $totalBasicSalary = 0;
    //                 $monthlyQuarterlyIncentive = 0;
    //                 $joinDate = Carbon::createFromDate($item->date_of_commencement)->format('m-y');
    //                 $paymentDate = Carbon::createFromDate($request->payment_date)->format('m-y');

    //                 //function ajustment
    //                 $dataPayrollAdjustment = PayrollAdjustment::where('employee_id',$item->id)->get();
    //                 $adjustmentIncludeTaxe = 0;
    //                 $adjustmentExcludeTaxe = 0;
    //                 foreach ($dataPayrollAdjustment as $valueAdjust) {
    //                     $adjustmentDate = Carbon::createFromDate($valueAdjust->adjustment_date)->format('m-y');
    //                     if($adjustmentDate == $paymentDate){
    //                         if ($valueAdjust->adjustment_type == 'include_taxe') {
    //                             $adjustmentIncludeTaxe = $valueAdjust->amount;
    //                         }else{
    //                             $adjustmentExcludeTaxe = $valueAdjust->amount;
    //                         }
    //                     }
    //                 }
    //                 //function difinde day first working
    //                 if ($joinDate == $paymentDate) {
    //                     //total day in monthsd
    //                     // $start_date = Carbon::createFromDate($item->date_of_commencement);
    //                     // $endMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth();
    //                     // $end_date = Date::createFromDate($endMonth);
    //                     // $commencementDate   = Carbon::parse($start_date);
    //                     // $resumptionDate     = Carbon::parse($end_date);
    //                     // $isCommencementWeekday = !$commencementDate->isWeekend();
    //                     // $toDays 		    = $resumptionDate->diffInWeekdays($commencementDate) + ($isCommencementWeekday ? 1 : 0);

    //                     $start_date = Carbon::parse($item->date_of_commencement);
    //                     $end_date   = $start_date->copy()->endOfMonth();
    //                     // Count working days (Mon–Fri)
    //                     $toDays = $start_date->diffInDaysFiltered(function (Carbon $date) {
    //                         return !$date->isWeekend(); // Exclude Saturday/Sunday
    //                     }, $end_date);

    //                     $joinDate = Carbon::createFromDate($item->date_of_commencement)->format('d');
    //                     $startMonth = Carbon::createFromDate($item->date_of_commencement)->format('m');
    //                     $startendMonth = Carbon::createFromDate($item->date_of_commencement)->endOfMonth()->format('d');
    //                     if ($joinDate==1) {
    //                         $totalBasicSalary = $item->basic_salary;
    //                     } else {
    //                         if ($startMonth == 02 && $startendMonth == 28 || $startendMonth == 29) {
    //                             if ($toDays == 21) {
    //                                 $totalBasicSalary = $item->basic_salary;
    //                             } else {
    //                                 $totalBasicSalary = ($item->basic_salary / 22) * $toDays;
    //                             }
    //                         }else{
    //                             if ($toDays >= 22) {
    //                                 $totalBasicSalary = $item->basic_salary;
    //                             }else{
    //                                 $totalBasicSalary = ($item->basic_salary / 22) * $toDays;
    //                             }
    //                         }
    //                     }
    //                 } else {
    //                     if ($item->emp_status == 1) {
    //                         $joinPassProbation = Carbon::createFromDate($item->fdc_date)->format('d');
    //                         if($joinPassProbation == '01'){
    //                             $totalBasicSalary = $item->basic_salary;
    //                         }else{
    //                             $monthToPay = Carbon::createFromDate($item->fdc_date)->format('Y-m');
    //                             $currentMonthToPay = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                             if($monthToPay == $currentMonthToPay){
    //                                 //function get first severance pay
    //                                 $endMonth = Carbon::createFromDate($item->fdc_date)->format('m');
    //                                 $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
    //                                 //find start date employee join date
    //                                 $date_of_month = Carbon::createFromDate($item->fdc_date)->format('Y-m');
    //                                 $currentYear = $date_of_month.'-'.$totalDayInMonth;
    //                                 //find total working day in month
    //                                 $startDate = Carbon::parse($item->fdc_date);
    //                                 $endDate = Carbon::parse($currentYear);
    //                                 //total day in  passt probation and total salary passt probation days
    //                                 $totalNewDays = $startDate->diffInDays($endDate) + 1;
    //                                 //total day in  probation and total salary in probation days
    //                                 $totalOldDay = $totalDayInMonth - $totalNewDays;
    //                                 //old salary
    //                                 $oldSalary = ($item->pre_salary * $totalOldDay) / $totalDayInMonth;

    //                                 $newSalary = 0;
    //                                 if ($totalOldDay) {
    //                                     $newSalary = ($item->basic_salary * $totalNewDays) / $totalDayInMonth;
    //                                 }
    //                                 $totalBaseSalaryRecived = round($oldSalary,2) + round($newSalary,2);
    //                                 $totalFirstSeverancPay = round($oldSalary,2);
    //                             }else{
    //                                 $totalBasicSalary = $item->basic_salary;
    //                             }
    //                         }
    //                     }else{
    //                         $totalBasicSalary = $item->basic_salary;
    //                     }
    //                 }
    //                 //fuction check Monthly/Quarterly Incentive
    //                 if (array_key_exists($item->number_employee, $dadaArrayIncentive)) {
    //                     $monthlyQuarterlyIncentive = $dadaArrayIncentive[$item->number_employee]['incentive'];
    //                 } else {
    //                    $monthlyQuarterlyIncentive = 0;
    //                 }
    //                 //fuction check Annual Bonus
    //                 if (array_key_exists($item->number_employee, $dadaArrayAnnualBonus)) {
    //                     $annualBonus = $dadaArrayAnnualBonus[$item->number_employee]['annual_bonus'];
    //                 } else {
    //                    $annualBonus = 0;
    //                 }
    //                 //fuction check Other benefit
    //                 if (array_key_exists($item->number_employee, $dadaArrayOtherBenefit)) {
    //                     $otherBenefit = $dadaArrayOtherBenefit[$item->number_employee]['other_benefit'];
    //                 } else {
    //                    $otherBenefit = 0;
    //                 }
    //                 //fuction check laon amount
    //                 if (array_key_exists($item->number_employee, $dadaArrayLoan)) {
    //                     $LoanAmount = $dadaArrayLoan[$item->number_employee]['laon_amount'];
    //                 } else {
    //                    $LoanAmount = 0;
    //                 }
    //                 //fuction check staff book
    //                 if (array_key_exists($item->number_employee, $dadaArrayStaffBook)) {
    //                     $totalStaffBook = $dadaArrayStaffBook[$item->number_employee]['total_staff_book'];
    //                 } else {
    //                    $totalStaffBook = 0;
    //                 }
    //                 //fuction check staff book
    //                 if (array_key_exists($item->number_employee, $dadaArrayParkingAllowance)) {
    //                     $totalParkAllowance = $dadaArrayParkingAllowance[$item->number_employee]['totalParkingAllowance'];
    //                 } else {
    //                    $totalParkAllowance = 0;
    //                 }
                    
    //                 //calculated khmer_new_year and pchumBen_bonus
    //                 $totalBunus = 0;
    //                 if ($item->emp_status == 1 || $item->emp_status == 10 || $item->emp_status == 2) {
    //                     $dataHolidayBunuse = Holiday::where('type','bonus')->whereYear('created_at', now()->year)->get();
    //                     foreach ($dataHolidayBunuse as $value) {
    //                         $userJoinDate = $item->date_of_commencement;
    //                         $dayOfYear = 365;
    //                         $fromDate = Carbon::parse($userJoinDate);
    //                         $toDate = Carbon::parse($value->from);

    //                         $totalStartDays = $fromDate->diffInDays($toDate) + 1;
    //                         $hildayMonth = Carbon::createFromDate($value->period_month)->format('Y-m');
    //                         $hildayDays = Carbon::createFromDate($value->period_month)->format('Y-m');
    //                         $payMonth = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                         $payDays = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                         $bounsType = $value->title;
    //                         if($hildayMonth == $payMonth && $hildayDays >= $payDays){
    //                             if ($totalStartDays > $dayOfYear) {
    //                                 $percent = $value->amount_percent / 100;
    //                                 $totalAllowanceBunus = ($item->basic_salary * $percent);
    //                             } else {
    //                                 $totalPercent = ($item->basic_salary * $value->amount_percent) / 100;
    //                                 $percentSalary = $totalPercent * $totalStartDays;
    //                                 $totalAllowanceBunus = $percentSalary / $dayOfYear;
    //                             }
    //                             $dataBonus = PreviewBonus::create([
    //                                 'employee_id'               => $item->id,
    //                                 'number_employee'           => $item->number_employee,
    //                                 'number_of_working_days'    => $totalStartDays,
    //                                 'base_salary'               => $item->basic_salary,
    //                                 'base_salary_received'      => $item->basic_salary,
    //                                 'total_allowance'           => $totalAllowanceBunus,
    //                                 'bouns_type'                => $bounsType,
    //                                 'payment_date'              => $request->payment_date,
    //                                 'created_by'                => Auth::user()->id,
    //                             ]);
    //                         }
    //                         $totalBunus = $dataBonus->total_allowance ?? 0;
    //                     }
    //                 }
    
    //                 // function sum benefit age children <= 18
    //                 $dataDateOfBirth = [];
    //                 $dataChildren = ChildrenInfor::where('employee_id',$item->id)->get();
    //                 foreach ($dataChildren as $value) {
    //                     // $yearsOfChild = Carbon::parse($value->date_of_birth)->age;
    //                     $birth_date = $value->date_of_birth;
    //                     $current_date = date('Y-m-d');
    //                     $birth_timestamp = strtotime($birth_date);
    //                     $current_timestamp = strtotime($current_date);
    //                     $diff_seconds = $current_timestamp - $birth_timestamp;
    //                     $age_years = $diff_seconds / (60 * 60 * 24 * 365.25);
    //                     $yearsOfChild = round($age_years);
    //                     if ($yearsOfChild <= 18) {
    //                         $dataDateOfBirth[] = $value;
    //                     }
    //                 }
                    
    //                 //function children allowance
    //                 $number_of_children = count($dataDateOfBirth);
    //                 $childrenAllowance = ChildrenAllowance::first();
    //                 $totalChildAllowance = 0;
    //                 if ($item->emp_status == 1 || $item->emp_status == 10 || $item->emp_status == 2) {
    //                     if ($number_of_children) {
    //                         if ($number_of_children == 0) {
    //                             $totalChildAllowance = 0;
    //                         } else if($number_of_children == 1) {
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 1;
    //                         }else if($number_of_children == 2){
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 2;
    //                         }else if($number_of_children == 3){
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 3;
    //                         }else if($number_of_children == 4){
    //                             $totalChildAllowance = $childrenAllowance->total_children_allowance * 4;
    //                         }
    //                     }
    //                 }
                    
    //                 //calcute last severance pay 1
    //                 $SeverancePay1 = null;
    //                 $SeverancePay2 = null;
    //                 $totalSeniority = 0;
    //                 $basic1 = 0;
    //                 $basic2 = 0;
    //                 $type_fdc1 = null;
    //                 $type_fdc2 = null;
    //                 $type_udc = null;
    //                 $totalSeverancyPaySalary = $totalBaseSalaryRecived != 0 ? $totalBaseSalaryRecived : $totalBasicSalary;
    //                 $totalSalarySeverancyPay = $totalSeverancyPaySalary + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $otherBenefit + $annualBonus + $totalBunus + $item->phone_allowance + $totalChildAllowance;
    //                 $totalSeverancePay = $totalFirstSeverancPay != 0 ? $totalFirstSeverancPay : $totalBasicSalary;
    //                 $totalOtherBenefit = $totalSeverancePay + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $annualBonus + $otherBenefit + $totalBunus + $item->phone_allowance + $totalChildAllowance;
    //                 //function difinde day end FDC
    //                 if ($item->emp_status == 1 || $item->emp_status == 10) {
    //                     $endContractDeadline= Carbon::createFromDate($item->fdc_end)->format('Y-m');
    //                     $paymentDate = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                     if($endContractDeadline == $paymentDate){
    //                         $endMonth = Carbon::createFromDate($item->fdc_end)->format('m');
    //                         $totalDayInMonth = Carbon::now()->month($endMonth)->daysInMonth;
    //                         $contract_deadline = Carbon::createFromDate($item->fdc_end)->format('Y-m');
    //                         $currentYear = $contract_deadline.'-'.$totalDayInMonth;
    //                         // new salary and new total days
    //                         $startDate = Carbon::parse($item->fdc_end);
    //                         $endDate = Carbon::parse($currentYear);
    //                         $totalNewDays = $startDate->diffInDays($endDate);
    //                         $SeverancePay2 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalNewDays;
    //                         //old salary and total old days
    //                         $totalOldDay = $totalDayInMonth - $totalNewDays;
    //                         $SeverancePay1 = ($totalSalarySeverancyPay / $totalDayInMonth) * $totalOldDay;
    //                         $type_fdc2 = 'FDC-2';
    //                         if ($item->emp_status == 10) {
    //                             $type_fdc1 = 'FDC-1';
    //                         }

    //                        // Start date = contract end date
    //                         $start_working_day_date = Carbon::parse($item->fdc_end);
    //                         // End date = end of the same month as the contract end
    //                         $end_working_day_date = $start_working_day_date->copy()->endOfMonth();
    //                         // Calculate working days (Monday–Friday)
    //                         $workingDays = $start_working_day_date->diffInWeekdays($end_working_day_date);
    //                         // Include start date if it's a weekday
    //                         if (!$start_working_day_date->isWeekend()) {
    //                             $workingDays += 1;
    //                         }
    //                         if ($workingDays >= 21) {
    //                             $type_udc = 'UDC';
    //                         }
                            
    //                         $totalSeniority = $totalSalarySeverancyPay;
    //                         $basic1 = ($item->basic_salary / $totalDayInMonth) * $totalOldDay;
    //                         $basic2 = ($item->basic_salary / $totalDayInMonth) * $totalNewDays;
    //                         $totalBaseSalaryRecived =  $basic1 + $basic2;
    //                     }
    //                 }
    //                 $dataTotalSeverancePay1 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
    //                 $totalSeverancePay1 =  $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 : $totalSalarySeverancyPay;
    //                 $totalSeverancePay2 = $SeverancePay2;
    //                 $totalBasicSalaryLast = $totalBaseSalaryRecived != 0 ? $totalBaseSalaryRecived : $totalBasicSalary;
    //                 $totalGrossSalary = (round($totalSeverancyPaySalary,2) + $adjustmentIncludeTaxe + $monthlyQuarterlyIncentive + $otherBenefit + $annualBonus + $totalBunus + $item->phone_allowance + $totalChildAllowance);
    //                 //function check severanc pay
    //                 if($item->emp_status == 1){
    //                     $dataTotalSeverancePay2 = $SeverancePay2 != null ? $SeverancePay2 : $totalOtherBenefit;
    //                 }
    //                 if($item->emp_status == 10){
    //                     $dataTotalSeverancePay2 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
    //                 }
                    
    //                 if ($item->emp_status == 'Probation') {
    //                     $type_fdc1 = null;
    //                     $totalSeverancePay1 = 0;
    //                 } 
    //                 if($item->emp_status == 1) {
    //                     $type_fdc1 = 'FDC-1';
    //                 }
    //                 if($item->emp_status == 10){
    //                     $type_fdc1 = null;
    //                     $totalSeniority = $totalSalarySeverancyPay;
    //                     $type_fdc2 = 'FDC-2';
    //                     $totalSeverancePay1 = 0;
    //                     $totalSeverancePay2 = $dataTotalSeverancePay2 != null ? $dataTotalSeverancePay2 : $totalSalarySeverancyPay;
    //                 }
    //                 if($item->emp_status == 2){
    //                     $type_udc = 'UDC';
    //                     $totalSeverancePay1 = $totalSeverancePay1;
    //                     $totalSeverancePay2 = 0;
    //                     $dataTotalSeverancePay1 = $SeverancePay1 != null ? $SeverancePay1 : $totalOtherBenefit;
    //                     $totalSeniority = $dataTotalSeverancePay1 != null ? $dataTotalSeverancePay1 : $totalSalarySeverancyPay;
    //                 }
                    
    //                 //sum salary and sum other benefit befor tax free
    //                 $dataGrossSalary = GrossSalaryPay::create([
    //                     'employee_id'               => $item->id,
    //                     'number_employee'           => $item->number_employee,
    //                     'basic_salary'              => $item->basic_salary,
    //                     'total_gross_salary'        => round($totalGrossSalary,2),
    //                     'total_fdc1'                => round($totalSeverancePay1,2),
    //                     'total_fdc2'                => round($totalSeverancePay2,2),
    //                     'total_seniority'           => round($totalSeniority,2),
    //                     'payment_date'              => $request->payment_date,
    //                     'type_fdc1'                 => $type_fdc1,
    //                     'type_fdc2'                 => $type_fdc2,
    //                     'type_udc'                  => $type_udc,
    //                     'created_by'                => Auth::user()->id
    //                 ]);

    //                 //function Seniority pay
    //                 $seniorityPayableTax = 0;
    //                 $taxExemptionSalary = 0;
    //                 $totaltaxableSalary = 0;
    //                 if ($item->emp_status == 2) {
    //                     $currentDate = Carbon::createFromDate($request->payment_date)->format('m');
    //                     $PaymentOfMonth = Carbon::parse($request->payment_date)->format('M-Y');
    //                     if ($currentDate == 6 || $currentDate == 12) {
    //                         // $nextYear = Carbon::parse()->format('Y');
    //                         $nextYear = Carbon::createFromDate($request->payment_date)->format('Y');
    //                         $currentYear = null;
    //                         $currentMonth = null;
    //                         if($currentDate == 6){  
    //                             $currentYear =  Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d');
    //                         }
    //                         if ($currentDate == 12) {
    //                             $currentMonth = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
    //                         }
    //                         $totalSalary = GrossSalaryPay::where('employee_id', $item->id)->where('type_udc','UDC')->when($currentYear ,function ($query, $udc_end_date) {
    //                             $query->where('payment_date', '>=',$udc_end_date);
    //                         })->when($currentMonth, function($query, $currentMonth){
    //                             $query->where('payment_date', '>=',$currentMonth);
    //                         })->pluck('total_seniority')->avg();

    //                         $totalAVG = (round($totalSalary,2) * 7.5) / 22;
    //                         $totalSalaryReceive = $totalAVG;
    //                         // $totalSalaryReceive = ceil($totalAVG);
    //                         $totalGrossExchange = 2000000 / $request->exchange_rate;
                            
    //                         $totalGrossInclucTax = round($totalGrossExchange,2);
    //                         if ($totalSalaryReceive > $totalGrossInclucTax) {
    //                             $taxExemptionSalary = $totalGrossInclucTax;
    //                         } else {
    //                             $taxExemptionSalary = $totalSalaryReceive;
    //                         }
    //                         if ($totalSalaryReceive > $totalGrossInclucTax) {
    //                             $totaltaxableSalary = $totalSalaryReceive - $totalGrossInclucTax;
    //                         } else {
    //                             $totaltaxableSalary = 0;
    //                         }
    //                         $paymentOfMonth = $PaymentOfMonth;
    //                         Seniority::where('number_employee',$item->number_employee)->where('payment_date',$request->payment_date)->delete();
    //                         $seniority = Seniority::create([
    //                             'employee_id'           => $item->id,
    //                             'number_employee'       => $item->number_employee,
    //                             'total_average_salary'  => $totalSalary,
    //                             'total_salary_receive'  => $totalSalaryReceive,
    //                             'tax_exemption_salary'  => $taxExemptionSalary,
    //                             'taxable_salary'        => $totaltaxableSalary,
    //                             'payment_of_month'      => $paymentOfMonth,
    //                             'payment_date'          => $request->payment_date,
    //                             'created_by'            => Auth::user()->id,
    //                         ]);
    //                         $seniorityPayableTax = $seniority->taxable_salary ?? 0;
    //                         $taxExemptionSalary = $seniority->tax_exemption_salary ?? 0;
    //                     }
    //                 }

    //                 if (count(Payroll::where('employee_id',$item->id)->get()) == 0) {
    //                     $totalGrossSalaryBeforpension = $totalGrossSalary + $totaltaxableSalary;
    //                 }else{
    //                     $totalGrossSalaryBeforpension = $dataGrossSalary->total_gross_salary + $totaltaxableSalary;
    //                 }
                    
    //                 // function get age employee <= 60 National Social Security Fund (NSSF) Formula
    //                 $pension_contribution = 0;
    //                 if($item->is_type_nssf != 1){
    //                     $exchangNSSF = ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();
    //                     if ($exchangNSSF) {
    //                         $totalExchangeRielPreTax =  $exchangNSSF->amount_riel * round($totalGrossSalaryBeforpension,2);
    //                         if ($totalExchangeRielPreTax) {
    //                             if ($totalExchangeRielPreTax >= 1200000) {
    //                                 $averageWage    = 1200000;
    //                             }else if($totalExchangeRielPreTax >= 400000){
    //                                 $averageWage    = $totalExchangeRielPreTax;
    //                             }else{
    //                                 $averageWage = 400000;
    //                             }
    //                         }else{
    //                             $averageWage = 0;
    //                         }
    //                         $occupationalRisk = (0.008 * $averageWage);
    //                         $healthCare = (0.026 * $averageWage);
    //                         $workerContributionUsd = ($averageWage * 0.02);

    //                         $workerContributionRiel = 0;
    //                         $age = Carbon::createFromDate($item->date_of_birth)->format('Y-m-d');
    //                         $yearsOfEmployee = Carbon::parse($age)->age;
    //                         if($yearsOfEmployee < 60){
    //                             $workerContributionRiel = round($workerContributionUsd,0) / $exchangNSSF->amount_riel;
    //                         }
    //                         $dataNSSF = PreviewNationalSocialSecurityFund::create([
    //                             'employee_id'                   => $item->id,
    //                             'number_employee'               => $item->number_employee,
    //                             'total_pre_tax_salary_usd'      => round($totalGrossSalaryBeforpension,2),
    //                             'total_pre_tax_salary_riel'     => $totalExchangeRielPreTax,
    //                             'total_average_wage'            => $averageWage,
    //                             'total_occupational_risk'       => $occupationalRisk,
    //                             'total_health_care'             => $healthCare,
    //                             'pension_contribution_usd'      => round($workerContributionUsd,0),
    //                             'pension_contribution_riel'     => $workerContributionRiel,
    //                             'corporate_contribution'        => round($workerContributionUsd,0),
    //                             'exchange_rate'                 => $exchangNSSF->amount_riel,
    //                             'payment_date'                  => $request->payment_date,
    //                             'created_by'                    => Auth::user()->id,
    //                         ]);
    //                     }
    //                     $pension_contribution = round($dataNSSF->pension_contribution_riel,2);
    //                 }

    //                 //function ដក​ pensin fund
    //                 $totalGrossAfterPension = $totalGrossSalaryBeforpension - $pension_contribution;
    //                 // functin exchange riel rate gross salary after tax
    //                 $totalExchangeRiel = round($totalGrossAfterPension, 2) * $request->exchange_rate;
    //                 //total that បូកបន្ថែមលើបន្ទុកកូននិងប្រពន្ធ
    //                 $totalChargesReducedChild = $childrenAllowance->reduced_burden_children;
    //                 $totalChargesReducedSpouse = $childrenAllowance->spouse_allowance;
    //                 //not have child and sposes child 1
    //                 if($number_of_children == 0 && $item->spouse == 0){
    //                     $totalChargesReduced = 0;
    //                 }else if($number_of_children == 0 && $item->spouse == 0){
    //                     $totalChargesReduced = $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 1 && $item->spouse == 0){
    //                     $totalChargesReduced = $totalChargesReducedChild;
    //                 }else if($number_of_children == 0 && $item->spouse == 1){
    //                     $totalChargesReduced = $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 1 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 2 && $item->spouse == 0){
    //                     $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
    //                 }else if($number_of_children == 2 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 3 && $item->spouse == 0){
    //                     $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
    //                 }else if($number_of_children == 3 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }else if($number_of_children == 4 && $item->spouse == 0){
    //                     $totalChargesReduced = $number_of_children * $totalChargesReducedChild;
    //                 }else if($number_of_children == 4 && $item->spouse == 1){
    //                     $totalChargesReduced = ($number_of_children * $totalChargesReducedChild) + $totalChargesReducedSpouse;
    //                 }
                    
    //                 //កាត់មូលដ្ឋានគិតពន្ធ
    //                 if ($number_of_children == 0 && $item->spouse == 0) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel;
    //                 } else if($number_of_children == 1 && $item->spouse == 0) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 0 && $item->spouse == 1) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 1 && $item->spouse == 1) {
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 2 &&  $item->spouse == 0){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 2 &&  $item->spouse == 1){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 3 &&  $item->spouse == 0){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 3 &&  $item->spouse == 1){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 4 &&  $item->spouse == 0){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }else if($number_of_children == 4 &&  $item->spouse == 1){
    //                     $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
    //                 }
                    
    //                 $children = $number_of_children;
    //                 // អត្រា ពន្ធ(%)
    //                 if ($number_of_children == 0 && $item->spouse == 0) {
    //                     if($totalExchangeRiel > 0 && $totalExchangeRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalExchangeRiel > 1500001 && $totalExchangeRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalExchangeRiel > 2000001 && $totalExchangeRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalExchangeRiel > 8500001 && $totalExchangeRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalExchangeRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalExchangeRiel > 1500001 && $totalExchangeRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalExchangeRiel > 2000001 && $totalExchangeRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalExchangeRiel > 8500001 && $totalExchangeRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;

    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 } else if($number_of_children == 1 && $item->spouse == 0) {
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }

    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 0 && $item->spouse == 1) {
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 1 && $item->spouse == 1) {
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 2 && $item->spouse == 0){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 2 && $item->spouse == 1){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 3 && $item->spouse == 0){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }

    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 3 && $item->spouse == 1){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 4 && $item->spouse == 0){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }else if($number_of_children == 4 && $item->spouse == 1){
    //                     if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
    //                         $totalTax = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalTax = 5;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalTax = 10;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalTax = 15;
    //                     }else{
    //                         $totalTax = 20;
    //                     }
                        
    //                     if($totalTtaxBbaseRiel <= 1500000){
    //                         $totalSalaryTaxRiel = 0;
    //                     }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 75000;
    //                     }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 175000;
    //                     }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 600000;
    //                     }else{
    //                         $totalSalaryTaxRiel = ($totalTtaxBbaseRiel * $totalTax) / 100 - 1225000;
    //                     }
    //                     //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
    //                     $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    //                     //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
    //                     $totalSalaryAfterTax = $totalGrossAfterPension - round($totalSalaryTaxUsd,2);
    //                 }
    //                 //function Severance Pay ti 1
    //                 $totalSeverancePay = 0;
    //                 $monthEndDate = Carbon::createFromDate($item->fdc_end)->format('Y-m');
    //                 $paymentDate = Carbon::createFromDate($request->payment_date)->format('Y-m');
    //                 if($item->emp_status == 1){
    //                     if($monthEndDate == $paymentDate){
    //                         $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc1')->sum('total_fdc1');
    //                         $totalContractSeverancePay = $dataSeveranc * 0.05;
    //                         $dataSeverance = SeverancePay::create([
    //                             'employee_id'                   => $item->id,
    //                             'number_employee'               => $item->number_employee,
    //                             'total_severanec_pay'           => round($dataSeveranc,2),
    //                             'total_contract_severance_pay'  => round($totalContractSeverancePay,2),
    //                             'payment_date'                  => $request->payment_date,
    //                             'type'                          => 'FDC-1',
    //                             'created_by'                    => Auth::user()->id,
    //                         ]);
    //                         $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
    //                     }
    //                 }

    //                 if($item->emp_status == 10){
    //                     if($monthEndDate == $paymentDate){
    //                         $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->where('number_employee',$item->number_employee)->whereNotNull('type_fdc2')->sum('total_fdc2');
    //                         $totalContractSeverancePay = $dataSeveranc * 0.05;
    //                         $dataSeverance = SeverancePay::create([
    //                             'employee_id'                   => $item->id,
    //                             'number_employee'               => $item->number_employee,
    //                             'total_severanec_pay'           => round($dataSeveranc,),
    //                             'total_contract_severance_pay'  => round($totalContractSeverancePay,2),
    //                             'payment_date'                  => $request->payment_date,
    //                             'type'                          => 'FDC-2',
    //                             'created_by'                    => Auth::user()->id,
    //                         ]);
    //                         $totalSeverancePay = $dataSeverance->total_contract_severance_pay;
    //                     }
    //                 }
    //                 $totalSalaryBeforPension = $totalSalaryAfterTax + $totalSeverancePay + $adjustmentExcludeTaxe + $taxExemptionSalary + $totalParkAllowance;
    //                 $totalNetSalary = $totalSalaryBeforPension - $LoanAmount - $totalStaffBook;
    //                 $data   = $request->all();
    //                 $data['employee_id']                    = $item->id;
    //                 $data['number_employee']                = $item->number_employee;
    //                 $data['basic_salary']                   = $item->basic_salary;
    //                 $data['spouse']                         = $item->spouse;
    //                 $data['children']                       = $children;
    //                 $data['total_gross_salary']             = $totalBasicSalaryLast;
    //                 $data['total_child_allowance']          = $totalChildAllowance;
    //                 $data['phone_allowance']                = $item->phone_allowance;
    //                 $data['total_kny_phcumben']             = $totalBunus;
    //                 $data['monthly_quarterly_bonuses']      = $monthlyQuarterlyIncentive;
    //                 $data['annual_incentive_bonus']         = $annualBonus;
    //                 $data['other_benefits']                 = $otherBenefit;
    //                 $data['total_severance_pay']            = round($totalSeverancePay,3);
    //                 $data['seniority_pay_included_tax']     = $seniorityPayableTax;
    //                 $data['total_gross']                    = $totalGrossSalaryBeforpension;
    //                 $data['total_pension_fund']             = $pension_contribution;
    //                 $data['base_salary_received_usd']       = $totalGrossAfterPension;
    //                 $data['base_salary_received_riel']      = round($totalExchangeRiel, 3);
    //                 $data['total_tax_base_riel']            = round($totalTtaxBbaseRiel, 3);
    //                 $data['total_charges_reduced']          = $totalChargesReduced;
    //                 $data['total_rate']                     = $totalTax;
    //                 $data['seniority_pay_excluded_tax']     = $taxExemptionSalary;
    //                 $data['total_salary_tax_riel']          = round($totalSalaryTaxRiel,3);
    //                 $data['total_salary_tax_usd']           = $totalSalaryTaxUsd;
    //                 $data['loan_amount']                    = $LoanAmount;
    //                 $data['total_staff_book']               = $totalStaffBook;
    //                 $data['adjustment']                     = $adjustmentExcludeTaxe;
    //                 $data['adjustment_include_taxe']        = $adjustmentIncludeTaxe;
    //                 $data['total_amount_car']               = $totalParkAllowance;
    //                 $data['total_salary']                   = $totalNetSalary;
    //                 $data['exchange_rate']                  = $request->exchange_rate;
    //                 $data['created_by']                     = Auth::user()->id;
    //                 payrollPreview::create($data);
    //             }
    //             Toastr::success('Created payroll successfully.','Success');
    //             return redirect()->back();
    //             DB::commit();
    //         } else {
    //             DB::rollback();
    //             Toastr::error('Can not employee payroll','Error');
    //             return redirect()->back();
    //         }
    //     }catch(\Exception $e){
    //         DB::rollback();
    //         Toastr::error('Payroll created fail','Error');
    //         return redirect()->back();
    //     }
    // }
    public function payrollStaffResign(Request $request){
        if (permissionAccess("m4-s7","is_view")->value != "1") {
            return view('upgrade.access_page');
        }

        if (request()->ajax()) {
            // Define the base query
            $query = ParyllStaffResign::leftJoin('users', 'paryll_staff_resigns.employee_id', '=', 'users.id')
            ->leftJoin('positions','users.position_id','=','positions.id')
            ->leftJoin('departments','users.department_id','=','departments.id')
            ->leftJoin('branchs','users.branch_id','=','branchs.id')
            ->select(
                'paryll_staff_resigns.*',
                'users.position_id',
                'users.department_id',
                'users.branch_id',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.date_of_commencement',
                'users.basic_salary',
                'positions.name_khmer as post_name_kh',
                'positions.name_english as post_name_en',
                'departments.name_khmer as depart_name_kh',
                'departments.name_english as depart_name_en',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
            );
            $query->when($request->employee_name, function ($query, $employee_name) {
                return $query->where('users.employee_name_en', 'LIKE', "%$employee_name%");
            })
            ->when($request->number_employee, function ($query, $number_employee) {
                return $query->where('users.number_employee', $number_employee);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                return $query->where('users.branch_id', $branch_id);
            })
            ->when($request->filter_month, function ($query, $filter_month) {
                return $query->whereMonth('paryll_staff_resigns.payment_date', date('m', strtotime($filter_month)));
            });

            // **Search Handling**
            $searchValue = request()->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('paryll_staff_resigns.id', 'like', "%{$searchValue}%")
                    ->orWhere('users.number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('positions.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('departments.name_english', 'like', "%{$searchValue}%")
                    ->orWhere('branchs.branch_name_en', 'like', "%{$searchValue}%");
                });
            }

            // Fetch paginated data
            $recordsTotal = ParyllStaffResign::count();
            $recordsFiltered = $query->count();
            // Apply pagination for the actual data retrieval
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));
            $data = $query->offset($start)->limit($limit)->orderBy('users.number_employee', 'ASC')->get();
            
            // Return JSON response
            return response()->json([
                'draw' => intval($request->input('draw')),  // Optional: for client-side tracking
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }

        $staffResign = User::whereIn('emp_status',['3','4','5','6','7','8','9'])->get();
        $branch = Branchs::all();
        $exChangeRateSalary= ExchangeRate::where('type','Salary')->orderBy('id','desc')->first();
        $exChangeRateNSSF= ExchangeRate::where('type','NSSF')->orderBy('id','desc')->first();
        return view('payrolls.payroll_staff_resign',compact('staffResign','branch','exChangeRateSalary','exChangeRateNSSF'));
    }
    public function payrollStaffResignCreate(Request $request){
        try{
            $staffResign = User::where('number_employee',$request->number_employee)->whereIn('emp_status',['3','4','5','6','7','8','9'])->get();
            if (!$staffResign->isEmpty()) {
                foreach ($staffResign as $item) {
                    PreviewNationalSocialSecurityFund::where('employee_id',$item->id)->delete();
                    ParyllStaffResign::where('employee_id',$item->id)->delete();
                    //function ajustment
                    $paymentDate = Carbon::createFromDate($request->payment_date)->format('m-y');
                    $dataPayrollAdjustment = PayrollAdjustment::where('employee_id',$item->id)->get();
                    $adjustmentIncludeTaxe = 0;
                    $adjustmentExcludeTaxe = 0;
                    foreach ($dataPayrollAdjustment as $valueAdjust) {
                        $adjustmentDate = Carbon::createFromDate($valueAdjust->adjustment_date)->format('m-y');
                        if($adjustmentDate == $paymentDate){
                            if ($valueAdjust->adjustment_type == 'include_taxe') {
                                $adjustmentIncludeTaxe = $valueAdjust->amount;
                            }else{
                                $adjustmentExcludeTaxe = $valueAdjust->amount;
                            }
                        }
                    }
                    //calculated khmer_new_year and pchumBen_bonus
                    $totalBunus = 0;
                    if ($item->resign_date >= $request->payment_date) {
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
                            }
                            $totalBunus = $totalAllowanceBunus ?? 0;
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
                    
                    $baseSalary = $item->basic_salary;
                    $monthlyQuarterlyIncentive = $request->monthly_quarterly_incentive == null ? 0 : $request->monthly_quarterly_incentive;
                    $totalGrossSalary = $item->basic_salary + $adjustmentIncludeTaxe + $item->phone_allowance + $monthlyQuarterlyIncentive + $totalChildAllowance + $totalBunus + $request->other_benefits + $request->annual_incentive_bonus;
                    $totalSalaryAL = 0;
                    // function get age employee <= 60 National Social Security Fund (NSSF) Formula
                    $pension_contribution = 0;
                    if($item->is_type_nssf != 1){
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

                            $workerContributionRiel = 0;
                            $age = Carbon::createFromDate($item->date_of_birth)->format('Y-m-d');
                            $yearsOfEmployee = Carbon::parse($age)->age;
                            if($yearsOfEmployee < 60){
                                $workerContributionRiel = $workerContributionUsd / $exchangNSSF->amount_riel;
                            }
                            $dataNSSF = PreviewNationalSocialSecurityFund::create([
                                'employee_id'                   => $item->id,
                                'number_employee'               => $item->number_employee,
                                'total_pre_tax_salary_usd'      => round($totalGrossSalary,2),
                                'total_pre_tax_salary_riel'     => $totalExchangeRielPreTax,
                                'total_average_wage'            => $averageWage,
                                'total_occupational_risk'       => round($occupationalRisk,-2),
                                'total_health_care'             => $healthCare,
                                'pension_contribution_usd'      => round($workerContributionUsd, -2),
                                'pension_contribution_riel'     => $workerContributionRiel,
                                'corporate_contribution'        => round($workerContributionUsd, -2),
                                'exchange_rate'                 => $exchangNSSF->amount_riel,
                                'payment_date'                  => $request->payment_date,
                                'created_by'                    => Auth::user()->id,
                            ]);
                        }
                        $pension_contribution = round($dataNSSF->pension_contribution_riel,2);
                    }

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
                                    $currentYear = Carbon::createFromDate($nextYear.'-01-01')->format('Y-m-d');
                                }
                            }
                            if ($currentDate == 12) {
                                $currentMonth = Carbon::createFromDate($nextYear.'-07-01')->format('Y-m-d');
                            }
                            $totalSalary = GrossSalaryPay::where('employee_id', $item->id)->where('type_udc','UDC')->when($currentYear ,function ($query, $udc_end_date) {
                                $query->where('payment_date', '>=',$udc_end_date);
                            })->when($currentMonth, function($query, $currentMonth){
                                $query->where('payment_date', '>=',$currentMonth);
                            })->pluck('total_fdc1')->avg();
                            
                            $totalSalaryReceive = (round($totalSalary,2) / 22) * 7.5;
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
                    // dd($baseSalaryReceivedUsd);
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
                        if($totalExchangeRiel > 0 && $totalExchangeRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalExchangeRiel > 1500001 && $totalExchangeRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalExchangeRiel > 2000001 && $totalExchangeRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalExchangeRiel > 8500001 && $totalExchangeRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;

                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    } else if($number_of_children == 1 && $item->spouse == 0) {
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 0 && $item->spouse == 1) {
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
    
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 1 && $item->spouse == 1) {
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 2 && $item->spouse == 0){
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 2 && $item->spouse == 1){
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 3 && $item->spouse == 0){
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 3 && $item->spouse == 1){
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 4 && $item->spouse == 0){
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                        $totalSalaryTaxUsd = round($totalSalaryTaxRiel,2) / $request->exchange_rate;
                        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
                        $totalSalaryAfterTax = $baseSalaryReceivedUsd - round($totalSalaryTaxUsd,2);
                    }else if($number_of_children == 4 && $item->spouse == 1){
                        if($totalTtaxBbaseRiel > 0 && $totalTtaxBbaseRiel <= 1500000){
                            $totalTax = 0;
                        }elseif($totalTtaxBbaseRiel > 1500001 && $totalTtaxBbaseRiel <= 2000000){
                            $totalTax = 5;
                        }elseif($totalTtaxBbaseRiel > 2000001 && $totalTtaxBbaseRiel <= 8500000){
                            $totalTax = 10;
                        }elseif($totalTtaxBbaseRiel > 8500001 && $totalTtaxBbaseRiel <= 12500000){
                            $totalTax = 15;
                        }else{
                            $totalTax = 20;
                        }
                        
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
                            $dataSeveranc = GrossSalaryPay::where('employee_id', $item->id)->whereNotNull('type_fdc1')->sum('total_fdc1');
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
                    $totalSalary = $totalSalaryAfterTax + $totalSeverancePay + $adjustmentExcludeTaxe + $taxExemptionSalary + $request->parking_allowance - $request->staff_loan - $request->staff_book;
                    if($request->staff_loan > $totalSalary){
                        $totalNetSalary = 0;
                    }else{
                        $totalNetSalary = $totalSalary;
                    }
                    $data   = $request->all();
                    $data['employee_id']                    = $item->id;
                    $data['number_employee']                = $item->number_employee;
                    $data['basic_salary']                   = $item->basic_salary;
                    $data['spouse']                         = $item->spouse;
                    $data['children']                       = $children;
                    $data['total_gross_salary']             = $baseSalary;
                    $data['total_child_allowance']          = $totalChildAllowance;
                    $data['phone_allowance']                = $item->phone_allowance;
                    $data['total_kny_phcumben']             = $totalBunus;
                    $data['monthly_quarterly_bonuses']      = $monthlyQuarterlyIncentive;
                    $data['other_benefits']                 = $request->other_benefits;
                    $data['annual_incentive_bonus']         = $request->annual_incentive_bonus == null ? 0 : $request->annual_incentive_bonus;
                    $data['total_severance_pay']            = round($totalSeverancePay,3);
                    $data['seniority_pay_included_tax']     = $seniorityPayableTax;
                    $data['adjustment_include_taxe']        = $adjustmentIncludeTaxe;
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
                    $data['loan_amount']                    = $request->staff_loan;
                    $data['adjustment']                     = $adjustmentExcludeTaxe;
                    $data['total_staff_book']               = $request->staff_book;
                    $data['total_amount_car']               = $request->parking_allowance;
                    $data['total_salary']                   = $totalNetSalary;
                    $data['leaves']                         = $totalSalaryAL;
                    $data['exchange_rate']                  = $request->exchange_rate;
                    $data['created_by']                     = Auth::user()->id;
                    ParyllStaffResign::create($data);
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
            $number_employee = $request->number_employee;
            $dataPayroll = payrollPreview::whereIn('number_employee',explode(",",$number_employee))->get();
            $dataNssf = PreviewNationalSocialSecurityFund::whereIn('number_employee',explode(",",$number_employee))->get();
            $dataGrossSalaryPay = PreviewGrossSalaryPay::whereIn('number_employee',explode(",",$number_employee))->get();
            $dataBonus = PreviewBonus::whereIn('number_employee',explode(",",$number_employee))->get();
            if ($dataBonus) {
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
                    PreviewBonus::whereIn('number_employee',explode(",",$number_employee))->delete();
                }
            }
            if ($dataNssf) {
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
                    PreviewNationalSocialSecurityFund::whereIn('number_employee',explode(",",$number_employee))->delete();
                }
            }
            if ($dataGrossSalaryPay) {
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
                        'created_by'            => $item->created_by,
                    ]);
                    PreviewGrossSalaryPay::whereIn('number_employee',explode(",",$number_employee))->delete();
                }
            }
            if ($dataPayroll) {
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
                        'total_staff_book'          => $item->total_staff_book,
                        'total_amount_car'          => $item->total_amount_car,
                        'total_salary'              => $item->total_salary,
                        'exchange_rate'             => $item->exchange_rate,
                        'adjustment'                => $item->adjustment,
                        'adjustment_include_taxe'   => $item->adjustment_include_taxe,
                        'leaves'                    => $item->leaves,
                        'created_by'                => $item->created_by,
                    ]);
                    payrollPreview::whereIn('number_employee',explode(",",$number_employee))->delete();
                }
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
        $payslip = Payroll::with('users')->where('id',$request->id)->first();
        return view('payrolls.payslip',compact('payslip'));
    }

    public function importPayroll(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $AllPayroll =  $spreadsheet->getSheetByName('payroll')->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            $dataUserLeaveArray = [];
            foreach ($AllPayroll as $item) {
                $i++;
                if ($i != 1) {
                    $employee = User::where("number_employee", $item[0])->first();
                    if($employee){
                        Payroll::firstOrCreate([
                            'employee_id'                   => $employee->id,
                            'number_employee'               => $item[0] == null ? 0 : $item[0],
                            'basic_salary'                  => $item[2] == null ? 0 : $item[2],
                            'total_gross_salary'            => $item[3] == null ? 0 : $item[3],
                            'total_child_allowance'         => $item[4] == null ? 0 : $item[4],
                            'phone_allowance'               => $item[5] == null ? 0 : $item[5],
                            'monthly_quarterly_bonuses'     => $item[6] == null ? 0 : $item[6],
                            'total_kny_phcumben'            => $item[7] == null ? 0 : $item[7],
                            'annual_incentive_bonus'        => $item[8] == null ? 0 : $item[8],
                            'seniority_pay_included_tax'    => $item[9] == null ? 0 : $item[9],
                            'seniority_pay_included_tax'    => $item[10] == null ? 0 : $item[10],
                            'total_gross'                   => $item[11] == null ? 0 : $item[11],
                            'total_pension_fund'            => $item[12] == null ? 0 : $item[12],
                            'base_salary_received_usd'      => $item[13] == null ? 0 : $item[13],
                            'base_salary_received_riel'     => $item[14] == null ? 0 : $item[14],
                            'spouse'                        => $item[15] == null ? 0 : $item[15],
                            'children'                      => $item[16] == null ? 0 : $item[16],
                            'total_charges_reduced'         => $item[17] == null ? 0 : $item[17],
                            'total_tax_base_riel'           => $item[18] == null ? 0 : $item[18],
                            'total_rate'                    => $item[19] == null ? 0 : $item[19],
                            'total_salary_tax_usd'          => $item[20] == null ? 0 : $item[20],
                            'total_salary_tax_riel'         => $item[21] == null ? 0 : $item[21],
                            'seniority_pay_excluded_tax'    => $item[22] == null ? 0 : $item[22],
                            'seniority_backford'            => $item[23] == null ? 0 : $item[23],
                            'total_severance_pay'           => $item[24] == null ? 0 : $item[24],
                            'loan_amount'                   => $item[25] == null ? 0 : $item[25],
                            'total_amount_car'              => $item[26] == null ? 0 : $item[26],
                            'total_salary'                  => $item[27] == null ? 0 : $item[27],
                            'payment_date'                  => $item[28] == null ? 0 : $item[28],
                            'exchange_rate'                 => $item[29] == null ? 0 : $item[29],
                            'created_by'                    => Auth::user()->id,
                        ]);
                    }else{
                        $dataUserLeaveArray[] = [$item[0]];
                    }
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
            $number_employee = $request->number_employee;
            $payment_date = $request->payment_date;
            payrollPreview::whereIn('number_employee',explode(",",$number_employee))->whereIn('payment_date',explode(",",$payment_date))->delete();
            PreviewNationalSocialSecurityFund::whereIn('number_employee',explode(",",$number_employee))->whereIn('payment_date',explode(",",$payment_date))->delete();
            GrossSalaryPay::whereIn('number_employee',explode(",",$number_employee))->whereIn('payment_date',explode(",",$payment_date))->delete();
            SeverancePay::whereIn('number_employee',explode(",",$number_employee))->whereIn('payment_date',explode(",",$payment_date))->delete();
            PreviewBonus::whereIn('number_employee',explode(",",$number_employee))->whereIn('payment_date',explode(",",$payment_date))->delete();
            Toastr::success('Payroll deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Payroll delete fail','Error');
            return redirect()->back();
        }
    }

    //payrollStaffResignDelete
    public function payrollStaffResignDelete(Request $request){
        try{
            ParyllStaffResign::where('number_employee',$request->number_employee)->delete();
            Toastr::success('Payroll staff resign deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Payroll staff resign delete fail','Error');
            return redirect()->back();
        }
    }
    public function approvedPayrollStaffResign(Request $request){
        try{
            $dataPayroll = ParyllStaffResign::where('number_employee',$request->number_employee)->get();
            $dataNssf = PreviewNationalSocialSecurityFund::where('number_employee',$request->number_employee)->get();
            if ($dataNssf) {
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
                    PreviewNationalSocialSecurityFund::where('number_employee',$request->number_employee)->delete();
                }
            }
            if ($dataPayroll) {
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
                        'total_staff_book'          => $item->total_staff_book,
                        'total_amount_car'          => $item->total_amount_car,
                        'total_salary'              => $item->total_salary,
                        'exchange_rate'             => $item->exchange_rate,
                        'adjustment'                => $item->adjustment,
                        'adjustment_include_taxe'   => $item->adjustment_include_taxe,
                        'leaves'                    => $item->leaves,
                        'created_by'                => $item->created_by,
                    ]);
                    ParyllStaffResign::where('number_employee',$request->number_employee)->delete();
                }
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
}
