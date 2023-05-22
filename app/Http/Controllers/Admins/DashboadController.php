<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\User;
use Carbon\Carbon;
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

    public function show(Request $request){
        $from_date = null;
        $to_date = null;
        $staff_from_date = null;
        $staff_to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
            $staff_from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d');
            $staff_to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d');
        }
        
        $employee = User::when($from_date, function ($query, $from_date) {
            $query->where('created_at', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('created_at','<=', $to_date);
        })->get();
        
        $staffResignations = User::whereNotIn('emp_status',['1','2','Probation'])
        ->when($staff_from_date, function ($query, $staff_from_date) {
            $query->where('date_of_commencement', '>=', $staff_from_date);
        })
        ->when($staff_to_date, function ($query, $staff_to_date) {
            $query->where('date_of_commencement','<=', $staff_to_date);
        })->get();

        $branches = Branchs::all();
        return response()->json([
            'data'=>$employee,
            'staffResignations'=>$staffResignations,
            'branches'=>$branches,
        ]);
    }
}
