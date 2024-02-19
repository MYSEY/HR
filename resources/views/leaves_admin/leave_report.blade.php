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
                    <h3 class="page-title">@lang('lang.leaves_report')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.leaves_report')</li>
                    </ul>
                </div>
            </div>
        </div>
        <form  class="needs-validation" novalidate>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group cls-research">
                        <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
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
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 filter-btn">
                    <div style="display: flex" class="float-end">
                        <button class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                            <span class="btn-text-search"><i class="fa fa-search"></i></span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                        @if (permissionAccess("m10-s3","is_print")->value == "1") 
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        @endif
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
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer w-100 tbl-leave-report"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="2" aria-sort="ascending"
                                                aria-label="#: activate to sort column descending">@lang('lang.employee_name')</th>
                                            <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="2" aria-sort="ascending"
                                                aria-label="department: activate to sort column descending">@lang('lang.department')</th>
                                            <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="2" aria-sort="ascending"
                                                aria-label="location: activate to sort column descending">@lang('lang.location')</th>
                                            <th class="sorting sorting_asc vertical-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="2" aria-sort="ascending"
                                                aria-label="location: activate to sort column descending">@lang('lang.join_date')</th>
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
                                                colspan="2" aria-sort="ascending" aria-label="Profle: activate to sort column descending"
                                                style="text-align: center">@lang('lang.unpaid_leave')</th>
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
                                            <th>@lang('lang.day_taken')</th>
                                            <th>@lang('lang.balance')</th>
                                            <th>@lang('lang.year') 1</th>
                                            <th>@lang('lang.year') 2</th>
                                            <th>@lang('lang.year') 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($LeaveAllocation) > 0)
                                            @foreach ($LeaveAllocation as $key=>$leave)
                                                <tr class="odd">
                                                    <td>{{$leave->employee->employee_name_en}}</td>
                                                    <td>{{$leave->employee->department->name_english}}</td>
                                                    <td>{{$leave->employee->branch->branch_name_en}}</td>
                                                    <td>{{\Carbon\Carbon::parse($leave->employee->date_of_commencement)->format('d-M-Y') ?? ''}}</td>
                                                    <td>{{$leave->default_annual_leave - $leave->total_annual_leave}}</td>
                                                    <td>{{$leave->total_annual_leave}}</td>
                                                    <td>{{number_format($leave->default_sick_leave - $leave->total_sick_leave)}}</td>
                                                    <td>{{number_format($leave->total_sick_leave)}}</td>
                                                    <td>{{number_format($leave->default_special_leave -$leave->total_special_leave)}}</td>
                                                    <td>{{number_format($leave->total_special_leave)}}</td>
                                                    <td>{{number_format($leave->default_unpaid_leave - $leave->total_unpaid_leave)}}</td>
                                                    <td>{{number_format($leave->total_unpaid_leave)}}</td>
                                                    <td>{{$leave->year_1 ? $leave->year_1 : 0}}</td>
                                                    <td>{{$leave->year_2 ? $leave->year_2 : 0}}</td>
                                                    <td>{{$leave->year_3 ? $leave->year_3 : 0}}</td>
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
                console.log("rows: ",rows);
                if (rows.length > 0) {
                    var tr = "";
                    let status = "";
                    $(rows).each(function(e, row) {
                        let join_date = moment(row.date_of_commencement).format('D-MMM-YYYY');
                        tr += '<tr class="odd">'+
                            '<td>'+(row.employee.employee_name_en)+'</td>'+
                            '<td>'+(row.employee.department.name_english)+'</td>'+
                            '<td>'+(row.employee.branch.branch_name_en)+'</td>'+
                            '<td>'+(join_date)+'</td>'+
                            '<td>'+(row.default_annual_leave - row.total_annual_leave)+'</td>'+
                            '<td>'+(row.total_annual_leave)+'</td>'+
                            '<td>'+(row.default_sick_leave - row.total_sick_leave)+'</td>'+
                            '<td>'+(row.total_sick_leave)+'</td>'+
                            '<td>'+(row.default_special_leave -row.total_special_leave)+'</td>'+
                            '<td>'+(row.total_special_leave)+'</td>'+
                            '<td>'+(row.default_unpaid_leave - row.total_unpaid_leave)+'</td>'+
                            '<td>'+(row.total_unpaid_leave)+'</td>'+
                            '<td>'+(row.year_1 ? row.year_1 : 0)+'</td>'+
                            '<td>'+(row.year_2 ? row.year_2 : 0)+'</td>'+
                            '<td>'+(row.year_3 ? row.year_3 : 0)+'</td>'+
                        '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=15 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                    
                $(".tbl-leave-report tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
        
    });
</script>
