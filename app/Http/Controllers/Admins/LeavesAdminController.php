<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $dataLeaveRequest = LeaveRequest::with("employee")->get();
        return view('leaves_admin.index', compact('dataLeaveType', 'LeaveAllocation', 'dataLeaveRequest'));
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
