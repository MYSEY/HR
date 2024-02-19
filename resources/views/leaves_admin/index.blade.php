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
                    <h3 class="page-title">@lang('lang.leaves_admin')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.leaves_admin')</li>
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
                        <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
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
                    <button class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" data-condiction="{{Auth::user()->RolePermission}}" id="icon-search-download-reload">
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
                            <a class="nav-link active tab_leave_none" data-bs-toggle="tab" href="#leave_request" aria-selected="true" role="tab" data-tab-id="1">@lang('lang.leave_requests') ({{count($dataLeaveRequest)}})</a>
                        </li>
                        @if (Auth::user()->RolePermission == "HR")
                            <li class="nav-item" role="presentation">
                                <a class="nav-link tab_leave_none" data-bs-toggle="tab" href="#leave_request_cancel" aria-selected="false" data-tab-id="2" role="tab">@lang('lang.requests_cancel') ({{count($requestCancels)}})</a>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" id="tab_leave_allocations" href="#leave_allocations" aria-selected="false" data-tab-id="3" role="tab" tabindex="-1">@lang('lang.leave_allocation')</a>
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
                                                                    aria-label="Leave Type: activate to sort column ascending">@lang('lang.leave_type')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="No of Days: activate to sort column ascending">@lang('lang.number_of_days')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="No of Days: activate to sort column ascending">@lang('lang.handover_staff')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    aria-label="Reason: activate to sort column ascending">@lang('lang.reason')</th>
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
                                                                        <td class="stuck-scroll-3 employee_name"> {{$request->employee ? $request->employee->employee_name_en : ""}} </td>
                                                                        <td class="stuck-scroll-3">{{$request->leaveType->name}}</td>
                                                                        <td >{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{$request->number_of_day}} Day</td>
                                                                        <td>{{ $request->handover ? $request->handover->employee_name_en : ""}}</td>
                                                                        <td>{{$request->reason}}</td>
                                                                        <td>{{$request->remark}}</td>
                                                                        <td>
                                                                            @if ($request->status == "rejected")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">HR rejecte</span>
                                                                            @elseif($request->status == "cancel")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>
                                                                            @elseif ($request->status == "rejected_lm")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Line manager rejecte</span>
                                                                            @elseif ($request->status == "rejected_hod")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Head department rejecte</span>
                                                                            @elseif ($request->status == "pending")
                                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending line manager approve</span>
                                                                            @elseif ($request->status == "approved_lm")
                                                                                <span class="badge bg-inverse-info" style="font-size: 13px;">Pending head department approve</span>
                                                                            @elseif ($request->status == "approved_hod")
                                                                                <span class="badge bg-inverse-info" style="font-size: 13px;">Pending HR Approve</span>
                                                                            @elseif($request->status == "approved")
                                                                                <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-end">
                                                                            @if (permissionAccess("m10-s1","is_approve")->value == "1" || permissionAccess("m10-s1","is_reject")->value == "1")
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
                                                                                        data-handover="{{ $request->handover ? $request->handover->employee_name_en : ''}}"
                                                                                        data-reason="{{$request->reason}}"
                                                                                    >@if (permissionAccess("m10-s1","is_approve")->value == "1")@lang('lang.approve')@endif @if (permissionAccess("m10-s1","is_reject")->value == "1")/ @lang('lang.reject')@endif</button>
                                                                                @endif
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
                                                        <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave-cancel" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                                                    <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                                    <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="Leave Type: activate to sort column ascending">@lang('lang.leave_type')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="No of Days: activate to sort column ascending">@lang('lang.number_of_days')</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="Handover Staff: activate to sort column ascending">@lang('lang.handover_staff')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                        aria-label="Reason: activate to sort column ascending">@lang('lang.reason')</th>
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
                                                                            <td>{{ $request->handover ? $request->handover->employee_name_en : ""}}</td>
                                                                            <td>{{$request->reason}}</td>
                                                                            <td>{{$request->remark}}</td>
                                                                            <td>
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Heard department cancel</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                @if (permissionAccess("m10-s1","is_cancel")->value == "1")
                                                                                    <button class="btn btn-outline-danger btn-sm btn-cancel" 
                                                                                        data-id="{{$request->id}}"
                                                                                        data-condiction="{{Auth::user()->RolePermission}}"
                                                                                    >@lang('lang.cancel')</button>
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
                                                                    style="text-align: center">@lang('lang.annual_leave')</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2"  aria-sort="ascending" aria-label="Sick: activate to sort column descending"
                                                                    style="text-align: center">@lang('lang.sick_leave')</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2" aria-sort="ascending" aria-label="Profle: activate to sort column descending"
                                                                    style="text-align: center">@lang('lang.special_leave')</th>
                                                                <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="2" aria-sort="ascending"
                                                                    aria-label="actions: activate to sort column descending" style="text-align: center">@lang('lang.actions')</th>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('lang.day_taken')</th>
                                                                <th>@lang('lang.balance')</th>
                                                                <th>@lang('lang.day_taken')</th>
                                                                <th>@lang('lang.balance')</th>
                                                                <th>@lang('lang.day_taken')</th>
                                                                <th>@lang('lang.balance')</th>
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
                                                                            <a class="btn btn-outline-secondary btn-sm" href="{{ url('/leave-request/detail', $leave->employee_id) }}">@lang('lang.view_request')</a>
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
        var condiction_tab = 1;
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/leaves/admin') }}"); 
        });
        $("#tab_leave_allocations").on("click", function () {
            $(".leave-disply-search").css("display","block");
            condiction_tab = $(this).data('tab-id');
        });
        $(".tab_leave_none").on("click", function () {
            $(".leave-disply-search").css("display","none");
            condiction_tab = $(this).data('tab-id');
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            var condistion = $(this).data('condiction');
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');

            axios.post('{{ URL('leaves/admin/filter') }}', {
                'condiction_tab': condiction_tab,
                'employee_name': $("#employee_name").val(),
                'department_id': $("#department_id").val(),
                'branch_id': $("#branch_id").val(),
            }).then(function(response) {
                if (condiction_tab == 3) {
                    var Leave_allocations = response.data.LeaveAllocations;
                    if (Leave_allocations.length > 0) {
                        var tr_allocation = "";
                        var td_allocation = "";
                        $(Leave_allocations).each(function (e, row) {
                            if (condistion == "HR") {
                                td_allocation = '<td>'+(row.employee.department.name_english)+'</td><td>'+(row.employee.branch.branch_name_en)+'</td>';             
                            }
                            tr_allocation += '<tr class="odd">'+
                                '<td>'+(row.employee.employee_name_en)+'</td>'+
                                (td_allocation)+
                                '<td>'+(row.default_annual_leave - row.total_annual_leave)+'</td>'+
                                '<td>'+(row.total_annual_leave)+'</td>'+
                                '<td>'+(row.default_sick_leave - row.total_sick_leave)+'</td>'+
                                '<td>'+(row.total_sick_leave)+'</td>'+
                                '<td>'+(row.default_special_leave -row.total_special_leave)+'</td>'+
                                '<td>'+(row.total_special_leave)+'</td>'+
                                '<td class="text-end">'+
                                    '<a class="btn btn-outline-secondary btn-sm" href="{{url("leave-request/detail")}}/'+(row.employee_id)+'">@lang("lang.view_request")</a>'+
                                '</td>'+
                        '</tr>';
                        });

                    }else{
                        var tr_allocation = '<tr><td colspan=10 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $("#leave_allocations tbody").html(tr_allocation);
                }else{
                    var rows = response.data.success;
                    if (rows.length > 0) {
                        var tr = "";
                        let candistion = "";
                        let status = "";
                        $(rows).each(function(e, row) {
                            let start_date = moment(row.start_date).format('D-MMM-YYYY');
                            let end_date = moment(row.end_date).format('D-MMM-YYYY');
                            if (row.status == "pending" || row.status == "approved_lm" || row.status == "approved_hod") {
                                candistion = '<button class="btn btn-outline-secondary btn-sm btn-approved" data-id="'+(row.id)+'" data-condition="'+(condistion)+'"'+
                                    'data-status="'+(row.status)+'"'+
                                    'data-employeename="'+(row.employee.employee_name_en)+'"'+
                                    'data-startdate="'+(row.start_date)+'"'+
                                    'data-enddate="'+(row.end_date)+'"'+
                                    'data-starthalfday="'+(row.start_half_day)+'"'+
                                    'data-endhalfday="'+(row.end_half_day)+'"'+
                                    'data-reason="'+(row.reason)+'"'+
                                '>@lang("lang.approved") / @lang("lang.reject")</button>';
                            };
                            if (condiction_tab == 2) {
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Heard department cancel</span>';
                                candistion = '<button class="btn btn-outline-danger btn-sm btn-cancel" data-id="'+(row.id)+'" data-condiction="'+(condistion)+'">@lang("lang.cancel")</button>';
                            }
                            if (row.status == "rejected"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">HR rejecte</span>';
                            }else if(row.status == "cancel"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>';
                            }else if (row.status == "rejected_lm"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Line manager rejecte</span>';
                            }else if (row.status == "rejected_hod"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Head department rejecte</span>';
                            }else if (row.status == "pending"){
                                status = '<span class="badge bg-inverse-info" style="font-size: 13px;">Pending line manager approve</span>';
                            }else if (row.status == "approved_lm"){
                                status = '<span class="badge bg-inverse-info" style="font-size: 13px;">Pending head department approve</span>';
                            }else if (row.status == "approved_hod"){
                                status = '<span class="badge bg-inverse-info" style="font-size: 13px;">Pending HR Approve</span>';
                            }else if(row.status == "approved"){
                                status = '<span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>';
                            };
                            tr += '<tr class="odd">'+
                                '<td class="ids">'+(e+1)+'</td>'+
                                '<td>' + (row.employee ? row.employee.employee_name_en : "") + '</td>'+
                                '<td>' + (row.leave_type.name) + '</td>'+
                                '<td>' + (start_date) + '</td>'+
                                '<td>' + (end_date) + '</td>'+
                                '<td>' + (row.number_of_day) + ' Day</td>'+
                                '<td>' + (row.handover ? row.handover.employee_name_en : "") + '</td>'+
                                '<td>' + (row.reason ? row.reason : "") + '</td>'+
                                '<td>' + (row.remark ? row.remark : "" ) + '</td>'+
                                '<td>' + (status) + '</td>'+
                                '<td class="text-end">'+
                                (candistion)+
                                '</td>'+
                            '</tr>';
                        });
                    } else {
                        var tr = '<tr><td colspan=10 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    
                    if (condiction_tab == 1) {
                        $(".tbl-leave-request tbody").html(tr);
                    }else {
                        $(".tbl-leave-cancel tbody").html(tr);
                    }
                }
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
        $(document).on('click','.btn-approved', function(){
            let is_approve = "{{ Helper::permissionAccess('m10-s1','is_approve') }}";
            let is_reject = "{{ Helper::permissionAccess('m10-s1','is_reject') }}";
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
            let handover = $(this).data("handover");
            let reason = $(this).data("reason");
            let description = "@lang('lang.are_you_sure_want_to_approve') or @lang('lang.reject')?";
            let text_label = "";
            let button_ok = "";
            if (is_approve == 1 ) {
                button_ok =   {
                    text: '@lang("lang.approve")',
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
            }
            let btn_reject  = "";
            if (is_reject == 1) {
                btn_reject = {
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
            }
          
            $.confirm({
                icon: 'fa fa-warning',
                title: '@lang("lang.employee_request_leave")',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<div class="form-group">'+
                        '<p>@lang("lang.employee_name"): '+employeename+'</p>'+
                        '<p>@lang("lang.from"): '+startdate+starthalfday+'</p>'+
                        '<p>@lang("lang.to"): '+enddate+endhalfday+'</p>'+
                        '<p>@lang("lang.handover_staff"): '+handover+'</p>'+
                        '<label>@lang("lang.reason"):</label>'+
                        '<textarea disabled class="form-control">'+reason+'</textarea>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label>@lang("lang.remark")</label>'+
                        '<textarea class="form-control remark"></textarea>'+
                    '</div>'+
                '</form>',
                buttons: {
                    button_ok,
                    btn_reject,
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
