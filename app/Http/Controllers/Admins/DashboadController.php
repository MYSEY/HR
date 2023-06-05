<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Option;
use App\Models\RecruitmentPlan;
use App\Models\StaffPromoted;
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
        return view('dashboads.admin');
    }

    public function show(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $Monthly= Carbon::now()->format('m');
        $yearLy = Carbon::now()->format('Y');

        $branches = Branchs::all();
        $options = Option::where("type", "emp_status")->get();

        $employee = User::with("gender")->with('position')->with('branch')->when($from_date, function ($query, $from_date) {
            $query->where('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('created_at','<=', $to_date);
            })->orderBy('id', 'desc')->get();

        $currentYear = Carbon::now()->format('Y');
        $year = Carbon::createFromDate('01-01-'.$currentYear)->format('Y-m-d');
        $staffResignations = User::whereNotIn('emp_status',['1','2','Probation'])
            ->when($year, function ($query, $year) {
                $query->where('resign_date', '>=', $year);
            })->orderBy('id', 'desc')->get();

        $recruitmentPlans = RecruitmentPlan::with('branch')->whereMonth("plan_date", 12)->whereYear("plan_date",$yearLy)->get();
        $achieveBranchs = User::with('branch')->whereIn('emp_status',['1','2','Probation'])
          ->when($year, function ($query, $year) {
              $query->where('date_of_commencement', '>=', $year);
          })->get();

        $totalStaff =  User::with("gender")->whereIn('emp_status',['1','2','Probation'])->get();
        $newStaff = User::where('emp_status', "Probation")->get()->count();
        $staffPromotes = StaffPromoted::all()->count();
        $transferred = Transferred::all()->count();

        $dataTrainings = Training::whereMonth("created_at", $Monthly)->whereYear("created_at", $yearLy)->get();
        $dataEmployeeTrainings = [];
        foreach ($dataTrainings as $key => $item) {
            $dataEmployeeTrainings[] = User::whereIn('id', $item->employee_id)->select("employee_name_kh", "employee_name_en", "branch_id", "profile")->with('branch')->get();
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
            'newStaff'=> $newStaff,
            'totalStaff'=> $totalStaff,
            'dataTrainings'=> $dataTrainings,
            'dataEmployeeTrainings'=> $dataEmployeeTrainings,
        ]);
    }
}
