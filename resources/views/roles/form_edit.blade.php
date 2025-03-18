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
{{-- new create role permission --}}
<form  method="POST" enctype="multipart/form-data">
    <input type="text" hidden name="parent_id" id="parent_id" value="{{Auth::user()->role_id}}">
    @csrf
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
                    <option value="BOD" {{ $role->role_type == "BOD" ? "selected":""}}>Board of Director</option>
                    <option value="CEO" {{ $role->role_type == "CEO" ? "selected":""}}>Chief Executive Officer</option>
                    <option value="HRAdmin" {{ $role->role_type == "HRAdmin" ? "selected":""}}>HR Admin</option>
                    <option value="HR" {{ $role->role_type == "HR" ? "selected":""}}>HR</option>
                    <option value="HOD" {{ $role->role_type == "HOD" ? "selected":""}}>Head of Department</option>
                    <option value="DHOD" {{ $role->role_type == "DHOD" ? "selected":""}}>D-Head of Department</option>
                    <option value="BM" {{ $role->role_type == "BM" ? "selected":""}}>Branch Manager</option>
                    <option value="DBM" {{ $role->role_type == "DBM" ? "selected":""}}>Deputy Branch Manager</option>
                    <option value="Employee" {{ $role->role_type == "Employee" ? "selected":""}}>Employee</option>

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
    <hr>
    <label for="">Permission</label>
    <div class="row">
        @foreach ($categoryPermission as $per)
            <div class="col-md-3 mb-2">
                <div class="form-group">
                    <div class="card border-success draggable" draggable="true">
                        <div class="card-header border-success">@lang($per->name)</div>
                        <div class="card-body">
                            <div class="mb-1 permission_all" data-id="{{$per->id}}"
                                data-name="{{$per->name}}"
                                data-subid="{{$per->sub_menu_id}}"
                                data-url="{{$per->url}}"
                                data-menu="{{$per->menu_id}}"
                                >
                                @if ($per->name == "lang.admin_dashboard")
                                    @php
                                        $dashboardData = json_decode($per->is_dashboard, true);
                                        $dashboardData = Arr::except($dashboardData, ['name', 'sub_menu_id', 'menu_id', 'url']);
                                    @endphp
                                    @foreach ($dashboardData as $key => $value)
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <label class="container-checkbox">
                                                <input type="checkbox" class="dashboad_all_admin{{ $per->id }}" name="{{ $key }}" data-subid="{{$per->sub_menu_id}}"
                                                {{SetCheckbox($arrayPermissions,$per->name,"is_dashboard")->is_dashboard[$key] == "1" ? "checked": ""}}
                                                >
                                                <span class="checkmark"></span> {{ ucfirst(str_replace('is_', ' ', $key)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    @php
                                        $pers = Arr::except($per, ['is_all', 'is_active']);
                                    @endphp
                                    @foreach ($pers->toArray() as $field => $value)
                                        @if ($value == 1 && Str::startsWith($field, 'is_'))
                                            <label class="container-checkbox">
                                                @if ($field == "is_create")
                                                    @lang('lang.' . $field)
                                                @elseif($field == "is_access")
                                                    @lang('lang.view_all_staff')
                                                @else
                                                    @lang('lang.' . str_replace('is_', '', $field))
                                                @endif
                                                <input type="checkbox" class="dashboad_all_admin{{ $per->id }}" name="{{ $field }}" data-subid="{{$per->sub_menu_id}}"
                                                {{SetCheckbox($arrayPermissions,$per->name,$field)->checkbox}}>
                                                <span class="checkmark"></span>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <hr>
    <div class="text-right">
        <button type="button" class="btn btn-danger waves-effect waves-themed btn-submit">Submit</button>
        <a class="btn btn-secondary waves-effect waves-themed"  href="{{url('role')}}"  type="button">Cancel</a>
    </div>
</form>
{{-- @include('roles.interface_edit') --}}
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/component-js/role-checkbox.js') }}"></script>
<script src="{{ asset('/admin/component-js/role-create.js') }}"></script>
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script>
    $(document).ready(function() {
        // JavaScript for drag-and-drop functionality
        const draggables = document.querySelectorAll('.draggable');
        const containers = document.querySelectorAll('.col-md-3');

        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });

            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            });
        });

        containers.forEach(container => {
            container.addEventListener('dragover', e => {
                e.preventDefault();
                const draggingElement = document.querySelector('.dragging');
                container.appendChild(draggingElement);
            });
        });
    });
    $(function() {
        var url = window.location.pathname;
        var id = url.substring(url.lastIndexOf('/') + 1);
        $(document).ready(function(){
            // module employee
            let allEmployees = $('.all_employee_checkbox').filter(':checked').length;
            if (allEmployees == $('input.all_employee_checkbox').length) {
                $("#all_employee").prop("checked", true);
            };
            // module leave
            let leavesAdmin = $('.leaves_admin_checkbox').filter(':checked').length;
            if (leavesAdmin == $('input.leaves_admin_checkbox').length) {
                $("#leaves_admin").prop("checked", true);
            };
            let leavesEmployee = $('.leaves_employee_checkbox').filter(':checked').length;
            if (leavesEmployee == $('input.leaves_employee_checkbox').length) {
                $("#leaves_employee").prop("checked", true);
            };

            let leavesReplacement = $('.request_replacement_checkbox').filter(':checked').length;
            if (leavesReplacement == $('input.request_replacement_checkbox').length) {
                $("#request_replacement").prop("checked", true);
            };

            let leavesReport = $('.leave_report_checkbox').filter(':checked').length;
            if (leavesReport == $('input.leave_report_checkbox').length) {
                $("#leaves_report").prop("checked", true);
            };
            // module recruitment
            let candidate_CVs_checkbox = $('.candidate_CVs_checkbox').filter(':checked').length;
            if (candidate_CVs_checkbox == $('input.candidate_CVs_checkbox').length) {
                $("#candidate_CVs").prop("checked", true);
            };
            let recruitment_plans_checkbox = $('.recruitment_plans_checkbox').filter(':checked').length;
            if (recruitment_plans_checkbox == $('input.recruitment_plans_checkbox').length) {
                $("#recruitment_plans").prop("checked", true);
            };
            //module C & B
            let g_checkbox = $('.g_checkbox').filter(':checked').length;
            if (g_checkbox == $('input.g_checkbox').length) {
                $("#generate_payroll").prop("checked", true);
            };
            let employee_salary_checkbox = $('.employee_salary_checkbox').filter(':checked').length;
            if (employee_salary_checkbox == $('input.employee_salary_checkbox').length) {
                $("#employee_salary").prop("checked", true);
            };
            let cb_nssf_checkbox = $('.cb_nssf_checkbox').filter(':checked').length;
            if (cb_nssf_checkbox == $('input.cb_nssf_checkbox').length) {
                $("#cb_nssf").prop("checked", true);
            };
            let severance_pay_checkbox = $('.severance_pay_checkbox').filter(':checked').length;
            if (severance_pay_checkbox == $('input.severance_pay_checkbox').length) {
                $("#severance_pay").prop("checked", true);
            };
            let fringe_benefits_checkbox = $('.fringe_benefits_checkbox').filter(':checked').length;
            if (fringe_benefits_checkbox == $('input.fringe_benefits_checkbox').length) {
                $("#fringe_benefits").prop("checked", true);
            };
            let payroll_staff_resign_checkbox = $('.payroll_staff_resign_checkbox').filter(':checked').length;
            if (payroll_staff_resign_checkbox == $('input.payroll_staff_resign_checkbox').length) {
                $("#payroll_staff_resign").prop("checked", true);
            };
            let payroll_adjustment_checkbox = $('.payroll_adjustment_checkbox').filter(':checked').length;
            if (payroll_adjustment_checkbox == $('input.payroll_adjustment_checkbox').length) {
                $("#payroll_adjustment").prop("checked", true);
            };

            // exspanse management
            let exspanse_checkbox = $('.exspanse_checkbox').filter(':checked').length;
            if (exspanse_checkbox == $('input.exspanse_checkbox').length) {
                $("#exspanse_request").prop("checked", true);
            };

            // module motor rental
            let motor_rentals_checkbox = $('.motor_rentals_checkbox').filter(':checked').length;
            if (motor_rentals_checkbox == $('input.motor_rentals_checkbox').length) {
                $("#motor_rentals").prop("checked", true);
            };
            let adjustment_mt_checkbox = $('.adjustment_mt_checkbox').filter(':checked').length;
            if (adjustment_mt_checkbox == $('input.adjustment_mt_checkbox').length) {
                $("#adjustment_mt").prop("checked", true);
            };
            let generate_pay_motor_rentals_checkbox = $('.generate_pay_motor_rentals_checkbox').filter(':checked').length;
            if (generate_pay_motor_rentals_checkbox == $('input.generate_pay_motor_rentals_checkbox').length) {
                $("#generate_pay_motor_rentals").prop("checked", true);
            };
            let pay_motor_rentals_checkbox = $('.pay_motor_rentals_checkbox').filter(':checked').length;
            if (pay_motor_rentals_checkbox == $('input.pay_motor_rentals_checkbox').length) {
                $("#pay_motor_rentals").prop("checked", true);
            };

            // module training
            let trainer_checkbox = $('.trainer_checkbox').filter(':checked').length;
            if (trainer_checkbox == $('input.trainer_checkbox').length) {
                $("#trainer").prop("checked", true);
            };
            let training_checkbox_block = $('.training_checkbox_block').filter(':checked').length;
            if (training_checkbox_block == $('input.training_checkbox_block').length) {
                $("#training").prop("checked", true);
            };
            let training_reports_checkbox = $('.training_reports_checkbox').filter(':checked').length;
            if (training_reports_checkbox == $('input.training_reports_checkbox').length) {
                $("#training_reports").prop("checked", true);
            };

            // module reports
            let employee_reports_checkbox = $('.employee_reports_checkbox').filter(':checked').length;
            if (employee_reports_checkbox == $('input.employee_reports_checkbox').length) {
                $("#employee_reports").prop("checked", true);
            };
            let payroll_report_checkbox = $('.payroll_report_checkbox').filter(':checked').length;
            if (payroll_report_checkbox == $('input.payroll_report_checkbox').length) {
                $("#payroll_report").prop("checked", true);
            };
            let tax_report_checkbox = $('.tax_report_checkbox').filter(':checked').length;
            if (tax_report_checkbox == $('input.tax_report_checkbox').length) {
                $("#tax_report").prop("checked", true);
            };
            let nssf_report_checkbox = $('.nssf_report_checkbox').filter(':checked').length;
            if (nssf_report_checkbox == $('input.nssf_report_checkbox').length) {
                $("#nssf_report").prop("checked", true);
            };
            let kmh_pchum_report_checkbox = $('.kmh_pchum_report_checkbox').filter(':checked').length;
            if (kmh_pchum_report_checkbox == $('input.kmh_pchum_report_checkbox').length) {
                $("#kmh_pchum_report").prop("checked", true);
            };
            let severance_pay_report_checkbox = $('.severance_pay_report_checkbox').filter(':checked').length;
            if (severance_pay_report_checkbox == $('input.severance_pay_report_checkbox').length) {
                $("#severance_pay_report").prop("checked", true);
            };
            let seniorities_pay_report_checkbox = $('.seniorities_pay_report_checkbox').filter(':checked').length;
            if (seniorities_pay_report_checkbox == $('input.seniorities_pay_report_checkbox').length) {
                $("#seniorities_pay_report").prop("checked", true);
            };
            let fringe_benefits_report_checkbox = $('.fringe_benefits_report_checkbox').filter(':checked').length;
            if (fringe_benefits_report_checkbox == $('input.fringe_benefits_report_checkbox').length) {
                $("#fringe_benefits_report").prop("checked", true);
            };
            let bank_transfer_report_checkbox = $('.bank_transfer_report_checkbox').filter(':checked').length;
            if (bank_transfer_report_checkbox == $('input.bank_transfer_report_checkbox').length) {
                $("#bank_transfer_report").prop("checked", true);
            };
            let e_filing_report_checkbox = $('.e_filing_report_checkbox').filter(':checked').length;
            if (e_filing_report_checkbox == $('input.e_filing_report_checkbox').length) {
                $("#e_filing_report").prop("checked", true);
            };
            let e_form_report_checkbox = $('.e_form_report_checkbox').filter(':checked').length;
            if (e_form_report_checkbox == $('input.e_form_report_checkbox').length) {
                $("#e_form_report").prop("checked", true);
            };
            let motor_rental_reports_checkbox = $('.motor_rental_reports_checkbox').filter(':checked').length;
            if (motor_rental_reports_checkbox == $('input.motor_rental_reports_checkbox').length) {
                $("#motor_rental_reports").prop("checked", true);
            };
            let new_staff_reports_checkbox = $('.new_staff_reports_checkbox').filter(':checked').length;
            if (new_staff_reports_checkbox == $('input.new_staff_reports_checkbox').length) {
                $("#new_staff_reports").prop("checked", true);
            };
            let staff_resigned_reports_checkbox = $('.staff_resigned_reports_checkbox').filter(':checked').length;
            if (staff_resigned_reports_checkbox == $('input.staff_resigned_reports_checkbox').length) {
                $("#staff_resigned_reports").prop("checked", true);
            };
            let transferred_staff_report_checkbox = $('.transferred_staff_report_checkbox').filter(':checked').length;
            if (transferred_staff_report_checkbox == $('input.transferred_staff_report_checkbox').length) {
                $("#transferred_staff_report").prop("checked", true);
            };
            let promoted_staff_report_checkbox = $('.promoted_staff_report_checkbox').filter(':checked').length;
            if (promoted_staff_report_checkbox == $('input.promoted_staff_report_checkbox').length) {
                $("#promoted_staff_report").prop("checked", true);
            };

            // module configuration
            let taxes_checkbox = $('.taxes_checkbox').filter(':checked').length;
            if (taxes_checkbox == $('input.taxes_checkbox').length) {
                $("#taxes").prop("checked", true);
            };
            let exchange_rate_checkbox = $('.exchange_rate_checkbox').filter(':checked').length;
            if (exchange_rate_checkbox == $('input.exchange_rate_checkbox').length) {
                $("#exchange_rate").prop("checked", true);
            };
            let public_holidays_checkbox = $('.public_holidays_checkbox').filter(':checked').length;
            if (public_holidays_checkbox == $('input.public_holidays_checkbox').length) {
                $("#public_holidays").prop("checked", true);
            };
            let children_allowance_checkbox = $('.children_allowance_checkbox').filter(':checked').length;
            if (children_allowance_checkbox == $('input.children_allowance_checkbox').length) {
                $("#children_allowance").prop("checked", true);
            };
            let leave_type_checkbox = $('.leave_type_checkbox').filter(':checked').length;
            if (leave_type_checkbox == $('input.leave_type_checkbox').length) {
                $("#leave_type").prop("checked", true);
            };

            // module setting
            let bank_checkbox = $('.bank_checkbox').filter(':checked').length;
            if (bank_checkbox == $('input.bank_checkbox').length) {
                $("#bank").prop("checked", true);
            };
            let position_checkbox = $('.position_checkbox').filter(':checked').length;
            if (position_checkbox == $('input.position_checkbox').length) {
                $("#position").prop("checked", true);
            };
            let branch_checkbox = $('.branch_checkbox').filter(':checked').length;
            if (branch_checkbox == $('input.branch_checkbox').length) {
                $("#branch").prop("checked", true);
            };
            let department_checkbox = $('.department_checkbox').filter(':checked').length;
            if (department_checkbox == $('input.department_checkbox').length) {
                $("#department").prop("checked", true);
            };
            let forgot_password_checkbox = $('.forgot_password_checkbox').filter(':checked').length;
            if (forgot_password_checkbox == $('input.forgot_password_checkbox').length) {
                $("#forgot_password").prop("checked", true);
            };

            // block province 
            let province_checkbox = $('.province_checkbox').filter(':checked').length;
            if (province_checkbox == $('input.province_checkbox').length) {
                $("#province").prop("checked", true);
            };
            // block district 
            let district_checkbox = $('.district_checkbox').filter(':checked').length;
            if (district_checkbox == $('input.district_checkbox').length) {
                $("#district").prop("checked", true);
            };
            // block commune 
            let commune_checkbox = $('.commune_checkbox').filter(':checked').length;
            if (commune_checkbox == $('input.commune_checkbox').length) {
                $("#commune").prop("checked", true);
            };
            // block village 
            let village_checkbox = $('.village_checkbox').filter(':checked').length;
            if (village_checkbox == $('input.village_checkbox').length) {
                $("#village").prop("checked", true);
            };
        });

        $(".btn-submit").on("click", function () {
           
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                let requered = formGroup.find(".role_required").val();
                if(!value && requered == "" || !requered){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField && requered == "") {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }
            });
            var num_miss = 0;
            $(".role_required").each(function(){
                if(!$(this).val() || $(this).val() ==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545");
                }else{
                    $(this).css("border-color","#198754");
                }
            });
            let data = [];
            $('.permission_all').each(function() {
                let id = $(this).data("id");
                let sub_name_en = $(this).data("name");
                let sub_menu_id = $(this).data("subid");
                let menu_id = $(this).data("menu");
                let url = $(this).data("url");
                let sub_class = `.dashboad_all_admin${id}`;
                let dataObj = { 
                    "name": sub_name_en,
                    "sub_menu_id":sub_menu_id,
                    "menu_id":menu_id,
                    "url":url,
                };
                let checkbox = false;
                $(sub_class).each(function() {
                    let name = $(this).attr("name");
                    if (url == "dashboad/admin" ) {
                        if ($(this).prop("checked")) {
                            checkbox = true;
                            dataObj[name] = 1;
                        }else{
                            dataObj[name] = 0;
                        }
                    }else{
                        if ($(this).prop("checked")) {
                            checkbox = true;
                            dataObj[name] = 1;
                        }
                    }
                });
                if (checkbox == true) {
                    data.push({
                        "name": sub_name_en,
                        "permission": [
                            dataObj
                        ]
                    });
                }
            });
            if (num_miss>0) {
                new Noty({
                    title: "",
                    text: 'Please input all require!',
                    type: "error",
                    timeout: 3000,
                    icon: true
                }).show();
                return false;
            }else{
                let url = "{{url('role/updatePermission')}}";
                $.ajax({
                    type: "POST",
                    url,
                    data: {
                            "id": id,
                        "_token": "{{ csrf_token() }}",
                        "role_name": $("#role_name").val(),
                        "role_type": $("#role_type").val(),
                        "role_permission": data,
                        "parent_id": $("#parent_id").val(),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.message) {
                            window.location.replace("{{ URL('role') }}");
                            new Noty({
                                title: "",
                                text: '@lang("lang.update_role_successfully")',
                                type: "success",
                                icon: true
                            }).show();
                        }
                    }
                });
            }
        });


        $(".btn_edit").on("click", function() {
            $("#btn-save-loading").css('display', 'block');
            $("#btn_edit").prop('disabled', true);
            $(".btn-text-save").css("display", "none");
            let data = dataPermission();
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                let requered = formGroup.find(".role_required").val();
                if(!value && requered == "" || !requered){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField && requered == "") {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }
            });
            var num_miss = 0;
            $(".role_required").each(function(){
                if(!$(this).val() || $(this).val() ==""){ num_miss++;}
            });
            if (num_miss>0) {
                setTimeout(function () {
                    $("#btn_edit").attr('disabled',false);
                    $("#btn-save-loading").css('display', 'none');
                    $(".btn-text-save").css("display", 'block');
                }, 500);
                new Noty({
                    title: "",
                    text: '@lang("lang.please_check_input_required")!',
                    type: "error",
                    timeout: 3000,
                    icon: true
                }).show();
                return false;
            }else{
                let url = "{{url('role/update-role')}}";
                $.ajax({
                    type: "POST",
                    url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id":id,
                        "role_name": $("#role_name").val(),
                        "role_type": $("#role_type").val(),
                        "role_permission": data,
                        "parent_id": $("#parent_id").val(),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.message) {
                            window.location.replace("{{ URL('role') }}");
                            new Noty({
                                title: "",
                                text: '@lang("lang.update_role_successfully")',
                                type: "success",
                                icon: true
                            }).show();
                            $("#btn_edit").attr('disabled',false);
                            $("#btn-save-loading").css('display', 'none');
                            $(".btn-text-save").css("display", 'block');
                        }
                    }
                });
            }
        }); 
    });
</script>
