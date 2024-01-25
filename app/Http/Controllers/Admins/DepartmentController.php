<?php

namespace App\Http\Controllers\Admins;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Department::where("parent_id", 0)->orWhere("parent_id", null)->with('child')->orderBy('id','DESC')->get();
        return view('department.index',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try {
            Activity::all()->last();
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $data['head_department'] = Auth::user()->id;
            Department::create($data);
            Toastr::success('Department created successfully.','Success');
            return redirect()->back();
            DB::commit();
        } catch (\Throwable $exp) {
            DB::rollBack();
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
        $data = Department::find($id);
        return view('department.edit',compact('data'));
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
            $data = Department::find($request->id);
            $data['parent_id']  = $request->parent_id ? $request->parent_id : null;
            $data['name_khmer']  = $request->name_khmer;
            $data['name_english']  = $request->name_english;
            $data['updated_by']  = Auth::user()->id;
            $data->save();
            Toastr::success('Department Updated successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Department Updated fail.','Error');
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
            Department::destroy($request->id);
            Toastr::success('Department deleted successfully.','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Department delete fail.','Error');
            return redirect()->back();
        }
    }
}