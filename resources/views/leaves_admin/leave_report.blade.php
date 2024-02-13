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
                    <h3 class="page-title">Leaves Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves Report</li>
                    </ul>
                </div>
            </div>
        </div>
        <form  class="needs-validation" novalidate>
            {{-- @csrf --}}
            
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group cls-research">
                        <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group leave-disply-search">
                        <select class="select form-control" id="type_id" data-select2-id="select2-data-2-c0n4" name="type_id">
                            <option value="" data-select2-id="select2-data-2-c0n4">@lang('lang.all_type')</option>
                            @foreach ($leaveType as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group leave-disply-search">
                        <select class="select form-control" id="department_id" data-select2-id="select2-data-2-c0n3" name="department_id">
                            <option value="" data-select2-id="select2-data-2-c0n3">@lang('lang.all_department')</option>
                            @foreach ($department as $item)
                                <option value="{{$item->id}}">{{$item->name_english}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group leave-disply-search">
                        <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                            @foreach ($location as $item)
                                <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" id="start_date" name="start_date"
                                placeholder="@lang('lang.start_date')">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" id="end_date" name="end_date" placeholder="@lang('lang.end_date')">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group leave-disply-search">
                        <select class="select form-control" id="status" data-select2-id="select2-data-2-c0n5" name="status">
                            <option value="" data-select2-id="select2-data-2-c0n5">@lang('lang.all_status')</option>
                            <option value="rejected">@lang('lang.reject')</option>
                            <option value="cancel">@lang('lang.cancel')</option>
                            <option value="approved">@lang('lang.approved')</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 filter-btn">
                    <div style="display: flex" class="float-end">
                        <button class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                            <span class="btn-text-search"><i class="fa fa-search"></i></span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                        {{-- @if (permissionAccess("m6-s3","is_export")->value == "1" ) --}}
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        {{-- @endif --}}
                        <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                            <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                            <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-leave-report" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                            <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                            <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Leave Type: activate to sort column ascending">Leave Type</th>
                                            <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending"
                                                aria-label="department: activate to sort column descending">@lang('lang.department')</th>
                                            <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                aria-sort="ascending" aria-label="location: activate to sort column descending">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="No of Days: activate to sort column ascending">Number of Days</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="status: activate to sort column descending">@lang('lang.status')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Reason: activate to sort column ascending">Reason</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="remark: activate to sort column descending">@lang('lang.remark')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($dataLeaveReport) > 0)
                                            @foreach ($dataLeaveReport as $key=>$leave)
                                                <tr class="odd">
                                                    <td class="ids stuck-scroll-3">{{++$key ?? ""}}</td>
                                                    <td class="stuck-scroll-3 employee_name"> {{$leave->employee->employee_name_en}} </td>
                                                    <td class="stuck-scroll-3">{{$leave->leaveType->name}}</td>
                                                    <td >{{$leave->employee->department->name_english}}</td>
                                                    <td >{{$leave->employee->branch->branch_name_en}}</td>
                                                    <td >{{\Carbon\Carbon::parse($leave->start_date)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{\Carbon\Carbon::parse($leave->end_date)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{$leave->number_of_day}} Day</td>
                                                    <td>
                                                        @if ($leave->status == "rejected")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                                        @elseif($leave->status == "cancel")
                                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>
                                                        @else
                                                            <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$leave->reason}}</td>
                                                    <td>{{$leave->remark}}</td>
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
@endsection
@include('includs.script')
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/leaves/report') }}"); 
        });
        $(".btn_excel").on("click", function () {
            var query = {
                'employee_name': $("#employee_name").val(),
                'status': $("#status").val(),
                'department_id': $("#department_id").val(),
                'branch_id': $("#branch_id").val(),
                'start_date': $("#start_date").val(),
                'end_date': $("#end_date").val(),
            }
            var url = "{{URL::to('leaves/export-report')}}?" + $.param(query)
            window.location = url;
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');

            axios.post('{{ URL('leaves/filter-report') }}', {
                'employee_name': $("#employee_name").val(),
                'status': $("#status").val(),
                'department_id': $("#department_id").val(),
                'branch_id': $("#branch_id").val(),
                'start_date': $("#start_date").val(),
                'end_date': $("#end_date").val(),
            }).then(function(response) {
                var rows = response.data.success;
                if (rows.length > 0) {
                    var tr = "";
                    let status = "";
                    $(rows).each(function(e, row) {
                        let start_date = moment(row.start_date).format('D-MMM-YYYY');
                        let end_date = moment(row.end_date).format('D-MMM-YYYY');
                        if (row.status == "rejected"){
                            status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>';
                        }else if(row.status == "cancel"){
                            status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>';
                        }else if(row.status == "approved"){
                            status = '<span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>';
                        };
                        tr += '<tr class="odd">'+
                            '<td class="ids">'+(e+1)+'</td>'+
                            '<td>' + (row.employee.employee_name_en) + '</td>'+
                            '<td>' + (row.leave_type.name) + '</td>'+
                            '<td>' + (row.employee.department.name_english) + '</td>'+
                            '<td>' + (row.employee.branch.branch_name_en) + '</td>'+
                            '<td>' + (start_date) + '</td>'+
                            '<td>' + (end_date) + '</td>'+
                            '<td>' + (row.number_of_day) + ' Day</td>'+
                            '<td>' + (status) + '</td>'+
                            '<td>' + (row.reason ? row.reason : "") + '</td>'+
                            '<td>' + (row.remark ? row.remark : "" ) + '</td>'+
                        '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=11 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                    
                $(".tbl-leave-report tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
        
    });
</script>
