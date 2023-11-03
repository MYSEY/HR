@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 8px !important;
    }

    #filter_month {
        position: relative;
    }

    input[type="month"]::-webkit-calendar-picker-indicator {
        background-position: right;
        background-size: auto;
        cursor: pointer;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        height: auto;
        width: auto;
    }

</style>
@section('content')
<div class="">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.import_nssf')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.import_nssf')</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                    <a href="#" class="btn add-btn" data-toggle="modal" id="importNSSF"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                @endif
            </div>
        </div>
    </div>
    
    @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
        <form>
            {{-- @csrf --}}
            <div class="row filter-btn"> 
                <div class="col-sm-2 col-md-2"> 
                    <div class="form-group">
                        <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                            @foreach ($branch as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                    <div class="form-group ">
                        <input class="form-control" type="month" id="filter_month">
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div style="display: flex" class="float-end">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.search')</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                            <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> @lang('lang.excel')</span>
                            <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary reset-btn">
                            <span class="btn-text-reset">@lang('lang.reload')</span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif
    {!! Toastr::message() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer tbl_nssf">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc stuck" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                        <th class="sorting sorting_asc stuck" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">@lang('lang.employee_name')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">@lang('lang.gender')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">@lang('lang.position')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">@lang('lang.location')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.total_salary_before_tax_dollars')@lang('lang.usd')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.total_salary_before_tax_riel')@lang('lang.riel')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.average_wage')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending"> @lang('lang.occupational_risk')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.health_care')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.pension_contribution_riel')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.pension_contribution_dollar')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.enterprise_pension_contribution')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">@lang('lang.payment_date')</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($DataNSSF) > 0)
                                        @foreach ($DataNSSF as $item)
                                            <tr class="odd">
                                                <td class="stuck"><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                <td class="stuck"><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeName }}</a></td>
                                                <td><a href="#">{{ $item->users->EmployeeGender }}</a></td>
                                                <td><a href="#">{{ $item->users->EmployeePosition }}</a></td>
                                                <td><a href="#">{{ $item->users->EmployeeBranch }}</a></td>
                                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                <td>${{ number_format($item->total_pre_tax_salary_usd,2) }}</td>
                                                <td><span>៛</span>{{ number_format($item->total_pre_tax_salary_riel) }}</td>
                                                <td><span>៛</span>{{ number_format($item->total_average_wage) }}</td>
                                                <td><span>៛</span>{{ number_format($item->total_occupational_risk)}}</td>
                                                <td>{{ number_format($item->total_health_care) }}</td>
                                                <td><span>៛</span>{{ number_format($item->pension_contribution_usd) }}</td>
                                                <td>${{ $item->pension_contribution_riel }}</td>
                                                <td><span>៛</span>{{ number_format($item->corporate_contribution) }}</td>
                                                <td>{{ Carbon\Carbon::parse($item->payment_date)->format('d-M-Y') }}</td>
                                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
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

    @include('NSSFs.import_nssf')

</div>
  
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script src="{{ asset('/admin/js/date-range-bicker.js') }}"></script>
<script>
    $(function() {
        $("#importNSSF").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#importNssfModal').modal('show');
        });
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/nssf-report') }}");
        });
        $(".btn-Search").on("click", function(){
            $(".btn-Search").prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block')
            let params = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                branch_id: $("#branch_id").val(),
                filter_month: $("#filter_month").val(),
            };
            showdatas(params);
        });
        $(".btn_excel").on("click", function() {
            let query = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val()
            };
            var url = "{{URL::to('reports/nssf-export')}}?" + $.param(query)
            window.location = url;
        });
        $(".btn_print").on("click", function() {
            $("#btn-text-loading-print").css('display', 'block');
            $(".btn_print").prop('disabled', true);
            $(".btn-text-print").css("display", "none");
            let params = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
                btn_print: true
            };
            showdatas(params)
            print_pdf();
        });
    });
    function showdatas(params) {
        var localeLanguage = '{{ config('app.locale') }}';
        $.ajax({
            type: "post",
            url: "{{ url('reports/nssf-report') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name: params.employee_name ? params.employee_name : null,
                branch_id: params.branch_id ? params.branch_id : null,
                filter_month: params.filter_month ? params.filter_month : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".btn-Search").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                if (data.length > 0) {
                    data.map((row) => {
                        let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                        let payment_date = moment(row.payment_date).format('D-MMM-YYYY')
                        let created_at = moment(row.created_at).format('D-MMM-YYYY')
                        tr +='<tr class="odd">'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.last_name_kh )+'</a></td>'+
                                '<td><a href="#">'+(row.users == null ? '' : row.users.first_name_kh )+'</a></td>'+
                                '<td><a href="#">'+(localeLanguage == 'en' ? row.name_english  : row.name_khmer )+'</a></td>'+
                                '<td><a href="#">'+(localeLanguage == 'en' ? row.positionNameEnglish  : row.positionNameKhmer )+'</a></td>'+
                                '<td><a href="#">'+(localeLanguage == 'en' ? row.branck_en  : row.branck_kh )+'</a></td>'+
                                '<td>'+(join_date)+'</td>'+
                                '<td>$'+(row.total_pre_tax_salary_usd )+'</td>'+
                                '<td><span>៛</span>'+(formatCurrencyKH(row.total_pre_tax_salary_riel) )+'</td>'+
                                '<td>'+(formatCurrencyKH(row.total_average_wage) )+'</td>'+
                                '<td>'+(formatCurrencyKH(row.total_occupational_risk) )+'</td>'+
                                '<td>'+(formatCurrencyKH(row.total_health_care) )+'</td>'+
                                '<td><span>៛</span>'+(formatCurrencyKH(row.pension_contribution_usd) )+'</td>'+
                                '<td>$'+(row.pension_contribution_riel )+'</td>'+
                                '<td><span>៛</span>'+(formatCurrencyKH(row.corporate_contribution) )+'</td>'+
                                '<td>'+(payment_date)+'</td>'+
                                '<td>'+(created_at)+'</td>'+
                        '</tr>';
                    });
                }else {
                    if(localeLanguage == 'en'){
                        var tr = '<tr><td colspan=15 align="center">No data available in table</td></tr>';
                    }else{
                        var tr = '<tr><td colspan=15 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                }
                $(".tbl_nssf tbody").html(tr);
            }
        });
    }
    function formatCurrencyKH(currency) {
        return parseInt(currency).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function print_pdf(type) {
        $("#print_purchase").show();
        window.setTimeout(function() {
            $("#print_purchase").hide();
            $(".btn_print").prop('disabled', false);
            $(".btn-text-print").show();
            $("#btn-text-loading-print").css('display', 'none');
        }, 2000);
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/style_print_report_payroll.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>