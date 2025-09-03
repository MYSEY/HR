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
                    <h3 class="page-title">@lang('lang.performance')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.performance')</li>
                    </ul>
                </div>
                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'HR' || Auth::user()->RolePermission == 'HRAdmin' || Auth::user()->RolePermission == 'developer')
                    <div class="col-auto float-end ms-auto">
                        @if (permissionAccess("m4-s2","is_import")->value == "1")
                            <a href="#" class="btn add-btn" data-toggle="modal" id="importPayroll"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                        @endif
                    </div>
                @endif
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('performance/create')}}" class="btn add-btn me-2"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                </div>
            </div>
        </div>
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
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:void(0);" class="btn btn-sm btn-secondary" id="btnApprovedAll">
                    Approved
                </a>
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkAll" name="checkAll" id="checkAll" onClick="toggle(this)">
                                                    <label class="custom-control-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.from_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.to_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.kip')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.total_weight')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">@lang('lang.action')</th>
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
        <!-- Delete Performane Modal -->
        <div class="modal custom-modal fade" id="delete_performance" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.deleted')!</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('performance/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">

                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Performane Modal -->
    </div>
    <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading Data...</p>
        </div>
    </div>
    @include('performances.import')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
    <script>
        var number_employee = null;
        var employee_name = null;
        var branch_id = null;
        var department_id = null;
        $(function(){
            $("#importPayroll").on("click", function() {
                $(".thanLess").hide();
                $("#thanLess").text("");
                $('#importLeaves').modal('show');
            });
            $('.btn-search').on('click', function() {
                number_employee = $('#employee_id').val();
                employee_name = $('#employee_name').val();
                branch_id = $('#branch_id').val();
                department_id = $('#department_id').val();
                $('#DataTables_Table_0').DataTable().ajax.reload(null, false);
            });
            $('.checkAll').on('click', function(e) {
                if($(this).is(':checked',true)){
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked',false);
                }
            });
            $('body').on('click','#btnApprovedAll',function(){
                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });
                var performance_id = allVals.join(",");
                if(allVals.length <=0)
                {
                    $.alert({
                        title: '@lang("lang.approve")!',
                        content: '@lang("lang.please_select_item_befor").',
                        type: 'blue',
                    });
                }  else {
                    $.confirm({
                        title: 'Approve!',
                        content: '@lang("lang.are_you_sure_want_to_approve")?',
                        type: "blue",
                        buttons: {
                            ok: {
                                text: 'ok',
                                btnClass: 'btn-blue',
                                action: function () {
                                    axios.post('{{ URL("performance/approved/all") }}', {
                                        'performance_id': performance_id,
                                    }).then(function (response) {
                                        if (response.data.success) {
                                            new Noty({
                                                title: "",
                                                text: '@lang("lang.the_process_has_been_successfully")',
                                                type: "success",
                                                icon: true
                                            }).show();
                                            setTimeout(() => {
                                                window.location.replace("{{ URL('performance') }}");
                                            }, 1500);
                                        } else if (response.data.message === 'weight_must_be_exactly') {
                                            new Noty({
                                                title: "",
                                                text: 'Total weight must be exactly 100% before approval.',
                                                type: "error",
                                                icon: true
                                            }).show();
                                            setTimeout(() => {
                                                window.location.replace("{{ URL('performance') }}");
                                            }, 2000);
                                        } else {
                                            new Noty({
                                                title: "",
                                                text: 'Something went wrong. Please try again.',
                                                type: "error",
                                                icon: true
                                            }).show();
                                        }
                                        dataTables();
                                    }).catch(function (error) {
                                        new Noty({
                                            text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                            type: "error",
                                            timeout: 3000,
                                            progressBar: true,
                                        }).show();
                                    });
                                }
                            },
                            cancel: {
                                text: '@lang("lang.cancel")',
                                action: function () {
                                    // Action for cancel button (if needed)
                                }
                            }
                        },
                        onContentReady: function () {
                            var jc = this;
                            this.$content.find('form').on('submit', function (e) {
                                e.preventDefault();
                                jc.$$formSubmit.trigger('click');
                            });
                        }
                    });
                }
            });
            // Initialize only once
            dataTables();
            $(".reset-btn").on("click", function() {
                $(this).prop('disabled', true);
                $(".btn-text-reset").hide();
                $("#btn-text-loading").css('display', 'block');
                window.location.replace("{{ URL('performance') }}");
            });
            $('.performanceDelete').on('click',function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
            $('body').on('click','#btnUpdateStatus',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.confirm({
                    title: 'Approve!',
                    content: '@lang("lang.are_you_sure_want_to_approve")?',
                    type: "blue",
                    buttons: {
                        ok: {
                            text: 'ok',
                            btnClass: 'btn-blue',
                            action: function () {
                                axios.post('{{ URL("performance/approve") }}/'+id).then(function(response) {
                                    if (response.data.success) {
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('performance') }}");
                                    } else if(response.data.message == 'weight_must_be_exactly'){
                                        new Noty({
                                            title: "",
                                            text: 'Total weight must be exactly 100% before approval.',
                                            type: "error",
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('performance') }}");
                                    }
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: '@lang("lang.cancel")',
                            action: function () {
                                // Action for cancel button (if needed)
                            }
                        }
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
            });
        });
        function toggle(source) {
            checkboxes = $('.checkAll');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
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
                    url: '{{ URL("performance") }}',
                    type: 'GET',
                    data: function (d) {
                        d.employee_id = $('input[name="employee_id"]').val();
                        d.employee_name = $('input[name="employee_name"]').val();
                        d.branch_id = $('select[name="branch_id"]').val();
                        d.department_id = $('select[name="department_id"]').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return `<div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                <input type="checkbox" class="custom-control-input sub_chk" name="checkbox" data-id="${data}" id="${data}" value="${data}">
                                <label class="custom-control-label" for="${data}"></label>
                            </div>`;
                        }
                    },
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
                    { data: 'dep_name', name: 'dep_name' },
                    { data: 'positions_name', name: 'positions_name' },
                    { data: 'from_date', name: 'from_date' },
                    { data: 'to_date', name: 'to_date' },
                    { data: 'type', name: 'type' },
                    {
                        data: 'total_weight',
                        name: 'total_weight',
                        render: function (data, type, row) {
                            return data !== null ? data + '%' : '';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            if (row.status === 'preparing') {
                                // Show dropdown if status is prepare
                                return `
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-dot-circle-o text-warning"></i>
                                            <span>Preparing</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" data-id="${row.id}" href="javascript:void(0)" id="btnUpdateStatus">
                                                <i class="fa fa-dot-circle-o text-success"></i>
                                                <span>Approve</span>
                                            </a>
                                        </div>
                                    </div>
                                `;
                            } else {
                                // Show non-clickable Approved label
                                return `
                                    <div class="action-label">
                                        <span class="btn btn-white btn-sm btn-rounded">
                                            <i class="fa fa-dot-circle-o text-success"></i>
                                            Approved
                                        </span>
                                    </div>
                                `;
                            }
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
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url('performance')}}/${row.id}">
                                            <i class="fa fa-regular fa-eye"></i> Preview
                                        </a>
                                        <a href="{{url('/performance')}}/${row.id}/edit" class="dropdown-item" data-id="${row.id}">
                                            <i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')
                                        </a>
                                        <a class="dropdown-item performanceDelete" href="#" data-toggle="modal" data-id="${row.id}" data-target="#delete_performance"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ],
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