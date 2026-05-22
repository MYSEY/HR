@extends('layouts.master')
<style>
    .big-checkbox .custom-control-input {
        transform: scale(1.5); /* make checkbox 1.5x bigger */
        margin-right: 8px;
    }
    .big-checkbox .custom-control-label {
        font-size: 18px; /* adjust label text if you add one */
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.report_annual_bonus')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.report_annual_bonus')</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row filter-btn"> 
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                <div class="form-group">
                    <div class="search">
                        <i class="uil uil-search"></i>
                        <input spellcheck="false" id="employee_id" name="employee_id" class="form-control" type="text" placeholder="Employee ID">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                @if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO']))
                    <div class="form-group">
                        <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                            @foreach ($branch as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-sm-2 col-md-2">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-txt"><i class="fa fa-search"></i></span>
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                        <span class="btn-text-excel"><i class="fa fa-arrow-circle-down"></i></span>
                        <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                        <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="tbl_report_annual_bonus" class="table table-striped custom-table mb-0 datatable dataTable no-footer" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="location: activate to sort column ascending">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="department: activate to sort column ascending">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="position: activate to sort column ascending">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="date_of_commencement: activate to sort column ascending">@lang('lang.date_of_commencement')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="basic_salary: activate to sort column ascending">@lang('lang.basic_salary')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="total_working_day: activate to sort column ascending">Total Working Day</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="incentive: activate to sort column ascending">%​ប្រាក់លើកទឹកចិត្ត</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="pa_score: activate to sort column ascending">PA Score</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="of_incentive_by_pa: activate to sort column ascending">% of Incentive by PA</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="achieved_vs_pa: activate to sort column ascending">% សម្រេចធៀបនឹង%PA</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="number_months_received: activate to sort column ascending">Number of months to be received</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Annual incentive allowance</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script>
    $(function(){
        var number_employee = null;
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('report/annual/bonus') }}");
        });
        $(".btn_excel").on("click", function() {
            let query = {
                branch_id: $("#branch_id").val(),
                department_id: $("#department_id").val(),
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
            };
            var url = "{{URL::to('report/annual/bonus/download')}}?" + $.param(query)
            window.location = url;
        });
        $('.btn-search').on('click', function() {
            $('#tbl_report_annual_bonus').DataTable().ajax.reload(null, false);
        });
        
        dataTables();
    });
    function dataTables() {
        $('#loading-overlay').show();
        $('#tbl_report_annual_bonus').DataTable({
            destroy: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            ajax: {
                url: '{{ URL("report/annual/bonus") }}',
                type: 'GET',
                data: function (d) {
                    d.employee_id = $('input[name="employee_id"]').val();
                    d.employee_name = $('input[name="employee_name"]').val();
                    d.branch_id = $('select[name="branch_id"]').val();
                    d.department_id = $('select[name="department_id"]').val();
                },
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'stuck-scroll-3',
                },
                { 
                    data: 'number_employee', 
                    name: 'number_employee',
                    className: 'stuck-scroll-3',
                },
                { 
                    data: 'employee_name_kh', 
                    name: 'employee_name_kh',
                    className: 'stuck-scroll-3',
                },
                { data: 'branch_name_en', name: 'branch_name_en' },
                { data: 'dep_name', name: 'dep_name' },
                { data: 'positions_name_kh', name: 'positions_name_kh' },
                {
                    data: 'date_of_commencement',
                    name: 'date_of_commencement'
                },
                {
                    data: 'basice_salary',
                    name: 'basice_salary'
                },
                {
                    data: 'working_days_per_year',
                    name: 'working_days_per_year'
                },
                {
                    data: 'incentive',
                    name: 'incentive',
                    render: function(data, type, row) {
                        return data + '%';
                    }
                },
                {
                    data: 'total_score_direct_chairman',
                    name: 'total_score_direct_chairman',
                    render: function(data, type, row) {
                        return Number(data).toFixed(2);
                    }
                },
                {
                    data: 'of_incentive_by_pa',
                    name: 'of_incentive_by_pa',
                    render: function(data, type, row) {
                        return data + '%';
                    }
                },
                {
                    data: 'achieved_vs_pa',
                    name: 'achieved_vs_pa',
                    render: function(data, type, row) {
                        return data + '%';
                    }
                },
                {
                    data: 'number_months_received',
                    name: 'number_months_received'
                },
                {
                    data: 'total_annaul_bounus',
                    name: 'total_annaul_bounus',
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<span class="badge bg-inverse-info" style="font-size: 13px;">${data === "pending" ? "Pending" : "Approved"}</span>`;
                    }
                }
            ],
            initComplete: function() {
                $('#loading-overlay').hide();
            }
        });
        $('#tbl_report_annual_bonus').on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#loading-overlay').show();
            } else {
                $('#loading-overlay').hide();
            }
        });
    }
</script>
@endsection