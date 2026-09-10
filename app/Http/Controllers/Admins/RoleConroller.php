<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CategoryPermission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class RoleConroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission = permissions::where('role_id',Auth::user()->role_id)->where("url", "role")->first();
        if (!$permission || $permission->is_view != "1") {
            return view('upgrade.access_page');
        }
        $role=Role::with("useruse")->get();
        return view('roles.role_index', compact('role'));
    }
    public function filter(Request $request) {
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s');
        }
        if ($request->to_date) {
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s');
        }
        $role=Role::with("useruse")
        // ->where("created_by", Auth::user()->id)
        ->when($request->role_name, function ($query, $role_name) {
            $query->where('role_name', 'LIKE', '%'.$role_name.'%');
        })
        ->when($request->role_type, function ($query, $role_type) {
            $query->where('role_type', $role_type);
        })
        ->when($from_date, function ($query, $from_date) {
            $query->where('created_at', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('created_at','<=', $to_date);
        })
        ->get();
        
        return response()->json(['role'=>$role]);
    }
    public function formCreate() {
        $permission = CategoryPermission::get();
        return view('roles.form_create', compact('permission'));
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
        DB::beginTransaction();
        try{
            Activity::all()->last();
            $role = Role::create([
                'role_name'     => $request->role_name,
                'role_type'     => $request->role_type,
                'status'        => 1,
                'created_by'    => Auth::user()->id
            ]);
            if ($request->role_permission) {
                foreach ($request->role_permission as $key => $item) {
                    foreach ($item["permission"] as $key => $per) {
                        if ($per["name"] == "lang.admin_dashboard") {
                            $per['is_dashboard'] = json_encode($per);
                        }
                        $per['parent_id'] = $request->parent_id;
                        $per['role_id'] = $role->id;
                        $per['is_active'] = 1;
                        permissions::create($per);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'message'=>"successfully",
                'status'=>200
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        } 
    }

    public function createPermission(Request $request) {
        DB::beginTransaction();
        try{
            Activity::all()->last();
            $role = Role::create([
                'role_name'     => $request->role_name,
                'role_type'     => $request->role_type,
                'status'        => 1,
                'created_by'    => Auth::user()->id
            ]);
           
            if ($request->role_permission) {
                
                foreach ($request->role_permission as $key => $item) {
                    
                    foreach ($item["permission"] as $key => $per) {
                        $menuPermission =  permissions::where("role_id", $role->id)->where("sub_menu_id", $per["sub_menu_id"])->count();
                        $permissionTypes =  DB::table("permission_types")->where("menu_id", $per["sub_menu_id"])->first();
                        if ($menuPermission == 0) {
                            $menuData["name"] = $permissionTypes->name;
                            $menuData["menu_id"] = $permissionTypes->menu_id;
                            $menuData["icon"] = $permissionTypes->icon;
                            $menuData["is_all"] = $permissionTypes->is_all;
                            $menuData['role_id'] = $role->id;
                            $menuData['is_active'] = 1;
                            $menuData['parent_id'] = $request->parent_id;
                            permissions::create($menuData);
                        }
                        if ($per["url"] == "dashboad/admin") {
                            $per['is_dashboard'] = json_encode($per);
                        }
                        $per['parent_id'] = $request->parent_id;
                        $per['role_id'] = $role->id;
                        $per['is_active'] = 1;
                        permissions::create($per);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'message'=>"successfully",
                'status'=>200
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        } 
    }
    public function updatePermission(Request $request) {
        DB::beginTransaction();
        try{
            Activity::all()->last();
            $data = Role::find($request->id);
            $data['role_name']     = $request->role_name;
            $data['role_type']     = $request->role_type;
            $data['updated_by']    = Auth::user()->id;
            $data->save();
            permissions::where('role_id',$request->id)->delete();
           
            if ($request->role_permission) {
                foreach ($request->role_permission as $key => $item) {
                    foreach ($item["permission"] as $key => $per) {
                        $menuPermission =  permissions::where("role_id", $request->id)->where("sub_menu_id", $per["sub_menu_id"])->count();
                        $permissionTypes =  DB::table("permission_types")->where("menu_id", $per["sub_menu_id"])->first();
                        if ($menuPermission == 0) {
                            $menuData["name"] = $permissionTypes->name;
                            $menuData["menu_id"] = $permissionTypes->menu_id;
                            $menuData["icon"] = $permissionTypes->icon;
                            $menuData["is_all"] = $permissionTypes->is_all;
                            $menuData['role_id'] = $request->id;
                            $menuData['is_active'] = 1;
                            $menuData['parent_id'] = $request->parent_id;
                            permissions::create($menuData);
                        }
                        if ($per["url"] == "dashboad/admin") {
                            $per['is_dashboard'] = json_encode($per);
                        }
                        $per['parent_id'] = $request->parent_id;
                        $per['role_id'] = $request->id;
                        $per['is_active'] = 1;
                        permissions::create($per);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'message'=>"successfully",
                'status'=>200
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
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
    public function show()
    {
        $dataRoles = Role::get();
        return response()->json([
            'data'=>$dataRoles,
            'status'=>200
        ]);
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
        $permissions = permissions::where("role_id", $request->id)->get()->toArray();
        $categoryPermission = CategoryPermission::get();
        $arrayPermissions = [];
        foreach ($permissions as $row) {
            $arrayPermissions[$row["name"]] = $row;
        }
        return view('roles.form_edit', compact('role','arrayPermissions', 'categoryPermission'));
    }

    public function updateRole(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = Role::find($request->id);
            $data['role_name']     = $request->role_name;
            $data['role_type']     = $request->role_type;
            $data['updated_by']    = Auth::user()->id;
            $data->save();
            permissions::where('role_id',$request->id)->delete();
            if ($request->role_permission) {
                foreach ($request->role_permission as $key => $item) {
                    foreach ($item["permission"] as $key => $per) {
                        if ($per["name"] == "lang.admin_dashboard") {
                            $per['is_dashboard'] = json_encode($per);
                        }
                        $per['parent_id'] = $request->parent_id;
                        $per['role_id'] = $request->id;
                        $per['created_by'] = Auth::user()->id;
                        $per['updated_by'] = Auth::user()->id;
                        permissions::create($per);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'message'=>"Update role successfully",
                'status'=>200
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
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
    public function processing(Request $request)
    {
        DB::beginTransaction();
        try {
            Role::where('id',$request->id)->update([
                'status' => $request->role_status,
            ]);
            permissions::where('role_id',$request->id)->update([
                'is_active' => $request->role_status,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'The process has been successfully.'
            ]);
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json(['message' => $exp->getMessage()], 500);
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
            permissions::destroy("role_id", $request->id);
            Toastr::success('Role Name deleted successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Role Name delete fail','Error');
            return redirect()->back();
        }
    }
}
