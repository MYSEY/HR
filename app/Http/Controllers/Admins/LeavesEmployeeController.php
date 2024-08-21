<?php

namespace App\Http\Controllers\Admins;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\Branchs;
use App\Models\DelegateLeave;
use App\Models\Department;
use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\mail as ModelsMail;
use App\Models\User;
use App\Repositories\Admin\EmployeeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LeavesEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataLeaveType = LeaveType::get();
        $LeaveAllocation = LeaveAllocation::where("employee_id", Auth::user()->id)->first();
        $employees= DB::table('users')->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'BM') {
                    $query->where("id", Auth::user()->line_manager);
                    $query->orWhere("branch_id", Auth::user()->branch_id);
                    $query->whereNot("id", Auth::user()->id);
                }else if($RolePermission == 'HOD'){
                    if (Auth::user()->id == Auth::user()->department->direct_manager_id) {
                        $query->where("department_id", Auth::user()->department_id);
                        $query->whereNot("id", Auth::user()->id);
                    }else{
                        $query->where("id", Auth::user()->line_manager);
                        $query->orWhere("line_manager", Auth::user()->id);
                        $query->whereNot("id", Auth::user()->id);
                    }
                }else if($RolePermission == 'Employee'){
                    $query->where("id", Auth::user()->line_manager);
                    $query->orWhere("line_manager", Auth::user()->line_manager);
                    $query->where("department_id", Auth::user()->department_id);
                    $query->where("branch_id", Auth::user()->branch_id);
                    $query->whereNot("id", Auth::user()->id);
                }else if($RolePermission == 'HR' || $RolePermission =="HRAdmin"){
                    $query->where("id", Auth::user()->line_manager);
                    $query->orWhere("line_manager", Auth::user()->id);
                    $query->whereNot("id", Auth::user()->id);
                }
            })->get();
        $delegateEmployees= DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select( 'users.*', 'roles.role_type',)
            ->whereNot("roles.role_type", "Employee")
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'BM') {
                    $query->orWhere("users.branch_id", Auth::user()->branch_id);
                    $query->whereNot("users.id", Auth::user()->id);
                }else if($RolePermission == 'HOD'){
                    $query->where("users.department_id", Auth::user()->department_id);
                    $query->whereNot("users.id", Auth::user()->id);
                }else if($RolePermission == 'HR' || $RolePermission =="HRAdmin"){
                    $query->orWhere("users.line_manager", Auth::user()->id);
                    $query->whereNot("users.id", Auth::user()->id);
                }
            })->get();
        $dataLeaveRequest = LeaveRequest::with("leaveType")->where("employee_id", Auth::user()->id)->get();
        return view('leaves_employee.index', compact('dataLeaveType', 'LeaveAllocation', 'employees','delegateEmployees', 'dataLeaveRequest'));
    }


    function duplicateLeace($request)
    {
        $startDate = $request->start_date;
            $endDate = $request->end_date;
            $startHalfDay = $request->start_half_day;
            $endHalfDay = $request->end_half_day;
            $overlappingLeave = null;

            $overlappingLeave  = LeaveRequest::where('employee_id', Auth::user()->id)
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
                    $overlappingLeave = LeaveRequest::where('employee_id', Auth::user()->id)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '>=', $startDate)
                        ->where('end_date', '<=', $endDate);
                    })->exists();
                }
                if (($startHalfDay == "am"|| $startHalfDay == "pm") || ($endHalfDay == "am" || $endHalfDay == "pm")) {
                    if ($startHalfDay == "am"|| $startHalfDay == "pm") {
                        $overlappingLeave1 = LeaveRequest::where('employee_id', Auth::user()->id)
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
                        $overlappingLeave2 = LeaveRequest::where('employee_id', Auth::user()->id)
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
                    $dataLeaves = LeaveRequest::where('employee_id', Auth::user()->id)
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
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $duplicate  = self::duplicateLeace($request);
            if ($duplicate) {
                return response()->json([
                    'error'=>'lang.start_date_and_end_date_already_exists',
                    'status'=>404,
                ]);
            }
            $data = $request->all();
            $LeaveAllocation = LeaveAllocation::where("employee_id", Auth::user()->id)->first();
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();

            $request_date = Carbon::now()->format('Y-m-d');
            // $request_date = "2024-07-03";
            $delegateLeave = DelegateLeave::where("requester_id", Auth::user()->line_manager)
            ->where('start_date', '<=', $request_date)
            ->where('end_date', '>=', $request_date)->first();
           
            if(Auth::user()->RolePermission == "BOD") {
                $data['status'] = "approved_hod";
                $data['next_approver'] = "Null";
            }else if (Auth::user()->RolePermission == "CEO") {
                $data['status'] = "approved_lm";
            }elseif (Auth::user()->RolePermission == "HOD" && Auth::user()->id == Auth::user()->department->direct_manager_id) {
                $data['status'] = "approved_lm";
            }else if(Auth::user()->RolePermission == "BM" && Auth::user()->id == Auth::user()->branch->direct_manager_id){
                $data['status'] = "approved_lm";
            }else{
                $data['status'] = "pending";
            }
           
            $data['next_approver'] = Auth::user()->line_manager;
            if ($delegateLeave) {
                $data['next_approver'] = $delegateLeave->delegate_id;
                if ($delegateLeave->delegate_id  == Auth::user()->id) {
                    $line =  User::where("id", $delegateLeave->requester_id)->first();
                    if ($line) {
                        $data['next_approver'] = $line->line_manager;
                        $lineLeave = DelegateLeave::where("requester_id",  $line->line_manager)->where('start_date', '<=', $request_date)->where('end_date', '>=', $request_date)->first();
                        
                        if ($lineLeave) {
                            $data['next_approver'] = $lineLeave->delegate_id;

                            $delegateLeave3 = LeaveRequest::where("employee_id", $lineLeave->delegate_id)
                            ->where('start_date', '<=', $request_date)
                            ->where('end_date', '>=', $request_date)->first();
                            if ($delegateLeave3) {
                                $LineNumberDelegateHead = Helper::countWeekdays($request_date,$delegateLeave3->end_date);

                                $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                                $LineNumber2 = Helper::countWeekdays($request_date,$lineLeave->end_date);
                                if ($LineNumber1 <= $LineNumber2) {
                                    $data['next_approver'] = $line->id;
                                    if ($LineNumberDelegateHead < $LineNumber1) {
                                        $data['next_approver'] = $delegateLeave3->employee_id;
                                    }
                                }else{
                                    $data['next_approver'] = $line->line_manager;
                                    if ($LineNumberDelegateHead < $LineNumber2) {
                                        $data['next_approver'] = $delegateLeave3->employee_id;
                                    }
                                }
                            }

                            // $lineLeave1 = DelegateLeave::where("requester_id",  $lineLeave->delegate_id)->where('start_date', '<=', $request_date)->where('end_date', '>=', $request_date)->first();
                            // if ($lineLeave1) {
                            //     $data['next_approver'] = $lineLeave->requester_id;
                            //     $delegateLeave3 = LeaveRequest::where("employee_id", $delegateLeave2->delegate_id)
                            //     ->where('start_date', '<=', $request_date)
                            //     ->where('end_date', '>=', $request_date)->first();
                            //     if ($delegateLeave3) {
                            //         $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                            //         $LineNumber2 = Helper::countWeekdays($request_date,$leaveLineManager2->end_date);
                            //         if ($LineNumber1 <= $LineNumber2) {
                            //             $data['next_approver'] = $line_manager1->id;
                            //         }else{
                            //             $data['next_approver'] = $line_manager1->line_manager;
                            //         }
                            //     }
                            // }
                        }
                    }
                }else{
                    $delegateLeave1 = DelegateLeave::where("requester_id", $delegateLeave->delegate_id)
                    ->where('start_date', '<=', $request_date)
                    ->where('end_date', '>=', $request_date)->first();
                    if ($delegateLeave1) {
                        $line_manager1 = User::where("id", Auth::user()->line_manager)->first();
                        $data['next_approver'] = $line_manager1->line_manager;

                        $leaveLineManager2 = LeaveRequest::where("employee_id", $line_manager1->line_manager)
                        ->where('start_date', '<=', $request_date)
                        ->where('end_date', '>=', $request_date)->first();
                        $delegateLeave2 = DelegateLeave::where("requester_id", $line_manager1->line_manager)
                        ->where('start_date', '<=', $request_date)
                        ->where('end_date', '>=', $request_date)->first();

                        if ($delegateLeave2) {
                            $data['next_approver'] = $delegateLeave2->delegate_id;
                            $delegateLeave3 = LeaveRequest::where("employee_id", $delegateLeave2->delegate_id)
                            ->where('start_date', '<=', $request_date)
                            ->where('end_date', '>=', $request_date)->first();
                            if ($delegateLeave3) {
                                $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                                $LineNumber2 = Helper::countWeekdays($request_date,$leaveLineManager2->end_date);
                                if ($LineNumber1 <= $LineNumber2) {
                                    $data['next_approver'] = $line_manager1->id;
                                }else{
                                    $data['next_approver'] = $line_manager1->line_manager;
                                }
                            }

                        }else{
                            if ($leaveLineManager2) {
                                $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                                $LineNumber2 = Helper::countWeekdays($request_date,$leaveLineManager2->end_date);
                                if ($LineNumber1 <= $LineNumber2) {
                                    $data['next_approver'] = $line_manager1->id;
                                }else{
                                    $data['next_approver'] = $line_manager1->line_manager;
                                }
                            }
                        }
                    }else{
                        $delegateLeaveRequest = LeaveRequest::where("employee_id", $delegateLeave->delegate_id)
                        ->where('start_date', '<=', $request_date)
                        ->where('end_date', '>=', $request_date)->first();
                        if ($delegateLeaveRequest) {
                           
                            $line_manager1 = User::where("id", Auth::user()->line_manager)->first();
                            $data['next_approver'] = $line_manager1->line_manager;
                            $leaveLineManager2 = LeaveRequest::where("employee_id", $line_manager1->line_manager)
                            ->where('start_date', '<=', $request_date)
                            ->where('end_date', '>=', $request_date)->first();
                            $delegateLeave2 = DelegateLeave::where("requester_id", $line_manager1->line_manager)
                            ->where('start_date', '<=', $request_date)
                            ->where('end_date', '>=', $request_date)->first();
                            if ($delegateLeave2) {
                                $data['next_approver'] = $delegateLeave2->delegate_id;
                                $delegateLeave3 = LeaveRequest::where("employee_id", $delegateLeave2->delegate_id)
                                ->where('start_date', '<=', $request_date)
                                ->where('end_date', '>=', $request_date)->first();
                                if ($delegateLeave3) {
                                    $LineNumberDelegateHead = Helper::countWeekdays($request_date,$delegateLeave3->end_date);
                                    
                                    $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                                    $LineNumber2 = Helper::countWeekdays($request_date,$leaveLineManager2->end_date);
                                    if ($LineNumber1 <= $LineNumber2) {
                                        $data['next_approver'] = $line_manager1->id;
                                        if ($LineNumberDelegateHead < $LineNumber1) {
                                            $data['next_approver'] = $delegateLeave3->employee_id;
                                        }
                                    }else{
                                        $data['next_approver'] = $line_manager1->line_manager;
                                        if ($LineNumberDelegateHead < $LineNumber2) {
                                            $data['next_approver'] = $delegateLeave3->employee_id;
                                        }
                                    }
                                }
    
                            }else{
                                // $line_manager1 = User::where("id", Auth::user()->line_manager)->first();
                                // $data['next_approver'] = $line_manager1->line_manager;
                                // $leaveLineManager2 = LeaveRequest::where("employee_id", $line_manager1->line_manager)
                                // ->where('start_date', '<=', $request_date)
                                // ->where('end_date', '>=', $request_date)->first();

                                // dd($line_manager1);
                                if ($leaveLineManager2) {
                                    // dd(5555555);
                                    $LineNumber1 = Helper::countWeekdays($request_date,$delegateLeave->end_date);
                                    $LineNumber2 = Helper::countWeekdays($request_date,$leaveLineManager2->end_date);
                                    if ($LineNumber1 <= $LineNumber2) {
                                        $data['next_approver'] = $line_manager1->id;
                                    }else{
                                        $data['next_approver'] = $line_manager1->line_manager;
                                    }
                                }
                                // dd(1123344);
                            }
                        }
                    }
                }
            }else{
                $leaveLineManager1 = LeaveRequest::where("employee_id", Auth::user()->line_manager)
                ->where('start_date', '<=', $request_date)
                ->where('end_date', '>=', $request_date)->first();
                if ($leaveLineManager1) {
                    $line_manager1 = User::where("id", Auth::user()->line_manager)->first();
                    $data['next_approver'] = $line_manager1->line_manager;
                    $leaveLineManager2 = LeaveRequest::where("employee_id", $line_manager1->line_manager)
                    ->where('start_date', '<=', $request_date)
                    ->where('end_date', '>=', $request_date)->first();

                    if ($leaveLineManager2) {
                        $DelegateLeave2 = DelegateLeave::where("requester_id", $line_manager1->line_manager)
                        ->where('start_date', '<=', $request_date)
                        ->where('end_date', '>=', $request_date)->first();
                        if ($DelegateLeave2) {
                            $delegateLeave3 = LeaveRequest::where("employee_id", $DelegateLeave2->delegate_id)
                            ->where('start_date', '<=', $request_date)
                            ->where('end_date', '>=', $request_date)->first();
                            $data['next_approver'] = $DelegateLeave2->delegate_id;
                            if ($delegateLeave3) {
                                $LineNumberDelegateHead = Helper::countWeekdays($request_date,$delegateLeave3->end_date);
                                $LineNumber1 = Helper::countWeekdays($request_date,$leaveLineManager1->end_date);
                                $LineNumber2 = Helper::countWeekdays($request_date,$leaveLineManager2->end_date);
                                if ($LineNumber1 <= $LineNumber2) {
                                    $data['next_approver'] = $line_manager1->id;
                                    if ($LineNumberDelegateHead < $LineNumber1) {
                                        $data['next_approver'] = $delegateLeave3->employee_id;
                                    }
                                }else{
                                    $data['next_approver'] = $line_manager1->line_manager;
                                    if ($LineNumberDelegateHead < $LineNumber2) {
                                        $data['next_approver'] = $delegateLeave3->employee_id;
                                    }
                                }
                            }

                        }else{

                            $LineNumber1 = Helper::countWeekdays($request_date,$leaveLineManager1->end_date);
                            $LineNumber2 = Helper::countWeekdays($request_date,$leaveLineManager2->end_date);
                            if ($LineNumber1 <= $LineNumber2) {
                                $data['next_approver'] = Auth::user()->line_manager;
                            }else{
                                $data['next_approver'] = $line_manager1->line_manager;
                            }



                            // $line_manager3 = User::where("id", $leaveLineManager2->employee_id)->first();
                            // $data['next_approver'] = $line_manager3->line_manager;
                            // $DelegateLeave3 = DelegateLeave::where("requester_id", $line_manager3->id)
                            // ->where('start_date', '<=', $request_date)
                            // ->where('end_date', '>=', $request_date)->first();
                            // if ($DelegateLeave3) {
                            //     $data['next_approver'] = $DelegateLeave3->delegate_id;
                            // }  


                        }
                        // $LineNumber1 = Helper::getDays($request_date,$leaveLineManager1->end_date);
                        // $LineNumber2 = Helper::getDays($request_date,$leaveLineManager2->end_date);
                        // if ($LineNumber1 <= $LineNumber2) {
                        //     $data['next_approver'] = $line_manager1->id;
                        // }
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

            if ($LeaveAllocation == null) {
                LeaveAllocation::create([
                    'employee_id'  => Auth::user()->id,
                    'default_annual_leave'  => 0,
                    'default_sick_leave'  => 0,
                    'default_special_leave'  => 0,
                    'default_unpaid_leave'  => 0,
                    'total_annual_leave'    => $LeaveAllocation['total_annual_leave'] = 0 - $request->number_of_day,
                    'total_sick_leave'  => 0,
                    'total_special_leave'  => 0,
                    'total_unpaid_leave'  => 0,
                    'created_by'  => Auth::user()->id,
                ]);
            }else{
                $LeaveAllocation["total_annual_leave"] = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $request->number_of_day : $LeaveAllocation->total_annual_leave;
                $LeaveAllocation["total_sick_leave"] = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $request->number_of_day : $LeaveAllocation->total_sick_leave;
                $LeaveAllocation["total_special_leave"] = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $request->number_of_day : $LeaveAllocation->total_special_leave;
                $LeaveAllocation["total_unpaid_leave"] = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $request->number_of_day : $LeaveAllocation->total_unpaid_leave;
                $LeaveAllocation["total_long_sick_leave"] = $LeaveType->type == "long_sick_leave" ? $LeaveAllocation->total_long_sick_leave - $request->number_of_day : $LeaveAllocation->total_long_sick_leave;
                $LeaveAllocation->save();
            }

            $data['employee_id'] = Auth::user()->id;
            $data['created_by'] = Auth::user()->id;
            
            LeaveRequest::create($data);
            
            // for send email
            $line_manager = User::where("id", $data['next_approver'])->first();
            $mail_message = ModelsMail::first();
            if ($line_manager && $mail_message) {
                if ($line_manager->email) {
                    Mail::to($line_manager->email)->send(new SendEmail($mail_message));
                }
            }
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
            $duplicate  = self::duplicateLeace($request);
            if ($duplicate) {
                return response()->json([
                    'error'=>'lang.start_date_and_end_date_already_exists',
                    'status'=>404,
                ]);
            }
            $LeaveAllocation = LeaveAllocation::where("employee_id", Auth::user()->id)->first();
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();
            $data = LeaveRequest::with("leaveType")->where("id", $request->id)->first();
            $delegateLeave = DelegateLeave::where("requester_id", $data->employee_id)->where("start_date", $data->start_date)->where("end_date",$data->end_date)->first();

            if ($LeaveType->type == $data->leaveType->type) {
                $number_day = 0;
                if ( $request->number_of_day > $data->number_of_day) {
                    $number_day = $data->number_of_day - $request->number_of_day;
                }else if ( $request->number_of_day < $data->number_of_day) {
                    $number_day = $data->number_of_day - $request->number_of_day;
                }
                $LeaveAllocation->total_annual_leave += $LeaveType->type == "annual_leave" ? $number_day : 0;
                $LeaveAllocation->total_sick_leave += $LeaveType->type == "sick_leave" ? $number_day : 0;
                $LeaveAllocation->total_special_leave += $LeaveType->type == "special_leave" ? $number_day : 0;
                $LeaveAllocation->total_unpaid_leave += $LeaveType->type == "unpaid_leave" ? $number_day : 0;
                $LeaveAllocation->total_long_sick_leave += $LeaveType->type == "long_sick_leave" ? $number_day : 0;
                $LeaveAllocation->save();
                
            }else{
                // When modifying the Status, sum the number of day to old status.
                if ($data->leaveType->type == "annual_leave") {
                    $current_annual_leave = $LeaveAllocation->total_annual_leave + $request->number_of_day;
                    $LeaveAllocation->total_annual_leave =  $current_annual_leave > $LeaveAllocation->default_annual_leave ? $LeaveAllocation->default_annual_leave : $current_annual_leave;
                }else if($data->leaveType->type == "sick_leave"){
                    $current_sick_leave = $LeaveAllocation->total_sick_leave + $request->number_of_day;
                    $LeaveAllocation->total_sick_leave = $current_sick_leave > $LeaveAllocation->default_sick_leave ? $LeaveAllocation->default_sick_leave : $current_sick_leave;
                }else if($data->leaveType->type == "special_leave") {
                    $current_special_leave = $LeaveAllocation->total_special_leave + $request->number_of_day;
                    $LeaveAllocation->total_special_leave = $current_special_leave > $LeaveAllocation->default_special_leave ? $LeaveAllocation->default_special_leave : $current_special_leave;
                }else if($data->leaveType->type == "unpaid_leave"){
                    $current_unpaid_leave = $LeaveAllocation->total_unpaid_leave + $request->number_of_day;
                    if ($current_unpaid_leave == 0) {
                        $LeaveAllocation->total_unpaid_leave = 0;
                    }else{
                        $LeaveAllocation->total_unpaid_leave =  $current_unpaid_leave;
                    }
                    // $LeaveAllocation->total_unpaid_leave = $current_unpaid_leave >= $LeaveAllocation->default_unpaid_leave ? $LeaveAllocation->default_unpaid_leave : $current_unpaid_leave;
                }else if($data->leaveType->type == "long_sick_leave"){
                    $current_long_sick_leave = $LeaveAllocation->total_long_sick_leave + $request->number_of_day;
                    if ($current_long_sick_leave == 0) {
                        $LeaveAllocation->total_long_sick_leave = 0;
                    }else {
                        $LeaveAllocation->total_long_sick_leave = $current_long_sick_leave;
                    }
                    // $LeaveAllocation->total_long_sick_leave = $current_long_sick_leave >= $LeaveAllocation->default_long_sick_leave ? $LeaveAllocation->default_long_sick_leave : $current_long_sick_leave;
                }

                // When modifying the Status, subtract the number of day from the new status.
                $LeaveAllocation->total_annual_leave = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $request->number_of_day : $LeaveAllocation->total_annual_leave;
                $LeaveAllocation->total_sick_leave = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $request->number_of_day : $LeaveAllocation->total_sick_leave;
                $LeaveAllocation->total_special_leave = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $request->number_of_day : $LeaveAllocation->total_special_leave;
                $LeaveAllocation->total_unpaid_leave = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $request->number_of_day : $LeaveAllocation->total_unpaid_leave;
                $LeaveAllocation->total_long_sick_leave = $LeaveType->type == "long_sick_leave" ? $LeaveAllocation->total_long_sick_leave - $request->number_of_day : $LeaveAllocation->total_long_sick_leave;
                
                $LeaveAllocation->save();
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
            
            if ($data->leaveType->type == "annual_leave") {
                $current_annual_leave = $LeaveAllocation->total_annual_leave + $request->number_of_day;
                $LeaveAllocation->total_annual_leave =  $current_annual_leave > $LeaveAllocation->default_annual_leave ? $LeaveAllocation->default_annual_leave : $current_annual_leave;
            }else if($data->leaveType->type == "sick_leave"){
                $current_sick_leave = $LeaveAllocation->total_sick_leave + $request->number_of_day;
                $LeaveAllocation->total_sick_leave = $current_sick_leave > $LeaveAllocation->default_sick_leave ? $LeaveAllocation->default_sick_leave : $current_sick_leave;
            }else if($data->leaveType->type == "special_leave") {
                $current_special_leave = $LeaveAllocation->total_special_leave + $request->number_of_day;
                $LeaveAllocation->total_special_leave = $current_special_leave > $LeaveAllocation->default_special_leave ? $LeaveAllocation->default_special_leave : $current_special_leave;
            }else if($data->leaveType->type == "unpaid_leave"){
                $current_unpaid_leave = $LeaveAllocation->total_unpaid_leave + $request->number_of_day;
                $LeaveAllocation->total_unpaid_leave = $current_unpaid_leave > $LeaveAllocation->default_unpaid_leave ? $LeaveAllocation->default_unpaid_leave : $current_unpaid_leave;
            }else if($data->leaveType->type == "long_sick_leave"){
                $current_long_sick_leave = $LeaveAllocation->total_long_sick_leave + $request->number_of_day;
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
}
