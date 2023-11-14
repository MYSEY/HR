<?php

use App\Helpers\Helper;
use App\Models\permissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class dataMenu {
    public $menu;
    public $subMenu;
    public $singleMenu;
}
function RolePermission()
{
    $id=Auth::user()->role_id;
    $role_permission = permissions::where('role_id',$id)->get()->toArray();
    if(count($role_permission) == 0){
        return false;
    }
    $datas = new dataMenu();
    $menu = [];
    $singleMenu = [];
    $subMenu = [];
    foreach ($role_permission as $groupedSubMenu) {
        if (!$groupedSubMenu["sub_menu_id"] && !$groupedSubMenu["menu_id"]) {
            $singleMenu[] = $groupedSubMenu;
        }else{
            if (!$groupedSubMenu["sub_menu_id"]) {
                $menu[] = $groupedSubMenu;
            }else{
                $subMenu[] = $groupedSubMenu;
            }
        }
    }
    $datas->menu = $menu;
    $datas->singleMenu = $singleMenu;
    $datas->subMenu = $subMenu;
    return $datas;

}
class dataRolePermission{
    public $value;
    public $checkbox;
    public $is_dashboard;
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
