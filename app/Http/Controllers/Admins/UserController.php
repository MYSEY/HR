<?php

namespace App\Http\Controllers\Admins;

use App\Models\Role;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdated;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Option;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('role')->with('department')->get();
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionStatus = Option::where('type','status')->get();
        return view('users.index',compact('data','role','position','department','optionStatus'));
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
    public function store(UserRequest $request)
    {
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalName();
            $image->move(public_path('uploads/images'), $filename);
        }
        try{
            $data = $request->all();
            $data['password']   = Hash::make($request->password);
            $data['profile']    = $filename;
            User::create($data);
            DB::commit();
            Toastr::success('Create new account successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User add new account fail :)','Error');
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
        $data = User::where('id',$request->id)->with('role')->first();
        $role = Role::all();
        $position = Position::all();
        $department = Department::all();
        $optionStatus = Option::where('type','status')->get();
        return response()->json(['success'=>$data,'role'=>$role,'position'=>$position,'department'=>$department,'optionStatus'=>$optionStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdated $request)
    {
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalName();
            $image->move(public_path('uploads/images'), $filename);
        }else{
            $filename = $request->hidden_image;
        }
        try{
            User::where('id',$request->id)->update([
                'name'  => $request->name,
                'email'  => $request->email,
                'role_id'  => $request->role_id,
                'position_id'  => $request->position_id,
                'phone'  => $request->phone,
                'department_id'  => $request->department_id,
                'status'  => $request->status,
                'profile'  => $filename
            ]);
            Toastr::success('Updated account successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User update fail :)','Error');
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
            User::destroy($request->id);
            if ($request->profile) {
                unlink('uploads/images/'.$request->profile);
            }
            Toastr::success('User deleted successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User delete fail :)','Error');
            return redirect()->back();
        }
    }
}
