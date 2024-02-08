@extends('layouts.master')
<style>
    .jconfirm-buttons-center{
        float: none !important;
        text-align: center !important;
    }
    .text {
        display: block;
        width: 100px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .vertical-center {
        vertical-align: middle;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves Admin</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves Admin</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row filter-row-btn">
            <div class="col-sm-6 col-md-3">
                <div class="form-group cls-research">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                @if (Auth::user()->RolePermission == "HR")
                    <div class="form-group leave-disply-search" style="display: none">
                        <select class="select form-control" id="department_id" data-select2-id="select2-data-2-c0n3" name="department_id">
                            <option value="" data-select2-id="select2-data-2-c0n3">@lang('lang.department')</option>
                            @foreach ($department as $item)
                                <option value="{{$item->id}}">{{$item->name_english}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                @if (Auth::user()->RolePermission == "HR")
                    <div class="form-group leave-disply-search" style="display: none">
                        <select class="select form-control" id="status" data-select2-id="select2-data-2-c0n2" name="status">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.location')</option>
                            @foreach ($location as $item)
                                <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12">
                <div style="display: flex" class="float-end">
                    <button class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-text-search"><i class="fa fa-search"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                        <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                        <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="page-menu">
            <div class="row">
                <div class="col-md-12 col-ms-12 p-0">
                    <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active tab_leave_none" data-bs-toggle="tab" href="#leave_request" aria-selected="true" role="tab" data-tab-id="1">Leave Requests ({{count($dataLeaveRequest)}})</a>
                        </li>
                        @if (Auth::user()->RolePermission == "HR")
                            <li class="nav-item" role="presentation">
                                <a class="nav-link tab_leave_none" data-bs-toggle="tab" href="#leave_request_cancel" aria-selected="false" role="tab">Requests Cancel ({{count($requestCancels)}})</a>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" id="tab_leave_allocations" href="#leave_allocations" aria-selected="false" data-tab-id="3" role="tab" tabindex="-1">Leave allocation</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="leave_request" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                            <tr>
                                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                                <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="Leave Type: activate to sort column ascending">Leave Type</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="No of Days: activate to sort column ascending">Number of Days</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="Reason: activate to sort column ascending">Reason</th>
                                                                <th ass="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-sort="ascending" aria-label="remark: activate to sort column descending" style="text-align: center;">@lang('lang.remark')</th>     
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-sort="ascending" aria-label="status: activate to sort column descending" style="text-align: center;">@lang('lang.status')</th>
                                                                <th class="text-end sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    aria-label="Actions: activate to sort column ascending">@lang('lang.actions')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($dataLeaveRequest) > 0)
                                                                @foreach ($dataLeaveRequest as $key=>$request)
                                                                    <tr class="odd">
                                                                        <td class="ids stuck-scroll-3">{{++$key ?? ""}}</td>
                                                                        <td class="stuck-scroll-3 employee_name"> {{$request->employee->employee_name_en}} </td>
                                                                        <td class="stuck-scroll-3">{{$request->leaveType->name}}</td>
                                                                        <td >{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{$request->number_of_day}} Day</td>
                                                                        <td>{{$request->reason}}</td>
                                                                        <td>{{$request->remark}}</td>
                                                                        <td>
                                                                            @if ($request->status == "rejected")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">HR rejected</span>
                                                                            @elseif($request->status == "cancel")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>
                                                                            @elseif ($request->status == "rejected_lm")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Line manager rejected</span>
                                                                            @elseif ($request->status == "rejected_hod")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Head department rejected</span>
                                                                            @elseif ($request->status == "pending")
                                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending line manager approved</span>
                                                                            @elseif ($request->status == "approved_lm")
                                                                                <span class="badge bg-inverse-info" style="font-size: 13px;">Pending head department approved</span>
                                                                            @elseif ($request->status == "approved_hod")
                                                                                <span class="badge bg-inverse-info" style="font-size: 13px;">Pending HR Approved</span>
                                                                            @elseif($request->status == "approved")
                                                                                <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-end">
                                                                            @if ($request->status == "pending" || $request->status == "approved_lm" || $request->status == "approved_hod")
                                                                                    <button class="btn btn-outline-secondary btn-sm btn-approved" 
                                                                                        data-id="{{$request->id}}"
                                                                                        data-condition="{{Auth::user()->RolePermission}}"
                                                                                        data-status="{{$request->status}}"
                                                                                        data-employeename="{{$request->employee->employee_name_en}}"
                                                                                        data-startdate="{{$request->start_date}}"
                                                                                        data-enddate="{{$request->end_date}}"
                                                                                        data-starthalfday="{{$request->start_half_day}}"
                                                                                        data-endhalfday="{{$request->end_half_day}}"
                                                                                        data-reason="{{$request->reason}}"
                                                                                    >@lang('lang.approved') / @lang('lang.reject')</button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
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
                        @if (Auth::user()->RolePermission == "HR")
                            <div class="tab-pane show" id="leave_request_cancel" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                                                    <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                                    <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="Leave Type: activate to sort column ascending">Leave Type</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="No of Days: activate to sort column ascending">Number of Days</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="Reason: activate to sort column ascending">Reason</th>
                                                                    <th ass="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                            aria-sort="ascending" aria-label="remark: activate to sort column descending" style="text-align: center;">@lang('lang.remark')</th>     
                                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-sort="ascending" aria-label="status: activate to sort column descending" style="text-align: center;">@lang('lang.status')</th>
                                                                    <th class="text-end sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        aria-label="Actions: activate to sort column ascending">@lang('lang.actions')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (count($requestCancels) > 0)
                                                                    @foreach ($requestCancels as $key=>$request)
                                                                        <tr class="odd">
                                                                            <td class="ids stuck-scroll-3">{{++$key ?? ""}}</td>
                                                                            <td class="stuck-scroll-3 employee_name"> {{$request->employee->employee_name_en}} </td>
                                                                            <td class="stuck-scroll-3">{{$request->leaveType->name}}</td>
                                                                            <td >{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                                            <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                                            <td>{{$request->number_of_day}} Day</td>
                                                                            <td>{{$request->reason}}</td>
                                                                            <td>{{$request->remark}}</td>
                                                                            <td>
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Heard department cancel</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <button class="btn btn-outline-danger btn-sm btn-cancel" 
                                                                                    data-id="{{$request->id}}"
                                                                                    data-condiction="{{Auth::user()->RolePermission}}"
                                                                                >@lang('lang.cancel')</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
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
                        @endif
                        <div class="tab-pane show" id="leave_allocations" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer staff-transfer-report w-100"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                            <tr>
                                                                <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="2" aria-sort="ascending"
                                                                    aria-label="#: activate to sort column descending">@lang('lang.employee_name')</th>
                                                                @if (Auth::user()->RolePermission == "HR")
                                                                    <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        rowspan="2" aria-sort="ascending"
                                                                        aria-label="department: activate to sort column descending">@lang('lang.department')</th>
                                                                    <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        rowspan="2" aria-sort="ascending"
                                                                        aria-label="location: activate to sort column descending">@lang('lang.location')</th>
                                                                @endif
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2" aria-label="Annual: activate to sort column descending"
                                                                    style="text-align: center">Annual Leave</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2"  aria-sort="ascending" aria-label="Sick: activate to sort column descending"
                                                                    style="text-align: center">Sick Leave</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2" aria-sort="ascending" aria-label="Profle: activate to sort column descending"
                                                                    style="text-align: center">Special Leave</th>
                                                                <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="2" aria-sort="ascending"
                                                                    aria-label="actions: activate to sort column descending" style="text-align: center">@lang('lang.actions')</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Day Taken</th>
                                                                <th>Balance</th>
                                                                <th>Day Taken</th>
                                                                <th>Balance</th>
                                                                <th>Day Taken</th>
                                                                <th>Balance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($LeaveAllocation) > 0)
                                                                @foreach ($LeaveAllocation as $key=>$leave)
                                                                    <tr class="odd">
                                                                        <td>{{$leave->employee->employee_name_en}}</td>
                                                                        @if (Auth::user()->RolePermission == "HR")
                                                                            <td>{{$leave->employee->department->name_english}}</td>
                                                                            <td>{{$leave->employee->branch->branch_name_en}}</td>
                                                                        @endif
                                                                        <td>{{$leave->default_annual_leave - $leave->total_annual_leave}}</td>
                                                                        <td>{{$leave->total_annual_leave}}</td>
                                                                        <td>{{number_format($leave->default_sick_leave - $leave->total_sick_leave)}}</td>
                                                                        <td>{{number_format($leave->total_sick_leave)}}</td>
                                                                        <td>{{number_format($leave->default_special_leave -$leave->total_special_leave)}}</td>
                                                                        <td>{{number_format($leave->total_special_leave)}}</td>
                                                                        <td class="text-end">
                                                                            <a class="btn btn-outline-secondary btn-sm" href="{{ url('/leave-request/detail', $leave->employee_id) }}">@lang('lang.view_details')</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/leaves/admin') }}"); 
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('leaves/admin/filter') }}', {
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'leave_type_id': $("#leave_type_id").val(),
                'start_date': $("#start_date").val(),
                'end_date': $("#end_date").val(),
                'status': $("#status").val(),
            }).then(function(response) {
                var rows = response.data.success;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let start_date = moment(row.start_date).format('D-MMM-YYYY')
                        let end_date = moment(row.end_date).format('D-MMM-YYYY')
                        let profile = '<a href="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                        '<img alt="" src="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                    '</a>';
                        if (row.employee.profile != null) {
                            profile ='<a href="{{asset("/uploads/images")}}/'+(row.employee.profile)+'" class="avatar">'+
                                        '<img alt="" src="{{asset("/uploads/images")}}/'+(row.employee.profile)+'">'+
                                    '</a>';
                        };
                        tr += '<tr class="odd">'+
                            '<td class="ids">'+(e+1)+'</td>'+
                            '<td>' + (profile) + '</td>'+
                            '<td>' + (row.employee.employee_name_en) + '</td>'+
                            '<td>' + (row.leave_type.name) + '</td>'+
                            '<td>' + (start_date) + '</td>'+
                            '<td>' + (end_date) + '</td>'+
                            '<td>' + (row.number_of_day) + '</td>'+
                            '<td>' + (row.reason ? row.reason : "") + '</td>'+
                            '<td>' + (row.approved_by ? row.approved_by : "" ) + '</td>'+
                            '<td class="text-end">'+
                                '<a class="btn btn-success btn-sm" href="#">Approved</a>'+
                               ' <a class="btn btn-primary btn-sm" href="#">Reject</a>'+
                            '</td>'+
                        '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=11 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-leave-request tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
        $("#tab_leave_allocations").on("click", function () {
            $(".leave-disply-search").css("display","block");
        });
        $(".tab_leave_none").on("click", function () {
            $(".leave-disply-search").css("display","none");
        });
        $(document).on('click','.btn-approved', function(){
            let id = $(this).data("id");
            let status = $(this).data("status");
            let condition = $(this).data("condition");
            if (condition == "HR" && (status != "approved_hod" || status == "approved_lm")) {
                let text_message = "";
                if (status == "approved_lm") {
                    text_message = "Pending head department approved";
                }else{
                    text_message = "Pending line manager approved";
                }
                new Noty({
                    title: "",
                    text: text_message,
                    type: "error",
                    timeout: 3000,
                    icon: true
                }).show();
                return false;
            }
            let employeename = $(this).data("employeename");
            let startdate  = moment($(this).data("startdate")).format('D-MMM-YYYY');
            let enddate = moment($(this).data("enddate")).format('D-MMM-YYYY');
            let starthalfday = $(this).data("starthalfday") ? '  half day ( '+ $(this).data("starthalfday")+" )" : "";
            let endhalfday = $(this).data("endhalfday") ? '  half day ( '+ $(this).data("endhalfday")+" )" : "";
            let reason = $(this).data("reason");
            let description = "@lang('lang.are_you_sure_want_to_approve') or rejected?";
            let text_label = "";
            let button_ok = {
                text: '@lang("lang.approved")',
                btnClass: 'btn-green btn-sm',
                action: function () {
                    var id = this.$content.find('.id').val();
                    let remark = this.$content.find('.remark').val();
                    axios.post('{{ URL('leaves/admin/approve') }}', {
                        'id': id,
                        'remark': remark,
                        'status': "approved",
                    }).then(function(response) {
                        new Noty({
                            title: "",
                            text: "@lang('lang.the_process_has_been_successfully').",
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                        window.location.replace("{{ URL('/leaves/admin') }}"); 
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
            let danger = {
                text: '@lang("lang.reject")',
                btnClass: 'btn-red btn-sm',
                action: function () {
                    var id = this.$content.find('.id').val();
                    var remark = this.$content.find('.remark').val();
                    if (remark == ""){
                        $(".remark").css("border","solid 1px red");
                        new Noty({
                            title: "",
                            text: "Please enter infomation in the remark.",
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                        return false;
                    }

                    axios.post('{{ URL('leaves/admin/reject') }}', {
                        'id': id,
                        'status': "rejected",
                        'remark': remark,
                    }).then(function(response) {
                        new Noty({
                            title: "",
                            text: "@lang('lang.the_process_has_been_successfully').",
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                        window.location.replace("{{ URL('/leaves/admin') }}"); 
                    }).catch(function(error) {
                        new Noty({
                            title: "",
                            text: "Som@lang('lang.something_went_wrong_please_try_again_later').",
                            type: "error",
                            icon: true
                        }).show();
                    });
                }
            };
            $.confirm({
                icon: 'fa fa-warning',
                title: 'Employee request leave',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<div class="form-group">'+
                        '<p>Empployee Name: '+employeename+'</p>'+
                        '<p>From: '+startdate+starthalfday+'</p>'+
                        '<p>To: '+enddate+endhalfday+'</p>'+
                        '<label>Reason:</label>'+
                        '<textarea disabled class="form-control">'+reason+'</textarea>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label>Remark</label>'+
                        '<textarea class="form-control remark"></textarea>'+
                    '</div>'+
                '</form>',
                buttons: {
                    button_ok,
                    danger,
                    cancel: {
                        text: '@lang("lang.close")',
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
        $(".btn-cancel").on("click", function() {
            let id = $(this).data("id");
            let condiction = $(this).data("condiction");
            let description = "@lang('lang.are_you_sure_want_to_cancel')?";
            let button_cancel = {
                text: '@lang("lang.cancel")',
                btnClass: 'btn-red btn-sm',
                action: function () {
                    var id = this.$content.find('.id').val();
                    let remark = this.$content.find('.remark').val();
                    if (remark == ""){
                        $(".remark").css("border","solid 1px red");
                        new Noty({
                            title: "",
                            text: "Please enter infomation in the remark.",
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                        return false;
                    }
                    axios.post('{{ URL('leaves/admin/cancel') }}', {
                        'id': id,
                        'remark': remark,
                        'status': condiction == "HOD" ? "cancel_hod": "cancel",
                    }).then(function(response) {
                        new Noty({
                            title: "",
                            text: "@lang('lang.the_process_has_been_successfully').",
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                        window.location.replace("{{ URL('/leaves/admin') }}"); 
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
            $.confirm({
                icon: 'fa fa-warning',
                title: 'Cancel request leave',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<div class="form-group">'+
                        '<label>Remark <span class="text-danger">*</span></label>'+
                        '<textarea class="form-control remark"></textarea>'+
                    '</div>'+
                '</form>',
                buttons: {
                    button_cancel,
                    cancel: {
                        text: '@lang("lang.close")',
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
    });
</script>
