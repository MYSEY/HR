@extends('layouts.master')
<style>
    .card_background_color {
        background-color: #f8f9fa !important;
    }
    /* The container checkbox */
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.add_roles')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/role') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.add_roles')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade active show" id="bank_statutory" role="tabpanel">
        <div class="card card_background_color">
            <div class="card-body">
                <form >
                    <input type="text" hidden name="parent_id" id="parent_id" value="{{Auth::user()->role_id}}">
                    {{-- @csrf --}}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">@lang('lang.name') <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    id="role_name" required name="role_name" value="{{ old('role_name') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">@lang('lang.type') <span class="text-danger">*</span></label>
                                <select class="form-control" id="role_type" name="role_type" required>
                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                    <option value="admin">@lang('lang.admin')</option>
                                    <option value="developer">@lang('lang.developer')</option>
                                    <option value="employee">@lang('lang.employee')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">@lang('lang.remark')</label>
                                <textarea style="height: 44px;" type="text" rows="3" class="form-control" name="remark" id="remark" value="{{ old('remark') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity"
                        bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0"
                            style="width: 100%; font-size: 22px;font-weight: normal !important;">@lang('lang.permission')
                            <span class="text-danger">*</span></label>
                    </div>
                    {{-- Block dashboad --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: normal !important;">@lang('lang.dashboard')</label>
                        </div>
                       <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="container-checkbox">@lang('lang.all')
                                        <input type="checkbox" id="dashboad_all" name="dashboad_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.employee')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_employee" name="dashboad_employee"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.age_of_employee')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_age_of_employee" name="dashboad_age_of_employee"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.birthday_reminder')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_birthday_reminder" name="dashboad_birthday_reminder"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                       </div>
                       <div class="col-md-3">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="container-checkbox">@lang('lang.total_number_of_staff')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_number_of_staff" name="dashboad_total_number_of_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.total_inactive_staff')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_inactive_staff" name="dashboad_total_inactive_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.resigned_staff')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_resigned_staff" name="dashboad_resigned_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang("lang.reasons_of_staff’s_exit")
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_reasons_of_staff’s_exit" name="dashboad_reasons"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-3">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="container-checkbox">% @lang('lang.staff_ratio')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_ratio" name="dashboad_staff_ratio"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_taking_leave')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_taking_leave" name="dashboad_staff_taking_leave"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_training_by_branch') (Internal)
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch" name="dashboad_staff_training_by_branch"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_training_by_branch') (External)
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch_external" name="dashboad_staff_training_by_branch_external"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- Block Employee --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.employee')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="employee_all" name="employee_all"> <span class="checkmark"></span>
                            </label>
                        </div>
                       <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.all_employee')
                                        <input type="checkbox" class="employee_checkbox" id="all_employee" name="all_employee"> <span class="checkmark"></span>
                                    </label>
                                    {{-- <label >@lang('lang.all_employee')</label> --}}
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_view" data-id="1" data-name="is_view" name="employee_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_add" data-id="1" data-name="is_add" name="employee_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_import" data-id="1" data-name="is_import" name="employee_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_edit" data-id="1" data-name="is_update" name="employee_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_delete" name="employee_delete" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.cancel')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_cancel" name="employee_cancel"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_print" name="employee_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_export" name="employee_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                         {{-- block leave employee --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.leaves_employee')</label> --}}
                                    <label class="container-checkbox">@lang('lang.leaves_employee')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee" name="leaves_employee"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_view" name="leaves_employee_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_add" name="leaves_employee_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_import" name="leaves_employee_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_edit" name="leaves_employee_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_delete" name="leaves_employee_delete" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.cancel')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_cancel" name="leaves_employee_cancel"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_print" name="leaves_employee_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_export" name="leaves_employee_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                     {{-- block Recruitment --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.recruitments')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="recruitments_all" name="recruitments_all"> <span class="checkmark"></span>
                            </label>
                        </div>
                        {{-- block Candidate CVs --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.candidate_CVs')</label> --}}
                                    <label class="container-checkbox">@lang('lang.candidate_CVs')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_CVs" name="candidate_CVs"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_view" name="candidate_cv_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_add" name="candidate_cv_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_import" name="candidate_cv_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_edit" name="candidate_cv_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.approve')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_approve" name="candidate_cv_approve"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_delete" name="candidate_cv_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.cancel')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_cancel" name="candidate_cv_cancel"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_print" name="candidate_cv_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_export" name="candidate_cv_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Recruitment Plan --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.recruitment_plans')</label> --}}
                                    <label class="container-checkbox">@lang('lang.recruitment_plans')
                                        <input type="checkbox" class="recruitment_checkbox" id="recruitment_plans" name="recruitment_plans"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_view" name="recruitment_plan_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_add" name="recruitment_plan_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_edit" name="recruitment_plan_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_delete" name="recruitment_plan_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_print" name="recruitment_plan_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_export" name="recruitment_plan_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- block C&B --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.compensation_and_benefits')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="c_and_b_all" name="c_and_b_all"> <span class="checkmark"></span>
                            </label>
                        </div>
                         {{-- block Employee Salary --}}
                       <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.employee_salary')</label> --}}
                                    <label class="container-checkbox">@lang('lang.employee_salary')
                                        <input type="checkbox" class="c_and_b_checkbox" id="employee_salary" name="employee_salary"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_view" name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_add" name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.approve')
                                        <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_approve" name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_edit" name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_delete" name="c_and_b_all" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_print" name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_export" name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                       </div>
                    </div>
                    <hr>
                    {{-- block Motor Rentals --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.motor_rentals')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="motor_rental_check_all" name="motor_rental_check_all"> <span class="checkmark"></span>
                            </label>
                        </div>
                        {{-- block Motor Rental --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.motor_rentals')</label> --}}
                                    <label class="container-checkbox">@lang('lang.motor_rentals')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rentals" name="motor_rentals"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_view" name="motor_rental_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_add" name="motor_rental_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_import" name="motor_rental_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_edit" name="motor_rental_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_delete" name="motor_rental_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_print" name="motor_rental_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_export" name="motor_rental_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Pay Motor Rental --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.pay_motor_rentals')</label> --}}
                                    <label class="container-checkbox">@lang('lang.pay_motor_rentals')
                                        <input type="checkbox" class="motor_rental_checkbox" id="pay_motor_rentals" name="pay_motor_rentals"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_view" name="Pay_motor_rental_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_add" name="Pay_motor_rental_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.approve')
                                        <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_approve" name="Pay_motor_rental_approve"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_edit" name="Pay_motor_rental_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_delete" name="Pay_motor_rental_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_print" name="Pay_motor_rental_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_export" name="Pay_motor_rental_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- block Trainings--}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.trainings')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="training_check_all" name="training_check_all"> <span class="checkmark"></span>
                            </label>
                        </div>
                       {{-- block Trainer--}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.trainer')</label> --}}
                                    <label class="container-checkbox">@lang('lang.trainer')
                                        <input type="checkbox" class="training_checkbox" id="trainer" name="trainer"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_view" name="trainer_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_add" name="trainer_check_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_edit" name="trainer_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_delete" name="trainer_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_print" name="trainer_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_export" name="trainer_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Training List --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.training')</label> --}}
                                    <label class="container-checkbox">@lang('lang.training')
                                        <input type="checkbox" class="training_checkbox" id="training" name="training"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_view" name="training_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_add" name="training_check_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_edit" name="training_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_delete" name="training_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_print" name="training_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_export" name="training_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Training report --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.training_reports')</label> --}}
                                    <label class="container-checkbox">@lang('lang.training_reports')
                                        <input type="checkbox" class="training_checkbox" id="training_reports" name="training_reports"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_view" name="report_training_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_print" name="report_training_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_export" name="report_training_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- block reports--}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.reports')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="reports_check_all" name="reports_check_all"> <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Employee report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.employee_reports')</label> --}}
                                    <label class="container-checkbox">@lang('lang.employee_reports')
                                        <input type="checkbox" class="reports_checkbox" id="employee_reports" name="employee_reports"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_view" name="report_employee_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_print" name="report_employee_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_export" name="report_employee_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Paylroll report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.payroll_report')</label> --}}
                                    <label class="container-checkbox">@lang('lang.payroll_report')
                                        <input type="checkbox" class="reports_checkbox" id="payroll_report" name="payroll_report"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_view" name="payroll_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_print" name="payroll_report_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_export" name="payroll_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Transfer report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.bank_transfer_report')</label> --}}
                                    <label class="container-checkbox">@lang('lang.bank_transfer_report')
                                        <input type="checkbox" class="reports_checkbox" id="bank_transfer_report" name="bank_transfer_report"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_view" name="bank_transfer_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_print" name="bank_transfer_report_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_export" name="bank_transfer_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block E-Filing report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.e_filing_report')</label> --}}
                                    <label class="container-checkbox">@lang('lang.e_filing_report')
                                        <input type="checkbox" class="reports_checkbox" id="e_filing_report" name="e_filing_report"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_view" name="e_filing_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_print" name="e_filing_report_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_export" name="e_filing_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block E-form report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.e_form_report')</label> --}}
                                    <label class="container-checkbox">@lang('lang.e_form_report')
                                        <input type="checkbox" class="reports_checkbox" id="e_form_report" name="e_form_report"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_view" name="e_form_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_print" name="e_form_report_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_export" name="e_form_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Motor Rantel report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.motor_rental_reports')</label> --}}
                                    <label class="container-checkbox">@lang('lang.motor_rental_reports')
                                        <input type="checkbox" class="reports_checkbox" id="motor_rental_reports" name="motor_rental_reports"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_view" name="motor_rental_reports_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_print" name="motor_rental_reports_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_export" name="motor_rental_reports_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block New Staff report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.new_staff_reports')</label> --}}
                                    <label class="container-checkbox">@lang('lang.new_staff_reports')
                                        <input type="checkbox" class="reports_checkbox" id="new_staff_reports" name="new_staff_reports"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_view" name="new_staff_reports_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_print" name="new_staff_reports_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_export" name="new_staff_reports_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Staff Resinged report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.staff_resigned_reports')</label> --}}
                                    <label class="container-checkbox">@lang('lang.staff_resigned_reports')
                                        <input type="checkbox" class="reports_checkbox" id="staff_resigned_reports" name="staff_resigned_reports"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_view" name="staff_resigned_reports_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_print" name="staff_resigned_reports_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_export" name="staff_resigned_reports_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Promoted report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.promoted_staff_report')</label> --}}
                                    <label class="container-checkbox">@lang('lang.promoted_staff_report')
                                        <input type="checkbox" class="reports_checkbox" id="promoted_staff_report" name="promoted_staff_report"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_view" name="promoted_staff_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_print" name="promoted_staff_report_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_export" name="promoted_staff_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Transferred Staff report --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.transferred_staff_report')</label> --}}
                                    <label class="container-checkbox">@lang('lang.transferred_staff_report')
                                        <input type="checkbox" class="reports_checkbox" id="transferred_staff_report" name="transferred_staff_report"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_view" name="transferred_staff_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_print" name="transferred_staff_report_check_print" > <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_export" name="transferred_staff_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- block Configuration --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.configuration')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="configuration_check_all" name="configuration_check_all"> <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Tax --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.taxes')</label> --}}
                                    <label class="container-checkbox">@lang('lang.taxes')
                                        <input type="checkbox" class="configuration_checkbox" id="taxes" name="taxes"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_view" name="taxes_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_add" name="taxes_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_edit" name="taxes_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_delete" name="taxes_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Exchange Rate --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.exchange_rate')</label> --}}
                                    <label class="container-checkbox">@lang('lang.exchange_rate')
                                        <input type="checkbox" class="configuration_checkbox" id="exchange_rate" name="exchange_rate"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_view" name="exchange_rate_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_add" name="exchange_rate_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_edit" name="exchange_rate_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_delete" name="exchange_rate_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Public Holiday --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.public_holidays')</label> --}}
                                    <label class="container-checkbox">@lang('lang.public_holidays')
                                        <input type="checkbox" class="configuration_checkbox" id="public_holidays" name="public_holidays"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_view" name="public_holidays_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_add" name="public_holidays_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_edit" name="public_holidays_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_delete" name="public_holidays_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block children allowance --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.children_allowance')</label> --}}
                                    <label class="container-checkbox">@lang('lang.children_allowance')
                                        <input type="checkbox" class="configuration_checkbox" id="children_allowance" name="children_allowance"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_view" name="children_allowance_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_add" name="children_allowance_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_edit" name="children_allowance_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_delete" name="children_allowance_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                     {{-- block Setting --}}
                     <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.setting')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="setting_check_all" name="setting_check_all"> <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Bank --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.bank')</label> --}}
                                    <label class="container-checkbox">@lang('lang.bank')
                                        <input type="checkbox" class="setting_checkbox" id="bank" name="bank"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_view" name="bank_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_add" name="bank_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_edit" name="bank_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_delete" name="bank_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Position --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.position')</label> --}}
                                    <label class="container-checkbox">@lang('lang.position')
                                        <input type="checkbox" class="setting_checkbox" id="position" name="position"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_view" name="position_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_add" name="position_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_edit" name="position_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_delete" name="position_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Branch --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.branch')</label> --}}
                                    <label class="container-checkbox">@lang('lang.branch')
                                        <input type="checkbox" class="setting_checkbox" id="branch" name="branch"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_view" name="branch_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_add" name="branch_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_edit" name="branch_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_delete" name="branch_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Departerment --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.department')</label> --}}
                                    <label class="container-checkbox">@lang('lang.department')
                                        <input type="checkbox" class="setting_checkbox" id="department" name="department"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_view" name="department_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_add" name="department_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_edit" name="department_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_delete" name="department_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Forgot Password --}}
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.forgot_password?')</label> --}}
                                    <label class="container-checkbox">@lang('lang.forgot_password?')
                                        <input type="checkbox" class="setting_checkbox" id="forgot_password" name="forgot_password"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_view" name="forgot_password_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_add" name="forgot_password_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')  
                                        <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_edit" name="forgot_password_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_delete" name="forgot_password_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- block Role --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.roles')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="role_check_all" name="role_check_all"> <span class="checkmark"></span>
                            </label>
                        </div>
                         {{-- block Permission --}}
                       <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label >@lang('lang.permission')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="role_checkbox" id="role_check_view" name="role_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="role_checkbox" id="role_check_add" name="role_check_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="role_checkbox" id="role_check_edit" name="role_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="role_checkbox" id="role_check_delete" name="role_check_delete" > <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="role_checkbox" id="role_check_print" name="role_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="role_checkbox" id="role_check_export" name="role_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                       </div>
                    </div>
                    <hr>
                    <div class="submit-section">
                        <button type="button" class="btn btn-primary create-btn">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                        <a href="{{ url('role') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/js/role-checkbox.js') }}"></script>
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script>
    $(function(){
        var data = roleCheckboxs();
        $(".create-btn").on("click", function() {
            console.log("data: ", data);
            return false;
            let url = "{{url('role/create')}}";
            $.ajax({
                type: "POST",
                url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "role_name": $("#role_name").val(),
                    "role_type": $("#role_type").val(),
                    "role_permission": data,
                    "parent_id": $("#parent_id").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    console.log("response: ", response);
                }
            });
        });
    });
</script>