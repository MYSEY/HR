@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .content-title {
        border-bottom: 1px solid #ccc;
        padding-top: 6px;
        padding-bottom: 5px;
        color: #983D3A;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.import_severance_pay')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.import_severance_pay')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("13","is_import")->value == "1")
                        <a href="#" class="btn add-btn" data-toggle="modal" id="importSeverancePay"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    @endif
                </div>
            </div>
        </div>

        @if (permissionAccess("13","is_view")->value == "1")
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
                    {{-- <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group ">
                            <input class="form-control" type="month" id="filter_month">
                        </div>
                    </div> --}}
                    <div class="col-sm-6 col-md-6">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.search')</span>
                            </button>
                            @if (permissionAccess("13","is_export")->value == "1")
                                <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                    <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> @lang('lang.excel')</span>
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
            {!! Toastr::message() !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable dataTable no-footer table_severance_pay" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">@lang('lang.employee_name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.department')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')</th>
                                                <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.fdc_start_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.basic_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.total_gross_salary')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.payment_date')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data)>0)
                                                @foreach ($data as $item)
                                                    <tr class="odd">
                                                        <td class="stuck-scroll-3"><a href="#">{{ $item->users == null ? '' : $item->users->number_employee}}</a></td>
                                                        <td class="stuck-scroll-3"><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeName}}</span></a></td>
                                                        <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeePosition}}</a></td>
                                                        <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeDepartment}}</a></td>
                                                        <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeBranch }}</a></td>
                                                        <td>{{ $item->users == null ? '' : $item->users->joinOfDate}}</td>
                                                        <td>{{ $item->users == null ? '' : $item->users->UDCStartDate}}</td>
                                                        <td>${{$item->basic_salary}}</td>
                                                        <td>${{$item->total_fdc1}}</td>
                                                        <td>{{$item->PayrollPaymentDate}}</td>
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
        @endif
        @include('severance_pays.import_severance_pay')
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $("#importSeverancePay").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#importSeverancePayModal').modal('show');
        });
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('severance-pay') }}");
        });
        $(".btn-search").on("click", function(){
            $(".btn-search").prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block')
            let params = {
                branch_id: $("#branch_id").val(),
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
            };
            showdatas(params);
        });
    });

    function showdatas(params) {
        var localeLanguage = '{{ config('app.locale') }}';
        $.ajax({
            type: "post",
            url: "{{ url('/severance-pay') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name: params.employee_name ? params.employee_name : null,
                branch_id: params.branch_id ? params.branch_id : null
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
                        let contract_deadline = moment(row.users.fdc_end).format('D-MMM-YYYY')
                        let payment_date = moment(row.payment_date).format('D-MMM-YYYY')
                        tr +='<tr class="odd">'+
                            '<td><a href="#">'+(row.users == null ? '' : row.users.number_employee)+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.users.employee_name_en : row.users.employee_name_kh )+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.position_name_english : row.position_name_khmer )+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.depart_name_en : row.depart_name_kh )+'</a></td>'+
                            '<td><a href="#">'+(localeLanguage == 'en' ? row.branch_name_en  : row.branch_name_kh )+'</a></td>'+
                            '<td>'+(row.users == null ? '' : join_date)+'</td>'+
                            '<td>'+(row.users == null ? '' : contract_deadline)+'</td>'+
                            '<td>'+(row.basic_salary)+'</td>'+
                            '<td>$'+(row.total_fdc1)+'</td>'+
                            '<td>'+(payment_date)+'</td>'+
                        '</tr>';
                    });
                }else {
                    if(localeLanguage == 'en'){
                        var tr = '<tr><td colspan=15 align="center">No data available in table</td></tr>';
                    }else{
                        var tr = '<tr><td colspan=15 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                    }
                }
                $(".table_severance_pay tbody").html(tr);
            }
        });
    }
</script>