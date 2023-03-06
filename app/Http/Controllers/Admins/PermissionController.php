<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql="SELECT t.id,t.name,(SELECT COUNT(*) 
        FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=1 and p_view.role_id=$request->role_id) as _view,(SELECT COUNT(*) 
        FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=2 and p_view.role_id=$request->role_id) as _add,(SELECT COUNT(*) 
        FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=3 and p_view.role_id=$request->role_id) as _update,(SELECT COUNT(*) 
        FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=4 and p_view.role_id=$request->role_id) as _delete ,(SELECT COUNT(*)
        FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=4 and p_view.role_id=$request->role_id) as _import, (SELECT COUNT(*)
        FROM permissions p_view WHERE p_view.status=1 and p_view.table_id=t.id and p_view.permission_type_id=4 and p_view.role_id=$request->role_id) as _export
        FROM tables t WHERE t.status=1";
        $role_permission=DB::select($sql);
        return response()->json(['success'=>$role_permission]);
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
        $data=[
            'table_id'              =>$request->table_id,
            'role_id'               =>$request->role_id,
            'permission_type_id'    =>$request->permission_type_id,
            'status'                =>1,
            'created_at'            =>now(),
            'updated_at'            =>now()
        ];
        if($request->checked==1){
            DB::table('permissions')->insert($data);
            Toastr::success('You have no permission to insert it !! :)','Success');
        }else{
            DB::table('permissions')->where(
                [
                    ['table_id','=',$data['table_id']],
                    ['role_id','=',$data['role_id']],
                    ['permission_type_id','=',$data['permission_type_id']]
                ]
            )->delete();
            Toastr::success('You have no permission to update it !! :)','Success');
        }
        // return response()->json(['success'=>'You have no permission to update it !!']);
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
    public function update(Request $request, $id)
    {
        //
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
