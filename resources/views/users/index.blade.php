@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('admin/css/loarding-table.css') }}">
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang("lang.employee")</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang("lang.employee")</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">

                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m2-s1","is_import")->value == "1")
                        <a href="#" class="btn add-btn" data-toggle="modal" id="import_employee"><i class="fa fa-arrow-circle-up"  data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-up" data-bs-original-title="fa fa-arrow-circle-up"></i>@lang('lang.import')</a>
                    @endif
                    @if (permissionAccess("m2-s1","is_create")->value == "1")
                        <a href="{{url('user/form/create')}}" class="btn add-btn me-2"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("m2-s1","is_view")->value == "1")
            <form class="needs-validation" novalidate>
                @csrf
                <div class="row filter-btn">
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" id="number_employee" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    
                    <div class="col-md-8 col-sm-8">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" id="icon-search-download-reload">
                                <span class="search-loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                                <span class="btn-search-txt">
                                    <i class="fa fa-search"></i>
                                </span>
                            </button>
                            @if (Auth::user()->RolePermission == 'developer')
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-export me-2" id="icon-search-download-reload">
                                    <span class="export-loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                                    <span class="btn-export-txt">
                                        <i class="fa fa-arrow-circle-down"></i>
                                    </span>
                                </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                                <span class="btn-text-reset">
                                    <i class="fa fa-undo"></i>
                                </span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            {!! Toastr::message() !!}
            <div class="content">
                <div class="page-menu">
                    <div class="row">
                        <div class="col-md-12 col-ms-12 p-0">
                            @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'HR' || Auth::user()->RolePermission == 'developer')
                                <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" id="tab_candidate_resume" href="#tbl_candidate_resume" aria-selected="true" role="tab" data-tab-id="1">@lang('lang.upcoming_staff')({{count($data)}})</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" id="tab_cancel" href="#tbl_cancel" aria-selected="false" data-tab-id="6" role="tab" tabindex="-1">@lang('lang.canceled_contract')({{count($dataCanContract)}})</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" id="tab_probation" href="#tbl_probations" aria-selected="false" role="tab" data-tab-id="2" tabindex="-1">@lang('lang.probation')({{count($dataProbation)}})</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" id="tab_fdc" href="#tbl_fdc" aria-selected="false" role="tab" data-tab-id="3" tabindex="-1">@lang('lang.fdc')({{count($dataFDC)}})</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" id="tab_udc" href="#tbl_udc" aria-selected="false" data-tab-id="4" role="tab" tabindex="-1">@lang('lang.udc')({{count($dataUDC)}})</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" id="tab_reason" href="#tbl_reject" aria-selected="false" data-tab-id="5" role="tab" tabindex="-1">@lang('lang.resigned_staff')({{count($dataResign)}})</a>
                                    </li>
                                </ul>
                            @else
                                <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" id="tab_probation" href="#tbl_probations" aria-selected="false" role="tab" data-tab-id="2" tabindex="-1">@lang('lang.probation')({{count($dataProbation)}})</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" id="tab_fdc" href="#tbl_fdc" aria-selected="false" role="tab" data-tab-id="3" tabindex="-1">@lang('lang.fdc')({{count($dataFDC)}})</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" id="tab_udc" href="#tbl_udc" aria-selected="false" data-tab-id="4" role="tab" tabindex="-1">@lang('lang.udc')({{count($dataUDC)}})</a>
                                    </li>
                                </ul>
                            @endif
                            <div class="tab-content">
                                @include('users.tab_all_table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- @include('users.persenal_infor_employee') --}}

        @include('users.import')
       
        <!-- Delete User Modal -->
        <div class="modal custom-modal fade" id="delete_user" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.deleted')!</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('users/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <input type="hidden" name="hidden_image" id="e_profile" value="">

                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
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

        $('.userDelete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
            $('.e_profile').val(_this.find('.image').text());
        });

        $('body').on('click', '#btn-emp-status a', function() {
            let id = $(this).attr('data-emp-id');
            let status = $(this).data('id');
            if (status == '1') {
                var emp_status = '@lang("lang.fixed_duration_contract")';
            } else if(status == '10') {
                var emp_status = '@lang("lang.fixed_duration_contract")';
            } else if(status == 2) {
                var emp_status = '@lang("lang.undetermined_duration_contract")';
            }else if(status == 3){
                var emp_status = '@lang("lang.resignation")';
            }else if(status == 4){
                var emp_status = '@lang("lang.termination")';
            }else if(status == 5){
                var emp_status = '@lang("lang.death")';
            }else if(status == 6){
                var emp_status = '@lang("lang.retired")';
            }else if(status == 7){
                var emp_status = '@lang("lang.lay_off")';
            }else if(status == 8){
                var emp_status = '@lang("lang.suspension")';
            }else if(status == 9){
                var emp_status = '@lang("lang.field_probation")';
            }else if (status =="Probation") {
                emp_status = status;
            }else{
                var emp_status = '@lang("lang.cancel_signed_contract")';
            }

            let join_date = $(".join_date").val();
            let start_date = $(this).attr('data-start-date');
            let end_date = $(this).attr('data-end-date');
            if (status == "Probation") {
                $.confirm({
                    title: '@lang("lang.employee_status")',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post">'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.join_dat") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control start_date" value="'+join_date+'" disabled>'+
                                    '<input type="hidden" class="form-control emp_status" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.pass_date") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control end_dete" value="'+start_date+'" disabled>'+
                                '</div>'+
                                '<label>@lang("lang.reason")</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'add-btn-status',
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
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    }
                });
            }else if (status == '1') {
                let start_date = $(this).attr('data-start-date');
                let end_date = $(this).attr('data-end-date');
                let salaryIncrease = $(this).attr('data-Salary-Increase');
                $.confirm({
                    title: '@lang("lang.employee_status")',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post" class="formName">'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label><a href="#">'+emp_status+'</a></label>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.start_date") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control start_date" value="'+start_date+'">'+
                                    '<input type="hidden" class="form-control emp_status" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.contract_deadline") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control end_dete" value="'+end_date+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.salary_increase")</label>'+
                                    '<input type="number" class="form-control total_salary_increase" value="'+salaryIncrease+'">'+
                                '</div>'+
                                '<label>@lang("lang.reason")</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var start_date = this.$content.find('.start_date').val();
                                var end_dete = this.$content.find('.end_dete').val();
                                var total_salary_increase = this.$content.find('.total_salary_increase').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!start_date) {
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                        content: 'Please input start date.',
                                    });
                                    return false;
                                }
                                if (!end_dete) {
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                        content: '@lang("lang.please_input_end_date")',
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
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('users') }}"); 
                                    }
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    }
                });
            }else if(status == '10'){
                let start_date = $(this).attr('data-end-date');
                $.confirm({
                    title: '@lang("lang.employee_status")',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post" class="formName">'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label><a href="#">'+emp_status+'</a></label>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.start_date") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control start_date" value="'+start_date+'">'+
                                    '<input type="hidden" class="form-control emp_status" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.contract_deadline") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control end_dete" value="">'+
                                '</div>'+
                                '<label>@lang("lang.reason")</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var start_date = this.$content.find('.start_date').val();
                                var end_dete = this.$content.find('.end_dete').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!start_date) {
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                        content: '@lang("lang.please_input_start_date")',
                                    });
                                    return false;
                                }
                                if (!end_dete) {
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                        content: '@lang("lang.please_input_start_date")',
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
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('users') }}"); 
                                    }
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    }
                });
            }else if(status==2){
                let start_date = $(this).attr('data-end-date');
                $.confirm({
                    title: '@lang("lang.employee_status")',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form>'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.start_date") <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control start_date" value="">'+
                                '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.reason")</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var start_date = this.$content.find('.start_date').val();
                                var id = this.$content.find('.id').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!start_date) {
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                        content: '@lang("lang.please_input_start_date")',
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
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
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
                    title: '@lang("lang.employee_status")',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post">'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.resign_date") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control resign_date" id="" name="" value="">'+
                                    '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.reason")</label>'+
                                    selectOption+
                                '</div>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var resign_date = this.$content.find('.resign_date').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!resign_date) {
                                    $.alert({
                                        title: '@lang("lang.requiered")',
                                        content: '@lang("lang.please_input_start_date")',
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
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    }
                });
            }else {
                $.confirm({
                    title: '@lang("lang.employee_status")',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post">'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+emp_status+'</a></label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label>@lang("lang.date") <span class="text-danger">*</span></label>'+
                                    '<input type="date" class="form-control resign_date">'+
                                    '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                                '</div>'+
                                '<label>@lang("lang.reason")</label>'+
                                '<textarea class="form-control resign_reason"></textarea>'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var emp_status = this.$content.find('.emp_status').val();
                                var id = this.$content.find('.id').val();
                                var resign_date = this.$content.find('.resign_date').val();
                                var resign_reason = this.$content.find('.resign_reason').val();

                                if (!resign_date) {
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
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
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('users') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
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

</script>
