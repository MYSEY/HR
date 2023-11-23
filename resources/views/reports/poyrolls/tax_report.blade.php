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
                <h3 class="page-title">@lang('lang.tax_report')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.tax_report')</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="">
        @if (permissionAccess("m7-s3","is_view")->value == "1")
            <form>
                {{-- @csrf --}}
                <div class="row filter-btn"> 
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group cls-research">
                            {{-- <div class="cal-icon"> --}}
                                <input class="form-control" type="month" id="filter_month">
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group" id="col-branch">
                            <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                                @foreach ($branchs as $item)
                                    <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-sm-6 col-md-4">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn me-2">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.search')</span>
                            </button>
                            @if (permissionAccess("m7-s3","is_export")->value == "1")
                                <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                    <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <label >@lang('lang.excel')</label></span>
                                    <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                                </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn">
                                <span class="btn-text-reset">@lang('lang.reload')</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer tbl_payment_salary"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting stuck" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                                    <th class="sorting sorting_asc stuck" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee Name: activate to sort column descending" style="width: 178px;">@lang('lang.employee_name')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">@lang('lang.department')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">@lang('lang.position')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">@lang('lang.location')</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.basic_salary')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.base_salary_received')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.child_allowance')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.phone_allowance')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.KNY_/_pchum_ben')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.total_gross_salary')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.excluded_tax'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.pension_fund')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')(@lang('lang.usd'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')(@lang('lang.riel'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.salary_charges_reduced')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.tax_base')(@lang('lang.riel'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.tax_rate')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.personal_tax')(@lang('lang.usd'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.personal_tax')(@lang('lang.riel'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.excluded_tax'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_backford')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.severance_pay')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 51.475px;">@lang('lang.net_salary')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending" style="width: 89.6px;">@lang('lang.payment_date')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($payroll)>0)
                                                    @foreach ($payroll as $item)
                                                        <tr class="odd">
                                                            <td class="stuck"><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                            <td class="stuck"><a href="#">{{ Helper::getLang() == 'en' ? $item->users->employee_name_en : $item->users->employee_name_kh }}</a></td>
                                                            <td><a href="#">{{$item->users == null ? '' : $item->users->EmployeeDepartment}}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeePosition}}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeBranch}}</a></td>
                                                            <td>{{ $item->users == null ? '' : $item->users->joinOfDate}}</td>
                                                            <td>$<a href="#">{{ $item->basic_salary }}</a></td>
                                                            <td>$<a href="#">{{ $item->total_gross_salary }}</a></td>
                                                            <td>$<a href="#">{{ $item->total_child_allowance }}</a></td>
                                                            <td>$<a href="#">{{ $item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_kny_phcumben}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_gross }}</a></td>
                                                            <td>$<a href="#">{{ $item->seniority_pay_included_tax}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_pension_fund}}</a></td>
                                                            <td>$<a href="#">{{ $item->base_salary_received_usd}}</a></td>
                                                            <td><span>៛</span><a href="#">{{ number_format($item->base_salary_received_riel) }}</a></td>
                                                            <td><span>៛</span><a href="#">{{$item->total_charges_reduced == '0' ? '0.00' : number_format($item->total_charges_reduced) }}</a></td>
                                                            <td><span>៛</span><a href="#">{{ number_format($item->total_tax_base_riel) }}</a></td>
                                                            <td><a href="#">{{ $item->total_rate}}%</a></td>
                                                            <td>$<a href="#">{{ $item->total_salary_tax_usd}}</a></td>
                                                            <td><span>៛</span><a href="#">{{$item->total_salary_tax_riel == '0' ? '0.00' : number_format($item->total_salary_tax_riel) }}</a></td>
                                                            <td>$<a href="#">{{ $item->seniority_pay_excluded_tax}}</a></td>
                                                            <td>$<a href="#">{{ $item->seniority_backford}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_severance_pay}}</a></td>
                                                            <td><span>៛</span><a href="#">{{ number_format($item->total_salary * $item->exchange_rate) }}</a></td>
                                                            <td>{{ $item->payment_date}}</td>
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
    </div>
</div>
  
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script src="{{ asset('/admin/js/date-range-bicker.js') }}"></script>
<script>
    $(function() {
        var tab_status = 1;
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/tax-report') }}");
        });
        $(".submit-btn").on("click", function(){
            $(".submit-btn").prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block')
            let params = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                branch_id: $("#branch_id").val(),
                filter_month: $("#filter_month").val(),
            };
            showdatas(tab_status, params);
        });
        $(".btn_excel").on("click", function() {
            let query = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
                tab_status: tab_status
            };
            var url = "{{URL::to('reports/tax-report-export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function showdatas(tab_status, params) {
        var localeLanguage = '{{ config('app.locale') }}';
        $.ajax({
            type: "post",
            url: "{{ url('reports/tax-report') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                tab_status,
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name: params.employee_name ? params.employee_name : null,
                branch_id: params.branch_id ? params.branch_id : null,
                filter_month: params.filter_month ? params.filter_month : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".submit-btn").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                    
                if (data.length > 0) {
                    let dollar = "$";
                    data.map((row) => {
                        let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                        let payment_date = moment(row.payment_date).format('D-MMM-YYYY')
                        tr +='<tr class="odd">'+
                            '<td class="stuck"><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                            '<td class="stuck"><a href="#">'+(localeLanguage == 'en' ? row.users.employee_name_en : row.users.employee_name_kh )+'</a></td>'+
                            '<td ><a href="#">'+(localeLanguage == 'en' ? row.depart_name_en : row.depart_name_kh )+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.position_name_en : row.position_name_kh)+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.branck_en : row.branck_kh)+'</a></td>'+
                            '<td>'+(join_date)+'</td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.basic_salary )+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.total_gross_salary )+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.total_child_allowance )+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.phone_allowance == null ? '0.00' : row.phone_allowance)+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.total_kny_phcumben)+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.total_gross )+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.seniority_pay_included_tax)+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.total_pension_fund)+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.base_salary_received_usd)+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.base_salary_received_riel))+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(row.total_charges_reduced == '0' ? '0.00' : formatCurrencyKH(row.total_charges_reduced))+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_tax_base_riel))+'</a></td>'+
                            '<td><a href="#">'+(row.total_rate)+'%</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.total_salary_tax_usd)+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(row.total_salary_tax_riel == '0' ? '0.00' : formatCurrencyKH(row.total_salary_tax_riel))+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.seniority_pay_excluded_tax)+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.seniority_backford)+'</a></td>'+
                            '<td>'+(dollar)+'<a href="#">'+(row.total_severance_pay)+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_salary * row.exchange_rate))+'</a></td>'+
                            '<td>'+(payment_date)+'</td>'+
                        '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=30 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl_payment_salary tbody").html(tr);
                $("#table_print_filter_basic_salary tbody").html(tr);
            }
        });
    }
    function formatCurrencyKH(currency) {
        return parseInt(currency).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>