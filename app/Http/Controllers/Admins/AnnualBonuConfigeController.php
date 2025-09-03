<?php

namespace App\Http\Controllers\Admins;

use App\Models\AnnualBonu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class AnnualBonuConfigeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AnnualBonu::all();
        return view('annual_bonus.index',compact('data'));
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
            $data['created_by']    = Auth::user()->id;
            AnnualBonu::create($data);
            Toastr::success('Annual bonus created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            Toastr::error('nnual bonus created fail.','Error');
            return redirect()->back();
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
        $data = AnnualBonu::findOrFail($id);
        return response()->json([
            'success'=>$data,
        ]);
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
        try {
            $data = $request->only(['criteria','discription','total_score', 'percentage','increasement_year']);
            $data['updated_by'] = Auth::user()->id;
            AnnualBonu::where('id', $request->id)->update($data);
            DB::commit(); // commit transaction
            Toastr::success('Annual bonus updated successfully.','Success');
            return redirect()->back();
        } catch (\Throwable $exp) {
            Toastr::error('nnual bonus created fail.','Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            AnnualBonu::destroy($id);
            Toastr::success('Annual bonus deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Annual bonus delete fail.','Error');
            return redirect()->back();
        }
    }
}
