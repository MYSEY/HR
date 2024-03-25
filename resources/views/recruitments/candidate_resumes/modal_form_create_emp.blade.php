<div id="add_emp" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.edit_candidate_cv')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="was-validated" >
                    @csrf
                    <input type="text" name="" id="candidate_id" hidden>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.employee_id')</label>
                                <input type="text" class="form-control number_employee_edit clear_data" hidden>
                                <input type="text" class="form-control number_employee clear_data" id="number_employee" name="number_employee">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.id_card_number') <span class="text-danger">*</span></label>
                                <input class="form-control emp_required clear_data" type="text" id="id_card_number" name="id_card_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control employee_name_kh emp_required" type="text" id="employee_name_kh" name="employee_name_kh" required disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control employee_name_en emp_required clear_data" type="text" id="employee_name_en" name="employee_name_en" required disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.gender') <span class="text-danger">*</span></label>
                                <select class="form-control form-select emp_required clear_data" name="gender" id="emp_gender">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.location') <span class="text-danger">*</span></label>
                                <select class="hr-select2-option clear_data" name="branch_id" id="emp_branch" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.department') <span class="text-danger">*</span></label>
                                <select class="hr-select2-option emp_required clear_data" id="department_id" name="department_id"  required>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.position') <span class="text-danger">*</span></label>
                                <select class="hr-select2-option emp_required clear_data" name="position_id" id="emp_position" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6" hidden>
                            <div class="form-group">
                                <label class="">@lang('lang.position_type') <span class="text-danger">*</span></label>
                                <select class="form-control clear_data" id="position_type" name="position_type">
                                    <option value="">@lang('lang.select')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.date_of_birth') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control clear_data datetimepicker @error('date_of_birth') is-invalid @enderror emp_required" type="text" required id="date_of_birth" name="date_of_birth" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.join_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control clear_data datetimepicker date_of_commencement emp_required" type="text" id="date_of_commencement" name="date_of_commencement" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.line_manager')</label>
                                <select class="hr-select2-option emp_required clear_data" id="line_manager" name="line_manager">
                                    <option selected disabled value=""> -- @lang('lang.select')--</option>
                                    @foreach ($lineManager as $item)
                                        <option data-id="{{$item->id}}" value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.personal_phone') <span class="text-danger">*</span></label>
                                <input class="form-control personal_phone_number emp_required clear_data" type="number" id="personal_phone_number" name="personal_phone_number" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.basic_salary')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.basic_salary') <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control emp_required clear_data" id="basic_salary" name="basic_salary" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.salary_increase')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control clear_data" type="number" id="salary_to_increase" name="salary_to_increase">
                                </div>
                            </div>
                        </div>
                    </div>
                     {{-- Created Current Address --}}
                     <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.current_address')</label>
                    </div>

                    {{-- CurrentAddress --}}
                    <div id="CurrentAddress">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.province/city') <span class="text-danger">*</span></label>
                                    <select class="form-control hr-select2-option clear_data @error('current_province') is-invalid @enderror emp_required" id="current_province" name="current_province" required>
                                        <option value="" selected> -- @lang('lang.select') --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan') <span class="text-danger">*</span></label>
                                    <select class="form-control hr-select2-option clear_data  @error('current_district') is-invalid @enderror emp_required" id="current_district" name="current_district" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label class="no-error-label">@lang('lang.commune/sangkat') <span class="text-danger">*</span></label>
                                    <select class="form-control hr-select2-option no-error-border clear_data @error('current_commune') is-invalid @enderror emp_required" id="current_commune" name="current_commune" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label class="no-error-label">@lang('lang.village') <span class="text-danger">*</span></label>
                                    <select class="form-control hr-select2-option no-error-border clear_data @error('current_village') is-invalid @enderror emp_required" id="current_village" name="current_village" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.house_no')</label>
                                <input class="form-control clear_data" type="text" id="current_house_no" name="current_house_no">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control clear_data" type="text" id="current_street_no" name="current_street_no">
                            </div>
                        </div>
                    </div>

                    {{-- Created Permanent Address --}}
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.permanent_address')</label>
                    </div>

                    {{-- PermanentAddress --}}
                    <div id="PermanentAddress">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.province/city') <span class="text-danger">*</span></label>
                                    <select class="form-control hr-select2-option clear_data @error('current_commune') is-invalid @enderror emp_required" id="permanent_province" name="permanent_province" required>
                                        <option value="" selected> -- @lang('lang.select') --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label>@lang('lang.district/khan')</label>
                                    <select class="select form-control hr-select2-option clear_data" id="permanent_district" name="permanent_district" value="{{old('permanent_district')}}">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2 ">
                                    <label class="no-error-label">@lang('lang.commune/sangkat')</label>
                                    <select class="select form-control hr-select2-option no-error-border clear_data" id="permanent_commune" name="permanent_commune" value="{{old('permanent_commune')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group hr-form-group-select2">
                                    <label class="no-error-label">@lang('lang.village')</label>
                                    <select class="select form-control hr-select2-option no-error-border clear_data" id="permanent_village" name="permanent_village" value="{{old('permanent_village')}}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.house_no')</label>
                                <input class="form-control clear_data" type="text" id="permanent_house_no" name="permanent_house_no">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.street_no')</label>
                                <input class="form-control clear_data" type="text" id="permanent_street_no" name="permanent_street_no">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="">@lang('lang.remark')</label>
                            <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="button" class="btn btn-primary  btn_save_print" id="btn_save_print" data-dismiss="modal" data-btn="1">
                            <span class="btn-text-print">@lang('lang.print')</span>
                            <span id="btn-print-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>

                        <button type="button" class="btn btn-primary btn_save" id="btn_save" data-dismiss="modal" data-btn="2">
                            <span class="btn-text-save">@lang('lang.edit')</span>
                            <span id="btn-save-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                        </button>
                        <button type="button" class="btn btn-secondary btn-cancel" id="btn-cancel">
                            <span class="btn-text-save">@lang('lang.cancel')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('recruitments.candidate_resumes.print_signed_contract')


<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script type="text/javascript">
    $(function(){
        var munber_employee_id = 0;
        $("#emp_position").on("change", function() {
            let position_type = $("#emp_position option:checked").attr('data-id');
            if (position_type == 1) {
                $('#position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Supporting Staff") {
                        $("#position_type").val($(this).val());
                    }
                }); 
            }else{
                $('#position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Field Staff") {
                        $("#position_type").val($(this).val());
                    }
                });
            }
        });
         // block Current Address
         $("#current_province").on("change", function(){
            let id = $("#current_province").val();
            let optionSelect = "currentProvince";

            $('#current_district').html('<option value=""> --@lang("lang.select") --</option>');
            $('#current_commune').html('<option value=""> --@lang("lang.select") --</option>');
            $('#current_village').html('<option value=""> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        $("#current_district").on("change", function(){
            let id = $("#current_district").val();
            let optionSelect = "currentDistrict";
            $('#current_commune').html('<option value=""> --@lang("lang.select") --</option>');
            $('#current_village').html('<option value=""> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        $("#current_commune").on("change", function(){
            let id = $("#current_commune").val();
            let optionSelect = "currentCommune";
            $('#current_village').html('<option value=""> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });

        // block Permanent Address
        $("#permanent_province").on("change", function(){
            let id = $("#permanent_province").val();
            let optionSelect = "permanentProvince";
            $('#permanent_district').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#permanent_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_district").on("change", function(){
            let id = $("#permanent_district").val();
            let optionSelect = "permanentDistrict";
            $('#permanent_commune').html('<option selected disabled> --@lang("lang.select") --</option>');
            $('#permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_commune").on("change", function(){
            let id = $("#permanent_commune").val();
            let optionSelect = "permanentCommune";
            $('#permanent_village').html('<option selected disabled> --@lang("lang.select") --</option>');
            showProvince(id, optionSelect);
        });
        $("#btn-cancel").on("click", function() {
            $('#add_emp').modal('hide');
        });

        $(document).on('click','.btn_print_signed_contract', function(){

            $('#current_province').html('<option selected value="">--@lang("lang.select") --</option>');
            $('#current_district').html('<option selected value=""> </option>');
            $('#current_commune').html('<option selected value=""> </option>');
            $('#current_village').html('<option selected value=""> </option>');

            $('#permanent_province').html('<option selected value="">--@lang("lang.select") --</option>');
            $('#permanent_district').html('<option selected value=""> </option>');
            $('#permanent_commune').html('<option selected value=""> </option>');
            $('#permanent_village').html('<option selected value=""> </option>');

            $("#position_type").html('<option selected value="">--@lang("lang.select") --</option>');
            $("#department_id").html('<option selected disabled value="">--@lang("lang.select") --</option>');
            $(".clear_data").val("");
            $("#remark").text("");
            let id = $(this).data("id");
            var localeLanguage = '{{ config('app.locale') }}';
            $.ajax({
                type: "GET",
                url: "{{ url('recruitment/candidate-resume/edit') }}",
                data: {
                    id: id,
                    status: '4',
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        if (response.position != '') {
                            $('#emp_position').html('');
                            $.each(response.position, function(i, item) {
                                $("#emp_position").append($('<option>', {
                                    "data-id" : item.position_type_number,
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.id == response.success.position_applied
                                }));
                            });
                        }
                        if (response.branch != '') {
                            $('#emp_branch').html('');
                            $.each(response.branch, function(i, item) {
                                $("#emp_branch").append($('<option>', {
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.branch_name_en : item.branch_name_kh,
                                    selected: item.id == response.success.location_applied
                                }));
                            });
                        }
                        if (response.gender != '') {
                            $('#emp_gender').html('');
                            $.each(response.gender, function(i, item) {
                                $("#emp_gender").append($('<option>', {
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.id == response.success.gender
                                }));
                            });
                        }
                        if (response.optionPositionType !='') {
                            // $("#position_type").html('');
                            $.each(response.optionPositionType, function(i, item) {
                                $("#position_type").append($('<option>', {
                                    "data-id" : item.name_english,
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.id == response.success.position_type
                                }));
                            });
                        }
                        if (response.department !='') {
                            $("#department_id").html('');
                            $.each(response.department, function(i, item) {
                                $("#department_id").append($('<option>', {
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.id == response.success.department_id
                                }));
                            });
                        }
                        if (response.province !='') {
                            $.each(response.province, function(i, item) {
                                $("#current_province").append($('<option>', {
                                    value: item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.current_province
                                }));
                                $("#permanent_province").append($('<option>', {
                                    value: item.code,
                                    text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                    selected: item.code == response.success.permanent_province
                                }));
                            });
                        }
                        if (response.district !='') {
                            $.each(response.district, function(i, item) {
                                if (item.province_id == response.success.current_province) {
                                    $("#current_district").append($('<option>', {
                                        value: item.code,
                                        text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                        selected: item.code == response.success.current_district
                                    }));
                                }
                                if (item.province_id == response.success.permanent_province) {
                                    $("#permanent_district").append($('<option>', {
                                        value: item.code,
                                        text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                        selected: item.code == response.success.permanent_district
                                    }));
                                }
                            });
                        }
                        if (response.conmmunes !='') {
                            $.each(response.conmmunes, function(i, item) {
                                if (item.district_id == response.success.current_district) {
                                    $("#current_commune").append($('<option>', {
                                        value: item.code,
                                        text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                        selected: item.code == response.success.current_commune
                                    }));
                                }
                            if (item.district_id == response.success.permanent_district) {
                                    $("#permanent_commune").append($('<option>', {
                                        value: item.code,
                                        text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                        selected: item.code == response.success.permanent_commune
                                    }));
                            }
                            });
                        }
                        if (response.villages !='') {
                            $.each(response.villages, function(i, item) {
                                if (item.commune_id == response.success.current_commune) {
                                    $("#current_village").append($('<option>', {
                                        value: item.code,
                                        text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                        selected: item.code == response.success.current_village
                                    }));
                                }
                                if (item.commune_id == response.success.permanent_commune) {
                                    $("#permanent_village").append($('<option>', {
                                        value: item.code,
                                        text: localeLanguage == 'en' ? item.name_en : item.name_km,
                                        selected: item.code == response.success.permanent_village
                                    }));
                                }
                            });
                        }
                        $("#candidate_id").val(id);
                        $(".number_employee_edit").val(response.success.number_employee);
                        $(".number_employee").val(response.success.number_employee ? response.success.number_employee : response.autoEmpId);
                        $(".employee_name_kh").val(response.success.name_kh);
                        $(".employee_name_en").val(response.success.name_en);
                        $("#date_of_birth").val(response.success.date_of_birth);
                        $(".date_of_commencement").val(response.success.join_date);
                        $("#id_card_number").val(response.success.id_card_number);
                        $(".personal_phone_number").val(response.success.contact_number);
                        $("#basic_salary").val(response.success.basic_salary);
                        $("#salary_to_increase").val(response.success.salary_increas);
                        $("#current_house_no").val(response.success.current_house_no);
                        $("#current_street_no").val(response.success.current_street_no);
                        $("#permanent_house_no").val(response.success.permanent_house_no);
                        $("#permanent_street_no").val(response.success.permanent_street_no);
                        $('#remark').val(response.success.remark);
                    }
                    $("#add_emp").modal("show");
                }
            });
        });

        $("#btn_save_print, #btn_save").on("click", function(){
            let btn_action = $(this).attr('data-btn');
            var num_miss = 0;
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                let requered = formGroup.find(".emp_required").val();
                if(!value && requered == ""){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField && requered == "") {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }
            });
            if (btn_action == 1) {
                $("#btn-print-loading").css('display', 'block');
                $("#btn_save_print").prop('disabled', true);
                $(".btn-text-print").css("display", "none");
            }else{
                $("#btn-save-loading").css('display', 'block');
                $("#btn_save").prop('disabled', true);
                $(".btn-text-save").css("display", "none");
            }
           
            $(".emp_required").each(function(){
                if($(this).val()==""){ num_miss++;}
            });
            if (num_miss>0) {
                if (btn_action == 1) {
                    setTimeout(function () {
                        $("#btn_save_print").attr('disabled',false);
                        $("#btn-print-loading").css('display', 'none');
                        $(".btn-text-print").css("display", 'block');
                    }, 500);
                }else{
                    setTimeout(function () {
                        $("#btn_save").attr('disabled',false);
                        $("#btn-save-loading").css('display', 'none');
                        $(".btn-text-save").css("display", 'block');
                    }, 500);
                }
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: "/users/duplicate",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        number_employee: $("#number_employee").val(),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        var data = response.data;
                        if ($("#number_employee").val() == $(".number_employee_edit").val()) {
                            data = 0;
                        }
                        if (data > 0) {
                            new Noty({
                                title: "",
                                text: "Employee ID already exists.",
                                type: "error",
                                timeout: 3000,
                                icon: true
                            }).show();
                            $("#number_employee").css("border-color", "red");

                            $("#btn_save").attr('disabled',false);
                            $("#btn-save-loading").css('display', 'none');
                            $(".btn-text-save").css("display", 'block');
                            $("#btn_save_print").prop('disabled', false);
                            $(".btn-text-print").show();
                            $("#btn-print-loading").css('display', 'none');
                            return false;
                        }else{
                            axios.post('{{ URL('recruitment/candidate-resume/createemp') }}', {
                                candidate_id: $("#candidate_id").val(),
                                number_employee: $("#number_employee").val(),
                                employee_name_kh: $("#employee_name_kh").val(),
                                employee_name_en: $("#employee_name_en").val(),
                                position_id: $("#emp_position").val(),
                                date_of_birth: $("#date_of_birth").val(),
                                gender: $("#emp_gender").val(),
                                department_id: $("#department_id").val(),
                                line_manager: $("#line_manager").val(),
                                branch_id: $("#emp_branch").val(),
                                date_of_commencement: $("#date_of_commencement").val(),
                                id_card_number: $("#id_card_number").val(),
                                personal_phone_number: $("#personal_phone_number").val(),
                                position_type: $("#emp_position option:checked").attr('data-id'),
                                basic_salary: $("#basic_salary").val(),
                                salary_increas: $("#salary_to_increase").val(),
                                current_province: $("#current_province").val(),
                                current_district: $("#current_district").val(),
                                current_commune: $("#current_commune").val(),
                                current_village: $("#current_village").val(),
                                current_house_no: $("#current_house_no").val(),
                                current_street_no: $("#current_street_no").val(),
                                permanent_province: $("#permanent_province").val(),
                                permanent_district: $("#permanent_district").val(),
                                permanent_commune: $("#permanent_commune").val(),
                                permanent_village: $("#permanent_village").val(),
                                permanent_house_no: $("#permanent_house_no").val(),
                                permanent_street_no: $("#permanent_street_no").val(),
                                remark: $("#remark").val(),
                            }).then(function(response) {
                                var data = response.data.dataEmployee;
                                var date_of_birth = new Date(data.date_of_birth);
                                var date_of_commencement = new Date(data.join_date);
                                var fdc_date = new Date(data.fdc_date);
                                let day = formatDate( date_of_birth, 'km', format_date={day: true});
                                let month = formatDate( date_of_birth, 'km', format_date={month: true});
                                let year = formatDate( date_of_birth, 'km', format_date={year: true});
                                let join_day = formatDate( date_of_commencement, 'km', format_date={day: true});
                                let join_month = formatDate( date_of_commencement, 'km', format_date={month: true});
                                let join_year = formatDate( date_of_commencement, 'km', format_date={year: true});
                                let end_day = formatDate( fdc_date, 'km', format_date={day: true});
                                let end_month = formatDate( fdc_date, 'km', format_date={month: true});
                                let end_year = formatDate( fdc_date, 'km', format_date={year: true});
                                if (data) {
                                    if (data.option.name_english == "Female") {
                                        $("#pr_mr_or_mrs").text("អ្នកស្រី ");
                                        $("#pr_gender").text("ស្រី ");
                                    }else{
                                        $("#pr_mr_or_mrs").text("លោក ");
                                        $("#pr_gender").text("ប្រុស ");
                                    }
                                    $("#pr_name").text(data.name_kh +" ");
                                    $("#pr_born_on").text(day+" ខែ "+month+" ឆ្នាំ "+ year);
                                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                                    $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                                    $("#pr_id_card_number").text($("#id_card_number").val()+ "");

                                    let number_home = "";
                                    let number_street = "";
                                    if (data.current_house_no) {
                                        number_home = "ផ្ទះលេខ "+ data.current_house_no;
                                    }
                                    if (data.current_street_no) {
                                        number_street = " ផ្លូវលេខ "+data.current_street_no;
                                    }
                                    let location = number_home + number_street + " ភូមិ "+data.currentvillage.name_km + " ឃុំ/សង្កាត់ " + data.currentcommune.name_km + " ស្រុក/ខណ្ឌ " + data.currentdistrict.name_km+ " ខេត្ត/ក្រុង "+data.currentprovince.name_km;

                                    $("#pr_current_location").text(location);

                                    $("#pr_personal_phone_number").text(data.contact_number);
                                    $(".pr_join_day").text(join_day);
                                    $(".pr_join_month").text(join_month);
                                    $(".pr_join_year").text(join_year);
                                    $("#pr_end_day").text(end_day);
                                    $("#pr_end_month").text(end_month);
                                    $("#pr_end_year").text(end_year);
                                    $("#pr_position").text(data.position.name_khmer);
                                    $("#pr_branch").text(data.branch.branch_name_kh);
                                    $("#pr_employee_id").text(data.number_employee);
                                    $("#pr_basic_salary").text(data.basic_salary);
                                    $("#pr_salary_increase").text($("#salary_to_increase").val());
                                    if (data.position.position_type == "Field Staff") {
                                        $("#pr_supporting_or_field_staff").text("ដោយធៀបនិងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate) ដោយការបង់ពន្ធជូនរាជរដ្ឋាភិបាលជាបន្ទុករបស់និយោជិត");
                                    }
                                    if (btn_action == 1) {
                                        print_pdf();
                                    }
                                }
                                new Noty({
                                    title: "",
                                    text: "The process has been successfully.",
                                    type: "success",
                                    timeout: 3000,
                                    icon: true
                                }).show();
                                showDatas(4);
                                $("#btn_save").attr('disabled',false);
                                $("#btn-save-loading").css('display', 'none');
                                $(".btn-text-save").css("display", 'block');
                                if (btn_action == 2) {
                                    $("#add_emp").modal("hide");
                                }
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: "Something went wrong please try again later.",
                                    type: "error",
                                    timeout: 3000,
                                    icon: true
                                }).show();
                            });
                            $("#number_employee").css("border-color", "#198754");
                        }
                    }
                });
            }
            
        });
    });
    function showProvince(id, optionSelect){
        let url = "";
        let data = {
            "_token": "{{ csrf_token() }}",
        };

        // block Current Address
        if (optionSelect == "currentProvince") {
            url = "{{url('district')}}"
            data.province_id = id
        }else if (optionSelect == "currentDistrict") {
            url = "{{url('commune')}}"
            data.district_id = id
        }else if (optionSelect == "currentCommune") {
            url = "{{url('village')}}"
            data.commune_id = id
        };

        // block Permanent Address
        if (optionSelect == "permanentProvince") {
            url = "{{url('district')}}"
            data.province_id = id
        }else if (optionSelect == "permanentDistrict") {
            url = "{{url('commune')}}"
            data.district_id = id
        }else if (optionSelect == "permanentCommune") {
            url = "{{url('village')}}"
            data.commune_id = id
        }
        var localeLanguage = '{{ config('app.locale') }}';
        $.ajax({
            type: "POST",
            url,
            data,
            dataType: "JSON",
            success: function (response) {
                var data = response.data;
                if (data != '') {
                    let option = {value: "",text: ""}
                    $.each(data, function(i, item) {
                        option = {
                            value: item.code,
                            text: localeLanguage == 'en' ? item.name_en : item.name_km,
                        }
                        if (optionSelect == "currentProvince") {
                            $('#current_district').append($('<option>', option));
                        }else if(optionSelect == "currentDistrict"){
                            $('#current_commune').append($('<option>', option));
                        }else if (optionSelect == "currentCommune") {
                            $('#current_village').append($('<option>', option));
                        }else if (optionSelect == "permanentProvince") {
                            $('#permanent_district').append($('<option>', option));
                        }else if (optionSelect == "permanentDistrict") {
                            $('#permanent_commune').append($('<option>', option));
                        }else if (optionSelect == "permanentCommune") {
                            $('#permanent_village').append($('<option>', option));
                        }
                    
                    });
                }
            }
        });
    }
    function print_pdf(type) {
        $("#print_purchase").show();

        window.setTimeout(function() {
            $("#print_purchase").hide();
            $("#btn_save_print").prop('disabled', false);
            $(".btn-text-print").show();
            $("#btn-print-loading").css('display', 'none');
            $("#add_emp").modal("hide")
        }, 2000);
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>