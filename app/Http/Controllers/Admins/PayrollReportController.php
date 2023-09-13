<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\Bonus;
use App\Models\Branchs;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Models\SeverancePay;
use Illuminate\Http\Request;
use App\Exports\ExportMotorRentel;
use App\Exports\ExportPayroll;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Maatwebsite\Excel\Facades\Excel;
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
        $payroll = Payroll::with('users')->orderBy('employee_id')->get();
        $dataNSSF = NationalSocialSecurityFund::orderBy('employee_id')->get();
        $dataSeniority = Seniority::orderBy('employee_id')->get();
        $severancePay = SeverancePay::orderBy('employee_id')->get();
        $benefit = Bonus::with("users")->orderBy('employee_id')->get();
        return view('reports.payroll_report',compact('payroll','dataNSSF','dataSeniority','severancePay','benefit'));
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
        if ($request->tab_status == 1) {
            $payroll = Payroll::with("users")
            ->join('users', 'payrolls.employee_id', '=', 'users.id')
            ->select(
                'payrolls.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('payment_date', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('payment_date', $yearLy);
            })->get();
        }else if ($request->tab_status == 2) {
            $payroll = NationalSocialSecurityFund::with("users")
            ->join('users', 'national_social_security_funds.employee_id', '=', 'users.id')
            ->select(
                'national_social_security_funds.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('payment_date', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('payment_date', $yearLy);
            })->get();
        }else if($request->tab_status == 3){
            
            $payroll = Bonus::with("users")->get();

        }else if ($request->tab_status == 4) {
            $payroll = Seniority::with("users")
            ->join('users', 'seniorities.employee_id', '=', 'users.id')
            ->select(
                'seniorities.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('payment_date', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('payment_date', $yearLy);
            })
            ->get();
        }else {
            $payroll = SeverancePay::with("users")
            ->join('users', 'severance_pays.employee_id', '=', 'users.id')
            ->select(
                'severance_pays.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('payment_date', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('payment_date', $yearLy);
            })
            ->get();
        }
        
        return response()->json([
            'success'=>$payroll,
        ]);
    }

    // Export payroll
    public function payrollExport(Request $request){
        return Excel::download(new ExportPayroll($request), 'ReportPayroll.xlsx');
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
}
