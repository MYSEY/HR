<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use App\Repositories\Admin\EmployeeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $dataLeaveRequest = LeaveRequest::with("leaveType")->where("employee_id", Auth::user()->id)->get();
        return view('leaves_employee.index', compact('dataLeaveType', 'LeaveAllocation', 'dataLeaveRequest'));
    }

    public function create(Request $request)
    {
        
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
            $data = $request->all();
            $LeaveAllocation = LeaveAllocation::where("employee_id", Auth::user()->id)->first();
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();
            if (empty($LeaveType->type)) {
                Toastr::error('Leave type not found','Error');
                return redirect()->back();
                DB::commit();
            }
            $LeaveAllocation["total_annual_leave"] = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $request->number_of_day : $LeaveAllocation->total_annual_leave;
            $LeaveAllocation["total_sick_leave"] = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $request->number_of_day : $LeaveAllocation->total_sick_leave;
            $LeaveAllocation["total_special_leave"] = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $request->number_of_day : $LeaveAllocation->total_special_leave;
            $LeaveAllocation["total_unpaid_leave"] = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $request->number_of_day : $LeaveAllocation->total_unpaid_leave;
            $data['status'] = "pending";
            $data['employee_id'] = Auth::user()->id;
            $data['created_by'] = Auth::user()->id;
            
            $LeaveAllocation->save();
            LeaveRequest::create($data);
            Toastr::success('Leave request created successfully.','Success');
            return redirect()->back();
            DB::commit();
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
        $data = LeaveRequest::where("id", $request->id)->first();
        return response()->json([
            'dataLeaveType'=>$dataLeaveType,
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
            $LeaveAllocation = LeaveAllocation::where("employee_id", Auth::user()->id)->first();
            $LeaveType = LeaveType::where("id", $request->leave_type_id)->first();
            $data = LeaveRequest::with("leaveType")->where("id", $request->id)->first();

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
                    $LeaveAllocation->total_unpaid_leave += $current_unpaid_leave > $LeaveAllocation->default_unpaid_leave ? $LeaveAllocation->default_unpaid_leave : $current_unpaid_leave;
                }

                // When modifying the Status, subtract the number of day from the new status.
                $LeaveAllocation->total_annual_leave = $LeaveType->type == "annual_leave" ? $LeaveAllocation->total_annual_leave - $request->number_of_day : $LeaveAllocation->total_annual_leave;
                $LeaveAllocation->total_sick_leave = $LeaveType->type == "sick_leave" ? $LeaveAllocation->total_sick_leave - $request->number_of_day : $LeaveAllocation->total_sick_leave;
                $LeaveAllocation->total_special_leave = $LeaveType->type == "special_leave" ? $LeaveAllocation->total_special_leave - $request->number_of_day : $LeaveAllocation->total_special_leave;
                $LeaveAllocation->total_unpaid_leave = $LeaveType->type == "unpaid_leave" ? $LeaveAllocation->total_unpaid_leave - $request->number_of_day : $LeaveAllocation->total_unpaid_leave;
                $LeaveAllocation->save();
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
            }

            $LeaveAllocation->save();
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
