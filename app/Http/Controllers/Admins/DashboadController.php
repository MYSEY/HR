<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Option;
use App\Models\RecruitmentPlan;
use App\Models\StaffPromoted;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\Transferred;
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
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }

        $branches = Branchs::all();
        $options = Option::where("type", "emp_status")->get();

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

          $staffPromotes = StaffPromoted::with("employee")->limit(5)->get();
          $transferred = Transferred::with("employee")->with("branch")->with("position")->limit(5)->get();

        $data = Training::with('trainingType')->limit(5)->get();
        $dataTrainings = [];
        foreach ($data as $key => $item) {
            $employees = [];
            foreach ($item->employee_id as $key => $empl) {
                $em =  User::where('id', $empl)->with("gender")->with("branch")->with("position")->limit(5)->get();
                $employees[] = $em;
            }
            $item["employees"] = $employees;
            $dataTrainings[] = $item;
        }
        
        return response()->json([
            'options'=>$options,
            'branches'=>$branches,
            'data'=>$employee,
            'staffResignations'=>$staffResignations,
            'recruitmentPlans'=>$recruitmentPlans,
            'achieveBranchs'=>$achieveBranchs,
            'staffPromotes'=>$staffPromotes,
            'transferred'=> $transferred,
            'dataTrainings'=> $dataTrainings,
        ]);
    }
}
