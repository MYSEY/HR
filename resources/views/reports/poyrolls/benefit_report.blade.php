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
                <h3 class="page-title">@lang('lang.benefit_khy')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.benefit_khy')</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="">
        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
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
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.search')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <label >@lang('lang.excel')</label></span>
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
        <div class="content">
            <div class="tab-pane show" id="tab_Benefit" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer table_banefit" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1">@lang('lang.employee_id')
                                                    </th>
                                                    <th class="sorting sorting_asc stuck" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee: activate to sort column descending">@lang('lang.employee_name')
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee: activate to sort column descending">@lang('lang.gender')
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee: activate to sort column descending">@lang('lang.position')
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee: activate to sort column descending">@lang('lang.location')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">@lang('lang.number_of_working_days')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">@lang('lang.basic_salary')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">@lang('lang.basic_salary_received')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Payslip: activate to sort column ascending">
                                                        @lang('lang.total_allowance')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($benefit) > 0)
                                                    @foreach ($benefit as $item)
                                                        <tr class="odd">
                                                            <td class="stuck"><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                            <td class="stuck"><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeName }}</a></td>
                                                            <td><a href="#">{{ $item->users->EmployeeGender }}</a></td>
                                                            <td><a href="#">{{ $item->users->EmployeePosition }}</a></td>
                                                            <td><a href="#">{{ $item->users->EmployeeBranch }}</a></td>
                                                            <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                            <td>{{ $item->number_of_working_days }} Days</td>
                                                            <td>${{ $item->base_salary }}</td>
                                                            <td>${{ $item->base_salary_received }}</td>
                                                            <td>${{ $item->total_allowance }}</td>
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
            </div>
        </div>
    </div>
</div>
  
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script src="{{ asset('/admin/js/date-range-bicker.js') }}"></script>
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/benefit-report') }}");
        });
        $(".btn-search").on("click", function(){
            $(".btn-search").prop('disabled', true);
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
            var url = "{{URL::to('reports/benefit-export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function showdatas(params) {
        var localeLanguage = '{{ config('app.locale') }}';
        $.ajax({
            type: "post",
            url: "{{ url('reports/benefit-report') }}",
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
                $(".btn-search").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                if (data.length > 0) {
                    data.map((row) => {
                        let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY')
                        let created_at = moment(row.created_at).format('D-MMM-YYYY')
                        tr +='<tr class="odd">'+
                            '<td class="stuck"><a href="#">'+(row.users == null ? '' : row.users.number_employee)+'</a></td>'+
                            '<td class="stuck"><a href="#">'+(localeLanguage == 'en' ? row.users.employee_name_en : row.users.employee_name_kh)+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.name_english  : row.name_khmer )+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.positionNameEnglish  : row.positionNameKhmer )+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.branck_en  : row.branck_kh )+'</a></td>'+
                            '<td>'+(row.users == null ? '' : join_date)+'</td>'+
                            '<td>'+(row.number_of_working_days)+' Days</td>'+
                            '<td>$'+(row.base_salary)+'</td>'+
                            '<td>$'+(row.base_salary_received)+'</td>'+
                            '<td>$'+(row.total_allowance)+'</td>'+
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
                $(".table_banefit tbody").html(tr);
                $("#table_print_filter_benefit tbody").html(tr);
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