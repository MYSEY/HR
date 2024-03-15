<div class="tab-pane fade active show" id="bank_statutory" role="tabpanel">
    <div class="card card_background_color">
        <div class="card-body">
            <form class="was-validated">
                @csrf
                <input type="text" hidden name="parent_id" id="parent_id" value="{{Auth::user()->role_id}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="">@lang('lang.name') <span class="text-danger">*</span></label>
                            <input class="form-control role_required @error('name') is-invalid @enderror" type="text"
                                id="role_name" required name="role_name" value="{{ old('role_name') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group hr-form-group-select2">
                            <label class="">@lang('lang.type') <span class="text-danger">*</span></label>
                            <select class="form-control hr-select2-option role_required" id="role_type" name="role_type" required>
                                <option selected disabled value=""> -- @lang('lang.select') --</option>
                                <option value="BOD">Board of Director</option>
                                <option value="CEO">Chief Executive Officer</option>
                                {{-- <option value="DCEO">Deputy Chief Executive Officer</option> --}}
                                <option value="HR">Head of HR</option>
                                {{-- <option value="DHR">Deputy Head of HR</option> --}}
                                <option value="HOD">Head of Department</option>
                                {{-- <option value="DHOD">Deputy Head of Department</option> --}}
                                {{-- <option value="HOCD">Head of Credit Department</option> --}}
                                {{-- <option value="DHOCD">Deputy Head of Credit Department</option> --}}
                                <option value="BM">Branch Manager</option>
                                {{-- <option value="DBM">Deputy Branch Manager</option> --}}
                                <option value="Employee">Employee</option>
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
                        <label style="font-weight: normal !important;">@lang('lang.admin_dashboard')</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="container-checkbox">@lang('lang.all')
                                    <input type="checkbox" id="dashboad_all" name="dashboad_all"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">Attendance & Leaves
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_leave" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.resigned_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_resigned_staff" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.promoted_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_promoted_staff" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.transferred_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_transferred_staff" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.training')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_training" value="0"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="container-checkbox">@lang('lang.employee')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_employee" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.age_of_employee')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_age_of_employee" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.birthday_reminder')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_birthday_reminder" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.total_number_of_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_number_of_staff" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.total_inactive_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_inactive_staff" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.resigned_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_resigned_staff" value="0"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="container-checkbox">% @lang("lang.reasons_of_staff’s_exit")
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_reasons_of_staff’s_exit" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.staff_ratio')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_ratio" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_taking_leave')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_taking_leave" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (Internal)
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch_internal" value="0"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (External)
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch_external" value="0"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>@lang('lang.employee_dashboard')</label>
                    </div>
                    <div class="col-md-10">
                        <label class="container-checkbox">@lang('lang.view')
                            <input type="checkbox" id="employee_dashboard" > <span class="checkmark"></span>
                        </label>
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
                                    <input value="1" checked type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_view" data-name="is_view" name="employee_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_add" data-name="is_add" name="employee_add"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_import" data-name="is_import" name="employee_import"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_edit" data-name="is_update" name="employee_edit"> <span class="checkmark"></span>
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
                                <label class="container-checkbox">@lang('lang.view_salary')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_view_salary" name="employee_view_salary"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                {{-- Block Leave --}}
                <div class="row">
                    <div class="col-md-2">
                        <label style="font-weight: bold;">@lang('lang.leave')</label>
                    </div>
                    <div class="col-md-10">
                        <label class="container-checkbox">@lang('lang.all')
                            <input type="checkbox" id="leave_all" name="leave_all"> <span class="checkmark"></span>
                        </label>
                    </div>
                    {{-- block leave for admin --}}
                    <div class="col-md-12 hidden_leaves_admin">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.leaves_admin')
                                    <input type="checkbox" class="leave_checkbox" id="leaves_admin" name="leaves_admin"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input value="" checked type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_view" name="leaves_admin_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_add" name="leaves_admin_add"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_edit" name="leaves_admin_edit"> <span class="checkmark"></span>
                                </label>
                                
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_delete" name="leaves_admin_delete" > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_approve" name="leaves_admin_approve"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.reject')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_reject" name="leaves_admin_reject"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_cancel" name="leaves_admin_cancel"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_print" name="leaves_admin_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="leave_checkbox leaves_admin_checkbox" id="leaves_admin_export" name="leaves_admin_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                     {{-- block leave employee --}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.leaves_employee')
                                    <input type="checkbox" class="leave_checkbox" id="leaves_employee" name="leaves_employee"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input value="1" checked type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_view" name="leaves_employee_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_add" name="leaves_employee_add"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_edit" name="leaves_employee_edit"> <span class="checkmark"></span>
                                </label>
                                {{-- <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_import" name="leaves_employee_import"> <span class="checkmark"></span>
                                </label> --}}
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_delete" name="leaves_employee_delete" > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_cancel" name="leaves_employee_cancel"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_print" name="leaves_employee_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="leave_checkbox leaves_employee_checkbox" id="leaves_employee_export" name="leaves_employee_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- leave report --}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.leaves_report')
                                    <input type="checkbox" class="leave_checkbox" id="leaves_report" name="leaves_employee"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="leave_checkbox leave_report_checkbox" id="leave_report_view" name="report_leave_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="leave_checkbox leave_report_checkbox" id="leave_report_print" name="report_leave_check_print" > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="leave_checkbox leave_report_checkbox" id="leave_report_export" name="report_leave_check_export"> <span class="checkmark"></span>
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
                                    <input value="1" checked type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_view" name="candidate_cv_view"> <span class="checkmark"></span>
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
                                    <input value="1" checked type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_view" name="recruitment_plan_view"> <span class="checkmark"></span>
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
                                <label class="container-checkbox">@lang('lang.generate_payroll')
                                    <input type="checkbox" class="c_and_b_checkbox" id="generate_payroll" name="generate_payroll"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="c_and_b_checkbox g_checkbox" id="g_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="c_and_b_checkbox g_checkbox" id="g_add"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="c_and_b_checkbox g_checkbox" id="g_approve"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="c_and_b_checkbox g_checkbox" id="g_delete" > <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
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
                                    <input value="1" checked type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_add"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_import"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_approve"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_edit"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_delete" > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- block nssf --}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.nssf')
                                    <input type="checkbox" class="c_and_b_checkbox" id="cb_nssf"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input value="1" checked type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_import"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- block Severance Pay --}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.severance_pay')
                                    <input type="checkbox" class="c_and_b_checkbox" id="severance_pay" > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input value="1" checked type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_import"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- block Fringe Benefits --}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.fringe_benefits')
                                    <input type="checkbox" class="c_and_b_checkbox" id="fringe_benefits"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input value="1" checked type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_add"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_import"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_edit"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_delete" > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_export"> <span class="checkmark"></span>
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
                                    <input value="1" checked type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_view" name="motor_rental_view"> <span class="checkmark"></span>
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
                                    <input value="1" checked type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_view" name="Pay_motor_rental_view"> <span class="checkmark"></span>
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
                                    <input value="1" checked type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_view" name="trainer_check_view"> <span class="checkmark"></span>
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
                                    <input value="1" checked type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_view" name="training_check_view"> <span class="checkmark"></span>
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
                                    <input value="1" checked type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_view" name="report_training_check_view"> <span class="checkmark"></span>
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
                            {{-- block tax report --}}
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.tax_report')
                                    <input type="checkbox" class="reports_checkbox" id="tax_report"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            {{-- block NSSF report --}}
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.nssf_report')
                                    <input type="checkbox" class="reports_checkbox" id="nssf_report"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                            {{-- block Khmer New Year and Pchum Ben Allowance report --}}
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.KNY_/_pchum_ben')
                                    <input type="checkbox" class="reports_checkbox" id="kmh_pchum_report"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                            {{-- block Severance Pay Report report --}}
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.severance_pay_report')
                                    <input type="checkbox" class="reports_checkbox" id="severance_pay_report"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            {{-- block Seniorities Pay report --}}
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.seniorities_pay_report')
                                    <input type="checkbox" class="reports_checkbox" id="seniorities_pay_report"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                            {{-- block bank transfer report --}}
                            <div class="col-md-2">
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
                             {{-- block Fringe Benefits report --}}
                             <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.fringe_benefits_report')
                                    <input type="checkbox" class="reports_checkbox" id="fringe_benefits_report" name="fringe_benefits_report"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_view" name="fringe_benefits_report_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_print" name="fringe_benefits_report_check_print" > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_export" name="fringe_benefits_report_check_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                   <div class="col-md-12">
                        <div class="form-group row">
                            {{-- block E-Filing report --}}
                            <div class="col-md-2">
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

                            {{-- block leave type --}}
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.leave_type')
                                    <input type="checkbox" class="configuration_checkbox" id="leave_type" name="leave_type"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox"class="configuration_checkbox leave_type_checkbox" id="leave_type_check_view" name="leave_type_check_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox"class="configuration_checkbox leave_type_checkbox" id="leave_type_check_add" name="leave_type_check_add"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox"class="configuration_checkbox leave_type_checkbox" id="leave_type_check_edit" name="leave_type_check_edit"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox"class="configuration_checkbox leave_type_checkbox" id="leave_type_check_delete" name="leave_type_check_delete" > <span class="checkmark"></span>
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
                    <button type="button" class="btn btn-primary btn_save" id="btn_save">
                        <span class="btn-text-save">@lang('lang.submit')</span>
                        <span id="btn-save-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                    </button>
                    <a href="{{ url('role') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>