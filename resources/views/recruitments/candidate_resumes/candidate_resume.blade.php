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
                    <a href="#" class="btn add-btn" data-toggle="modal" id="import_new_cvs"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    <a href="#" class="btn add-btn me-2" id="add_new" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="">
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab_candidate_resume" aria-selected="true"
                                    role="tab">@lang('lang.cvs')(<span id="data_cv">{{count($data)}}</span>)</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_short_list" href="#tab_short_list" aria-selected="false" role="tab" data-tab-id="2"
                                    tabindex="-1">@lang('lang.shortlisted')(<span id="dataShortList">{{$dataShortList}})</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_not_tab_short_list" href="#tab_not_short_list" aria-selected="false" role="tab" data-tab-id="2"
                                    tabindex="-1">@lang('lang.non-shortlisted')(<span id="dataNon">{{$dataNon}}</span>)</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_interviewed_failed" href="#tab_interviewed_failed" aria-selected="false" data-tab-id="6"
                                    role="tab" tabindex="-1">@lang('lang.inter-failed')(<span id="dataFailed">{{$dataFailed}}</span>)</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_interviewed_result" href="#tab_interviewed_result" aria-selected="false" data-tab-id="3"
                                    role="tab" tabindex="-1">@lang('lang.inter-result')(<span id="dataResult">{{$dataResult}}</span>)</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_signed_contract" href="#tab_signed_contract" aria-selected="false" data-tab-id="4"
                                    role="tab" tabindex="-1">@lang('lang.processing_contract')(<span id="dataProcessing">{{$dataProcessing}}</span>)</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_signed_contract_cancel" href="#tab_signed_contract_cancel" aria-selected="false" data-tab-id="5"
                                    role="tab" tabindex="-1">@lang('lang.canceled_contract')(<span id="dataCancel">{{$dataCancel}}</span>)</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <div class="tab-content">
                @include('recruitments.candidate_resumes.table_by_tab')
            </div>
        </div>

        <!-- Delete training type Modal -->
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
        @include('recruitments.candidate_resumes.modal_form_create')
        @include('recruitments.candidate_resumes.modal_form_edit')
        @include('recruitments.candidate_resumes.modal_form_create_emp')
        @include('recruitments.candidate_resumes.import')

    </div>
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>

<script type="text/javascript">
    $(function(){
        $("#import_new_cvs").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#import_motor_cv').modal('show');
        });
        $("#btn_tab_short_list, #btn_not_tab_short_list").on("click", function(){
            let tab_status = $(this).attr('data-tab-id');
            showDatas(tab_status);
        });
        $("#btn_tab_interviewed_failed, #btn_tab_interviewed_result, #btn_tab_signed_contract, #btn_tab_signed_contract_cancel").on("click", function(){
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
                        $('#e_name_kh').val(response.success.name_kh);
                        $('#e_name_en').val(response.success.name_en);
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
                                // '<input type="text" id="committeeinterview" class="form-control committee_interview">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.remark")</label>'+
                                '<textarea type="text" rows="3" class="form-control remark"></textarea>'+
                            '</div>'+
                        '</form>',
                    onOpen: function(){
                            this.$content.find('.showtList').change(function(){
                                let value = $('.showtList').val();
                                if (value == "2") {
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
                                    $(".interviewed_date").hide();
                                    $(".interviewed_dates").val("");
                                }else if(value == 3){
                                    $(".interviewed_date").show();
                                    $(".interviewed_results").hide();
                                }else{
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
                                var interviewed_result = this.$content.find('.interviewed_result').val();
                                var id = this.$content.find('.id').val();
                                var interviewed_dates = this.$content.find('.interviewed_dates').val();
                                var remark = this.$content.find('.remark').val();
                                if (joined_interview == "1") {
                                    if ($(".interviewed_result").val() ==""){
                                        $(".interviewed_result").css("border","solid 1px red");
                                        return false;
                                    }
                                }else if (joined_interview == 3) {
                                    if ($(".interviewed_dates").val() ==""){
                                        $(".interviewed_dates").css("border","solid 1px red");
                                        return false;
                                    }
                                }

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
    });
    function showDatas(btn_tab){
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
                                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                (tag_i)+ '<span>'+(text_status)+'</span>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                // '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="2" href="#">'+
                                                //     '<i class="fa fa-dot-circle-o text-warning"></i> Shortlisted'+
                                                // '</a>'+
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
                            }else if (staff.short_list == 2) {
                                tr_not_list += '<tr class="odd">'+
                                    '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                    '<td class="stuck-scroll-3">'+(staff.name_kh)+' </td>'+
                                    '<td class="stuck-scroll-3">'+(staff.name_en)+'</td>'+
                                    '<td >'+(staff.option.name_english)+'</td>'+
                                    '<td >'+(staff.position.name_english)+'</td>'+
                                    '<td >'+(staff.branch.branch_name_en)+'</td>'+
                                    '<td >'+
                                        cv+
                                    '</td>'+
                                    '<td >'+
                                        '<div class="dropdown action-label">'+
                                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                (tag_i)+ '<span>'+(text_status)+'</span>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="2" data-id-short="non-shortlist" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-warning"></i> @lang("lang.shortlisted")'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+(staff.remark ? staff.remark: "")+'</td>'+
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
                                interview_result = '<span class="badge bg-inverse-danger">@lang("lang.black_list")</snap>'
                            }else{
                                interview_result = "No";
                            };
                            let status_show_failed = "";
                            let interviewed_date = staff_result.interviewed_date ? moment(staff_result.interviewed_date).format('MMM-D-YYYY') : "";
                            if (staff_result.interviewed_result == "5") {
                                status_show_failed = '<div class="dropdown action-label">'+
                                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                '<i class="fa fa-dot-circle-o text-info"></i><span>@lang("lang.interviewed")</span>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'"  data-id="6" data-status="'+(staff_result.status)+'" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-info"></i> @lang("lang.interviewed")'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>';
                            }else {
                                status_show_failed = interview_result;
                            }
                            tr_failed += '<tr class="odd">'+
                                '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                                '<td class="stuck-scroll-3">'+(staff_result.name_kh )+'</td>'+
                                '<td class="stuck-scroll-3">'+(staff_result.name_en)+'</td>'+
                                '<td >'+(staff_result.option.name_english)+'</td>'+
                                '<td >'+(staff_result.position.name_english)+'</td>'+
                                '<td >'+(staff_result.branch.branch_name_en)+'</td>'+
                                '<td >'+(interviewed_date)+'</td>'+
                                '<td >'+(interview_result)+'</td>'+
                                '<td >'+(status_show_failed)+'</td>'+
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
                            status_show = '<div class="dropdown action-label">'+
                                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                (tag_i)+ '<span>'+ (text_status)+'</span>'+
                                            '</a>'+
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
                    };
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
                                        '<div class="dropdown dropdown-action">'+
                                            '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">'+
                                                '<i class="material-icons">more_vert</i>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right">'+
                                                '<a class="dropdown-item btn_print_signed_contract" href="#" data-print-status="4" data-id="'+(staff_result.id)+'">'+
                                                    '<i class="fa fa-print fa-lg m-r-5"></i> @lang("lang.print")'+
                                                '</a>'+
                                                '<a class="btn btn-sm dropdown-item btn_approve" href="#" data-id-card="'+(dataAprove)+'" data-id="'+(staff_result.id)+'">'+
                                                    '<i class="fa fa-dot-circle-o text-success"></i>'+
                                                    '<span> @lang("lang.approve")</span>'+
                                                '</a>'+
                                                '<a class="dropdown-item btn_cancel text-danger" href="#" data-id="'+(staff_result.id)+'">'+
                                                    '  <span aria-hidden="true">&times;</span> @lang("lang.cancel")'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
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
                $(".tbl-short-list tbody").html(tr);
                $(".tbl-not-short-list tbody").html(tr_not_list);
                $(".tbl-failed tbody").html(tr_failed);
                $(".tbl-result tbody").html(tr_re);
                $(".tbl-signed-contract tbody").html(tr_ct);
                $(".tbl-signed-contract_cancel tbody").html(tr_ct_cancel);
            }
        });
    }
</script>
