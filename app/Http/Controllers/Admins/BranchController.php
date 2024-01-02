<?php

namespace App\Http\Controllers\Admins;

use App\Models\Branchs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BranchsRequest;
use Spatie\Activitylog\Models\Activity;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Branchs::all();
        return view('branchs.index',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchsRequest $request)
    {
        try {
            Activity::all()->last();
            $data = $request->all();
            $data['created_by']    = Auth::user()->id;
            Branchs::create($data);
            Toastr::success('Branch created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            Toastr::error('Branch created fail.','Error');
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
    public function edit(Request $request)
    {
        $data = Branchs::where('id',$request->id)->first();
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
    public function update(Request $request)
    {
        try{
            $data = Branchs::find($request->id);
            $data['branch_name_kh'] = $request->branch_name_kh;
            $data['branch_name_en'] = $request->branch_name_en;
            $data['updated_by'] = Auth::user()->id ;
            $data->save();
            Activity::all()->last();
            Toastr::success('Branch updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Branch updated fail.','Error');
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
            Branchs::destroy($request->id);
            Toastr::success('Branch deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Branch delete fail.','Error');
            return redirect()->back();
        }
    }
}
