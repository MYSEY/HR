<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ExchangeRate::all();
        return view('exchange_rates.index',  compact('data'));
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
        try {
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
    public function update(Request $request)
    {
        try{
            ExchangeRate::where('id',$request->id)->update([
                'currency' => $request->currency,
                'amount' => $request->amount,
                'description' => $request->description,
                'updated_by' => Auth::user()->id 
            ]);
            Toastr::success('Exchange rate Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Exchange rate Updated fail.','Error');
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
