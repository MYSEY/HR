<div class="tab-pane fade active show" id="bank_statutory" role="tabpanel">
    <div class="card card_background_color">
        <div class="card-body">
            <form class="was-validated">
                <input type="text" hidden name="parent_id" id="parent_id" value="{{Auth::user()->role_id}}">
                {{-- @csrf --}}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="">@lang('lang.name') <span class="text-danger">*</span></label>
                            <input class="form-control role_required @error('name') is-invalid @enderror" type="text"
                                id="role_name" required name="role_name" value="{{$role->role_name}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group hr-form-group-select2">
                            <label class="">@lang('lang.type') <span class="text-danger">*</span></label>
                            <select class="form-control hr-select2-option role_required" id="role_type" name="role_type" required>
                                <option value="admin" {{ $role->role_type == "admin" ? "selected":""}}>@lang('lang.admin')</option>
                                <option value="developer" {{ $role->role_type == "developer" ? "selected":""}}>@lang('lang.developer')</option>
                                <option value="employee" {{ $role->role_type == "employee" ? "selected":""}}>@lang('lang.employee')</option>
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
                                    <input type="checkbox" id="dashboad_all" 
                                    {{SetCheckbox($arrayPermissions,"Dashboards","is_all")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboards","is_all")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.employee')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_employee"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_employee"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_employee"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.age_of_employee')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_age_of_employee"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_age_of_employee"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_age_of_employee"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.birthday_reminder')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_birthday_reminder"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_birthday_reminder"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_birthday_reminder"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                   </div>
                   <div class="col-md-3">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="container-checkbox">@lang('lang.total_number_of_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_number_of_staff"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_total_number_of_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_total_number_of_staff"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.total_inactive_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_inactive_staff"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_total_inactive_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_total_inactive_staff"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.resigned_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_resigned_staff"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_resigned_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_resigned_staff"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang("lang.reasons_of_staff’s_exit")
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_reasons_of_staff’s_exit"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_reasons_of_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_reasons_of_staff"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                   <div class="col-md-3">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="container-checkbox">% @lang('lang.staff_ratio')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_ratio"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_ratio"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_ratio"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_taking_leave')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_taking_leave" 
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_taking_leave"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_taking_leave"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (Internal)
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch_internal"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_training_internal"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_training_internal"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (External)
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch_external"
                                    {{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_training_external"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"Dashboard","is_dashboard")->is_dashboard["is_staff_training_external"]}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="employee_all"
                            {{SetCheckbox($arrayPermissions,"Employee","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"Employee","is_all")->value}}"
                            > <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.all_employee')
                                    <input type="checkbox" class="employee_checkbox" id="all_employee"> <span class="checkmark"></span>
                                </label>
                                {{-- <label >@lang('lang.all_employee')</label> --}}
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_view" 
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_add" 
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_import" 
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_edit"
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_delete"
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_cancel"
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_cancel")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_cancel")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_print"
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_export"
                                    {{SetCheckbox($arrayPermissions,"All Employee","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"All Employee","is_export")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                     {{-- block leave employee --}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.leaves_employee')
                                    <input type="checkbox" class="employee_checkbox" id="leaves_employee"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_view"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_add"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_import"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_edit"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_delete"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_cancel"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_cancel")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_cancel")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_print"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_export"
                                    {{SetCheckbox($arrayPermissions,"Leaves Employee","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Leaves Employee","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="recruitments_all" 
                            {{SetCheckbox($arrayPermissions,"recruitments","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"recruitments","is_all")->value}}"
                            > <span class="checkmark"></span>
                        </label>
                    </div>
                    {{-- block Candidate CVs --}}
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-2">
                                {{-- <label >@lang('lang.candidate_CVs')</label> --}}
                                <label class="container-checkbox">@lang('lang.candidate_CVs')
                                    <input type="checkbox" class="recruitment_checkbox" id="candidate_CVs" name="candidate_CVs" > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_view"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_add"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_import"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_edit"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_approve"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_approve")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_approve")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_delete"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_cancel"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_cancel")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_cancel")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_print"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_print")->value}}"
                                    ><span class="checkmark"></span>
                                </label>
                               
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_export"
                                    {{SetCheckbox($arrayPermissions,"Candidate CV","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Candidate CV","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="recruitment_checkbox" id="recruitment_plans"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_view"
                                    {{SetCheckbox($arrayPermissions,"Recruitment Plan","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Recruitment Plan","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_add"
                                    {{SetCheckbox($arrayPermissions,"Recruitment Plan","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Recruitment Plan","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_edit"
                                    {{SetCheckbox($arrayPermissions,"Recruitment Plan","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Recruitment Plan","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_delete"
                                    {{SetCheckbox($arrayPermissions,"Recruitment Plan","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Recruitment Plan","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_print"
                                    {{SetCheckbox($arrayPermissions,"Recruitment Plan","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Recruitment Plan","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_export"
                                    {{SetCheckbox($arrayPermissions,"Recruitment Plan","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Recruitment Plan","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="c_and_b_all" 
                            {{SetCheckbox($arrayPermissions,"Compensation and Benefits","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"Compensation and Benefits","is_all")->value}}"
                            > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_view"
                                    {{SetCheckbox($arrayPermissions,"Payroll","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Payroll","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_add"
                                    {{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_create"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_create"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_approve"
                                    {{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_approve"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_approve"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_edit"
                                    {{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_update"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_update"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_delete" 
                                    {{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_delete"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_delete"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_print"
                                    {{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_print"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_print"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_export"
                                    {{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_export"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Payroll",$arrayPermissions) ? $arrayPermissions["Payroll"]["is_export"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_view"
                                    {{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_view"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_view"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_import"
                                    {{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_import"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_import"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_print"
                                    {{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_print"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_print"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_export"
                                    {{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_export"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("nssf",$arrayPermissions) ? $arrayPermissions["nssf"]["is_view"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_view"
                                    {{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_view"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_view"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_import"
                                    {{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_import"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_import"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_print"
                                    {{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_print"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_print"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_export"
                                    {{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_export"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Severance Pay",$arrayPermissions) ? $arrayPermissions["Severance Pay"]["is_export"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_view"
                                    {{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_view"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_view"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_add"
                                    {{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_create"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_create"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_import"
                                    {{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_import"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_import"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_edit"
                                    {{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_update"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_update"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_delete"
                                    {{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_delete"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_delete"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_print"
                                    {{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_print"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_print"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_export"
                                    {{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_export"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("Fringe Benefits",$arrayPermissions) ? $arrayPermissions["Fringe Benefits"]["is_export"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="motor_rental_check_all" 
                            {{SetCheckbox($arrayPermissions,"Motor Rentals","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"Motor Rentals","is_all")->value}}"
                            > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_view"
                                    {{SetCheckbox($arrayPermissions,"Motor Rental","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_add"
                                    {{SetCheckbox($arrayPermissions,"Motor Rental","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_import"
                                    {{SetCheckbox($arrayPermissions,"Motor Rental","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_edit"
                                    {{SetCheckbox($arrayPermissions,"Motor Rental","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_delete"
                                    {{SetCheckbox($arrayPermissions,"Motor Rental","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_print"
                                    {{SetCheckbox($arrayPermissions,"Motor Rental","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental","is_print")->value}}"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_export"
                                    {{SetCheckbox($arrayPermissions,"Motor Rental","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_view"
                                    {{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_add"
                                    {{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_approve"
                                    {{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_approve")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_approve")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_edit"
                                    {{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_delete"
                                    {{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_print"
                                    {{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_export"
                                    {{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Pay Motor Rental","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="training_check_all"
                            {{SetCheckbox($arrayPermissions,"Trainings","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"Trainings","is_all")->value}}"
                            > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_view"
                                    {{SetCheckbox($arrayPermissions,"Trainer","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Trainer","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_add"
                                    {{SetCheckbox($arrayPermissions,"Trainer","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Trainer","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_edit"
                                    {{SetCheckbox($arrayPermissions,"Trainer","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Trainer","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_delete"
                                    {{SetCheckbox($arrayPermissions,"Trainer","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Trainer","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_print"
                                    {{SetCheckbox($arrayPermissions,"Trainer","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Trainer","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_export"
                                    {{SetCheckbox($arrayPermissions,"Trainer","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Trainer","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_view"
                                    {{SetCheckbox($arrayPermissions,"Training","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_add"
                                    {{SetCheckbox($arrayPermissions,"Training","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_edit"
                                    {{SetCheckbox($arrayPermissions,"Training","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_delete"
                                    {{SetCheckbox($arrayPermissions,"Training","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_print"
                                    {{SetCheckbox($arrayPermissions,"Training","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Training","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Training Report","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training Report","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_print"
                                    {{SetCheckbox($arrayPermissions,"Training Report","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training Report","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_export"
                                    {{SetCheckbox($arrayPermissions,"Training Report","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Training Report","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="reports_check_all" 
                            {{SetCheckbox($arrayPermissions,"reports","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"reports","is_all")->value}}"
                            > <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            {{-- block Employee report --}}
                            <div class="col-md-2">
                                {{-- <label >@lang('lang.employee_reports')</label> --}}
                                <label class="container-checkbox">@lang('lang.employee_reports')
                                    <input type="checkbox" class="reports_checkbox" id="employee_reports" > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Employee Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Employee Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Employee Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Employee Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Employee Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Employee Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            {{-- block Paylroll report --}}
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.payroll_report')
                                    <input type="checkbox" class="reports_checkbox" id="payroll_report"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_view"
                                    {{SetCheckbox($arrayPermissions,"Payroll Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Payroll Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Payroll Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Payroll Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Payroll Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Payroll Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_view"
                                    {{SetCheckbox($arrayPermissions,"Tax Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Tax Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"Tax Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Tax Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"Tax Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Tax Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_view"
                                    {{SetCheckbox($arrayPermissions,"NSSF Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"NSSF Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"NSSF Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"NSSF Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"NSSF Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"NSSF Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_view"
                                    {{SetCheckbox($arrayPermissions,"Khm Pchum Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Khm Pchum Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"Khm Pchum Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Khm Pchum Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"Khm Pchum Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Khm Pchum Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_view"
                                    {{SetCheckbox($arrayPermissions,"Severance Pay Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Severance Pay Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"Severance Pay Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Severance Pay Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"Severance Pay Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Severance Pay Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_view"
                                    {{SetCheckbox($arrayPermissions,"Seniorities Pay Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Seniorities Pay Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"Seniorities Pay Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Seniorities Pay Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"Seniorities Pay Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Seniorities Pay Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Fringe Benefits Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Fringe Benefits Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Fringe Benefits Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Fringe Benefits Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Fringe Benefits Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Fringe Benefits Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Bank Transfer Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Bank Transfer Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Bank Transfer Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Bank Transfer Reports","is_print")->value}}"
                                     > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Bank Transfer Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Bank Transfer Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_view" 
                                    {{SetCheckbox($arrayPermissions,"E-Filing Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"E-Filing Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"E-Filing Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"E-Filing Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"E-Filing Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"E-Filing Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_view" 
                                    {{SetCheckbox($arrayPermissions,"E-Form Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"E-Form Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"E-Form Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"E-Form Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"E-Form Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"E-Form Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Motor Rental Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Motor Rental Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Motor Rental Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Motor Rental Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_view" 
                                    {{SetCheckbox($arrayPermissions,"New Staff Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"New Staff Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_print" 
                                    {{SetCheckbox($arrayPermissions,"New Staff Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"New Staff Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_export" 
                                    {{SetCheckbox($arrayPermissions,"New Staff Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"New Staff Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Staff Resigned Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Staff Resigned Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Staff Resigned Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Staff Resigned Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Staff Resigned Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Staff Resigned Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Transferred Staff Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Transferred Staff Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Transferred Staff Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Transferred Staff Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Transferred Staff Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Transferred Staff Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Promoted Staff Reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Promoted Staff Reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Promoted Staff Reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Promoted Staff Reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Promoted Staff Reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Promoted Staff Reports","is_export")->value}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="configuration_check_all" 
                            {{SetCheckbox($arrayPermissions,"Configuration","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"Configuration","is_all")->value}}"
                            > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Tax","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Tax","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Tax","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Tax","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Tax","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Tax","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Tax","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Tax","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Exchange Rate","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Exchange Rate","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Exchange Rate","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Exchange Rate","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Exchange Rate","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Exchange Rate","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Exchange Rate","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Exchange Rate","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Public Holidays","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Public Holidays","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Public Holidays","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Public Holidays","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Public Holidays","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Public Holidays","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Public Holidays","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Public Holidays","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Children Allowance","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Children Allowance","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Children Allowance","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Children Allowance","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Children Allowance","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Children Allowance","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Children Allowance","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Children Allowance","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="setting_check_all" 
                            {{SetCheckbox($arrayPermissions,"Setting","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"Setting","is_all")->value}}"
                            > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Bank","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Bank","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Bank","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Bank","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Bank","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Bank","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Bank","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Bank","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Position","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Position","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Position","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Position","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Position","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Position","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Position","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Position","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Branch","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Branch","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Branch","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Branch","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Branch","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Branch","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Branch","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Branch","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Department","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Department","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Department","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Department","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Department","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Department","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Department","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Department","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Forgot Password","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Forgot Password","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Forgot Password","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Forgot Password","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Forgot Password","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Forgot Password","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Forgot Password","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Forgot Password","is_delete")->value}}"
                                    > <span class="checkmark"></span>
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
                            <input type="checkbox" id="role_check_all" 
                            {{SetCheckbox($arrayPermissions,"Role","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"Role","is_all")->value}}"
                            > <span class="checkmark"></span>
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
                                    <input type="checkbox" class="role_checkbox" id="role_check_view" 
                                    {{SetCheckbox($arrayPermissions,"Role Permission","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Role Permission","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="role_checkbox" id="role_check_add" 
                                    {{SetCheckbox($arrayPermissions,"Role Permission","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Role Permission","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="role_checkbox" id="role_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"Role Permission","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Role Permission","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="role_checkbox" id="role_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"Role Permission","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Role Permission","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="role_checkbox" id="role_check_print" 
                                    {{SetCheckbox($arrayPermissions,"Role Permission","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Role Permission","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="role_checkbox" id="role_check_export" 
                                    {{SetCheckbox($arrayPermissions,"Role Permission","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"Role Permission","is_export")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                   </div>
                </div>
                <hr>
                <div class="submit-section">
                    <button type="button" class="btn btn-primary btn_edit" id="btn_edit">
                        <span class="btn-text-save">@lang('lang.submit')</span>
                        <span id="btn-save-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                    </button>
                    <a href="{{ url('role') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>