<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboadController extends Controller
{
    public function dashboadEmployee(){
        return view('dashboads.employee');
    }
    public function dashboadAdmin(){
        $employee = User::all();
        return view('dashboads.admin',compact('employee'));
    }
}
