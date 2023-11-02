<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Branchs;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Exports\ExportTax;
use App\Models\Department;
use App\Exports\ExportNSSF;
use App\Models\SeverancePay;
use Illuminate\Http\Request;
use App\Exports\ExportBenefit;
use App\Exports\ExportPayroll;
use App\Models\GrossSalaryPay;
use App\Exports\ExportMotorRentel;
use App\Exports\ExportSeniorityPay;
use App\Exports\ExportSeverancePay;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\NationalSocialSecurityFund;
use App\Repositories\Admin\MotorRentalRepository;

class PayrollReportController extends Controller
{
    private $dataMotor;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(MotorRentalRepository $dataMotors)
    {
        $this->dataMotor = $dataMotors;
    }
    public function index()
    {
        $payroll = Payroll::with('users')->orderBy('id', 'DESC')->get();
        $branchs = Branchs::get();
        return view('reports.payroll_report',compact('payroll','branchs'));
    }

    public function reportNssf(){
        $dataNSSF = NationalSocialSecurityFund::with('users')->orderBy('id', 'DESC')->get();
        $branchs = Branchs::get();
        return view('reports.poyrolls.snnf_report',compact('dataNSSF','branchs'));
    }
    public function reportBenefitKNYPCh(){
        $benefit = Bonus::with("users")->orderBy('employee_id','DESC')->get();
        $branchs = Branchs::get();
        return view('reports.poyrolls.benefit_report',compact('benefit','branchs'));
    }
    public function reportSeverancePay(){
        $severancePay = SeverancePay::orderBy('employee_id')->orderBy('id', 'DESC')->get();
        $branchs = Branchs::get();
        return view('reports.poyrolls.severance_pay_report',compact('severancePay','branchs'));
    }
    public function reportSenorityPay(){
        $dataSeniority = Seniority::with('users')->orderBy('id', 'DESC')->get();
        $branchs = Branchs::get();
        return view('reports.poyrolls.seniority_pay_report',compact('dataSeniority','branchs'));
    }
    public function BenefitFilter(Request $request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $benefit = Bonus::with("users")
        ->leftJoin('users', 'bonuses.employee_id', '=', 'users.id')
        ->leftJoin('options','options.id','=','users.gender')
        ->leftJoin('positions','positions.id','=','users.position_id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->select(
            'bonuses.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'options.name_khmer',
            'options.name_english',
            'options.type',
            'positions.name_khmer as positionNameKhmer',
            'positions.name_english as positionNameEnglish',
            'branchs.branch_name_kh as branck_kh',
            'branchs.branch_name_en as branck_en',
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
            'success'=>$benefit,
        ]);
    }
    public function TaxReport(){
        $payroll = Payroll::with('users')->orderBy('id', 'DESC')->get();
        $branchs = Branchs::get();
        return view('reports.poyrolls.tax_report',compact('payroll','branchs'));
    }
    public function TaxFilter(Request $request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $taxReport=[];
        $taxReport = Payroll::with("users")
        ->leftJoin('users', 'payrolls.employee_id', '=', 'users.id')
        ->leftJoin('positions','positions.id','=','users.position_id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->leftJoin('departments','departments.id','=','users.department_id')
        ->select(
            'payrolls.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.branch_id',
            'positions.name_khmer as position_name_kh',
            'positions.name_english as position_name_en',
            'branchs.branch_name_kh as branck_kh',
            'branchs.branch_name_en as branck_en',
            'departments.name_khmer as depart_name_kh',
            'departments.name_english as depart_name_en',
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
            'success'=>$taxReport,
        ]);
    }
    public function nssfFilter(Request $request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $nssf = NationalSocialSecurityFund::with("users")
        ->leftJoin('users', 'national_social_security_funds.employee_id', '=', 'users.id')
        ->leftJoin('options','options.id','=','users.gender')
        ->leftJoin('positions','positions.id','=','users.position_id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->select(
            'national_social_security_funds.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'options.name_khmer',
            'options.name_english',
            'options.type',
            'positions.name_khmer as positionNameKhmer',
            'positions.name_english as positionNameEnglish',
            'branchs.branch_name_kh as branck_kh',
            'branchs.branch_name_en as branck_en',
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
            'success'=>$nssf,
        ]);
    }
    public function SeverancePayFilter(Request $request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $nssf = SeverancePay::with("users")
        ->leftJoin('users', 'severance_pays.employee_id', '=', 'users.id')
        ->leftJoin('options','options.id','=','users.gender')
        ->leftJoin('positions','positions.id','=','users.position_id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->select(
            'severance_pays.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'options.name_khmer',
            'options.name_english',
            'options.type',
            'positions.name_khmer as positionNameKhmer',
            'positions.name_english as positionNameEnglish',
            'branchs.branch_name_kh as branck_kh',
            'branchs.branch_name_en as branck_en',
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
            'success'=>$nssf,
        ]);
    }
    public function SenorityPayFilter(Request $request){
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $Seniority = Seniority::with("users")
        ->leftJoin('users', 'seniorities.employee_id', '=', 'users.id')
        ->leftJoin('options','options.id','=','users.gender')
        ->leftJoin('positions','positions.id','=','users.position_id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->select(
            'seniorities.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'options.name_khmer',
            'options.name_english',
            'options.type',
            'positions.name_khmer as positionNameKhmer',
            'positions.name_english as positionNameEnglish',
            'branchs.branch_name_kh as branck_kh',
            'branchs.branch_name_en as branck_en',
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
            'success'=>$Seniority,
        ]);
    }
    
    public function filter(Request $request)
    {
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll=[];
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

    // Export payroll
    public function payrollExport(Request $request){
        return Excel::download(new ExportPayroll($request), 'ReportPayroll.xlsx');
    }

    public function nssfExport(Request $request){
        return Excel::download(new ExportNSSF($request), 'NSSF.xlsx');
    }
    public function BenefitExport(Request $request){
        return Excel::download(new ExportBenefit($request), 'benefit.xlsx');
    }
    public function SeverancePayExport(Request $request){
        return Excel::download(new ExportSeverancePay($request), 'severance_pay.xlsx');
    }
    public function SenorityPayExport(Request $request){
        return Excel::download(new ExportSeniorityPay($request), 'seniority_pay.xlsx');
    }
    public function TaxExport(Request $request){
        return Excel::download(new ExportTax($request), 'ReportTax.xlsx');
    }
    public function motorrentel(Request $request)
    {
        $data = $this->dataMotor->getDatas($request);
        $branchs = Branchs::get();
        $departments = Department::get();
        if ($request->research) {
            return response()->json(['data'=>$data]);
        }else {
            return view('reports.motor_rentel_report', compact('data', 'branchs', 'departments'));
        }
    }

    // Export List motor rentel in payroll
    public function export(Request $request)
    {
        $data = $this->dataMotor->getDatas($request);
        return Excel::download(new ExportMotorRentel($data), 'MotorRentel.xlsx');
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


    public function SeverancePay(){
        $branch = Branchs::get();
        $data = GrossSalaryPay::with('users')->where('type_fdc1','fdc1')->get();
        return view('severance_pays.index',compact('data','branch'));
    }
    public function SeverancePayFil(Request $request){
        $nssf = GrossSalaryPay::with("users")->where('type_fdc1','fdc1')
        ->leftJoin('users', 'gross_salary_pays.employee_id', '=', 'users.id')
        ->leftJoin('positions','positions.id','=','users.position_id')
        ->leftJoin('branchs','branchs.id','=','users.branch_id')
        ->leftJoin('departments','departments.id','=','users.department_id')
        ->select(
            'gross_salary_pays.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'positions.name_khmer as position_name_khmer',
            'positions.name_english as position_name_english',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'departments.name_khmer as depart_name_kh',
            'departments.name_english as depart_name_en',
        )
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('users.branch_id', $branch_id);
        })->get();
        return response()->json([
            'success'=>$nssf,
        ]);
    }
    public function importSeverancePay(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $AllSeverancePay =  $spreadsheet->getSheetByName('Severance Pay')->toArray();
        // dd($AllSeverancePay);
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($AllSeverancePay as $item) {
                $i++;
                if ($i != 1) {
                    $employee = User::where("number_employee", $item[0])->first();
                    GrossSalaryPay::create([
                        'employee_id'                   => $employee->id,
                        'number_employee'               => $item[0],
                        'basic_salary'                  => $item[2],
                        'total_gross_salary'            => $item[3],
                        'total_fdc1'                    => $item[4],
                        'type_fdc1'                     => $item[5],
                        'payment_date'                  => $item[6],
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
}
