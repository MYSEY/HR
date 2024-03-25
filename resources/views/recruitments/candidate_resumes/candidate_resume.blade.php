@extends('layouts.master')
<style>
.jconfirm-buttons-center{
    float: none !important;
    text-align: center !important;
}
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.candidate_CVs')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.candidate_CVs')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m3-s1","is_import")->value == "1")
                    <a href="#" class="btn add-btn" data-toggle="modal" id="import_new_cvs"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    @endif
                    @if (permissionAccess("m3-s1","is_create")->value == "1")
                    <a href="#" class="btn add-btn me-2" id="add_new" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        @if (permissionAccess("m3-s1","is_view")->value == "1")
        <div class="">
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab_candidate_resume" aria-selected="true"
                                    role="tab">@lang('lang.cvs')<span id="data_cv" class="badge bg-secondary ms-1 rounded-pill">{{count($data)}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_short_list" href="#tab_short_list" aria-selected="false" role="tab" data-tab-id="2"
                                    tabindex="-1">@lang('lang.shortlisted')<span id="dataShortList" class="badge bg-secondary ms-1 rounded-pill">{{$dataShortList}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_not_tab_short_list" href="#tab_not_short_list" aria-selected="false" role="tab" data-tab-id="2"
                                    tabindex="-1">@lang('lang.non-shortlisted')<span id="dataNon" class="badge bg-secondary ms-1 rounded-pill">{{$dataNon}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_interviewed_failed" href="#tab_interviewed_failed" aria-selected="false" data-tab-id="6"
                                    role="tab" tabindex="-1">@lang('lang.inter-failed')<span id="dataFailed" class="badge bg-secondary ms-1 rounded-pill">{{$dataFailed}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_interviewed_result" href="#tab_interviewed_result" aria-selected="false" data-tab-id="3"
                                    role="tab" tabindex="-1">@lang('lang.inter-result')<span id="dataResult" class="badge bg-secondary ms-1 rounded-pill">{{$dataResult}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_signed_contract" href="#tab_signed_contract" aria-selected="false" data-tab-id="4"
                                    role="tab" tabindex="-1">@lang('lang.processing_contract')<span id="dataProcessing" class="badge bg-secondary ms-1 rounded-pill">{{$dataProcessing}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_signed_contract_cancel" href="#tab_signed_contract_cancel" aria-selected="false" data-tab-id="5"
                                    role="tab" tabindex="-1">@lang('lang.cancel_processing_contract')<span id="dataCancel" class="badge bg-secondary ms-1 rounded-pill">{{$dataCancel}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_upcoming" href="#tab_upcoming" aria-selected="false" data-tab-id="7"
                                    role="tab" tabindex="-1">@lang('lang.upcoming_staff')<span id="dataUpcoming" class="badge bg-secondary ms-1 rounded-pill">{{$totalUpcomings}}</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="tab_cancel" href="#tab_upcoming_cancel" aria-selected="false" data-tab-id="8"
                                    role="tab" tabindex="-1">@lang('lang.canceled_contract')<span class="badge bg-secondary ms-1 rounded-pill">{{$totalUpcomingtotalCancel}}</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <div class="tab-content">
                @include('recruitments.candidate_resumes.table_by_tab')
            </div>
        </div>
        @endif
        <!-- Delete Modal -->
        <div class="modal custom-modal fade" id="delete_candidate" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('recruitment/candidate-resume/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                <input type="hidden" name="id" class="d_id">
                                <input type="hidden" name="hidden_image" id="e_profile">
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
        @include('recruitments.candidate_resumes.modal_form_create')
        @include('recruitments.candidate_resumes.modal_form_edit')
        @include('recruitments.candidate_resumes.modal_form_create_emp')
        @include('recruitments.candidate_resumes.import')
    </div>
    @include('components.loading-modal')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>

<script type="text/javascript">
    $(function(){
        $("#import_new_cvs").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#import_motor_cv').modal('show');
        });
        $(document).on('click','.upcomingDelete', function(){
            let id = $(this).data("id");
            $('.d_id').val(id);
        });
        $("#position_applied, #e_position_applied").on("change", function() {
            let position_type = $("#position_applied option:checked").attr('data-id');
            let e_position_type = $("#e_position_applied option:checked").attr('data-id');
            if (position_type == 1 || e_position_type == 1) {
                $('#position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Supporting Staff") {
                        $("#position_type").val($(this).val());
                    }
                }); 
                $('#e_position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Supporting Staff") {
                        $("#e_position_type").val($(this).val());
                    }
                }); 
            }else{
                $('#position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Field Staff") {
                        $("#position_type").val($(this).val());
                    }
                });
                $('#e_position_type').find('option').each(function(){
                    if ($(this).attr('data-id') == "Field Staff") {
                        $("#e_position_type").val($(this).val());
                    }
                });
            }
        });

        $("#btn_tab_short_list, #btn_not_tab_short_list").on("click", function(){
            let tab_status = $(this).attr('data-tab-id');
            showDatas(tab_status);
        });
        $("#btn_tab_interviewed_failed, #btn_tab_interviewed_result, #btn_tab_signed_contract, #btn_tab_signed_contract_cancel, #btn_tab_upcoming, #tab_cancel").on("click", function(){
            let tab_status = $(this).attr('data-tab-id');
            if (tab_status ==  5) {
                tab_status ="Cancel"
            }
            showDatas(tab_status);
        });
        $(document).on('click','.btn_approve', function(){
            let id = $(this).data("id");
            let id_card = $(this).attr("data-id-card");
            let description = "@lang('lang.are_you_sure_want_to_approve')?";
            let text_label = "";
            let button_ok = {
                        text: '@lang("lang.ok")',
                        btnClass: 'add-btn-status',
                        action: function () {
                            var id = this.$content.find('.id').val();
                            axios.post('{{ URL('recruitment/candidate-resume/createemp') }}', {
                                'id': id,
                                'status': "Upcoming",
                            }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.the_process_has_been_successfully').",
                                    type: "success",
                                    timeout: 3000,
                                    icon: true
                                }).show(); 
                                showDatas("4");
                                $("#dataProcessing").text(response.data.dataProcessing);
                                $("#dataUpcoming").text(response.data.totalUpcomings);
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                    type: "error",
                                    icon: true
                                }).show();
                            });
                        }
                    };
            if (id_card == "false") {
                text_label = '<label>@lang("lang.you_cannot_aprove").</label>';
                description = "@lang('lang.please_enter_all_requried_information').";
                button_ok = "";
            }
            $.confirm({
                icon: 'fa fa-warning',
                title: '@lang("lang.approve")',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        (text_label)+
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                '</form>',
                onOpenBefore: function () {
                    $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
                },
                buttons: {
                    button_ok,
                    cancel: {
                        text: '@lang("lang.cancel")',
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function () {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        });
        $(document).on('click','.btn_cancel', function(){
            let id = $(this).data("id");
            $.confirm({
                title: '@lang("lang.cancel")',
                icon: 'fa fa-warning',
                titleClass: 'text-center',
                type: 'red',
                typeAnimated: true,
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>@lang("lang.are_you_sure_want_to_cancel")?</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                '</form>',
                onOpenBefore: function () {
                    $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
                },
                buttons: {
                    formSubmit: {
                        text: '@lang("lang.ok")',
                        btnClass: 'add-btn-status',
                        action: function () {
                            var id = this.$content.find('.id').val();
                            axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                'id': id,
                                'status': "Cancel",
                            }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.the_process_has_been_successfully').",
                                    type: "success",
                                    timeout: 3000,
                                    icon: true
                                }).show();
                                showDatas("4");
                                $("#dataProcessing").text(response.data.dataProcessing);
                                $("#dataCancel").text(response.data.dataCancel);
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: "Som@lang('lang.something_went_wrong_please_try_again_later').",
                                    type: "error",
                                    icon: true
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text: '@lang("lang.cancel")',
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function () {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            let id = $(this).data('id');
            $('.e_id').val(id);
        });
        $(document).on('click','.update', function(){
            var localeLanguage = '{{ config('app.locale') }}';
            let id = $(this).data("id");
            $("#e_id").val(id);
            $.ajax({
                type: "GET",
                url: "{{ url('recruitment/candidate-resume/edit') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        if (response.position != '') {
                            $('#e_position_applied').html('');
                            $.each(response.position, function(i, item) {
                                $('#e_position_applied').append($('<option>', {
                                    "data-id" : item.position_type_number,
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.id == response.success.position_applied
                                }));
                            });
                        }
                        if (response.branch != '') {
                            $('#e_location_applied').html('');
                            $.each(response.branch, function(i, item) {
                                $('#e_location_applied').append($('<option>', {
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.branch_name_en : item.branch_name_kh,
                                    selected: item.id == response.success.location_applied
                                }));
                            });
                        }
                        if (response.optionPositionType != '') {
                        $.each(response.optionPositionType, function(i, item) {
                            $('#e_position_type').append($('<option>', {
                                "data-id" : item.name_english,
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.position_type
                            }));
                        });
                    }
                        if (response.gender != '') {
                            $('#e_gender').html('');
                            $.each(response.gender, function(i, item) {
                                $('#e_gender').append($('<option>', {
                                    value: item.id,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.id == response.success.gender
                                }));
                            });
                        }
                        $('#e_last_name_kh').val(response.success.last_name_kh);
                        $('#e_first_name_kh').val(response.success.first_name_kh);
                        $('#e_last_name_en').val(response.success.last_name_en);
                        $('#e_first_name_en').val(response.success.first_name_en);
                        $('#e_current_position').val(response.success.current_position);
                        $('#e_companey_name').val(response.success.companey_name);
                        $('#e_current_address').val(response.success.current_address);
                        $('#e_received_date').val(response.success.received_date);
                        $('#e_recruitment_channel').val(response.success.recruitment_channel);
                        $('#e_contact_number').val(response.success.contact_number);
                        $('#hidden_cv').val(response.success.cv);
                        // $('#e_remark').val(response.success.remark);
                        $('#status').val(response.success.status);
                    }
                    $('#edit_staff').modal('show');
                }
            });
        });
        
        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-emp-id');
            let status = $(this).data('id');
            let nonShort = $(this).data('id-short');
            if(status==2){
                $.confirm({
                    title: '@lang("lang.candidate_resume_status")!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form class="needs-validation" novalidate>'+
                            '<div class="form-group">'+
                                '<label><a href="#">@lang("lang.shortlisted")</a></label>'+
                            '</div>'+
                            '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.shortlist")</label>'+
                                '<select class="form-control form-select showtList" name="short_list">'+
                                    '<option selected value="1"> @lang("lang.yes")</option>'+
                                    '<option value="2"> @lang("lang.no")</option>'+
                                    '<option value="7"> @lang("lang.black_list")</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group interviewed_date">'+
                                '<label>@lang("lang.interviewed_date") <span class="text-danger">*</span></label>'+
                                '<input type="datetime-local" class="form-control interviewed_dates">'+
                            '</div>'+
                            '<div class="form-group interview_channel">'+
                                '<label>@lang("lang.interviewed_channel")</label>'+
                                '<select class="form-control form-select interviewed_channel">'+
                                    '<option selected value="Online"> Online</option>'+
                                    '<option value="Face to face"> @lang("lang.face_to_face")</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group committee_interviewed">'+
                                '<label>@lang("lang.interview_committee") <span class="text-danger">*</span></label>'+
                                '<select class="form-control hr-select2-option-emp form-select committee_interview" id="committeeinterview" name="states[]" multiple >'+
                                   
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.remark")</label>'+
                                '<textarea type="text" rows="3" class="form-control remark"></textarea>'+
                            '</div>'+
                        '</form>',
                    onOpen: function(){
                            this.$content.find('.showtList').change(function(){
                                let value = $('.showtList').val();
                                if (value == "2" || value == "7") {
                                    $(".interviewed_date").hide();
                                    $(".interview_channel").hide();
                                    $(".committee_interviewed").hide();
                                }else{
                                    $(".interviewed_date").show();
                                    $(".interview_channel").show();
                                    $(".committee_interviewed").show();
                                }
                            });
                        },
                    buttons: {
                        confirm: {
                            text: '@lang("lang.submit")',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var c_status = this.$content.find('.status').val();
                                var short_list = this.$content.find('.showtList').val();
                                var interviewed_date = this.$content.find('.interviewed_dates').val();
                                var interviewed_channel = this.$content.find('.interviewed_channel').val();
                                var committee_interview = this.$content.find('.committee_interview').val();
                                var id = this.$content.find('.id').val();
                                var remark = this.$content.find('.remark').val();
                                if (short_list == "1") {
                                    if ($(".interviewed_dates").val() ==""){
                                        $(".interviewed_dates").css("border","solid 1px red");
                                        return false;
                                    }
                                    if (!committee_interview.length){
                                        $(".committee_interviewed").each(function(){
                                            let formGroup = $(this);
                                            let value = formGroup.attr("data-select2-id");
                                            let requeredField = formGroup.find(".hr-select2-option").val();
                                            if(!value){ 
                                                formGroup.find(".select2-selection").css("border-color","#dc3545");
                                            }else if (!requeredField) {
                                                formGroup.find(".select2-selection").css("border-color","#dc3545");
                                            }
                                        });
                                        return false;
                                    }
                                }
                                if (short_list == "7") {
                                    $.confirm({
                                        title: '@lang("lang.candidate_resume_status")!',
                                        content: 'Are you sure you want to change to <span class="text-danger">@lang("lang.black_list")</span>?',
                                        icon: 'fa fa-warning',
                                        animation: 'scale',
                                        closeAnimation: 'zoom',
                                        buttons: {
                                            confirm: {
                                                text: 'Yes, sure!',
                                                btnClass: 'add-btn-status',
                                                action: function(){
                                                    axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                                            'id': id,
                                                            'status': c_status,
                                                            'short_list': short_list,
                                                            'interviewed_date': interviewed_date,
                                                            'interviewed_channel': interviewed_channel,
                                                            'committee_interview': committee_interview.toString(),
                                                            'remark': remark,
                                                        }).then(function(response) {
                                                            new Noty({
                                                                title: "",
                                                                text: "@lang('lang.the_process_has_been_successfully').",
                                                                type: "success",
                                                                timeout: 3000,
                                                                icon: true
                                                            }).show();
                                                            if (nonShort == "non-shortlist") {
                                                                showDatas("2");
                                                                $("#data_cv").text(response.data.data);
                                                                $("#dataNon").text(response.data.dataNon);
                                                                $("#dataShortList").text(response.data.dataShortList);
                                                            }else{
                                                                window.location.replace("{{ URL('recruitment/candidate-resume/list') }}");
                                                            }
                                                    }).catch(function(error) {
                                                        new Noty({
                                                            title: "",
                                                            text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                                            type: "error",
                                                            icon: true
                                                        }).show();
                                                    });
                                                }
                                            },
                                            cancel: function(){}
                                        }
                                    });
                                }else{
                                    axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                            'id': id,
                                            'status': c_status,
                                            'short_list': short_list,
                                            'interviewed_date': interviewed_date,
                                            'interviewed_channel': interviewed_channel,
                                            'committee_interview': committee_interview.toString(),
                                            'remark': remark,
                                        }).then(function(response) {
                                            new Noty({
                                                title: "",
                                                text: "@lang('lang.the_process_has_been_successfully').",
                                                type: "success",
                                                timeout: 3000,
                                                icon: true
                                            }).show();
                                            if (nonShort == "non-shortlist") {
                                                showDatas("2");
                                                $("#data_cv").text(response.data.data);
                                                $("#dataNon").text(response.data.dataNon);
                                                $("#dataShortList").text(response.data.dataShortList);
                                            }else{
                                                window.location.replace("{{ URL('recruitment/candidate-resume/list') }}");
                                            }
                                    }).catch(function(error) {
                                        new Noty({
                                            title: "",
                                            text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                            type: "error",
                                            icon: true
                                        }).show();
                                    });
                                }
                            }
                        },
                        cancel: {
                            text: '@lang("lang.cancel")',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    }
                }); 
                $(document).ready(function(){
                    $('.hr-select2-option-emp').each(function() {
                        $(this).select2({
                            width: '100%',
                            dropdownParent: $(this).parent(),
                        })
                    });
                    axios.get('{{ URL('recruitment/candidate-resume/employee') }}', {
                    }).then(function(response) {
                        if (response.data.employees != '') {
                            $('#committeeinterview').html('');
                            $.each(response.data.employees, function(i, item) {
                                $('#committeeinterview').append($('<option>', {
                                    value: item.employee_name_en,
                                    text: item.employee_name_en,
                                    // selected: item.id == response.success.location_applied
                                }));
                            });
                        }
                    })
                });
            }else if(status == 3 || status == 6){
                let data_status = $(this).attr('data-status');
                let select_joined_interview  = ""; 
                if (data_status == 3 ) {
                    select_joined_interview = '<select class="form-control form-select joined_interview" >'+
                        '<option selected value="1"> @lang("lang.yes")</option>'+
                    '</select>';
                }else{
                    select_joined_interview = '<select class="form-control form-select joined_interview" >'+
                        '<option selected value="1"> @lang("lang.yes")</option>'+
                        '<option value="2"> @lang("lang.no")</option>'+
                        '<option value="3"> @lang("lang.delay")</option>'+
                    '</select>';
                }
                $.confirm({
                    title: '@lang("lang.candidate_resume_status")!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form class="needs-validation" novalidate>'+
                            '<div class="form-group">'+
                                '<label><a href="#">@lang("lang.interviewed")</a></label>'+
                            '</div>'+
                            '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.joined_interview")</label>'+
                                select_joined_interview+
                            '</div>'+
                            '<div class="form-group interviewed_date" style="display: none">'+
                                '<label>@lang("lang.interviewed_date") <span class="text-danger">*</span></label>'+
                                '<input type="datetime-local" class="form-control interviewed_dates">'+
                            '</div>'+
                            '<div class="form-group interviewed_results">'+
                                '<label>@lang("lang.interviewed_result")</label>'+
                                '<select class="form-control form-select interviewed_result" >'+
                                    '<option selected value="1"> @lang("lang.passed")</option>'+
                                    '<option value="2">@lang("lang.failed")</option>'+
                                    '<option value="3">@lang("lang.waiting")</option>'+
                                    '<option value="4">@lang("lang.pending")</option>'+
                                    '<option value="5">@lang("lang.high_exected_salary")</option>'+
                                    '<option value="6">@lang("lang.rejected_offered")</option>'+
                                    '<option value="7">@lang("lang.black_list")</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group interviewed_results_non" style="display:none">'+
                                '<label>@lang("lang.interviewed_result")</label>'+
                                '<select class="form-control form-select non_interviewed_result" >'+
                                    '<option selected value="8"> @lang("lang.non_black_list")</option>'+
                                    '<option value="7">@lang("lang.black_list")</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.remark")</label>'+
                                '<textarea type="text" rows="3" class="form-control remark"></textarea>'+
                            '</div>'+
                        '</form>',
                    onOpen: function(){
                            this.$content.find('.joined_interview').change(function(){
                                let value = $('.joined_interview').val();
                                if (value == "2") {
                                    $(".interviewed_results").hide();
                                    $(".interviewed_results_non").show();
                                    $(".interviewed_date").hide();
                                    $(".interviewed_dates").val("");
                                }else if(value == 3){
                                    $(".interviewed_date").show();
                                    $(".interviewed_results").hide();
                                    $(".interviewed_results_non").hide();
                                }else{
                                    $(".interviewed_results_non").hide();
                                    $(".interviewed_results").show();
                                    $(".interviewed_date").hide();
                                    $(".interviewed_dates").val("");
                                    $('.status').val(3)
                                }
                            });
                        },
                    buttons: {
                        confirm: {
                            text: '@lang("lang.submit")',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var status = this.$content.find('.status').val();
                                var joined_interview = this.$content.find('.joined_interview').val();
                                var interviewed_result = "";
                                var id = this.$content.find('.id').val();
                                var interviewed_dates = this.$content.find('.interviewed_dates').val();
                                var remark = this.$content.find('.remark').val();
                                if (joined_interview == "1") {
                                    if ($(".interviewed_result").val() ==""){
                                        $(".interviewed_result").css("border","solid 1px red");
                                        return false;
                                    }
                                    interviewed_result = this.$content.find('.interviewed_result').val();
                                }else if(joined_interview == "2"){
                                    if ($(".non_interviewed_result").val() ==""){
                                        $(".non_interviewed_result").css("border","solid 1px red");
                                        return false;
                                    }
                                    interviewed_result = this.$content.find('.non_interviewed_result').val();
                                }else if (joined_interview == 3) {
                                    if ($(".interviewed_dates").val() ==""){
                                        $(".interviewed_dates").css("border","solid 1px red");
                                        return false;
                                    }
                                };
                                if (interviewed_result == "7" || interviewed_result == "8") {
                                    let content_text = 'Are you sure you want to change to <span class="text-danger">@lang("lang.black_list")</span>?';
                                    if (interviewed_result == "8") {
                                        content_text = 'Are you sure you want to change to <span class="text-danger">@lang("lang.non_black_list")</span>?';
                                    }
                                    $.confirm({
                                        title: '@lang("lang.candidate_resume_status")!',
                                        content: content_text,
                                        icon: 'fa fa-warning',
                                        animation: 'scale',
                                        closeAnimation: 'zoom',
                                        buttons: {
                                            confirm: {
                                                text: 'Yes, sure!',
                                                btnClass: 'add-btn-status',
                                                action: function(){
                                                     axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                                            'id': id,
                                                            'status': status,
                                                            'joined_interview': joined_interview,
                                                            'interviewed_result': interviewed_result,
                                                            'interviewed_date': interviewed_dates,
                                                            'remark': remark,
                                                        }).then(function(response) {
                                                            if (status == 6) {
                                                                showDatas("6");
                                                            };
                                                            if(status == 3) {
                                                                showDatas("3");
                                                            } ;
                                                            if(nonShort == "shortlist") {
                                                                showDatas("2");
                                                            };
                                                            $("#dataFailed").text(response.data.dataFailed);
                                                            $("#dataResult").text(response.data.dataResult);
                                                            $("#dataShortList").text(response.data.dataShortList);
                                                            new Noty({
                                                                title: "",
                                                                text: "@lang('lang.the_process_has_been_successfully').",
                                                                type: "success",
                                                                timeout: 3000,
                                                                icon: true
                                                            }).show();
                                                    }).catch(function(error) {
                                                        new Noty({
                                                            title: "",
                                                            text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                                            type: "error",
                                                            icon: true
                                                        }).show();
                                                    });
                                                }
                                            },
                                            cancel: function(){}
                                        }
                                    });
                                }else{
                                    axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                            'id': id,
                                            'status': status,
                                            'joined_interview': joined_interview,
                                            'interviewed_result': interviewed_result,
                                            'interviewed_date': interviewed_dates,
                                            'remark': remark,
                                        }).then(function(response) {
                                            if (status == 6) {
                                                showDatas("6");
                                            };
                                            if(status == 3) {
                                                showDatas("3");
                                            } ;
                                            if(nonShort == "shortlist") {
                                                showDatas("2");
                                            };
                                            $("#dataFailed").text(response.data.dataFailed);
                                            $("#dataResult").text(response.data.dataResult);
                                            $("#dataShortList").text(response.data.dataShortList);
                                            new Noty({
                                                title: "",
                                                text: "@lang('lang.the_process_has_been_successfully').",
                                                type: "success",
                                                timeout: 3000,
                                                icon: true
                                            }).show();
                                    }).catch(function(error) {
                                        new Noty({
                                            title: "",
                                            text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                            type: "error",
                                            icon: true
                                        }).show();
                                    });
                                }
                            }
                        },
                        cancel: {
                            text: '@lang("lang.cancel")',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    }
                }); 
            }else if(status == 4) {
                $.confirm({
                    title: '@lang("lang.candidate_resume_status")!',
                    contentClass: 'text-center',
                    // backgroundDismiss: 'cancel',
                    content: ''+
                        '<form class="needs-validation" novalidate>'+
                            '<div class="form-group">'+
                                '<label><a href="#">@lang("lang.signed_contract")</a></label>'+
                            '</div>'+
                            '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.signed_contract_date") <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control contract_date" value="">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.join_date") <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control join_date" value="">'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: '@lang("lang.submit")',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var status = this.$content.find('.status').val();
                                var contract_date = this.$content.find('.contract_date').val();
                                var join_date = this.$content.find('.join_date').val();
                                var id = this.$content.find('.id').val();
                                if (status == "4") {
                                    if ($(".contract_date").val() ==""){
                                        $(".contract_date").css("border","solid 1px red");
                                        return false;
                                    }
                                    if ($(".join_date").val() ==""){
                                        $(".join_date").css("border","solid 1px red");
                                        return false;
                                    }
                                    
                                }
                                axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                        'id': id,
                                        'status': status,
                                        'contract_date': contract_date,
                                        'join_date': join_date,
                                    }).then(function(response) {
                                        showDatas("3");
                                        $("#dataFailed").text(response.data.dataFailed);
                                        $("#dataProcessing").text(response.data.dataProcessing);
                                        $("#dataResult").text(response.data.dataResult);
                                        new Noty({
                                            title: "",
                                            text: "@lang('lang.the_process_has_been_successfully').",
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            },
                        },
                        cancel: {
                            text: '@lang("lang.cancel")',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                }); 
            }
        });
        $(document).on('click','.btn_print', function(){
            $('#modal-loading').modal('show');
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('users/print')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    var data = response.success;
                    var date_of_birth = new Date(data.date_of_birth);
                    var date_of_commencement = new Date(data.date_of_commencement);
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
                        if (data.gender.name_english == "Female") {
                            $("#pr_mr_or_mrs").text("អ្នកស្រី ");
                            $("#pr_gender").text("ស្រី ");
                        }else{
                            $("#pr_mr_or_mrs").text("លោក ");
                            $("#pr_gender").text("ប្រុស ");
                        }
                        $("#pr_name").text(data.employee_name_kh +" ");
                        $("#pr_born_on").text(day+" ខែ "+month+" ឆ្នាំ "+ year);
                        $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                        $("#pr_permanent_province").text(data.permanentprovince.name_km + " ");
                        $("#pr_id_card_number").text(data.id_card_number+ "");

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

                        $("#pr_personal_phone_number").text(data.personal_phone_number);
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
                        $("#pr_salary_increase").text(data.salary_increas);
                        if (data.position.position_type == "Field Staff") {
                            $("#pr_supporting_or_field_staff").text("ដោយធៀបនិងភាគរយការងារសម្រេចបានសម្រាប់បុគ្គលិកឥណទាន (គិតតាម Pro-Rate) ដោយការបង់ពន្ធជូនរាជរដ្ឋាភិបាលជាបន្ទុករបស់និយោជិត");
                        }
                        print_pdf();
                        window.setTimeout(function() {
                            $('#modal-loading').modal('hide');
                        }, 2000);
                    }
                }
            });
        });
        $('body').on('click', '#btn-emp-status a', function() {
            let id = $(this).attr('data-emp-id');
            let status = $(this).data('id');
            var emp_status = status;
            let join_date = $(this).attr('data-join-date');
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
                                    '<label>@lang("lang.join_date") <span class="text-danger">*</span></label>'+
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
                                        timeout: 3000,
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    $("#dataUpcoming").text(response.data.totalUpcomings);
                                    showDatas("7");
                                    // window.location.replace("{{ URL('recruitment/candidate-resume/list') }}");
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
            }else{
                emp_status = '@lang("lang.cancel_signed_contract")';
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
                                '<div class="form-group assign_line_manager" style="display:none">'+
                                    '<label>@lang("lang.assign_new_line_manager")</label>'+
                                    '<select class="form-control hr-select2-option-emp form-select line_manager" id="line_manager" name="line_manager" >'+
                                    
                                    '</select>'+
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
                                var line_manager = this.$content.find('.line_manager').val();

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
                                        'resign_reason': resign_reason,
                                        'line_manager': line_manager
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        timeout: 3000,
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('recruitment/candidate-resume/list') }}");
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
    function showDatas(btn_tab){
        let is_update = "{{ Helper::permissionAccess('m3-s1','is_update') }}";
        let is_delete = "{{ Helper::permissionAccess('m3-s1','is_delete') }}";
        let is_cancel = "{{ Helper::permissionAccess('m3-s1','is_cancel') }}";
        let is_print = "{{ Helper::permissionAccess('m3-s1','is_print') }}";
        let is_approve = "{{ Helper::permissionAccess('m3-s1','is_approve') }}";
        var status_tab = btn_tab;
        $.ajax({
            type: "GET",
            url: "{{ url('/recruitment/candidate-resume/show') }}",
            data: {
                status: btn_tab
            },
            dataType: "JSON",
            success: function(response) {
                let datas = response.datas;
                let dataUpcomings = response.dataUpcomings;
                let dataUpcomingCancels = response.dataUpcomingCancels;
                if (datas.length > 0) {
                    var tr_re = "";
                    var tr_failed = "";
                    var tr = "";
                    var tr_not_list = "";
                    var tr_ct = "";
                    var tr_ct_cancel = "";
                    if (btn_tab == 2) {
                        let num = 1;
                        datas.map((staff) => {
                            let interviewed_date = "";
                            let time = "";
                            if (staff.interviewed_date) {
                                interviewed_date = moment(staff.interviewed_date).format('MMM-D-YYYY');
                                time = moment(staff.interviewed_date).format('hh:mm A');
                            }
                            let text_status = "";
                            let tag_i = "";
                            if (staff.status =='1') {
                                text_status = "@lang('lang.received_cv')";
                                tag_i = '<i class="fa fa-dot-circle-o text-purple"></i>'
                            }else if (staff.status =='2') {
                                text_status = "@lang('lang.shortlisted')";
                                tag_i = '<i class="fa fa-dot-circle-o text-warning"></i>'
                            }else if(staff.status =='3') {
                                text_status = "@lang('lang.interviewed')";
                                tag_i = '<i class="fa fa-dot-circle-o text-info"></i>'
                            };
                            let cv =  "";
                            if (staff.cv) {
                                cv = '<small class="block text-ellipsis">'+
                                        '<a href="{{asset("/uploads/images")}}/'+(staff.cv)+'" target="_blank" class="subdrop"><i class="la la-file-pdf"></i> <span>@lang("lang.preview_cv")</span></a>'+
                                    '</small>'
                            }
                            let dropdown_menu = '<a class="btn btn-white btn-sm btn-rounded" href="#">'+
                                                    (tag_i)+ '<span>'+(text_status)+'</span>'+
                                                '</a>';
                                if (is_update == 1) {
                                    dropdown_menu = '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                    (tag_i)+ '<span>'+(text_status)+'</span>'+
                                                '</a>';
                                }
                            if (staff.short_list == 1) {
                                tr += '<tr class="odd">'+
                                    '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                    '<td class="stuck-scroll-3">'+(staff.name_kh)+' </td>'+
                                    '<td class="stuck-scroll-3">'+(staff.name_en)+'</td>'+
                                    '<td >'+(staff.option.name_english)+'</td>'+
                                    '<td >'+(staff.position.name_english)+'</td>'+
                                    '<td >'+(staff.branch.branch_name_en)+'</td>'+
                                    '<td >'+(interviewed_date)+'</td>'+
                                    '<td >'+(time)+'</td>'+
                                    '<td ><span class="badge bg-inverse-success">'+(staff.interviewed_channel)+'</snap></td>'+
                                    '<td >'+(staff.committee_interview ? staff.committee_interview : "")+'</td>'+
                                    '<td >'+
                                        '<div class="dropdown action-label">'+
                                           (dropdown_menu)+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="3" data-id-short="shortlist"  href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-info"></i> @lang("lang.interviewed")'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td >'+
                                        cv+
                                    '</td>'+
                                    '<td>'+(staff.remark ? staff.remark: "")+'</td>'+
                                '</tr>';
                                num ++;
                            }else if (staff.short_list == 2 || staff.short_list == 7) {
                                let status_black_list = '<div class="dropdown action-label">'+
                                            (dropdown_menu)+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="2" data-id-short="non-shortlist" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-warning"></i> @lang("lang.shortlisted")'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>';
                                if (staff.short_list == 7) {
                                    status_black_list = '<span style="font-size: 13px" class="badge bg-inverse-danger">Black List</span>';
                                }
                                tr_not_list += '<tr class="odd">'+
                                    '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                    '<td class="stuck-scroll-3">'+(staff.name_kh)+' </td>'+
                                    '<td class="stuck-scroll-3">'+(staff.name_en)+'</td>'+
                                    '<td >'+(staff.option.name_english)+'</td>'+
                                    '<td >'+(staff.position.name_english)+'</td>'+
                                    '<td >'+(staff.branch.branch_name_en)+'</td>'+
                                    '<td >'+(cv)+'</td>'+
                                    '<td >'+
                                        status_black_list+
                                    '</td>'+
                                    '<td >'+(staff.remark ? staff.remark : "")+'</td>'+
                                '</tr>';
                                num ++;
                            }
                        });
                    }
                    if (status_tab == 6) {
                        let num =1;
                        datas.map((staff_result) => {
                            let interview_result = "";
                            if (staff_result.interviewed_result == "2") {
                                interview_result = "@lang('lang.failed')";
                            }else if (staff_result.interviewed_result == "5") {
                                interview_result = "@lang('lang.high_exected_salary')";
                            }else
                            if (staff_result.interviewed_result == "6") {
                                interview_result = "@lang('lang.rejected_offered')";
                            }else if(staff_result.interviewed_result == "7"){
                                interview_result = '<span class="badge bg-inverse-danger">@lang("lang.black_list")</snap>';
                            }else if(staff_result.interviewed_result == "8") {
                                interview_result = "@lang('lang.non_black_list')";
                            }else{
                                interview_result = "No";
                            };
                            let status_show_failed = "";
                            let interviewed_date = staff_result.interviewed_date ? moment(staff_result.interviewed_date).format('MMM-D-YYYY') : "";
                            if (staff_result.interviewed_result != "7") {
                                let dropdown_menu = '<a class="btn btn-white btn-sm btn-rounded" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-info"></i><span>@lang("lang.interviewed")</span>'+
                                                '</a>';
                                if (is_update == 1) {
                                    dropdown_menu =  '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                    '<i class="fa fa-dot-circle-o text-info"></i><span>@lang("lang.interviewed")</span>'+
                                                '</a>';
                                }
                                status_show_failed = '<div class="dropdown action-label">'+
                                           (dropdown_menu)+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'"  data-id="2" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-warning"></i> @lang("lang.shortlisted")'+
                                                '</a>'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'"  data-id="6" data-status="'+(staff_result.status)+'" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-info"></i> @lang("lang.interviewed")'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>';
                            }else {
                                if (staff_result.joined_interview == "1") {
                                    status_show_failed = '<span class="badge bg-inverse-success">@lang("lang.yes")</snap>'
                                }else if (staff_result.joined_interview == "2") {
                                    status_show_failed = '<span class="badge bg-inverse-danger">@lang("lang.no")</snap>'
                                }else{
                                    status_show_failed = interview_result;
                                }
                                
                            }
                            tr_failed += '<tr class="odd">'+
                                '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                '<td class="stuck-scroll-3">'+(staff_result.name_kh )+'</td>'+
                                '<td class="stuck-scroll-3">'+(staff_result.name_en)+'</td>'+
                                '<td >'+(staff_result.option.name_english)+'</td>'+
                                '<td >'+(staff_result.position.name_english)+'</td>'+
                                '<td >'+(staff_result.branch.branch_name_en)+'</td>'+
                                '<td >'+(interviewed_date)+'</td>'+
                                '<td >'+(status_show_failed)+'</td>'+
                                '<td >'+(interview_result)+'</td>'+
                                '<td >'+(staff_result.remark ? staff_result.remark: "")+'</td>'+
                            '</tr>';
                            num ++;
                        })
                    }
                    if (btn_tab == 3) {
                        let num = 1;
                        datas.map((staff_result) => {
                            let text_status = "";
                            let tag_i = "";
                            let interview_result = "";
                            if (staff_result.interviewed_result == 1) {
                                interview_result = "@lang('lang.passed')";
                            }else if (staff_result.interviewed_result == "3") {
                                interview_result = "@lang('lang.waiting')";
                            }else if (staff_result.interviewed_result == "4") {
                                interview_result = "@lang('lang.pending')";
                            }

                            if(staff_result.status =='3') {
                                text_status = " @lang('lang.interviewed')";
                                tag_i = '<i class="fa fa-dot-circle-o text-info"></i>'
                            }else if (staff_result.status =='4') {
                                text_status = "@lang('lang.signed_contract')";
                                tag_i = '<i class="fa fa-dot-circle-o text-success"></i>'
                            };
                            let status_show = "";
                            let complete = '';
                            let interviewed_date = staff_result.interviewed_date ? moment(staff_result.interviewed_date).format('MMM-D-YYYY') : "";
                            if (staff_result.interviewed_result == 1) {
                                complete = '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'" data-id="4" href="#">'+
                                            '<i class="fa fa-dot-circle-o text-success"></i> @lang("lang.complete")'+
                                        '</a>';
                            }
                            let dropdown_menu = '<a class="btn btn-white btn-sm btn-rounded" href="#">'+
                                                    (tag_i)+ '<span>'+(text_status)+'</span>'+
                                                '</a>';
                            if (is_update == 1) {
                                dropdown_menu = '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                (tag_i)+ '<span>'+ (text_status)+'</span>'+
                                            '</a>';
                            }
                            status_show = '<div class="dropdown action-label">'+
                                            (dropdown_menu)+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'"  data-id="3" data-status="'+(staff_result.status)+'" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-info"></i> @lang("lang.interviewed")'+
                                                '</a>'+
                                                (complete)+
                                            '</div>'+
                                        '</div>';
                            tr_re += ' <tr class="odd">'+
                                '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                '<td class="stuck-scroll-3">'+(staff_result.name_kh )+'</td>'+
                                '<td class="stuck-scroll-3">'+(staff_result.name_en)+'</td>'+
                                '<td >'+(staff_result.option.name_english)+'</td>'+
                                '<td >'+(staff_result.position.name_english)+'</td>'+
                                '<td >'+(staff_result.branch.branch_name_en)+'</td>'+
                                '<td >'+(interviewed_date)+'</td>'+
                                '<td ><span class="badge bg-inverse-success">'+(interview_result)+'</snap></td>'+
                                '<td >'+(status_show)+'</td>'+
                                '<td >'+(staff_result.remark ? staff_result.remark: "")+'</td>'+
                            '</tr>';
                            num ++;
                        })
                    }
                    if (btn_tab == 4 || btn_tab == "Cancel") {
                        let num  =1;
                        datas.map((staff_result) => {
                            let interview_result = "";
                            if (staff_result.interviewed_result == 1) {
                                interview_result = "@lang('lang.passed')";
                            }
                            let join_date = staff_result.join_date ? moment(staff_result.join_date).format('MMM-D-YYYY') : "";
                            let contract_date = staff_result.contract_date ? moment(staff_result.contract_date).format('MMM-D-YYYY') : "";
                            let updated_at =  moment(staff_result.updated_at).format('MMM-D-YYYY');
                            if (staff_result.status == "Cancel") {
                                action = "";
                                tr_ct_cancel += ' <tr class="odd">'+
                                    '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                    '<td class="name_kh stuck-scroll-3" >'+(staff_result.name_kh )+'</td>'+
                                    '<td class="name_en stuck-scroll-3">'+(staff_result.name_en)+'</td>'+
                                    '<td class="gender_name_english"><input type="text" class="gender_id" data-gender="'+(staff_result.gender)+'" hidden>'+(staff_result.option.name_english)+'</td>'+
                                    '<td class="position" ><input type="text" class="position_id" data-postion="'+(staff_result.position_applied)+'" hidden>'+(staff_result.position.name_english)+'</td>'+
                                    '<td class="branch"><input type="text" class="branch_id" data-branch="'+(staff_result.location_applied)+'" hidden>'+(staff_result.branch.branch_name_en)+'</td>'+
                                    '<td >'+(contract_date)+'</td>'+
                                    '<td ><input type="date" class="join_date" data-join-date="'+(staff_result.join_date)+'" hidden>'+(join_date)+'</td>'+
                                    '<td ><span class="badge bg-inverse-success">'+(interview_result)+'</snap></td>'+
                                    '<td >'+(staff_result.remark ? staff_result.remark: "")+'</td>'+
                                    '<td ><span class="badge bg-inverse-danger">'+(staff_result.status)+'</snap></td>'+
                                    '<td >'+(updated_at)+'</td>'+
                                '</tr>';
                                num ++;
                            }else{
                                let dataAprove = false;
                                if (staff_result.id_card_number && staff_result.position_type && staff_result.department_id) {
                                    dataAprove = true;
                                }
                                let dropdown_action = "";
                                let cancel = "";
                                let approve = "";
                                let print = "";
                                if (is_print == 1 || is_approve == 1 || is_cancel == 1) {
                                    if (is_print == 1 ) {
                                        print = '<a class="dropdown-item btn_print_signed_contract" href="#" data-print-status="4" data-id="'+(staff_result.id)+'">'+
                                                    '<i class="fa fa-print fa-lg m-r-5"></i> @lang("lang.print")'+
                                                '</a>';
                                    }
                                    if (is_approve == 1) {
                                        approve =  '<a class="btn btn-sm dropdown-item btn_approve" href="#" data-id-card="'+(dataAprove)+'" data-id="'+(staff_result.id)+'">'+
                                                    '<i class="fa fa-dot-circle-o text-success"></i>'+
                                                    '<span> @lang("lang.approve")</span>'+
                                                '</a>';
                                    }
                                    if (is_cancel) {
                                        cancel = '<a class="dropdown-item btn_cancel text-danger" href="#" data-id="'+(staff_result.id)+'">'+
                                                    '  <span aria-hidden="true">&times;</span> @lang("lang.cancel")'+
                                                '</a>';
                                    }
                                    dropdown_action = '<div class="dropdown dropdown-action">'+
                                            '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                                '<i class="material-icons">more_vert</i>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right">'+
                                                (print)+
                                                (approve)+
                                                (cancel)+
                                            '</div>'+
                                        '</div>';
                                }
                                tr_ct += ' <tr class="odd">'+
                                    '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                    '<td class="name_kh stuck-scroll-3" >'+(staff_result.name_kh )+'</td>'+
                                    '<td class="name_en stuck-scroll-3">'+(staff_result.name_en)+'</td>'+
                                    '<td class="gender_name_english"><input type="text" class="gender_id" data-gender="'+(staff_result.gender)+'" hidden>'+(staff_result.option.name_english)+'</td>'+
                                    '<td class="position" ><input type="text" class="position_id" data-postion="'+(staff_result.position_applied)+'" hidden>'+(staff_result.position.name_english)+'</td>'+
                                    '<td class="branch"><input type="text" class="branch_id" data-branch="'+(staff_result.location_applied)+'" hidden>'+(staff_result.branch.branch_name_en)+'</td>'+
                                    '<td >'+(contract_date)+'</td>'+
                                    '<td ><input type="date" class="join_date" data-join-date="'+(staff_result.join_date)+'" hidden>'+(join_date)+'</td>'+
                                    '<td ><span class="badge bg-inverse-success">'+(interview_result)+'</snap></td>'+
                                    '<td >'+(staff_result.remark ? staff_result.remark: "")+'</td>'+
                                    '<td>'+
                                        '<input type="text" class="phone_number" data-phone-number="'+(staff_result.contact_number)+'" hidden>'+
                                        (dropdown_action)+
                                    '</td>'+
                                '</tr>';
                                num ++;
                            }
                        });
                    }
                }else {
                    var tr = '<tr><td colspan=13 align="center">@lang("lang.no_record_to_display")</td></tr>';
                    var tr_not_list = '<tr><td colspan=9 align="center">@lang("lang.no_record_to_display")</td></tr>';
                    var tr_failed = '<tr><td colspan=10 align="center">@lang("lang.no_record_to_display")</td></tr>';
                    var tr_re = '<tr><td colspan=10 align="center">@lang("lang.no_record_to_display")</td></tr>';
                    var tr_ct = '<tr><td colspan=11 align="center">@lang("lang.no_record_to_display")</td></tr>';
                   
                }
                var tr_upcoming = "";
                if (btn_tab == 7) {
                    if (dataUpcomings.length > 0) {
                        let index = 0;
                        dataUpcomings.map((emp) => {
                            index++;
                            let tag_a = '';
                            if (emp.profile != null) {
                                tag_a = '<a href="{{asset("/uploads/images")}}/'+(emp.profile)+'" class="avatar">'+
                                            '<img alt="" src="{{asset("/uploads/images")}}/'+(emp.profile)+'">'+
                                        '</a>';
                            }else {
                                tag_a = '<a href="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                        '<img alt="" src="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                    '</a>';
                            };
                            let td = "";
                            let DOB = moment(emp.date_of_birth).format('D-MMM-YYYY')
                            let joinOfDate = moment(emp.date_of_commencement).format('D-MMM-YYYY')
                            let PassDate = moment(emp.fdc_date).format('D-MMM-YYYY')
                            let fdc_end = moment(emp.fdc_end).format('D-MMM-YYYY')
                            let basic_salary = "";
                            let salary_increas = "";
                            // if (is_view_salary == 1) {
                            //     basic_salary =    '<td>$ <a href="#">'+(emp.basic_salary)+'</a></td>';
                            //     salary_increas =  '<td>$ <a href="#">'+(emp.salary_increas)+'</a></td>';
                            // }
                            tr_upcoming +='<tr class="odd">'+
                                    '<td class="ids stuck-scroll-4">'+(index)+'</td>'+
                                    '<td class="sorting_1 stuck-scroll-4">'+
                                        '<h2 class="table-avatar">'+
                                            (tag_a)+
                                        '</h2>'+
                                    '</td>'+
                                    '<td class="stuck-scroll-4"><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.number_employee)+'</a></td>'+
                                    '<td class="stuck-scroll-4"><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_kh)+'</a></td>'+
                                    '<td><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_en)+'</a></td>'+
                                    '<td>'+(emp.gender ? localeLanguage == 'en'?  emp.gender.name_english : emp.gender.name_khmer : "")+'</td>'+
                                    '<td>'+(DOB)+'</td>'+
                                    '<td>'+(emp.branch ? localeLanguage == 'en' ? emp.branch.branch_name_en : emp.branch.branch_name_kh : "")+'</td>'+
                                    '<td>'+(emp.department ? localeLanguage == 'en' ? emp.department.name_english :  emp.department.name_khmer : "")+'</td>'+
                                    '<td>'+(emp.position ? localeLanguage == 'en' ? emp.position.name_english : emp.position.name_khmer : "")+'</td>'+
                                    '<td>'+(emp.position ? emp.position.position_type : "")+'</td>'+
                                    '<td>'+(emp.personal_phone_number)+'</td>'+
                                    // (basic_salary)+
                                    // (salary_increas)+
                                    '<td>'+(joinOfDate)+'</td>'+
                                    '<td>'+(PassDate)+'</td>'+
                                    '<td>'+
                                        '<div class="dropdown action-label">'+
                                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                '<i class="fa fa-dot-circle-o text-success"></i>'+
                                                '<span>'+(emp.emp_status)+'</span>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">'+
                                                '<input type="text" name="" class="join_date" value="" hidden>'+
                                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-start-date="'+(emp.fdc_date)+'" data-join-date="'+(emp.date_of_commencement)+'" data-id="Probation" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-success"></i> @lang("lang.probation")'+
                                                '</a>'+
                                                '<a class="dropdown-item" data-emp-id="'+(emp.id)+'" data-id="Cancel" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-danger"></i> @lang("lang.cancel")'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td class="text-end">'+
                                        '<div class="dropdown dropdown-action">'+
                                            '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                            '<i  class="material-icons">more_vert</i>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right">'+
                                                '<a class="dropdown-item userUpdate" href="{{url("user/form/edit")}}/'+(emp.id)+'" data-id="'+(emp.id)+'"><i class="fa fa-pencil m-r-5"></i> @lang("lang.edit")</a>'+
                                                '<a class="dropdown-item btn_print" data-id="'+(emp.id)+'"><i class="fa fa-print fa-lg m-r-5"></i> @lang("lang.print")</a>'+
                                                '<a class="dropdown-item upcomingDelete" href="#" data-toggle="modal" data-id="'+(emp.id)+'" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang("lang.delete")</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                            '</tr>';
                        });
                    }else{
                        tr_upcoming = '<tr><td colspan=19 align="center">@lang("lang.no_record_to_display")</td></tr>';
                    }
                }
                var tr_upcoming_cancel = "";
                if (btn_tab == 8) {
                    if (dataUpcomingCancels.length > 0) {
                        let index = 0;
                        dataUpcomingCancels.map((emp) => {
                            index++;
                            let tag_a = '';
                            if (emp.profile != null) {
                                tag_a = '<a href="{{asset("/uploads/images")}}/'+(emp.profile)+'" class="avatar">'+
                                            '<img alt="" src="{{asset("/uploads/images")}}/'+(emp.profile)+'">'+
                                        '</a>';
                            }else {
                                tag_a = '<a href="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                        '<img alt="" src="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                    '</a>';
                            };
                            let td = "";
                            let DOB = moment(emp.date_of_birth).format('D-MMM-YYYY')
                            let joinOfDate = moment(emp.date_of_commencement).format('D-MMM-YYYY')
                            let PassDate = moment(emp.fdc_date).format('D-MMM-YYYY')
                            tr_upcoming_cancel += '<tr class="odd">'+
                                                    '<td class="ids stuck-scroll-4">'+(index)+'</td>'+
                                                    '<td class="sorting_1 stuck-scroll-4">'+
                                                        '<h2 class="table-avatar">'+
                                                            (tag_a)+
                                                        '</h2>'+
                                                    '</td>'+
                                                    '<td class="stuck-scroll-4"><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.number_employee)+'</a></td>'+
                                                    '<td class="stuck-scroll-4"><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_kh)+'</a></td>'+
                                                    '<td><a href="{{url("employee/profile")}}/'+(emp.id)+'">'+(emp.employee_name_en)+'</a></td>'+
                                                    '<td>'+(emp.gender ? localeLanguage == 'en'?  emp.gender.name_english : emp.gender.name_khmer : "")+'</td>'+
                                                    '<td>'+(DOB)+'</td>'+
                                                    '<td>'+(emp.branch ? localeLanguage == 'en' ? emp.branch.branch_name_en : emp.branch.branch_name_kh : "")+'</td>'+
                                                    '<td>'+(emp.department ? localeLanguage == 'en' ? emp.department.name_english :  emp.department.name_khmer : "")+'</td>'+
                                                    '<td>'+(emp.position ? localeLanguage == 'en' ? emp.position.name_english : emp.position.name_khmer : "")+'</td>'+
                                                    '<td>'+(emp.position ? emp.position.position_type : "")+'</td>'+
                                                    '<td>'+(emp.personal_phone_number)+'</td>'+
                                                    '<td>'+(joinOfDate)+'</td>'+
                                                    '<td>'+(PassDate)+'</td>'+
                                                    '<td>'+
                                                        '<span style="font-size: 13px" class="badge bg-inverse-danger">Cancel</span>'+
                                                    '</td>'+
                                                    '<td class="text-end">'+
                                                        '<div class="dropdown dropdown-action">'+
                                                            '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                                            '<i  class="material-icons">more_vert</i>'+
                                                            '</a>'+
                                                            '<div class="dropdown-menu dropdown-menu-right">'+
                                                                '<a class="dropdown-item upcomingDelete" href="#" data-toggle="modal" data-id="'+(emp.id)+'" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang("lang.delete")</a>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</td>'+
                                                '</tr>';
                        });
                    }else{
                        tr_upcoming_cancel = '<tr><td colspan=16 align="center">@lang("lang.no_record_to_display")</td></tr>';
                    }
                }
                $(".tbl-short-list tbody").html(tr);
                $(".tbl-not-short-list tbody").html(tr_not_list);
                $(".tbl-failed tbody").html(tr_failed);
                $(".tbl-result tbody").html(tr_re);
                $(".tbl-signed-contract tbody").html(tr_ct);
                $(".tbl-signed-contract_cancel tbody").html(tr_ct_cancel);
                $(".tbl-upcoming tbody").html(tr_upcoming);
                $(".tbl-upcoming_cancel tbody").html(tr_upcoming_cancel);
            }
        });
    }
    function print_pdf() {
        $("#print_purchase").show();
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
