<?php

namespace App\Http\Controllers\Admins;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ExchangeRate::orderBy('change_date','desc')->get();
        return view('exchange_rates.index',  compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            if ($request->id) {
                $data = ExchangeRate::find($request->id);
                $data->update([
                    'amount_usd' => $request->amount_usd,
                    'amount_riel' => $request->amount_riel,
                    'change_date' => $request->change_date,
                    'type'        => $request->type,
                    'updated_by' => Auth::user()->id 
                ]);
            }else{
                $data = ExchangeRate::create([
                    'amount_usd' => $request->amount_usd,
                    'amount_riel' => $request->amount_riel,
                    'change_date' => $request->change_date,
                    'type'        => $request->type,
                    'updated_by' => Auth::user()->id 
                ]);
            }
            return response()->json(['success'=>$data]);
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Exchange rate fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Activity::all()->last();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            ExchangeRate::create($data);
            Toastr::success('Exchange rate created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Exchange rate created fail.','Error');
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
        $data = ExchangeRate::where('id',$request->id)->first();
        return response()->json(['success'=>$data]);
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
            $data = ExchangeRate::find($request->id);
            $data['amount_usd'] = $request->amount_usd;
            $data['amount_riel'] = $request->amount_riel;
            $data['change_date'] = $request->change_date;
            $data['type']        = $request->type;
            $data['updated_by'] = Auth::user()->id;
            $data->save();
            Toastr::success('Exchange rate successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Exchange rate fail.','Error');
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
            ExchangeRate::destroy($request->id);
            Toastr::success('Exchange rate deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Exchange rate delete fail.','Error');
            return redirect()->back();
        }
    }
}
