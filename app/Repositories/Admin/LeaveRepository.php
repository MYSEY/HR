<?php

namespace App\Repositories\Admin;

use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveRepository extends BaseRepository
{
    use UploadFIle;
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return LeaveAllocation::class;
    }

    public function getDatas($request){
        $currentYear = null;
        if ($request->monthly == true) {
            $currentYear =  Carbon::createFromDate(Carbon::now())->format('Y');
        }
        $employeeData = LeaveRequest::leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
        ->select(
            'leave_requests.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.department_id',
            'users.branch_id',
            'users.line_manager',
        )
        ->whereIn("leave_requests.status", ["approved", "approved_hod"])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'Employee'){
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BM'])){
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
            if (in_array($RolePermission, ['HR'])){
                if(permissionAccess("m10-s3","is_access")->value == "1"){
                    $query->whereIn("leave_requests.status", ["approved", "approved_hod"]);
                }else{
                    $query->where("users.line_manager", Auth::user()->id);
                }
            }
            if (in_array($RolePermission, ['DHOD','DBM'])){
                $query->where("users.line_manager", Auth::user()->id);
            }
            if (in_array($RolePermission, ['HOD'])){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            }
        }) 

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
        })->get();
        $employee_ids = [];
        foreach ($employeeData as $key => $value) {
           $employee_ids [] = $value->employee_id;
        }
        $LeaveAllocation = LeaveAllocation::with("employee")->whereIn("employee_id", $employee_ids)->orderBy('id', 'DESC')->get();
        return $LeaveAllocation;
    }

    public function getLeaveAllocation($request){
        $LeaveAllocation = LeaveAllocation::with("employee")->with("createdBy")
        ->leftJoin('users', 'leave_allocations.employee_id', '=', 'users.id')
        ->select(
            'leave_allocations.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.department_id',
            'users.branch_id',
            'users.line_manager',
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
                    $query->where("users.id", Auth::user()->id);
                    $query->orWhere("users.department_id", Auth::user()->department_id);
                    
                }else{
                    $query->where("users.id", Auth::user()->id);
                    $query->orWhere("users.line_manager", Auth::user()->id);
                }
            }else if ($RolePermission == 'HR' && permissionAccess("m10-s1","is_access")->value != "1") {
                $query->where("users.id", Auth::user()->id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            }else if($RolePermission == 'DHOD' || $RolePermission == 'DBM'){
                $query->where("users.id", Auth::user()->id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            }else if($RolePermission == 'Employee'){
                if(permissionAccess("m10-s1","is_access")->value == "1"){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }else{
                    $query->where("users.id", Auth::user()->line_manager);
                }
            }
        })
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
        return $LeaveAllocation;
    }
     public function getLeaveReports($request){
        $sumByEmployee = LeaveRequest::with(["employee", "handover", "createdBy", "leaveType","LeaveAllocation"])
                ->whereIn("leave_requests.status", ["approved_lm","approved_hod","pending","approved"])
                ->leftJoin('users', 'leave_requests.employee_id', '=', 'users.id')
                ->select(
                    'leave_requests.*',
                    'users.number_employee',
                    'users.employee_name_en',
                    'users.employee_name_kh',
                    'users.department_id',
                    'users.branch_id',
                    'users.line_manager',
                    DB::raw("SUM(CASE WHEN leave_type_id = 1 THEN number_of_day ELSE 0 END) AS total_number_al"),
                    DB::raw("SUM(CASE WHEN leave_type_id = 2 THEN number_of_day ELSE 0 END) AS total_number_sl"),
                    DB::raw("SUM(CASE WHEN leave_type_id = 3 THEN number_of_day ELSE 0 END) AS total_number_sp"),
                    DB::raw("SUM(CASE WHEN leave_type_id = 4 THEN number_of_day ELSE 0 END) AS total_number_ul")
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
                            $query->where("users.id", Auth::user()->id);
                            $query->orWhere("users.department_id", Auth::user()->department_id);
                            
                        }else{
                            $query->where("users.id", Auth::user()->id);
                            $query->orWhere("users.line_manager", Auth::user()->id);
                        }
                    }else if ($RolePermission == 'HR' && permissionAccess("m10-s1","is_access")->value != "1") {
                        $query->where("users.id", Auth::user()->id);
                        $query->orWhere("users.line_manager", Auth::user()->id);
                    }else if($RolePermission == 'DHOD' || $RolePermission == 'DBM'){
                        $query->where("users.id", Auth::user()->id);
                        $query->orWhere("users.line_manager", Auth::user()->id);
                    }else if($RolePermission == 'Employee'){
                        if(permissionAccess("m10-s1","is_access")->value == "1"){
                            $query->where("users.department_id", Auth::user()->department_id);
                            $query->where("users.branch_id", Auth::user()->branch_id);
                        }else{
                            $query->where("users.id", Auth::user()->line_manager);
                        }
                    }
                }) 
            ->when(
                !$request->start_date && !$request->end_date,
                function ($query) {
                    $query->whereYear('leave_requests.start_date', now()->year);
                }
            )
            ->when($request->start_date, function ($query, $start_date) {
                $query->where('leave_requests.start_date', '>=', $start_date);
            })
            ->when($request->end_date, function ($query, $end_date) {
                $query->where('leave_requests.end_date', '<=', $end_date);
            })
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
            })
            ->groupBy('employee_id')->get();
        return $sumByEmployee;
    }
}