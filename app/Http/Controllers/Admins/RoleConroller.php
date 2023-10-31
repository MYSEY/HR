<?php

namespace App\Http\Controllers\Admins;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\permissions;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class RoleConroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!RolePermission(3,1)){
            return view('errors.no-permission');
        }
        $sql="SELECT t.id,t.name,(SELECT COUNT(*) FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=1) as _view,(SELECT COUNT(*) FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=2) as _add,(SELECT COUNT(*) FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=3) as _update,(SELECT COUNT(*) FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=4) as _delete FROM tables t WHERE t.status=1";
        $permissionList=DB::select($sql);
        $role=Role::where('status',1)->get();
        return view('roles.index',compact('role','permissionList'));
        // $role=Role::with("useruse")->where('status',1)->get();
        // return view('roles.role_index', compact('role'));
    }
    public function formCreate() {
        return view('roles.form_create');
    }

    public function detail(Request $request) {
        $role=Role::where('id',$request->id)->first();
        $user_use = User::where("role_id", $request->id)->get();
        return view('roles.role_detail', compact('role','user_use'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $role = Role::create([
            'role_name' => $request->role_name,
            'role_type' => $request->role_type,
            'status'    => 1,
            'created_by'    => Auth::user()->id
        ]);
       
        if ($request->role_permission) {
            foreach ($request->role_permission as $key => $item) {
                $items = [];
                foreach ($item["permission"] as $key => $per) {
                    $per['parent_id'] = $request->parent_id;
                    $per['role_id'] = $role->id;
                    $items[] = $per;
                    permissions::create($per);
                }
            }
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
        $request->validate([
            'role_name' => 'required|string|max:255',
            'role_type' => 'required|string|max:255',
        ]);
        try{
            Role::create([
                'role_name' => $request->role_name,
                'role_type' => $request->role_type,
                'status'    => 1,
                'created_by'    => Auth::user()->id
            ]);
            Toastr::success('Create new role successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Add new role fail','Error');
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
        $role=Role::where('id',$request->id)->first();
        $permissions = permissions::where("role_id", $request->id)->get();
        return view('roles.form_edit', compact('role','permissions'));
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
            Role::where('id',$request->id)->update([
                'role_name'  => $request->role_name,
                'role_type'  => $request->role_type,
                'status'    => 1,
                'updated_by'    => Auth::user()->id
            ]);
            Toastr::success('Updated role successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Add new employee fail','Error');
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
            Role::destroy($request->id);
            Toastr::success('Role Name deleted successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Role Name delete fail','Error');
            return redirect()->back();
        }
    }
}
