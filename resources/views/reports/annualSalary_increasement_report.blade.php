@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.annual_salary_increasement_report')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.annual_salary_increasement_report')</li>
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
                     {{-- @if ($permission->is_export == "1") --}}
                        <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                            <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                            <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    {{-- @endif --}}
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
                                <table id="tbl_annual_salary_increas" class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="location: activate to sort column ascending">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="department: activate to sort column ascending">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="position: activate to sort column ascending">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="date_of_commencement: activate to sort column ascending">@lang('lang.date_of_commencement')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ពិន្ទុ</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">បុគ្គលិកផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ប្រធានផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 50.825px;">@lang('lang.salary_increasement')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="salary request: activate to sort column ascending" style="width: 50.825px;">@lang('lang.salary_request')</th>
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

    <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading Data...</p>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script>
    $(function(){
        // Initialize only once
        dataTables();
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('report/annual/salary/increasement') }}");
        });
        $('.btn-search').on('click', function() {
            number_employee = $('#employee_id').val();
            employee_name = $('#employee_name').val();
            branch_id = $('#branch_id').val();
            department_id = $('#department_id').val();
            $('#tbl_annual_salary_increas').DataTable().ajax.reload(null, false);
        });
        $(".btn_excel").on("click", function () {
            let currentPage = $(".per_page").val();
            let query = {
                "_token": "{{ csrf_token() }}",
                number_employee: $('#employee_id').val(),
                employee_name: $('#employee_name').val(),
                branch_id: $('#branch_id').val(),
                department_id: $('#department_id').val(),
            };
            var url = "{{URL::to('report/annual/salary/export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function dataTables() {
        $('#loading-overlay').show();
        if ($.fn.DataTable.isDataTable('#tbl_annual_salary_increas')) {
            $('#tbl_annual_salary_increas').DataTable().clear().destroy();
        }
        $('#tbl_annual_salary_increas').DataTable({
            destroy: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            ajax: {
                url: '{{ URL("report/annual/salary/increasement") }}',
                type: 'GET',
                data: function (d) {
                    d.employee_id = $('input[name="employee_id"]').val();
                    d.employee_name = $('input[name="employee_name"]').val();
                    d.branch_id = $('select[name="branch_id"]').val();
                    d.department_id = $('select[name="department_id"]').val();
                }
                // dataSrc: function (json) {
                //     console.log("Data:", json.data);
                //     return json.data;
                // }
            },
            columns: [
                { data: 'number_employee', name: 'number_employee' },
                { data: 'employee_name_kh', name: 'employee_name_kh' },
                { data: 'branch_name_en', name: 'branch_name_en' },
                { data: 'dep_name', name: 'dep_name' },
                { data: 'positions_name', name: 'positions_name' },
                {
                    data: 'date_of_commencement',
                    name: 'date_of_commencement'
                },
                {
                    data: 'total_score',
                    name: 'total_score',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data == null ? '0.00' : data}</span>`;
                    }
                },
                {
                    data: 'total_score_live_staff',
                    name: 'total_score_live_staff',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data == null ? '0.00' : data}</span>`;
                    }
                },
                {
                    data: 'total_score_direct_chairman',
                    name: 'total_score_direct_chairman',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data == null ? '0.00' : data}</span>`;
                    }
                },
                {
                    data: 'salary_increasement',
                    name: 'salary_increasement',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data}</span>`;
                    }
                },
                {
                    data: 'salary_request',
                    name: 'salary_request',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data}</span>`;
                    }
                }
            ],
            initComplete: function() {
                $('#loading-overlay').hide();
            }
        });
        $('#tbl_annual_salary_increas').on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#loading-overlay').show();
            } else {
                $('#loading-overlay').hide();
            }
        });
    }
</script>
@endsection