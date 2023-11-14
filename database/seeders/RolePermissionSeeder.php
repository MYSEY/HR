<?php

namespace Database\Seeders;

use App\Models\permissions;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=RolePermissionSeeder
     *
     * @return void
     */
    public function run()
    {
        $dataJson = [
            "is_employee"=>"1",
            "is_age_of_employee"=>"1",
            "is_birthday_reminder"=>"1",
            "is_total_number_of_staff"=>"1",
            "is_total_inactive_staff"=>"1",
            "is_resigned_staff"=>"1",
            "is_reasons_of_staff"=>"1",
            "is_staff_ratio"=>"1",
            "is_staff_taking_leave"=>"1",
            "is_staff_training_internal"=>"1",
            "is_staff_training_external"=>"1"
        ];
        $datas = [
            [
                "menu_id"=>"1",
                "icon"=>"la la-dashboard",
                "name"=>"lang.dashboards",
                "is_all"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.admin_dashboard",
                "sub_menu_id"=>"1",
                "menu_id"=>"2",
                "url"=>"dashboad/admin",
                "is_dashboard"=>json_encode($dataJson),
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.employee_dashboard",
                "sub_menu_id"=>"1",
                "menu_id"=>"3",
                "url"=>"dashboad/employee",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"4",
                "icon"=>"la la-user",
                "name"=>"lang.employee",
                "is_all"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.all_employee",
                "menu_id"=>"5",
                "sub_menu_id"=>"4",
                "url"=>"users",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_import"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "is_cancel"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.leaves_employee",
                "sub_menu_id"=>"4",
                "menu_id"=>"6",
                "url"=>"leaves/employee",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_import"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "is_cancel"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"7",
                "icon"=>"la la-briefcase",
                "name"=>"lang.recruitments",
                "is_all"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.candidate_cv",
                "sub_menu_id"=>"7",
                "menu_id"=>"8",
                "url"=>"recruitment/candidate-resume/list",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_import"=>"1",
                "is_update"=>"1",
                "is_approve"=>"1",
                "is_delete"=>"1",
                "is_cancel"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.recruitment_plan",
                "sub_menu_id"=>"7",
                "menu_id"=>"9",
                "url"=>"recruitment/plan-list",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"10",
                "icon"=>"la la-money",
                "name"=>"lang.c&b",
                "is_all"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.employee_salary",
                "sub_menu_id"=>"10",
                "menu_id"=>"11",
                "url"=>"payroll/preview",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_approve"=>"1",
                "is_delete"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.nssf",
                "sub_menu_id"=>"10",
                "menu_id"=>"12",
                "url"=>"import-nssf",
                "is_view"=>"1",
                "is_import"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.severance_pay",
                "sub_menu_id"=>"10",
                "menu_id"=>"13",
                "url"=>"severance-pay",
                "is_view"=>"1",
                "is_import"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.fringe_benefits",
                "sub_menu_id"=>"10",
                "menu_id"=>"14",
                "url"=>"fringe-benefit",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_import"=>"1",
                "is_delete"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"15",
                "icon"=>"la la-motorcycle",
                "is_all"=>"1",
                "name"=>"lang.motor_rentals",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.motor_rental",
                "sub_menu_id"=>"15",
                "menu_id"=>"16",
                "url"=>"motor-rentel/list",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_import"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.pay_motor_rental",
                "sub_menu_id"=>"15",
                "menu_id"=>"17",
                "url"=>"motor-rentel/pay",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_approve"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"18",
                "icon"=>"la la-edit",
                "is_all"=>"1",
                "name"=>"lang.trainings",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.trainer",
                "sub_menu_id"=>"18",
                "menu_id"=>"19",
                "url"=>"trainer/list",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.training",
                "sub_menu_id"=>"18",
                "menu_id"=>"20",
                "url"=>"training/list",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.training_report",
                "sub_menu_id"=>"18",
                "menu_id"=>"21",
                "url"=>"reports/training-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"22",
                "icon"=>"la la-pie-chart",
                "is_all"=>"1",
                "name"=>"lang.reports",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.employee_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"23",
                "url"=>"reports/employee-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.payroll_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"24",
                "url"=>"reports/payroll-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.tax_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"25",
                "url"=>"reports/tax-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.nssf_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"26",
                "url"=>"reports/nssf-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.khm_pchum_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"27",
                "url"=>"reports/benefit-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.severance_pay_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"28",
                "url"=>"reports/severance-pay-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.seniorities_pay_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"29",
                "url"=>"reports/seniorities-pay",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.fringe_benefits_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"30",
                "url"=>"reports/fringe-benefits-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.bank_transfer_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"31",
                "url"=>"reports/bank-transfer",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.e_filing_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"32",
                "url"=>"reports/e-filing",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.e_form_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"33",
                "url"=>"reports/e-form",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.motor_rental_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"34",
                "url"=>"reports/motor-rentel-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.new_staff_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"35",
                "url"=>"reports/new_staff-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.staff_resigned_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"36",
                "url"=>"reports/staff-resigned-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.transferred_staff_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"37",
                "url"=>"reports/transferred-staff-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.promoted_staff_reports",
                "sub_menu_id"=>"22",
                "menu_id"=>"38",
                "url"=>"reports/promoted-staff-report",
                "is_view"=>"1",
                "is_print"=>"1",
                "is_export"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"39",
                "icon"=>"la la-key",
                "is_all"=>"1",
                "name"=>"lang.configuration",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.tax",
                "sub_menu_id"=>"39",
                "menu_id"=>"40",
                "url"=>"taxes",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.exchange_rate",
                "sub_menu_id"=>"39",
                "menu_id"=>"41",
                "url"=>"exchange-rate/list",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.public_holidays",
                "sub_menu_id"=>"39",
                "menu_id"=>"42",
                "url"=>"holidays",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.children_allowance",
                "sub_menu_id"=>"39",
                "menu_id"=>"43",
                "url"=>"children/allowance",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "menu_id"=>"44",
                "icon"=>"la la-cog",
                "is_all"=>"1",
                "name"=>"lang.setting",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.bank",
                "sub_menu_id"=>"44",
                "menu_id"=>"45",
                "url"=>"bank",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.position",
                "sub_menu_id"=>"44",
                "menu_id"=>"46",
                "url"=>"position",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.branch",
                "sub_menu_id"=>"44",
                "menu_id"=>"47",
                "url"=>"branch",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.department",
                "sub_menu_id"=>"44",
                "menu_id"=>"48",
                "url"=>"department",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
            [
                "name"=>"lang.forgot_password",
                "sub_menu_id"=>"44",
                "menu_id"=>"49",
                "url"=>"change/password",
                "is_view"=>"1",
                "is_create"=>"1",
                "is_update"=>"1",
                "is_delete"=>"1",
                "parent_id"=>"1",
                "is_active"=>1,
            ],
           
            
        ];
        $roles=Role::get();
        foreach ($roles as $key=>$role) {
            if ($role->role_type == "developer") {
                $datas[] = [
                        "icon"=>"la la-key",
                        "name"=>"lang.role_permission",
                        "url"=>"role",
                        "is_all"=>"1",
                        "is_view"=>"1",
                        "is_create"=>"1",
                        "is_update"=>"1",
                        "is_delete"=>"1",
                        "is_print"=>"1",
                        "is_export"=>"1",
                        "parent_id"=>"1",
                        "is_active"=>1,
                ];
            }
            foreach ($datas as $key => $item) {
                $item["role_id"] = $role->id;
                permissions::firstOrCreate($item);
            }
        };
       
    }
}
