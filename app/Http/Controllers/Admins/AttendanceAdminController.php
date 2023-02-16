<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceAdminController extends Controller
{
    public function index(){
        return view('attendance_admins.index');
    }
}