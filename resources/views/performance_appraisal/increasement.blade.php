@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.generate_annual_salary_increasement')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.generate_annual_salary_increasement')</li>
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
                <div class="form-group ">
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
                                <table id="DataTables_Table_0" class="table table-striped custom-table mb-0 datatable dataTable no-footer" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-4">#</th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="location: activate to sort column ascending">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="department: activate to sort column ascending">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="position: activate to sort column ascending">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="date_of_commencement: activate to sort column ascending">@lang('lang.date_of_commencement')</th>
                                            {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="basic_salary: activate to sort column ascending">@lang('lang.basic_salary')</th> --}}
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ពិន្ទុ</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">បុគ្គលិកផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ប្រធានផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.salary_increasement')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr class="odd">
                                                <td class="ids stuck-scroll-4">{{$item->id}}</td>
                                                <td class="stuck-scroll-4"><a href="{{url("performance",$item->employee_id)}}">{{$item->number_employee}}</a></td>
                                                <td class="stuck-scroll-4"><a href="">{{$item->employee_name_en}}</a></td>
                                                <td>{{$item->branch_name_en}}</td>
                                                <td>{{$item->dep_name}}</td>
                                                <td>{{$item->positions_name}}</td>
                                                <td>{{$item->date_of_commencement}}</td>
                                                {{-- <td>{{$item->basic_salary}}</td> --}}
                                                <td><span class="badge bg-inverse-success">{{$item->total_score}}</span></td>
                                                <td><span class="badge bg-inverse-success">{{$item->total_score_live_staff}}</span></td>
                                                <td><span class="badge bg-inverse-success">{{$item->total_score_direct_chairman}}</span></td>
                                                <td>
                                                    {{Helper::calculationSalaryIncreasement($item->total_score_direct_chairman,$item->basic_salary,$item->date_of_commencement)}}
                                                </td>
                                            </tr>
                                        @endforeach
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
<script>
    // $(document).ready(function () {
    //     // Initialize only once
    //     initDataTable();

    //     // Reload only (DON'T destroy/reinit)
    //     $('.btn-search').on('click', function() {
    //         $('#tbl_performance_appraisal').DataTable().ajax.reload(null, false);
    //     });
    // });

    function initDataTable() {
        $('#tbl_performance_appraisal').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            ajax: {
                url: '{{ URL("performance-appraisal") }}',
                type: 'GET',
                data: function (d) {
                    d.employee_id = $('input[name="employee_id"]').val();
                    d.employee_name = $('input[name="employee_name"]').val();
                    d.branch_id = $('select[name="branch_id"]').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'number_employee', name: 'number_employee' },
                { data: 'employee_name_kh', name: 'employee_name_kh' },
                { data: 'branch_name_en', name: 'branch_name_en' },
                { data: 'dep_name', name: 'dep_name' },
                { data: 'positions_name', name: 'positions_name' },
                { data: 'from_date', name: 'from_date' },
                { data: 'to_date', name: 'to_date' },
                { data: 'type', name: 'type' },
                {
                    data: 'total_score',
                    name: 'total_score',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data}</span>`;
                    }
                },
                {
                    data: 'total_score_live_staff',
                    name: 'total_score_live_staff',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data}</span>`;
                    }
                },
                {
                    data: 'total_score_direct_chairman',
                    name: 'total_score_direct_chairman',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data}</span>`;
                    }
                },
                { data: 'overall_results', name: 'overall_results' },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="javascript:void(0)">
                                <i class="fa fa-dot-circle-o text-success"></i>
                                <span>${ row.status == 'approve' ? 'Approved' : '' }</span>
                            </a>
                        `;
                    }
                },
                {
                    data: null,
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{url('performance-appraisal')}}/${row.id}">
                                        <i class="fa fa-regular fa-eye"></i> Preview
                                    </a>
                                </div>
                            </div>
                        `;
                    }
                }
            ],
            initComplete: function() {
                $('#loading-overlay').hide();
            }
        });

        $('#tbl_performance_appraisal').on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#loading-overlay').show();
            } else {
                $('#loading-overlay').hide();
            }
        });
    }
</script>