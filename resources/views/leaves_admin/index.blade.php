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
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == "HR")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leave"><i class="fa fa-plus"></i> Generate Leave</a>
                    @endif
                    <a href="#" class="btn add-btn me-1" data-bs-toggle="modal" data-bs-target="#request_leave"><i class="fa fa-plus"></i>Request Leave</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Pending Requests</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3" >
                <div class="stats-info">
                    <h6>Approved Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Reject Leave</h6>
                    <h4>0</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Unplanned Leaves</h6>
                    <h4>0</h4>
                </div>
            </div>
        </div>
        
        <div class="row filter-row-btn">
            <div class="col-sm-6 col-md-2">
                <div class="form-group cls-research">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group" id="col-branch">
                    <select class="select form-control" id="leave_type_id" data-select2-id="select2-data-2-c0n3" name="leave_type_id">
                        <option value="" data-select2-id="select2-data-2-c0n3">Leave Type</option>
                        @foreach ($dataLeaveType as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
           
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group" id="col-branch">
                    <select class="select form-control" id="status" data-select2-id="select2-data-2-c0n2" name="status">
                        <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_status')</option>
                        <option value="pending" >@lang('lang.pending')</option>
                        <option value="approved" >@lang('lang.approved')</option>
                        <option value="declined" >@lang('lang.declined')</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="start_date" placeholder="@lang('lang.start_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="end_date" placeholder="@lang('lang.end_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
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
                            <a class="nav-link active" data-bs-toggle="tab" href="#leave_request" aria-selected="false" role="tab" data-tab-id="1">Leave Requests</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#leave_allocations" aria-selected="false" data-tab-id="2" role="tab" tabindex="-1">Leave allocation</a>
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
                                                                <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Leave Type: activate to sort column ascending">Leave Type</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="No of Days: activate to sort column ascending"
                                                                    style="width: 76.925px;">Number of Days</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Reason: activate to sort column ascending"
                                                                    style="width: 117.075px;">Reason</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="2" aria-sort="ascending" aria-label="approve_by: activate to sort column descending" style="text-align: center;">@lang('lang.status')</th>
                                                                <th class="text-end sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                                    aria-label="Actions: activate to sort column ascending"
                                                                    style="width: 54.6125px;">@lang('lang.actions')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($dataLeaveRequest) > 0)
                                                                @foreach ($dataLeaveRequest as $key=>$request)
                                                                    <tr class="odd">
                                                                        <td class="ids stuck-scroll-4">{{++$key ?? ""}}</td>
                                                                        <td class="stuck-scroll-4">
                                                                            {{$request->employee->employee_name_en}}
                                                                        </td>
                                                                        <td class="stuck-scroll-4">{{$request->leaveType->name}}</td>
                                                                        <td>{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{$request->number_of_day}} Day</td>
                                                                        <td>{{$request->reason}}</td>
                                                                        <td>
                                                                            @if (isset($request->StatusApprve["rejected_lsm"]))
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                                                            @elseif (isset($request->StatusApprve["approved_lsm"]))
                                                                                <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                                            @else
                                                                                <span class="badge bg-inverse-info" style="font-size: 13px;">Pending</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-end">
                                                                            {{-- @if (Auth::user()->RolePermission == "BM" || Auth::user()->RolePermission == "HOD" ) --}}
                                                                                {{-- @if ($request->status == "pending") --}}
                                                                                    <button class="btn btn-success btn-sm btn-approved" data-id="{{$request->id}}">@lang('lang.approved')</button>
                                                                                    <button class="btn btn-primary btn-sm btn_cancel"  data-id="{{$request->id}}">@lang('lang.reject')</button>
                                                                                {{-- @endif --}}
                                                                            {{-- @else
                                                                                @if ($request->status == "approved_lm" || $request->status == "pending")
                                                                                    <button type="button" class="btn btn-outline-success btn-sm me-1 mb-1 btn-approved" data-id="{{$request->id}}" {{ $request->status == "pending" ? "disabled":""}} >@lang('lang.approved')</button>
                                                                                    <button type="button" class="btn btn-outline-danger btn-sm me-1 mb-1 btn_cancel" data-id="{{$request->id}}" {{ $request->status == "pending" ? "disabled":""}}>@lang('lang.reject')</button>
                                                                                @endif 
                                                                            @endif --}}
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
                        <div class="tab-pane show" id="leave_allocations" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer staff-transfer-report"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                            <tr>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="2" aria-sort="ascending" aria-label="employee_name: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2"
                                                                    aria-label="Annual: activate to sort column descending"
                                                                    style="text-align: center">Annual Leave</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2"  aria-sort="ascending"
                                                                    aria-label="Sick: activate to sort column descending"
                                                                    style="text-align: center">Sick Leave</th>
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="2" aria-sort="ascending"
                                                                    aria-label="Profle: activate to sort column descending"
                                                                    style="text-align: center">Special Leave</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Day Taken</th>
                                                                <th>Balance (today) </th>
                                                                <th>Day Taken</th>
                                                                <th>Balance (today) </th>
                                                                <th>Day Taken</th>
                                                                <th>Balance (today) </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($LeaveAllocation) > 0)
                                                                @foreach ($LeaveAllocation as $key=>$leave)
                                                                    <tr class="odd">
                                                                        <td>{{$leave->employee->employee_name_en}}</td>
                                                                        <td>{{$leave->default_annual_leave - $leave->total_annual_leave}}</td>
                                                                        <td>{{$leave->total_annual_leave}}</td>
                                                                        <td>{{number_format($leave->default_sick_leave - $leave->total_sick_leave)}}</td>
                                                                        <td>{{number_format($leave->total_sick_leave)}}</td>
                                                                        <td>{{number_format($leave->default_special_leave -$leave->total_special_leave)}}</td>
                                                                        <td>{{number_format($leave->total_special_leave)}}</td>
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
    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Generate Leave</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('leaves/admin/generate')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee <span class="text-danger">*</span></label>
                                    <select class="form-control select floating" name="employee_id">
                                        <option value=""> @lang('lang.select') </option>
                                        @foreach ($employees as $item)
                                            <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">Generate</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="request_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Leave Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('leaves/employee/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Leave Type<span class="text-danger">*</span></label>
                                    <select class="form-control select floating" id="leave_type_id" name="leave_type_id" required>
                                        <option selected value=""> --@lang('lang.select')--</option>
                                        @foreach ($dataLeaveType as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" name="start_date" id="start_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Half Day?</label>
                                    <select class="form-control select floating" name="start_half_day">
                                        <option value=""> @lang('lang.select') </option>
                                        <option value="am">AM</option>
                                        <option value="pm">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" name="end_date" id="end_date"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Half Day?</label>
                                    <select class="form-control select floating" name="end_half_day">
                                        <option value=""> @lang('lang.select') </option>
                                        <option value="am">AM</option>
                                        <option value="pm">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Number of days <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="number_of_day" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Request To <span class="text-danger">*</span></label>
                                    <select class="form-control select floating" name="request_to">
                                        <option value=""> @lang('lang.select') </option>
                                        {{-- @foreach ($teamLeader as $item)
                                            <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label >Leave Reason</label>
                                    <textarea class="form-control" id="reason" name="reason" placeholder="Write down why you want to relax"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">Apply</span>
                            </button>
                        </div>
                    </form>
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
        $(document).on('click','.btn-approved', function(){
            let id = $(this).data("id");
            let description = "@lang('lang.are_you_sure_want_to_approve')?";
            let text_label = "";
            let button_ok = {
                text: '@lang("lang.ok")',
                btnClass: 'add-btn-status',
                action: function () {
                    var id = this.$content.find('.id').val();
                    let handover_staff_id = this.$content.find('.handover_staff_id').val();
                    axios.post('{{ URL('leaves/admin/approve') }}', {
                        'id': id,
                        'handover_staff_id': handover_staff_id,
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
            $.confirm({
                icon: 'fa fa-warning',
                title: '@lang("lang.approved")',
                titleClass: 'text-center',
                type: 'blue',
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>'+(description)+'</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<div class="form-group">'+
                        '<label>Handover Staff <span class="text-danger">*</span></label>'+
                        '<select class="form-control form-select handover_staff_id" id="handover_staff_id">'+
                           
                        '</select>'+
                    '</div>'+
                '</form>',
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
            $(document).ready(function(){
                    axios.get('{{ URL('leave/admin/employee') }}', {
                    }).then(function(response) {
                        if (response.data.employees != '') {
                            $('#handover_staff_id').html('');
                            $("#handover_staff_id").append('<option selected value="">--Select--</option>');
                            $.each(response.data.employees, function(i, item) {
                                $('#handover_staff_id').append($('<option>', {
                                    value: item.id,
                                    text: item.employee_name_en,
                                    // selected: item.id == response.success.location_applied
                                }));
                            });
                        }
                    })
                });
        });
        $(document).on('click','.btn_cancel', function(){
            let id = $(this).data("id");
            $.confirm({
                title: '@lang("lang.reject")',
                icon: 'fa fa-warning',
                titleClass: 'text-center',
                type: 'red',
                typeAnimated: true,
                content: '' +
                '<form action="" class="formName">' +
                    '<div class="form-group" style="text-align: center">' +
                        '<label>@lang("lang.are_you_sure_want_to_reject")?</label>' +
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                    '</div>' +
                    '<label>@lang("lang.remark") <span class="text-danger">*</span></label>'+
                    '<textarea class="form-control remark"></textarea>'+
                '</form>',
                // onOpenBefore: function () {
                //     $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
                // },
                buttons: {
                    formSubmit: {
                        text: '@lang("lang.ok")',
                        btnClass: 'add-btn-status',
                        action: function () {
                            var id = this.$content.find('.id').val();
                            var remark = this.$content.find('.remark').val();
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
    });
</script>
