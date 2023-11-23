var dataPermission = function () {
    let data = [];
    // block dashboard
    let dashboad_checkbox = $('.dashboad_checkbox').filter(':checked').length;
    let dashboad_all = $('#dashboad_all').filter(':checked').length;
    if (dashboad_all || dashboad_checkbox) {
        data.push({
            name: "Dashboards",
            permission: [
                {
                    "menu_id":"1",
                    "icon":"la la-dashboard",
                    "is_all": $("#dashboad_all").val(),
                    "name":"lang.dashboards",
                },  
            ]
        });
    }
    if (dashboad_checkbox) {
        data.push({
            name: "Dashboard",
            permission: [
                {
                    "name":"lang.admin_dashboard",
                    "sub_menu_id":"1",
                    "menu_id":"m1-s1",
                    "url":"dashboad/admin",
                    "is_employee": $("#dashboad_employee").val(),
                    "is_age_of_employee": $("#dashboad_age_of_employee").val(),
                    "is_birthday_reminder": $("#dashboad_birthday_reminder").val(),
                    "is_total_number_of_staff": $("#dashboad_total_number_of_staff").val(),
                    "is_total_inactive_staff": $("#dashboad_total_inactive_staff").val(),
                    "is_resigned_staff": $("#dashboad_resigned_staff").val(),
                    "is_reasons_of_staff": $("#dashboad_reasons_of_staff’s_exit").val(),
                    "is_staff_ratio": $("#dashboad_staff_ratio").val(),
                    "is_staff_taking_leave": $("#dashboad_staff_taking_leave").val(),
                    "is_staff_training_internal": $("#dashboad_staff_training_by_branch_internal").val(),
                    "is_staff_training_external": $("#dashboad_staff_training_by_branch_external").val(),
                }
            ]
        })
    }

    // block all employee
    let all_employee_checkbox = $('.all_employee_checkbox').filter(':checked').length;
    let leaves_employee_checkbox = $('.leaves_employee_checkbox').filter(':checked').length;
    let employee_all = $('#employee_all').filter(':checked').length;
    if (employee_all || all_employee_checkbox || leaves_employee_checkbox) {
        data.push({
            name: "employee_block",
            permission: [
                {
                    "menu_id":"2",
                    "icon":"la la-user",
                    "name":"lang.employee",
                    "is_all": $("#employee_all").val(),
                },
            ]
        });
    }
    if (all_employee_checkbox) {
        data.push({
            name: "all_employee",
            permission: [
                {
                    "name":"lang.all_employee",
                    "menu_id":"m2-s1",
                    "sub_menu_id":"2",
                    "url":"users",
                    "is_view": $("#employee_view").val(),
                    "is_create": $("#employee_add").val(),
                    "is_import": $("#employee_import").val(),
                    "is_update": $("#employee_edit").val(),
                    "is_delete": $("#employee_delete").val(),
                    "is_cancel": $("#employee_cancel").val(),
                    "is_print": $("#employee_print").val(),
                    "is_export": $("#employee_export").val(),
                }
            ]
        })
    }
    if (leaves_employee_checkbox) {
        data.push({
            name: "leaves_employee",
            permission: [
                {
                    "name":"lang.leaves_employee",
                    "sub_menu_id":"2",
                    "menu_id":"m2-s2",
                    "url":"leaves/employee",
                    "is_view": $("#leaves_employee_view").val(),
                    "is_create": $("#leaves_employee_add").val(),
                    "is_import": $("#leaves_employee_import").val(),
                    "is_update": $("#leaves_employee_edit").val(),
                    "is_delete": $("#leaves_employee_delete").val(),
                    "is_cancel": $("#leaves_employee_cancel").val(),
                    "is_print": $("#leaves_employee_print").val(),
                    "is_export": $("#leaves_employee_export").val(),
                }
            ]
        })
    }

    // block all recruitment
    let candidate_CVs_checkbox = $('.candidate_CVs_checkbox').filter(':checked').length;
    let recruitment_plans_checkbox = $('.recruitment_plans_checkbox').filter(':checked').length;
    let recruitments_all = $('#recruitments_all').filter(':checked').length;
    if (recruitments_all || candidate_CVs_checkbox || recruitment_plans_checkbox) {
        data.push({
            name: "recruitments",
            permission: [
                {
                    "menu_id":"3",
                    "icon":"la la-briefcase",
                    "name":"lang.recruitments",
                    "is_all": $('#recruitments_all').val(),
                },
            
            ]
        });
    }
    if (candidate_CVs_checkbox) {
        data.push({
            name: "candidate_cv",
            permission: [
                {
                    "name":"lang.candidate_cv",
                    "sub_menu_id":"3",
                    "menu_id":"m3-s1",
                    "url":"recruitment/candidate-resume/list",
                    "is_view": $("#candidate_cv_view").val(),
                    "is_create": $("#candidate_cv_add").val(),
                    "is_import": $("#candidate_cv_import").val(),
                    "is_update": $("#candidate_cv_edit").val(),
                    "is_approve": $("#candidate_cv_approve").val(),
                    "is_delete": $("#candidate_cv_delete").val(),
                    "is_cancel": $("#candidate_cv_cancel").val(),
                    "is_print": $("#candidate_cv_print").val(),
                    "is_export": $("#candidate_cv_export").val(),
                }
            ]
        })
    }
    if (recruitment_plans_checkbox) {
        data.push({
            name: "recruitment_plan",
            permission: [
                {
                    "name":"lang.recruitment_plan",
                    "sub_menu_id":"3",
                    "menu_id":"m3-s2",
                    "url":"recruitment/plan-list",
                    "is_view": $("#recruitment_plan_view").val(),
                    "is_create": $("#recruitment_plan_add").val(),
                    "is_update": $("#recruitment_plan_edit").val(),
                    "is_delete": $("#recruitment_plan_delete").val(),
                    "is_print": $("#recruitment_plan_print").val(),
                    "is_export": $("#recruitment_plan_export").val(),
                }
            ]
        })
    }

    // block C&B 
    let g_checkbox = $('.g_checkbox').filter(':checked').length;
    let employee_salary_checkbox = $('.employee_salary_checkbox').filter(':checked').length;
    let cb_nssf_checkbox = $('.cb_nssf_checkbox').filter(':checked').length;
    let severance_pay_checkbox = $('.severance_pay_checkbox').filter(':checked').length;
    let fringe_benefits_checkbox = $('.fringe_benefits_checkbox').filter(':checked').length;
    let c_and_b_all = $('.c_and_b_checkbox').filter(':checked').length;
    if (c_and_b_all) {
        data.push({
            name: "Compensation and Benefits",
            permission: [
                {
                    "menu_id":"4",
                    "icon":"la la-money",
                    "name":"lang.c&b",
                    "is_all": $("#c_and_b_all").val(),
                },
            ]
        });
    }
    if (g_checkbox) {
        data.push({
            name: "generate_payroll",
            permission: [
                {
                    "name":"lang.generate_payroll",
                    "sub_menu_id":"4",
                    "menu_id":"m4-s1",
                    "url":"payroll/review",
                    "is_view": $("#g_view").val(),
                    "is_create": $("#g_add").val(),
                    "is_approve": $("#g_approve").val(),
                    "is_delete": $("#g_delete").val(),
                }
            ]
        })
    }
    if (employee_salary_checkbox) {
        data.push({
            name: "payroll",
            permission: [
                {
                    "name":"lang.employee_salary",
                    "sub_menu_id":"4",
                    "menu_id":"m4-s2",
                    "url":"payroll",
                    "is_view": $("#c_and_b_view").val(),
                    "is_create": $("#c_and_b_add").val(),
                    "is_import": $("#c_and_b_import").val(),
                    "is_update": $("#c_and_b_edit").val(),
                    "is_approve": $("#c_and_b_approve").val(),
                    "is_delete": $("#c_and_b_delete").val(),
                    "is_print": $("#c_and_b_print").val(),
                    "is_export": $("#c_and_b_export").val(),
                }
            ]
        })
    }
    if (cb_nssf_checkbox) {
        data.push({
            name: "nssf",
            permission: [
                {
                    "name":"lang.nssf",
                    "sub_menu_id":"4",
                    "menu_id":"m4-s3",
                    "url":"import-nssf",
                    "is_view": $("#cb_nssf_view").val(),
                    "is_import": $("#cb_nssf_import").val(),
                    "is_print": $("#cb_nssf_print").val(),
                    "is_export": $("#cb_nssf_export").val(),
                }
            ]
        })
    }
    if (severance_pay_checkbox) {
        data.push({
            name: "Severance Pay",
            permission: [
                {
                    "name":"lang.severance_pay",
                    "sub_menu_id":"4",
                    "menu_id":"m4-s4",
                    "url":"severance-pay",
                    "is_view": $("#severance_pay_view").val(),
                    "is_import": $("#severance_pay_import").val(),
                    "is_print": $("#severance_pay_print").val(),
                    "is_export": $("#severance_pay_export").val(),
                }
            ]
        })
    }
    if (fringe_benefits_checkbox) {
        data.push({
            name: "Fringe Benefits",
            permission: [
                {
                    "name":"lang.fringe_benefits",
                    "sub_menu_id":"4",
                    "menu_id":"m4-s5",
                    "url":"fringe-benefit",
                    "is_view": $("#fringe_benefits_view").val(),
                    "is_create": $("#fringe_benefits_add").val(),
                    "is_update": $("#fringe_benefits_edit").val(),
                    "is_import": $("#fringe_benefits_import").val(),
                    "is_delete": $("#fringe_benefits_delete").val(),
                    "is_print": $("#fringe_benefits_print").val(),
                    "is_export": $("#fringe_benefits_export").val(),
                }
            ]
        })
    }

    //block motor rentals 
    let motor_rentals_checkbox = $('.motor_rentals_checkbox').filter(':checked').length;
    let pay_motor_rentals_checkbox = $('.pay_motor_rentals_checkbox').filter(':checked').length;
    let motor_rental_check_all = $('#motor_rental_check_all').filter(':checked').length;
    if (motor_rental_check_all || motor_rentals_checkbox || pay_motor_rentals_checkbox) {
        data.push({
            name: "Motor Rentals",
            permission: [
                {
                    "menu_id":"5",
                    "icon":"la la-motorcycle",
                    "is_all":"1",
                    "name":"lang.motor_rentals",
                    "is_all": $("#motor_rental_check_all").val(),
                },
            ]
        });
    }
    if (motor_rentals_checkbox) {
        data.push({
            name: "motor_rental",
            permission: [
                {
                    "name":"lang.motor_rental",
                    "sub_menu_id":"5",
                    "menu_id":"m5-s1",
                    "url":"motor-rentel/list",
                    "is_view": $("#motor_rental_view").val(),
                    "is_create": $("#motor_rental_add").val(),
                    "is_import": $("#motor_rental_import").val(),
                    "is_update": $("#motor_rental_edit").val(),
                    "is_delete": $("#motor_rental_delete").val(),
                    "is_print": $("#motor_rental_print").val(),
                    "is_export": $("#motor_rental_export").val(),
                },
            ]
        })
    }
    if (pay_motor_rentals_checkbox) {
        data.push({
            name: "pay_motor_rental",
            permission: [
                {
                    "name":"lang.pay_motor_rental",
                    "sub_menu_id":"5",
                    "menu_id":"m5-s2",
                    "url":"motor-rentel/pay",
                    "is_view": $("#Pay_motor_rental_view").val(),
                    "is_create": $("#Pay_motor_rental_add").val(),
                    "is_approve": $("#Pay_motor_rental_approve").val(),
                    "is_update": $("#Pay_motor_rental_edit").val(),
                    "is_delete": $("#Pay_motor_rental_delete").val(),
                    "is_print": $("#Pay_motor_rental_print").val(),
                    "is_export": $("#Pay_motor_rental_export").val(),
                },
            ]
        })
    }

    //block Trainings 
    let trainer_checkbox = $('.trainer_checkbox').filter(':checked').length;
    let training_checkbox_block = $('.training_checkbox_block').filter(':checked').length;
    let training_reports_checkbox = $('.training_reports_checkbox').filter(':checked').length;
    let training_check_all = $('#training_check_all').filter(':checked').length;
    if (training_check_all || trainer_checkbox || training_checkbox_block || training_reports_checkbox) {
        data.push({
            name: "Trainings",
            permission: [
                {
                    "menu_id":"6",
                    "icon":"la la-edit",
                    "is_all":"1",
                    "name":"lang.trainings",
                    "is_all": $("#training_check_all").val(),
                },
            ]
        });
    }
    if (trainer_checkbox) {
        data.push({
            name: "Trainer",
            permission: [
                {
                    "name":"lang.trainer",
                    "sub_menu_id":"6",
                    "menu_id":"m6-s1",
                    "url":"trainer/list",
                    "is_view": $("#trainer_check_view").val(),
                    "is_create": $("#trainer_check_add").val(),
                    "is_update": $("#trainer_check_edit").val(),
                    "is_delete": $("#trainer_check_delete").val(),
                    "is_print": $("#trainer_check_print").val(),
                    "is_export": $("#trainer_check_export").val(),
                },
            ]
        })
    }
    if (training_checkbox_block) {
        data.push({
            name: "Training",
            permission: [
                {
                    "name":"lang.training",
                    "sub_menu_id":"6",
                    "menu_id":"m6-s2",
                    "url":"training/list",
                    "is_view": $("#training_check_view").val(),
                    "is_create": $("#training_check_add").val(),
                    "is_update": $("#training_check_edit").val(),
                    "is_delete": $("#training_check_delete").val(),
                    "is_print": $("#training_check_print").val(),
                    "is_export": $("#training_check_export").val(),
                },
            ]
        })
    }
    if (training_reports_checkbox) {
        data.push({
            name: "Training_Report",
            permission: [
                {
                    "name":"lang.training_report",
                    "sub_menu_id":"6",
                    "menu_id":"m6-s3",
                    "url":"reports/training-report",
                    "is_view": $("#report_training_check_view").val(),
                    "is_print": $("#report_training_check_print").val(),
                    "is_export": $("#report_training_check_export").val(),
                },
            ]
        })
    }

    // block reports 
    let employee_reports_checkbox = $('.employee_reports_checkbox').filter(':checked').length;
    let payroll_report_checkbox = $('.payroll_report_checkbox').filter(':checked').length;
    let tax_report_checkbox = $('.tax_report_checkbox').filter(':checked').length;
    let nssf_report_checkbox = $('.nssf_report_checkbox').filter(':checked').length;
    let kmh_pchum_report_checkbox = $('.kmh_pchum_report_checkbox').filter(':checked').length;
    let severance_pay_report_checkbox = $('.severance_pay_report_checkbox').filter(':checked').length;
    let seniorities_pay_report_checkbox = $('.seniorities_pay_report_checkbox').filter(':checked').length;
    let fringe_benefits_report_checkbox = $('.fringe_benefits_report_checkbox').filter(':checked').length;
    let bank_transfer_report_checkbox = $('.bank_transfer_report_checkbox').filter(':checked').length;
    let e_filing_report_checkbox = $('.e_filing_report_checkbox').filter(':checked').length;
    let e_form_report_checkbox = $('.e_form_report_checkbox').filter(':checked').length;
    let motor_rental_reports_checkbox = $('.motor_rental_reports_checkbox').filter(':checked').length;
    let new_staff_reports_checkbox = $('.new_staff_reports_checkbox').filter(':checked').length;
    let staff_resigned_reports_checkbox = $('.staff_resigned_reports_checkbox').filter(':checked').length;
    let transferred_staff_report_checkbox = $('.transferred_staff_report_checkbox').filter(':checked').length;
    let promoted_staff_report_checkbox = $('.promoted_staff_report_checkbox').filter(':checked').length;
    let reports_check_all = $('.reports_checkbox').filter(':checked').length;
    if (reports_check_all) {
        data.push({
            name: "reports",
            permission: [
                {
                    "menu_id":"7",
                    "icon":"la la-pie-chart",
                    "is_all":"1",
                    "name":"lang.reports",
                    "is_all": $("#reports_check_all").val(),
                },
            ]
        });
    }

    if (employee_reports_checkbox) {
        data.push({
            name: "Employee_Reports",
            permission: [
                {
                    "name":"lang.employee_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s1",
                    "url":"reports/employee-report",
                    "is_view": $("#report_employee_check_view").val(),
                    "is_print": $("#report_employee_check_print").val(),
                    "is_export": $("#report_employee_check_export").val(),
                },
            ]
        })
    }
    if (payroll_report_checkbox) {
        data.push({
            name: "Payroll_Reports",
            permission: [
                {
                    "name":"lang.payroll_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s2",
                    "url":"reports/payroll-report",
                    "is_view": $("#payroll_report_check_view").val(),
                    "is_print": $("#payroll_report_check_print").val(),
                    "is_export": $("#payroll_report_check_export").val(),
            },
            ]
        })
    }
    if (tax_report_checkbox) {
        data.push({
            name: "tax_report",
            permission: [
                {
                    "name":"lang.tax_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s3",
                    "url":"reports/tax-report",
                    "is_view": $("#tax_report_check_view").val(),
                    "is_print": $("#tax_report_check_print").val(),
                    "is_export": $("#tax_report_check_export").val(),
            },
            ]
        })
    }
    if (nssf_report_checkbox) {
        data.push({
            name: "nssf_report",
            permission: [
                {
                    "name":"lang.nssf_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s4",
                    "url":"reports/nssf-report",
                    "is_view": $("#nssf_report_check_view").val(),
                    "is_print": $("#nssf_report_check_print").val(),
                    "is_export": $("#nssf_report_check_export").val(),
            },
            ]
        })
    }
    if (kmh_pchum_report_checkbox) {
        data.push({
            name: "kmh_pchum_report",
            permission: [
                {
                    "name":"lang.khm_pchum_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s5",
                    "url":"reports/benefit-report",
                    "is_view": $("#kmh_pchum_report_check_view").val(),
                    "is_print": $("#kmh_pchum_report_check_print").val(),
                    "is_export": $("#kmh_pchum_report_check_export").val(),
            },
            ]
        })
    }
    if (severance_pay_report_checkbox) {
        data.push({
            name: "severance_pay_report",
            permission: [
                {
                    "name":"lang.severance_pay_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s6",
                    "url":"reports/severance-pay-report",
                    "is_view": $("#severance_pay_report_check_view").val(),
                    "is_print": $("#severance_pay_report_check_print").val(),
                    "is_export": $("#severance_pay_report_check_export").val(),
            },
            ]
        })
    }
    if (seniorities_pay_report_checkbox) {
        data.push({
            name: "seniorities_pay_report",
            permission: [
                {
                    "name":"lang.seniorities_pay_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s7",
                    "url":"reports/seniorities-pay",
                    "is_view": $("#seniorities_pay_report_check_view").val(),
                    "is_print": $("#seniorities_pay_report_check_print").val(),
                    "is_export": $("#seniorities_pay_report_check_export").val(),
                },
            ]
        })
    }
    if (fringe_benefits_report_checkbox) {
        data.push({
            name: "fringe_benefits_report",
            permission: [
                {
                    "name":"lang.fringe_benefits_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s8",
                    "url":"reports/fringe-benefits-report",
                    "is_view": $("#fringe_benefits_report_check_view").val(),
                    "is_print": $("#fringe_benefits_report_check_print").val(),
                    "is_export": $("#fringe_benefits_report_check_export").val(),
                },
            ]
        })
    }
    if (bank_transfer_report_checkbox) {
        data.push({
            name: "Bank_Transfer_Reports",
            permission: [
                {
                    "name":"lang.bank_transfer_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s9",
                    "url":"reports/bank-transfer",
                    "is_view": $("#bank_transfer_report_check_view").val(),
                    "is_print": $("#bank_transfer_report_check_print").val(),
                    "is_export": $("#bank_transfer_report_check_export").val(),
                },
            ]
        })
    }
    if (e_filing_report_checkbox) {
        data.push({
            name: "E-Filing_Reports",
            permission: [
                {
                    "name":"lang.e_filing_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s10",
                    "url":"reports/e-filing",
                    "is_view": $("#e_filing_report_check_view").val(),
                    "is_print": $("#e_filing_report_check_print").val(),
                    "is_export": $("#e_filing_report_check_export").val(),
                },
            ]
        })
    }
    if (e_form_report_checkbox) {
        data.push({
            name: "E-Form_Reports",
            permission: [
                {
                    "name":"lang.e_form_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s11",
                    "url":"reports/e-form",
                    "is_view": $("#e_form_report_check_view").val(),
                    "is_print": $("#e_form_report_check_print").val(),
                    "is_export": $("#e_form_report_check_export").val(),
                },
            ]
        })
    }
    if (motor_rental_reports_checkbox) {
        data.push({
            name: "Motor_Rental_Reports",
            permission: [
                {
                    "name":"lang.motor_rental_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s12",
                    "url":"reports/motor-rentel-report",
                    "is_view": $("#motor_rental_reports_check_view").val(),
                    "is_print": $("#motor_rental_reports_check_print").val(),
                    "is_export": $("#motor_rental_reports_check_export").val(),
                },
            ]
        })
    }
    if (new_staff_reports_checkbox) {
        data.push({
            name: "New_Staff_Reports",
            permission: [
                {
                    "name":"lang.new_staff_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s13",
                    "url":"reports/new_staff-report",
                    "is_view": $("#new_staff_reports_check_view").val(),
                    "is_print": $("#new_staff_reports_check_print").val(),
                    "is_export": $("#new_staff_reports_check_export").val(),
                },
            ]
        })
    }
    if (staff_resigned_reports_checkbox) {
        data.push({
            name: "Staff_Resigned_Reports",
            permission: [
                {
                    "name":"lang.staff_resigned_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s14",
                    "url":"reports/staff-resigned-report",
                    "is_view": $("#staff_resigned_reports_check_view").val(),
                    "is_print": $("#staff_resigned_reports_check_print").val(),
                    "is_export": $("#staff_resigned_reports_check_export").val(),
                },
            ]
        })
    }
    if (transferred_staff_report_checkbox) {
        data.push({
            name: "Transferred_Staff_Reports",
            permission: [
                {
                    "name":"lang.transferred_staff_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s15",
                    "url":"reports/transferred-staff-report",
                    "is_view": $("#transferred_staff_report_check_view").val(),
                    "is_print": $("#transferred_staff_report_check_print").val(),
                    "is_export": $("#transferred_staff_report_check_export").val(),
                },
            ]
        })
    }
    if (promoted_staff_report_checkbox) {
        data.push({
            name: "Promoted_Staff_Reports",
            permission: [
                {
                    "name":"lang.promoted_staff_reports",
                    "sub_menu_id":"7",
                    "menu_id":"m7-s16",
                    "url":"reports/promoted-staff-report",
                    "is_view": $("#promoted_staff_report_check_view").val(),
                    "is_print": $("#promoted_staff_report_check_print").val(),
                    "is_export": $("#promoted_staff_report_check_export").val(),
                },
            ]
        })
    }

    //block Configuration
    let taxes_checkbox = $('.taxes_checkbox').filter(':checked').length;
    let exchange_rate_checkbox = $('.exchange_rate_checkbox').filter(':checked').length;
    let public_holidays_checkbox = $('.public_holidays_checkbox').filter(':checked').length;
    let children_allowance_checkbox = $('.children_allowance_checkbox').filter(':checked').length;
    let configuration_check_all = $('.configuration_checkbox').filter(':checked').length;
    if (configuration_check_all) {
        data.push({
            name: "configuration",
            permission: [
                {
                    "menu_id":"8",
                    "icon":"la la-key",
                    "name":"lang.configuration",
                    "is_all": $("#configuration_check_all").val(),
                },
            ]
        });
    }
    if (taxes_checkbox) {
        data.push({
            name: "Tax",
            permission: [
                {
                    "name":"lang.tax",
                    "sub_menu_id":"8",
                    "menu_id":"m8-s1",
                    "url":"taxes",
                    "is_view": $("#taxes_check_view").val(),
                    "is_create": $("#taxes_check_add").val(),
                    "is_update": $("#taxes_check_edit").val(),
                    "is_delete": $("#taxes_check_delete").val(),
                },
            ]
        })
    }
    if (exchange_rate_checkbox) {
        data.push({
            name: "Exchange_Rate",
            permission: [
                {
                    "name":"lang.exchange_rate",
                    "sub_menu_id":"8",
                    "menu_id":"m8-s2",
                    "url":"exchange-rate/list",
                    "is_view": $("#exchange_rate_check_view").val(),
                    "is_create": $("#exchange_rate_check_add").val(),
                    "is_update": $("#exchange_rate_check_edit").val(),
                    "is_delete": $("#exchange_rate_check_delete").val(),
                },
            ]
        })
    }
    if (public_holidays_checkbox) {
        data.push({
            name: "Public_Holidays",
            permission: [
                {
                    "name":"lang.public_holidays",
                    "sub_menu_id":"8",
                    "menu_id":"m8-s3",
                    "url":"holidays",
                    "is_view": $("#public_holidays_check_view").val(),
                    "is_create": $("#public_holidays_check_add").val(),
                    "is_update": $("#public_holidays_check_edit").val(),
                    "is_delete": $("#public_holidays_check_delete").val(),
                },
            ]
        })
    }
    if (children_allowance_checkbox) {
        data.push({
            name: "Children_Allowance",
            permission: [
                {
                    "name":"lang.children_allowance",
                    "sub_menu_id":"8",
                    "menu_id":"m8-s4",
                    "url":"children/allowance",
                    "is_view": $("#children_allowance_check_view").val(),
                    "is_create": $("#children_allowance_check_add").val(),
                    "is_update": $("#children_allowance_check_edit").val(),
                    "is_delete": $("#children_allowance_check_delete").val(),
                },
            ]
        })
    }

    // block settings
    let bank_checkbox = $('.bank_checkbox').filter(':checked').length;
    let position_checkbox = $('.position_checkbox').filter(':checked').length;
    let branch_checkbox = $('.branch_checkbox').filter(':checked').length;
    let department_checkbox = $('.department_checkbox').filter(':checked').length;
    let forgot_password_checkbox = $('.forgot_password_checkbox').filter(':checked').length;
    let setting_check_all = $('.setting_checkbox').filter(':checked').length;
    if (setting_check_all) {
        data.push({
            name: "setting",
            permission: [
                {
                    "menu_id":"9",
                    "icon":"la la-cog",
                    "name":"lang.setting",
                    "is_all": $("#setting_check_all").val(),
                },
            ]
        });
    }
    if (bank_checkbox) {
        data.push({
            name: "Bank",
            permission: [
                {
                    "name":"lang.bank",
                    "sub_menu_id":"9",
                    "menu_id":"m9-s1",
                    "url":"bank",
                    "is_view": $("#bank_check_view").val(),
                    "is_create": $("#bank_check_add").val(),
                    "is_update": $("#bank_check_edit").val(),
                    "is_delete": $("#bank_check_delete").val(),
                },
            ]
        })
    }
    if (position_checkbox) {
        data.push({
            name: "Position",
            permission: [
                {
                    "name":"lang.position",
                    "sub_menu_id":"9",
                    "menu_id":"m9-s2",
                    "url":"position",
                    "is_view": $("#position_check_view").val(),
                    "is_create": $("#position_check_add").val(),
                    "is_update": $("#position_check_edit").val(),
                    "is_delete": $("#position_check_delete").val(),
                },
            ]
        })
    }
    if (branch_checkbox) {
        data.push({
            name: "Branch",
            permission: [
                {
                    "name":"lang.branch",
                    "sub_menu_id":"9",
                    "menu_id":"m9-s3",
                    "url":"branch",
                    "is_view": $("#branch_check_view").val(),
                    "is_create": $("#branch_check_add").val(),
                    "is_update": $("#branch_check_edit").val(),
                    "is_delete": $("#branch_check_delete").val(),
                },
            ]
        })
    }
    if (department_checkbox) {
        data.push({
            name: "Department",
            permission: [
                {
                    "name":"lang.department",
                    "sub_menu_id":"9",
                    "menu_id":"m9-s4",
                    "url":"department",
                    "is_view": $("#department_check_view").val(),
                    "is_create": $("#department_check_add").val(),
                    "is_update": $("#department_check_edit").val(),
                    "is_delete": $("#department_check_delete").val(),
                },
            ]
        })
    }
    if (forgot_password_checkbox) {
        data.push({
            name: "Forgot_Password",
            permission: [
                {
                    "name":"lang.forgot_password",
                    "sub_menu_id":"9",
                    "menu_id":"m9-s5",
                    "url":"change/password",
                    "is_view": $("#forgot_password_check_view").val(),
                    "is_create": $("#forgot_password_check_add").val(),
                    "is_update": $("#forgot_password_check_edit").val(),
                    "is_delete": $("#forgot_password_check_delete").val(),
                },
            ]
        })
    }
   
    // block roles
    let role_checkbox = $('.role_checkbox').filter(':checked').length;
    if (role_checkbox) {
        data.push({
            name: "role Permission",
            permission: [
                {
                    "icon":"la la-key",
                    "name":"lang.role_permission",
                    "url":"role",
                    "is_all": $("#role_check_all").val(),
                    "is_view": $("#role_check_view").val(),
                    "is_create": $("#role_check_add").val(),
                    "is_update": $("#role_check_edit").val(),
                    "is_delete": $("#role_check_delete").val(),
                    "is_print": $("#role_check_print").val(),
                    "is_export": $("#role_check_export").val(),
                },  
            ]
        });
    }
    return data;
}