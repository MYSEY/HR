<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\RecruitmentPlan;
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
        $branches = Branchs::all();

        $employee = User::with("gender")->with('position')->with('branch')->when($from_date, function ($query, $from_date) {
            $query->where('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('created_at','<=', $to_date);
            })->get();


        $currentYear = Carbon::now()->format('Y');
        $year = Carbon::createFromDate('01-01-'.$currentYear)->format('Y-m-d');
        $staffResignations = User::whereNotIn('emp_status',['1','2','Probation'])
            ->when($year, function ($query, $year) {
                $query->where('resign_date', '>=', $year);
            })->get();

        $recruitmentPlans = RecruitmentPlan::with('branch')->get();
        $achieveBranchs = User::with('branch')->whereIn('emp_status',['1','2','Probation'])
          ->when($year, function ($query, $year) {
              $query->where('date_of_commencement', '>=', $year);
          })->get();

        return response()->json([
            'branches'=>$branches,
            'data'=>$employee,
            'staffResignations'=>$staffResignations,
            'recruitmentPlans'=>$recruitmentPlans,
            'achieveBranchs'=>$achieveBranchs,
        ]);
    }
}
