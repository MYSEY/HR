<?php

use App\Models\permissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

function RolePermission($table_id,$permission_type_id)
{
    $id=Auth::user()->role_id;
    $role_permission = permissions::where('role_id',$id)->where('table_id',$table_id)->where('permission_type_id',$permission_type_id)->get();
    if(count($role_permission)>0){
        return true;
    }
}
function menu(){
    return $data=[
        [
            'name'=>'Main',
            'icon'=>'<i class="la la-dashboard"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=>'Dashboard',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Dashboard Admin',
                    'url'=>"dashboad/admin",
                    'table'=>1,
                    'permission'=>1
                ],
                [
                    'value'=>'Dashboard Employee',
                    'url'=>"dashboad/employee",
                    'table'=>2,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'Employee',
            'icon'=>'<i class="la la-user"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=>'Employees',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'All Employees',
                    'url'=>"users",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Leaves Employee',
                    'url'=>"employee/report",
                    'table'=>6,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'HR',
            'icon'=>'<i class="la la-key"></i> <span></span>',
            'value'=>'Roles Permissions',
            'table'=>4,
            'permission'=>1,
            'url'=>"role",
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-pie-chart"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=>'Reports',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Employee Reports',
                    'url'=>"employee/report",
                    'table'=>2,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-key"></i> <span> </span> <span class="menu-arrow"></span>',
            'value'=>'Configuration',
            'table'=>7,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Position',
                    'url'=>"position",
                    'table'=>7,
                    'permission'=>1
                ],
                [
                    'value'=>'Branch',
                    'url'=>"branch",
                    'table'=>8,
                    'permission'=>1
                ],
                [
                    'value'=>'Department',
                    'url'=>"department",
                    'table'=>6,
                    'permission'=>1
                ],
            ]
        ],
    ];
}
