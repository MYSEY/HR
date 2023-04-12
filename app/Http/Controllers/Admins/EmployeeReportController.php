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

    public function index(Request $request){
        if ($request->emp_status!=null) {
            $users = User::where('emp_status',$request->emp_status)->get();
            return view('employee_reports.report',compact('users'));
        } else {
            $users = User::all();
            return view('employee_reports.report',compact('users'));
        }
    }
}
