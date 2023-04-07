<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function employeeProbation(){
        $users = User::where('emp_status','Probation')->get();
        return view('employee_reports.probation',compact('users'));
    }
    public function employeeFdc()
    {
        $users = User::where('emp_status',1)->get();
        return view('employee_reports.fdc',compact('users'));
    }
    public function employeeUdc()
    {
        $users = User::where('emp_status',2)->get();
        return view('employee_reports.udc',compact('users'));
    }
    public function employeeResignation()
    {
        $users = User::where('emp_status',3)->get();
        return view('employee_reports.resignation',compact('users'));
    }
    public function employeeTermination()
    {
        $users = User::where('emp_status',4)->get();
        return view('employee_reports.termination',compact('users'));
    }
}
