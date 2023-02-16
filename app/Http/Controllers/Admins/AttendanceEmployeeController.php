<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceEmployeeController extends Controller
{
    public function index(){
        return view('attendance_employees.index');
    }
}
