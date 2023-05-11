<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\MotorRentel;
use Carbon\Carbon;
use Illuminate\Http\Request;
class PayrollReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.payroll_report');
    }

    public function motorrentel(Request $request)
    {
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        
        $data = MotorRentel::with('user')->join('users', 'motor_rentels.employee_id', '=', 'users.id')
            ->select(
                'motor_rentels.*',
                'users.employee_name_en',
                'users.employee_name_kh',
                'users.number_employee',
                'users.branch_id',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->orWhere('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
                $query->orWhere('users.employee_name_kh', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($request->branch_id, function ($query, $branch) {
                $query->where('users.branch_id', $branch);
            })
            ->when($from_date, function ($query, $from_date) {
                $query->where('motor_rentels.created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                $query->where('motor_rentels.created_at','<=', $to_date);
            })
            ->orderBy('id', 'desc')
            ->get();
        $branchs = Branchs::get();
        if ($request->research) {
            return response()->json(['data'=>$data]);
        }else {
            return view('reports.motor_rentel_report', compact('data', 'branchs'));
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
