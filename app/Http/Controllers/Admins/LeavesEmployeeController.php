<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportLeaveEmployee;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\Branchs;
use App\Models\DelegateLeave;
use App\Models\Department;
use App\Models\LeaveAllocation;
use App\Models\LeaveAllocationHistory;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\mail as ModelsMail;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Admin\EmployeeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\CarbonPeriod;

class LeavesEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (permissionAccess("m10-s2","is_view")->value != "1") {
            return view('upgrade.access_page');
        }

        $dataLeaveType = LeaveType::get();
        $LeaveAllocation = LeaveAllocation::where("employee_id", Auth::user()->id)->first();
        // ទាញទិន្នន័យប្រវត្តិឆ្នាំចាស់ៗ
        $allocationHistory = DB::table('leave_allocation_histories')
            ->where('employee_id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->get();
        $balances = [];
        if ($LeaveAllocation) {
            $current_year = date('Y', strtotime($LeaveAllocation->created_at));
            $balances[$current_year] = [
                $LeaveAllocation
            ];
        }
        // Loop បញ្ចូល History ដោយទាញឆ្នាំពី created_at
        foreach ($allocationHistory as $history) {
            $year = date('Y', strtotime($history->created_at)); 
            $balances[$year] = [
                $history
            ];
        }

        $employees= DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->select( 'users.*', 'roles.role_type',)
        ->whereIn('users.emp_status', ['Probation','1','2','10',])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'Employee'){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BM','DBM'])){
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['HR','HRAdmin','DHOD','HOD'])){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->orWhere("users.line_manager", Auth::user()->id);
                $query->whereNot("users.id", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BOD','CEO'])){
                $query->whereNot("users.id", Auth::user()->id);
                $query->whereNot("roles.role_type", "Employee");
            }
            })->get();
        $delegateEmployees= DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select( 'users.*', 'roles.role_type',)
            ->whereIn('users.emp_status', ['Probation','1','2','10',])
            ->whereNot("roles.role_type", "Employee")
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if (in_array($RolePermission, ['BM','DBM'])){
                    $query->where("users.branch_id", Auth::user()->branch_id);
                    $query->whereNot("users.id", Auth::user()->id);
                }else if (in_array($RolePermission, ['HR','DHOD', 'HRAdmin', 'HOD'])){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->where("users.branch_id", Auth::user()->branch_id);
                    $query->orWhere("users.line_manager", Auth::user()->id);
                    $query->whereNot("users.id", Auth::user()->id);
                }else if($RolePermission == 'Employee'){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->where("users.branch_id", Auth::user()->branch_id);
                    $query->whereNot("users.id", Auth::user()->id);
                }
                if (in_array($RolePermission, ['BOD','CEO'])){
                    $query->whereNot("users.id", Auth::user()->id);
                    $query->whereNot("roles.role_type", "Employee");
                }
            })->get();
        $dataLeaveRequest = LeaveRequest::with("leaveType")->where("employee_id", Auth::user()->id)
        // ->whereYear('start_date', now()->year) get data by current year
        ->orderByRaw('YEAR(start_date) DESC')  // Group by Year first
        // ->orderByRaw('MONTH(start_date) DESC') // Then by Month
        ->orderBy('id', 'asc')                // Finally by ID for specific order
        ->get();
        return view('leaves_employee.index', compact('dataLeaveType', 'balances', 'LeaveAllocation', 'employees','delegateEmployees', 'dataLeaveRequest'));
    }

    public function indexReplcement(){
        if (permissionAccess("m10-s4","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $dataLeaveType = LeaveType::get();
        $employees= DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->select( 'users.*', 'roles.role_type',)
        // ->whereIn('users.emp_status', ['Probation','1','2','10',])
        // ->whereNot("roles.role_type", "Employee")
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if (in_array($RolePermission, ['BM','DBM'])){
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
            if($RolePermission == 'Employee'){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
            }
            if (in_array($RolePermission, ['HR','DHOD', 'HRAdmin', 'HOD'])){
                $query->where("users.department_id", Auth::user()->department_id);
                $query->where("users.branch_id", Auth::user()->branch_id);
                $query->orWhere("users.line_manager", Auth::user()->id);
            }
            if (in_array($RolePermission, ['BOD','CEO'])){
                $query->whereNot("users.id", Auth::user()->id);
                $query->whereNot("roles.role_type", "Employee");
            }
        })->get();
        $delegateEmployees= DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select( 'users.*', 'roles.role_type',)
            ->whereIn('users.emp_status', ['Probation','1','2','10',])
            ->whereNot("roles.role_type", "Employee")
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if (in_array($RolePermission, ['BM','DBM'])){
                    $query->where("users.branch_id", Auth::user()->branch_id);
                    // $query->whereNot("users.id", Auth::user()->id);
                }else if (in_array($RolePermission, ['HR','DHOD', 'HRAdmin', 'HOD'])){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->where("users.branch_id", Auth::user()->branch_id);
                    $query->orWhere("users.line_manager", Auth::user()->id);
                }else if($RolePermission == 'Employee'){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->where("users.branch_id", Auth::user()->branch_id);
                    // $query->whereNot("users.id", Auth::user()->id);
                }
                if (in_array($RolePermission, ['BOD','CEO'])){
                    $query->whereNot("users.id", Auth::user()->id);
                    $query->whereNot("roles.role_type", "Employee");
                }
            })->get();
        $dataLeaveRequest = LeaveRequest::with("leaveType")->with("employee")->with("LeaveAllocation")->where("request_to", Auth::user()->id)->get();
        return view('leaves_employee.leave_replacement', compact('dataLeaveType', 'employees','delegateEmployees', 'dataLeaveRequest'));
    }


    function duplicateLeace($request, $employee_id)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $startHalfDay = $request->start_half_day;
        $endHalfDay = $request->end_half_day;
        $overlappingLeave = null;

        $overlappingLeave  = LeaveRequest::where('employee_id', $employee_id)
        ->whereIn("status", ["approved_lm","approved_hod", "pending"])
        ->where(function ($query) use ($startDate, $endDate, $startHalfDay, $endHalfDay) {
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<', $endDate)
                    ->where('end_date', '>', $startDate);
            })
            ->orWhere(function ($query) use ($startDate, $endDate, $startHalfDay, $endHalfDay) {
                // Overlap considering half days
                $query->where('start_date', '=', $startDate)
                    ->where('end_date', '=', $endDate)
                    ->where(function ($query) use ($startHalfDay, $endHalfDay) {
                        $query->where(function ($query) use ($startHalfDay) {
                            $query->where('start_half_day', $startHalfDay)
                                ->where('end_half_day', false);
                        })
                        ->orWhere(function ($query) use ($startHalfDay, $endHalfDay) {
                            $query->where('start_half_day', false)
                                ->where('end_half_day', $endHalfDay);
                        })
                        ->orWhere(function ($query) use ($startHalfDay, $endHalfDay) {
                            $query->where('start_half_day', $startHalfDay)
                                ->where('end_half_day', $endHalfDay);
                        });
                    });
            });
        })->exists();
        if (!$overlappingLeave) {
            if (!$startHalfDay && !$endHalfDay) {
                $overlappingLeave = LeaveRequest::where('employee_id', $employee_id)
                ->whereIn("status", ["approved_lm","approved_hod", "pending"])
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate);
                })->exists();
            }
            if (($startHalfDay == "am"|| $startHalfDay == "pm") || ($endHalfDay == "am" || $endHalfDay == "pm")) {
                if ($startHalfDay == "am"|| $startHalfDay == "pm") {
                    $overlappingLeave1 = LeaveRequest::where('employee_id', $employee_id)
                    ->whereIn("status", ["approved_lm","approved_hod", "pending"])
                    ->where(function ($query) use ($startDate, $startHalfDay) {
                        $query->where('start_date', '=', $startDate)
                        ->where('start_half_day', '=', $startHalfDay);
                    })->exists();
                    if ($overlappingLeave1) {
                        return true;
                        // return response()->json([
                        //     'error'=>'lang.start_date_and_end_date_already_exists',
                        //     'status'=>404,
                        // ]);
                    }  
                } 
                if ($endHalfDay == "am" || $endHalfDay == "pm") {
                    $overlappingLeave2 = LeaveRequest::where('employee_id', $employee_id)
                    ->whereIn("status", ["approved_lm","approved_hod", "pending"])
                    ->where(function ($query) use ($endDate, $endHalfDay) {
                        $query->where('end_date', '=', $endDate)
                        ->where('end_half_day', '=', $endHalfDay);
                    })->exists();
                    if ($overlappingLeave2) {
                        return true;
                        // return response()->json([
                        //     'error'=>'lang.start_date_and_end_date_already_exists',
                        //     'status'=>404,
                        // ]);
                    }  
                }
                $dataLeaves = LeaveRequest::where('employee_id', $employee_id)
                ->whereIn("status", ["approved_lm","approved_hod", "pending"])
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $startDate)
                    ->where('end_date', '>=', $endDate);
                })->first();
                if ($dataLeaves) {
                    if (!$dataLeaves->start_half_day && !$dataLeaves->end_half_day) {
                        return true;
                        // return response()->json([
                        //     'error'=>'lang.start_date_and_end_date_already_exists',
                        //     'status'=>404,
                        // ]);
                    }
                }
            }
        }
        
        if ($overlappingLeave) {
            return true;
            // return response()->json([
            //     'error'=>'lang.start_date_and_end_date_already_exists',
            //     'status'=>404,
            // ]);
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
        }
        return $total_number_of_day;
    }
    public static function LeaveAllocation($request, $LeaveType , $uesr_id){
        $current_year = Carbon::now()->format('Y');
        $current_start_date = Carbon::createFromDate($request->start_date)->format('Y');
        $LeaveAllocation = LeaveAllocation::where("employee_id", $uesr_id)->first();
        if ($current_start_date == $current_year) {
            //** caculate leave for end date new year */
            $total_number_of_day = self::totalRequestLeaveDay($request);
            //** end */
            if ($LeaveAllocation == null) {
                LeaveAllocation::create([
                    'employee_id'  => $uesr_id,
                    'default_annual_leave'  => 0,
                    'default_sick_leave'  => 0,
                    'default_special_leave'  => 0,
                    'default_unpaid_leave'  => 0,
                    'total_annual_leave'    => $LeaveType->type == "annual_leave" ? $LeaveAllocation['total_annual_leave'] = 0 - $total_number_of_day : 0,
                    'total_sick_leave'  => $LeaveType->type == "sick_leave" ? $LeaveAllocation['total_sick_leave'] = 0 - $total_number_of_day : 0,
                    'total_special_leave'  => $LeaveType->type == "special_leave" ? $LeaveAllocation['total_special_leave'] = 0 - $total_number_of_day : 0,
                    'total_unpaid_leave'  => 0,
                    'created_by'  => $uesr_id,
                ]);
                return null;
            }else{
                $LeaveAllocation["total_annual_leave"] = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $total_number_of_day : $LeaveAllocation->total_annual_leave;
                $LeaveAllocation["total_sick_leave"] = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $total_number_of_day : $LeaveAllocation->total_sick_leave;
                $LeaveAllocation["total_special_leave"] = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $total_number_of_day : $LeaveAllocation->total_special_leave;
                $LeaveAllocation["total_unpaid_leave"] = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $total_number_of_day : $LeaveAllocation->total_unpaid_leave;
                $LeaveAllocation["total_long_sick_leave"] = $LeaveType->type == "long_sick_leave" ? $LeaveAllocation->total_long_sick_leave - $total_number_of_day : $LeaveAllocation->total_long_sick_leave;
                $LeaveAllocation->save();
                return [
                    "total_annual_leave"        => $LeaveAllocation->total_annual_leave,
                    "total_sick_leave"          => $LeaveAllocation->total_sick_leave,
                    "total_special_leave"       => $LeaveAllocation->total_special_leave,
                    "total_unpaid_leave"        => $LeaveAllocation->total_unpaid_leave,
                    "total_long_sick_leave"     => $LeaveAllocation->total_long_sick_leave
                ];
            }
        }
        if($current_start_date < $current_year){
            $dataAllocationHistores = LeaveAllocationHistory::where("employee_id", $uesr_id)->whereYear("created_at",$current_start_date)->first();
            if ($dataAllocationHistores == null) {
                if ($LeaveAllocation == null) {
                    LeaveAllocation::create([
                        'employee_id'  => $uesr_id,
                        'default_annual_leave'  => 0,
                        'default_sick_leave'  => 0,
                        'default_special_leave'  => 0,
                        'default_unpaid_leave'  => 0,
                        'total_annual_leave'    => $LeaveType->type == "annual_leave" ? $LeaveAllocation['total_annual_leave'] = 0 - $request->number_of_day : 0,
                        'total_sick_leave'  => $LeaveType->type == "sick_leave" ? $LeaveAllocation['total_sick_leave'] = 0 - $request->number_of_day : 0,
                        'total_special_leave'  => $LeaveType->type == "special_leave" ? $LeaveAllocation['total_special_leave'] = 0 - $request->number_of_day : 0,
                        'total_unpaid_leave'  => 0,
                        'created_by'  => $uesr_id,
                    ]);
                   return null;
                }else{
                    $LeaveAllocation["total_annual_leave"] = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $request->number_of_day : $LeaveAllocation->total_annual_leave;
                    $LeaveAllocation["total_sick_leave"] = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $request->number_of_day : $LeaveAllocation->total_sick_leave;
                    $LeaveAllocation["total_special_leave"] = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $request->number_of_day : $LeaveAllocation->total_special_leave;
                    $LeaveAllocation["total_unpaid_leave"] = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $request->number_of_day : $LeaveAllocation->total_unpaid_leave;
                    $LeaveAllocation["total_long_sick_leave"] = $LeaveType->type == "long_sick_leave" ? $LeaveAllocation->total_long_sick_leave - $request->number_of_day : $LeaveAllocation->total_long_sick_leave;
                    $LeaveAllocation->save();
                    return [
                        "total_annual_leave"        => $LeaveAllocation->total_annual_leave,
                        "total_sick_leave"          => $LeaveAllocation->total_sick_leave,
                        "total_special_leave"       => $LeaveAllocation->total_special_leave,
                        "total_unpaid_leave"        => $LeaveAllocation->total_unpaid_leave,
                        "total_long_sick_leave"     => $LeaveAllocation->total_long_sick_leave
                    ];
                }
            }else{
                $dataAllocationHistores["total_annual_leave"] = $LeaveType->type == "annual_leave" ? $dataAllocationHistores->total_annual_leave - $request->number_of_day : $dataAllocationHistores->total_annual_leave;
                $dataAllocationHistores["total_sick_leave"] = $LeaveType->type == "sick_leave" ? $dataAllocationHistores->total_sick_leave - $request->number_of_day : $dataAllocationHistores->total_sick_leave;
                $dataAllocationHistores["total_special_leave"] = $LeaveType->type == "special_leave" ? $dataAllocationHistores->total_special_leave - $request->number_of_day : $dataAllocationHistores->total_special_leave;
                $dataAllocationHistores["total_unpaid_leave"] = $LeaveType->type == "unpaid_leave" ? $dataAllocationHistores->total_unpaid_leave - $request->number_of_day : $dataAllocationHistores->total_unpaid_leave;
                $dataAllocationHistores["total_long_sick_leave"] = $LeaveType->type == "long_sick_leave" ? $dataAllocationHistores->total_long_sick_leave - $request->number_of_day : $dataAllocationHistores->total_long_sick_leave;
                $dataAllocationHistores->save();
                return null;
            }
        }
    }
    public static function updateLeaveAllocation($request, $data, $LeaveType , $uesr_id){
        $current_year = Carbon::now()->format('Y');
        $current_start_date = Carbon::createFromDate($request->start_date)->format('Y');
        $total_number_of_day = $request->number_of_day;
        if ($current_start_date == $current_year) {
            //** caculate leave for end date new year */
            $total_number_of_day = self::totalRequestLeaveDay($request);
            //** end */
        }
        $LeaveAllocation = LeaveAllocation::where("employee_id", $uesr_id)->first();
        if ($LeaveType->type == $data->leaveType->type) {
            $data_number_of_day = self::totalRequestLeaveDay($data);
            $number_day = 0;
            if ( $total_number_of_day > $data_number_of_day) {
                $number_day = $data_number_of_day - $total_number_of_day;
            }else if ( $total_number_of_day < $data_number_of_day) {
                $number_day = $data_number_of_day - $total_number_of_day;
            }
            $LeaveAllocation->total_annual_leave += $LeaveType->type == "annual_leave" ? $number_day : 0;
            $LeaveAllocation->total_sick_leave += $LeaveType->type == "sick_leave" ? $number_day : 0;
            $LeaveAllocation->total_special_leave += $LeaveType->type == "special_leave" ? $number_day : 0;
            $LeaveAllocation->total_unpaid_leave += $LeaveType->type == "unpaid_leave" ? $number_day : 0;
            $LeaveAllocation->total_long_sick_leave += $LeaveType->type == "long_sick_leave" ? $number_day : 0;
            $LeaveAllocation->save();
            return [
                "total_annual_leave"        => $LeaveAllocation->total_annual_leave,
                "total_sick_leave"          => $LeaveAllocation->total_sick_leave,
                "total_special_leave"       => $LeaveAllocation->total_special_leave,
                "total_unpaid_leave"        => $LeaveAllocation->total_unpaid_leave,
                "total_long_sick_leave"     => $LeaveAllocation->total_long_sick_leave
            ];
            
        }else{
            // When modifying the Status, sum the number of day to old status.
            if ($data->leaveType->type == "annual_leave") {
                $current_annual_leave = $LeaveAllocation->total_annual_leave + $total_number_of_day;
                $LeaveAllocation->total_annual_leave =  $current_annual_leave > $LeaveAllocation->default_annual_leave ? $LeaveAllocation->default_annual_leave : $current_annual_leave;
            }else if($data->leaveType->type == "sick_leave"){
                $current_sick_leave = $LeaveAllocation->total_sick_leave + $total_number_of_day;
                $LeaveAllocation->total_sick_leave = $current_sick_leave > $LeaveAllocation->default_sick_leave ? $LeaveAllocation->default_sick_leave : $current_sick_leave;
            }else if($data->leaveType->type == "special_leave") {
                $current_special_leave = $LeaveAllocation->total_special_leave + $total_number_of_day;
                $LeaveAllocation->total_special_leave = $current_special_leave > $LeaveAllocation->default_special_leave ? $LeaveAllocation->default_special_leave : $current_special_leave;
            }else if($data->leaveType->type == "unpaid_leave"){
                $current_unpaid_leave = $LeaveAllocation->total_unpaid_leave + $total_number_of_day;
                if ($current_unpaid_leave == 0) {
                    $LeaveAllocation->total_unpaid_leave = 0;
                }else{
                    $LeaveAllocation->total_unpaid_leave =  $current_unpaid_leave;
                }
            }else if($data->leaveType->type == "long_sick_leave"){
                $current_long_sick_leave = $LeaveAllocation->total_long_sick_leave + $total_number_of_day;
                if ($current_long_sick_leave == 0) {
                    $LeaveAllocation->total_long_sick_leave = 0;
                }else {
                    $LeaveAllocation->total_long_sick_leave = $current_long_sick_leave;
                }
            }

            // When modifying the Status, subtract the number of day from the new status.
            $LeaveAllocation->total_annual_leave = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $total_number_of_day : $LeaveAllocation->total_annual_leave;
            $LeaveAllocation->total_sick_leave = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $total_number_of_day : $LeaveAllocation->total_sick_leave;
            $LeaveAllocation->total_special_leave = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $total_number_of_day : $LeaveAllocation->total_special_leave;
            $LeaveAllocation->total_unpaid_leave = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $total_number_of_day : $LeaveAllocation->total_unpaid_leave;
            $LeaveAllocation->total_long_sick_leave = $LeaveType->type == "long_sick_leave" ? $LeaveAllocation->total_long_sick_leave - $total_number_of_day : $LeaveAllocation->total_long_sick_leave;
            
            $LeaveAllocation->save();
            return [
                "total_annual_leave"        => $LeaveAllocation->total_annual_leave,
                "total_sick_leave"          => $LeaveAllocation->total_sick_leave,
                "total_special_leave"       => $LeaveAllocation->total_special_leave,
                "total_unpaid_leave"        => $LeaveAllocation->total_unpaid_leave,
                "total_long_sick_leave"     => $LeaveAllocation->total_long_sick_leave
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $duplicate  = self::duplicateLeace($request, Auth::user()->id);
            if ($duplicate) {
                return response()->json([
                    'error'=>'lang.start_date_and_end_date_already_exists',
                    'status'=>404,
                ]);
            }
            $data = $request->all();
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();

            $data['line_manager_id'] = Auth::user()->line_manager;

            // *** approve by head or branch *** //
            // $manager = User::where("id", Auth::user()->line_manager)->first();
            $dataBranch = Branchs::where("id", Auth::user()->branch->id)->first();
            if($dataBranch->abbreviations == "HQ"){
                $data['next_approver'] = Auth::user()->department->direct_manager_id;
            }else{
                $data['next_approver'] = Auth::user()->branch->direct_manager_id;
            }
            $data['status'] = "pending";
            if(Auth::user()->RolePermission == "BOD") {
                $data['status'] = "approved_hod";
                $data['next_approver'] = "Null";
            }else if (Auth::user()->RolePermission == "CEO") {
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif (Auth::user()->RolePermission == "HOD" && Auth::user()->id == Auth::user()->department->direct_manager_id) {
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif(Auth::user()->RolePermission == "DHOD" && Auth::user()->id == Auth::user()->department->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }else if(Auth::user()->RolePermission == "BM" && Auth::user()->id == Auth::user()->branch->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif(Auth::user()->RolePermission == "DBM" && Auth::user()->id == Auth::user()->branch->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif(Auth::user()->RolePermission == "HRAdmin" && Auth::user()->id == Auth::user()->department->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }
            if(Auth::user()->under_approve){
                $data['next_approver'] = Auth::user()->under_approve;
            }

            $request_date = Carbon::now()->format('Y-m-d');
            // *** new process detegate leave *** //
            $delegateLeave = DelegateLeave::where("requester_id", $data['next_approver'])
            ->where('start_date', '<=', $request_date)
            ->where('end_date', '>=', $request_date)->first();
            
            if ($delegateLeave) {
                if(Auth::user()->id == $delegateLeave->delegate_id){
                    $line_manager_head = User::where("id", $delegateLeave->requester_id)->first();
                    $data['next_approver'] = $line_manager_head->line_manager;
                }else{
                    $data['next_approver'] = $delegateLeave->delegate_id;
                    $delegateLeave3 = LeaveRequest::where("employee_id", $delegateLeave->delegate_id)
                    ->where('start_date', '<=', $request_date)
                    ->where('end_date', '>=', $request_date)->first();
                    if ($delegateLeave3) {
                        $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                        $LineNumber2 = Helper::countWeekdays($request_date,$delegateLeave3->end_date);
                        
                        if ($LineNumber1 <= $LineNumber2) {
                            $data['next_approver'] = $delegateLeave->requester_id;
                        }else{
                            $data['next_approver'] = $delegateLeave3->employee_id;
                        }
                    }
                }
            }
            if ($request->delegate_id) {
                DelegateLeave::create(
                    [
                        "requester_id"      => Auth::user()->id,
                        "delegate_id"       => $request->delegate_id,
                        "number_of_day"     => $request->number_of_day,
                        "start_date"        => $request->start_date,
                        "end_date"          => $request->end_date,
                    ]
                );
            }
            if (empty($LeaveType->type)) {
                Toastr::error('Leave type not found','Error');
                return redirect()->back();
                DB::commit();
            }
            
            $leaveAllo = self::LeaveAllocation($request, $LeaveType , Auth::user()->id);
            if($leaveAllo){
                $data["total_annual_leave"]      = $leaveAllo["total_annual_leave"];
                $data["total_sick_leave"]        = $leaveAllo["total_sick_leave"];
                $data["total_special_leave"]     = $leaveAllo["total_special_leave"];
                $data["total_unpaid_leave"]      = $leaveAllo["total_unpaid_leave"];
                $data["total_long_sick_leave"]   = $leaveAllo["total_long_sick_leave"];
            }
            $data['employee_id'] = Auth::user()->id;
            $data['created_by'] = Auth::user()->id;            
            LeaveRequest::create($data);
            DB::commit();
            // for send email
            $manager1 = User::where("id", Auth::user()->line_manager)->first();
            $line_manager2 = User::where("id", $data['next_approver'])->first();
            $staff_request = User::where("id", Auth::user()->id)->with("position")->with("branch")->first();

            // $mail_message = ModelsMail::first();
            // if ($line_manager2 && $mail_message) {
            //     if ($line_manager2) {
            //         $datasSendEmail = [
            //             'mail_message'      => $mail_message,
            //             'staff_request'     => $staff_request,
            //             'start_date'        => $request->start_date,
            //             'end_date'          => $request->end_date,
            //             'number_of_day'     => $request->number_of_day,
            //         ];
            //         if ($manager1) {
            //             $recipients = [$manager1->email, $line_manager2->email];
            //             if ($manager1->email != $line_manager2->email) {
            //                 foreach ($recipients as $email) {
            //                     $btn_approve = false;
            //                     if($email != $manager1->email){
            //                         $btn_approve = true;
            //                     }
            //                     if($email){
            //                         // After commit, email cannot affect data saving anymore
            //                         DB::afterCommit(function () use ($email,$datasSendEmail,$btn_approve) {
            //                             try {
            //                                Mail::to($email)->queue(new SendEmail($datasSendEmail, $btn_approve));
            //                             } catch (\Exception $e) {
            //                                 Log::error("Email failed after commit: " . $e->getMessage());
            //                             }
            //                         });
            //                     }
            //                 }
            //             }else{
            //                 if($line_manager2->email){
            //                     $email = $line_manager2->email;
            //                     $btn_approve = true;
            //                     DB::afterCommit(function () use ($email,$datasSendEmail,$btn_approve) {
            //                         try {
            //                             Mail::to($email)->queue(new SendEmail($datasSendEmail, $btn_approve));
            //                         } catch (\Exception $e) {
            //                             Log::error("Email failed after commit: " . $e->getMessage());
            //                         }
            //                     });
            //                     // Mail::to($line_manager2->email)->queue(new SendEmail($datasSendEmail, true));
            //                 }
            //             }
            //         }else{
            //             if($line_manager2->email){
            //                 $email = $line_manager2->email;
            //                 $btn_approve = true;
            //                 DB::afterCommit(function () use ($email,$datasSendEmail,$btn_approve) {
            //                     try {
            //                         Mail::to($email)->queue(new SendEmail($datasSendEmail, $btn_approve));
            //                     } catch (\Exception $e) {
            //                         Log::error("Email failed after commit: " . $e->getMessage());
            //                     }
            //                 });
            //                 // Mail::to($line_manager2->email)->queue(new SendEmail($datasSendEmail,true));
            //             }
            //         }

            //     }
            // }
            return response()->json([
                'success'=>'leave_request_created_successfully',
                'status'=>200,
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Leave request created fail.','Error');
        }
    }

    public function replcementCreate(Request $request){
        DB::beginTransaction();
        try {
            $duplicate  = self::duplicateLeace($request, $request->employee_id);
            if ($duplicate) {
                return response()->json([
                    'error'=>'lang.start_date_and_end_date_already_exists',
                    'status'=>404,
                ]);
            }
            $data = $request->all();
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();
            $userRequest = User::where("id", $request->employee_id)->with("department")->with("branch")->with("role")->first();
            $data['line_manager_id'] = $userRequest->line_manager;
            if($userRequest->branch->abbreviations == "HQ"){
                $data['next_approver'] = $userRequest->department->direct_manager_id;
            }else{
               $data['next_approver'] = $userRequest->branch->direct_manager_id;
            }

            // *** approve by head or branch *** //
            if($userRequest->role->role_type == "BOD") {
                $data['status'] = "approved_hod";
                $data['next_approver'] = "Null";
            }else if ($userRequest->role->role_type == "CEO") {
                $data['next_approver'] = $userRequest->line_manager;
                $data['status'] = "approved_lm";

            }elseif ($userRequest->role->role_type == "HOD" && $request->employee_id == $userRequest->department->direct_manager_id) {
                $data['next_approver'] = $userRequest->line_manager;
                $data['status'] = "approved_lm";
            }elseif($userRequest->role->role_type == "DHOD" && $request->employee_id == $userRequest->department->direct_manager_id){
                $data['next_approver'] = $userRequest->line_manager;
                $data['status'] = "approved_lm";
            }else if($userRequest->role->role_type == "BM" && $request->employee_id == $userRequest->branch->direct_manager_id){
                $data['next_approver'] = $userRequest->department->direct_manager_id;
                $data['status'] = "approved_lm";
            }elseif($userRequest->role->role_type == "DBM" && $request->employee_id == $userRequest->branch->direct_manager_id){
                $data['next_approver'] = $userRequest->department->direct_manager_id;
                $data['status'] = "approved_lm";
            }else{
                $data['status'] = "pending";
            }
            if($userRequest->under_approve){
                $data['next_approver'] = $userRequest->under_approve;
            }

            $request_date = Carbon::now()->format('Y-m-d');
            // $request_date = "2024-09-25";
            // *** new process detegate leave *** //
            $delegateLeave = DelegateLeave::where("requester_id", $data['next_approver'])
            ->where('start_date', '<=', $request_date)
            ->where('end_date', '>=', $request_date)->first();
            if ($delegateLeave) {
                if($request->employee_id == $delegateLeave->delegate_id){
                    $line_manager_head = User::where("id", $delegateLeave->requester_id)->first();
                    $data['next_approver'] = $line_manager_head->line_manager;
                }else{
                    $data['next_approver'] = $delegateLeave->delegate_id;
                    $delegateLeave3 = LeaveRequest::where("employee_id", $delegateLeave->delegate_id)
                    ->where('start_date', '<=', $request_date)
                    ->where('end_date', '>=', $request_date)->first();
                    if ($delegateLeave3) {
                        $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                        $LineNumber2 = Helper::countWeekdays($request_date,$delegateLeave3->end_date);
                        
                        if ($LineNumber1 <= $LineNumber2) {
                            $data['next_approver'] = $delegateLeave->requester_id;
                        }else{
                            $data['next_approver'] = $delegateLeave3->employee_id;
                        }
                    }
                }
            }
            
            if ($request->delegate_id) {
                DelegateLeave::create(
                    [
                        "requester_id"      => $request->employee_id,
                        "delegate_id"       => $request->delegate_id,
                        "number_of_day"     => $request->number_of_day,
                        "start_date"        => $request->start_date,
                        "end_date"          => $request->end_date,
                    ]
                );
            }

            if (empty($LeaveType->type)) {
                Toastr::error('Leave type not found','Error');
                return redirect()->back();
                DB::commit();
            }
            $leaveAllo = self::LeaveAllocation($request, $LeaveType , $request->employee_id);
            if($leaveAllo){
                $data["total_annual_leave"]      = $leaveAllo["total_annual_leave"];
                $data["total_sick_leave"]        = $leaveAllo["total_sick_leave"];
                $data["total_special_leave"]     = $leaveAllo["total_special_leave"];
                $data["total_unpaid_leave"]      = $leaveAllo["total_unpaid_leave"];
                $data["total_long_sick_leave"]   = $leaveAllo["total_long_sick_leave"];
            }
                // if ($LeaveAllocation == null) {
                //     LeaveAllocation::create([
                //         'employee_id'  => $request->employee_id,
                //         'default_annual_leave'  => 0,
                //         'default_sick_leave'  => 0,
                //         'default_special_leave'  => 0,
                //         'default_unpaid_leave'  => 0,
                //         'total_annual_leave'    => $LeaveAllocation['total_annual_leave'] = 0 - $request->number_of_day,
                //         'total_sick_leave'  => 0,
                //         'total_special_leave'  => 0,
                //         'total_unpaid_leave'  => 0,
                //         'created_by'  => $request->employee_id,
                //     ]);
                // }else{
                //     $total_annual_leave = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $request->number_of_day : $LeaveAllocation->total_annual_leave;
                //     $total_sick_leave = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $request->number_of_day : $LeaveAllocation->total_sick_leave;
                //     $total_special_leave = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $request->number_of_day : $LeaveAllocation->total_special_leave;
                //     $total_unpaid_leave = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $request->number_of_day : $LeaveAllocation->total_unpaid_leave;
                //     $total_long_sick_leave = $LeaveType->type == "long_sick_leave" ? $LeaveAllocation->total_long_sick_leave - $request->number_of_day : $LeaveAllocation->total_long_sick_leave;
                    
                //     $LeaveAllocation["total_annual_leave"]      = $total_annual_leave;
                //     $LeaveAllocation["total_sick_leave"]        = $total_sick_leave;
                //     $LeaveAllocation["total_special_leave"]     = $total_special_leave;
                //     $LeaveAllocation["total_unpaid_leave"]      = $total_unpaid_leave;
                //     $LeaveAllocation["total_long_sick_leave"]   = $total_long_sick_leave;   
                    
                //     $data["total_annual_leave"]      = $total_annual_leave;
                //     $data["total_sick_leave"]        = $total_sick_leave;
                //     $data["total_special_leave"]     = $total_special_leave;
                //     $data["total_unpaid_leave"]      = $total_unpaid_leave;
                //     $data["total_long_sick_leave"]   = $total_long_sick_leave;   
                //     $LeaveAllocation->save();
                // }

            
            $data['employee_id'] = $request->employee_id;
            $data['created_by'] = Auth::user()->id;
            $data['request_to'] = Auth::user()->id;
            
            LeaveRequest::create($data);

            $staff_request = User::where("id", $request->employee_id)->with("position")->with("branch")->first();
            $manager1 = User::where("id", $staff_request->line_manager)->first();
            $line_manager2 = User::where("id", $data['next_approver'])->first();
            DB::commit();
            // $mail_message = ModelsMail::first();
            // if ($line_manager2 && $mail_message) {
            //     if ($line_manager2) {
            //         // $datasSendEmail['mail_message'] = $mail_message;
            //         // $datasSendEmail['staff_request'] = $staff_request;
            //         $datasSendEmail = [
            //             'mail_message'      => $mail_message,
            //             'staff_request'     => $staff_request,
            //             'start_date'        => $request->start_date,
            //             'end_date'          => $request->end_date,
            //             'number_of_day'     => $request->number_of_day,
            //         ];
            //         if ($manager1) {
            //             $recipients = [$manager1->email, $line_manager2->email];
            //             if ($manager1->email != $line_manager2->email) {
            //                 foreach ($recipients as $email) {
            //                     $btn_approve = false;
            //                     if($email != $manager1->email){
            //                         $btn_approve = true;
            //                     }
            //                     if($email){
            //                         DB::afterCommit(function () use ($email,$datasSendEmail,$btn_approve) {
            //                             try {
            //                                Mail::to($email)->queue(new SendEmail($datasSendEmail, $btn_approve));
            //                             } catch (\Exception $e) {
            //                                 Log::error("Email failed after commit: " . $e->getMessage());
            //                             }
            //                         });
            //                         // Mail::to($email)->queue(new SendEmail($datasSendEmail, $btn_approve));
            //                     }
            //                 }
            //             }else{
            //                 if($line_manager2->email){
            //                     $email = $line_manager2->email;
            //                     $btn_approve = true;
            //                     DB::afterCommit(function () use ($email,$datasSendEmail,$btn_approve) {
            //                         try {
            //                             Mail::to($email)->queue(new SendEmail($datasSendEmail, $btn_approve));
            //                         } catch (\Exception $e) {
            //                             Log::error("Email failed after commit: " . $e->getMessage());
            //                         }
            //                     });
            //                     // Mail::to($line_manager2->email)->queue(new SendEmail($datasSendEmail, true));
            //                 }
            //             }
            //         }else{
            //             if($line_manager2->email){
            //                 $email = $line_manager2->email;
            //                 $btn_approve = true;
            //                 DB::afterCommit(function () use ($email,$datasSendEmail,$btn_approve) {
            //                     try {
            //                         Mail::to($email)->queue(new SendEmail($datasSendEmail, $btn_approve));
            //                     } catch (\Exception $e) {
            //                         Log::error("Email failed after commit: " . $e->getMessage());
            //                     }
            //                 });
            //                 // Mail::to($line_manager2->email)->queue(new SendEmail($datasSendEmail,true));
            //             }
            //         }
            //     }
            // }
            return response()->json([
                'success'=>'leave_request_created_successfully',
                'status'=>200,
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Leave request created fail.','Error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $dataLeaveType = LeaveType::get();
        $hondover_staff= User::when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }else{
                $query->where("department_id", Auth::user()->department_id);
            }
        })->get();
        $data = LeaveRequest::where("id", $request->id)->first();
        return response()->json([
            'dataLeaveType'=>$dataLeaveType,
            'hondover_staff'=>$hondover_staff,
            'success'=>$data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $duplicate  = self::duplicateLeace($request, Auth::user()->id);
            if ($duplicate) {
                return response()->json([
                    'error'=>'lang.start_date_and_end_date_already_exists',
                    'status'=>404,
                ]);
            }
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();
            $data = LeaveRequest::with("leaveType")->where("id", $request->id)->first();
            $delegateLeave = DelegateLeave::where("requester_id", $data->employee_id)->where("start_date", $data->start_date)->where("end_date",$data->end_date)->first();
            $leaveAllo = self::updateLeaveAllocation($request, $data, $LeaveType , Auth::user()->id);
            if($leaveAllo){
                $data["total_annual_leave"]      = $leaveAllo["total_annual_leave"];
                $data["total_sick_leave"]        = $leaveAllo["total_sick_leave"];
                $data["total_special_leave"]     = $leaveAllo["total_special_leave"];
                $data["total_unpaid_leave"]      = $leaveAllo["total_unpaid_leave"];
                $data["total_long_sick_leave"]   = $leaveAllo["total_long_sick_leave"];
            }
            if ($delegateLeave) {
                if ($request->delegate_id) {
                    $delegateLeave['delegate_id'] = $request->delegate_id;
                }
                $delegateLeave['start_date'] = $request->start_date;
                $delegateLeave['end_date'] = $request->end_date;
                $delegateLeave['number_of_day'] = $request->number_of_day;
                $delegateLeave->save();
            }else{
                if ($request->delegate_id) {
                    DelegateLeave::create(
                        [
                            "requester_id"      => Auth::user()->id,
                            "delegate_id"       => $request->delegate_id,
                            "number_of_day"     => $request->number_of_day,
                            "start_date"        => $request->start_date,
                            "end_date"          => $request->end_date,
                        ]
                    );
                }
            }

            $data['leave_type_id'] = $request->leave_type_id;
            $data['start_date'] = $request->start_date;
            $data['start_half_day'] = $request->start_half_day;
            $data['end_date'] = $request->end_date;
            $data['end_half_day'] = $request->end_half_day;
            $data['number_of_day'] = $request->number_of_day;
            $data['reason'] = $request->reason;
            $data['updated_by'] = Auth::user()->id;

            $data->save();
            return response()->json([
                'success'=>'leave_request_created_successfully',
                'status'=>200,
            ]);
            Toastr::success('Leave requsest updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Leave requsest updated fail.','Error');
            return redirect()->back();
        }
    }

    public function replcementUpdate(Request $request)
    {
        try{
            $duplicate  = self::duplicateLeace($request, $request->employee_id);
            if ($duplicate) {
                return response()->json([
                    'error'=>'lang.start_date_and_end_date_already_exists',
                    'status'=>404,
                ]);
            }
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();
            $data = LeaveRequest::with("leaveType")->where("id", $request->id)->first();
            $delegateLeave = DelegateLeave::where("requester_id", $data->employee_id)->where("start_date", $data->start_date)->where("end_date",$data->end_date)->first();
            $leaveAllo = self::updateLeaveAllocation($request, $data, $LeaveType , $request->employee_id);
            if($leaveAllo){
                $data["total_annual_leave"]      = $leaveAllo["total_annual_leave"];
                $data["total_sick_leave"]        = $leaveAllo["total_sick_leave"];
                $data["total_special_leave"]     = $leaveAllo["total_special_leave"];
                $data["total_unpaid_leave"]      = $leaveAllo["total_unpaid_leave"];
                $data["total_long_sick_leave"]   = $leaveAllo["total_long_sick_leave"];
            }
            if ($delegateLeave) {
                if ($request->delegate_id) {
                    $delegateLeave['delegate_id'] = $request->delegate_id;
                }
                $delegateLeave['start_date'] = $request->start_date;
                $delegateLeave['end_date'] = $request->end_date;
                $delegateLeave['number_of_day'] = $request->number_of_day;
                $delegateLeave->save();
            }else{
                if ($request->delegate_id) {
                    DelegateLeave::create(
                        [
                            "requester_id"      => $request->employee_id,
                            "delegate_id"       => $request->delegate_id,
                            "number_of_day"     => $request->number_of_day,
                            "start_date"        => $request->start_date,
                            "end_date"          => $request->end_date,
                        ]
                    );
                }
            }

            $data['leave_type_id'] = $request->leave_type_id;
            $data['start_date'] = $request->start_date;
            $data['start_half_day'] = $request->start_half_day;
            $data['end_date'] = $request->end_date;
            $data['end_half_day'] = $request->end_half_day;
            $data['number_of_day'] = $request->number_of_day;
            $data['reason'] = $request->reason;
            $data['updated_by'] = Auth::user()->id;

            $data->save();
            return response()->json([
                'success'=>'leave_request_created_successfully',
                'status'=>200,
            ]);
            Toastr::success('Leave requsest updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Leave requsest updated fail.','Error');
            return redirect()->back();
        }
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
            $data = LeaveRequest::with("leaveType")->where("id", $request->id)->first();
            $LeaveAllocation = LeaveAllocation::where("employee_id", $data->employee_id)->first();
            
            $total_number_of_day = self::totalRequestLeaveDay($data);
            if ($data->leaveType->type == "annual_leave") {
                $current_annual_leave = $LeaveAllocation->total_annual_leave + $total_number_of_day;
                $LeaveAllocation->total_annual_leave =  $current_annual_leave > $LeaveAllocation->default_annual_leave ? $LeaveAllocation->default_annual_leave : $current_annual_leave;
            }else if($data->leaveType->type == "sick_leave"){
                $current_sick_leave = $LeaveAllocation->total_sick_leave + $total_number_of_day;
                $LeaveAllocation->total_sick_leave = $current_sick_leave > $LeaveAllocation->default_sick_leave ? $LeaveAllocation->default_sick_leave : $current_sick_leave;
            }else if($data->leaveType->type == "special_leave") {
                $current_special_leave = $LeaveAllocation->total_special_leave + $total_number_of_day;
                $LeaveAllocation->total_special_leave = $current_special_leave > $LeaveAllocation->default_special_leave ? $LeaveAllocation->default_special_leave : $current_special_leave;
            }else if($data->leaveType->type == "unpaid_leave"){
                $current_unpaid_leave = $LeaveAllocation->total_unpaid_leave + $total_number_of_day;
                $LeaveAllocation->total_unpaid_leave = $current_unpaid_leave > $LeaveAllocation->default_unpaid_leave ? $LeaveAllocation->default_unpaid_leave : $current_unpaid_leave;
            }else if($data->leaveType->type == "long_sick_leave"){
                $current_long_sick_leave = $LeaveAllocation->total_long_sick_leave + $total_number_of_day;
                $LeaveAllocation->total_long_sick_leave = $current_long_sick_leave > $LeaveAllocation->default_long_sick_leave ? $LeaveAllocation->default_long_sick_leave : $current_long_sick_leave;
            }
            $LeaveAllocation->save();

            DelegateLeave::where('requester_id', $data->employee_id)->where("start_date",$data->start_date)->where("end_date",$data->end_date)->delete();

            LeaveRequest::destroy($request->id);
           
            Toastr::success('Leave requsest deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Leave requsest delete fail.','Error');
            return redirect()->back();
        }
    }
    public function cancel(Request $request)
    {
        try{
            $data = LeaveRequest::with("leaveType")->where("id", $request->id)->first();
            $dataBranch = Branchs::where("id", Auth::user()->branch->id)->first();
            if($dataBranch->abbreviations == "HQ"){
                if(Auth::user()->under_approve){
                    $data['next_approver'] = Auth::user()->under_approve;
                }else{
                    $data['next_approver'] = Auth::user()->department->direct_manager_id;
                }
            }else{
                if(Auth::user()->under_approve){
                    $data['next_approver'] = Auth::user()->under_approve;
                }else{
                    $data['next_approver'] = Auth::user()->branch->direct_manager_id;
                }  
            }
            if(Auth::user()->RolePermission == "BOD") {
                $data['next_approver'] = "Null";
            }else if (Auth::user()->RolePermission == "CEO") {
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif (Auth::user()->RolePermission == "HOD" && Auth::user()->id == Auth::user()->department->direct_manager_id) {
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif(Auth::user()->RolePermission == "DHOD" && Auth::user()->id == Auth::user()->department->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }else if(Auth::user()->RolePermission == "BM" && Auth::user()->id == Auth::user()->branch->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif(Auth::user()->RolePermission == "DBM" && Auth::user()->id == Auth::user()->branch->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }elseif(Auth::user()->RolePermission == "HRAdmin" && Auth::user()->id == Auth::user()->department->direct_manager_id){
                $data['next_approver'] = Auth::user()->line_manager;
            }

            $data['status'] = "pending_cancel";
            $data['remark'] = $request->remark;
            // $data['next_approver'] = $data->approved_by;
            $data['updated_by'] = Auth::user()->id;

            $data->save();
           
            Toastr::success('Cancel successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Cancel fail.','Error');
            return redirect()->back();
        }
    }
    public function Export(Request $request) {
        $dataLeaveType = LeaveType::get();
        $LeaveAllocation = LeaveAllocation::where("employee_id", $request->id)->first();
        $dataLeaveRequest = LeaveRequest::with("leaveType")->with("employee")->where("employee_id", $request->id)->get();
        $data = [
            "dataLeaveType"=> $dataLeaveType,
            "LeaveAllocation"=> $LeaveAllocation,
            "dataLeaveRequest"=> $dataLeaveRequest
        ];
        $export = new ExportLeaveEmployee($data);
        return Excel::download($export, 'Leave Employee.xlsx');
    }
}
