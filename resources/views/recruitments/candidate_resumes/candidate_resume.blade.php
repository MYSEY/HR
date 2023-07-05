@extends('layouts.master_print')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Candidate Resumes</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Candidate Resumes</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" id="add_new" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="content container-fluid">
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab_candidate_resume" aria-selected="true"
                                    role="tab">Candidate Resume</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_short_list" href="#tab_short_list" aria-selected="false" role="tab" data-tab-id="2"
                                    tabindex="-1">Short List</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_not_tab_short_list" href="#tab_not_short_list" aria-selected="false" role="tab" data-tab-id="2"
                                    tabindex="-1">Not Short List</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_interviewed_result" href="#tab_interviewed_result" aria-selected="false" data-tab-id="3"
                                    role="tab" tabindex="-1">Interviewed Result</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_signed_contract" href="#tab_signed_contract" aria-selected="false" data-tab-id="4"
                                    role="tab" tabindex="-1">Signed Contract</a>
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
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('recruitment/candidate-resume/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
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
    </div>
@endsection
{{-- @include('recruitments.candidate_resumes.print_signed_contract') --}}

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{asset('/admin/js/noty.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $("#btn_tab_short_list, #btn_not_tab_short_list").on("click", function(){
            let tab_status = $(this).attr('data-tab-id');
            console.log(tab_status);
            showDatas(tab_status);
        });
        $("#btn_tab_interviewed_result, #btn_tab_signed_contract").on("click", function(){
            let tab_status = $(this).attr('data-tab-id');
            showDatas(tab_status);
        });

        $(document).on('click','.btn_print_signed_contract', function(){
            var _this = $(this).parents('tr');
            $("#candidate_id").val(_this.find('.ids').text());
            $(".employee_name_kh").val(_this.find('.name_kh').text());
            $(".employee_name_en").val(_this.find('.name_en').text());
            $("#position").val(_this.find('.position').text());
            $("#position_id").val($('.position_id').attr("data-postion"));

            $("#gender_name").val(_this.find('.gender_name_english').text());
            $("#gender_id").val($('.gender_id').attr("data-gender"));
            $(".date_of_commencement").val($('.join_date').attr("data-join-date"));
            $("#branch_name").val(_this.find('.branch').text());
            $("#branch_id").val($('.branch_id').attr("data-branch"));
            $(".personal_phone_number").val($('.phone_number').attr("data-phone-number"));
            $("#add_emp").modal("show");
        });
        
        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
        $('.update').on('click', function() {
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
                    console.log(response.success);
                    if (response.success) {
                        if (response.position != '') {
                            $('#e_position_applied').html('');
                            $.each(response.position, function(i, item) {
                                $('#e_position_applied').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.position_applied
                                }));
                            });
                        }
                        if (response.branch != '') {
                            $('#e_location_applied').html('');
                            $.each(response.branch, function(i, item) {
                                $('#e_location_applied').append($('<option>', {
                                    value: item.id,
                                    text: item.branch_name_en,
                                    selected: item.id == response.success.location_applied
                                }));
                            });
                        }
                        if (response.gender != '') {
                            $('#e_gender').html('');
                            $.each(response.gender, function(i, item) {
                                $('#e_gender').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
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
            var candi_status = "";
            if (status == 1) {
                candi_status = "Received CV";
            } else if(status == 2) {
                candi_status = "Shortlisted";
            }else if(status == 3){
                candi_status = "Interviewed";
            }else if(status == 4){
                candi_status = "Signed Contract";
            }
            if (status == 1) {
                $.confirm({
                    title: 'Candidate Resume Status!',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: ''+
                        '<form method="post" class="formName">'+
                            '<div class="form-group">'+
                                '<div class="form-group">'+
                                    '<label><a href="#">'+candi_status+'</a></label>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<p>Do you really want to change Status?</p>'+
                                    '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                                '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Ok',
                            btnClass: 'btn-blue',
                            action: function() {
                                var status = this.$content.find('.status').val();
                                var id = this.$content.find('.id').val();
                                axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                        'id': id,
                                        'status': status,
                                    }).then(function(response) {
                                    if (response.data.message == 'successfull') {
                                        new Noty({
                                            title: "",
                                            text: "The process has been successfully.",
                                            type: "success",
                                            icon: true
                                        }).show();
                                        $('.card-footer').remove();
                                        window.location.replace("{{ URL('recruitment/candidate-resume/list') }}"); 
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
                $.confirm({
                    title: 'Candidate Resume Status!',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: ''+
                        '<form class="needs-validation" novalidate>'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+candi_status+'</a></label>'+
                            '</div>'+
                            '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '<div class="form-group">'+
                                '<label>Short List</label>'+
                                '<select class="form-control form-select showtList" name="short_list">'+
                                    '<option selected value="1"> Yes</option>'+
                                    '<option value="2"> No</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group interviewed_date">'+
                                '<label>Interviewed Date <span class="text-danger">*</span></label>'+
                                '<input type="datetime-local" class="form-control interviewed_dates">'+
                            '</div>'+
                            '<div class="form-group interview_channel">'+
                                '<label>Interviewed Channel</label>'+
                                '<input type="text" class="form-control interviewed_channel">'+
                            '</div>'+
                            '<div class="form-group committee_interviewed">'+
                                '<label>Committee Interview <span class="text-danger">*</span></label>'+
                                '<input type="text" class="form-control committee_interview">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Remark</label>'+
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
                            text: 'Submit',
                            btnClass: 'btn-blue',
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
                                    if ($(".committee_interview").val() ==""){
                                        $(".committee_interview").css("border","solid 1px red");
                                        return false;
                                    }
                                }

                                axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                        'id': id,
                                        'status': c_status,
                                        'short_list': short_list,
                                        'interviewed_date': interviewed_date,
                                        'interviewed_channel': interviewed_channel,
                                        'committee_interview': committee_interview,
                                        'remark': remark,
                                    }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('recruitment/candidate-resume/list') }}");
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
                let data_status = $(this).attr('data-status');
                let select_joined_interview  = ""; 
                if (data_status == 3 ) {
                    select_joined_interview = '<select class="form-control form-select joined_interview" >'+
                        '<option selected value="1"> Yes</option>'+
                    '</select>';
                }else{
                    select_joined_interview = '<select class="form-control form-select joined_interview" >'+
                        '<option selected value="1"> Yes</option>'+
                        '<option value="2"> No</option>'+
                        '<option value="3"> Delay</option>'+
                    '</select>';
                }
                $.confirm({
                    title: 'Candidate Resume Status!',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: ''+
                        '<form class="needs-validation" novalidate>'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+candi_status+'</a></label>'+
                            '</div>'+
                            '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '<div class="form-group">'+
                                '<label>Joined Interview</label>'+
                                select_joined_interview+
                            '</div>'+
                            '<div class="form-group interviewed_date" style="display: none">'+
                                '<label>Interviewed Date <span class="text-danger">*</span></label>'+
                                '<input type="datetime-local" class="form-control interviewed_dates">'+
                            '</div>'+
                            '<div class="form-group interviewed_results">'+
                                '<label>Interviewed Result</label>'+
                                '<select class="form-control form-select interviewed_result" >'+
                                    '<option selected value="1"> Passed</option>'+
                                    '<option value="2"> Failed</option>'+
                                    '<option value="3"> Waiting</option>'+
                                    '<option value="4"> Pending</option>'+
                                    '<option value="5"> High Exected Salary</option>'+
                                    '<option value="6"> Rejected Offered</option>'+
                                    '<option value="7"> Black list</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Remark</label>'+
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
                            text: 'Submit',
                            btnClass: 'btn-blue',
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
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('recruitment/candidate-resume/list') }}");
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
            }else if(status == 4) {
                $.confirm({
                    title: 'Candidate Resume Status!',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: ''+
                        '<form class="needs-validation" novalidate>'+
                            '<div class="form-group">'+
                                '<label><a href="#">'+candi_status+'</a></label>'+
                            '</div>'+
                            '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '<div class="form-group">'+
                                '<label>Contract Date <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control contract_date" value="">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Join Date <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control join_date" value="">'+
                            '</div>'+
                        '</form>',
                    buttons: {
                        confirm: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
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
                                    new Noty({
                                        title: "",
                                        text: "The process has been successfully.",
                                        type: "success",
                                        icon: true
                                    }).show();
                                    $('.card-footer').remove();
                                    window.location.replace("{{ URL('recruitment/candidate-resume/list') }}");
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
            }
        });
    });
    function showDatas(btn_tab){
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
                    var tr = "";
                    var tr_not_list = "";
                    var tr_ct = "";
                    if (btn_tab == 2) {
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
                                text_status = "Received CV";
                                tag_i = '<i class="fa fa-dot-circle-o text-purple"></i>'
                            }else if (staff.status =='2') {
                                text_status = "Shortlisted";
                                tag_i = '<i class="fa fa-dot-circle-o text-warning"></i>'
                            }else if(staff.status =='3') {
                                text_status = "Interviewed";
                                tag_i = '<i class="fa fa-dot-circle-o text-info"></i>'
                            };
                            let cv =  "";
                            if (staff.cv) {
                                cv = '<small class="block text-ellipsis">'+
                                        '<a href="{{asset("/uploads/images")}}/'+(staff.cv)+'" target="_blank" class="subdrop"><i class="la la-file-pdf"></i> <span>Preview CV</span></a>'+
                                    '</small>'
                            }
                            if (staff.short_list == 1) {
                                tr += '<tr class="odd">'+
                                    '<td class="ids">'+(staff.id)+'</td>'+
                                    '<td >'+(staff.name_kh)+' </td>'+
                                    '<td >'+(staff.name_en)+'</td>'+
                                    '<td >'+(staff.option.name_english)+'</td>'+
                                    '<td >'+(staff.position.name_english)+'</td>'+
                                    '<td >'+(staff.branch.branch_name_en)+'</td>'+
                                    '<td >'+(interviewed_date)+'</td>'+
                                    '<td >'+(time)+'</td>'+
                                    '<td >'+(staff.committee_interview ? staff.committee_interview : "")+'</td>'+
                                    '<td >'+
                                        '<div class="dropdown action-label">'+
                                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                (tag_i)+
                                                '<span>'+(text_status)+'</span>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                // '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="2" href="#">'+
                                                //     '<i class="fa fa-dot-circle-o text-warning"></i> Shortlisted'+
                                                // '</a>'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="3" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-info"></i> Interviewed'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td >'+
                                        cv+
                                    '</td>'+
                                    '<td>'+(staff.remark ? staff.remark: "")+'</td>'+
                                '</tr>';
                            }else if (staff.short_list == 2) {
                                tr_not_list += '<tr class="odd">'+
                                    '<td class="ids">'+(staff.id)+'</td>'+
                                    '<td >'+(staff.name_kh)+' </td>'+
                                    '<td >'+(staff.name_en)+'</td>'+
                                    '<td >'+(staff.option.name_english)+'</td>'+
                                    '<td >'+(staff.position.name_english)+'</td>'+
                                    '<td >'+(staff.branch.branch_name_en)+'</td>'+
                                    '<td >'+
                                        '<div class="dropdown action-label">'+
                                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                (tag_i)+
                                                '<span>'+(text_status)+'</span>'+
                                            '</a>'+
                                            '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="2" href="#">'+
                                                    '<i class="fa fa-dot-circle-o text-warning"></i> Shortlisted'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td >'+
                                        cv+
                                    '</td>'+
                                    '<td>'+(staff.remark ? staff.remark: "")+'</td>'+
                                '</tr>';
                            }
                        });
                    }else if (btn_tab == 3) {
                        datas.map((staff_result) => {
                            let text_status = "";
                            let tag_i = "";
                            let interview_result = "";
                            if (staff_result.interviewed_result == 1) {
                                interview_result = "Passed";
                            }else
                            if (staff_result.interviewed_result == "2") {
                                interview_result = "Failed";
                            }else
                            if (staff_result.interviewed_result == "3") {
                                interview_result = "Waiting";
                            }else
                            if (staff_result.interviewed_result == "4") {
                                interview_result = "Pending";
                            }else
                            if (staff_result.interviewed_result == "5") {
                                interview_result = "High Exected Salary";
                            }else
                            if (staff_result.interviewed_result == "6") {
                                interview_result = "Rejected Offered";
                            }else if(staff_result.interviewed_result == "7"){
                                interview_result = "Black list";
                            }else{
                                interview_result = "No";
                            };

                            if(staff_result.status =='3') {
                                text_status = "Interviewed";
                                tag_i = '<i class="fa fa-dot-circle-o text-info"></i>'
                            }else if (staff_result.status =='4') {
                                text_status = "Signed Contract";
                                tag_i = '<i class="fa fa-dot-circle-o text-success"></i>'
                            };
                            let status_show = "";
                            if (staff_result.interviewed_result == 1 || staff_result.interviewed_result == 3 || staff_result.interviewed_result == 4 || staff_result.interviewed_result == 5) {
                                status_show = '<div class="dropdown action-label">'+
                                                '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                                    (tag_i)+
                                                    '<span>'+(text_status)+'</span>'+
                                                '</a>'+
                                                '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                                    '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'"  data-id="3" data-status="'+(staff_result.status)+'" href="#">'+
                                                        '<i class="fa fa-dot-circle-o text-info"></i> Interviewed'+
                                                    '</a>'+
                                                    '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'" data-id="4" href="#">'+
                                                        '<i class="fa fa-dot-circle-o text-success"></i> Signed Contract'+
                                                    '</a>'+
                                                '</div>'+
                                            '</div>';
                            }else{
                                status_show = '<span class="badge bg-inverse-danger">'+interview_result+'</snap>';   
                            }
                            let interviewed_date = staff_result.interviewed_date ? moment(staff_result.interviewed_date).format('MMM-D-YYYY') : "";
                            tr_re += ' <tr class="odd">'+
                                '<td class="ids">'+(staff_result.id)+'</td>'+
                                '<td >'+(staff_result.name_kh )+'</td>'+
                                '<td >'+(staff_result.name_en)+'</td>'+
                                '<td >'+(staff_result.option.name_english)+'</td>'+
                                '<td >'+(staff_result.position.name_english)+'</td>'+
                                '<td >'+(staff_result.branch.branch_name_en)+'</td>'+
                                '<td >'+(interviewed_date)+'</td>'+
                                '<td >'+(interview_result)+'</td>'+
                                '<td >'+
                                    (status_show)+
                                '</td>'+
                                '<td >'+(staff_result.remark ? staff_result.remark: "")+'</td>'+
                            '</tr>';
                        });
                    }else if (btn_tab == 4) {
                        datas.map((staff_result) => {
                            let interview_result = "";
                            if (staff_result.interviewed_result == 1) {
                                interview_result = "Passed";
                            }
                            let join_date = staff_result.join_date ? moment(staff_result.join_date).format('MMM-D-YYYY') : "";
                            let contract_date = staff_result.contract_date ? moment(staff_result.contract_date).format('MMM-D-YYYY') : "";
                            tr_ct += ' <tr class="odd">'+
                                '<td class="ids">'+(staff_result.id)+'</td>'+
                                '<td class="name_kh" >'+(staff_result.name_kh )+'</td>'+
                                '<td class="name_en">'+(staff_result.name_en)+'</td>'+
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
                                            '<a class="dropdown-item btn_print_signed_contract" href="#">'+
                                                '<i class="fa fa-print fa-lg m-r-5"></i> Print'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>';
                        });
                    }
                }else {
                    var tr = '<tr><td colspan=12 align="center">No record to display</td></tr>';
                    var tr_not_list = '<tr><td colspan=9 align="center">No record to display</td></tr>';
                    var tr_re = '<tr><td colspan=10 align="center">No record to display</td></tr>';
                    var tr_ct = '<tr><td colspan=10 align="center">No record to display</td></tr>';
                }
                $(".tbl-short-list tbody").html(tr);
                $(".tbl-not-short-list tbody").html(tr_not_list);
                $(".tbl-result tbody").html(tr_re);
                $(".tbl-signed-contract tbody").html(tr_ct);
            }
        });
    }
</script>
