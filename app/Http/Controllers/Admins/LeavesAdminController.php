<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExporLeaveAllocation;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Branchs;
use App\Models\LeaveType;
use App\Models\Department;
use App\Models\Remainning;
use App\Exports\ExportLeave;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Models\LeaveAllocation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\DelegateLeave;
use App\Models\LeaveAllocationHistory;
use App\Models\mail as ModelsMail;
use Illuminate\Support\Facades\Mail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Repositories\Admin\LeaveRepository;
use App\Repositories\Admin\EmployeeRepository;
use Carbon\CarbonPeriod;

class LeavesAdminController extends Controller
{
    private $dataRequests;
    public function __construct(LeaveRepository $request)
    {
        $this->dataRequests = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission = DB::table('permissions')
            ->where('role_id', Auth::user()->role_id)
            ->where("url", "leaves/admin")
            ->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $location = Branchs::get();
        $department = Department::get();
        return view('leaves_admin.index', compact('permission','location', 'department'));
    }

    public function detail(Request $request) {
        if ($request->ajax()) {
            $query = LeaveRequest::with(["leaveType","employee","approvedby","createdBy"])
            ->where("employee_id", $request->employee_id)
            ->when($request->start_date, function ($q, $start_date) {
                $q->where('leave_requests.start_date', '>=', $start_date);
            })
            ->when($request->end_date, function ($q, $end_date) {
                $q->where('leave_requests.end_date', '<=', $end_date);
            });
            $searchValue = $request->input('search.value');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('leave_requests.id', 'like', "%{$searchValue}%")
                    ->orWhere('leave_requests.start_date', 'like', "%{$searchValue}%")
                    ->orWhere('leave_requests.end_date', 'like', "%{$searchValue}%");

                    $q->orWhereHas('employee', function ($q2) use ($searchValue) {
                        $q2->where('number_employee', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_en', 'like', "%{$searchValue}%");
                    });

                    $q->orWhereHas('handover', function ($q2) use ($searchValue) {
                        $q2->where('employee_name_en', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%");
                    });
                    $q->orWhereHas('leaveType', function ($q2) use ($searchValue) {
                        $q2->where('name', 'like', "%{$searchValue}%");
                    });
                });
            }

            // Total count matching status filters
            $recordsTotal = (clone $query)->count();
            $recordsFiltered = $query->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            if ($limit == -1) {
                $data = $query->orderBy('leave_requests.id', 'DESC')->get();
            } else {
                $data = $query->orderBy('leave_requests.id', 'DESC')->offset($start)->limit($limit)->get();
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
        return view('leaves_admin.leave_detail');
    }

    public function employees() {
        $employees= User::when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }else{
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
        })->get();
        return response()->json([
            'employees' => $employees
        ]);
    }

    public function generate(Request $request){
        try {
            $employee = User::where("id",$request->employee_id)->first();
            $leaveType = LeaveType::get();
            $existsLeave = LeaveAllocation::where("employee_id", $request->employee_id)->first();
            
            if ($existsLeave) {
                Toastr::error('Already exists generate leave for Employee!','Error');
                return redirect()->back();
                DB::commit();
            }
            //count month for new employee Incomplete year
            $toDate = Carbon::parse($employee->fdc_date);
            // $toDate = Carbon::parse("15-04-2024");
            // dd($todate)
            $yearLy = Carbon::now()->format('Y');
            $fromDate = $yearLy."-12-31";
            $months = $toDate->diffInMonths($fromDate);
            // $toDays 		    = $toDate->diffInWeekdays("30-04-2024");
            // dd($toDays);
            $data['employee_id'] = $employee->id;
            if ($months < 12) {
                $total_day = 0;
                foreach ($leaveType as $key => $lt) {
                    if ($lt->type == "annual_leave") {
                        $total_day = (($lt->default_day / 12) * $months);
                        $data['default_annual_leave'] = $total_day;
                        $data['total_annual_leave'] = $total_day;
                    }else if($lt->type == "sick_leave") {
                        $total_day = (($lt->default_day / 12) * $months);
                        $data['default_sick_leave'] = $total_day;
                        $data['total_sick_leave'] = $total_day;
                    }else if($lt->type == "special_leave"){
                        $total_day = (($lt->default_day / 12) * $months);
                        $data['default_special_leave'] = $total_day;
                        $data['total_special_leave'] = $total_day;
                    }else{
                        $data['default_unpaid_leave'] = 0;
                        $data['total_unpaid_leave'] = 0;
                        $data['default_long_sick_leave'] = 0;
                        $data['total_long_sick_leave'] = 0;
                    }
                }
            }else{
                $data['default_annual_leave'] = 18;
                $data['default_sick_leave'] = 10;
                $data['default_special_leave'] = 22;
                $data['default_unpaid_leave'] = 0;
                $data['default_long_sick_leave'] = 0;
                $data['total_annual_leave'] = 18;
                $data['total_sick_leave'] = 10;
                $data['total_special_leave'] = 22;
                $data['total_unpaid_leave'] = 0;
                $data['total_long_sick_leave'] = 0;
            }
            LeaveAllocation::create($data);
            Toastr::success('Leave created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Leave created fail.','Error');
        }
    }
    public static function totalRequestLeaveDay($request)
    {
        $current_year = Carbon::now()->format('Y');
        //** caculate leave for end date new year */
        $total_number_of_day = $request->number_of_day;
        $current_end_date = Carbon::createFromDate($request->end_date)->format('Y');
        if($current_end_date > $current_year){
            $new_year_start = Carbon::createFromFormat('Y-m-d', $current_end_date . '-01-02');
            $new_year_end   = Carbon::createFromFormat('Y-m-d', $request->end_date);
            $newYearWorkingDays = CarbonPeriod::create($new_year_start, $new_year_end)
            ->filter(fn ($date) => $date->isWeekday())
            ->count();
            $totalCurrent_numberOfDay = $request->number_of_day - $newYearWorkingDays;
            if($request->end_half_day){
                $totalCurrent_numberOfDay = $totalCurrent_numberOfDay + 0.5;
            }
            $total_number_of_day = $totalCurrent_numberOfDay;
        }else if($current_end_date = $current_year){
            $new_year_start = Carbon::createFromFormat('Y-m-d', $current_end_date . '-01-02');
            $new_year_end   = Carbon::createFromFormat('Y-m-d', $request->end_date);
            $newYearWorkingDays = CarbonPeriod::create($new_year_start, $new_year_end)
            ->filter(fn ($date) => $date->isWeekday())
            ->count();
            $totalCurrent_numberOfDay = $newYearWorkingDays;
            if($request->end_half_day){
                $totalCurrent_numberOfDay = $totalCurrent_numberOfDay - 0.5;
            }
            $total_number_of_day = $totalCurrent_numberOfDay;
        }
        return $total_number_of_day;
    }

    public function approve(Request $request) {
        try {
            $data = LeaveRequest::with("employee")->find($request->id);

            $dataDepartment = Department::where("id", $data->employee->department_id)->first();
            $dataBranch = Branchs::where("id", $data->employee->branch_id)->first();
            $role = Auth::user()->RolePermission;
            $request_date = Carbon::createFromDate($data->created_at)->format('Y-m-d');
            $delegateLeave = DelegateLeave::
            where("delegate_id", $data->next_approver)
            ->where('start_date', '<=',  $request_date)
            ->where('end_date', '>=',  $request_date);
            $delegateLeave_branch = (clone $delegateLeave)->where('requester_id',  $dataBranch->direct_manager_id)->first();
            $delegateLeave_department = (clone $delegateLeave)->where('requester_id',  $dataDepartment->direct_manager_id)->first();

            if($role == "HOD" || $role == "CEO" || $role == 'BOD' || $role == 'DHOD'){
                $department = Auth::user()->department;
                if ($delegateLeave_department) {
                    $data['next_approver'] = "Null";
                    $data['status'] = "approved_hod";
                }else{
                    if (Auth::user()->id == $department->direct_manager_id || $role == "CEO" || $role == 'BOD'){
                        $data['next_approver'] = "Null";
                        $data['status'] = "approved_hod";
                    }else{
                            $leaveDepartment = DelegateLeave::where("requester_id",  $dataDepartment->direct_manager_id)
                            ->where('start_date', '<=', $request_date)
                            ->where('end_date', '>=', $request_date)->first();
                            $data['status'] = "approved_lm";

                            if ($leaveDepartment) {
                                $delegate = DelegateLeave::where("requester_id",  $leaveDepartment->delegate_id)
                                ->where('start_date', '<=', $request_date)
                                ->where('end_date', '>=', $request_date)->first();

                                /** Compare leave head dept with delegate */
                                if ($delegate) {

                                    if ($leaveDepartment->number_of_day < $delegate->number_of_day) {
                                        $data['next_approver'] = $delegate->requester_id;
                                    }else{
                                        $data['next_approver'] = $leaveDepartment->delegate_id;
                                    }


                                }else{
                                    $data['next_approver'] = $leaveDepartment->delegate_id;
                                }

                            }else{
                                $data['next_approver'] = $department->direct_manager_id;
                            }
                        $email_send = User::where("id", $data['next_approver'])->first();
                        // for send email
                        // $mail_message = ModelsMail::first();
                        // if ($email_send && $mail_message) {
                        //     if ($email_send->email) {
                        //         // Mail::to("oudam.chhor@camma.com.kh")->send(new SendEmail($mail_message));
                        //         Mail::to($email_send->email)->send(new SendEmail($mail_message));
                        //     }
                        // }
                    }
                }
            }else if ($role == 'BM' || $role == 'DBM') {
                $branch = Auth::user()->branch;
                if ($delegateLeave_branch) {
                    $data['next_approver'] = "Null";
                    $data['status'] = "approved_hod";
                }else{

                    if ($branch->direct_manager_id == Auth::user()->id ) {
                        $data['next_approver'] = "Null";
                        $data['status'] = "approved_hod";
                    }else{

                        $leaveBranch = DelegateLeave::where("requester_id",  $dataBranch->direct_manager_id)
                        ->where('start_date', '<=', $request_date)
                        ->where('end_date', '>=', $request_date)->first();
                        $data['status'] = "approved_lm";

                        if ($leaveBranch) {
                            $delegate = DelegateLeave::where("requester_id",  $leaveBranch->delegate_id)
                            ->where('start_date', '<=', $request_date)
                            ->where('end_date', '>=', $request_date)->first();

                            /** Compare leave head dept with delegate */
                            if ($delegate) {
                                if ($leaveBranch->number_of_day < $delegate->number_of_day) {
                                    $data['next_approver'] = $delegate->requester_id;
                                }else{
                                    $data['next_approver'] = $leaveBranch->delegate_id;
                                }
                            }else{
                                $data['next_approver'] = $leaveBranch->delegate_id;
                            }

                        }else{
                            $data['next_approver'] = $branch->direct_manager_id;
                        }

                        // $data['next_approver'] = $branch->direct_manager_id;

                        $email_send = User::where("id", $data['next_approver'])->first();
                        // for send email
                        // $mail_message = ModelsMail::first();
                        // if ($email_send && $mail_message) {
                        //     if ($email_send->email) {
                        //         // Mail::to("oudam.chhor@camma.com.kh")->send(new SendEmail($mail_message));
                        //         Mail::to($email_send->email)->send(new SendEmail($mail_message));
                        //     }
                        // }
                    }
                }
            }else if($role == 'HR' || $role =="HRAdmin") {
                $data['status'] = "approved";
            }
            $data['remark']= $request->remark;
            $data['approved_date']= Carbon::now();
            if ($data->approved_by) {
                $data['approved_by'] = $data->approved_by . ',' . Auth::user()->id; 
            }else{
                $data['approved_by'] = Auth::user()->id; 
            };

            $data->save();
            DB::commit();

            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }

    public function approveds(Request $request){
        try {
            $updated = DB::table('leave_requests')
                ->whereIn('id', $request->ids)
                ->update([
                    'status'        => "approved",
                    // 'approved_date' => Carbon::now(),
                    // 'approved_by'   => Auth::user()->id,
                    'updated_by'   => Auth::user()->id,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
    public function cancels(Request $request){
        try {
            $updated = DB::table('leave_requests')
                ->whereIn('id', $request->ids)
                ->update([
                    'status'        => "cancel",
                    'approved_date' => Carbon::now(),
                    'approved_by'   => Auth::user()->id,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
    public function reject(Request $request) {
        try {
            $data = LeaveRequest::with("leaveType")->find($request->id);
            $LeaveAllocation = LeaveAllocation::where("employee_id", $data->employee_id)->first();
            //** caculate leave for end date new year */
            $total_number_of_day = self::totalRequestLeaveDay($data);
            //** end */
            if ($data->leaveType->type == "annual_leave") {
                // $current_annual_leave = $LeaveAllocation->total_annual_leave + $data->number_of_day;
                $current_annual_leave = $LeaveAllocation->total_annual_leave +$total_number_of_day;
                $LeaveAllocation->total_annual_leave =  $current_annual_leave > $LeaveAllocation->default_annual_leave ? $LeaveAllocation->default_annual_leave : $current_annual_leave;
            }else if($data->leaveType->type == "sick_leave"){
                $current_sick_leave = $LeaveAllocation->total_sick_leave +$total_number_of_day;
                $LeaveAllocation->total_sick_leave = $current_sick_leave > $LeaveAllocation->default_sick_leave ? $LeaveAllocation->default_sick_leave : $current_sick_leave;
            }else if($data->leaveType->type == "special_leave") {
                $current_special_leave = $LeaveAllocation->total_special_leave +$total_number_of_day;
                $LeaveAllocation->total_special_leave = $current_special_leave > $LeaveAllocation->default_special_leave ? $LeaveAllocation->default_special_leave : $current_special_leave;
            }else if($data->leaveType->type == "unpaid_leave"){
                $current_unpaid_leave = $LeaveAllocation->total_unpaid_leave +$total_number_of_day;
                if ($current_unpaid_leave == 0) {
                   $LeaveAllocation->total_unpaid_leave = 0;
                }else{
                    $LeaveAllocation->total_unpaid_leave = $current_unpaid_leave;
                }
            }else if($data->leaveType->type == "long_sick_leave"){
                $current_long_sick_leave = $LeaveAllocation->total_long_sick_leave +$total_number_of_day;
                if ($current_long_sick_leave == 0) {
                    $LeaveAllocation->total_long_sick_leave = 0;
                }else{
                    $LeaveAllocation->total_long_sick_leave = $current_long_sick_leave;
                }
            }
            $role = Auth::user()->RolePermission;
            $department = Auth::user()->department;
            if($role == "HOD" || $role == "CEO" || $role == 'BOD' || $role == 'DHOD'){
                if (Auth::user()->id == $department->direct_manager_id || $role == "CEO" || $role == 'BOD') {
                    $data['status'] = $request->status == "cancel_hod" ? "cancel_hod" : "rejected_hod" ;
                }else{
                    $data['status'] = "rejected_lm";
                }
            }else if ($role == 'BM' || $role == 'DBM') {
                $branch = Auth::user()->branch;
                if ($branch->direct_manager_id == Auth::user()->id ) {
                    $data['status'] = $request->status == "cancel_hod" ? "cancel_hod" : "rejected_hod" ;
                }else{
                    $data['status'] = "rejected_lm";
                }
            }else if($role == 'HR' || $role =="HRAdmin") {
                $data['status'] = $request->status == "cancel" ? "cancel" : "rejected" ;
            }

            DelegateLeave::where('requester_id', $data->employee_id)->where("start_date",$data->start_date)->where("end_date",$data->end_date)->delete();

            $data['remark']= $request->remark;
            $data->save();
            $LeaveAllocation->save();
            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leaves_admin.create');
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
    public function show(Request $request)
    {
        if ($request->ajax()) {

            $query = LeaveRequest::with(["employee", "handover", "createdBy", "leaveType","LeaveAllocation"])
            // ->whereIn("leave_requests.status", ["approved_lm","approved_hod","pending"])
            ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
            ->select(
                'leave_requests.*',
                'users.line_manager',
                'users.department_id',
                'users.branch_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if(in_array($RolePermission, ['BOD', 'CEO','HOD', 'DHOD', 'BM', 'DBM'])){
                    $query->whereIn("leave_requests.status", ["pending"]);
                    $query->where("leave_requests.next_approver", Auth::user()->id);
                    
                }else if ($RolePermission == 'HR') {
                    if(permissionAccess("m10-s1","is_access")->value == "1"){
                        $query->whereNot("leave_requests.status", "approved");
                    }else{
                        $query->where("leave_requests.next_approver", Auth::user()->id);
                    }
                }
                else if(in_array($RolePermission, ['HRAdmin', 'admin','developer'])){
                    $query->whereIn("leave_requests.status", ["approved_lm","approved_hod","pending"]);
                    // $query->whereNot("leave_requests.status", "approved");
                }
                else if($RolePermission == 'Employee'){
                    if(permissionAccess("m10-s1","is_access")->value == "1"){
                        $query->where("users.department_id", Auth::user()->department_id);
                        $query->where("users.branch_id", Auth::user()->branch_id);
                        $query->whereNot("leave_requests.status", "approved");
                    }else{
                        $query->where("leave_requests.next_approver", Auth::user()->id);
                    }
                }
                
            });

            $searchValue = $request->input('search.value');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {

                    // 🔹 Search main table
                    $q->where('leave_requests.id', 'like', "%{$searchValue}%")
                    ->orWhere('leave_requests.start_date', 'like', "%{$searchValue}%")
                    ->orWhere('leave_requests.end_date', 'like', "%{$searchValue}%");

                    // 🔹 Search employee
                    $q->orWhereHas('employee', function ($q2) use ($searchValue) {
                        $q2->where('number_employee', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_en', 'like', "%{$searchValue}%");
                    });

                    // 🔹 Search handover
                    $q->orWhereHas('handover', function ($q2) use ($searchValue) {
                        $q2->where('employee_name_en', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%");
                    });

                    // 🔹 Search created by
                    $q->orWhereHas('createdBy', function ($q2) use ($searchValue) {
                        $q2->where('employee_name_en', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%");
                    });

                    // 🔹 Search leave type
                    $q->orWhereHas('leaveType', function ($q2) use ($searchValue) {
                        $q2->where('name', 'like', "%{$searchValue}%");
                    });
                });
            }
            $recordsTotal = (clone $query)->count();
            $recordsFiltered = $query->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            // 🔥 HANDLE "ALL"
            if ($limit == -1) {
                $data = $query->get(); // get all rows
            } else {
                $data = $query->orderBy('id', 'DESC')->offset($start)->limit($limit)->get();
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
    }
    public function showCancel(Request $request){
        if ($request->ajax()) {

            // 1. Eager load ALL relations required by the frontend
            $query = LeaveRequest::with(["employee", "handover", "leaveType", "createdBy"])
                ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
                ->select(
                    'leave_requests.*',
                    'users.line_manager',
                    'users.department_id',
                    'users.branch_id'
                )
                ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                    if(in_array($RolePermission, ['BOD', 'CEO','HOD', 'DHOD', 'BM', 'DBM'])){
                        $query->where("leave_requests.status", "pending_cancel");
                        $query->where("leave_requests.next_approver", Auth::user()->id);
                    } else if ($RolePermission == 'HR') {
                        if(permissionAccess("m10-s1","is_access")->value == "1"){
                            $query->whereIn("leave_requests.status", ["cancel_hod","cancel","pending_cancel"]);
                        } else {
                            $query->where("leave_requests.status", "pending_cancel");
                            $query->where("leave_requests.next_approver", Auth::user()->id);
                        }
                    } else if(in_array($RolePermission, ['HRAdmin', 'admin','developer'])){
                        $query->whereIn("leave_requests.status", ["cancel_hod","cancel","pending_cancel"]);
                    } else if($RolePermission == 'Employee'){
                        if(permissionAccess("m10-s1","is_access")->value == "1"){
                            $query->where("users.department_id", Auth::user()->department_id);
                            $query->where("users.branch_id", Auth::user()->branch_id);
                            $query->whereIn("leave_requests.status", ["cancel_hod","cancel","pending_cancel"]);
                        } else {
                            $query->where("leave_requests.status", "pending_cancel");
                            $query->where("leave_requests.next_approver", Auth::user()->id);
                        }
                    }
                });

            $searchValue = $request->input('search.value');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('leave_requests.id', 'like', "%{$searchValue}%")
                    ->orWhere('leave_requests.start_date', 'like', "%{$searchValue}%")
                    ->orWhere('leave_requests.end_date', 'like', "%{$searchValue}%");

                    $q->orWhereHas('employee', function ($q2) use ($searchValue) {
                        $q2->where('number_employee', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_en', 'like', "%{$searchValue}%");
                    });

                    $q->orWhereHas('handover', function ($q2) use ($searchValue) {
                        $q2->where('employee_name_en', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%");
                    });

                    $q->orWhereHas('createdBy', function ($q2) use ($searchValue) {
                        $q2->where('employee_name_en', 'like', "%{$searchValue}%")
                        ->orWhere('employee_name_kh', 'like', "%{$searchValue}%");
                    });

                    $q->orWhereHas('leaveType', function ($q2) use ($searchValue) {
                        $q2->where('name', 'like', "%{$searchValue}%");
                    });
                });
            }

            // Total count matching status filters
            $recordsTotal = (clone $query)->count();
            $recordsFiltered = $query->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            if ($limit == -1) {
                $data = $query->orderBy('leave_requests.id', 'DESC')->get();
            } else {
                $data = $query->orderBy('leave_requests.id', 'DESC')->offset($start)->limit($limit)->get();
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
    }
    public function showRecord(Request $request)
    {
        if ($request->ajax()) {

            // 1. Get base query with joins and role permission scope applied
            $baseQuery = $this->dataRequests->getLeaveAllocationQuery($request);

            // 2. Total records matching the user's role permissions (before search/filters)
            $recordsTotal = (clone $baseQuery)->count();

            // 3. Apply custom request filters (employee_id, employee_name, department, branch)
            $query = $baseQuery->when($request->employee_id, function ($q, $employee_id) {
                $q->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($q, $employee_name) {
                $q->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($request->department_id, function ($q, $department) {
                $q->where('users.department_id', $department);
            })
            ->when($request->branch_id, function ($q, $branch) {
                $q->where('users.branch_id', $branch);
            });

            // 4. Apply DataTables Global Search Box
            $searchValue = $request->input('search.value');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('users.number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('users.employee_name_kh', 'like', "%{$searchValue}%")
                    ->orWhere('leave_allocations.id', 'like', "%{$searchValue}%");
                });
            }

            // 5. Total records after search and filters are applied
            $recordsFiltered = $query->count();

            // 6. Data Fetching & Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            if ($limit == -1) {
                $data = $query->orderBy('users.number_employee', 'asc')->get();
            } else {
                $data = $query->orderBy('users.number_employee', 'asc')
                            ->offset($start)
                            ->limit($limit)
                            ->get();
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
    }
    public function showReport(Request $request)
    {
        if ($request->ajax()) {

            // Get base query with roles applied
            $baseQuery = $this->dataRequests->getStaffReports($request);

            // Calculate total count before global search
            $recordsTotal = DB::table(DB::raw("({$baseQuery->toSql()}) as sub"))
                ->mergeBindings($baseQuery->getQuery())
                ->count();

            // Handle DataTables search
            $searchValue = $request->input('search.value');
            if (!empty($searchValue)) {
                $baseQuery->whereHas('employee', function ($q) use ($searchValue) {
                    $q->where('number_employee', 'like', "%{$searchValue}%")
                    ->orWhere('employee_name_en', 'like', "%{$searchValue}%")
                    ->orWhere('employee_name_kh', 'like', "%{$searchValue}%");
                });
            }

            // Count after search filters
            $recordsFiltered = DB::table(DB::raw("({$baseQuery->toSql()}) as sub"))
                ->mergeBindings($baseQuery->getQuery())
                ->count();

            // Pagination
            $start = intval($request->input('start', 0));
            $limit = intval($request->input('length', 10));

            if ($limit == -1) {
                $data = $baseQuery->get();
            } else {
                $data = $baseQuery->offset($start)->limit($limit)->get();
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ]);
        }
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

    public function GenerateLeave(){
        $data = LeaveAllocation::all();
        $AnnualLeave = LeaveType::where('type','annual_leave')->first();
        $SickLeave = LeaveType::where('type','sick_leave')->first();
        $SpecialLeave = LeaveType::where('type','special_leave')->first();
        return view('leaves_admin.generat_leave',compact('AnnualLeave','SickLeave','SpecialLeave','data'));
    }
    public static function calculateAnnualLeave($dbDate, $remainingDay)
    {
        $totalMonths = Carbon::now()->diffInMonths($dbDate);
        $diffYears   = intdiv($totalMonths, 12);
        $remainMonths = $totalMonths % 12;

        // If they worked more than 0 month → treat as next year
        if ($remainMonths > 0) {
            $diffYears += 1;
        }
        // 1–3 years
        if ($diffYears <= 3) {
            $max = 0;
            if ($remainingDay >= 6) {
                $max = 6;
            } else {
                $max = $remainingDay;
            }
            return [
                "total" => 18,
                "max"   => $max
            ];
        }
        // >= 4 years (block calculation)
        // Block size: 3 years => +1 leave
        $blockIndex   = intdiv($diffYears - 4, 3);   // 0,1,2,3...
        $totalLeave   = 19 + $blockIndex;           // 19,20,21...
        $maxLeave     = 7 + $blockIndex;            // 7,8,9...
        $year = 0;
        if ($remainingDay >= $maxLeave) {
            $year = $maxLeave;
        } else {
            $year = $remainingDay;
        }
        return [
            "total" => $totalLeave,
            "max"   => $year
        ];
    }
    public static function rotateRemainYears($data, $max)
    {
        return [
            "remain_year_1" => $max,                // new year → new max limit
            "remain_year_2" => $data->year_1,       // previous year_1 → year_2
            "remain_year_3" => $data->year_2        // previous year_2 → year_3
        ];
    }
    
    public static function totalRequestLeave ($employee_id){
        $year = Carbon::now()->format('Y');
        $yearStart = Carbon::create($year, 1, 2);
        $yearEnd   = Carbon::create($year, 12, 31);
        $leaveRequest = LeaveRequest::with("leaveType")->where("employee_id",$employee_id)
            ->whereDate('start_date', '<=', $yearEnd)
            ->whereDate('end_date', '>=', $yearStart)
            ->get();
            $total_annual_leave     =0;
            $total_sick_leave       =0;
            $total_special_leave    =0;
            $total = 0;
            $yearStartCompare = Carbon::createFromFormat('Y-m-d', $year . '-01-01');
            if(count($leaveRequest) > 0){
                foreach ($leaveRequest as $item) {
                    if($item->start_date < $yearStartCompare){
                        $from = Carbon::parse($item->start_date)->max($yearStart);
                        $to   = Carbon::parse($item->end_date)->min($yearEnd);
                        $workingDays = CarbonPeriod::create($from, $to)
                            ->filter(fn ($date) => $date->isWeekday())
                            ->count();
                        if($item->end_half_day){
                            $total = $workingDays - 0.5;
                        }
                    }else{
                        $total = $item->number_of_day;
                    }
    
                    switch ($item->leaveType->type) {
                        case 'annual_leave':
                            $total_annual_leave += $total;
                            break;

                        case 'sick_leave':
                            $total_sick_leave += $total;
                            break;

                        case 'special_leave':
                            $total_special_leave += $total;
                            break;
                    }
                }
            }
            
        return [
            "total_annual_leave" => $total_annual_leave,
            "total_sick_leave" => $total_sick_leave,
            "total_special_leave" => $total_special_leave,
            "total_unpaid_leave" => 0
        ];
    }
    public function CreateGenerateLeave(Request $request){
        try {
            $employee = User::whereIn('emp_status',['1','10','2'])->get();
            if ($employee) {
                foreach ($employee as $item) {
                    // $dbDate = "2021-01-01";
                    $dbDate = Carbon::parse($item->date_of_commencement);
                    // $diffYears = 3;
                    $diffYears = Carbon::now()->diffInYears($dbDate);
                    $data = LeaveAllocation::where('employee_id',$item->id)->first();
                    LeaveAllocationHistory::create($data->toArray());
                    if ($data) {
                        $defaultDays = $request->annual_leave;
                        $sick_leave = $request->sick_leave;
                        $special_leave = $request->special_leave;
                        $remain_year_1 = $data->year_1;
                        $remain_year_2 = $data->year_2;
                        $remain_year_3 = $data->year_3;
                        if($diffYears){
                            $remainingDay = $data->total_annual_leave;
                            $calculateAnnualLeave = self::calculateAnnualLeave($dbDate, $remainingDay);
                            $totalAnnualLeave = $calculateAnnualLeave['total'];
                            $max = $calculateAnnualLeave['max'];
                            // Step 2: rotate remain_year_1..3
                            $rotated = self::rotateRemainYears($data, $max);
                            $remain_year_1 = $rotated["remain_year_1"];
                            $remain_year_2 = $rotated["remain_year_2"];
                            $remain_year_3 = $rotated["remain_year_3"];
                            $defaultDays = $totalAnnualLeave;
                        }
                        $totalRequestLeaves = self:: totalRequestLeave($item->id);
                        LeaveAllocation::where('employee_id',$item->id)->update([
                            'default_annual_leave'  => $defaultDays,
                            'default_sick_leave'  => $sick_leave,
                            'default_special_leave'  => $special_leave,
                            'default_unpaid_leave'  => 0,
                            'total_annual_leave'  => ($defaultDays - $totalRequestLeaves["total_annual_leave"]),
                            'total_sick_leave'  => ($sick_leave - $totalRequestLeaves["total_sick_leave"]),
                            'total_special_leave'  => ($special_leave - $totalRequestLeaves["total_special_leave"]),
                            'total_unpaid_leave'  => 0,
                            'year_1'  => $remain_year_1,
                            'year_2'  => $remain_year_2,
                            'year_3'  => $remain_year_3,
                            'created_at'=>Carbon::now()
                        ]);
                    }
                }
            }
            Toastr::success('The process has been successfully.','Success');
            return redirect('leaves/admin');
            DB::commit();
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }

    public function Report(Request $request) {
        if (permissionAccess("m10-s3","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $location = Branchs::get();
        $department = Department::get();
        $leaveType = LeaveType::get();
        $LeaveAllocation = $this->dataRequests->getDatas($request);
        return view('leaves_admin.leave_report', compact('LeaveAllocation','leaveType','location','department'));
    }
    public function FilterReport(Request $request) {
        $data = $this->dataRequests->getDatas($request);
        return response()->json([
            'success'=>$data,
        ]);
    }
    public function Export(Request $request) {
        $data = $this->dataRequests->getDatas($request);
        $export = new ExportLeave($data);
        return Excel::download($export, 'Leave Request.xlsx');
    }
    public function ImportLeave(Request $request){
        $file = $request->file;
        $filesize = filesize($file);
        $extension = $request->file->extension();
        $spreadsheet = IOFactory::load($file);
        $AllLeave = $spreadsheet->getActiveSheet()->toArray();
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
            $i = 0;
            $dataArray = [];
            foreach ($AllLeave as $item) {
                $i++;
                if ($i != 1) {
                    $employee = User::where("number_employee", $item[0])->first();
                    LeaveAllocation::firstOrCreate([
                        'employee_id'               => $employee->id,
                        'default_annual_leave'      => $item[2],
                        'total_annual_leave'        => $item[2],
                        'default_sick_leave'        => $item[3],
                        'total_sick_leave'          => $item[3],
                        'default_special_leave'     => $item[4],
                        'total_special_leave'       => $item[4],
                        'default_unpaid_leave'      => $item[5],
                        'total_unpaid_leave'        => $item[5],
                        'default_long_sick_leave'   => 0,
                        'total_long_sick_leave'     => 0,
                        'year_1'                    => $item[6],
                        'year_2'                    => $item[7],
                        'year_3'                    => $item[8],
                        'created_by'    => Auth::user()->id,
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

    public function ExportLeaveAllocation(Request $request){
        if($request->condiction_tab == 4){
            $data = $this->dataRequests->getLeaveReports($request);
        }else{
           $data = $this->dataRequests->getLeaveAllocation($request); 
        }
        $export = new ExporLeaveAllocation($data, $request);
        return Excel::download($export, 'Leave Records.xlsx');
    }
}
