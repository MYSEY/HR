<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ExportMotorRentel;
use App\Http\Controllers\Controller;
use App\Models\Branchs;
use App\Models\MotorRentel;
use App\Models\Payroll;
use App\Models\User;
use App\Repositories\Admin\MotorRentalRepository;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PayrollReportController extends Controller
{
    private $dataMotor;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(MotorRentalRepository $dataMotors)
    {
        $this->dataMotor = $dataMotors;
    }
    public function index()
    {
        $payroll = Payroll::with('users')->get();
        return view('reports.payroll_report',compact('payroll'));
    }

    public function motorrentel(Request $request)
    {
        $data = $this->dataMotor->getDatas($request);
        $branchs = Branchs::get();
        if ($request->research) {
            return response()->json(['data'=>$data]);
        }else {
            return view('reports.motor_rentel_report', compact('data', 'branchs'));
        }
    }

    public function export(Request $request)
    {
        $data = $this->dataMotor->getDatas($request);
        return Excel::download(new ExportMotorRentel($data), 'MotorRentel.xlsx');
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
