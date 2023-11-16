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
                                    {{SetCheckbox($arrayPermissions,"lang.dashboards","is_all")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.dashboards","is_all")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.employee')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_employee"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_employee"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_employee"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.age_of_employee')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_age_of_employee"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_age_of_employee"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_age_of_employee"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.birthday_reminder')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_birthday_reminder"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_birthday_reminder"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_birthday_reminder"]}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_total_number_of_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_total_number_of_staff"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.total_inactive_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_total_inactive_staff"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_total_inactive_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_total_inactive_staff"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.resigned_staff')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_resigned_staff"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_resigned_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_resigned_staff"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang("lang.reasons_of_staff’s_exit")
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_reasons_of_staff’s_exit"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_reasons_of_staff"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_reasons_of_staff"]}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_ratio"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_ratio"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_taking_leave')
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_taking_leave" 
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_taking_leave"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_taking_leave"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (Internal)
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch_internal"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_training_internal"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_training_internal"]}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (External)
                                    <input type="checkbox" class="dashboad_checkbox" id="dashboad_staff_training_by_branch_external"
                                    {{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_training_external"] == "1" ? "checked": ""}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.admin_dashboard","is_dashboard")->is_dashboard["is_staff_training_external"]}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.employee","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.employee","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_import" 
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_cancel"
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_cancel")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_cancel")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_print"
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="employee_checkbox all_employee_checkbox" id="employee_export"
                                    {{SetCheckbox($arrayPermissions,"lang.all_employee","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.all_employee","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_add"
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_import"
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_cancel"
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_cancel")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_cancel")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_print"
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="employee_checkbox leaves_employee_checkbox" id="leaves_employee_export"
                                    {{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.leaves_employee","is_export")->value}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.recruitments","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.recruitments","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_add"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_import"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_approve"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_approve")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_approve")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_cancel"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_cancel")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_cancel")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_print"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_print")->value}}"
                                    ><span class="checkmark"></span>
                                </label>
                               
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="recruitment_checkbox candidate_CVs_checkbox" id="candidate_cv_export"
                                    {{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.candidate_cv","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_add"
                                    {{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_print"
                                    {{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="recruitment_checkbox recruitment_plans_checkbox" id="recruitment_plan_export"
                                    {{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.recruitment_plan","is_export")->value}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.c&b","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.c&b","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_add"
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_import"
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_approve"
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_approve")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_approve")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_print"
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox employee_salary_checkbox" id="c_and_b_export"
                                    {{SetCheckbox($arrayPermissions,"lang.employee_salary","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_salary","is_export")->value}}"
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
                                    {{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_view"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_view"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_import"
                                    {{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_import"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_import"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_print"
                                    {{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_print"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_print"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox cb_nssf_checkbox" id="cb_nssf_export"
                                    {{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_export"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.nssf",$arrayPermissions) ? $arrayPermissions["lang.nssf"]["is_view"] ? '1' :'0': '0' }}"
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
                                    {{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_view"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_view"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_import"
                                    {{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_import"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_import"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_print"
                                    {{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_print"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_print"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox severance_pay_checkbox" id="severance_pay_export"
                                    {{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_export"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.severance_pay",$arrayPermissions) ? $arrayPermissions["lang.severance_pay"]["is_export"] ? '1' :'0': '0' }}"
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
                                    {{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_view"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_view"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_add"
                                    {{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_create"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_create"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_import"
                                    {{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_import"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_import"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_edit"
                                    {{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_update"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_update"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_delete"
                                    {{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_delete"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_delete"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_print"
                                    {{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_print"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_print"] ? '1' :'0': '0' }}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="c_and_b_checkbox fringe_benefits_checkbox" id="fringe_benefits_export"
                                    {{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_export"] ? 'checked' :'': '' }}
                                    value="{{array_key_exists("lang.fringe_benefits",$arrayPermissions) ? $arrayPermissions["lang.fringe_benefits"]["is_export"] ? '1' :'0': '0' }}"
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
                            {{SetCheckbox($arrayPermissions,"lang.motor_rentals","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.motor_rentals","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_add"
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_import"
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental","is_import")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental","is_import")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_print"
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental","is_print")->value}}"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="motor_rental_checkbox motor_rentals_checkbox" id="motor_rental_export"
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_add"
                                    {{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_approve"
                                    {{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_approve")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_approve")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_print"
                                    {{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="motor_rental_checkbox pay_motor_rentals_checkbox" id="Pay_motor_rental_export"
                                    {{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.pay_motor_rental","is_export")->value}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.trainings","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.trainings","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.trainer","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.trainer","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_add"
                                    {{SetCheckbox($arrayPermissions,"lang.trainer","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.trainer","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.trainer","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.trainer","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.trainer","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.trainer","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.trainer","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.trainer","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="training_checkbox trainer_checkbox" id="trainer_check_export"
                                    {{SetCheckbox($arrayPermissions,"lang.trainer","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.trainer","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.training","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_add"
                                    {{SetCheckbox($arrayPermissions,"lang.training","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_edit"
                                    {{SetCheckbox($arrayPermissions,"lang.training","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_delete"
                                    {{SetCheckbox($arrayPermissions,"lang.training","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.training","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="training_checkbox training_checkbox_block" id="training_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.training","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.training_report","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training_report","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.training_report","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training_report","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="training_checkbox training_reports_checkbox" id="report_training_check_export"
                                    {{SetCheckbox($arrayPermissions,"lang.training_report","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.training_report","is_export")->value}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.reports","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.reports","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.employee_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.employee_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox employee_reports_checkbox" id="report_employee_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.employee_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.employee_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.payroll_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.payroll_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.payroll_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.payroll_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox payroll_report_checkbox" id="payroll_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.payroll_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.payroll_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.tax_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.tax_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.tax_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.tax_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox tax_report_checkbox" id="tax_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"lang.tax_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.tax_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.nssf_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.nssf_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.nssf_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.nssf_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox nssf_report_checkbox" id="nssf_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"lang.nssf_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.nssf_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.khm_pchum_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.khm_pchum_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.khm_pchum_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.khm_pchum_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox kmh_pchum_report_checkbox" id="kmh_pchum_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"lang.khm_pchum_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.khm_pchum_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.severance_pay_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.severance_pay_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.severance_pay_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.severance_pay_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox severance_pay_report_checkbox" id="severance_pay_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"lang.severance_pay_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.severance_pay_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.seniorities_pay_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.seniorities_pay_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.seniorities_pay_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.seniorities_pay_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox seniorities_pay_report_checkbox" id="seniorities_pay_report_check_export"
                                    {{SetCheckbox($arrayPermissions,"lang.seniorities_pay_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.seniorities_pay_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.bank_transfer_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.bank_transfer_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.bank_transfer_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.bank_transfer_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox bank_transfer_report_checkbox" id="bank_transfer_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.bank_transfer_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.bank_transfer_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.fringe_benefits_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.fringe_benefits_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.fringe_benefits_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.fringe_benefits_reports","is_print")->value}}"
                                     > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox fringe_benefits_report_checkbox" id="fringe_benefits_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.fringe_benefits_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.fringe_benefits_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.e_filing_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.e_filing_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.e_filing_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.e_filing_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox e_filing_report_checkbox" id="e_filing_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.e_filing_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.e_filing_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.e_form_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.e_form_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_print"
                                    {{SetCheckbox($arrayPermissions,"lang.e_form_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.e_form_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox e_form_report_checkbox" id="e_form_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.e_form_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.e_form_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox motor_rental_reports_checkbox" id="motor_rental_reports_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.motor_rental_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.motor_rental_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.new_staff_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.new_staff_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.new_staff_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.new_staff_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox new_staff_reports_checkbox" id="new_staff_reports_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.new_staff_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.new_staff_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.staff_resigned_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.staff_resigned_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.staff_resigned_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.staff_resigned_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox staff_resigned_reports_checkbox" id="staff_resigned_reports_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.staff_resigned_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.staff_resigned_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.promoted_staff_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.promoted_staff_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.promoted_staff_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.promoted_staff_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox promoted_staff_report_checkbox" id="promoted_staff_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.promoted_staff_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.promoted_staff_reports","is_export")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.transferred_staff_reports","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.transferred_staff_reports","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.transferred_staff_reports","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.transferred_staff_reports","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="reports_checkbox transferred_staff_report_checkbox" id="transferred_staff_report_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.transferred_staff_reports","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.transferred_staff_reports","is_export")->value}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.configuration","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.configuration","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.tax","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.tax","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.tax","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.tax","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.tax","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.tax","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="configuration_checkbox taxes_checkbox" id="taxes_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.tax","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.tax","is_delete")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="configuration_checkbox exchange_rate_checkbox" id="exchange_rate_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.exchange_rate","is_delete")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.public_holidays","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.public_holidays","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.public_holidays","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.public_holidays","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.public_holidays","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.public_holidays","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="configuration_checkbox public_holidays_checkbox" id="public_holidays_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.public_holidays","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.public_holidays","is_delete")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.children_allowance","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.children_allowance","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.children_allowance","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.children_allowance","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.children_allowance","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.children_allowance","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox"class="configuration_checkbox children_allowance_checkbox" id="children_allowance_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.children_allowance","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.children_allowance","is_delete")->value}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.setting","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.setting","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.bank","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.bank","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.bank","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.bank","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.bank","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.bank","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox bank_checkbox" id="bank_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.bank","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.bank","is_delete")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.position","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.position","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.position","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.position","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.position","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.position","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox position_checkbox" id="position_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.position","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.position","is_delete")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.branch","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.branch","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.branch","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.branch","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.branch","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.branch","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox branch_checkbox" id="branch_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.branch","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.branch","is_delete")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.department","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.department","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.department","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.department","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.department","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.department","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox department_checkbox" id="department_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.department","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.department","is_delete")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.forgot_password","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.forgot_password","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.forgot_password","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.forgot_password","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')  
                                    <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.forgot_password","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.forgot_password","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="setting_checkbox forgot_password_checkbox" id="forgot_password_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.forgot_password","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.forgot_password","is_delete")->value}}"
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
                            {{SetCheckbox($arrayPermissions,"lang.role_permission","is_all")->checkbox}}
                            value="{{SetCheckbox($arrayPermissions,"lang.role_permission","is_all")->value}}"
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
                                    {{SetCheckbox($arrayPermissions,"lang.role_permission","is_view")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.role_permission","is_view")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="role_checkbox" id="role_check_add" 
                                    {{SetCheckbox($arrayPermissions,"lang.role_permission","is_create")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.role_permission","is_create")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="role_checkbox" id="role_check_edit" 
                                    {{SetCheckbox($arrayPermissions,"lang.role_permission","is_update")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.role_permission","is_update")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="role_checkbox" id="role_check_delete" 
                                    {{SetCheckbox($arrayPermissions,"lang.role_permission","is_delete")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.role_permission","is_delete")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="role_checkbox" id="role_check_print" 
                                    {{SetCheckbox($arrayPermissions,"lang.role_permission","is_print")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.role_permission","is_print")->value}}"
                                    > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="role_checkbox" id="role_check_export" 
                                    {{SetCheckbox($arrayPermissions,"lang.role_permission","is_export")->checkbox}}
                                    value="{{SetCheckbox($arrayPermissions,"lang.role_permission","is_export")->value}}"
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