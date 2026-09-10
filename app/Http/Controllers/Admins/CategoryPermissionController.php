<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\CategoryPermission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Contracts\Activity;

class CategoryPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CategoryPermission::with("menu")->get();
        $permissiontypes = DB::table("permission_types")->get();
        return view('permission_categories.index',compact(['data','permissiontypes']));
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
            $menu_id = $request->permission["sub_menu_id"];
            $dubp = CategoryPermission::where("sub_menu_id",$menu_id)->where("url", $request->permission["url"])->first();
            if ($dubp) {
                return response()->json([
                    'message'=>"Category permission already  exit!",
                    'status'=>400
                ]);
            }
            $cate = CategoryPermission::where("sub_menu_id",$menu_id)->count();
            $permissionTypes =  DB::table("permission_types")->where("menu_id", $menu_id)->first();
            if (empty($cate)) {
                $sub_id = 1;  
            }else{
                $sub_id = $cate+1;
            }
            $menu_id = "m".$permissionTypes->menu_id."-s".$sub_id;
            if ($request->permission["url"] =="dashboad/admin") {
                $data['is_dashboard'] = json_encode($request->permission);
            }else{
                $permission = Arr::except($request->permission, ['name', 'sub_menu_id', 'menu_id', 'url']);
                foreach ($permission as $key => $value) {
                    $data[$key] = $value;
                }
            }
            $data['name'] = $request->permission["name"];
            $data['menu_id'] = $menu_id;
            $data['icon'] = $permissionTypes->icon;
            $data['is_all'] = 1;
            $data['url'] = $request->permission["url"];
            $data['sub_menu_id'] = $request->permission["sub_menu_id"];
            $data['is_active'] = 1;
            $data['created_by'] = Auth::user()->id;
            CategoryPermission::create($data);
            DB::commit();
            return response()->json([
                'message'=>"successfully",
                'status'=>200
            ]);
           
        } catch (\Throwable $exp) {
            DB::rollback();
            return response()->json(['message' => $exp->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = CategoryPermission::with("menu")->where("id", $request->id)->first();
        $permissiontypes = DB::table("permission_types")->get();
        return response()->json([
            'permissiontypes' => $permissiontypes,
            'data' => $data,
        ]);
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
        // try {
            $menu_id = $request->permission["sub_menu_id"];
            $permissionTypes =  DB::table("permission_types")->where("menu_id", $menu_id)->first();
            $data = CategoryPermission::where('id',$request->id)->first();
            if ($data->sub_menu_id != $menu_id) {
                $dubp = CategoryPermission::where("sub_menu_id",$menu_id)->where("url", $request->permission["url"])->first();
                if ($dubp) {
                    return response()->json([
                        'message'=>"Category permission already  exit!",
                        'status'=>400
                    ]);
                }else{
                    $cate = CategoryPermission::where("sub_menu_id",$menu_id)->count();
                    if (empty($cate)) {
                        $sub_id = 1;  
                    }else{
                        $sub_id = $cate+1;
                    }
                    $menu_id = "m".$permissionTypes->menu_id."-s".$sub_id;
                }
               
            }
            if ($request->permission["url"] =="dashboad/admin") {
                $data['is_dashboard'] = json_encode($request->permission);
            }else{
                $permission = Arr::except($request->permission, [
                'name', 'sub_menu_id', 'menu_id', 'url',
                "is_leave" ,
                "is_total_resigned_staff" ,
                "is_promoted_staff" ,
                "is_transferred_staff" ,
                "is_training" ,
                "is_employee" ,
                "is_age_of_employee" ,
                "is_birthday_reminder" ,
                "is_total_number_of_staff" ,
                "is_total_inactive_staff" ,
                "is_resigned_staff" ,
                "is_reasons_of_staff" ,
                "is_staff_ratio" ,
                "is_staff_taking_leave" ,
                "is_staff_training_internal" ,
                "is_staff_training_external" ,
            ]);
                foreach ($permission as $key => $value) {
                    $data[$key] = $value;
                }
            }
            $data['name'] = $request->permission["name"];
            $data['menu_id'] = $menu_id;
            $data['icon'] = $permissionTypes->icon;
            $data['is_all'] = 1;
            $data['url'] = $request->permission["url"];
            $data['sub_menu_id'] = $request->permission["sub_menu_id"];
            $data['is_active'] = 1;
            $data['updated_by'] = Auth::user()->id;
            unset($data->permission);
            $data->save();
            
            DB::commit();
            return response()->json([
                'message'=>"Update successfully",
                'status'=>200
            ]);
           
        // } catch (\Throwable $exp) {
        //     DB::rollback();
        //     return response()->json(['message' => $exp->getMessage()], 500);
        // }
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
            CategoryPermission::destroy($request->id);
            Toastr::success('Deleted successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Role Name delete fail','Error');
            return redirect()->back();
        }
    }
}
