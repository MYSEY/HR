@extends('layouts.master')
<style>
     .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .ui-datepicker-calendar {
        display: none;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fringe_benefits_report')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fringe_benefits_report')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (permissionAccess("30","is_view")->value == "1")
        <div class="row filter-btn">
            <div class="col-sm-2 col-md-2"> 
                <div class="form-group cls-research">
                    <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name_kh" id="employee_name_kh"
                        placeholder="@lang('lang.name_kh')" value="{{ old('employee_name_kh') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name_en" id="employee_name_en"
                        placeholder="@lang('lang.name_en')" value="{{ old('employee_name_en') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary submit-btn me-2">
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                        <span class="btn-txt">@lang('lang.search')</span>
                    </button>
                    @if (permissionAccess("30","is_export")->value == "1")
                        <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                            <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <label >@lang('lang.excel')</label></span>
                            <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                    @endif
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn">
                        <span class="btn-text-reset">@lang('lang.reload')</span>
                        <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl_fringe_benefit_report"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" style="vertical-align:bottom" >#</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" style="vertical-align:bottom">@lang('lang.employee_id')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" colspan="2" style="text-align: center">@lang('lang.names_and_surnames')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" style="vertical-align:bottom" >@lang('lang.gender')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" style="vertical-align:bottom" >@lang('lang.position')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" style="vertical-align:bottom" >@lang('lang.location')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" style="vertical-align:bottom">@lang('lang.join_date')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" colspan="2" style="text-align: center">@lang('lang.total_cost')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" colspan="2" style="vertical-align:bottom; text-align: center">@lang('lang.tax_deduction') (50%)</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" colspan="2" style="vertical-align:bottom; text-align: center">@lang('lang.withholding_tax_rate') (20%)</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" colspan="2" style="vertical-align:bottom; text-align: center">@lang('lang.earnings_after_tax')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="2" style="vertical-align:bottom"  >@lang("lang.cashier's_signature")</th>
                                            </tr>
                                            <tr>
                                                <th>@lang('lang.name') (@lang('lang.kh'))</th>
                                                <th>@lang('lang.name') (@lang('lang.en'))</th>
                                                <th>@lang('lang.usd')</th>
                                                <th>@lang('lang.riel')</th>
                                                <th>@lang('lang.usd')</th>
                                                <th>@lang('lang.riel')</th>
                                                <th>@lang('lang.usd')</th>
                                                <th>@lang('lang.riel')</th>
                                                <th>@lang('lang.usd')</th>
                                                <th>@lang('lang.riel')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($datas) > 0)
                                                @foreach ($datas as $key=>$item)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $item["employee"]->number_employee }}</td>
                                                        <td>{{ $item["employee"]->employee_name_kh }}</td>
                                                        <td>{{ $item["employee"]->employee_name_en }}</td>
                                                        <td >{{$item["employee"]->employeeGender ? $item["employee"]->employeeGender : ""}}</td>
                                                        <td >{{$item["employee"]->position ? $item["employee"]->position->name_english : ""}}</td>
                                                        <td >{{$item["employee"]->branch ? $item["employee"]->branch->branch_name_en : ""}}</td>
                                                        <td >{{\Carbon\Carbon::parse($item["employee"]->date_of_commencement)->format('d-M-Y') ?? ''}}</td>
                                                        <td >{{ $item["amount_usd"] }}</td>
                                                        <td >{{ number_format($item["amount_riel"])}}</td>
                                                        <td >{{ $item["tax_deduction_usd"] }}</td>
                                                        <td >{{ number_format($item["tax_deduction_riel"])}}</td>
                                                        <td >{{ $item["withholding_tax_rate_usd"]}}</td>
                                                        <td >{{ number_format($item["withholding_tax_rate_riel"])}}</td>
                                                        <td >{{ $item["earnings_after_tax_usd"]}}</td>
                                                        <td >{{ number_format($item["earnings_after_tax_riel"])}}</td>
                                                        <td ></td>
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
@endsection
@include('includs.script')
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/fringe-benefits-report') }}");
        });
        $(".btn_excel").on("click", function() {
            let query = {
                employee_id: $("#employee_id").val(),
                employee_name_en: $("#employee_name_en").val(),
                employee_name_kh: $("#employee_name_kh").val(),
                position_id: $("#position_id").val(),
            };
            var url = "{{URL::to('reports/fringe-benefits-export')}}?" + $.param(query)
            window.location = url;
        });
        $(".submit-btn").on("click", function() {
            $(".submit-btn").prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block')
            let params = {
                employee_id: $("#employee_id").val(),
                employee_name_en: $("#employee_name_en").val(),
                employee_name_kh: $("#employee_name_kh").val(),
                position_id: $("#position_id").val(),
            };
            showdatas(params);
        });
    });
    function showdatas(params) {
        var localeLanguage = '{{ config('app.locale') }}';
        $.ajax({
            type: "post",
            url: "{{ url('reports/fringe-benefits-filter') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name_en: params.employee_name_en ? params.employee_name_en : null,
                employee_name_kh: params.employee_name_kh ? params.employee_name_kh : null,
                position_id: params.position_id ? params.position_id : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".submit-btn").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                if (data.length > 0) {
                    let index = 0;
                    data.map((row) => {
                        index++;
                        let join_date = row.employee.date_of_commencement ? moment(row.employee.date_of_commencement).format('D-MMM-YYYY'): "";
                        tr +='<tr class="odd">'+
                                '<td >'+(index)+'</td>'+
                                '<td >'+(row.employee.number_employee)+'</td>'+
                                '<td >'+(row.employee.employee_name_kh)+'</td>'+
                                '<td >'+(row.employee.employee_name_en)+'</td>'+
                                '<td >'+(row.employee.employee_gender ? row.employee.employee_gender.name_english : "")+'</td>'+
                                '<td >'+(row.employee.position ? row.employee.position.name_english : "")+'</td>'+
                                '<td >'+(row.employee.branch ? row.employee.branch.branch_name_en : "")+'</td>'+
                                '<td >'+(join_date)+'</td>'+
                                '<td >'+(row.amount_usd)+'</td>'+
                                '<td >'+(Number(row.amount_riel).toFixed(0))+'</td>'+
                                '<td >'+(row.tax_deduction_usd)+'</td>'+
                                '<td >'+(Number(row.tax_deduction_riel).toFixed(0))+'</td>'+
                                '<td >'+(row.withholding_tax_rate_usd)+'</td>'+
                                '<td >'+(Number(row.withholding_tax_rate_riel).toFixed(0))+'</td>'+
                                '<td >'+(row.earnings_after_tax_usd)+'</td>'+
                                '<td >'+(Number(row.earnings_after_tax_riel).toFixed(0))+'</td>'+
                                '<td> </td>'+
                        '</tr>';
                    });
                }else{
                    if(localeLanguage == 'en'){
                        var tr = '<tr><td colspan=19 align="center">No data available in table</td></tr>';
                    }else{
                        var tr = '<tr><td colspan=19 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                }
                $(".tbl_fringe_benefit_report tbody").html(tr);   
            }
        });
    }
</script>
