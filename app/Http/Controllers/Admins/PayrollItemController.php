<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PayrollAdjustment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdjustmentRequest;

class PayrollItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (permissionAccess("m4-s6","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $employee = User::all();
        $data = PayrollAdjustment::orderBy('id','DESC')->get();
        return view('payroll_item.index',compact('employee','data'));
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
    public function store(AdjustmentRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by']    = Auth::user()->id;
            PayrollAdjustment::create($data);
            DB::commit();
            Toastr::success('Payroll Adjustments created successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Payroll Adjustments created fail.','Error');
        }
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
    public function edit(Request $request)
    {
        $employee = User::whereIn('emp_status',['Probation','1','2','10'])->get();
        $data = PayrollAdjustment::where('id',$request->id)->first();
        return response()->json([
            'success'=>$data,
            'employee'=>$employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            PayrollAdjustment::where('id',$request->id)->update([
                'employee_id'    => $request->employee_id,
                'amount'    => $request->amount,
                'adjustment_date'    => $request->adjustment_date,
                'adjustment_type'    => $request->adjustment_type,
                'description'    => $request->description,
                'updated_by'    => Auth::user()->id,
            ]);
            DB::commit();
            Toastr::success('Payroll Adjustments updated successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Payroll Adjustments updated fail.','Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            PayrollAdjustment::destroy($request->id);
            Toastr::success('Payroll Adjustments deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Payroll Adjustments delete fail.','Error');
            return redirect()->back();
        }
    }
}
