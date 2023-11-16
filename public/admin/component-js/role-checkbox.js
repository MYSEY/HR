
$(function(){
    // block dahboard
    $("#dashboad_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".dashboad_checkbox").prop("checked", false);
            $(".dashboad_checkbox").val(0);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".dashboad_checkbox").prop("checked", true);
            $(this).val(1)
            $(".dashboad_checkbox").val(1);
        }
    });
    $(".dashboad_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let checkboxes = $('.dashboad_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.dashboad_checkbox').length) {
                $("#dashboad_all").prop("checked", true);
                $("#dashboad_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.dashboad_checkbox').length) {
                $("#dashboad_all").prop("checked", false);
                $("#dashboad_all").val(0)
            };
        });
    });

    // blcok employee
    $("#employee_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".employee_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".employee_checkbox").prop("checked", true);
            $(this).val(1)
            $(".employee_checkbox").val(1);
        }    
    });
    $("#all_employee").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".all_employee_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".all_employee_checkbox").prop("checked", true);
            $(this).val(1)
            $(".all_employee_checkbox").val(1);
        }
        
    });
    $(".all_employee_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
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
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".leaves_employee_checkbox").prop("checked", true);
            $(this).val(1)
            $(".leaves_employee_checkbox").val(1);
        }
        
    });
    $(".leaves_employee_checkbox").on("click", function () {
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let allEmployees = $('.all_employee_checkbox');
        allEmployees.change(function(){
            let countAllCheckboxes = allEmployees.filter(':checked').length;
            if (countAllCheckboxes == $('input.all_employee_checkbox').length) {
                $("#all_employee").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.all_employee_checkbox').length) {
                $("#all_employee").prop("checked", false);
            };
        });

        let leavesEmployee = $('.leaves_employee_checkbox');
        leavesEmployee.change(function(){
            let countleavesEmployeeCheckboxes = leavesEmployee.filter(':checked').length;
            if (countleavesEmployeeCheckboxes == $('input.leaves_employee_checkbox').length) {
                $("#leaves_employee").prop("checked", true);
            };
            if (countleavesEmployeeCheckboxes < $('input.leaves_employee_checkbox').length) {
                $("#leaves_employee").prop("checked", false);
            };
        });

        let checkboxes = $('.employee_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.employee_checkbox').length) {
                $("#employee_all").prop("checked", true);
                $("#employee_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.employee_checkbox').length) {
                $("#employee_all").prop("checked", false);
                $("#employee_all").val(0)
            };
        });
    });

    // blcok recruitment
    $("#recruitments_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".recruitment_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".recruitment_checkbox").prop("checked", true);
            $(this).val(1)
            $(".recruitment_checkbox").val(1);
        }   
    });
    $("#candidate_CVs").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".candidate_CVs_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".candidate_CVs_checkbox").prop("checked", true);
            $(this).val(1)
            $(".candidate_CVs_checkbox").val(1);
        }
    });
    $(".candidate_CVs_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#recruitment_plans").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".recruitment_plans_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".recruitment_plans_checkbox").prop("checked", true);
            $(this).val(1)
            $(".recruitment_plans_checkbox").val(1);
        }
    });
    $(".recruitment_plans_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let candidate_CVs_checkbox = $('.candidate_CVs_checkbox');
        candidate_CVs_checkbox.change(function(){
            let countAllCheckboxes = candidate_CVs_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.candidate_CVs_checkbox').length) {
                $("#candidate_CVs").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.candidate_CVs_checkbox').length) {
                $("#candidate_CVs").prop("checked", false);
            };
        });

        let recruitment_plans_checkbox = $('.recruitment_plans_checkbox');
        recruitment_plans_checkbox.change(function(){
            let countAllCheckboxes = recruitment_plans_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.recruitment_plans_checkbox').length) {
                $("#recruitment_plans").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.recruitment_plans_checkbox').length) {
                $("#recruitment_plans").prop("checked", false);
            };
        });

        let checkboxes = $('.recruitment_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.recruitment_checkbox').length) {
                $("#recruitments_all").prop("checked", true);
                $("#recruitments_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.recruitment_checkbox').length) {
                $("#recruitments_all").prop("checked", false);
                $("#recruitments_all").val(0)
            };
        });
    });

    // blcok C&B
    $("#c_and_b_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".c_and_b_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".c_and_b_checkbox").prop("checked", true);
            $(this).val(1)
            $(".c_and_b_checkbox").val(1);
        }
    });
    $("#employee_salary").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".employee_salary_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".employee_salary_checkbox").prop("checked", true);
            $(this).val(1)
            $(".employee_salary_checkbox").val(1);
        }
    });
    $(".employee_salary_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#cb_nssf").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".cb_nssf_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".cb_nssf_checkbox").prop("checked", true);
            $(this).val(1)
            $(".cb_nssf_checkbox").val(1);
        }
    });
    $(".cb_nssf_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#severance_pay").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".severance_pay_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".severance_pay_checkbox").prop("checked", true);
            $(this).val(1)
            $(".severance_pay_checkbox").val(1);
        }
    });
    $(".severance_pay_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#fringe_benefits").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".fringe_benefits_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".fringe_benefits_checkbox").prop("checked", true);
            $(this).val(1)
            $(".fringe_benefits_checkbox").val(1);
        }
    });
    $(".fringe_benefits_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });

    $(document).ready(function(){
        let employee_salary_checkbox = $('.employee_salary_checkbox');
        employee_salary_checkbox.change(function(){
            let countAllCheckboxes = employee_salary_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.employee_salary_checkbox').length) {
                $("#employee_salary").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.employee_salary_checkbox').length) {
                $("#employee_salary").prop("checked", false);
            };
        });

        let cb_nssf_checkbox = $('.cb_nssf_checkbox');
        cb_nssf_checkbox.change(function(){
            let countAllCheckboxes = cb_nssf_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.cb_nssf_checkbox').length) {
                $("#cb_nssf").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.cb_nssf_checkbox').length) {
                $("#cb_nssf").prop("checked", false);
            };
        });

        let severance_pay_checkbox = $('.severance_pay_checkbox');
        severance_pay_checkbox.change(function(){
            let countAllCheckboxes = severance_pay_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.severance_pay_checkbox').length) {
                $("#severance_pay").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.severance_pay_checkbox').length) {
                $("#severance_pay").prop("checked", false);
            };
        });

        let fringe_benefits_checkbox = $('.fringe_benefits_checkbox');
        fringe_benefits_checkbox.change(function(){
            let countAllCheckboxes = fringe_benefits_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.fringe_benefits_checkbox').length) {
                $("#fringe_benefits").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.fringe_benefits_checkbox').length) {
                $("#fringe_benefits").prop("checked", false);
            };
        });

        let checkboxes = $('.c_and_b_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.c_and_b_checkbox').length) {
                $("#c_and_b_all").prop("checked", true);
                $("#c_and_b_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.c_and_b_checkbox').length) {
                $("#c_and_b_all").prop("checked", false);
                $("#c_and_b_all").val(0)
            };
        });
    });

    // blcok motor rental
    $("#motor_rental_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".motor_rental_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".motor_rental_checkbox").prop("checked", true);
            $(this).val(1)
            $(".motor_rental_checkbox").val(1);
        }
    });
    $("#motor_rentals").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".motor_rentals_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".motor_rentals_checkbox").prop("checked", true);
            $(this).val(1)
            $(".motor_rentals_checkbox").val(1);
        }
    });
    $(".motor_rentals_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#pay_motor_rentals").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".pay_motor_rentals_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".pay_motor_rentals_checkbox").prop("checked", true);
            $(this).val(1)
            $(".pay_motor_rentals_checkbox").val(1);
        }
    });
    $(".pay_motor_rentals_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let motor_rentals_checkbox = $('.motor_rentals_checkbox');
        motor_rentals_checkbox.change(function(){
            let countAllCheckboxes = motor_rentals_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.motor_rentals_checkbox').length) {
                $("#motor_rentals").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.motor_rentals_checkbox').length) {
                $("#motor_rentals").prop("checked", false);
            };
        });

        let pay_motor_rentals_checkbox = $('.pay_motor_rentals_checkbox');
        pay_motor_rentals_checkbox.change(function(){
            let countAllCheckboxes = pay_motor_rentals_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.pay_motor_rentals_checkbox').length) {
                $("#pay_motor_rentals").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.pay_motor_rentals_checkbox').length) {
                $("#pay_motor_rentals").prop("checked", false);
            };
        });

        let checkboxes = $('.motor_rental_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.motor_rental_checkbox').length) {
                $("#motor_rental_check_all").prop("checked", true);
                $("#motor_rental_check_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.motor_rental_checkbox').length) {
                $("#motor_rental_check_all").prop("checked", false);
                $("#motor_rental_check_all").val(0)
            };
        });
    });

    // blcok training
    $("#training_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".training_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".training_checkbox").prop("checked", true);
            $(this).val(1)
            $(".training_checkbox").val(1);
        }
    });
    $("#trainer").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".trainer_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".trainer_checkbox").prop("checked", true);
            $(this).val(1)
            $(".trainer_checkbox").val(1);
        }
    });
    $(".trainer_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#training").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".training_checkbox_block").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".training_checkbox_block").prop("checked", true);
            $(this).val(1)
            $(".training_checkbox_block").val(1);
        }
    });
    $(".training_checkbox_block").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#training_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".training_reports_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".training_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".training_reports_checkbox").val(1);
        }
    });
    $(".training_reports_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let trainer_checkbox = $('.trainer_checkbox');
        trainer_checkbox.change(function(){
            let countAllCheckboxes = trainer_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.trainer_checkbox').length) {
                $("#trainer").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.trainer_checkbox').length) {
                $("#trainer").prop("checked", false);
            };
        });
        let training_checkbox_block = $('.training_checkbox_block');
        training_checkbox_block.change(function(){
            let countAllCheckboxes = training_checkbox_block.filter(':checked').length;
            if (countAllCheckboxes == $('input.training_checkbox_block').length) {
                $("#training").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.training_checkbox_block').length) {
                $("#training").prop("checked", false);
            };
        });
        let training_reports_checkbox = $('.training_reports_checkbox');
        training_reports_checkbox.change(function(){
            let countAllCheckboxes = training_reports_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.training_reports_checkbox').length) {
                $("#training_reports").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.training_reports_checkbox').length) {
                $("#training_reports").prop("checked", false);
            };
        });

        let checkboxes = $('.training_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.training_checkbox').length) {
                $("#training_check_all").prop("checked", true);
                $("#training_check_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.training_checkbox').length) {
                $("#training_check_all").prop("checked", false);
                $("#training_check_all").val(0)
            };
        });
    });

    // blcok reports
    $("#reports_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".reports_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".reports_checkbox").val(1);
        }
    });
    $("#employee_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".employee_reports_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".employee_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".employee_reports_checkbox").val(1);
        }
    });
    $(".employee_reports_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#payroll_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".payroll_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".payroll_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".payroll_report_checkbox").val(1);
        }
    });
    $(".payroll_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#tax_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".tax_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".tax_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".tax_report_checkbox").val(1);
        }
    });
    $(".tax_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#nssf_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".nssf_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".nssf_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".nssf_report_checkbox").val(1);
        }
    });
    $(".nssf_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#kmh_pchum_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".kmh_pchum_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".kmh_pchum_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".kmh_pchum_report_checkbox").val(1);
        }
    });
    $(".kmh_pchum_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#severance_pay_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".severance_pay_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".severance_pay_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".severance_pay_report_checkbox").val(1);
        }
    });
    $(".severance_pay_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#seniorities_pay_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".seniorities_pay_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".seniorities_pay_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".seniorities_pay_report_checkbox").val(1);
        }
    });
    $(".seniorities_pay_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#fringe_benefits_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".fringe_benefits_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".fringe_benefits_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".fringe_benefits_report_checkbox").val(1);
        }
    });
    $(".fringe_benefits_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#bank_transfer_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".bank_transfer_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".bank_transfer_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".bank_transfer_report_checkbox").val(1);
        }
    });
    $(".bank_transfer_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#e_filing_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".e_filing_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".e_filing_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".e_filing_report_checkbox").val(1);
        }
    });
    $(".e_filing_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#e_form_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".e_form_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".e_form_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".e_form_report_checkbox").val(1);
        }
    });
    $(".e_form_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#motor_rental_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".motor_rental_reports_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".motor_rental_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".motor_rental_reports_checkbox").val(1);
        }
    });
    $(".motor_rental_reports_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#new_staff_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".new_staff_reports_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".new_staff_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".new_staff_reports_checkbox").val(1);
        }
    });
    $(".new_staff_reports_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#staff_resigned_reports").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".staff_resigned_reports_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".staff_resigned_reports_checkbox").prop("checked", true);
            $(this).val(1)
            $(".staff_resigned_reports_checkbox").val(1);
        }
    });
    $(".staff_resigned_reports_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#transferred_staff_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".transferred_staff_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".transferred_staff_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".transferred_staff_report_checkbox").val(1);
        }
    });
    $(".transferred_staff_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#promoted_staff_report").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".promoted_staff_report_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".promoted_staff_report_checkbox").prop("checked", true);
            $(this).val(1)
            $(".promoted_staff_report_checkbox").val(1);
        }
    });
    $(".promoted_staff_report_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let employee_reports_checkbox = $('.employee_reports_checkbox');
        employee_reports_checkbox.change(function(){
            let countAllCheckboxes = employee_reports_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.employee_reports_checkbox').length) {
                $("#employee_reports").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.employee_reports_checkbox').length) {
                $("#employee_reports").prop("checked", false);
            };
        });
        let payroll_report_checkbox = $('.payroll_report_checkbox');
        payroll_report_checkbox.change(function(){
            let countAllCheckboxes = payroll_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.payroll_report_checkbox').length) {
                $("#payroll_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.payroll_report_checkbox').length) {
                $("#payroll_report").prop("checked", false);
            };
        });
        let tax_report_checkbox = $('.tax_report_checkbox');
        tax_report_checkbox.change(function(){
            let countAllCheckboxes = tax_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.tax_report_checkbox').length) {
                $("#tax_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.tax_report_checkbox').length) {
                $("#tax_report").prop("checked", false);
            };
        });
        let nssf_report_checkbox = $('.nssf_report_checkbox');
        nssf_report_checkbox.change(function(){
            let countAllCheckboxes = nssf_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.nssf_report_checkbox').length) {
                $("#nssf_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.nssf_report_checkbox').length) {
                $("#nssf_report").prop("checked", false);
            };
        });
        let kmh_pchum_report_checkbox = $('.kmh_pchum_report_checkbox');
        kmh_pchum_report_checkbox.change(function(){
            let countAllCheckboxes = kmh_pchum_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.kmh_pchum_report_checkbox').length) {
                $("#kmh_pchum_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.kmh_pchum_report_checkbox').length) {
                $("#kmh_pchum_report").prop("checked", false);
            };
        });
        let severance_pay_report_checkbox = $('.severance_pay_report_checkbox');
        severance_pay_report_checkbox.change(function(){
            let countAllCheckboxes = severance_pay_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.severance_pay_report_checkbox').length) {
                $("#severance_pay_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.severance_pay_report_checkbox').length) {
                $("#severance_pay_report").prop("checked", false);
            };
        });
        let seniorities_pay_report_checkbox = $('.seniorities_pay_report_checkbox');
        seniorities_pay_report_checkbox.change(function(){
            let countAllCheckboxes = seniorities_pay_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.seniorities_pay_report_checkbox').length) {
                $("#seniorities_pay_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.seniorities_pay_report_checkbox').length) {
                $("#seniorities_pay_report").prop("checked", false);
            };
        });
        let fringe_benefits_report_checkbox = $('.fringe_benefits_report_checkbox');
        fringe_benefits_report_checkbox.change(function(){
            let countAllCheckboxes = fringe_benefits_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.fringe_benefits_report_checkbox').length) {
                $("#fringe_benefits_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.fringe_benefits_report_checkbox').length) {
                $("#fringe_benefits_report").prop("checked", false);
            };
        });
        let bank_transfer_report_checkbox = $('.bank_transfer_report_checkbox');
        bank_transfer_report_checkbox.change(function(){
            let countAllCheckboxes = bank_transfer_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.bank_transfer_report_checkbox').length) {
                $("#bank_transfer_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.bank_transfer_report_checkbox').length) {
                $("#bank_transfer_report").prop("checked", false);
            };
        });
        let e_filing_report_checkbox = $('.e_filing_report_checkbox');
        e_filing_report_checkbox.change(function(){
            let countAllCheckboxes = e_filing_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.e_filing_report_checkbox').length) {
                $("#e_filing_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.e_filing_report_checkbox').length) {
                $("#e_filing_report").prop("checked", false);
            };
        });
        let e_form_report_checkbox = $('.e_form_report_checkbox');
        e_form_report_checkbox.change(function(){
            let countAllCheckboxes = e_form_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.e_form_report_checkbox').length) {
                $("#e_form_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.e_form_report_checkbox').length) {
                $("#e_form_report").prop("checked", false);
            };
        });
        let motor_rental_reports_checkbox = $('.motor_rental_reports_checkbox');
        motor_rental_reports_checkbox.change(function(){
            let countAllCheckboxes = motor_rental_reports_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.motor_rental_reports_checkbox').length) {
                $("#motor_rental_reports").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.motor_rental_reports_checkbox').length) {
                $("#motor_rental_reports").prop("checked", false);
            };
        });
        let new_staff_reports_checkbox = $('.new_staff_reports_checkbox');
        new_staff_reports_checkbox.change(function(){
            let countAllCheckboxes = new_staff_reports_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.new_staff_reports_checkbox').length) {
                $("#new_staff_reports").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.new_staff_reports_checkbox').length) {
                $("#new_staff_reports").prop("checked", false);
            };
        });
        let staff_resigned_reports_checkbox = $('.staff_resigned_reports_checkbox');
        staff_resigned_reports_checkbox.change(function(){
            let countAllCheckboxes = staff_resigned_reports_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.staff_resigned_reports_checkbox').length) {
                $("#staff_resigned_reports").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.staff_resigned_reports_checkbox').length) {
                $("#staff_resigned_reports").prop("checked", false);
            };
        });
        let transferred_staff_report_checkbox = $('.transferred_staff_report_checkbox');
        transferred_staff_report_checkbox.change(function(){
            let countAllCheckboxes = transferred_staff_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.transferred_staff_report_checkbox').length) {
                $("#transferred_staff_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.transferred_staff_report_checkbox').length) {
                $("#transferred_staff_report").prop("checked", false);
            };
        });
        let promoted_staff_report_checkbox = $('.promoted_staff_report_checkbox');
        promoted_staff_report_checkbox.change(function(){
            let countAllCheckboxes = promoted_staff_report_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.promoted_staff_report_checkbox').length) {
                $("#promoted_staff_report").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.promoted_staff_report_checkbox').length) {
                $("#promoted_staff_report").prop("checked", false);
            };
        });
        let checkboxes = $('.reports_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.reports_checkbox').length) {
                $("#reports_check_all").prop("checked", true);
                $("#reports_check_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.reports_checkbox').length) {
                $("#reports_check_all").prop("checked", false);
                $("#reports_check_all").val(0)
            };
        });
    });

    // blcok configuration
    $("#configuration_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".configuration_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".configuration_checkbox").prop("checked", true);
            $(this).val(1)
            $(".configuration_checkbox").val(1);
        }
    });
    $("#taxes").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".taxes_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".taxes_checkbox").prop("checked", true);
            $(this).val(1)
            $(".taxes_checkbox").val(1);
        }
    });
    $(".taxes_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#exchange_rate").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".exchange_rate_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".exchange_rate_checkbox").prop("checked", true);
            $(this).val(1)
            $(".exchange_rate_checkbox").val(1);
        }
    });
    $(".exchange_rate_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#public_holidays").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".public_holidays_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".public_holidays_checkbox").prop("checked", true);
            $(this).val(1)
            $(".public_holidays_checkbox").val(1);
        }
    });
    $(".public_holidays_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#children_allowance").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".children_allowance_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".children_allowance_checkbox").prop("checked", true);
            $(this).val(1)
            $(".children_allowance_checkbox").val(1);
        }
    });
    $(".children_allowance_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let taxes_checkbox = $('.taxes_checkbox');
        taxes_checkbox.change(function(){
            let countAllCheckboxes = taxes_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.taxes_checkbox').length) {
                $("#taxes").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.taxes_checkbox').length) {
                $("#taxes").prop("checked", false);
            };
        });
        let exchange_rate_checkbox = $('.exchange_rate_checkbox');
        exchange_rate_checkbox.change(function(){
            let countAllCheckboxes = exchange_rate_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.exchange_rate_checkbox').length) {
                $("#exchange_rate").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.exchange_rate_checkbox').length) {
                $("#exchange_rate").prop("checked", false);
            };
        });
        let public_holidays_checkbox = $('.public_holidays_checkbox');
        public_holidays_checkbox.change(function(){
            let countAllCheckboxes = public_holidays_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.public_holidays_checkbox').length) {
                $("#public_holidays").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.public_holidays_checkbox').length) {
                $("#public_holidays").prop("checked", false);
            };
        });
        let children_allowance_checkbox = $('.children_allowance_checkbox');
        children_allowance_checkbox.change(function(){
            let countAllCheckboxes = children_allowance_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.children_allowance_checkbox').length) {
                $("#children_allowance").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.children_allowance_checkbox').length) {
                $("#children_allowance").prop("checked", false);
            };
        });
        let checkboxes = $('.configuration_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.configuration_checkbox').length) {
                $("#configuration_check_all").prop("checked", true);
                $("#configuration_check_all").val(1)
            };
            if (countCheckedCheckboxes < $('input.configuration_checkbox').length) {
                $("#configuration_check_all").prop("checked", false);
                $("#configuration_check_all").val(0)
            };
        });
    });

    // blcok setting
    $("#setting_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".setting_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".setting_checkbox").prop("checked", true);
            $(this).val(1)
            $(".setting_checkbox").val(1);
        }
    });
    $("#bank").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".bank_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".bank_checkbox").prop("checked", true);
            $(this).val(1)
            $(".bank_checkbox").val(1);
        }
    });
    $(".bank_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#position").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".position_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".position_checkbox").prop("checked", true);
            $(this).val(1)
            $(".position_checkbox").val(1);
        }
    });
    $(".position_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#branch").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".branch_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".branch_checkbox").prop("checked", true);
            $(this).val(1)
            $(".branch_checkbox").val(1);
        }
    });
    $(".branch_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#department").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".department_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".department_checkbox").prop("checked", true);
            $(this).val(1)
            $(".department_checkbox").val(1);
        }
    });
    $(".department_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $("#forgot_password").on("click", function() {
        if (!$(this).prop("checked")) {
            $(".forgot_password_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".forgot_password_checkbox").prop("checked", true);
            $(this).val(1)
            $(".forgot_password_checkbox").val(1);
        }
    });
    $(".forgot_password_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let bank_checkbox = $('.bank_checkbox');
        bank_checkbox.change(function(){
            let countAllCheckboxes = bank_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.bank_checkbox').length) {
                $("#bank").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.bank_checkbox').length) {
                $("#bank").prop("checked", false);
            };
        });
        let position_checkbox = $('.position_checkbox');
        position_checkbox.change(function(){
            let countAllCheckboxes = position_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.position_checkbox').length) {
                $("#position").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.position_checkbox').length) {
                $("#position").prop("checked", false);
            };
        });
        let branch_checkbox = $('.branch_checkbox');
        branch_checkbox.change(function(){
            let countAllCheckboxes = branch_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.branch_checkbox').length) {
                $("#branch").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.branch_checkbox').length) {
                $("#branch").prop("checked", false);
            };
        });
        let department_checkbox = $('.department_checkbox');
        department_checkbox.change(function(){
            let countAllCheckboxes = department_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.department_checkbox').length) {
                $("#department").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.department_checkbox').length) {
                $("#department").prop("checked", false);
            };
        });
        let forgot_password_checkbox = $('.forgot_password_checkbox');
        forgot_password_checkbox.change(function(){
            let countAllCheckboxes = forgot_password_checkbox.filter(':checked').length;
            if (countAllCheckboxes == $('input.forgot_password_checkbox').length) {
                $("#forgot_password").prop("checked", true);
            };
            if (countAllCheckboxes < $('input.forgot_password_checkbox').length) {
                $("#forgot_password").prop("checked", false);
            };
        });
        let checkboxes = $('.setting_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.setting_checkbox').length) {
                $("#setting_check_all").prop("checked", true);
                $("#setting_check_all").val(1);
            };
            if (countCheckedCheckboxes < $('input.setting_checkbox').length) {
                $("#setting_check_all").prop("checked", false);
                $("#setting_check_all").val(0);
            };
        });
    });

    // blcok role
    $("#role_check_all").on("click", function(){
        if (!$(this).prop("checked")) {
            $(".role_checkbox").prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(".role_checkbox").prop("checked", true);
            $(this).val(1)
            $(".role_checkbox").val(1);
        }
    });
    $(".role_checkbox").on("click", function(){
        if (!$(this).prop("checked")) {
            $(this).prop("checked", false);
            $(this).val(0)
        }
        if ($(this).prop("checked")) {
            $(this).prop("checked", true);
            $(this).val(1)
        }
    });
    $(document).ready(function(){
        let checkboxes = $('.role_checkbox');
        checkboxes.change(function(){
            let countCheckedCheckboxes = checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes == $('input.role_checkbox').length) {
                $("#role_check_all").prop("checked", true);
                $("#role_check_all").val(1);
            };
            if (countCheckedCheckboxes < $('input.role_checkbox').length) {
                $("#role_check_all").prop("checked", false);
                $("#role_check_all").val(0);
            };
        });
    });
});