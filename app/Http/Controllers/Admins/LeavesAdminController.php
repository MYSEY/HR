<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use App\Repositories\Admin\EmployeeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeavesAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataLeaveType = LeaveType::get();
        $LeaveAllocation = LeaveAllocation::get();
        $employees = User::where("emp_status", "1")->get();
        $dataLeaveRequest = LeaveRequest::with("employee")
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'BM' || $RolePermission == "HOD") {
                $query->where("request_to", Auth::user()->id);
            }
        })->get();
        $dataApprove = LeaveRequest::
        when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'BM' || $RolePermission == "HOD") {
                $query->where("request_to", Auth::user()->id);
                $query->where("status", "approved_lm");
            }else{
                $query->where("status", "approved");
            }
        })
        ->count();
        $dataReject = LeaveRequest::
        when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'BM' || $RolePermission == "HOD") {
                $query->where("request_to", Auth::user()->id);
                $query->where("status", "rejected_lm");
            }else{
                $query->where("status", "rejected");
            }
        })
        ->count();
        $dataPending = LeaveRequest::where("status", "pending")
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'BM' || $RolePermission == "HOD") {
                $query->where("request_to", Auth::user()->id);
            }
        })
        ->count();
        return view('leaves_admin.index', compact('employees', 'dataLeaveType', 'LeaveAllocation', 'dataLeaveRequest', 'dataApprove', 'dataReject', 'dataPending'));
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
        $dataLeaveRequest = LeaveRequest::with("employee")->with("leaveType")
        ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
        ->select(
            'leave_requests.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.profile',
        )
        ->when($request->leave_type_id, function ($query, $leave_type_id) {
            $query->where('leave_type_id', $leave_type_id);
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })

        ->when($request->start_date, function ($query, $start_date) {
            $query->where('start_date', '>=', $start_date);
        })
        ->when($request->end_date, function ($query, $end_date) {
            $query->where('end_date','<=', $end_date);
        })
        ->get();
        return response()->json([
            'success'=>$dataLeaveRequest,
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
            $yearLy = Carbon::now()->format('Y');
            $fromDate = $yearLy."-12-31";
            $months = $toDate->diffInMonths($fromDate);
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
            if ($role == 'BM' || $role == "HOD") {
                $data['status'] = "approved_lm";
            }else{
                $data['status'] = $request->status;
            }
            $data['handover_staff_id']=$request->handover_staff_id;
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
            if ($role == 'BM' || $role == "HOD") {
                $data['status'] = "rejected_lm";
            }else{
                $data['status'] = $request->status;
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
}
