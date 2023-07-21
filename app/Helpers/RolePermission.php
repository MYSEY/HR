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
            'value'=>'Employee',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'All Employee',
                    'url'=>"users",
                    'table'=>3,
                    'permission'=>1
                ],
                [
                    'value'=>'Leaves Employee',
                    'url'=>"leaves/employee",
                    'table'=>12,
                    'permission'=>1
                ]
            ]
        ],
        [
            'name'=>'HR',
            'icon'=>'<i class="la la-money"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=>'Payroll',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Employee Salary',
                    'url'=>"payroll",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Motor Rental',
                    'url'=>"motor-rentel/list",
                    'table'=>2,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-briefcase"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=>'Recruitment',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Recruitment Plan',
                    'url'=>"recruitment/plan-list",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Candidate CV',
                    'url'=>"recruitment/candidate-resume/list",
                    'table'=>2,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-edit"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=>'Training',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Training List',
                    'url'=>"training/list",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Trainer',
                    'url'=>"trainer/list",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Training Report',
                    'url'=>"reports/training-report",
                    'table'=>2,
                    'permission'=>1
                ],
                // [
                //     'value'=>'Training Type',
                //     'url'=>"training-type/list",
                //     'table'=>2,
                //     'permission'=>1
                // ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-pie-chart"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=>'Report',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Employee Report',
                    'url'=>"reports/employee-report",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Payroll Report',
                    'url'=>"reports/payroll-report",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Motor Rental Report',
                    'url'=>"reports/motor-rentel-report",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'New Staff Report',
                    'url'=>"reports/new_staff-report",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Staff Resigned Report',
                    'url'=>"reports/staff-resigned-report",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Promoted Staff Report',
                    'url'=>"reports/promoted-staff-report",
                    'table'=>2,
                    'permission'=>1
                ],
                [
                    'value'=>'Transferred Staff Report',
                    'url'=>"reports/transferred-staff-report",
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
                    'value'=>'Taxe',
                    'url'=>"taxes",
                    'table'=>7,
                    'permission'=>1
                ],
                [
                    'value'=>'Exchange Rate',
                    'url'=>"exchange-rate/list",
                    'table'=>7,
                    'permission'=>1
                ],
                
                [
                    'value'=>'Public Holiday',
                    'url'=>"holidays",
                    'table'=>6,
                    'permission'=>1
                ],
                [
                    'value'=>'Children Allowance',
                    'url'=>"children/allowance",
                    'table'=>6,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-cog"></i> <span> </span> <span class="menu-arrow"></span>',
            'value'=>'Setting',
            'table'=>7,
            'permission'=>1,
            'child'=>[
                [
                    'value'=>'Bank',
                    'url'=>"bank",
                    'table'=>7,
                    'permission'=>1
                ],
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
                [
                    'value'=>'Change Password',
                    'url'=>"change/password",
                    'table'=>6,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-key"></i> <span></span>',
            'value'=>'Roles Permission',
            'table'=>6,
            'permission'=>1,
            'url'=>"role",
        ],
    ];
}
