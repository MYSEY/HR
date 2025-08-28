@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.performance_appraisal')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.performance_appraisal')</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row filter-btn"> 
            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                <div class="form-group">
                    <div class="search">
                        <i class="uil uil-search"></i>
                        <input spellcheck="false" id="employee_id" name="employee_id" class="form-control" type="text" placeholder="Employee ID">
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group ">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                @if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO']))
                    <div class="form-group">
                        <select class="select form-control hr-select2-option" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                            @foreach ($branch as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                @if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO']))
                    <div class="form-group">
                        <select class="select form-control hr-select2-option" id="department_id" data-select2-id="select2-data-2-c0n2" name="department_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_department')</option>
                            @foreach ($department as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-sm-2 col-md-2">
                <div style="display: flex">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-txt"><i class="fa fa-search"></i></span>
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    {{-- @if (permissionAccess("m4-s2","is_export")->value == "1")
                        <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                            <span class="btn-text-excel"><i class="fa fa-arrow-circle-down"></i></span>
                            <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    @endif --}}
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                        <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc stuck-scroll-4">#</th>
                                                    <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                                    <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.department')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.from_date')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.to_date')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.type')</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ពិន្ទុ</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">បុគ្គលិកផ្ទាល់</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ប្រធានផ្ទាល់</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Overall Results</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.status')</th>
                                                    <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
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
        var number_employee = null;
        $(function(){
            // Reload only (DON'T destroy/reinit)
            $('.btn-search').on('click', function() {
                number_employee = $('#employee_id').val();
                employee_name = $('#employee_name').val();
                branch_id = $('#branch_id').val();
                $('#DataTables_Table_0').DataTable().ajax.reload(null, false);
            });
            // Initialize only once
            dataTables();
            $(".reset-btn").on("click", function() {
                $(this).prop('disabled', true);
                $(".btn-text-reset").hide();
                $("#btn-text-loading").css('display', 'block');
                window.location.replace("{{ URL('performance-appraisal') }}");
            });
        });

        function dataTables() {
            $('#loading-overlay').show();
            // Check if DataTable instance exists, then destroy it
            if ($.fn.DataTable.isDataTable('#DataTables_Table_0')) {
                $('#DataTables_Table_0').DataTable().clear().destroy();
            }
            $('#DataTables_Table_0').DataTable({
                destroy: true,
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
                "order": [
                    { "column": "2", "dir": "asc" }
                ],
                columns: [
                    { data: 'id', name: 'id' },
                    { 
                        data: 'number_employee', 
                        name: 'number_employee',
                        className: 'stuck-scroll-3',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'employee_name_kh', 
                        name: 'employee_name_kh',
                        className: 'stuck-scroll-3',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'branch_name_en', 
                        name: 'branch_name_en',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'dep_name', 
                        name: 'dep_name',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'positions_name', 
                        name: 'positions_name',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'from_date', 
                        name: 'from_date',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'to_date', 
                        name: 'to_date',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'type', 
                        name: 'type',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'total_score',
                        name: 'total_score',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            return `<span class="badge bg-inverse-success">${data}</span>`;
                        }
                    },
                    {
                        data: 'total_score_live_staff',
                        name: 'total_score_live_staff',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            return `<span class="badge bg-inverse-success">${data}</span>`;
                        }
                    },
                    {
                        data: 'total_score_direct_chairman',
                        name: 'total_score_direct_chairman',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            return `<span class="badge bg-inverse-success">${data}</span>`;
                        }
                    },
                    {
                        data: 'overall_results',
                        name: 'overall_results',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            let overallResults = '';
                            let color = '';
                            let score = parseFloat(row.total_score_direct_chairman);

                            if (score === 0.00) {
                                overallResults = '';
                            } else if (score < 2) {
                                overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
                                color = 'red';
                            } else if (score <= 2.99) {
                                overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
                                color = 'orange';
                            } else if (score <= 3.99) {
                                overallResults = 'ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
                                color = 'info';
                            } else if (score <= 4.99) {
                                overallResults = 'ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)';
                                color = 'lightgreen';
                            } else {
                                overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
                                color = 'green';
                            }
                            return `<span style="color:${color}">${overallResults}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return `
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="javascript:void(0)">
                                    <i class="fa fa-dot-circle-o text-success"></i>
                                    <span>${ row.status == 'approved' ? 'Approved' : '' }</span>
                                </a>
                            `;
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return `
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url('performance')}}/${row.id}">
                                            <i class="fa fa-regular fa-eye"></i> Preview
                                        </a>
                                        <a class="dropdown-item" href="{{url('performance-appraisal')}}/${row.id}">
                                            <i class="fa fa-regular fa-eye"></i> Progress KPI
                                        </a>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ],
                order: [[0, 'desc']],
                initComplete: function() {
                    $('#loading-overlay').hide(); // Hide spinner when data is fully loaded
                }
            });

            $('#DataTables_Table_0').on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    $('#loading-overlay').show();
                } else {
                    $('#loading-overlay').hide();
                }
            });
        }
    </script>
@endsection