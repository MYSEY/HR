<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Option;
use App\Models\Branchs;
use App\Models\Holiday;
use App\Models\Training;
use App\Models\Transferred;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Models\StaffPromoted;
use App\Models\CandidateResume;
use App\Models\LeaveAllocation;
use App\Models\RecruitmentPlan;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\EmployeeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboadController extends Controller
{
    public function dashboadEmployee(){
        $holiday = Holiday::where('from','=',Carbon::now()->addDays(2))->get(['title_kh','from']);
        $LeaveRequest = LeaveRequest::where('employee_id',Auth::user()->id)->orderBy('id', 'DESC')->first();
        $data = LeaveAllocation::where('employee_id',Auth::user()->id)->first();
        return view('dashboads.employee',compact('data','holiday','LeaveRequest'));
    }
    public function dashboadAdmin(){

        $dataShortList = DB::table('candidate_resumes')->select('candidate_resumes.*')
        ->where(DB::raw("(DATE_FORMAT(candidate_resumes.interviewed_date,'%Y-%m-%d'))"), Carbon::now()->format('Y-m-d'))
        ->where('candidate_resumes.status','2')->get()->count();
        $dataContract = CandidateResume::where('contract_date',Carbon::now()->format('Y-m-d'))->where('status','4')->get()->count();
        $dataUpComming = User::where('date_of_commencement',Carbon::now()->format('Y-m-d'))->where('emp_status','Upcoming')->get()->count();
        $dataProbation = User::where('fdc_date',Carbon::now()->format('Y-m-d'))->where('emp_status','Probation')->get()->count();
         return view('dashboads.admin',compact(
                    'dataUpComming',
                    'dataProbation',
                    'dataShortList',
                    'dataContract'
                ));
        // return view('dashboads.admin');
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
        $position_type = Option::whereIn("type", ["position_type", "gender"])->get();

        $employee = User::with("gender")->with('position')->with('branch')
        ->whereNot("emp_status", null)
        ->when($from_date, function ($query, $from_date) {
            $query->where('created_at', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('created_at','<=', $to_date);
        })->orderBy('id', 'desc')->get();

        // $currentYear = Carbon::now()->format('Y');
        // $year = Carbon::createFromDate('01-01-'.$currentYear)->format('Y-m-d');
        $year = null;
        $staffResignations = User::whereNotIn('emp_status',['1','2','10','Probation','Upcoming', 'Cancel'])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'BM'){
                $query->where("branch_id", Auth::user()->branch_id);
            }else if($RolePermission == 'HOD'){
                $query->whereIn("department_id",  EmployeeRepository::getRoleHOD());
            }
        })
        ->when($year, function ($query, $year) {
            $query->where('resign_date', '>=', $year);
        })->orderBy('id', 'desc')->get();

        $recruitmentPlans = RecruitmentPlan::with("branch")->whereMonth("plan_date", 12)->whereYear("plan_date",$yearLy)
            ->join('positions', 'recruitment_plans.position_id', '=', 'positions.id')
            ->select(
                'recruitment_plans.*',
                'positions.type',
            )
            ->where("positions.type", "Credit_Officer")
            ->get();
        $achieveBranchs = User::with('branch')->whereIn('emp_status',['1','2','10','Probation'])
        ->when($year, function ($query, $year) {
            $query->where('date_of_commencement', '>=', $year);
        })->get();
        
        $leavePending = LeaveRequest::when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'CEO' || $RolePermission == 'BOD' || $RolePermission == 'BM' || $RolePermission == 'HOD'){
                $query->where("next_approver", Auth::user()->id);
                $query->whereIn("status", ["approved_hod", "approved_lm", "pending"]);
            }else{
                $query->whereIn("status", ["pending","approved_hod", "approved_lm"]);
            }
        })->count();
        $leaveApproval = LeaveRequest::when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'CEO' || $RolePermission == 'BOD' || $RolePermission == 'BM' || $RolePermission == 'HOD'){
                $query->whereJsonContains("approved_by", Auth::user()->id);
            }else{
                $query->where("status", ["approved"]);
            }
        })->count();
        $leaveReject = LeaveRequest::when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'CEO' || $RolePermission == 'BOD' || $RolePermission == 'BM' || $RolePermission == 'HOD'){
                $query->where("next_approver", Auth::user()->id);
                $query->whereIn("status", ["rejected_hod","rejected_lm"]);
            }else{
                $query->whereIn("status", ["rejected","rejected_hod","rejected_lm"]);
            }
        })->count();
        $leaveCancel = LeaveRequest::where("status","cancel")
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'CEO' || $RolePermission == 'BOD' || $RolePermission == 'BM' || $RolePermission == 'HOD'){
                $query->whereJsonContains("approved_by", Auth::user()->id);
                $query->where("status", "cancel");
            }else if($RolePermission == 'HR'){
                $query->where("status", "cancel");
            }
        })->count();

        $totalStaff =  User::with("gender")->with("position")->whereIn('emp_status',['1','2','10','Probation'])
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'BM'){
                $query->where("branch_id", Auth::user()->branch_id);
            }else if($RolePermission == 'HOD'){
                $query->whereIn("department_id",  EmployeeRepository::getRoleHOD());
            }
        })->get();
        $staffPromotes = StaffPromoted::with("employee")->join('users', 'staff_promoteds.employee_id', '=', 'users.id')
            ->select(
                'staff_promoteds.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
                'users.department_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'Employee') {
                    $query->where("users.id", Auth::user()->id);
                }
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
            })->count();
        $transferred = Transferred::with("employee")->with("branch")->with("position")->join('users', 'transferreds.employee_id', '=', 'users.id')
            ->select(
                'transferreds.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.branch_id',
                'users.department_id',
            )
            ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                if ($RolePermission == 'Employee') {
                    $query->where("users.id", Auth::user()->id);
                }
                if ($RolePermission == 'HOD') {
                    $query->whereIn("users.department_id", EmployeeRepository::getRoleHOD());
                }
                if ($RolePermission == 'BM') {
                    $query->where("users.branch_id", Auth::user()->branch_id);
                }
        })->count();

         // $dataTrainings = Training::whereYear("created_at", $yearLy)->get();
      
        $dataTrainings = Training::get();
        $dataEmployeeTrainings = [];
        foreach ($dataTrainings as $key => $item) {
                $users = User::whereIn('id', $item->employee_id)
                ->select("number_employee","employee_name_kh", "employee_name_en", "branch_id")
                ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
                    if($RolePermission == 'BM'){
                        $query->where("branch_id", Auth::user()->branch_id);
                    }else if($RolePermission == 'HOD'){
                        $query->where("department_id",  EmployeeRepository::getRoleHOD());
                    }
                })->with('branch')->get();
            $dataEmployeeTrainings[] = [
                "training_type"=> $item->training_type,
                "employee"=> $users,
            ];
        }
        $empUpcoming = User::where("emp_status","Upcoming")
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if($RolePermission == 'BM'){
                $query->where("branch_id", Auth::user()->branch_id);
            }else if($RolePermission == 'HOD'){
                $query->whereIn("department_id",  EmployeeRepository::getRoleHOD());
            }
        })->count();

        $candidateResumes = CandidateResume::whereNot("status","5")->count();

        return response()->json([
            'options'=>$options,
            'position_type'=>$position_type,
            'branches'=>$branches,
            'data'=>$employee,
            'staffResignations'=>$staffResignations,
            'recruitmentPlans'=>$recruitmentPlans,
            'achieveBranchs'=>$achieveBranchs,
            'staffPromotes'=>$staffPromotes,
            'transferred'=> $transferred,
            'totalStaff'=> $totalStaff,
            'dataTrainings'=> $dataTrainings,
            "candidateResumes"=>$candidateResumes,
            "empUpcoming"=>$empUpcoming,
            'dataEmployeeTrainings'=> $dataEmployeeTrainings,
            'leavePending'      => $leavePending,
            'leaveApproval'     => $leaveApproval,
            'leaveReject'       => $leaveReject,
            'leaveCancel'       => $leaveCancel,
        ]);
    }
}
