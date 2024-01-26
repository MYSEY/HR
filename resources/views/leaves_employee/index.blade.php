@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leave"><i
                            class="fa fa-plus"></i> Request Leave</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Annual Leave</h6>
                    <h4>{{$LeaveAllocation ? $LeaveAllocation->total_annual_leave : 0}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Sick Leave</h6>
                    <h4>{{$LeaveAllocation ? $LeaveAllocation->total_sick_leave : 0}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Special Leave</h6>
                    <h4>{{$LeaveAllocation ? $LeaveAllocation->total_special_leave : 0}}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Unpaid Leave</h6>
                    <h4>{{$LeaveAllocation ? $LeaveAllocation->total_unpaid_leave : 0}}</h4>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                {{-- <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Leave Type: activate to sort column ascending"
                                                style="width: 108.1px;">Leave Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="From: activate to sort column ascending"
                                                style="width: 78.7625px;">Start Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="To: activate to sort column ascending" style="width: 77.875px;">
                                                End Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="No of Days: activate to sort column ascending"
                                                style="width: 76.7875px;">Number of Days</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Reason: activate to sort column ascending"
                                                style="width: 116.887px;">Reason</th>
                                            <th class="text-center sorting" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending"
                                                style="width: 109.887px;">Status</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Actions: activate to sort column ascending"
                                                style="width: 54.4875px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataLeaveRequest) > 0)
                                            @foreach ($dataLeaveRequest as $request)
                                            <tr class="odd">
                                                <td>{{$request->leaveType->name}}</td>
                                                <td>{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                <td>{{$request->number_of_day}} Day</td>
                                                <td>{{$request->reason}}</td>
                                                <td>
                                                    @if ($request->status == "pending" || $request->status == "approved_lm")
                                                        @if ($request->status == "approved_lm")
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending HR to Approved.</span>
                                                        @else
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending personal manager to Approved.</span>
                                                        @endif
                                                        
                                                    @elseif ($request->status == "rejected" || $request->status == "rejected_lm")
                                                        <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                                    @elseif ($request->status == "approved")
                                                        <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @if ($request->status=='pending')
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item update" data-toggle="modal" data-id="{{$request->id}}" data-target="#edit_leave_request"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-id="{{$request->id}}" data-target="#delete_leave"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table> --}}
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer staff-transfer-report"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="2" aria-sort="ascending"
                                            aria-label="#: activate to sort column descending">#</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            colspan="2" aria-label="Period of Leave: activate to sort column descending"
                                            style="text-align: center">Period of Leave</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            colspan="2" aria-label="Annual: activate to sort column descending"
                                            style="text-align: center">Annual Leave</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            colspan="2"  aria-sort="ascending" aria-label="Sick: activate to sort column descending"
                                            style="text-align: center">Sick Leave</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            colspan="2" aria-sort="ascending" aria-label="Profle: activate to sort column descending"
                                            style="text-align: center">Special Leave</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="2" aria-sort="ascending" aria-label="reason: activate to sort column descending">@lang('lang.reason')</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="2" aria-sort="ascending" aria-label="approve_by: activate to sort column descending" style="text-align: center;">Checked by <br> Sub.or line Mgr</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="2" aria-sort="ascending" aria-label="approve_by: activate to sort column descending" style="text-align: center;"
                                            >Approve by <br> BM or Head <br> Dept or CEO</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="2" aria-sort="ascending" aria-label="approve_by: activate to sort column descending" style="text-align: center;">Confirmed by <br> HRD</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="2" aria-sort="ascending"
                                            aria-label="actions: activate to sort column descending">@lang('lang.actions')</th>
                                    </tr>
                                    <tr>
                                        <th>From</th>
                                        <th>To </th>
                                        <th>Day Taken</th>
                                        <th>Balance (today) </th>
                                        <th>Day Taken</th>
                                        <th>Balance (today) </th>
                                        <th>Day Taken</th>
                                        <th>Balance (today) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($dataLeaveRequest) > 0)
                                        @php
                                            $total_annual_leave= 0;
                                            $total_sick_leave= 0;
                                            $total_spacial_leave= 0;
                                        @endphp
                                        @foreach ($dataLeaveRequest as $key=>$request)
                                            @php
                                                if ($request->leaveType->type == "annual_leave") {
                                                    $total_annual_leave += $request->number_of_day;
                                                }else if ($request->leaveType->type == "sick_leave") {
                                                    $total_sick_leave += $request->number_of_day;
                                                }else if ($request->leaveType->type == "special_leave") {
                                                    $total_spacial_leave += $request->number_of_day;
                                                }
                                            @endphp
                                            <tr class="odd">
                                                <td>{{$key+1}}</td>
                                                <td>{{\Carbon\Carbon::parse($request->start_date)->format('d-M-Y') ?? ''}}</td>
                                                <td>{{\Carbon\Carbon::parse($request->end_date)->format('d-M-Y') ?? ''}}</td>
                                                <td>{{$request->leaveType->type == "annual_leave"? $request->number_of_day : 0}}</td>
                                                <td>{{$request->leaveType->type == "annual_leave" ? $LeaveAllocation->default_annual_leave - $total_annual_leave : 0}}</td>
                                                <td>{{$request->leaveType->type == "sick_leave"? $request->number_of_day : 0}}</td>
                                                <td>{{$request->leaveType->type == "sick_leave" ? $LeaveAllocation->default_sick_leave - $total_sick_leave : 0}}</td>
                                                <td>{{$request->leaveType->type == "special_leave"? $request->number_of_day : 0}}</td>
                                                <td>{{$request->leaveType->type == "special_leave" ? $LeaveAllocation->default_special_leave - $total_spacial_leave : 0}}</td>
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
                                                <td>
                                                    @if ((isset($request->StatusApprve["rejected_lm"])) || isset($request->StatusApprve["rejected_bm"]) || isset($request->StatusApprve["rejected_lsm"]))
                                                        <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                                    @elseif (isset($request->StatusApprve["approved_lm"]) || isset($request->StatusApprve["approved_bm"]))
                                                        <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                    @else
                                                        <span class="badge bg-inverse-info" style="font-size: 13px;">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($request->StatusApprve["rejected_hr"]) || isset($request->StatusApprve["rejected_bm"]) || isset($request->StatusApprve["rejected_lsm"]))
                                                        <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                                    @elseif (isset($request->StatusApprve["approved_hr"]))
                                                        <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                    @else
                                                        <span class="badge bg-inverse-info" style="font-size: 13px;">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @if (isset($request->StatusApprve["pending"]))
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item update" data-toggle="modal" data-id="{{$request->id}}" data-target="#edit_leave_request"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-id="{{$request->id}}" data-target="#delete_leave"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                            </div>
                                                        </div>
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

    <div id="add_leave" class="modal custom-modal fade" role="dialog">
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
                                        <option selected disabled value=""> --@lang('lang.select')--</option>
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
                                    <label>From Date <span class="text-danger">*</span></label>
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
                                    <label>To Date <span class="text-danger">*</span></label>
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

    <div id="edit_leave_request" class="modal custom-modal fade hr-modal-select2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Leave Request</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('leaves/employee/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="id" class="e_id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Leave Type<span class="text-danger">*</span></label>
                                    <select class="form-control select floating" id="e_leave_type_id" name="leave_type_id" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>From Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" name="start_date" id="e_start_date" required>
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
                                    <label>To Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker" name="end_date" id="e_end_date"  required>
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
                                    <input type="text" class="form-control" id="e_number_of_day" name="number_of_day" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label >Leave Reason</label>
                                    <textarea class="form-control" id="e_reason" name="reason" placeholder="Write down why you want to relax"></textarea>
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
    <!-- Delete leave request Modal -->
    <div class="modal custom-modal fade" id="delete_leave" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>@lang('lang.delete')</h3>
                        <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{url('leaves/employee/delete')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_id">
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
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('.update').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
            let _id = id;
            $.ajax({
                type: "GET",
                url: "{{url('leaves/employee/edit')}}",
                data: {
                    id : _id
                },
                dataType: "JSON",
                success: function (response) {
                    let success = response.success;
                    $('#e_start_date').val(success.start_date);
                    $('#e_end_date').val(success.end_date);
                    $('#e_number_of_day').val(success.number_of_day);
                    $('#e_reason').text(success.reason);
                    $('#e_leave_type_id').html('<option value=""> -- @lang("lang.select") --</option>');
                    if (response.dataLeaveType != '') {
                        $.each(response.dataLeaveType, function(i, item) {
                            $('#e_leave_type_id').append($('<option>', {
                                value: item.id,
                                text: item.name,
                                selected: item.id == response.success.leave_type_id
                            }));
                        });
                    }
                }
            });
        });
        $('.leaveDelete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    });
</script>