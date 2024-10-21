<?php

namespace App\Http\Controllers\Admins;

use App\Helpers\Helper;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (permissionAccess("m8-s5","is_view")->value != "1") {
            return view('upgrade.access_page');
        }
        $data = LeaveType::all();
        return view('leave_types.index',compact('data'));
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
            $duplicate = LeaveType::where("type",$request->type)->first();
            DB::commit();
            if ($duplicate) {
                Toastr::error('Leave type  already exists.','Error');
                return redirect()->back();
            }else{
                Activity::all()->last();
                $data = $request->all();
                $data['created_by'] = Auth::user()->id;
                LeaveType::create($data);
                Toastr::success('Leave type created successfully.','Success');
                return redirect()->back();
            }
        } catch (\Throwable $exp) {
            DB::rollback();
            Toastr::error('Leave type created fail.','Error');
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
        $data = LeaveType::where('id',$request->id)->first();
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
            $data = LeaveType::find($request->id);
            $data['name'] = $request->name;
            $data['default_day'] = $request->default_day;
            $data['updated_by'] = Auth::user()->id;
            $data->save();
            Toastr::success('Taxes Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Taxes Updated fail.','Error');
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
        //
    }
}
