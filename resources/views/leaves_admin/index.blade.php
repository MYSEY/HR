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
    .tooltip-inner {
        white-space: pre-line !important;
        text-align: left !important;
        max-width: 300px !important; 
        /* word-wrap: break-word !important; */
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
                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'HR' || Auth::user()->RolePermission == 'HRAdmin' || Auth::user()->RolePermission == 'developer')
                    <div class="col-auto float-end ms-auto">
                        @if (permissionAccess("m4-s2","is_import")->value == "1")
                            <a href="#" class="btn add-btn" data-toggle="modal" id="importPayroll"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="row filter-row-btn">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    @if (in_array(Auth::user()->RolePermission, ['BOD', 'CEO','HR','HRAdmin','admin']))
                        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 leave-disply-search" style="display: none">
                            <div class="form-group">
                                <select class="select form-control" id="department_id" data-select2-id="select2-data-2-c0n3" name="department_id">
                                    <option value="" data-select2-id="select2-data-2-c0n3">@lang('lang.department')</option>
                                    @foreach ($department as $item)
                                        <option value="{{$item->id}}">{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 leave-disply-search" style="display: none">
                            <div class="form-group">
                                <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                    <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.location')</option>
                                    @foreach ($location as $item)
                                        <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 leave-disply-date" style="display: none">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="start_date" placeholder="@lang('lang.start_date')">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 leave-disply-date" style="display: none">
                        <div class="form-group">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text" id="end_date" placeholder="@lang('lang.end_date')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div style="display: flex" class="float-end">
                    <button class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" data-userid="{{Auth::user()->id}}" data-condiction="{{Auth::user()->RolePermission}}" id="icon-search-download-reload">
                        <span class="btn-text-search"><i class="fa fa-search"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    @if (permissionAccess("m10-s1","is_export")->value == "1") 
                        <div style="display: none" class="btn_excel">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    @endif
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
                            <a class="nav-link active tab_leave_none" data-bs-toggle="tab" href="#leave_request" aria-selected="true" role="tab" data-tab-id="1">@lang('lang.leave_requests')
                                <span id="dataShortList" class="badge bg-secondary ms-1 rounded-pill">{{$dataLeaveRequest}}</span> 
                            </a>
                        </li>
                        {{-- @if (Auth::user()->RolePermission == "HR" || Auth::user()->RolePermission == 'HRAdmin') --}}
                            <li class="nav-item" role="presentation">
                                <a class="nav-link tab_leave_none" data-bs-toggle="tab" href="#leave_request_cancel" aria-selected="false" data-tab-id="2" role="tab">@lang('lang.requests_cancel') 
                                    <span id="dataShortList" class="badge bg-secondary ms-1 rounded-pill">{{count($requestCancels)}}</span>
                                </a>
                            </li>
                        {{-- @endif --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" id="tab_leave_allocations" href="#leave_allocations" aria-selected="false" data-tab-id="3" role="tab" tabindex="-1">@lang('lang.leave_allocation')</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" id="tab_leave_report" href="#leave_reports" aria-selected="false" data-tab-id="4" role="tab" tabindex="-1">@lang('lang.staff_leave_report')</a>
                        </li>
                    </ul>
                    @if (Auth::user()->RolePermission == 'HRAdmin')
                    {{-- @if (permissionAccess("m4-s1","is_delete")->value == "1") --}}
                        {{-- <button type="button" class="btn btn-sm btn-danger reject_all mt-3">@lang('lang.reject')</button> --}}
                    {{-- @endif --}}
                    
                        @if (permissionAccess("m10-s1","is_approve")->value == "1")
                            <button type="button" class="btn btn-sm btn-success btn_approved_all mt-3" href="#" data-id=""> @lang('lang.approve')</button>
                            <button style="display: none" type="button" class="btn btn-sm btn-success btn_approved_cancel_all mt-3" href="#" data-id=""> @lang('lang.approve')</button>
                        @endif
                    @endif
                    <div class="tab-content">
                        <div class="tab-pane active show" id="leave_request" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped custom-table mb-0 no-footer tbl-leave-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                            <tr>
                                                                @if (in_array(Auth::user()->RolePermission, ['HRAdmin','admin']))
                                                                    <th class="stuck-scroll-3"><input type="checkbox" id="checkAll"></th>
                                                                @endif
                                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                                                <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="handover staff: activate to sort column ascending">@lang('lang.handover_staff')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="delegated: activate to sort column ascending">@lang('lang.delegated')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Leave Type: activate to sort column ascending">@lang('lang.leave_type')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Reason: activate to sort column ascending">@lang('lang.reason')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="No of Days: activate to sort column ascending">@lang('lang.number_of_days')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="To: activate to sort column ascending">@lang('lang.request_date')</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="request by: activate to sort column ascending">@lang('lang.request_by')</th>
                                                                <th ass="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="remark: activate to sort column descending" style="text-align: center;">@lang('lang.remark')</th>  
                                                                {{-- @if (Auth::user()->RolePermission == 'HRAdmin') --}}
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="approver: activate to sort column ascending">@lang('lang.approver')</th>
                                                                {{-- @endif --}}   
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="status: activate to sort column descending" style="text-align: center;">@lang('lang.status')</th>
                                                                <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Actions: activate to sort column ascending">@lang('lang.actions')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {{-- @if (count($dataLeaveRequest) > 0)
                                                                @foreach ($dataLeaveRequest as $key=>$request)
                                                                    <tr class="odd">
                                                                        @if (in_array(Auth::user()->RolePermission, ['HRAdmin','admin']))
                                                                            <td class="stuck-scroll-3">
                                                                                <input type="checkbox" class="sub_chk" data-id="{{$request->id}}" data-status="{{$request->status}}"
                                                                                @if($request->status == 'pending' && $request->next_approver != Auth::user()->id) disabled @endif>
                                                                            </td>
                                                                        @endif
                                                                        <td class="ids">{{++$key ?? ""}}</td>
                                                                        <td class="stuck-scroll-3 employee_name"> {{$request->employee ? $request->employee->employee_name_en : ""}} </td>
                                                                        <td>{{ $request->handover ? $request->handover->employee_name_en : ""}}</td>

                                                                        <td>{{$request->Delegated}}</td>
                                                                        
                                                                        <td class="">{{$request->leaveType->name}}</td>
                                                                        <td data-toggle="tooltip" data-html="true" title="{!! $request->reason !!}">
                                                                            {{ Str::limit($request->reason, 30, '...') }}
                                                                        </td>
                                                                        <td>{{$request->number_of_day}} Day</td>
                                                                        <td >{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                                        <td>{{$request->created_at ? \Carbon\Carbon::parse($request->created_at)->format('d-M-Y h:i') : ''}}</td>
                                                                        <td> {{$request->createdBy->employee_name_en}} </td>
                                                                        <td data-toggle="tooltip" data-html="true" title="{!! $request->remark !!}">
                                                                             {{ Str::limit($request->remark, 30, '...') }}
                                                                        </td>
                                                                        <td>{{ $request->Approve ? $request->Approve : ""}}</td>
                                                                        <td>
                                                                            @if ($request->status == "rejected")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by HR</span>
                                                                            @elseif($request->status == "cancel")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>
                                                                            @elseif ($request->status == "rejected_lm")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by Line Manager</span>
                                                                            @elseif ($request->status == "rejected_hod")
                                                                                <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by ACEO/Head/BM</span>
                                                                            @elseif ($request->status == "approved_lm" || $request->status == "pending")
                                                                                <span class="badge bg-inverse-info" style="font-size: 13px;">Waiting Approve by CEO/Head/BM</span>
                                                                            @elseif ($request->status == "approved_hod")
                                                                                <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                                            @elseif($request->status == "approved")
                                                                                <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-end">
                                                                            @if (permissionAccess("m10-s1","is_approve")->value == "1" || permissionAccess("m10-s1","is_reject")->value == "1")
                                                                                @if ($request->status == "pending" || $request->status == "approved_lm" || $request->status == "approved_hod")
                                                                                    <button class="btn btn-outline-secondary btn-sm btn-approved" 
                                                                                        data-id="{{$request->id}}"
                                                                                        data-linemanager="{{$request->employee->line_manager}}"
                                                                                        data-approveby="{{$request->next_approver}}"
                                                                                        data-status="{{$request->status}}"
                                                                                        data-employeename="{{$request->employee->employee_name_en}}"
                                                                                        data-startdate="{{$request->start_date}}"
                                                                                        data-enddate="{{$request->end_date}}"
                                                                                        data-starthalfday="{{$request->start_half_day}}"
                                                                                        data-endhalfday="{{$request->end_half_day}}"
                                                                                        data-handover="{{ $request->handover ? $request->handover->employee_name_en : ''}}"
                                                                                        data-reason="{{$request->reason}}"
                                                                                        data-leavetype="{{$request->leaveType->type}}"
                                                                                        data-leaveallocation="{{$request->LeaveAllocation}}"
                                                                                    >@if (permissionAccess("m10-s1","is_approve")->value == "1")@lang('lang.approve')@endif @if (permissionAccess("m10-s1","is_reject")->value == "1")/ @lang('lang.reject')@endif</button>
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @if (Auth::user()->RolePermission == "HR" || Auth::user()->RolePermission == 'HRAdmin') --}}
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
                                                                    @if (Auth::user()->RolePermission == 'HRAdmin')
                                                                        <th class="stuck-scroll-3"><input type="checkbox" id="checkAllCancel"></th>
                                                                    @endif
                                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                                                    <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="handover staff: activate to sort column ascending">@lang('lang.handover_staff')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="delegated: activate to sort column ascending">@lang('lang.delegated')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Leave Type: activate to sort column ascending">@lang('lang.leave_type')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Reason: activate to sort column ascending">@lang('lang.reason')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="No of Days: activate to sort column ascending">@lang('lang.number_of_days')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="request by: activate to sort column ascending">@lang('lang.request_by')</th>
                                                                    <th ass="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="remark: activate to sort column descending" style="text-align: center;">@lang('lang.remark')</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="approver: activate to sort column ascending">@lang('lang.approver')</th>
                                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="status: activate to sort column descending" style="text-align: center;">@lang('lang.status')</th>
                                                                    <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Actions: activate to sort column ascending">@lang('lang.actions')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (count($requestCancels) > 0)
                                                                    @foreach ($requestCancels as $key=>$request)
                                                                        <tr class="odd">
                                                                            @if (Auth::user()->RolePermission == 'HRAdmin')
                                                                                <td class="stuck-scroll-3">
                                                                                    <input type="checkbox" class="sub_chk_cancel" data-id="{{$request->id}}" data-status="{{$request->status}}"
                                                                                    @if($request->status != 'cancel_hod') disabled @endif>
                                                                                </td>
                                                                            @endif
                                                                            <td class="ids">{{++$key ?? ""}}</td>
                                                                            <td class="stuck-scroll-3 employee_name"> {{$request->employee ? $request->employee->employee_name_en : ""}} </td>
                                                                            <td>{{ $request->handover ? $request->handover->employee_name_en : ""}}</td>

                                                                            <td>{{$request->Delegated}}</td>
                                                                            
                                                                            <td class="">{{$request->leaveType->name}}</td>
                                                                            <td>{{$request->reason}}</td>
                                                                            <td>{{$request->number_of_day}} Day</td>
                                                                            <td >{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                                            <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                                            <td> {{$request->createdBy->employee_name_en}} </td>
                                                                            <td>{{$request->remark}}</td>
                                                                            {{-- @if (Auth::user()->RolePermission == "HR" || Auth::user()->RolePermission == 'HRAdmin') --}}
                                                                            <td>{{ $request->Approve ? $request->Approve : ""}}</td>
                                                                            <td>
                                                                                @if($request->status == "pending_cancel")
                                                                                    <span class="badge bg-inverse-danger" style="font-size: 13px;">Waiting Approve by CEO/Head/BM</span>
                                                                                @elseif($request->status == "cancel_hod" || $request->status == "cancel")
                                                                                    <span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-end">
                                                                                @if($request->next_approver == Auth::user()->id)
                                                                                    @if (permissionAccess("m10-s1","is_cancel")->value == "1")
                                                                                        <button class="btn btn-outline-danger btn-sm btn-cancel" 
                                                                                            data-id="{{$request->id}}"
                                                                                            data-condiction="{{Auth::user()->RolePermission}}"
                                                                                        >@lang('lang.approve') @lang('lang.cancel')</button>
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
                        {{-- @endif --}}
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
                                                                <th class="sorting sorting_asc vertical-center stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" aria-sort="ascending" aria-label="#: activate to sort column descending">@lang('lang.employee_id')</th>
                                                                <th class="sorting sorting_asc vertical-center stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" aria-sort="ascending" aria-label="#: activate to sort column descending">@lang('lang.employee_name')</th>
                                                                @if (Auth::user()->RolePermission == "HR" || Auth::user()->RolePermission == 'HRAdmin')
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
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="3" aria-sort="ascending" aria-label="Profle: activate to sort column descending"
                                                                    style="text-align: center">@lang('lang.carried_forward_leave')</th>
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
                                                                <th>@lang('lang.year_1')</th>
                                                                <th>@lang('lang.year_2')</th>
                                                                <th>@lang('lang.year_3')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($LeaveAllocation) > 0)
                                                                @foreach ($LeaveAllocation as $key=>$leave)
                                                                    <tr class="odd">
                                                                        <td class="stuck-scroll-3">{{$leave->employee->number_employee ?? ""}}</td>
                                                                        <td class="stuck-scroll-3">{{$leave->employee->employee_name_en ?? ""}}</td>
                                                                        @if (Auth::user()->RolePermission == "HR" || Auth::user()->RolePermission == 'HRAdmin')
                                                                            <td>{{$leave->employee->department->name_english}}</td>
                                                                            <td>{{$leave->employee->branch->branch_name_en}}</td>
                                                                        @endif
                                                                        <td>{{$leave->default_annual_leave - $leave->total_annual_leave}}</td>
                                                                        <td>{{$leave->total_annual_leave}}</td>
                                                                        <td>{{$leave->default_sick_leave - $leave->total_sick_leave}}</td>
                                                                        <td>{{$leave->total_sick_leave}}</td>
                                                                        <td>{{$leave->default_special_leave -$leave->total_special_leave}}</td>
                                                                        <td>{{$leave->total_special_leave}}</td>
                                                                        <td>{{$leave->year_1}}</td>
                                                                        <td>{{$leave->year_2}}</td>
                                                                        <td>{{$leave->year_3}}</td>
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
                        <div class="tab-pane show" id="leave_reports" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped custom-table mb-0 w-100"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                            <tr>
                                                                <th class="sorting sorting_asc vertical-center stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" aria-sort="ascending" aria-label="#: activate to sort column descending">@lang('lang.employee_id')</th>
                                                                <th class="sorting sorting_asc vertical-center stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" aria-sort="ascending" aria-label="#: activate to sort column descending">@lang('lang.employee_name')</th>
                                                                @if (Auth::user()->RolePermission == "HR" || Auth::user()->RolePermission == 'HRAdmin')
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
                                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    colspan="3" aria-sort="ascending" aria-label="Profle: activate to sort column descending"
                                                                    style="text-align: center">@lang('lang.carried_forward_leave')</th>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('lang.day_taken')</th>
                                                                <th>@lang('lang.balance')</th>
                                                                <th>@lang('lang.day_taken')</th>
                                                                <th>@lang('lang.balance')</th>
                                                                <th>@lang('lang.day_taken')</th>
                                                                <th>@lang('lang.balance')</th>
                                                                <th>@lang('lang.year_1')</th>
                                                                <th>@lang('lang.year_2')</th>
                                                                <th>@lang('lang.year_3')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($sumByEmployee) > 0)
                                                                @foreach ($sumByEmployee as $key=>$leave)
                                                                    <tr class="odd">
                                                                        <td class="stuck-scroll-3">{{$leave->employee->number_employee ?? ""}}</td>
                                                                        <td class="stuck-scroll-3">{{$leave->employee->employee_name_en ?? ""}}</td>
                                                                        @if (Auth::user()->RolePermission == "HR" || Auth::user()->RolePermission == 'HRAdmin')
                                                                            <td>{{$leave->employee->department->name_english}}</td>
                                                                            <td>{{$leave->employee->branch->branch_name_en}}</td>
                                                                        @endif
                                                                        <td>{{$leave->total_number_al}}</td>
                                                                        <td>{{$leave->LeaveAllocation->total_annual_leave}}</td>
                                                                        <td>{{$leave->total_number_sl}}</td>
                                                                        <td>{{$leave->LeaveAllocation->total_sick_leave}}</td>
                                                                        <td>{{$leave->total_number_sp}}</td>
                                                                        <td>{{$leave->LeaveAllocation->total_special_leave}}</td>
                                                                        <td>{{$leave->LeaveAllocation->year_1}}</td>
                                                                        <td>{{$leave->LeaveAllocation->year_2}}</td>
                                                                        <td>{{$leave->LeaveAllocation->year_3}}</td>
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
    @include('leaves_admin.import_leaves')
    <input type="hidden" id="leaveAuth" value="{{Auth::user()}}">

    <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading Data...</p>
        </div>
    </div>
@endsection
@include('includs.script')
@section('script')
<script>
    $(function() {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip({ 
                html: true,
                container: 'tr' 
            });
        });
        datashowTables();
        $("#importPayroll").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#importLeaves').modal('show');
        });
        var condiction_tab = 1;
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/leaves/admin') }}"); 
        });
        $("#tab_leave_allocations").on("click", function () {
            $(".leave-disply-search").css("display","block");
            $(".btn_approved_all").css("display","none");
            $(".leave-disply-date").css("display","none");
            $(".btn_excel").css("display","block");
            condiction_tab = $(this).data('tab-id');
        });
        $("#tab_leave_report").on("click", function () {
            $(".leave-disply-search").css("display","block");
            $(".leave-disply-date").css("display","block");
            $(".btn_approved_all").css("display","none");
            $(".btn_excel").css("display","block");
            condiction_tab = $(this).data('tab-id');
        });
        $(".tab_leave_none").on("click", function () {
            $(".btn_excel").css("display","none");
            $(".leave-disply-search").css("display","none");
            $(".leave-disply-date").css("display","none");
            condiction_tab = $(this).data('tab-id');
            if (condiction_tab == 1) {
                $(".btn_approved_all").css("display","block");
            }else{
                $(".btn_approved_all").css("display","none");
            }
            if ($(this).data('tab-id') == 2) {
                $(".btn_approved_cancel_all").css("display","block");
            }else{
                $(".btn_approved_cancel_all").css("display","none");
            }
        });

        $(".btn_excel").on("click", function () {
            if(condiction_tab == 4){
                var query = {
                    'employee_name': $("#employee_name").val(),
                    'status': null,
                    'condiction_tab': condiction_tab,
                    'department_id': $("#department_id").val(),
                    'branch_id': $("#branch_id").val(),
                    'start_date': $("#start_date").val(),
                    'end_date': $("#end_date").val(),
                }
            }else{
                var query = {
                    'employee_name': $("#employee_name").val(),
                    'status': null,
                    "condiction_tab":null,
                    'department_id': $("#department_id").val(),
                    'branch_id': $("#branch_id").val(),
                    'start_date': null,
                    'end_date': null,
                }
            }
            
            var url = "{{URL::to('leaves/admin/export-allocation')}}?" + $.param(query)
            window.location = url;
        });

        $('#checkAll').on('click', function(e) {
            if($(this).is(':checked',true)){
                $(".sub_chk").each(function() {
                    if ($(this).data('status') == "approved_hod") {
                        $(this).prop('checked', true);
                    }
                });
            } else {  
                $(".sub_chk").prop('checked',false);
            }  
        });
       
        $('body').on('click','.btn_approved_all',function(){
            var allVals = [];  
            $(".sub_chk:checked").each(function() {
                if ($(this).data('status') == "approved_hod") {
                    allVals.push($(this).attr('data-id'));
                }
            });
            // var ids = allVals.join(",");
            if(allVals.length <=0)  
            {
                new Noty({
                    title: "",
                    text: '@lang("lang.please_select_item_befor_approve")',
                    timeout: 3000,
                    type: "error",
                    icon: true
                }).show();
            }  else {
                $(".loading-icon").css('display', 'block')
                $.confirm({
                    title: '@lang("lang.approve")',
                    content: ""+
                                "<p>There are "+allVals.length+" approachable leave.</p>"+
                                "<label>@lang('lang.are_you_sure_want_to_approve')?</label>",
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'ok',
                            btnClass: 'btn-blue',
                            action: function(){
                            axios.post('{{ URL('leaves/admin/approveds') }}',{
                                'ids': allVals,
                            }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.the_process_has_been_successfully")',
                                    type: "success",
                                    icon: true
                                }).show();
                                window.location.replace("{{ URL('leaves/admin') }}");
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
                            close: function () {
                        }
                    }
                });
            }
        });
        $('#checkAllCancel').on('click', function(e) {
            if($(this).is(':checked',true)){
                $(".sub_chk_cancel").each(function() {
                    if ($(this).data('status') == "cancel_hod") {
                        $(this).prop('checked', true);
                    }
                });
            } else {  
                $(".sub_chk_cancel").prop('checked',false);
            }  
        });
        $('body').on('click','.btn_approved_cancel_all',function(){
            var allValCancels = [];  
            $(".sub_chk_cancel:checked").each(function() {
                if ($(this).data('status') == "cancel_hod") {
                    allValCancels.push($(this).attr('data-id'));
                }
            });
            // var ids = allValCancels.join(",");
            if(allValCancels.length <=0)  
            {
                new Noty({
                    title: "",
                    text: '@lang("lang.please_select_item_befor_approve")',
                    timeout: 3000,
                    type: "error",
                    icon: true
                }).show();
            }  else {
                $(".loading-icon").css('display', 'block')
                $.confirm({
                    title: '@lang("lang.approve")',
                    content: ""+
                                "<p>There are "+allValCancels.length+" approachable leave.</p>"+
                                "<label>@lang('lang.are_you_sure_want_to_approve')?</label>",
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'ok',
                            btnClass: 'btn-blue',
                            action: function(){
                            axios.post('{{ URL('leaves/admin/cancel/all') }}',{
                                'ids': allValCancels,
                            }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.the_process_has_been_successfully")',
                                    type: "success",
                                    icon: true
                                }).show();
                                window.location.replace("{{ URL('leaves/admin') }}");
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
                            close: function () {
                        }
                    }
                });
            }
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            var condistion = $(this).data("condiction"); 
            var userId = $(this).data("userid");
            let is_approve = "{{ Helper::permissionAccess('m10-s1','is_approve') }}";
            let is_reject = "{{ Helper::permissionAccess('m10-s1','is_reject') }}";

            axios.post('{{ URL('leaves/admin/filter') }}', {
                'condiction_tab': condiction_tab,
                'employee_name': $("#employee_name").val(),
                'department_id': $("#department_id").val(),
                'branch_id': $("#branch_id").val(),
                'start_date': $("#start_date").val(),
                'end_date': $("#end_date").val(),
            }).then(function(response) {
                if (condiction_tab == 3) {
                    var Leave_allocations = response.data.LeaveAllocations;
                    if (Leave_allocations.length > 0) {
                        var tr_allocation = "";
                        var td_allocation = "";
                    
                        $(Leave_allocations).each(function (e, row) {
                            if (condistion == "HRAdmin" || condistion == "HR" ) {
                                td_allocation = '<td>'+(row.employee.department.name_english)+'</td><td>'+(row.employee.branch.branch_name_en)+'</td>';             
                            }
                            tr_allocation += '<tr class="odd">'+
                                '<td class="stuck-scroll-3">'+(row.employee.number_employee)+'</td>'+
                                '<td class="stuck-scroll-3">'+(row.employee.employee_name_en)+'</td>'+
                                (td_allocation)+
                                '<td>'+(row.default_annual_leave - row.total_annual_leave)+'</td>'+
                                '<td>'+(row.total_annual_leave)+'</td>'+
                                '<td>'+(row.default_sick_leave - row.total_sick_leave)+'</td>'+
                                '<td>'+(row.total_sick_leave)+'</td>'+
                                '<td>'+(row.default_special_leave -row.total_special_leave)+'</td>'+
                                '<td>'+(row.total_special_leave)+'</td>'+
                                '<td>'+(row.year_1)+'</td>'+
                                '<td>'+(row.year_2)+'</td>'+
                                '<td>'+(row.year_3)+'</td>'+
                                '<td class="text-end">'+
                                    '<a class="btn btn-outline-secondary btn-sm" href="{{url("leave-request/detail")}}/'+(row.employee_id)+'">@lang("lang.view_request")</a>'+
                                '</td>'+
                        '</tr>';
                        });

                    }else{
                        var tr_allocation = '<tr><td colspan=14 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $("#leave_allocations tbody").html(tr_allocation);
                }else if(condiction_tab == 4){
                    var Leave_reports = response.data.success;
                    if (Leave_reports.length > 0) {
                        var tr_leave_report = "";
                        var td_allocation = "";
                    
                        $(Leave_reports).each(function (e, row) {
                            if (condistion == "HRAdmin" || condistion == "HR" ) {
                                td_allocation = '<td>'+(row.employee.department.name_english)+'</td><td>'+(row.employee.branch.branch_name_en)+'</td>';             
                            }
                            tr_leave_report += '<tr class="odd">'+
                                '<td class="stuck-scroll-3">'+(row.employee.number_employee)+'</td>'+
                                '<td class="stuck-scroll-3">'+(row.employee.employee_name_en)+'</td>'+
                                (td_allocation)+
                                '<td>'+(row.total_number_al)+'</td>'+
                                '<td>'+(row.leave_allocation.total_annual_leave)+'</td>'+
                                '<td>'+(row.total_number_sl)+'</td>'+
                                '<td>'+(row.leave_allocation.total_sick_leave)+'</td>'+
                                '<td>'+(row.total_number_sp)+'</td>'+
                                '<td>'+(row.leave_allocation.total_special_leave)+'</td>'+
                                '<td>'+(row.leave_allocation.year_1)+'</td>'+
                                '<td>'+(row.leave_allocation.year_2)+'</td>'+
                                '<td>'+(row.leave_allocation.year_3)+'</td>'+
                        '</tr>';
                        });

                    }else{
                        var tr_leave_report = '<tr><td colspan=13 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                    $("#leave_reports tbody").html(tr_leave_report);
                }
                else{
                    var rows = response.data.success;
                    if (rows.length > 0) {
                       
                        var tr = "";
                        let candistion = "";
                        let status = "";
                        let ckeckbox = "";
                        $(rows).each(function(e, row) {
                            let start_date = moment(row.start_date).format('D-MMM-YYYY');
                            let end_date = moment(row.end_date).format('D-MMM-YYYY');
                            let created_at = row.created_at ? moment(row.created_at).format('D-MMM-YYYY HH:mm') : "";
                            if (is_approve == 1 || is_reject == 1) {
                                if (row.status == "pending" || row.status == "approved_lm" || row.status == "approved_hod") {
                                    candistion = '<button class="btn btn-outline-secondary btn-sm btn-approved" data-id="'+(row.id)+'"'+  
                                        'data-linemanager="'+(row.employee.line_manager)+'"'+
                                        'data-status="'+(row.status)+'"'+
                                        'data-approveby="'+(row.next_approver)+'"'+
                                        'data-employeename="'+(row.employee.employee_name_en)+'"'+
                                        'data-startdate="'+(row.start_date)+'"'+
                                        'data-enddate="'+(row.end_date)+'"'+
                                        'data-starthalfday="'+(row.start_half_day)+'"'+
                                        'data-endhalfday="'+(row.end_half_day)+'"'+
                                        'data-reason="'+(row.reason)+'"'+
                                    '>@lang("lang.approve") / @lang("lang.reject")</button>';
                                };
                            }
                            if (condiction_tab == 2) {
                                if (is_approve == 1 || is_reject == 1) {
                                    if(row.next_approver == userId){
                                        candistion = '<button class="btn btn-outline-danger btn-sm btn-cancel" data-id="'+(row.id)+'">@lang("lang.approve") @lang("lang.cancel")</button>';
                                    }else{
                                        candistion = "";
                                    }
                                }else{
                                    candistion = "";
                                }
                                
                                if (row.status == "cancel_hod") {
                                    status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>'; 
                                }
                                if (row.status == "pending_cancel") {
                                    status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Waiting Approve by CEO/Head/BM</span>'; 
                                }
                               
                            }
                            if (row.status == "rejected"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by HR</span>';
                            }else if(row.status == "cancel"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>';
                            }else if (row.status == "rejected_lm"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by Line Manager</span>';
                            }else if (row.status == "rejected_hod"){
                                status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by ACEO/Head/BM</span>';
                            // }else if (row.status == "pending"){
                            //     status = '<span class="badge bg-inverse-info" style="font-size: 13px;">Waiting Approve by Line Manager</span>';
                            }else if (row.status == "approved_lm" || row.status == "pending"){
                                status = '<span class="badge bg-inverse-info" style="font-size: 13px;">Waiting Approve by CEO/Head/BM</span>';
                            }else if (row.status == "approved_hod"){
                                status = '<span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>';
                                // status = '<span class="badge bg-inverse-info" style="font-size: 13px;">Waiting Verify by HR</span>';
                            }else if(row.status == "approved"){
                                status = '<span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>';
                            };
                            if (condistion == "HRAdmin" || condistion == "admin") {
                                ckeckbox = '<td class="stuck-scroll-3">'+
                                    '<input type="checkbox" class="sub_chk" data-id="'+(row.id)+'" data-status="'+(row.status)+'">'+
                                '</td>';
                            }
                            tr += '<tr class="odd">'+
                                (ckeckbox)+
                                '<td class="ids">'+(e+1)+'</td>'+
                                '<td class="stuck-scroll-3">' + (row.employee ? row.employee.employee_name_en : "") + '</td>'+
                                '<td>' + (row.handover ? row.handover.employee_name_en : "") + '</td>'+
                                '<td>' +(row.delegated_employee)+'</td>'+
                                '<td>' + (row.leave_type.name) + '</td>'+
                                '<td>' + (row.reason ? row.reason : "") + '</td>'+
                                '<td>' + (row.number_of_day) + ' Day</td>'+
                                '<td>' + (start_date) + '</td>'+
                                '<td>' + (end_date) + '</td>'+
                                '<td>' + (created_at) + '</td>'+
                                '<td>' +(row.created_by.employee_name_en)+ '</td>'+
                                '<td>' + (row.remark ? row.remark : "" ) + '</td>'+
                                '<td>' +(row.approve ? row.approve.employee_name_en : "") +'</td>'+
                                '<td>' + (status) + '</td>'+
                                '<td class="text-end">'+
                                (candistion)+
                                '</td>'+
                            '</tr>';
                        });
                    } else {
                        var tr = '<tr><td colspan=15 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
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
        let approve_by = "";
        $(document).on('click','.btn-approved', function(){
            let is_approve = "{{ Helper::permissionAccess('m10-s1','is_approve') }}";
            let is_reject = "{{ Helper::permissionAccess('m10-s1','is_reject') }}";
            let id = $(this).data("id");
            let status = $(this).data("status");
            let condition = @json(Auth::user());
            let linemanager = $(this).data("linemanager");
            approve_by = $(this).data("approveby");
            if (condition.role.role_type == "HRAdmin") {
                if (approve_by !="Null" || !approve_by) {
                    if (condition.id != approve_by) {
                        let text_message = "Pending manager head department or BM approve";
                        new Noty({
                            title: "",
                            text: text_message,
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                        return false;
                    }
                }
            }else{
                if (condition.id != approve_by) {
                    let text_message = "Pending manager head department or BM approve";
                    new Noty({
                        title: "",
                        text: text_message,
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                    return false;
                }
            }

            
            let employeename = $(this).data("employeename");
            let startdate  = moment($(this).data("startdate")).format('D-MMM-YYYY');
            let enddate = moment($(this).data("enddate")).format('D-MMM-YYYY');
            let starthalfday = $(this).data("starthalfday") ? '  half day ( '+ $(this).data("starthalfday")+" )" : "";
            let endhalfday = $(this).data("endhalfday") ? '  half day ( '+ $(this).data("endhalfday")+" )" : "";
            let handover = $(this).data("handover");
            let reason = $(this).data("reason");
            let leaveType = $(this).data("leavetype");
            let LeaveAllocation = $(this).data("leaveallocation");
            let leave_balance = 0;
            if (leaveType == "annual_leave") {
                leave_balance = LeaveAllocation.total_annual_leave;
            }else if(leaveType == "sick_leave"){
                leave_balance = LeaveAllocation.total_sick_leave;
            }else if(leaveType == "special_leave"){
                leave_balance = LeaveAllocation.total_special_leave;
            }else if(leaveType == "unpaid_leave"){
                leave_balance = LeaveAllocation.total_unpaid_leave;
            }else if(leaveType == "long_sick_leave"){
                leave_balance = LeaveAllocation.total_long_sick_leave;
            }
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
                        '<p>@lang("lang.leave_balance"): <span style="font-weight: bold">'+leave_balance+' @lang("lang.day")</span></p>'+
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
                text: '@lang("lang.submit")',
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
    function strLimit(str, limit = 30, end = '...') {
        return str.length > limit ? str.substring(0, limit) + end : str;
    }
    function datashowTables() {
        let is_reject = "{{ Helper::permissionAccess('m10-s1','is_reject') }}";
        let is_approve = "{{ Helper::permissionAccess('m10-s1','is_approve') }}";
        $('#loading-overlay').show();

        if ($.fn.DataTable.isDataTable('.tbl-leave-request')) {
            $('.tbl-leave-request').DataTable().clear().destroy();
        }

        $('.tbl-leave-request').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ url("/leaves/admin/show") }}',
                type: 'GET',
                // dataSrc: function (response) { 
                //     console.log('Table data only:', response.data); 
                //     return response.data; 
                // }
            },
            columns: [
                // ✅ Checkbox (HRAdmin only)
                @if (Auth::user()->RolePermission == 'HRAdmin' || Auth::user()->RolePermission == 'admin')
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'stuck-scroll-3',
                        render: function (row) {

                            const isDisabled =
                                row.status === 'pending' &&
                                row.next_approver != {{ Auth::id() }};

                            return `
                                <input type="checkbox"
                                    class="sub_chk"
                                    data-id="${row.id}"
                                    data-status="${row.status}"
                                    ${isDisabled ? 'disabled' : ''}>
                            `;
                        }
                    },
                @endif

                {
                    data: null,
                    name: 'num',
                    className: 'ids stuck-scroll-3',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                // Employee
                {
                    data: 'employee.employee_name_en',
                    className: 'stuck-scroll-3',
                    defaultContent: ''
                },

                // Handover
                {
                    data: 'handover.employee_name_en',
                    defaultContent: ''
                },

                // Delegated
                {
                    data: 'Delegated',
                    defaultContent: ''
                },

                // Leave type
                {
                    data: 'leave_type.name',
                    defaultContent: ''
                },

                // Reason
                { 
                     data: 'reason',
                        defaultContent: '',
                        render: function (data, type, row) {

                            if (!data) return '';
                            return `
                                <span data-toggle="tooltip"
                                    data-html="true"
                                    title="${data}">
                                    ${strLimit(data, 30, '...')}
                                </span>
                            `;
                        }
                },

                // Days
                {
                    data: 'number_of_day',
                    render: d => `${d} Day`
                },

                { 
                    data: 'start_date',
                    render: function(data, type, row) {
                        return data ? moment(data).format('D-MMM-YYYY') : '';
                    }
                },

                // End date
                { 
                    data: 'end_date',
                    render: function(data, type, row) {
                        return data ? moment(data).format('D-MMM-YYYY') : '';
                    }
                },

                // Created At
                { 
                    data: 'created_at',
                    render: function(data, type, row) {
                        // ឆែកលក្ខខណ្ឌបើមានទិន្នន័យ ទើបហៅ Moment.js មក Format កុំឱ្យចេញ error ពេល data null
                        return data ? moment(data).format('D-MMM-YYYY HH:mm') : '';
                    }
                },

                // Created by
                {
                    data: 'created_by.employee_name_en',
                    defaultContent: ''
                },

                // Remark
                { data: 'remark', defaultContent: '' },

                // Approve
                { data: 'Approve', defaultContent: '' },

                // Status badge
                {
                    data: 'status',
                    render: function (status) {
                        switch (status) {

                            case 'rejected':
                                return `<span class="badge bg-inverse-danger" style="font-size:13px;">
                                            Rejected by HR
                                        </span>`;

                            case 'cancel':
                                return `<span class="badge bg-inverse-danger" style="font-size:13px;">
                                            Cancel
                                        </span>`;

                            case 'rejected_lm':
                                return `<span class="badge bg-inverse-danger" style="font-size:13px;">
                                            Rejected by Line Manager
                                        </span>`;

                            case 'rejected_hod':
                                return `<span class="badge bg-inverse-danger" style="font-size:13px;">
                                            Rejected by ACEO/Head/BM
                                        </span>`;

                            case 'approved_lm':
                            case 'pending':
                                return `<span class="badge bg-inverse-info" style="font-size:13px;">
                                            Waiting Approve by CEO/Head/BM
                                        </span>`;

                            case 'approved':
                            case 'approved_hod':
                                return `<span class="badge bg-inverse-success" style="font-size:13px;">
                                            Approved
                                        </span>`;

                            default:
                                return '';
                        }
                    }
                },


                // Action button
               {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (row) {

                        // Permission check
                        if (is_approve !== "1" && is_reject !== "1") {
                            return '';
                        }

                        // Status check
                        if (!['pending', 'approved_lm', 'approved_hod'].includes(row.status)) {
                            return '';
                        }

                        let buttonText = '';

                        if (is_approve === "1") {
                            buttonText += `@lang('lang.approve')`;
                        }

                        if (is_reject === "1") {
                            buttonText += (buttonText ? ' / ' : '') + `@lang('lang.reject')`;
                        }

                        return `
                            <button class="btn btn-outline-secondary btn-sm btn-approved"
                                data-id="${row.id}"
                                data-linemanager="${row.employee?.line_manager ?? ''}"
                                data-approveby="${row.next_approver}"
                                data-status="${row.status}"
                                data-employeename="${row.employee?.employee_name_en ?? ''}"
                                data-startdate="${row.start_date}"
                                data-enddate="${row.end_date}"
                                data-starthalfday="${row.start_half_day}"
                                data-endhalfday="${row.end_half_day}"
                                data-handover="${row.handover?.employee_name_en ?? ''}"
                                data-reason="${row.reason}"
                                data-leavetype="${row.leave_type?.type ?? ''}"
                                data-leaveallocation='${JSON.stringify(row.leave_allocation ?? {})}'
                            >
                                ${buttonText}
                            </button>
                        `;
                    }
                }
            ],
            order: [[0, 'desc']],
            initComplete: function () {
                $('#loading-overlay').hide();
            }
        });

        $('.tbl-leave-request').on('processing.dt', function (e, settings, processing) {
            processing ? $('#loading-overlay').show() : $('#loading-overlay').hide();
        });
    }
</script>
@endsection
