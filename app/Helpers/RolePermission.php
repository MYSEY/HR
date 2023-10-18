<?php

use App\Helpers\Helper;
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
    // $valuePayroll = nl2br("Compensation and\r\nBenefits");
    // dd($valuePayroll);
    return $data=[
        [
            'name'=> Helper::getLang() == 'en' ? 'HR Management System': 'ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្ស',
            'icon'=>'<i class="la la-dashboard"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Dashboard': 'ផ្ទាំងគ្រប់គ្រង',
            'table'=>2,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Admin Dashboard': "ផ្ទាំងគ្រប់គ្រង",
                    'url'=>"dashboad/admin",
                    'table'=>1,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Employee Dashboard': "ផ្ទាំងគ្រប់គ្រងបុគ្គលិក",
                    'url'=>"dashboad/employee",
                    'table'=>2,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>"",
            'icon'=>'<i class="la la-user"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Employee': "បុគ្គលិក",
            'table'=>3,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'All Employee': "បុគ្គលិកទាំងអស់",
                    'url'=>"users",
                    'table'=>3,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Leaves Employee': "ការចាកចេញពីបុគ្គលិក",
                    'url'=>"leaves/employee",
                    'table'=>12,
                    'permission'=>1
                ]
            ]
        ],
        [
            
            'name'=>'',
            'icon'=>'<i class="la la-briefcase"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Recruitment': 'ការជ្រើសរើសបុគ្គលិក',
            'table'=>7,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Candidate CV': 'CV បេក្ខជន',
                    'url'=>"recruitment/candidate-resume/list",
                    'table'=>8,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Recruitment Plan': 'ផែនការជ្រើសរើសបុគ្គលិក',
                    'url'=>"recruitment/plan-list",
                    'table'=>7,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-money"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'C&B' :'សំណងនិងអត្ថប្រយោជន៍',
            'table'=>4,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Employee Salary': 'ប្រាក់បៀវត្សរ៍បុគ្គលិក',
                    'url'=>"payroll",
                    'table'=>4,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-motorcycle"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Motor Rental': 'ការជួលម៉ូតូ',
            'table'=>5,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Motor Rental':'ការជួលម៉ូតូ',
                    'url'=>"motor-rentel/list",
                    'table'=>5,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Pay Motor Rental': 'បង់ថ្លៃជួលម៉ូតូ',
                    'url'=>"motor-rentel/pay",
                    'table'=>6,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-edit"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Training': 'វគ្គបណ្តុះបណ្តាល',
            'table'=>9,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Trainer':'គ្រូបង្វឹក',
                    'url'=>"trainer/list",
                    'table'=>9,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Training List': 'បញ្ជីបណ្តុះបណ្តាល',
                    'url'=>"training/list",
                    'table'=>10,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Training Report':'របាយការណ៍បណ្តុះបណ្តាល',
                    'url'=>"reports/training-report",
                    'table'=>11,
                    'permission'=>1
                ]
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-pie-chart"></i> <span></span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Report': 'របាយការណ៍',
            'table'=>17,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Employee Report': 'របាយការណ៍បុគ្គលិក',
                    'url'=>"reports/employee-report",
                    'table'=>17,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Payroll Report':'របាយការណ៍ប្រាក់បៀវត្សរ៍បុគ្គលិក',
                    'url'=>"reports/payroll-report",
                    'table'=>18,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Bank Transfer Report':'របាយការណ៍ការផ្ទេរប្រាក់តាមធនាគារ',
                    'url'=>"reports/bank-transfer",
                    'table'=>18,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'E-Filing Report':'របាយការណ៍ E-Filing',
                    'url'=>"reports/e-filing",
                    'table'=>19,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'E-Form Report':'របាយការណ៍ E-Form',
                    'url'=>"reports/e-form",
                    'table'=>19,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Motor Rental Report': 'របាយការណ៍ជួលម៉ូតូ',
                    'url'=>"reports/motor-rentel-report",
                    'table'=>20,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'New Staff Report': 'របាយការណ៍បុគ្គលិកថ្មី',
                    'url'=>"reports/new_staff-report",
                    'table'=>21,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Staff Resigned Report': 'របាយការណ៍លាឈប់បុគ្គលិក',
                    'url'=>"reports/staff-resigned-report",
                    'table'=>22,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Promoted Staff Report': 'របាយការណ៍បុគ្គលិកដែលត្រូវបានតំឡើង',
                    'url'=>"reports/promoted-staff-report",
                    'table'=>23,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Transferred Staff Report': 'របាយការណ៍បុគ្គលិកដែលត្រូវបានផ្ទេរ',
                    'url'=>"reports/transferred-staff-report",
                    'table'=>24,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-key"></i> <span> </span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Configuration':'ការកំណត់​រចនាសម្ព័ន្ធ',
            'table'=>24,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Tax':'ពន្ធ',
                    'url'=>"taxes",
                    'table'=>24,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Exchange Rate':'អត្រា​ប្តូ​រ​ប្រាក់',
                    'url'=>"exchange-rate/list",
                    'table'=>25,
                    'permission'=>1
                ],
                
                [
                    'value'=> Helper::getLang() == 'en' ? 'Public Holiday':'ថ្ងៃឈប់​សំរាក​សាធារណៈ',
                    'url'=>"holidays",
                    'table'=>12,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Children Allowance': 'ប្រាក់ឧបត្ថម្ភកូន',
                    'url'=>"children/allowance",
                    'table'=>26,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-cog"></i> <span> </span> <span class="menu-arrow"></span>',
            'value'=> Helper::getLang() == 'en' ? 'Setting':'ការកំណត់',
            'table'=>13,
            'permission'=>1,
            'child'=>[
                [
                    'value'=> Helper::getLang() == 'en' ? 'Bank':'ធនាគារ',
                    'url'=>"bank",
                    'table'=>13,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Position' : 'តួនាទី',
                    'url'=>"position",
                    'table'=>15,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Branch' : 'សាខា',
                    'url'=>"branch",
                    'table'=>16,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Department' :'នាយកដ្ឋាន',
                    'url'=>"department",
                    'table'=>14,
                    'permission'=>1
                ],
                [
                    'value'=> Helper::getLang() == 'en' ? 'Forgot Password' : 'ភ្លេច​លេខសម្ងាត់​',
                    'url'=>"change/password",
                    'table'=>27,
                    'permission'=>1
                ],
            ]
        ],
        [
            'name'=>'',
            'icon'=>'<i class="la la-key"></i> <span></span>',
            'value'=> Helper::getLang() == 'en' ? 'Roles Permission' : 'ការអនុញ្ញាតតួនាទី',
            'table'=>6,
            'permission'=>1,
            'url'=>"role",
        ],
    ];
}
