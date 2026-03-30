@extends('layouts.master')
<style>
    .big-checkbox .custom-control-input {
        transform: scale(1.5); /* make checkbox 1.5x bigger */
        margin-right: 8px;
    }
    .big-checkbox .custom-control-label {
        font-size: 18px; /* adjust label text if you add one */
    }
    .container-checkbox {
        /* display: block; */
        position: relative;
        padding-left: 25px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
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
                @if ($permission->is_import == 1 || Auth::user()->RolePermission == 'developer')
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" id="importKPI">
                            <i class="fa fa-arrow-circle-up" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-up" data-bs-original-title="fa fa-arrow-circle-up"></i> @lang('lang.import')</a>
                    </div>
                @endif
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_import == 1)
                        <a href="#" class="btn add-btn" data-toggle="modal" id="btnImportResult">
                            <i class="fa fa-arrow-circle-up" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-up" data-bs-original-title="fa fa-arrow-circle-up"></i> Import Result
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="p-6 rounded-lg">
            <div class="flex items-center space-x-8 ">
                <label class="flex items-center pb-4 space-x-2 text-gray-500 hover:text-gray-700 me-3">
                    <span>Pending Review</span>
                    <span id="PendingReview" class="badge bg-secondary px-2 py-0.5 rounded-pill">0</span>
                </label>

                {{-- <label class="flex items-center pb-4 space-x-2 text-gray-500 hover:text-gray-700 me-3">
                    <span>Pending Accepted</span>
                    <span id="PendingAccepted" class="badge bg-secondary px-2 py-0.5 rounded-pill">0</span>
                </label> --}}

                <label class="flex items-center pb-4 space-x-2 text-gray-500 hover:text-gray-700 me-3">
                    <span>Pending Verify</span>
                    <span id="PendingVerify" class="badge bg-secondary px-2 py-0.5 rounded-pill">0</span>
                </label>

                <label class="flex items-center pb-4 space-x-2 text-gray-500 hover:text-gray-700 me-3">
                    <span>Pending Approve</span>
                    <span id="PendingApprove" class="badge bg-secondary px-2 py-0.5 rounded-pill">0</span>
                </label>
                <label class="flex items-center pb-4 space-x-2 text-gray-500 hover:text-gray-700 me-3">
                    <span>Return</span>
                    <span id="PendingReturn" class="badge bg-secondary px-2 py-0.5 rounded-pill">0</span>
                </label>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row filter-btn">
            @if (count($branch)>1)
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group">
                        <select class="select form-control hr-select2-option filter" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                            @foreach ($branch as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            @if (count($department)>1)
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group">
                        <select class="select form-control hr-select2-option filter" id="department_id" data-select2-id="select2-data-2-c0n2" name="department_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_department')</option>
                            @foreach ($department as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group">
                    <select class="select form-control hr-select2-option filter" id="status" data-select2-id="select2-data-2-c09n2" name="status">
                        <option value="">@lang('lang.all') @lang('lang.status')</option>
                        <option value="new">New</option>
                        <option value="preparing">Preparing</option>
                        <option value="1">Pending Review</option>
                        <option value="2">Pending Verify</option>
                        <option value="3">Pending Approve</option>
                        <option value="4">Return</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div style="display: flex" class="float-end">
                    @if ($permission->is_export == 1 || Auth::user()->RolePermission == 'developer')
                        {{-- @if (permissionAccess("m4-s2","is_export")->value == "1") --}}
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                <span class="btn-text-excel"><i class="fa fa-arrow-circle-down"></i></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        {{-- @endif --}}
                    @endif
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
                                                    <th class="sorting sorting_asc stuck-scroll-3">#</th>
                                                    <th class="stuck-scroll-3">@lang('lang.status')</th>
                                                    <th class="sorting stuck-scroll-3">@lang('lang.employee_id')</th>
                                                    <th class="sorting sorting_asc">@lang('lang.employee_name')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.department')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.from_date')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.to_date')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.kpi_year')</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ពិន្ទុ</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">បុគ្គលិកផ្ទាល់</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ប្រធានផ្ទាល់</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Overall Results</th>
                                                    <th>@lang('lang.review_by')</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.asign_to')</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.reason')</th>
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
    @include('performance_appraisal.import')
    @include('performance_appraisal.import_result')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
    <script>
        var number_employee = null;
        const userRole = "{{ Auth::user()->RolePermission }}";
        $(function(){
            dataTables();
            $("#btnImportResult").on("click", function() {
                $(".pa_thanLess").hide();
                $("#pa_thanLess").text("");
                $('#importResult').modal('show');
            });
            $("#importKPI").on("click", function() {
                $(".thanLess").hide();
                $("#thanLess").text("");
                $('#importLeaves').modal('show');
            });
            $(".btn_excel").on("click", function() {
                let query = {
                    branch_id: $("#branch_id").val(),
                    department_id: $("#department_id").val(),
                    employee_id: $("#employee_id").val(),
                    employee_name: $("#employee_name").val(),
                };
                var url = "{{URL::to('performance/appraisal/download')}}?" + $.param(query)
                window.location = url;
            });
            $('.filter').on('change', function() {
                dataTables();
            });
            $(document).on('click','.checkbox-group', function(){
                $(".checkbox-group").not(this).prop("checked", false);
            });
            $('body').on('click', '.btn-asign', function() {
                var pa_id = $(this).data("id");
                var employee_old = $(this).data("name");
                var get_employee_id = $(this).data("employeeid");
                var status = $(this).data("status");
                var actionBtn = "";
                var titleText = "";
                var formContent = "";
                var columnClassText = 'col-md-4';
                if (status == "new" || status == 1 || status == 2 || status == 3 || status == 4) {
                    titleText = '@lang("lang.asign_to_employee")';
                    columnClassText = 'col-md-6'
                    formContent = ''+
                        '<form id="add-style">'+
                            '<div class="mt-2">'+
                                '<label class="container-checkbox">Review'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="1"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Verify'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="2"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Approve'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="3"> <span class="checkmark"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.employee")</label>'+
                                '<select class="form-control hr-select2-option-emp-role form-select asign_employee_id" id="asign_employee_id">'+

                                '</select>'+
                            '</div>'+
                            '<div class="form-group">' +
                                '<label>@lang("lang.remark")</label>' +
                                '<textarea class="form-control remark" rows="4" placeholder="Enter remark..."></textarea>' +
                            '</div>' +
                        '</form>';
                    actionBtn = {
                        text: 'Submit',
                        btnClass: 'btn-green',
                        action: function() {
                            this.$content.find('.remark').css("border-color","#e3e3e3");
                            var asign_employee_id = this.$content.find('.asign_employee_id').val();
                            let actionAsign = this.$content.find('.action-asign:checked').val();
                            let remark = this.$content.find('.remark').val();
                            if (!actionAsign) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Check action for asign!',
                                });
                                return false;
                            }
                            if (!asign_employee_id) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Please select employee for asign!',
                                });
                                return false;
                            }
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL("performance-appraisal/asign") }}', {
                                'id': pa_id,
                                'actionAsign': actionAsign,
                                'asign_employee_id': asign_employee_id,
                                'reason': remark,
                            }).then(function(response) {
                                $('#modal-loading').modal('hide');
                                if (response.data.success) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    window.location.replace("{{ URL('performance-appraisal') }}");
                                } else if(response.data.message == 'weight_must_be_exactly'){
                                    new Noty({
                                        title: "",
                                        text: 'Total weight must be exactly 100% before approval.',
                                        type: "error",
                                        icon: true,
                                        timeout: 3000,
                                    }).show();
                                }
                            }).catch(function(error) {
                                $('#modal-loading').modal('hide');
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                    type: "error",
                                    icon: true,
                                    timeout: 3000,
                                }).show();
                            });
                        }
                    }
                }
                if (status === 3) {
                    titleText = '@lang("lang.employee_pa")';
                    formContent = ''+
                        '<form>'+
                            '<span >Are you sure want to Approved or Return?</span>'+
                            '<div class="form-group">' +
                                '<label>@lang("lang.remark") <span class="text-danger">*</span></label>' +
                                '<textarea class="form-control remark" rows="4" placeholder="Enter remark..."></textarea>' +
                            '</div>' +
                        '</form>';
                    actionBtn =  {
                        text: 'Approve',
                        btnClass: 'btn-green',
                        action: function() {
                            let remark = this.$content.find('.remark').val();
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL("performance-appraisal/approved") }}', {
                                'id': pa_id,
                                'actionAsign': "approved",
                                'reason': remark,
                            }).then(function(response) {
                                $('#modal-loading').modal('hide');
                                if (response.data.success) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    window.location.replace("{{ URL('performance-appraisal') }}");
                                } else if(response.data.message == 'weight_must_be_exactly'){
                                    new Noty({
                                        title: "",
                                        text: 'Total weight must be exactly 100% before approval.',
                                        type: "error",
                                        icon: true,
                                        timeout: 3000,
                                    }).show();
                                }
                            }).catch(function(error) {
                                $('#modal-loading').modal('hide');
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                    type: "error",
                                    icon: true,
                                    timeout: 3000,
                                }).show();
                            });
                        }
                    }
                }
                $.confirm({
                    title: titleText,
                    contentClass: 'text-center',
                    columnClass: columnClassText,
                    content: formContent,
                    buttons: {
                        confirm: actionBtn,
                        danger: {
                            text: 'Return',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var asign_employee_id = this.$content.find('.asign_employee_id').val();
                                let remark = this.$content.find('.remark').val();
                                if (!remark) {
                                    this.$content.find('.remark').css("border-color","#dc3545");
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                        content: 'Please to remark!',
                                    });
                                    return false;
                                }
                                $('#modal-loading').modal('show');
                                axios.post('{{ URL("performance-appraisal/return") }}', {
                                    'id': pa_id,
                                    'actionAsign': 4,
                                    'asign_employee_id': asign_employee_id,
                                    'reason': remark,
                                }).then(function(response) {
                                    $('#modal-loading').modal('hide');
                                    if (response.data.success) {
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('performance-appraisal') }}");
                                    } else if(response.data.message == 'weight_must_be_exactly'){
                                        new Noty({
                                            title: "",
                                            text: 'Total weight must be exactly 100% before approval.',
                                            type: "error",
                                            icon: true,
                                            timeout: 3000,
                                        }).show();
                                    }
                                }).catch(function(error) {
                                    $('#modal-loading').modal('hide');
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true,
                                        timeout: 3000,
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    },
                    onContentReady: function() {
                        var jc = this;
                        this.$content.find('form').on('submit', function(e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
                $(document).ready(function(){
                    $('.hr-select2-option-emp-role').each(function() {
                        $(this).select2({
                            width: '100%',
                            dropdownParent: $(this).parent(),
                        })
                    });
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/performance-admin/employees') }}",
                        data: {
                            'get_employee_id': get_employee_id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            let datas = response.datas;
                            $('#asign_employee_id').html('<option selected value=""> -- @lang("lang.select") --</option>');
                            if (datas != '') {
                                $.each(datas, function(i, item) {
                                    $('#asign_employee_id').append($('<option>', {
                                        value: item.id,
                                        html: item.employee_name_en + '&nbsp;&nbsp;' + '(' + '&nbsp;'+ item.department.name_english + '&nbsp;)'
                                    }));
                                });
                            }
                        }
                    });
                });
            });
        });
        function strLimit(str, limit = 30, end = '...') {
            return str.length > limit ? str.substring(0, limit) + end : str;
        }
        function dataTables() {
            // $('#loading-overlay').show();
            // // Check if DataTable instance exists, then destroy it
            // if ($.fn.DataTable.isDataTable('#DataTables_Table_0')) {
            //     $('#DataTables_Table_0').DataTable().clear().destroy();
            // }
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
                        d.department_id = $('select[name="department_id"]').val();
                        d.status = $('select[name="status"]').val();
                    },
                    dataSrc: function (json) {
                        $('#PendingReview').text(json.pendingReview || 0);
                        // $('#PendingAccepted').text(json.pendingAccepted || 0);
                        $('#PendingVerify').text(json.pendingVerify || 0);
                        $('#PendingApprove').text(json.pendingApprove || 0);
                        $('#PendingReturn').text(json.pendingReturn || 0);
                        userPermission = json.permission || {}; // 👈 Save permission
                        userIdLog = json.userIdLog;
                        return json.data;
                    }
                },
                "order": [
                    { "column": "2", "dir": "asc" }
                ],
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'stuck-scroll-3',
                        render: function (data, type, row) {
                            let statusText = "";
                            if (row.status == "new") {
                                statusText = '<span class="badge bg-inverse-info" style="font-size: 13px;">New</span>';
                            }
                            if (row.status == "preparing") {
                                statusText = '<span class="badge bg-inverse-info" style="font-size: 13px;">Preparing</span>';
                            }
                            if (row.status == "1") {
                                statusText = '<span class="badge bg-inverse-info" style="font-size: 13px;">Pending Review</span>';
                            }
                            if (row.status == "2") {
                                statusText = '<span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Verify</span>';
                            }
                            if (row.status == "3") {
                                statusText = '<span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Approve</span>';
                            }
                            if (row.status == "4") {
                                statusText = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Return</span>';
                            }
                            if (row.status == "approved") {
                                statusText = '<span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>';
                            }
                            return `
                                ${statusText}
                            `;
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
                                color = 'green';
                            } else {
                                overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
                                color = 'green';
                            }
                            return `<span style="color:${color}">${overallResults}</span>`;
                        }
                    },
                    {
                        data: 'review_employee_name_en',
                        name: 'review_by',
                        render: function (data, type, row) {
                            return row.review_employee_name_en;
                        }
                    },
                    {
                        data: null,
                        name: 'asign_to',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            let textBtn = "@lang('lang.asign_to')";
                            if (row.status == 3) {
                                textBtn = "@lang('lang.approved')";
                            }
                            if ((userIdLog == data.employee_id && (row.status =="new" || row.status =="4")) || userIdLog == data.review_employee_id) {
                                return `
                                    <a class="btn btn-white btn-sm btn-rounded btn-asign"
                                    data-id="${row.id}"
                                    data-name="${row.review_employee_name_en}"
                                    data-employeeid="${row.employee_id}"
                                    data-status="${row.status}"
                                    href="#" aria-expanded="false">
                                        <i class="fa fa-dot-circle-o text-success"></i>
                                        <span>${textBtn}</span>
                                    </a>
                                `;
                            } else {
                                return `
                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                        <i class="fa fa-dot-circle-o text-danger"></i> <span>You can't asign</span>
                                    </a>
                                `;
                            }
                        }
                    },
                    {
                        data: 'reason',
                        defaultContent: '',
                        render: function (data, type, row) {

                            if (!data) return '';
                            return `
                                <span data-toggle="tooltip"
                                    data-html="true"
                                    title="${data}">
                                    ${strLimit(data, 30, '...')}
                                </span>
                            `;
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            let actionHtml = `
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ url('performance-appraisal-preview') }}/${row.id}">
                                            <i class="fa fa-regular fa-eye"></i> Preview
                                        </a>
                            `;
                            if ((userIdLog == data.employee_id && (row.status =="new" || row.status =="4")) || (userPermission.is_update == 1  && (userIdLog == data.review_employee_id && row.status =="new"))){
                                actionHtml += `
                                    <a class="dropdown-item" href="{{ url('performance-appraisal') }}/${row.id}">
                                        <i class="fa fa-regular fa-pencil"></i> Update Progress
                                    </a>
                                `;
                            }
                            if (userPermission.is_export == 1) {
                                actionHtml += `
                                            <a class="dropdown-item" href="{{ url('performance/appraisal/export') }}/${row.id}">
                                                <i class="fa fa-regular fa-download"></i> Export Template
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }

                            return actionHtml;
                        }
                    }
                ],
                order: [[0, 'desc']],
                initComplete: function() {
                    $('#loading-overlay').hide(); // Hide spinner when data is fully loaded
                }
            });

            // $('#DataTables_Table_0').on('processing.dt', function (e, settings, processing) {
            //     if (processing) {
            //         $('#loading-overlay').show();
            //     } else {
            //         $('#loading-overlay').hide();
            //     }
            // });
        }
    </script>
@endsection
