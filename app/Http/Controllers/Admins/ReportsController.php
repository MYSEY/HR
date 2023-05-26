<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\Position;
use App\Models\StaffPromoted;
use App\Models\Transferred;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function newStaff(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
        }
        $employees = User::with("gender")->with('position')->with('branch')
        ->where("emp_status",'Probation')
        ->when($from_date, function ($query, $from_date) {
            $query->where('date_of_commencement', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('date_of_commencement','<=', $to_date);
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('branch_id', $branch_id);
        })
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
            $query->where('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
        })
        ->get();

        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['employees'=>$employees]);
        }else {
            return view('reports.new_staff_report', compact('employees', 'branch'));
        }
    }
    public function staffResigned(Request $request){
        $join_date = null;
        $leave_of_absence = null;
        if ($request->join_date) {
            $join_date = Carbon::createFromDate($request->join_date)->format('Y-m-d H:i:s');
        }
        if ($request->leave_of_absence) {
            $leave_of_absence = Carbon::createFromDate($request->leave_of_absence)->format('Y-m-d H:i:s');
        }

        $employees = User::with("gender")->with('position')->with('branch')
            ->whereNotIn('emp_status',['1','2','Probation'])
            ->when($join_date, function ($query, $join_date) {
                $query->where('date_of_commencement', '>=', $join_date);
            })
            ->when($leave_of_absence, function ($query, $leave_of_absence) {
                $query->where('resign_date', '>=', $leave_of_absence);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                $query->where('branch_id', $branch_id);
            })
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })->get();
        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['employees'=>$employees]);
        }else {
            return view('reports.staff_resigned_report', compact('employees', 'branch'));
        }
    }
    public function staffPromoted(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d H:i:s');
        }

        $staffPromotes = StaffPromoted::with("employee")->join('users', 'staff_promoteds.employee_id', '=', 'users.id')
            ->select(
                'staff_promoteds.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
            )
            ->when($from_date, function ($query, $from_date) {
                $query->where('date', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('date','<=', $to_date);
            })
            ->when($request->branch_id, function ($query, $branch_id) {
                $query->where('users.branch_id', $branch_id);
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })->get();
        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['staffPromotes'=>$staffPromotes]);
        }else {
            return view('reports.staff_promoted_report', compact('staffPromotes', 'branch'));
        }
    }
    public function staffTransferred(Request $request){
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d H:i:s');
        }

        $transferred = Transferred::with("employee")->with("branch")->with("position")->join('users', 'transferreds.employee_id', '=', 'users.id')
            ->select(
                'transferreds.*',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($from_date, function ($query, $from_date) {
                $query->where('date', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('date','<=', $to_date);
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })->get();
        $branch = Branchs::all();
        if ($request->research) {
            return response()->json(['transferred'=>$transferred]);
        }else {
            return view('reports.staff_transferred_report', compact('transferred', 'branch'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
