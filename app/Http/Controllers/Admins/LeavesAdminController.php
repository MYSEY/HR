<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportLeave;
use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\Remainning;
use Illuminate\Http\Request;
use App\Models\LeaveAllocation;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Admin\EmployeeRepository;
use App\Repositories\Admin\LeaveRepository;
use Maatwebsite\Excel\Facades\Excel;

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
    public function index()
    {
        $location = Branchs::get();
        $department = Department::get();
        $LeaveAllocation = LeaveAllocation::with("employee")
        ->leftJoin('users', 'leave_allocations.employee_id', '=', 'users.id')
        ->select(
            'leave_allocations.*',
            'users.line_manager',
            'users.department_id',
            'users.branch_id',
        )
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'CEO' || $RolePermission == 'BOD'){
                $query->where("users.id", Auth::user()->id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            }else if ($RolePermission == 'BM') {
                $query->where("users.id", Auth::user()->line_manager);
                $query->orWhere("users.branch_id", Auth::user()->branch_id);
            }else if($RolePermission == 'HOD'){
                if (Auth::user()->id == Auth::user()->department->direct_manager_id) {
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->whereNot("users.id", Auth::user()->id);
                }else{
                    $query->where("users.id", Auth::user()->id);
                    $query->orWhere("users.line_manager", Auth::user()->id);
                }
            }else if($RolePermission == 'Employee'){
                $query->where("users.id", Auth::user()->line_manager);
                $query->orWhere("users.line_manager", Auth::user()->line_manager);
            }
        })->get();

        $dataLeaveRequest = LeaveRequest::with("employee")->with("handover")->whereIn("status", ["approved_lm","approved_hod","pending"])
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if($RolePermission == 'CEO' || $RolePermission == 'BOD' || $RolePermission == 'BM' || $RolePermission == 'HOD'){
                    $query->where("next_approver", Auth::user()->id);
                }else if($RolePermission == 'HR'){
                    $query->whereNot("status", "approved");
                }
            })->orderBy('id', 'DESC')->get();
        $requestCancels = LeaveRequest::with("employee")->with("handover")
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if($RolePermission == 'HR'){
                    $query->where("status", "cancel_hod");
                }
            })->orderBy('id', 'DESC')->get();
        return view('leaves_admin.index', compact('location', 'department', 'LeaveAllocation', 'dataLeaveRequest', 'requestCancels'));
    }

    public function detail(Request $request) {
        $leave_requests = LeaveRequest::with("leaveType")->with("employee")->where("employee_id", $request->employee_id)->get();
        return view('leaves_admin.leave_detail', compact('leave_requests'));
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

    public function filter(Request $request)
    {
        if ($request->condiction_tab == 3) {
            $LeaveAllocation = LeaveAllocation::with("employee")
            ->leftJoin('users', 'leave_allocations.employee_id', '=', 'users.id')
            ->select(
                'leave_allocations.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.department_id',
                'users.branch_id',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($request->department_id, function ($query, $department) {
                $query->where('users.department_id', $department);
            })
            ->when($request->branch_id, function ($query, $branch) {
                $query->where('users.branch_id', $branch);
            })->orderBy('id', 'DESC')->get();
            return response()->json([
                'LeaveAllocations'=>$LeaveAllocation,
            ]);
        }else{
            $dataLeaveRequest = LeaveRequest::with("employee")->with("leaveType")->with("handover")
            ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
            ->select(
                'leave_requests.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.profile',
            )
            ->when($request->condiction_tab, function ($query, $condiction_tab) {
                if ($condiction_tab == 1) {
                    $query->whereIn("leave_requests.status", ["approved_lm","approved_hod","pending"]);
                }else{
                    $query->where('leave_requests.status', 'cancel_hod');
                }
            })
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })->orderBy('id', 'DESC')->get();
            return response()->json([
                'success'=>$dataLeaveRequest,
            ]);
        }
        
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
                    }
                }
            }else{
                $data['default_annual_leave'] = 18;
                $data['default_sick_leave'] = 10;
                $data['default_special_leave'] = 22;
                $data['default_unpaid_leave'] = 0;
                $data['total_annual_leave'] = 18;
                $data['total_sick_leave'] = 10;
                $data['total_special_leave'] = 22;
                $data['total_unpaid_leave'] = 0;
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
    public function approve(Request $request) {
        try {
            $data = LeaveRequest::find($request->id);
            $role = Auth::user()->RolePermission;
            if($role == "HOD" || $role == "CEO" || $role == 'BOD'){
                $department = Auth::user()->department;
                if (Auth::user()->id == $department->direct_manager_id || $role == "CEO" || $role == 'BOD'){
                    $data['next_approver'] = "Null";
                    $data['status'] = "approved_hod";
                }else{
                    $data['next_approver'] = $department->direct_manager_id;
                    $data['status'] = "approved_lm";
                }
            }else if ($role == 'BM') {
                $branch = Auth::user()->branch;
                if ($branch->direct_manager_id == Auth::user()->id ) {
                    $data['next_approver'] = "Null";
                    $data['status'] = "approved_hod";
                }else{
                    $data['next_approver'] = $branch->direct_manager_id;
                    $data['status'] = "approved_lm";
                }
            }else if($role == 'HR') {
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
    public function reject(Request $request) {
        try {
            $data = LeaveRequest::with("leaveType")->find($request->id);
            $LeaveAllocation = LeaveAllocation::where("employee_id", $data->employee_id)->first();
            if ($data->leaveType->type == "annual_leave") {
                $current_annual_leave = $LeaveAllocation->total_annual_leave + $data->number_of_day;
                $LeaveAllocation->total_annual_leave =  $current_annual_leave > $LeaveAllocation->default_annual_leave ? $LeaveAllocation->default_annual_leave : $current_annual_leave;
            }else if($data->leaveType->type == "sick_leave"){
                $current_sick_leave = $LeaveAllocation->total_sick_leave + $data->number_of_day;
                $LeaveAllocation->total_sick_leave = $current_sick_leave > $LeaveAllocation->default_sick_leave ? $LeaveAllocation->default_sick_leave : $current_sick_leave;
            }else if($data->leaveType->type == "special_leave") {
                $current_special_leave = $LeaveAllocation->total_special_leave + $data->number_of_day;
                $LeaveAllocation->total_special_leave = $current_special_leave > $LeaveAllocation->default_special_leave ? $LeaveAllocation->default_special_leave : $current_special_leave;
            }else if($data->leaveType->type == "unpaid_leave"){
                $current_unpaid_leave = $LeaveAllocation->total_unpaid_leave + $data->number_of_day;
                $LeaveAllocation->total_unpaid_leave = $current_unpaid_leave > $LeaveAllocation->default_unpaid_leave ? $LeaveAllocation->default_unpaid_leave : $current_unpaid_leave;
            }
            $role = Auth::user()->RolePermission;
            $department = Auth::user()->department;
            if($role == "HOD" || $role == "CEO" || $role == 'BOD'){
                if (Auth::user()->id == $department->direct_manager_id || $role == "CEO" || $role == 'BOD') {
                    $data['status'] = $request->status == "cancel_hod" ? "cancel_hod" : "rejected_hod" ;
                }else{
                    $data['status'] = "rejected_lm";
                }
            }else if ($role == 'BM') {
                $branch = Auth::user()->branch;
                if ($branch->direct_manager_id == Auth::user()->id ) {
                    $data['status'] = $request->status == "cancel_hod" ? "cancel_hod" : "rejected_hod" ;
                }else{
                    $data['status'] = "rejected_lm";
                }
            }else if($role == 'HR') {
                $data['status'] = $request->status == "cancel" ? "cancel" : "rejected" ;
            }
            
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

    public function GenerateLeave(){
        $data = LeaveAllocation::all();
        $AnnualLeave = LeaveType::where('type','annual_leave')->first();
        $SickLeave = LeaveType::where('type','sick_leave')->first();
        $SpecialLeave = LeaveType::where('type','special_leave')->first();
        return view('leaves_admin.generat_leave',compact('AnnualLeave','SickLeave','SpecialLeave','data'));
    }
    public function CreateGenerateLeave(Request $request){
        try {
            $employee = User::whereIn('emp_status',['1','10','2'])->get();
            if ($employee) {
                foreach ($employee as $item) {
                    $dbDate = Carbon::parse($item->date_of_commencement);
                    $diffYears = 3;
                    // $diffYears = Carbon::now()->diffInYears($dbDate);
                    $data = LeaveAllocation::where('employee_id',$item->id)->first();
                    $remainingDay = $data->total_annual_leave;
                    $defaultDays = $request->annual_leave;
                    $sick_leave = $request->sick_leave;
                    $special_leave = $request->special_leave;
                    
                    if ($diffYears == 1) {
                        $defaultDays = $remainingDay;
                        $sick_leave = $sick_leave;
                        $special_leave = $special_leave;
                        $remain_year_1 = 0;
                        $remain_year_2 = 0;
                        $remain_year_3 = 0;
                    }elseif($diffYears == 2){
                        if ($remainingDay >= 6) {
                            $remianDay = 6;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $remianDay;
                        $remain_year_2 = 0;
                        $remain_year_3 = 0;
                        $totalDays = $defaultDays;
                    }elseif($diffYears == 3){
                        if ($remainingDay >= 6) {
                            $remianDay = 6;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $data->year_1;
                        $remain_year_2 = $remianDay;
                        $remain_year_3 = 0;
                        $totalDays = $defaultDays;
                    }elseif($diffYears == 4){
                        if ($remainingDay >= 6) {
                            $remianDay = 6;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $data->year_1;
                        $remain_year_2 = $data->year_2;
                        $remain_year_3 = $remianDay;
                        $totalDays = $defaultDays + 1;
                    } elseif($diffYears == 5) {
                        if ($remainingDay >= 7) {
                            $remianDay = 7;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $remianDay;
                        $remain_year_2 = $data->year_2;
                        $remain_year_3 = $data->year_3;
                        $totalDays = $defaultDays + 1;
                    }elseif($diffYears == 6){
                        if ($remainingDay >= 7) {
                            $remianDay = 7;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $data->year_1;
                        $remain_year_2 = $remianDay;
                        $remain_year_3 = $data->year_3;
                        $totalDays = $defaultDays + 1;
                    }elseif($diffYears == 7){
                        if ($remainingDay >= 8) {
                            $remianDay = 8;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $data->year_1;
                        $remain_year_2 = $data->year_3;
                        $remain_year_3 = $remianDay;
                        $totalDays = $defaultDays + 2;
                    }elseif($diffYears == 8){
                        if ($remainingDay >= 8) {
                            $remianDay = 8;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $remianDay;
                        $remain_year_2 = $data->year_2;
                        $remain_year_3 = $data->year_3;
                        $totalDays = $defaultDays + 2;
                    }elseif($diffYears == 9){
                        if ($remainingDay >= 8) {
                            $remianDay = 8;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $data->year_1;
                        $remain_year_2 = $remianDay;
                        $remain_year_3 = $data->year_3;
                        $totalDays = $defaultDays + 2;
                    }else{
                        if ($remainingDay >= 10) {
                            $remianDay = 9;
                        } else {
                            $remianDay = $remainingDay;
                        }
                        $remain_year_1 = $remianDay;
                        $remain_year_2 = 0;
                        $remain_year_3 = 0;
                        $totalDays = $defaultDays + 3;
                    }
                    // dd($remianDay);
                    // dd($diffYears);
                    LeaveAllocation::where('employee_id',$item->id)->update([
                        'default_annual_leave'  => $totalDays,
                        'default_sick_leave'  => $sick_leave,
                        'default_special_leave'  => $special_leave,
                        'default_unpaid_leave'  => 0,
                        'total_annual_leave'  => $totalDays,
                        'total_sick_leave'  => $sick_leave,
                        'total_special_leave'  => $special_leave,
                        'total_unpaid_leave'  => 0,
                        'year_1'  => $remain_year_1,
                        'year_2'  => $remain_year_2,
                        'year_3'  => $remain_year_3,
                    ]);
                }
            }
            Toastr::success('The process has been successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }

    public function Report(Request $request) {
       
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
}
