@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
    .reset-btn{
        color: #fff !important
    }
</style>
<link rel="stylesheet" href="{{ asset('admin/css/loarding-table.css') }}">
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">

                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Admin')
                        <a href="#" class="btn add-btn" data-toggle="modal" id="add_new"><i class="fa fa-plus"></i> Add New</a>
                    @endif
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Admin')
                        <a href="#" class="btn add-btn" data-toggle="modal" id="import_employee"><i
                                class="fa fa-plus"></i>
                            Import Data</a>
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'Admin')
            <form class="needs-validation" novalidate>
                @csrf
                <div class="row filter-btn">
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" id="number_employee" placeholder="Employee ID" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Employee name" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success btn-search me-2">
                                <span class="search-loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                                <span class="btn-search-txt">{{ __('Search') }}</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">Reload</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
       
        {!! Toastr::message() !!}
       
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12 col-ms-12">
                        <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" id="tab_candidate_resume" href="#tbl_candidate_resume" aria-selected="true" role="tab" data-tab-id="1">Upcoming Staff({{count($data)}})</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_probation" href="#tbl_probations" aria-selected="false" role="tab" data-tab-id="2" tabindex="-1">Probation({{count($dataProbation)}})</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_fdc" href="#tbl_fdc" aria-selected="false" role="tab" data-tab-id="3" tabindex="-1">FDC({{count($dataFDC)}})</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_udc" href="#tbl_udc" aria-selected="false" data-tab-id="4" role="tab" tabindex="-1">UDC({{count($dataUDC)}})</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_cancel" href="#tbl_cancel" aria-selected="false" data-tab-id="6" role="tab" tabindex="-1">Canceled Contract({{count($dataCanContract)}})</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_reason" href="#tbl_reject" aria-selected="false" data-tab-id="5" role="tab" tabindex="-1">Resigned Staff({{count($dataResign)}})</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            @include('users.tab_all_table')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('users.modal_form_create')
        @include('users.modal_form_edit')
        @include('users.import')
       
        <!-- Delete User Modal -->
        <div class="modal custom-modal fade" id="delete_user" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Deleted!</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('users/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <input type="hidden" name="hidden_image" id="e_profile" value="">

                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete User Modal -->
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{asset('/admin/js/noty.js')}}"></script>

<script>
    $(function(){
        $("#import_employee").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#importEmployeeModal').modal('show');
        });
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('users') }}"); 
        });
        // block Current Address
        $("#current_province, #e_current_province").on("change", function(){
            let id = $("#current_province").val() ?? $("#current_province").val() ?? $("#e_current_province").val() ?? $("#e_current_province").val();
            let optionSelect = "currentProvince";

            $('#current_district').html('<option selected disabled> --Select --</option>');
            $('#current_commune').html('<option selected disabled> --Select --</option>');
            $('#current_village').html('<option selected disabled> --Select --</option>');

            $('#e_current_district').html('<option selected disabled> --Select --</option>');
            $('#e_current_commune').html('<option selected disabled> --Select --</option>');
            $('#e_current_village').html('<option selected disabled> --Select --</option>');

            showProvince(id, optionSelect);
        });

        $("#current_district, #e_current_district").on("change", function(){
            let id = $("#current_district").val() ?? $("#current_district").val() ?? $("#e_current_district").val() ?? $("#e_current_district").val();
            let optionSelect = "currentDistrict";
            $('#current_commune').html('<option selected disabled> --Select --</option>');
            $('#current_village').html('<option selected disabled> --Select --</option>');

            $('#e_current_commune').html('<option selected disabled> --Select --</option>');
            $('#e_current_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });

        $("#current_commune, #e_current_commune").on("change", function(){
            let id = $("#current_commune").val() ?? $("#current_commune").val() ?? $("#e_current_commune").val() ?? $("#e_current_commune").val();
            let optionSelect = "currentCommune";
            $('#current_village').html('<option selected disabled> --Select --</option>');
            $('#e_current_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });

        // block Permanent Address
        $("#permanent_province, #e_permanent_province").on("change", function(){
            let id = $("#permanent_province").val() ?? $("#permanent_province").val() ?? $("#e_permanent_province").val() ?? $("#e_permanent_province").val();
            let optionSelect = "permanentProvince";
            $('#permanent_district').html('<option selected disabled> --Select --</option>');
            $('#permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#permanent_village').html('<option selected disabled> --Select --</option>');

            $('#e_permanent_district').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_district, #e_permanent_district").on("change", function(){
            let id = $("#permanent_district").val() ?? $("#permanent_district").val() ?? $("#e_permanent_district").val() ?? $("#e_permanent_district").val();
            let optionSelect = "permanentDistrict";
            $('#permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#permanent_village').html('<option selected disabled> --Select --</option>');

            $('#e_permanent_commune').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });
        $("#permanent_commune, #e_permanent_commune").on("change", function(){
            let id = $("#permanent_commune").val() ?? $("#permanent_commune").val() ?? $("#e_permanent_commune").val() ?? $("#e_permanent_commune").val();
            let optionSelect = "permanentCommune";
            $('#permanent_village').html('<option selected disabled> --Select --</option>');
            $('#e_permanent_village').html('<option selected disabled> --Select --</option>');
            showProvince(id, optionSelect);
        });

        $("#add_new").on("click", function (){
            $('#current_district').html('<option></option>');
            $('#current_commune').html('<option></option>');
            $('#current_village').html('<option></option>');

            $('#permanent_district').html('<option></option>');
            $('#permanent_commune').html('<option></option>');
            $('#permanent_village').html('<option></option>');
            $('#add_user').modal('show');
        });
        $(".btn-close").on("click", function(){
            $("#add_user").modal('hide')
            $("#editUserModal").modal('hide')
        });
        $(".btn-cancel").on("click", function(){
            $("#add_user").modal('hide');
            $("#editUserModal").modal('hide');
        });

        $(document).on('click','.userUpdate', function(){
            $('#e_bank_name').html('<option selected value=""> </option>');
            
            $('#e_current_province').html('<option selected value="">--Select --</option>');
            $('#e_current_district').html('<option selected value=""> </option>');
            $('#e_current_commune').html('<option selected value=""> </option>');
            $('#e_current_village').html('<option selected value=""> </option>');

            $('#e_permanent_province').html('<option selected value="">--Select --</option>');
            $('#e_permanent_district').html('<option selected value=""> </option>');
            $('#e_permanent_commune').html('<option selected value=""> </option>');
            $('#e_permanent_village').html('<option selected value=""> </option>');
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('users/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        if (response.role != '') {
                            $('#e_role_id').html('<option selected disabled> --Select --</option>');
                            $.each(response.role, function(i, item) {
                                $('#e_role_id').append($('<option>', {
                                    value: item.id,
                                    text: item.name,
                                    selected: item.id == response.success.role_id
                                }));
                            });
                        }

                        if (response.position != '') {
                            $('#e_position').html('<option selected disabled> --Select --</option>');
                            $.each(response.position, function(i, item) {
                                $('#e_position').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.position_id
                                }));
                            });
                        }
                        
                        if (response.department != '') {
                            $('#e_department').html('<option selected disabled> --Select --</option>');
                            $.each(response.department, function(i, item) {
                                $('#e_department').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.department_id
                                }));
                            });
                        }
                        if (response.optionGender != '') {
                            $('#e_gender').html('<option selected disabled> --Select --</option>');
                            $.each(response.optionGender, function(i, item) {
                                $('#e_gender').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.gender
                                }));
                            });
                        }
                        if (response.branch != '') {
                            $('#e_branch_id').html('<option selected disabled> -- Select --</option>');
                            $.each(response.branch, function(i, item) {
                                $('#e_branch_id').append($('<option>', {
                                    value: item.id,
                                    text: item.branch_name_en,
                                    selected: item.id == response.success.branch_id
                                }));
                            });
                        }
                        if (response.success.spouse == 1) {
                            $("#e_spouse").append('<option selected value="1">Yes</option> <option value="0">No</option>');
                        } else {
                            $("#e_spouse").append('<option selected value="0">No</option> <option value="1">Yes</option>');   
                        }
                        if (response.success.is_loan == 1) {
                            $("#e_is_loan").append('<option selected value="1">Yes</option> <option value="0">No</option>');
                        } else {
                            $("#e_is_loan").append('<option selected value="0">No</option> <option value="1">Yes</option>');   
                        }

                        if (response.optionIdentityType != '') {
                            $.each(response.optionIdentityType, function(i, item) {
                                $('#e_identity_type').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.identity_type
                                }));
                            });
                        }

                        if (response.optionPositionType != '') {
                            $.each(response.optionPositionType, function(i, item) {
                                $('#e_position_type').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.position_type
                                }));
                            });
                        }
                        if (response.optionLoan != '') {
                            $.each(response.optionLoan, function(i, item) {
                                $('#e_is_loan').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.is_loan
                                }));
                            });
                        }
                        
                        if (response.bank != '') {
                            $.each(response.bank, function(i, item) {
                                $('#e_bank_name').append($('<option>', {
                                    value: item.id,
                                    text: item.name,
                                    selected: item.id == response.success.bank_name
                                }));
                            });
                        }
                        
                        if (response.province != '') {
                            $.each(response.province, function(i,item) {
                                let option = {
                                    value: item.code,
                                    text: item.name_en,
                                }
                                $('#e_current_province').append($('<option>', {...option, selected: item.code == response.success.current_province})); 
                                $('#e_permanent_province').append($('<option>', {...option, selected: item.code == response.success.permanent_province})); 
                            });
                        }

                        if (response.district != '') {
                            $.each(response.district, function(i,item) {
                                if (item.province_id == response.success.current_province) {
                                    let cur_option = {}
                                    cur_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.current_district
                                    };
                                    $('#e_current_district').append($('<option>', cur_option));
                                }
                                if (item.province_id == response.success.permanent_province) {
                                    let per_option = {}
                                    per_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.permanent_district
                                    };
                                    $('#e_permanent_district').append($('<option>', per_option));
                                } 
                            });
                        }

                        if (response.conmmunes != '') {
                            $.each(response.conmmunes, function(i,item) {
                                if (item.district_id == response.success.current_district) {
                                    let cur_option = {}
                                    cur_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.current_commune
                                    };
                                    $('#e_current_commune').append($('<option>', cur_option));
                                }
                                if (item.district_id == response.success.permanent_district) {
                                    let per_option = {}
                                    per_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.permanent_commune
                                    };
                                    $('#e_permanent_commune').append($('<option>', per_option));
                                }
                            });
                        }

                        if (response.villages != '') {
                            $.each(response.villages, function(i,item) {
                                if (item.commune_id == response.success.current_commune) {
                                    let cur_option = {}
                                    cur_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.current_village
                                    };
                                    $('#e_current_village').append($('<option>', cur_option));
                                }
                                if (item.commune_id == response.success.permanent_commune) {
                                    let per_option = {}
                                    per_option= {
                                        value:item.code,
                                        text: item.name_en,
                                        selected: item.code == response.success.permanent_village
                                    };
                                    $('#e_permanent_village').append($('<option>', per_option));
                                }
                            });
                        }
                        
                        $('#e_id').val(response.success.id);
                        $('#e_number_employee').val(response.success.number_employee);
                        $('#e_employee_name_kh').val(response.success.employee_name_kh);
                        $('#e_employee_name_en').val(response.success.employee_name_en);
                        $('#e_date_of_birth').val(response.success.date_of_birth);
                        $('#e_unit').val(response.success.unit);
                        $('#e_level').val(response.success.level);
                        $('#e_basic_salary').val(response.success.basic_salary);
                        $('#e_phone_allowance').val(response.success.phone_allowance);
                        $('#e_date_of_commencement').val(response.success.date_of_commencement);
                        $('#e_number_of_children').val(response.success.number_of_children);
                        $('#e_marital_status').val(response.success.marital_status);
                        $('#e_nationality').val(response.success.nationality);
                        $('#e_personal_phone_number').val(response.success.personal_phone_number);
                        $('#e_company_phone_number').val(response.success.company_phone_number);
                        $('#e_agency_phone_number').val(response.success.agency_phone_number);
                        $('#e_email').val(response.success.email);
                        $('#e_remark').val(response.success.remark);
                        $('#e_bank_name').val(response.success.bank_name);
                        $('#e_account_name').val(response.success.account_name);
                        $('#e_account_number').val(response.success.account_number);
                        $('#e_identity_number').val(response.success.identity_number);
                        $('#e_issue_date').val(response.success.issue_date);
                        $('#e_issue_expired_date').val(response.success.issue_expired_date);
                        $('#e_profile').val(response.success.profile);
                        $('#e_guarantee_letter').val(response.success.guarantee_letter);
                        $('#e_employment_book').val(response.success.employment_book);
                        $('#e_current_house_no').val(response.success.current_house_no);
                        $('#e_current_street_no').val(response.success.current_street_no);
                        $('#e_permanent_house_no').val(response.success.permanent_house_no);
                        $('#e_permanent_street_no').val(response.success.permanent_street_no);
                        $('#editUserModal').modal('show');
                    }
                }
            });
        });
        $('.userDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
            $('.e_profile').val(_this.find('.image').text());
        });

        $('body').on('click', '#btn-emp-status a', function() {
            let id = $(this).attr('data-emp-id');
            let status = $(this).data('id');
            if (status == '1') {
                var emp_status = "Fixed Duration Contract (FDC)";
            } else if(status == '10') {
                var emp_status = "Fixed Duration Contract (FDC)";
            } else if(status == 2) {
                var emp_status = "Undetermined Duration Contract (UDC)";
            }else if(status == 3){
                var emp_status = "Resignation";
            }else if(status == 4){
                var emp_status = "Termination";
            }else if(status == 5){
                var emp_status = "Death";
            }else if(status == 6){
                var emp_status = "Retired";
            }else if(status == 7){
                var emp_status = "Lay off";
            }else if(status == 8){
                var emp_status = "Suspension";
            }else if(status == 9){
                var emp_status = "Fall Probation";
            }else if (status =="Probation") {
                emp_status = status;
            }else{
                var emp_status = "Cancel Signed Contract";
            }

            let join_date = $(".join_date").val();
            let start_date = $(this).attr('data-start-date');
            let end_date = $(this).attr('data-end-date');
            if (status == "Probation") {
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post">'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>Join Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control start_date" value="'+join_date+'" disabled>'+
                                    '<input type="hidden" class="form-control emp_status" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Pass Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control end_dete" value="'+start_date+'" disabled>'+
                                '</div>'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var resign_reason = this.$content.find('.resign_reason').val();
                                axios.post('{{ URL('employee/status') }}', {
                                        'id': id,
                                        'emp_status': emp_status,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "Something went wrong please try again later.",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-red btn-sm',
                        },
                    }
                });
            }else if (status == '1') {
                let start_date = $(this).attr('data-start-date');
                let end_date = $(this).attr('data-end-date');
                let salaryIncrease = $(this).attr('data-Salary-Increase');
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post" class="formName">'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label><a href="#">'+emp_status+'</a></label>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Start Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control start_date" value="'+start_date+'">'+
                                    '<input type="hidden" class="form-control emp_status" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>End Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control end_dete" value="'+end_date+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Salary Increase</label>'+
                                    '<input type="number" class="form-control total_salary_increase" value="'+salaryIncrease+'">'+
                                '</div>'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var start_date = this.$content.find('.start_date').val();
                                var end_dete = this.$content.find('.end_dete').val();
                                var total_salary_increase = this.$content.find('.total_salary_increase').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!start_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input start date.',
                                    });
                                    return false;
                                }
                                if (!end_dete) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input end date.',
                                    });
                                    return false;
                                }
                                
                                axios.post('{{ URL('employee/status') }}', {
                                        'emp_status': emp_status,
                                        'id': id,
                                        'start_date': start_date,
                                        'end_dete': end_dete,
                                        'total_salary_increase': total_salary_increase,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    if (response.data.message == 'successfull') {
                                        new Noty({
                                            title: "",
                                            text: "The process has been successfully.",
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('users') }}"); 
                                    }
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "Something went wrong please try again later.",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-red btn-sm',
                        },
                    }
                });
            }else if(status == '10'){
                let start_date = $(this).attr('data-end-date');
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post" class="formName">'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label><a href="#">'+emp_status+'</a></label>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Start Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control start_date" value="'+start_date+'">'+
                                    '<input type="hidden" class="form-control emp_status" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>End Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control end_dete" value="">'+
                                '</div>'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var start_date = this.$content.find('.start_date').val();
                                var end_dete = this.$content.find('.end_dete').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!start_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input start date.',
                                    });
                                    return false;
                                }
                                if (!end_dete) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input end date.',
                                    });
                                    return false;
                                }
                                
                                axios.post('{{ URL('employee/status') }}', {
                                        'emp_status': emp_status,
                                        'id': id,
                                        'start_date': start_date,
                                        'end_dete': end_dete,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    if (response.data.message == 'successfull') {
                                        new Noty({
                                            title: "",
                                            text: "The process has been successfully.",
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('users') }}"); 
                                    }
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "Something went wrong please try again later.",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-red btn-sm',
                        },
                    }
                });
            }else if(status==2){
                let start_date = $(this).attr('data-end-date');
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form>'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Start Date <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control start_date" value="'+start_date+'">'+
                                '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var start_date = this.$content.find('.start_date').val();
                                var id = this.$content.find('.id').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!start_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input end date.',
                                    });
                                    return false;
                                }

                                axios.post('{{ URL('employee/status') }}', {
                                        'id': id,
                                        'emp_status': emp_status,
                                        'start_date': start_date,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "Something went wrong please try again later.",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-red btn-sm',
                        },
                    }
                }); 
            }else if(status == 3){
                var selectOption = '<select class="select form-control resign_reason" name="department_id"></select>';
                axios.get('{{ URL('users/reasonoption') }}', {
                }).then(function(response) {
                    var options = response.data.options
                    $.each(options, function(i, item) {
                        let option = {
                            value: item.id,
                            text: item.name_english,
                        }
                        $('.resign_reason').append($('<option>', option));
                    });
                });
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post">'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>Resignation Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control resign_date" id="" name="" value="">'+
                                    '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Reason</label>'+
                                    selectOption+
                                '</div>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var resign_date = this.$content.find('.resign_date').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!resign_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input date.',
                                    });
                                    return false;
                                }
                                
                                axios.post('{{ URL('employee/status') }}', {
                                        'id': id,
                                        'emp_status': emp_status,
                                        'resign_date': resign_date,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "Something went wrong please try again later.",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-red btn-sm',
                        },
                    }
                });
            }else {
                $.confirm({
                    title: 'Employee Status!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post">'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>Date <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control resign_date">'+
                                    '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                                '</div>'+
                                '<label>Reason</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var resign_date = this.$content.find('.resign_date').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!resign_date) {
                                    $.alert({
                                        title: '<span class="text-danger">Requiered</span>',
                                        content: 'Please input date.',
                                    });
                                    return false;
                                }
                                
                                axios.post('{{ URL('employee/status') }}', {
                                        'id': id,
                                        'emp_status': emp_status,
                                        'resign_date': resign_date,
                                        'resign_reason': resign_reason
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "Something went wrong please try again later.",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-red btn-sm',
                        },
                    },
                    onContentReady: function() {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function(e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
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
                            text: item.name_en,
                        }
                        if (optionSelect == "currentProvince") {
                            $('#current_district').append($('<option>', option));
                            $('#e_current_district').append($('<option>', option));
                        }else if(optionSelect == "currentDistrict"){
                            $('#current_commune').append($('<option>', option));
                            $('#e_current_commune').append($('<option>', option));
                        }else if (optionSelect == "currentCommune") {
                            $('#current_village').append($('<option>', option));
                            $('#e_current_village').append($('<option>', option));
                        }else if (optionSelect == "permanentProvince") {
                            $('#permanent_district').append($('<option>', option));
                            $('#e_permanent_district').append($('<option>', option));
                        }else if (optionSelect == "permanentDistrict") {
                            $('#permanent_commune').append($('<option>', option));
                            $('#e_permanent_commune').append($('<option>', option));
                        }else if (optionSelect == "permanentCommune") {
                            $('#permanent_village').append($('<option>', option));
                            $('#e_permanent_village').append($('<option>', option));
                        }
                    
                    });
                }
            }
        });
    }
</script>
