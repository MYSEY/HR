@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Candidate Resume</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Candidate Resume</li>
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
                                <a class="nav-link" data-bs-toggle="tab" id="btn_tab_interviewed_result" href="#tab_interviewed_result" aria-selected="false" data-tab-id="3"
                                    role="tab" tabindex="-1">Interviewed Result</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <div class="tab-content">
                <div class="tab-pane active show" id="tab_candidate_resume" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name (EN)</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name (KH)</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">Gender</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Current Position at: activate to sort column ascending">Current Position</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Company Name: activate to sort column ascending" >Company Name</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Current Address: activate to sort column ascending" >Current Address</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position Appied: activate to sort column ascending" >Position Appied</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Location Appied: activate to sort column ascending" >Location Appied</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Received Date: activate to sort column ascending" >Received Date</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Recruitment Channel: activate to sort column ascending" >Recruitment Channel</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Concten Number: activate to sort column ascending" >Concten Number</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Recruitement Status: activate to sort column ascending" >Status</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" >Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($data)>0)
                                                        @foreach ($data as $item)
                                                            <tr class="odd">
                                                                <td class="ids">{{$item->id}}</td>
                                                                <td >{{$item->name_kh }}</td>
                                                                <td >{{$item->name_en}}</td>
                                                                <td >{{$item->gender}}</td>
                                                                <td >{{$item->current_position}}</td>
                                                                <td >{{$item->companey_name}}</td>
                                                                <td >{{$item->current_address}}</td>
                                                                <td >{{$item->CandidatePosition}}</td>
                                                                <td >{{$item->CandidateBranch}}</td>
                                                                <td >{{ \Carbon\Carbon::parse($item->received_date)->format('d-M-Y') ?? ''}}</td>
                                                                <td >{{$item->recruitment_channel}}</td>
                                                                <td >{{$item->contact_number}}</td>
                                                                <td >
                                                                    <div class="dropdown action-label">
                                                                        @if ($item->status=='1')
                                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="fa fa-dot-circle-o text-purple"></i>
                                                                                <span>Received CV</span>
                                                                            </a>
                                                                        @elseif ($item->status=='2')
                                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="fa fa-dot-circle-o text-warning"></i>
                                                                                <span>Shortlisted</span>
                                                                            </a>
                                                                        @endif
                                                                        @if (Auth::user()->RolePermission == 'Administrator')
                                                                            <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}"  data-id="1" href="#">
                                                                                    <i class="fa fa-dot-circle-o text-purple"></i> Received CV
                                                                                </a>
                                                                                <a class="dropdown-item" data-emp-id="{{$item->id}}"  data-id="2" href="#">
                                                                                    <i class="fa fa-dot-circle-o text-warning"></i> Shortlisted
                                                                                </a>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>{{ $item->remark }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="14" style="text-align: center">No record to display</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
    
                <div class="tab-pane show" id="tab_short_list" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-short-list"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name (EN)</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name (KH)</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">Gender</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position Appied: activate to sort column ascending" >Position Appied</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Location Appied: activate to sort column ascending" >Location Appied</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Interviewed Date: activate to sort column ascending" >Interviewed Date</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Time: activate to sort column ascending" >Time</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Committee Interview: activate to sort column ascending" >Committee Interview</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" >Status</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="CV's Candidates: activate to sort column ascending" >CV's Candidates</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="tab-pane show" id="tab_interviewed_result" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer tbl-result"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name (EN)</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name (KH)</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">Gender</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position Appied: activate to sort column ascending" >Position Appied</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Location Appied: activate to sort column ascending" >Location Appied</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Interviewed Date: activate to sort column ascending" >Interviewed Date</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Interviewed Result: activate to sort column ascending" >Interviewed Result</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" >Status</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" >Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete training type Modal -->
        <div class="modal custom-modal fade" id="delete_plan" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('recruitment/plan-delete')}}" method="POST">
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
    </div>
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{asset('/admin/js/noty.js')}}"></script>
<script>
    $(function(){
        $("#btn_tab_short_list").on("click", function(){
            let tab_status = $(this).attr('data-tab-id');
            showDatas(tab_status);
        });
        $("#btn_tab_interviewed_result").on("click", function(){
            let tab_status = $(this).attr('data-tab-id');
            showDatas(tab_status);
        });
        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-emp-id');
            let status = $(this).data('id');
            if (status == 1) {
                var candi_status = "Received CV";
            } else if(status == 2) {
                var candi_status = "Shortlisted";
            }else if(status == 3){
                var candi_status = "Interviewed";
            }else if(status == 4){
                var candi_status = "Signed Contract";
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
                                '<select class="form-control form-select joined_interview" >'+
                                    '<option selected value="1"> Yes</option>'+
                                    '<option value="2"> No</option>'+
                                '</select>'+
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
                        '</form>',
                    onOpen: function(){
                            this.$content.find('.joined_interview').change(function(){
                                let value = $('.joined_interview').val();
                                if (value == "2") {
                                    $(".interviewed_results").hide();
                                }else{
                                    $(".interviewed_results").show();
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
                                if (joined_interview == "1") {
                                    if ($(".interviewed_result").val() ==""){
                                        $(".interviewed_result").css("border","solid 1px red");
                                        return false;
                                    }
                                    
                                }

                                axios.post('{{ URL('recruitment/candidate-resume/status') }}', {
                                        'id': id,
                                        'status': status,
                                        'joined_interview': joined_interview,
                                        'interviewed_result': interviewed_result,
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
                            tr += '<tr class="odd">'+
                                '<td class="ids">'+(staff.id)+'</td>'+
                                '<td >'+(staff.name_kh)+' </td>'+
                                '<td >'+(staff.name_en)+'</td>'+
                                '<td >'+(staff.gender)+'</td>'+
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
                                            '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="1" href="#">'+
                                                '<i class="fa fa-dot-circle-o text-purple"></i> Received CV'+
                                            '</a>'+
                                            '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="2" href="#">'+
                                                '<i class="fa fa-dot-circle-o text-warning"></i> Shortlisted'+
                                            '</a>'+
                                            '<a class="dropdown-item" data-emp-id="'+(staff.id)+'"  data-id="3" href="#">'+
                                                '<i class="fa fa-dot-circle-o text-info"></i> Interviewed'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                            '</td>'+
                                '<td ></td>'+
                            '</tr>';
                        });
                    }else if (btn_tab == 3) {
                        datas.map((staff_result) => {
                            let text_status = "";
                            let tag_i = "";
                            let interview_result = "";
                            if (staff_result.interviewed_result == 1) {
                                interview_result = "Passed";
                            }
                            if (staff_result.interviewed_result == "2") {
                                interview_result = "Failed";
                            }
                            if (staff_result.interviewed_result == "3") {
                                interview_result = "Waiting";
                            }
                            if (staff_result.interviewed_result == "4") {
                                interview_result = "Pending";
                            }
                            if (staff_result.interviewed_result == "5") {
                                interview_result = "High Exected Salary";
                            }
                            if (staff_result.interviewed_result == "6") {
                                interview_result = "Rejected Offered";
                            }
                            if (staff_result.interviewed_result == "6") {
                                interview_result = "Black list";
                            };
                            if (staff_result.status =='2') {
                                text_status = "Shortlisted";
                                tag_i = '<i class="fa fa-dot-circle-o text-warning"></i>'
                            }else if(staff_result.status =='3') {
                                text_status = "Interviewed";
                                tag_i = '<i class="fa fa-dot-circle-o text-info"></i>'
                            }else if (staff_result.status =='4') {
                                text_status = "Signed Contract";
                                tag_i = '<i class="fa fa-dot-circle-o text-success"></i>'
                            };
                            let interviewed_date = staff_result.interviewed_date ? moment(staff_result.interviewed_date).format('MMM-D-YYYY') : "";
                            tr_re += ' <tr class="odd">'+
                                '<td class="ids">'+(staff_result.id)+'</td>'+
                                '<td >'+(staff_result.name_kh )+'</td>'+
                                '<td >'+(staff_result.name_en)+'</td>'+
                                '<td >'+(staff_result.gender)+'</td>'+
                                '<td >'+(staff_result.position.name_english)+'</td>'+
                                '<td >'+(staff_result.branch.branch_name_en)+'</td>'+
                                '<td >'+(interviewed_date)+'</td>'+
                                '<td >'+(interview_result)+'</td>'+
                                '<td >'+
                                    '<div class="dropdown action-label">'+
                                        '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">'+
                                            (tag_i)+
                                            '<span>'+(text_status)+'</span>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right" id="btn-status">'+
                                            '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'"  data-id="2" href="#">'+
                                                '<i class="fa fa-dot-circle-o text-warning"></i> Shortlisted'+
                                            '</a>'+
                                            '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'"  data-id="3" href="#">'+
                                                '<i class="fa fa-dot-circle-o text-info"></i> Interviewed'+
                                            '</a>'+
                                            '<a class="dropdown-item" data-emp-id="'+(staff_result.id)+'" data-id="4" href="#">'+
                                                '<i class="fa fa-dot-circle-o text-success"></i> Signed Contract'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                                '<td >'+(staff_result.remark ? staff_result.remark: "")+'</td>'+
                            '</tr>';
                        });
                    }
                }else {
                    var tr = '<tr><td colspan=11 align="center">No record to display</td></tr>';
                    var tr_re = '<tr><td colspan=10 align="center">No record to display</td></tr>';
                }
                $(".tbl-short-list tbody").html(tr);
                $(".tbl-result tbody").html(tr_re);
            }
        });
    }
</script>
