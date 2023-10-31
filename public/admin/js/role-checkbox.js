
var roleCheckboxs = function () {
    var data = [];
    // block dahboard
    $("#dashboad_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".dashboad_checkbox").prop("checked", false);
            $(".dashboad_checkbox").val(0);
        }
        if ($(this).prop("checked")) {
            $(".dashboad_checkbox").prop("checked", true);
            $(".dashboad_checkbox").val(1);
        }
    });
    $(document).ready(function(){
        var checkboxes = $('.dashboad_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.dashboad_checkbox').length) {
                $("#dashboad_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.dashboad_checkbox').length) {
                $("#dashboad_all").prop("checked", false);
            };
        });
    });

    // blcok employee
    $("#employee_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".employee_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "employee")
        }
        if ($(this).prop("checked")) {
            $(".employee_checkbox").prop("checked", true);
            $(this).val(1)
            $(".employee_checkbox").val(1);
            data.push({
                name: "employee",
                permission: [
                    {
                        "is_all": $(this).val(),
                        "name":"Employee",
                    },
                    {
                        "name":"All Employee",
                        "table_id":"3",
                        "is_view": $("#employee_view").val(),
                        "is_create": $("#employee_add").val(),
                        "is_import": $("#employee_import").val(),
                        "is_update": $("#employee_edit").val(),
                        "is_delete": $("#employee_delete").val(),
                        "is_cancel": $("#employee_cancel").val(),
                        "is_print": $("#employee_print").val(),
                        "is_export": $("#employee_export").val(),
                    },
                    {
                        "name":"Leaves Employee",
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
    });
    $("#all_employee").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".all_employee_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "all_employee")
        }
        if ($(this).prop("checked")) {
            $(".all_employee_checkbox").prop("checked", true);
            $(this).val(1)
            $(".all_employee_checkbox").val(1);
            data.push({
                name: "all_employee",
                permission: [
                    {
                        "name":"All Employee",
                        "table_id":"3",
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
        
    });
    // $(".all_employee_checkbox").on("click", function(){
    //      $(document).ready(function(){
    //         var allEmployeeSingle = $('.all_employee_checkbox');
    //         allEmployeeSingle.change(function(){
    //             var countAllCheckboxes = allEmployeeSingle.filter(':checked').length;
    //             if (countAllCheckboxes == $('input.all_employee_checkbox').length) {
    //                 $("#all_employee").prop("checked", true);
    //             };
    //         });
    //     });
    //     if ($(this).prop("checked")) {
    //         let permission = {
    //             name:"All Employee",
    //             table_id:"3",
    //         };
    //         let dataCheckName = $(this).data("name");

    //         alert(dataCheckName);

    //         if (dataCheckName == "is_view") {
    //             permission.is_view = 1;
    //         }
    //         if (dataCheckName == "is_add") {
    //             permission.is_add = 1;
    //         }
    //         if (dataCheckName == "is_import") {
    //             permission.is_import = 1;
    //         }
    //         if (dataCheckName == "is_update") {
    //             permission.is_update = 1;
    //         }
    //         if (dataCheckName == "is_delete") {
    //             permission.is_delete = 1;
    //         }
    //         if (dataCheckName == "is_cancel") {
    //             permission.is_cancel = 1;
    //         }
    //         if (dataCheckName == "is_print") {
    //             permission.is_print = 1;
    //         }
    //         if (dataCheckName == "is_export") {
    //             permission.is_export = 1;
    //         }
    //         data.push({
    //             permission: [permission]
    //         });
    //     };
       
    // });
    $("#leaves_employee").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".leaves_employee_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "leaves_employee")
        }
        if ($(this).prop("checked")) {
            $(".leaves_employee_checkbox").prop("checked", true);
            $(this).val(1)
            $(".leaves_employee_checkbox").val(1);
            data.push({
                name: "leaves_employee",
                permission: [
                    {
                        "name":"Leaves Employee",
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
        
    });
    $(document).ready(function(){
        var allEmployees = $('.all_employee_checkbox');
        allEmployees.change(function(){
            var countAllCheckboxes = allEmployees.filter(':checked').length;
            if (countAllCheckboxes == $('input.all_employee_checkbox').length) {
                $("#all_employee").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.all_employee_checkbox').length) {
                $("#all_employee").prop("checked", false);
            };
        });
        var leavesEmployee = $('.leaves_employee_checkbox');
        leavesEmployee.change(function(){
            var countleavesEmployeeCheckboxes = leavesEmployee.filter(':checked').length;
            if (countleavesEmployeeCheckboxes == $('input.leaves_employee_checkbox').length) {
                $("#leaves_employee").prop("checked", true);
            };
            if (countleavesEmployeeCheckboxes < $('input.leaves_employee_checkbox').length) {
                $("#leaves_employee").prop("checked", false);
            };
        });

        var checkboxes = $('.employee_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.employee_checkbox').length) {
                $("#employee_all").prop("checked", true);
                data.push({
                    name: "employee_block",
                    permission: [
                        {
                            "is_all": $(this).val(),
                            "name":"Employee",
                        },
                    ]
                });
            };
            if (countCheckedCheckboxes < $('input.employee_checkbox').length) {
                $("#employee_all").prop("checked", false);
                data = data.filter(item => item.name !== "employee_block");
            };
        });
    });

    // blcok recruitment
    $("#recruitments_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".recruitment_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "recruitments")
        }
            if ($(this).prop("checked")) {
            $(".recruitment_checkbox").prop("checked", true);
            $(this).val(1)
            $(".recruitment_checkbox").val(1);
                data.push({
                        name: "recruitments",
                        permission: [
                            {
                                "is_all": $(this).val(),
                                "name":"recruitments",
                            },
                            {
                                "name":"Candidate CV",
                                "table_id":"8",
                                "is_view": $("#candidate_cv_view").val(),
                                "is_create": $("#candidate_cv_add").val(),
                                "is_import": $("#candidate_cv_import").val(),
                                "is_update": $("#candidate_cv_edit").val(),
                                "is_approve": $("#candidate_cv_approve").val(),
                                "is_delete": $("#candidate_cv_delete").val(),
                                "is_cancel": $("#candidate_cv_cancel").val(),
                                "is_print": $("#candidate_cv_print").val(),
                                "is_export": $("#candidate_cv_export").val(),
                            },
                            {
                                "name":"Recruitment Plan",
                                "table_id":"7",
                                "is_view": $("#recruitment_plan_view").val(),
                                "is_create": $("#recruitment_plan_add").val(),
                                "is_update": $("#recruitment_plan_edit").val(),
                                "is_delete": $("#recruitment_plan_delete").val(),
                                "is_print": $("#recruitment_plan_print").val(),
                                "is_export": $("#recruitment_plan_export").val(),
                            }
                    ]
                });
            }
            
    });
    $("#candidate_CVs").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".candidate_CVs_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "candidate_cv")
        }
        if ($(this).prop("checked")) {
            $(".candidate_CVs_checkbox").prop("checked", true);
            $(this).val(1)
            $(".candidate_CVs_checkbox").val(1);
            data.push({
                name: "candidate_cv",
                permission: [
                    {
                        "name":"Candidate CV",
                        "table_id":"8",
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
        
    });
    $("#recruitment_plans").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".recruitment_plans_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "recruitment_plan")
        }
        if ($(this).prop("checked")) {
            $(".recruitment_plans_checkbox").prop("checked", true);
            $(this).val(1)
            $(".recruitment_plans_checkbox").val(1);
            data.push({
                name: "recruitment_plan",
                permission: [
                    {
                        "name":"Recruitment Plan",
                        "table_id":"7",
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
        
    });
    $(document).ready(function(){
        var checkboxes = $('.recruitment_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.recruitment_checkbox').length) {
                $("#recruitments_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.recruitment_checkbox').length) {
                $("#recruitments_all").prop("checked", false);
            };
        });
    });

    // blcok C&B
    $("#c_and_b_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".c_and_b_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "c_and_b_all")
        }
        if ($(this).prop("checked")) {
            $(".c_and_b_checkbox").prop("checked", true);
            $(this).val(1)
            $(".c_and_b_checkbox").val(1);
                data.push({
                    name: "c_and_b_all",
                    permission: [
                        {
                            "is_all": $(this).val(),
                            "name":"Compensation and Benefits",
                        },
                        {
                            "name":"Payroll",
                            "table_id":"4",
                            "is_view": $("#c_and_b_view").val(),
                            "is_create": $("#c_and_b_add").val(),
                            "is_update": $("#c_and_b_edit").val(),
                            "is_approve": $("#c_and_b_approve").val(),
                            "is_delete": $("#c_and_b_delete").val(),
                            "is_print": $("#c_and_b_print").val(),
                            "is_export": $("#c_and_b_export").val(),
                        }
                    ]
                });
            }
    });
    $("#employee_salary").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".employee_salary_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "payroll")
        }
        if ($(this).prop("checked")) {
            $(".employee_salary_checkbox").prop("checked", true);
            $(this).val(1)
            $(".employee_salary_checkbox").val(1);
            data.push({
                name: "payroll",
                permission: [
                    {
                        "name":"Payroll",
                        "table_id":"4",
                        "is_view": $("#c_and_b_view").val(),
                        "is_create": $("#c_and_b_add").val(),
                        "is_update": $("#c_and_b_edit").val(),
                        "is_approve": $("#c_and_b_approve").val(),
                        "is_delete": $("#c_and_b_delete").val(),
                        "is_print": $("#c_and_b_print").val(),
                        "is_export": $("#c_and_b_export").val(),
                    }
                ]
            })
        }
        
    });
    $(document).ready(function(){
        var checkboxes = $('.c_and_b_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.c_and_b_checkbox').length) {
                $("#c_and_b_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.c_and_b_checkbox').length) {
                $("#c_and_b_all").prop("checked", false);
            };
        });
    });

    // blcok motor rental
    $("#motor_rental_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".motor_rental_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "motor_rentals")
        }
        if ($(this).prop("checked")) {
            $(".motor_rental_checkbox").prop("checked", true);
            $(this).val(1)
            $(".motor_rental_checkbox").val(1);
                data.push({
                    name: "motor_rentals",
                    permission: [
                        {
                            "is_all": $(this).val(),
                            "name":"Motor Rentals",
                        },
                        {
                            "name":"Motor Rental",
                            "table_id":"5",
                            "is_view": $("#motor_rental_view").val(),
                            "is_create": $("#motor_rental_add").val(),
                            "is_import": $("#motor_rental_import").val(),
                            "is_update": $("#motor_rental_edit").val(),
                            "is_delete": $("#motor_rental_delete").val(),
                            "is_print": $("#motor_rental_print").val(),
                            "is_export": $("#motor_rental_export").val(),
                        },
                        {
                            "name":"Pay Motor Rental",
                            "table_id":"6",
                            "is_view": $("#Pay_motor_rental_view").val(),
                            "is_create": $("#Pay_motor_rental_add").val(),
                            "is_approve": $("#Pay_motor_rental_approve").val(),
                            "is_update": $("#Pay_motor_rental_edit").val(),
                            "is_delete": $("#Pay_motor_rental_delete").val(),
                            "is_print": $("#Pay_motor_rental_print").val(),
                            "is_export": $("#Pay_motor_rental_export").val(),
                        }
                    ]
                });
            }
    });
    $("#motor_rentals").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".motor_rentals_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "motor_rental")
        }
        if ($(this).prop("checked")) {
            $(".motor_rentals_checkbox").prop("checked", true);
            $(this).val(1)
            $(".motor_rentals_checkbox").val(1);
            data.push({
                name: "motor_rental",
                permission: [
                    {
                        "name":"Motor Rental",
                        "table_id":"5",
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
        
    });
    $("#pay_motor_rentals").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".pay_motor_rentals_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "pay_motor_rental")
        }
        if ($(this).prop("checked")) {
            $(".pay_motor_rentals_checkbox").prop("checked", true);
            $(this).val(1)
            $(".pay_motor_rentals_checkbox").val(1);
            data.push({
                name: "pay_motor_rental",
                permission: [
                    {
                        "name":"Pay Motor Rental",
                            "table_id":"6",
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
        
    });
    $(document).ready(function(){
        var checkboxes = $('.motor_rental_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.motor_rental_checkbox').length) {
                $("#motor_rental_check_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.motor_rental_checkbox').length) {
                $("#motor_rental_check_all").prop("checked", false);
            };
        });
    });

    // blcok training
    $("#training_check_all").on("click", function(){
            if (!$(this).prop("checked")) {
                $(".training_checkbox").prop("checked", false);
                data = data.filter(item => item.name !== "trainings")
            }
            if ($(this).prop("checked")) {
                $(".training_checkbox").prop("checked", true);
                $(this).val(1)
                $(".training_checkbox").val(1);
                data.push({
                    name: "trainings",
                    permission: [
                        {
                            "is_all": $(this).val(),
                            "name":"Trainings",
                        },
                        {
                            "name":"Trainer",
                            "table_id":"10",
                            "is_view": $("#trainer_check_view").val(),
                            "is_create": $("#trainer_check_add").val(),
                            "is_update": $("#trainer_check_edit").val(),
                            "is_delete": $("#trainer_check_delete").val(),
                            "is_print": $("#trainer_check_print").val(),
                            "is_export": $("#trainer_check_export").val(),
                        },
                        {
                            "name":"Training",
                            "table_id":"10",
                            "is_view": $("#training_check_view").val(),
                            "is_create": $("#training_check_add").val(),
                            "is_update": $("#training_check_edit").val(),
                            "is_delete": $("#training_check_delete").val(),
                            "is_print": $("#training_check_print").val(),
                            "is_export": $("#training_check_export").val(),
                        },
                        {
                            "name":"Training Report",
                            "table_id":"10",
                            "is_view": $("#report_training_check_view").val(),
                            "is_print": $("#report_training_check_print").val(),
                            "is_export": $("#report_training_check_export").val(),
                        }
                    ]
                });
            }
    });
    $("#trainer").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".trainer_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Trainer")
        }
        if ($(this).prop("checked")) {
            $(".trainer_checkbox").prop("checked", true);
            $(this).val(1)
            $(".trainer_checkbox").val(1);
            data.push({
                name: "Trainer",
                permission: [
                    {
                        "name":"Trainer",
                        "table_id":"10",
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
        
    });
    $("#training").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".training_checkbox_block").prop("checked", false);
            data = data.filter(item => item.name !== "Training")
        }
        if ($(this).prop("checked")) {
            $(".training_checkbox_block").prop("checked", true);
            $(this).val(1)
            $(".training_checkbox_block").val(1);
            data.push({
                name: "Training",
                permission: [
                    {
                        "name":"Training",
                        "table_id":"10",
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
        
    });
    $("#training_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".training_reports_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Training_Report")
        }
        if ($(this).prop("checked")) {
            $(".training_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".training_reports_checkbox").val(1);
            data.push({
                name: "Training_Report",
                permission: [
                    {
                        "name":"Training Report",
                        "table_id":"10",
                        "is_view": $("#report_training_check_view").val(),
                        "is_print": $("#report_training_check_print").val(),
                        "is_export": $("#report_training_check_export").val(),
                    },
                ]
            })
        }
        
    });
    $(document).ready(function(){
        var checkboxes = $('.training_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.training_checkbox').length) {
                $("#training_check_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.training_checkbox').length) {
                $("#training_check_all").prop("checked", false);
            };
        });
    });

    // blcok reports
    $("#reports_check_all").on("click", function(){
            if (!$(this).prop("checked")) {
                $(".reports_checkbox").prop("checked", false);
                data = data.filter(item => item.name !== "reports")
            }
            if ($(this).prop("checked")) {
                $(".reports_checkbox").prop("checked", true);
                $(this).val(1)
                $(".reports_checkbox").val(1);
                data.push({
                    name: "reports",
                    permission: [
                        {
                            "is_all": $(this).val(),
                            "name":"Reports",
                        },
                        {
                            "name":"Employee Reports",
                            "table_id":"17",
                            "is_view": $("#report_employee_check_view").val(),
                            "is_print": $("#report_employee_check_print").val(),
                            "is_export": $("#report_employee_check_export").val(),
                        },
                        {
                            "name":"Payroll Reports",
                            "table_id":"18",
                            "is_view": $("#payroll_report_check_view").val(),
                            "is_print": $("#payroll_report_check_print").val(),
                            "is_export": $("#payroll_report_check_export").val(),
                        },
                        {
                            "name":"Bank Transfer Reports",
                            "is_view": $("#bank_transfer_report_check_view").val(),
                            "is_print": $("#bank_transfer_report_check_print").val(),
                            "is_export": $("#bank_transfer_report_check_export").val(),
                        },
                        {
                            "name":"E-Filing Reports",
                            "is_view": $("#e_filing_report_check_view").val(),
                            "is_print": $("#e_filing_report_check_print").val(),
                            "is_export": $("#e_filing_report_check_export").val(),
                        },
                        {
                            "name":"E-Form Reports",
                            "is_view": $("#e_form_report_check_view").val(),
                            "is_print": $("#e_form_report_check_print").val(),
                            "is_export": $("#e_form_report_check_export").val(),
                        },
                        {
                            "name":"Motor Rental Reports",
                            "table_id":"19",
                            "is_view": $("#motor_rental_reports_check_view").val(),
                            "is_print": $("#motor_rental_reports_check_print").val(),
                            "is_export": $("#motor_rental_reports_check_export").val(),
                        },
                        {
                            "name":"New Staff Reports",
                            "table_id":"20",
                            "is_view": $("#new_staff_reports_check_view").val(),
                            "is_print": $("#new_staff_reports_check_print").val(),
                            "is_export": $("#new_staff_reports_check_export").val(),
                        },
                        {
                            "name":"Staff Resigned Reports",
                            "table_id":"21",
                            "is_view": $("#staff_resigned_reports_check_view").val(),
                            "is_print": $("#staff_resigned_reports_check_print").val(),
                            "is_export": $("#staff_resigned_reports_check_export").val(),
                        },
                        {
                            "name":"Promoted Staff Reports",
                            "table_id":"22",
                            "is_view": $("#promoted_staff_report_check_view").val(),
                            "is_print": $("#promoted_staff_report_check_print").val(),
                            "is_export": $("#promoted_staff_report_check_export").val(),
                        },
                        {
                            "name":"Transferred Staff Reports",
                            "table_id":"23",
                            "is_view": $("#transferred_staff_report_check_view").val(),
                            "is_print": $("#transferred_staff_report_check_print").val(),
                            "is_export": $("#transferred_staff_report_check_export").val(),
                        },
                    ]
                });
            }
    });
    $("#employee_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".employee_reports_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Employee_Reports")
        }
        if ($(this).prop("checked")) {
            $(".employee_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".employee_reports_checkbox").val(1);
            data.push({
                name: "Employee_Reports",
                permission: [
                    {
                        "name":"Employee Reports",
                        "table_id":"17",
                        "is_view": $("#report_employee_check_view").val(),
                        "is_print": $("#report_employee_check_print").val(),
                        "is_export": $("#report_employee_check_export").val(),
                    },
                ]
            })
        }
    });
    $("#payroll_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".payroll_report_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Payroll_Reports")
        }
        if ($(this).prop("checked")) {
            $(".payroll_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".payroll_report_checkbox").val(1);
            data.push({
                name: "Payroll_Reports",
                permission: [
                    {
                        "name":"Payroll Reports",
                        "table_id":"18",
                        "is_view": $("#payroll_report_check_view").val(),
                        "is_print": $("#payroll_report_check_print").val(),
                        "is_export": $("#payroll_report_check_export").val(),
                },
                ]
            })
        }
        
    });
    $("#bank_transfer_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".bank_transfer_report_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Bank_Transfer_Reports")
        }
        if ($(this).prop("checked")) {
            $(".bank_transfer_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".bank_transfer_report_checkbox").val(1);
            data.push({
                name: "Bank_Transfer_Reports",
                permission: [
                    {
                        "name":"Bank Transfer Reports",
                        "is_view": $("#bank_transfer_report_check_view").val(),
                        "is_print": $("#bank_transfer_report_check_print").val(),
                        "is_export": $("#bank_transfer_report_check_export").val(),
                },
                ]
            })
        }
        
    });
    $("#e_filing_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".e_filing_report_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "E-Filing_Reports")
        }
        if ($(this).prop("checked")) {
            $(".e_filing_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".e_filing_report_checkbox").val(1);
            data.push({
                name: "E-Filing_Reports",
                permission: [
                    {
                        "name":"E-Filing Reports",
                        "is_view": $("#e_filing_report_check_view").val(),
                        "is_print": $("#e_filing_report_check_print").val(),
                        "is_export": $("#e_filing_report_check_export").val(),
                },
                ]
            })
        }
        
    });
    $("#e_form_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".e_form_report_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "E-Form_Reports")
        }
        if ($(this).prop("checked")) {
            $(".e_form_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".e_form_report_checkbox").val(1);
            data.push({
                name: "E-Form_Reports",
                permission: [
                    {
                        "name":"E-Form Reports",
                        "is_view": $("#e_form_report_check_view").val(),
                        "is_print": $("#e_form_report_check_print").val(),
                        "is_export": $("#e_form_report_check_export").val(),
                },
                ]
            })
        }
        
    });
    $("#motor_rental_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".motor_rental_reports_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Motor_Rental_Reports")
        }
        if ($(this).prop("checked")) {
            $(".motor_rental_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".motor_rental_reports_checkbox").val(1);
            data.push({
                name: "Motor_Rental_Reports",
                permission: [
                    {
                        "name":"Motor Rental Reports",
                        "table_id":"19",
                        "is_view": $("#motor_rental_reports_check_view").val(),
                        "is_print": $("#motor_rental_reports_check_print").val(),
                        "is_export": $("#motor_rental_reports_check_export").val(),
                },
                ]
            })
        }
        
    });
    $("#new_staff_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".new_staff_reports_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "New_Staff_Reports")
        }
        if ($(this).prop("checked")) {
            $(".new_staff_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".new_staff_reports_checkbox").val(1);
            data.push({
                name: "New_Staff_Reports",
                permission: [
                    {
                        "name":"New Staff Reports",
                        "table_id":"20",
                        "is_view": $("#new_staff_reports_check_view").val(),
                        "is_print": $("#new_staff_reports_check_print").val(),
                        "is_export": $("#new_staff_reports_check_export").val(),
                    },
                ]
            })
        }
        
    });
    $("#staff_resigned_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".staff_resigned_reports_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Staff_Resigned_Reports")
        }
        if ($(this).prop("checked")) {
            $(".staff_resigned_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".staff_resigned_reports_checkbox").val(1);
            data.push({
                name: "Staff_Resigned_Reports",
                permission: [
                    {
                        "name":"Staff Resigned Reports",
                        "table_id":"21",
                        "is_view": $("#staff_resigned_reports_check_view").val(),
                        "is_print": $("#staff_resigned_reports_check_print").val(),
                        "is_export": $("#staff_resigned_reports_check_export").val(),
                    },
                ]
            })
        }
        
    });
    $("#transferred_staff_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".transferred_staff_report_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Promoted_Staff_Reports")
        }
        if ($(this).prop("checked")) {
            $(".transferred_staff_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".transferred_staff_report_checkbox").val(1);
            data.push({
                name: "Promoted_Staff_Reports",
                permission: [
                    {
                        "name":"Promoted Staff Reports",
                        "table_id":"22",
                        "is_view": $("#promoted_staff_report_check_view").val(),
                        "is_print": $("#promoted_staff_report_check_print").val(),
                        "is_export": $("#promoted_staff_report_check_export").val(),
                    },
                ]
            })
        }
        
    });
    $("#promoted_staff_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".promoted_staff_report_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Transferred_Staff_Reports")
        }
        if ($(this).prop("checked")) {
            $(".promoted_staff_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".promoted_staff_report_checkbox").val(1);
            data.push({
                name: "Transferred_Staff_Reports",
                permission: [
                    {
                        "name":"Transferred Staff Reports",
                        "table_id":"23",
                        "is_view": $("#transferred_staff_report_check_view").val(),
                        "is_print": $("#transferred_staff_report_check_print").val(),
                        "is_export": $("#transferred_staff_report_check_export").val(),
                    },
                ]
            })
        }
        
    });
    $(document).ready(function(){
        var checkboxes = $('.reports_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.reports_checkbox').length) {
                $("#reports_check_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.reports_checkbox').length) {
                $("#reports_check_all").prop("checked", false);
            };
        });
    });

    // blcok configuration
    $("#configuration_check_all").on("click", function(){
            if (!$(this).prop("checked")) {
                $(".configuration_checkbox").prop("checked", false);
                data = data.filter(item => item.name !== "configuration")
            }
            if ($(this).prop("checked")) {
                $(".configuration_checkbox").prop("checked", true);
                $(this).val(1)
                $(".configuration_checkbox").val(1);
                data.push({
                    name: "configuration",
                    permission: [
                        {
                            "is_all": $(this).val(),
                            "name":"Configuration",
                        },
                        {
                            "name":"Tax",
                            "table_id":"24",
                            "is_view": $("#taxes_check_view").val(),
                            "is_create": $("#taxes_check_add").val(),
                            "is_update": $("#taxes_check_edit").val(),
                            "is_delete": $("#taxes_check_delete").val(),
                        },
                        {
                            "name":"Exchange Rate",
                            "table_id":"25",
                            "is_view": $("#exchange_rate_check_view").val(),
                            "is_create": $("#exchange_rate_check_add").val(),
                            "is_update": $("#exchange_rate_check_edit").val(),
                            "is_delete": $("#exchange_rate_check_delete").val(),
                        },
                        {
                            "name":"Public Holidays",
                            "table_id":"12",
                            "is_view": $("#public_holidays_check_view").val(),
                            "is_create": $("#public_holidays_check_add").val(),
                            "is_update": $("#public_holidays_check_edit").val(),
                            "is_delete": $("#public_holidays_check_delete").val(),
                        },
                        {
                            "name":"Children Allowance",
                            "table_id":"26",
                            "is_view": $("#children_allowance_check_view").val(),
                            "is_create": $("#children_allowance_check_add").val(),
                            "is_update": $("#children_allowance_check_edit").val(),
                            "is_delete": $("#children_allowance_check_delete").val(),
                        },
                        
                    ]
                });
            }
    });
    $("#taxes").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".taxes_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Tax")
        }
        if ($(this).prop("checked")) {
            $(".taxes_checkbox").prop("checked", true);
            $(this).val(1)
            $(".taxes_checkbox").val(1);
            data.push({
                name: "Tax",
                permission: [
                    {
                        "name":"Tax",
                        "table_id":"24",
                        "is_view": $("#taxes_check_view").val(),
                        "is_create": $("#taxes_check_add").val(),
                        "is_update": $("#taxes_check_edit").val(),
                        "is_delete": $("#taxes_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $("#exchange_rate").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".exchange_rate_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Exchange_Rate")
        }
        if ($(this).prop("checked")) {
            $(".exchange_rate_checkbox").prop("checked", true);
            $(this).val(1)
            $(".exchange_rate_checkbox").val(1);
            data.push({
                name: "Exchange_Rate",
                permission: [
                    {
                        "name":"Exchange Rate",
                        "table_id":"25",
                        "is_view": $("#exchange_rate_check_view").val(),
                        "is_create": $("#exchange_rate_check_add").val(),
                        "is_update": $("#exchange_rate_check_edit").val(),
                        "is_delete": $("#exchange_rate_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $("#public_holidays").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".public_holidays_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Public_Holidays")
        }
        if ($(this).prop("checked")) {
            $(".public_holidays_checkbox").prop("checked", true);
            $(this).val(1)
            $(".public_holidays_checkbox").val(1);
            data.push({
                name: "Public_Holidays",
                permission: [
                    {
                        "name":"Public Holidays",
                        "table_id":"12",
                        "is_view": $("#public_holidays_check_view").val(),
                        "is_create": $("#public_holidays_check_add").val(),
                        "is_update": $("#public_holidays_check_edit").val(),
                        "is_delete": $("#public_holidays_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $("#children_allowance").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".children_allowance_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Children_Allowance")
        }
        if ($(this).prop("checked")) {
            $(".children_allowance_checkbox").prop("checked", true);
            $(this).val(1)
            $(".children_allowance_checkbox").val(1);
            data.push({
                name: "Children_Allowance",
                permission: [
                    {
                        "name":"Children Allowance",
                        "table_id":"26",
                        "is_view": $("#children_allowance_check_view").val(),
                        "is_create": $("#children_allowance_check_add").val(),
                        "is_update": $("#children_allowance_check_edit").val(),
                        "is_delete": $("#children_allowance_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $(document).ready(function(){
        var checkboxes = $('.configuration_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.configuration_checkbox').length) {
                $("#configuration_check_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.configuration_checkbox').length) {
                $("#configuration_check_all").prop("checked", false);
            };
        });
    });

    // blcok setting
    $("#setting_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".setting_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "setting")
        }
        if ($(this).prop("checked")) {
            $(".setting_checkbox").prop("checked", true);
            $(this).val(1)
            $(".setting_checkbox").val(1);
            data.push({
                name: "setting",
                permission: [
                    {
                        "is_all": $(this).val(),
                        "name":"Setting",
                    },
                    {
                        "name":"Bank",
                        "table_id":"13",
                        "is_view": $("#bank_check_view").val(),
                        "is_create": $("#bank_check_add").val(),
                        "is_update": $("#bank_check_edit").val(),
                        "is_delete": $("#bank_check_delete").val(),
                    },
                    {
                        "name":"Position",
                        "table_id":"15",
                        "is_view": $("#position_check_view").val(),
                        "is_create": $("#position_check_add").val(),
                        "is_update": $("#position_check_edit").val(),
                        "is_delete": $("#position_check_delete").val(),
                    },
                    {
                        "name":"Branch",
                        "table_id":"16",
                        "is_view": $("#branch_check_view").val(),
                        "is_create": $("#branch_check_add").val(),
                        "is_update": $("#branch_check_edit").val(),
                        "is_delete": $("#branch_check_delete").val(),
                    },
                    {
                        "name":"Department",
                        "table_id":"14",
                        "is_view": $("#department_check_view").val(),
                        "is_create": $("#department_check_add").val(),
                        "is_update": $("#department_check_edit").val(),
                        "is_delete": $("#department_check_delete").val(),
                    },
                    {
                        "name":"Forgot Password",
                        "is_view": $("#forgot_password_check_view").val(),
                        "is_create": $("#forgot_password_check_add").val(),
                        "is_update": $("#forgot_password_check_edit").val(),
                        "is_delete": $("#forgot_password_check_delete").val(),
                    },
                    
                ]
            });
        }
    });
    $("#bank").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".bank_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Bank")
        }
        if ($(this).prop("checked")) {
            $(".bank_checkbox").prop("checked", true);
            $(this).val(1)
            $(".bank_checkbox").val(1);
            data.push({
                name: "Bank",
                permission: [
                    {
                        "name":"Bank",
                        "table_id":"13",
                        "is_view": $("#bank_check_view").val(),
                        "is_create": $("#bank_check_add").val(),
                        "is_update": $("#bank_check_edit").val(),
                        "is_delete": $("#bank_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $("#position").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".position_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Position")
        }
        if ($(this).prop("checked")) {
            $(".position_checkbox").prop("checked", true);
            $(this).val(1)
            $(".position_checkbox").val(1);
            data.push({
                name: "Position",
                permission: [
                    {
                        "name":"Position",
                        "table_id":"15",
                        "is_view": $("#position_check_view").val(),
                        "is_create": $("#position_check_add").val(),
                        "is_update": $("#position_check_edit").val(),
                        "is_delete": $("#position_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $("#branch").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".branch_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Branch")
        }
        if ($(this).prop("checked")) {
            $(".branch_checkbox").prop("checked", true);
            $(this).val(1)
            $(".branch_checkbox").val(1);
            data.push({
                name: "Branch",
                permission: [
                    {
                        "name":"Branch",
                        "table_id":"16",
                        "is_view": $("#branch_check_view").val(),
                        "is_create": $("#branch_check_add").val(),
                        "is_update": $("#branch_check_edit").val(),
                        "is_delete": $("#branch_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $("#department").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".department_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Department")
        }
        if ($(this).prop("checked")) {
            $(".department_checkbox").prop("checked", true);
            $(this).val(1)
            $(".department_checkbox").val(1);
            data.push({
                name: "Department",
                permission: [
                    {
                        "name":"Department",
                        "table_id":"14",
                        "is_view": $("#department_check_view").val(),
                        "is_create": $("#department_check_add").val(),
                        "is_update": $("#department_check_edit").val(),
                        "is_delete": $("#department_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $("#forgot_password").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".forgot_password_checkbox").prop("checked", false);
            data = data.filter(item => item.name !== "Forgot_Password")
        }
        if ($(this).prop("checked")) {
            $(".forgot_password_checkbox").prop("checked", true);
            $(this).val(1)
            $(".forgot_password_checkbox").val(1);
            data.push({
                name: "Forgot_Password",
                permission: [
                    {
                        "name":"Forgot Password",
                        "is_view": $("#forgot_password_check_view").val(),
                        "is_create": $("#forgot_password_check_add").val(),
                        "is_update": $("#forgot_password_check_edit").val(),
                        "is_delete": $("#forgot_password_check_delete").val(),
                    },
                ]
            })
        }
        
    });
    $(document).ready(function(){
        var checkboxes = $('.setting_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.setting_checkbox').length) {
                $("#setting_check_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.setting_checkbox').length) {
                $("#setting_check_all").prop("checked", false);
            };
        });
    });

    // blcok role
    $("#role_check_all").on("click", function(){
            if (!$(this).prop("checked")) {
                $(".role_checkbox").prop("checked", false);
                data = data.filter(item => item.name !== "role")
            }
            if ($(this).prop("checked")) {
                $(".role_checkbox").prop("checked", true);
                $(this).val(1)
                $(".role_checkbox").val(1);
                data.push({
                    name: "role",
                    permission: [
                        {
                            "is_all": $(this).val(),
                            "name":"Role",
                        },
                        {
                            "name":"Permission",
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
    });
    $(document).ready(function(){
        var checkboxes = $('.role_checkbox');
        checkboxes.change(function(){
            var countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.role_checkbox').length) {
                $("#role_check_all").prop("checked", true);
            };
            if (countCheckedCheckboxes < $('input.role_checkbox').length) {
                $("#role_check_all").prop("checked", false);
            };
        });
    });
    return data;
}