@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.view_all_leave') {{Helper::getCurrenYear()}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/admin') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.view_all_leave')</li>
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
                <div class="form-group leave-disply-search">
                    <select class="select form-control" id="department_id" data-select2-id="select2-data-2-c0n3" name="department_id">
                        <option value="" data-select2-id="select2-data-2-c0n3">@lang('lang.all_department')</option>
                        @foreach ($department as $item)
                            <option value="{{$item->id}}">{{$item->name_english}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group leave-disply-search">
                    <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                        <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.location')</option>
                        @foreach ($location as $item)
                            <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                        @endforeach
                    </select>
                </div>
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
                    <a href="{{ url('/dashboad/admin') }}" class="btn btn-sm btn-outline-secondary" id="icon-search-download-reload"><i class="fa fa-backward"></i></a>
                </div>
            </div>
        </div>
        <div class="tab-pane show" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable dataTable no-footer tbl-leave-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">#</th>
                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Employee: activate to sort column descending" >@lang('lang.employee_name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="handover staff: activate to sort column ascending">@lang('lang.handover_staff')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="delegated: activate to sort column ascending">@lang('lang.delegated')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="No of Days: activate to sort column ascending">@lang('lang.number_of_days')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="From: activate to sort column ascending">@lang('lang.start_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" aria-label="To: activate to sort column ascending">@lang('lang.end_date')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($dataLeaveRequest) > 0)
                                                @foreach ($dataLeaveRequest as $key=>$item)
                                                    <tr>
                                                        <td class="ids">{{++$key ?? ""}}</td>
                                                        <td> {{$item->employee ? $item->employee->employee_name_en : ""}} </td>
                                                        <td>{{ $item->handover ? $item->handover->employee_name_en : ""}}</td>

                                                        <td>{{$item->Delegated}}</td>
                                                        <td>{{$item->number_of_day}} Day</td>
                                                        <td >{{\Carbon\Carbon::parse($item->start_date)->format('d-M-Y') ?? ''}}</td>
                                                        <td>{{\Carbon\Carbon::parse($item->end_date)->format('d-M-Y') ?? ''}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" style="text-align: center">@lang('lang.no_record_to_display')</td>
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
    </div>
@endsection
@include('includs.script')
<script>
    $(function(){
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/dashboad/view-leave') }}"); 
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('dashboad/view-leave/search') }}', {
                'employee_name': $("#employee_name").val(),
                'department_id': $("#department_id").val(),
                'branch_id': $("#branch_id").val(),
            }).then(function(response) {
                var rows = response.data.success;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let start_date = moment(row.start_date).format('D-MMM-YYYY');
                        let end_date = moment(row.end_date).format('D-MMM-YYYY');
                        tr += '<tr class="odd">'+
                            '<td class="ids">'+(e+1)+'</td>'+
                            '<td class="stuck-scroll-3">' + (row.employee ? row.employee.employee_name_en : "") + '</td>'+
                            '<td>' + (row.handover ? row.handover.employee_name_en : "") + '</td>'+
                            '<td>' +(row.delegated_employee)+'</td>'+
                            '<td>' + (row.number_of_day) + ' Day</td>'+
                            '<td>' + (start_date) + '</td>'+
                            '<td>' + (end_date) + '</td>'+
                        '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=7 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-leave-request tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
    });
</script>