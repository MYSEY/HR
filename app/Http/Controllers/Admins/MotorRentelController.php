<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\MotorRentel;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class MotorRentelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MotorRentel::orderBy('id', 'desc')->get();
        $employees = User::all();
        return view('motor_rentels.index', compact('data','employees'));
    }

    public function detail(Request $request)
    {
        $data = MotorRentel::where("id", $request->id)->first();
        // $employees = User::all();
        return view('motor_rentels.detail', compact('data'));
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
            // $product_year = Carbon::createFromDate($request->product_year)->format('Y');
            // $expried_year = Carbon::createFromDate($request->expired_year)->format('Y');
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            MotorRentel::create($data);
            Toastr::success('Created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Created fail.','Error');
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
        $data = MotorRentel::where("id", $request->id)->first();
        $employee = User::all();
        return response()->json([
            'success'=>$data,
            'employee'=>$employee,
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
        try{
            $dataUpdate = [
                'employee_id' => $request->employee_id,
                'gasoline_price_per_liter' => $request->gasoline_price_per_liter,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'product_year' => $request->product_year,
                'expired_year' => $request->expired_year,
                'shelt_life' => $request->shelt_life,
                'total_gasoline' => $request->total_gasoline,
                'total_work_day' => $request->total_work_day,
                'price_engine_oil' => $request->price_engine_oil,
                'price_motor_rentel' => $request->price_motor_rentel,
                'tax_rate' => $request->tax_rate,
                'updated_by' => Auth::user()->id 
            ];
            MotorRentel::where('id',$request->id)->update($dataUpdate);
            Toastr::success('Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Updated fail.','Error');
            return redirect()->back();
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
            MotorRentel::destroy($request->id);
            Toastr::success('Deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Delete fail.','Error');
            return redirect()->back();
        }
    }
}
