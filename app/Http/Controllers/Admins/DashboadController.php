<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboadController extends Controller
{
    public function dashboadEmployee(){
        return view('dashboads.employee');
    }
    public function dashboadAdmin(){
        return view('dashboads.admin');
    }
}
