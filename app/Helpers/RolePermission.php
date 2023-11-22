<?php

use App\Helpers\Helper;
use App\Models\permissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class dataMenu {
    public $menu;
    public $subMenu;
}
function RolePermission()
{
    $id=Auth::user()->role_id;
    $datas = new dataMenu();
    $datas->menu = permissions::where('role_id',$id)->where("sub_menu_id", null)->get()->toArray();
    $datas->subMenu = permissions::where('role_id',$id)->whereNot("sub_menu_id", null)->get()->toArray();
    return $datas;
}
class dataRolePermission{
    public $value;
    public $checkbox;
    public $is_dashboard;
}
function permissionAccess($menu_id,$name_button){
    $id=Auth::user()->role_id;
    $permission = permissions::where('role_id',$id)->get()->toArray();
    $arrayPermissions = [];
    foreach ($permission as $row) {
        $arrayPermissions[$row["menu_id"]] = $row;
    }
    $dataObject = new dataRolePermission();
    if (array_key_exists($menu_id,$arrayPermissions) && $arrayPermissions[$menu_id][$name_button]){
        if ($menu_id == "2") {
            $dataObject->is_dashboard = json_decode($arrayPermissions[$menu_id][$name_button], true);
        }else{
            $dataObject->value = $arrayPermissions[$menu_id][$name_button];
        }
    } else{
        $dataJson = [
            "is_employee"=>"0",
            "is_age_of_employee"=>"0",
            "is_birthday_reminder"=>"0",
            "is_total_number_of_staff"=>"0",
            "is_total_inactive_staff"=>"0",
            "is_resigned_staff"=>"0",
            "is_reasons_of_staff"=>"0",
            "is_staff_ratio"=>"0",
            "is_staff_taking_leave"=>"0",
            "is_staff_training_internal"=>"0",
            "is_staff_training_external"=>"0"
        ];
        $dataObject->value = 0;
        $dataObject->is_dashboard = $dataJson;
    }
    return $dataObject;
}

function SetCheckbox($datas,$permission_name,$permission_checkbox){
    $dataObject = new dataRolePermission();
    if (array_key_exists($permission_name,$datas) && $datas[$permission_name][$permission_checkbox]){
        if ($permission_name == "lang.admin_dashboard") {
            $dataObject->is_dashboard = json_decode($datas[$permission_name][$permission_checkbox], true);
        }else{
            $dataObject->value = $datas[$permission_name][$permission_checkbox];
            $dataObject->checkbox = $datas[$permission_name][$permission_checkbox] == 1 ? "checked" : "";
        }
    } else{
        $dataJson = [
            "is_employee"=>"0",
            "is_age_of_employee"=>"0",
            "is_birthday_reminder"=>"0",
            "is_total_number_of_staff"=>"0",
            "is_total_inactive_staff"=>"0",
            "is_resigned_staff"=>"0",
            "is_reasons_of_staff"=>"0",
            "is_staff_ratio"=>"0",
            "is_staff_taking_leave"=>"0",
            "is_staff_training_internal"=>"0",
            "is_staff_training_external"=>"0"
        ];
        $dataObject->value = 0;
        $dataObject->checkbox = "";
        $dataObject->is_dashboard = $dataJson;
    }
    return $dataObject;
}
