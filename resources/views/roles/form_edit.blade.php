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
    .container-checkbox:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked~.checkmark:after {
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
{{-- @dd($permissions) --}}
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.edit_roles')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/role') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.edit_roles')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade active show" id="bank_statutory" role="tabpanel">
        <div class="card card_background_color">
            <div class="card-body">
                <form>
                    <input type="text" hidden name="parent_id" id="parent_id" value="{{ Auth::user()->role_id }}">
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
                                <textarea style="height: 44px;" type="text" rows="3" class="form-control" name="remark" id="remark"
                                    value="{{ old('remark') }}"></textarea>
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
                                        <input type="checkbox" id="dashboad_all" name="dashboad_all"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.employee')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_employee"
                                            name="dashboad_employee"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.age_of_employee')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_age_of_employee"
                                            name="dashboad_age_of_employee"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.birthday_reminder')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_birthday_reminder"
                                            name="dashboad_birthday_reminder"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="container-checkbox">@lang('lang.total_number_of_staff')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_number_of_staff"
                                            name="dashboad_total_number_of_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.total_inactive_staff')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_inactive_staff"
                                            name="dashboad_total_inactive_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.resigned_staff')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_resigned_staff"
                                            name="dashboad_resigned_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.reasons_of_staff’s_exit')
                                        <input type="checkbox" class="dashboad_checkbox"
                                            id="dashboad_reasons_of_staff’s_exit" name="dashboad_reasons"> <span
                                            class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="container-checkbox">% @lang('lang.staff_ratio')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_ratio"
                                            name="dashboad_staff_ratio"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_taking_leave')
                                        <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_taking_leave"
                                            name="dashboad_staff_taking_leave"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_training_by_branch') (Internal)
                                        <input type="checkbox" class="dashboad_checkbox"
                                            id="dashboad_staff_training_by_branch"
                                            name="dashboad_staff_training_by_branch"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_training_by_branch') (External)
                                        <input type="checkbox" class="dashboad_checkbox"
                                            id="dashboad_staff_training_by_branch_external"
                                            name="dashboad_staff_training_by_branch_external"> <span
                                            class="checkmark"></span>
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
                                <input type="checkbox" id="employee_all" name="employee_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {{-- <label >@lang('lang.all_employee')</label> --}}
                                    <label class="container-checkbox">@lang('lang.all_employee')
                                        <input type="checkbox" class="employee_checkbox" id="employee_view"
                                            name="employee_view"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="employee_checkbox" id="employee_view"
                                            name="employee_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="employee_checkbox" id="employee_add"
                                            name="employee_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="employee_checkbox" id="employee_import"
                                            name="employee_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="employee_checkbox" id="employee_edit"
                                            name="employee_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="employee_checkbox" id="employee_delete"
                                            name="employee_delete"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.cancel')
                                        <input type="checkbox" class="employee_checkbox" id="employee_cancel"
                                            name="employee_cancel"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="employee_checkbox" id="employee_print"
                                            name="employee_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="employee_checkbox" id="employee_export"
                                            name="employee_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block leave employee --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.leaves_employee')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_view"
                                            name="leaves_employee_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_add"
                                            name="leaves_employee_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_import"
                                            name="leaves_employee_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_edit"
                                            name="leaves_employee_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_delete"
                                            name="leaves_employee_delete"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.cancel')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_cancel"
                                            name="leaves_employee_cancel"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_print"
                                            name="leaves_employee_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="employee_checkbox" id="leaves_employee_export"
                                            name="leaves_employee_export"> <span class="checkmark"></span>
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
                                <input type="checkbox" id="recruitments_all" name="recruitments_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>
                        {{-- block Candidate CVs --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.candidate_CVs')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_view"
                                            name="candidate_cv_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_add"
                                            name="candidate_cv_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_import"
                                            name="candidate_cv_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_edit"
                                            name="candidate_cv_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.approve')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_approve"
                                            name="candidate_cv_approve"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_delete"
                                            name="candidate_cv_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.cancel')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_cancel"
                                            name="candidate_cv_cancel"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_print"
                                            name="candidate_cv_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="recruitment_checkbox" id="candidate_cv_export"
                                            name="candidate_cv_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Recruitment Plan --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.recruitment_plans')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="recruitment_checkbox" id="recruitment_plan_view"
                                            name="recruitment_plan_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="recruitment_checkbox" id="recruitment_plan_add"
                                            name="recruitment_plan_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="recruitment_checkbox" id="recruitment_plan_edit"
                                            name="recruitment_plan_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="recruitment_checkbox" id="recruitment_plan_delete"
                                            name="recruitment_plan_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="recruitment_checkbox" id="recruitment_plan_print"
                                            name="recruitment_plan_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="recruitment_checkbox" id="recruitment_plan_export"
                                            name="recruitment_plan_export"> <span class="checkmark"></span>
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
                                <input type="checkbox" id="c_and_b_all" name="c_and_b_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>
                        {{-- block Employee Salary --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.employee_salary')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="c_and_b_checkbox" id="c_and_b_view"
                                            name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="c_and_b_checkbox" id="c_and_b_add"
                                            name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.approve')
                                        <input type="checkbox" class="c_and_b_checkbox" id="c_and_b_approve"
                                            name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="c_and_b_checkbox" id="c_and_b_edit"
                                            name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="c_and_b_checkbox" id="c_and_b_delete"
                                            name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="c_and_b_checkbox" id="c_and_b_print"
                                            name="c_and_b_all"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="c_and_b_checkbox" id="c_and_b_export"
                                            name="c_and_b_all"> <span class="checkmark"></span>
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
                                <input type="checkbox" id="motor_rental_check_all" name="motor_rental_check_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>
                        {{-- block Motor Rental --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.motor_rentals')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rental_view"
                                            name="motor_rental_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rental_add"
                                            name="motor_rental_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.import')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rental_import"
                                            name="motor_rental_import"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rental_edit"
                                            name="motor_rental_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rental_delete"
                                            name="motor_rental_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rental_print"
                                            name="motor_rental_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="motor_rental_checkbox" id="motor_rental_export"
                                            name="motor_rental_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Pay Motor Rental --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.pay_motor_rentals')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="motor_rental_checkbox" id="Pay_motor_rental_view"
                                            name="Pay_motor_rental_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="motor_rental_checkbox" id="Pay_motor_rental_add"
                                            name="Pay_motor_rental_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.approve')
                                        <input type="checkbox" class="motor_rental_checkbox"
                                            id="Pay_motor_rental_approve" name="Pay_motor_rental_approve"> <span
                                            class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="motor_rental_checkbox" id="Pay_motor_rental_edit"
                                            name="Pay_motor_rental_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="motor_rental_checkbox" id="Pay_motor_rental_delete"
                                            name="Pay_motor_rental_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="motor_rental_checkbox" id="Pay_motor_rental_print"
                                            name="Pay_motor_rental_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="motor_rental_checkbox" id="Pay_motor_rental_export"
                                            name="Pay_motor_rental_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- block Trainings --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.trainings')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="training_check_all" name="training_check_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>
                        {{-- block Trainer --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.trainer')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="training_checkbox" id="trainer_check_view"
                                            name="trainer_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="training_checkbox" id="trainer_check_add"
                                            name="trainer_check_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="training_checkbox" id="trainer_check_edit"
                                            name="trainer_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="training_checkbox" id="trainer_check_delete"
                                            name="trainer_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="training_checkbox" id="trainer_check_print"
                                            name="trainer_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="training_checkbox" id="trainer_check_export"
                                            name="trainer_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Training List --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.training')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="training_checkbox" id="training_check_view"
                                            name="training_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="training_checkbox" id="training_check_add"
                                            name="training_check_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="training_checkbox" id="training_check_edit"
                                            name="training_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="training_checkbox" id="training_check_delete"
                                            name="training_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="training_checkbox" id="training_check_print"
                                            name="training_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="training_checkbox" id="training_check_export"
                                            name="training_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- block Training report --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.training_reports')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="training_checkbox" id="report_training_check_view"
                                            name="report_training_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="training_checkbox" id="report_training_check_print"
                                            name="report_training_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="training_checkbox"
                                            id="report_training_check_export" name="report_training_check_export"> <span
                                            class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- block reports --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label style="font-weight: bold;">@lang('lang.reports')</label>
                        </div>
                        <div class="col-md-10">
                            <label class="container-checkbox">@lang('lang.all')
                                <input type="checkbox" id="reports_check_all" name="reports_check_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Employee report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.employee_reports')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox" id="report_employee_check_view"
                                            name="report_employee_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox" id="report_employee_check_print"
                                            name="report_employee_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox" id="report_employee_check_export"
                                            name="report_employee_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Paylroll report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.payroll_report')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox" id="payroll_report_check_view"
                                            name="payroll_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox" id="payroll_report_check_print"
                                            name="payroll_report_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox" id="payroll_report_check_export"
                                            name="payroll_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Transfer report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.bank_transfer_report')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="bank_transfer_report_check_view" name="bank_transfer_report_check_view">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="bank_transfer_report_check_print" name="bank_transfer_report_check_print">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="bank_transfer_report_check_export"
                                            name="bank_transfer_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block E-Filing report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.e_filing_report')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox" id="e_filing_report_check_view"
                                            name="e_filing_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox" id="e_filing_report_check_print"
                                            name="e_filing_report_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox" id="e_filing_report_check_export"
                                            name="e_filing_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block E-form report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.e_form_report')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox" id="e_form_report_check_view"
                                            name="e_form_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox" id="e_form_report_check_print"
                                            name="e_form_report_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox" id="e_form_report_check_export"
                                            name="e_form_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Motor Rantel report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.motor_rental_reports')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="motor_rental_reports_check_view" name="motor_rental_reports_check_view">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="motor_rental_reports_check_print" name="motor_rental_reports_check_print">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="motor_rental_reports_check_export"
                                            name="motor_rental_reports_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block New Staff report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.new_staff_reports')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox" id="new_staff_reports_check_view"
                                            name="new_staff_reports_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="new_staff_reports_check_print" name="new_staff_reports_check_print"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="new_staff_reports_check_export" name="new_staff_reports_check_export">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Staff Resinged report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.staff_resigned_reports')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="staff_resigned_reports_check_view"
                                            name="staff_resigned_reports_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="staff_resigned_reports_check_print"
                                            name="staff_resigned_reports_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="staff_resigned_reports_check_export"
                                            name="staff_resigned_reports_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Promoted report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.promoted_staff_report')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="promoted_staff_report_check_view" name="promoted_staff_report_check_view">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="promoted_staff_report_check_print"
                                            name="promoted_staff_report_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="promoted_staff_report_check_export"
                                            name="promoted_staff_report_check_export"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Transferred Staff report --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.transferred_staff_report')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="transferred_staff_report_check_view"
                                            name="transferred_staff_report_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="transferred_staff_report_check_print"
                                            name="transferred_staff_report_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="reports_checkbox"
                                            id="transferred_staff_report_check_export"
                                            name="transferred_staff_report_check_export"> <span class="checkmark"></span>
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
                                <input type="checkbox" id="configuration_check_all" name="configuration_check_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Tax --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.taxes')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="configuration_checkbox" id="taxes_check_view"
                                            name="taxes_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="configuration_checkbox" id="taxes_check_add"
                                            name="taxes_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="configuration_checkbox" id="taxes_check_edit"
                                            name="taxes_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="configuration_checkbox" id="taxes_check_delete"
                                            name="taxes_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Exchange Rate --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.exchange_rate')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="exchange_rate_check_view" name="exchange_rate_check_view"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="exchange_rate_check_add" name="exchange_rate_check_add"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="exchange_rate_check_edit" name="exchange_rate_check_edit"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="exchange_rate_check_delete" name="exchange_rate_check_delete"> <span
                                            class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Public Holiday --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.public_holidays')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="public_holidays_check_view" name="public_holidays_check_view"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="public_holidays_check_add" name="public_holidays_check_add"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="public_holidays_check_edit" name="public_holidays_check_edit"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="configuration_checkbox"
                                            id="public_holidays_check_delete" name="public_holidays_check_delete"> <span
                                            class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block children allowance --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.children_allowance')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox"class="configuration_checkbox"
                                            id="children_allowance_check_view" name="children_allowance_check_view"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox"class="configuration_checkbox"
                                            id="children_allowance_check_add" name="children_allowance_check_add"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox"class="configuration_checkbox"
                                            id="children_allowance_check_edit" name="children_allowance_check_edit"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox"class="configuration_checkbox"
                                            id="children_allowance_check_delete" name="children_allowance_check_delete">
                                        <span class="checkmark"></span>
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
                                <input type="checkbox" id="setting_check_all" name="setting_check_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Bank --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.bank')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox" id="bank_check_view"
                                            name="bank_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox" id="bank_check_add"
                                            name="bank_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="setting_checkbox" id="bank_check_edit"
                                            name="bank_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox" id="bank_check_delete"
                                            name="bank_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Position --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.position')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox" id="position_check_view"
                                            name="position_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox" id="position_check_add"
                                            name="position_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="setting_checkbox" id="position_check_edit"
                                            name="position_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox" id="position_check_delete"
                                            name="position_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Branch --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.branch')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox" id="branch_check_view"
                                            name="branch_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox" id="branch_check_add"
                                            name="branch_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="setting_checkbox" id="branch_check_edit"
                                            name="branch_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox" id="branch_check_delete"
                                            name="branch_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- block Departerment --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.department')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox" id="department_check_view"
                                            name="department_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox" id="department_check_add"
                                            name="department_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="setting_checkbox" id="department_check_edit"
                                            name="department_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox" id="department_check_delete"
                                            name="department_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- block Forgot Password --}}
                                <div class="col-md-2">
                                    <label>@lang('lang.forgot_password?')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="setting_checkbox"
                                            id="forgot_password_check_view" name="forgot_password_check_view"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="setting_checkbox" id="forgot_password_check_add"
                                            name="forgot_password_check_add"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="setting_checkbox"
                                            id="forgot_password_check_edit" name="forgot_password_check_edit"> <span
                                            class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="setting_checkbox"
                                            id="forgot_password_check_delete" name="forgot_password_check_delete"> <span
                                            class="checkmark"></span>
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
                                <input type="checkbox" id="role_check_all" name="role_check_all"> <span
                                    class="checkmark"></span>
                            </label>
                        </div>
                        {{-- block Permission --}}
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>@lang('lang.permission')</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.view')
                                        <input type="checkbox" class="role_checkbox" id="role_check_view"
                                            name="role_check_view"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.add')
                                        <input type="checkbox" class="role_checkbox" id="role_check_add"
                                            name="role_check_add"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.edit')
                                        <input type="checkbox" class="role_checkbox" id="role_check_edit"
                                            name="role_check_edit"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.delete')
                                        <input type="checkbox" class="role_checkbox" id="role_check_delete"
                                            name="role_check_delete"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="container-checkbox">@lang('lang.print')
                                        <input type="checkbox" class="role_checkbox" id="role_check_print"
                                            name="role_check_print"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.export')
                                        <input type="checkbox" class="role_checkbox" id="role_check_export"
                                            name="role_check_export"> <span class="checkmark"></span>
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
{{-- <script src="{{ asset('/admin/js/role-checkbox.js') }}"></script> --}}
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script>
    $(function() {
        // blcok dashboad
        var data = [];
        $("#dashboad_all").on("click", function() {
            if (!$(this).prop("checked")) {
                $(".dashboad_checkbox").prop("checked", false);
                $(".dashboad_checkbox").val(0);
            }
            if ($(this).prop("checked")) {
                $(".dashboad_checkbox").prop("checked", true);
                $(".dashboad_checkbox").val(1);
            }
        });
        $(document).ready(function() {
            var checkboxes = $('.dashboad_checkbox');
            checkboxes.change(function() {
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
        $("#employee_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Employee",
                        },
                        {
                            "name": "All Employee",
                            "table_id": "3",
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
                            "name": "Leaves Employee",
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
        $(document).ready(function() {
            var checkboxes = $('.employee_checkbox');
            checkboxes.change(function() {
                var countCheckedCheckboxes = checkboxes.filter(':checked').length;
                if (countCheckedCheckboxes == $('input.employee_checkbox').length) {
                    $("#employee_all").prop("checked", true);
                };
                if (countCheckedCheckboxes < $('input.employee_checkbox').length) {
                    $("#employee_all").prop("checked", false);
                };
            });
        });

        // blcok recruitment
        $("#recruitments_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "recruitments",
                        },
                        {
                            "name": "Candidate CV",
                            "table_id": "8",
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
                            "name": "Recruitment Plan",
                            "table_id": "7",
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
        $(document).ready(function() {
            var checkboxes = $('.recruitment_checkbox');
            checkboxes.change(function() {
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
        $("#c_and_b_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Compensation and Benefits",
                        },
                        {
                            "name": "Payroll",
                            "table_id": "4",
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
        $(document).ready(function() {
            var checkboxes = $('.c_and_b_checkbox');
            checkboxes.change(function() {
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
        $("#motor_rental_check_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Motor Rentals",
                        },
                        {
                            "name": "Motor Rental",
                            "table_id": "5",
                            "is_view": $("#motor_rental_view").val(),
                            "is_create": $("#motor_rental_add").val(),
                            "is_import": $("#motor_rental_import").val(),
                            "is_update": $("#motor_rental_edit").val(),
                            "is_delete": $("#motor_rental_delete").val(),
                            "is_print": $("#motor_rental_print").val(),
                            "is_export": $("#motor_rental_export").val(),
                        },
                        {
                            "name": "Pay Motor Rental",
                            "table_id": "6",
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
        $(document).ready(function() {
            var checkboxes = $('.motor_rental_checkbox');
            checkboxes.change(function() {
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
        $("#training_check_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Trainings",
                        },
                        {
                            "name": "Trainer",
                            "table_id": "10",
                            "is_view": $("#trainer_check_view").val(),
                            "is_create": $("#trainer_check_add").val(),
                            "is_update": $("#trainer_check_edit").val(),
                            "is_delete": $("#trainer_check_delete").val(),
                            "is_print": $("#trainer_check_print").val(),
                            "is_export": $("#trainer_check_export").val(),
                        },
                        {
                            "name": "Training",
                            "table_id": "10",
                            "is_view": $("#training_check_view").val(),
                            "is_create": $("#training_check_add").val(),
                            "is_update": $("#training_check_edit").val(),
                            "is_delete": $("#training_check_delete").val(),
                            "is_print": $("#training_check_print").val(),
                            "is_export": $("#training_check_export").val(),
                        },
                        {
                            "name": "Training Report",
                            "table_id": "10",
                            "is_view": $("#report_training_check_view").val(),
                            "is_print": $("#report_training_check_print").val(),
                            "is_export": $("#report_training_check_export").val(),
                        }
                    ]
                });
            }
        });
        $(document).ready(function() {
            var checkboxes = $('.training_checkbox');
            checkboxes.change(function() {
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
        $("#reports_check_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Reports",
                        },
                        {
                            "name": "Employee Reports",
                            "table_id": "17",
                            "is_view": $("#report_employee_check_view").val(),
                            "is_print": $("#report_employee_check_print").val(),
                            "is_export": $("#report_employee_check_export").val(),
                        },
                        {
                            "name": "Payroll Reports",
                            "table_id": "18",
                            "is_view": $("#payroll_report_check_view").val(),
                            "is_print": $("#payroll_report_check_print").val(),
                            "is_export": $("#payroll_report_check_export").val(),
                        },
                        {
                            "name": "Bank Transfer Reports",
                            "is_view": $("#bank_transfer_report_check_view").val(),
                            "is_print": $("#bank_transfer_report_check_print").val(),
                            "is_export": $("#bank_transfer_report_check_export").val(),
                        },
                        {
                            "name": "E-Filing Reports",
                            "is_view": $("#e_filing_report_check_view").val(),
                            "is_print": $("#e_filing_report_check_print").val(),
                            "is_export": $("#e_filing_report_check_export").val(),
                        },
                        {
                            "name": "E-Form Reports",
                            "is_view": $("#e_form_report_check_view").val(),
                            "is_print": $("#e_form_report_check_print").val(),
                            "is_export": $("#e_form_report_check_export").val(),
                        },
                        {
                            "name": "Motor Rental Reports",
                            "table_id": "19",
                            "is_view": $("#motor_rental_reports_check_view").val(),
                            "is_print": $("#motor_rental_reports_check_print").val(),
                            "is_export": $("#motor_rental_reports_check_export").val(),
                        },
                        {
                            "name": "New Staff Reports",
                            "table_id": "20",
                            "is_view": $("#new_staff_reports_check_view").val(),
                            "is_print": $("#new_staff_reports_check_print").val(),
                            "is_export": $("#new_staff_reports_check_export").val(),
                        },
                        {
                            "name": "Staff Resigned Reports",
                            "table_id": "21",
                            "is_view": $("#staff_resigned_reports_check_view").val(),
                            "is_print": $("#staff_resigned_reports_check_print").val(),
                            "is_export": $("#staff_resigned_reports_check_export").val(),
                        },
                        {
                            "name": "Promoted Staff Reports",
                            "table_id": "22",
                            "is_view": $("#promoted_staff_report_check_view").val(),
                            "is_print": $("#promoted_staff_report_check_print").val(),
                            "is_export": $("#promoted_staff_report_check_export").val(),
                        },
                        {
                            "name": "Transferred Staff Reports",
                            "table_id": "23",
                            "is_view": $("#transferred_staff_report_check_view").val(),
                            "is_print": $("#transferred_staff_report_check_print").val(),
                            "is_export": $("#transferred_staff_report_check_export").val(),
                        },
                    ]
                });
            }
        });
        $(document).ready(function() {
            var checkboxes = $('.reports_checkbox');
            checkboxes.change(function() {
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
        $("#configuration_check_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Configuration",
                        },
                        {
                            "name": "Tax",
                            "table_id": "24",
                            "is_view": $("#taxes_check_view").val(),
                            "is_create": $("#taxes_check_add").val(),
                            "is_update": $("#taxes_check_edit").val(),
                            "is_delete": $("#taxes_check_delete").val(),
                        },
                        {
                            "name": "Exchange Rate",
                            "table_id": "25",
                            "is_view": $("#exchange_rate_check_view").val(),
                            "is_create": $("#exchange_rate_check_add").val(),
                            "is_update": $("#exchange_rate_check_edit").val(),
                            "is_delete": $("#exchange_rate_check_delete").val(),
                        },
                        {
                            "name": "Public Holidays",
                            "table_id": "12",
                            "is_view": $("#public_holidays_check_view").val(),
                            "is_create": $("#public_holidays_check_add").val(),
                            "is_update": $("#public_holidays_check_edit").val(),
                            "is_delete": $("#public_holidays_check_delete").val(),
                        },
                        {
                            "name": "Children Allowance",
                            "table_id": "26",
                            "is_view": $("#children_allowance_check_view").val(),
                            "is_create": $("#children_allowance_check_add").val(),
                            "is_update": $("#children_allowance_check_edit").val(),
                            "is_delete": $("#children_allowance_check_delete").val(),
                        },

                    ]
                });
            }
        });
        $(document).ready(function() {
            var checkboxes = $('.configuration_checkbox');
            checkboxes.change(function() {
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
        $("#setting_check_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Setting",
                        },
                        {
                            "name": "Bank",
                            "table_id": "13",
                            "is_view": $("#bank_check_view").val(),
                            "is_create": $("#bank_check_add").val(),
                            "is_update": $("#bank_check_edit").val(),
                            "is_delete": $("#bank_check_delete").val(),
                        },
                        {
                            "name": "Position",
                            "table_id": "15",
                            "is_view": $("#position_check_view").val(),
                            "is_create": $("#position_check_add").val(),
                            "is_update": $("#position_check_edit").val(),
                            "is_delete": $("#position_check_delete").val(),
                        },
                        {
                            "name": "Branch",
                            "table_id": "16",
                            "is_view": $("#branch_check_view").val(),
                            "is_create": $("#branch_check_add").val(),
                            "is_update": $("#branch_check_edit").val(),
                            "is_delete": $("#branch_check_delete").val(),
                        },
                        {
                            "name": "Department",
                            "table_id": "14",
                            "is_view": $("#department_check_view").val(),
                            "is_create": $("#department_check_add").val(),
                            "is_update": $("#department_check_edit").val(),
                            "is_delete": $("#department_check_delete").val(),
                        },
                        {
                            "name": "Forgot Password",
                            "is_view": $("#forgot_password_check_view").val(),
                            "is_create": $("#forgot_password_check_add").val(),
                            "is_update": $("#forgot_password_check_edit").val(),
                            "is_delete": $("#forgot_password_check_delete").val(),
                        },

                    ]
                });
            }
        });
        $(document).ready(function() {
            var checkboxes = $('.setting_checkbox');
            checkboxes.change(function() {
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
        $("#role_check_all").on("click", function() {
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
                    permission: [{
                            "is_all": $(this).val(),
                            "name": "Role",
                        },
                        {
                            "name": "Permission",
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
        $(document).ready(function() {
            var checkboxes = $('.role_checkbox');
            checkboxes.change(function() {
                var countCheckedCheckboxes = checkboxes.filter(':checked').length;
                if (countCheckedCheckboxes == $('input.role_checkbox').length) {
                    $("#role_check_all").prop("checked", true);
                };
                if (countCheckedCheckboxes < $('input.role_checkbox').length) {
                    $("#role_check_all").prop("checked", false);
                };
            });
        });

        $(".create-btn").on("click", function() {
            let url = "{{ url('role/create') }}";
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
                success: function(response) {
                    console.log("response: ", response);
                }
            });
        });
    });
</script>
