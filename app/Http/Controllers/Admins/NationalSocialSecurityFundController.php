<?php

namespace App\Http\Controllers\Admins;

use App\Models\Branchs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\ExportNSSFReview;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Admin\EmployeeRepository;

class NationalSocialSecurityFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (permissionAccess("m4-s3","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $startOfLastMonth = null;
        $branch = Branchs::get();
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }else{
            $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        }
        if (Auth::user()->RolePermission == 'Employee') {
            $DataNSSF = DB::table('preview_national_social_security_funds')
            ->leftJoin('users','preview_national_social_security_funds.employee_id', '=', 'users.id')
            ->leftJoin('positions','positions.id','=','users.position_id')
            ->leftJoin('branchs','branchs.id','=','users.branch_id')
            ->leftJoin('departments','departments.id','=','users.department_id')
            ->leftJoin('options','options.id','=','users.gender')
            ->select(
                'preview_national_social_security_funds.*',
                'users.branch_id',
                'users.department_id',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.date_of_commencement',
                'users.branch_id',
                'users.department_id',
                'users.gender',
                'options.name_khmer',
                'options.name_english',
                'positions.name_khmer as position_name_khmer',
                'positions.name_english as position_name_english',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'departments.name_khmer as depart_name_kh',
                'departments.name_english as depart_name_en'
            )
            ->where('preview_national_social_security_funds.employee_id',Auth::user()->id)
            ->where('preview_national_social_security_funds.number_employee',Auth::user()->number_employee)
            ->get();
        } else {
            $DataNSSF = DB::table('preview_national_social_security_funds')
            ->leftJoin('users','preview_national_social_security_funds.employee_id', '=', 'users.id')
            ->leftJoin('positions','positions.id','=','users.position_id')
            ->leftJoin('branchs','branchs.id','=','users.branch_id')
            ->leftJoin('departments','departments.id','=','users.department_id')
            ->leftJoin('options','options.id','=','users.gender')
            ->select(
                'preview_national_social_security_funds.*',
                'users.branch_id',
                'users.department_id',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.date_of_commencement',
                'users.line_manager',
                'users.gender',
                'options.name_khmer',
                'options.name_english',
                'positions.name_khmer as position_name_khmer',
                'positions.name_english as position_name_english',
                'branchs.branch_name_kh',
                'branchs.branch_name_en',
                'departments.name_khmer as depart_name_kh',
                'departments.name_english as depart_name_en',
            )->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'HOD') {
                    if (permissionAccess("m4-s3", "is_view_salary_staff")->value == 1) {
                        $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                    }else{
                        $query->where("users.id", Auth::user()->id);
                    }
                }
                if (in_array($RolePermission, ['HR', 'DHOD', 'DBM'])) {
                    $query->where("users.id", Auth::user()->id);
                    if (optional(permissionAccess("m4-s3", "is_view_salary_staff"))->value == 1) {
                        $query->orWhere(function ($q) {
                            $q->where("users.line_manager", Auth::user()->id);
                        });
                    }
                }
                if ($RolePermission == 'BM') {
                    if (permissionAccess("m4-s3", "is_view_salary_staff")->value == 1) {
                        $query->where("users.branch_id", Auth::user()->branch_id);
                    }else{
                        $query->where("users.id", Auth::user()->id);
                    }
                }
            })->whereIn('users.emp_status',['Probation','1','10','2'])->get();
        }
        return view('NSSFs.index',compact('DataNSSF','branch'));
    }

    public function NssfExportReview(Request $request){
        return Excel::download(new ExportNSSFReview($request), 'NSSF.xlsx');
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
