<?php

namespace App\Http\Controllers\Admins;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeProfileController extends Controller
{
    public function employeeProfile(Request $request){
        $data = Employee::where('id',$request->id)->first();
        return view('employees.profile',compact('data'));
    }
}
