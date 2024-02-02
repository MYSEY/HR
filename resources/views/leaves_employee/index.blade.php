@extends('layouts.master')
<style>
    .card_background_color {
        background-color: #f8f9fa !important;
    }
    /* The container checkbox */
    .container-checkbox {
        /* display: block; */
        position: relative;
        padding-left: 35px;
        /* margin-bottom: 5px; */
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
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
                                                rowspan="2" aria-sort="ascending" aria-label="approve_by: activate to sort column descending" style="text-align: center;">@lang('lang.status')</th>
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
                                                        @if ($request->status == "rejected")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">HR Rejected</span>
                                                        @elseif ($request->status == "rejected_lm")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Line Manager Rejected</span>
                                                        @elseif ($request->status == "rejected_hod")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Head department Rejected</span>
                                                        @elseif ($request->status == "pending")
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending Line Manager Approved</span>
                                                        @elseif ($request->status == "approved_lm")
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending Head department Approved</span>
                                                        @elseif ($request->status == "approved_hod")
                                                            <span class="badge bg-inverse-info" style="font-size: 13px;">Pending HR Approved</span>
                                                        @elseif($request->status == "approved")
                                                            <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if (isset($request->StatusApprve["pending"]))
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item update" data-toggle="modal" data-id="{{$request->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    <a class="dropdown-item leaveDelete" href="#" data-toggle="modal" data-id="{{$request->id}}" data-numberday="{{$request->number_of_day}}" data-target="#delete_leave"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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
    @include('leaves_employee.modal_form_create')
    @include('leaves_employee.modal_form_edit')

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
                            <input type="hidden" name="number_of_day" class="number_of_day">
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
<script>
    $(function(){
        $('.leaveDelete').on('click',function(){
            let id = $(this).data("id");
            let numberday = $(this).data("numberday");
            $('.e_id').val(id);
            $('.number_of_day').val(numberday);
        });
    });
</script>