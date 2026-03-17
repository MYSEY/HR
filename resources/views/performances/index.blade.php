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
                <a href="javascript:void(0);" class="btn btn-sm btn-secondary mb-3" id="btnAssignAll">
                    Assign All
                </a>
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="tbl_performance" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkAll" name="checkAll" id="checkAll" onClick="toggle(this)">
                                                    <label class="custom-control-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.status')</th>
                                            <th class="sorting stuck-scroll-3">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-3">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.from_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.to_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.kpi_year')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.total_weight')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" >@lang('lang.incharge_by')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.reason')</th>
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
        <div class="modal custom-modal fade" id="deleteModal" role="dialog">
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
                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
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
    @include('performances.import')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
    <script>
        window.rolePermission = "{{ Auth::user()->RolePermission }}";
        window.userId = "{{ Auth::user()->id }}";
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
                $('#tbl_performance').DataTable().ajax.reload(null, false);
            });
            $('.checkAll').on('click', function(e) {
                if($(this).is(':checked',true)){
                    $(".sub_chk:not(:disabled)").prop("checked", true);
                } else {
                    $(".sub_chk:not(:disabled)").prop("checked", false);
                }
            });
            $('body').on('click', '#btnAsignTo', function() {
                var id = $(this).data("id");
                var employee_old = $(this).data("name");
                var get_employee_id = $(this).data("employeeid");
                var status = $(this).data("status");
                var actionBtn = "";
                var titleText = "";
                var formContent = "";
                var columnClassText = 'col-md-4';
                if (status == "accepted") {
                    titleText = '@lang("lang.asign_to")';
                    columnClassText = 'col-md-6'
                    formContent = ''+
                        '<form id="add-style">'+
                            '<div class="mt-2">'+
                                '<label class="container-checkbox">Review'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="1"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.employee")</label>'+
                                '<select class="select form-control hr-select2-option employee_id" id="employee_id">'+
                                    '<option value="">-- @lang("lang.select") --</option>'+
                                    '@foreach ($employee as $item)'+
                                        '<option value="{{ $item->id }}">{{ $item->employee_name_en }}</option>'+
                                    '@endforeach'+
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
                            var employee_id = this.$content.find('.employee_id').val();
                            let status = this.$content.find('.action-asign:checked').val();
                            let remark = this.$content.find('.remark').val();
                            if (!status) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Check action for asign!',
                                });
                                return false;
                            }
                            if (!employee_id) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Please select employee for asign!',
                                });
                                return false;
                            }
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL("performance/assign") }}', {
                                'id': id,
                                'status': status,
                                'employee_id': employee_id,
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
                                    window.location.replace("{{ URL('performance') }}");
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
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    },
                    onContentReady: function () {
                        // ✅ Initialize Select2 inside the modal
                        this.$content.find('.hr-select2-option').select2({
                            width: '100%',
                            dropdownParent: this.$content, // <-- IMPORTANT
                            placeholder: '-- Select Employee --'
                        });
                    }
                });
            });

            $('body').on('click','#btnAssignAll',function(){
                var id = $(this).data("id");
                var employee_old = $(this).data("name");
                var get_employee_id = $(this).data("employeeid");
                var status = $(this).data("status");
                
                var userid = $(this).data("userid");
                var allVals = [];
                $(".sub_chk:checked:not(:disabled)").each(function() {
                    allVals.push($(this).attr('data-id'));
                });
                
                var performance_id = allVals.join(",");
                if(allVals.length <=0)
                {
                    $.alert({
                        title: '@lang("lang.assign")!',
                        content: '@lang("lang.please_select_item_befor").',
                        type: 'red',
                    });
                }  else {
                    var actionBtn = "";
                    var titleText = "";
                    var formContent = "";
                    var columnClassText = 'col-md-4';
                    titleText = '@lang("lang.asign_to_employee")';
                    columnClassText = 'col-md-6'
                    formContent = ''+
                        '<form id="add-style">'+
                            '<div class="mt-2">'+
                                '<label class="container-checkbox">Review'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="1"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.employee")</label>'+
                                '<select class="select form-control hr-select2-option employee_id" id="employee_id">'+
                                    '<option value="">-- @lang("lang.select") --</option>'+
                                    '@foreach ($employee as $item)'+
                                        '<option value="{{ $item->id }}">{{ $item->employee_name_en }}</option>'+
                                    '@endforeach'+
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
                            var employee_id = this.$content.find('.employee_id').val();
                            let status = this.$content.find('.action-asign:checked').val();
                            let remark = this.$content.find('.remark').val();
                            if (!status) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Check action for asign!',
                                });
                                return false;
                            }
                            if (!employee_id) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Please select employee for asign!',
                                });
                                return false;
                            }
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL("performance/assign/all") }}', {
                                'performance_id': performance_id,
                                'status': status,
                                'employee_id': employee_id,
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
                                    window.location.replace("{{ URL('performance-admin') }}");
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
                    $.confirm({
                        title: titleText,
                        contentClass: 'text-center',
                        columnClass: columnClassText,
                        content: formContent,
                        buttons: {
                            confirm: actionBtn,
                            cancel: {
                                text: '@lang("lang.cancel")',
                                action: function () {
                                    // Action for cancel button (if needed)
                                }
                            }
                        },
                        onContentReady: function () {
                            // ✅ Initialize Select2 inside the modal
                            this.$content.find('.hr-select2-option').select2({
                                width: '100%',
                                dropdownParent: this.$content, // <-- IMPORTANT
                                placeholder: '-- Select Employee --'
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
            $(document).on('click', '.performanceDelete', function (e) {
                let id = $(this).data("id");
                $('.e_id').val(id);
                $('#deleteModal').modal('show');
            });

            $('body').on('click', '#btnAccepted', function () {
                const id = $(this).data("id");
                $.confirm({
                    title: '@lang("lang.accepted")',
                    content: 'Are you sure want to accepted this performance?',
                    type: "blue",
                    buttons: {
                        submit: {
                            text: 'Submit',
                            btnClass: 'btn-green',
                            action: function () {
                                $('#modal-loading').modal('show');
                                axios.post('{{ URL("performance/accepted") }}', {
                                    id: id,
                                })
                                .then(function (response) {
                                    $('#modal-loading').modal('hide');
                                    if (response.data.success) {
                                        new Noty({
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            timeout: 2500
                                        }).show();
                                        window.location.replace("{{ URL('performance') }}");
                                        return;
                                    }
                                    // Validation Error: Weight must be 100%
                                    if (response.data.message === 'weight_must_be_exactly') {
                                        new Noty({
                                            text: 'Total weight must be exactly 100% before approval.',
                                            type: "error",
                                            timeout: 3000
                                        }).show();
                                        return;
                                    }
                                    // Other backend errors
                                    new Noty({
                                        text: response.data.message || 'Unknown error',
                                        type: "error"
                                    }).show();
                                })
                                .catch(function (error) {
                                    $('#modal-loading').modal('hide');
                                    new Noty({
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        timeout: 3000
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm'
                        }
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
        function strLimit(str, limit = 30, end = '...') {
            return str.length > limit ? str.substring(0, limit) + end : str;
        }
        function dataTables() {
            $('#tbl_performance').DataTable({
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
                    },
                    dataSrc: function (json) {
                        userPermission = json.permission || {}; // 👈 Save permission
                        userIdLog = json.userIdLog;
                        return json.data;
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let disabledAttr = "disabled";
                            if (row.employee_id == window.userId && row.status == 'preparing') {
                                disabledAttr = "";
                            }
                            if ((row.line_manager == window.userId && row.status == "accepted") || row.review_employee_id == window.userId) {
                                disabledAttr = "";
                            }
                            return `<div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                <input type="checkbox" class="custom-control-input sub_chk" ${disabledAttr} name="checkbox" data-status="${row.status}" data-id="${data}" id="${data}" value="${data}">
                                <label class="custom-control-label" for="${data}"></label>
                            </div>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            // const isOwner = row.line_manager == window.userId || row.employee_id == window.userId;
                            if (row.line_manager == window.userId && row.status == "accepted") {
                                return `
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" 
                                        href="#" data-toggle="dropdown">
                                            <i class="fa fa-dot-circle-o text-success"></i>
                                            <span>Accepted</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" 
                                            id="btnAsignTo" 
                                            data-id="${row.id}" 
                                            data-status="${row.status}">
                                                <i class="fa fa-dot-circle-o text-primary"></i>
                                                <span>@lang("lang.asign_to")</span>
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }
                            if (row.employee_id == window.userId && row.status === 'preparing') {
                                return `
                                        <div class="dropdown action-label">
                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" 
                                            href="#" data-toggle="dropdown">
                                                <i class="fa fa-dot-circle-o text-warning"></i>
                                                <span>Preparing</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" 
                                                id="btnAccepted" 
                                                data-id="${row.id}" 
                                                data-status="${row.status}">
                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                    <span>@lang('lang.accepted')</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            let statusText = "";
                            if (row.status == "preparing") {
                                statusText = '<span class="badge bg-inverse-info" style="font-size: 13px;">Preparing</span>';
                            }
                            if (row.status == "accepted") {
                                statusText = '<span class="badge bg-inverse-success" style="font-size: 13px;">Accepted</span>';
                            }
                            if (row.status == "1") {
                                statusText = '<span class="badge bg-inverse-info" style="font-size: 13px;">Pending Review</span>';
                            }
                            if (row.status == "2") {
                                statusText = '<span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Accepted</span>';
                            }
                            if (row.status == "3") {
                                statusText = '<span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Verify</span>';
                            }
                            if (row.status == "4") {
                                statusText = '<span class="badge bg-inverse-warning" style="font-size: 13px;">Pending Approve</span>';
                            }
                            if (row.status == "5") {
                                statusText = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Return</span>';
                            }
                            if (row.status == "approved") {
                                statusText = '<span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>';
                            }
                            // 3️⃣ DEFAULT fallback
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
                    { data: 'review_employee_name_en', name: 'review_employee_name_en' },
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
                            let btn_edit = "";
                            let btn_delete = "";
                            if ((row.employee_id == window.userId && (row.status == 'preparing' || row.status == "5")) || (row.line_manager == window.userId && row.status == 'preparing')) {
                                btn_edit = ` <a href="{{url('/performance')}}/${row.id}/edit" class="dropdown-item" data-id="${row.id}">
                                            <i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')
                                        </a>`;
                                btn_delete = `<a class="dropdown-item performanceDelete" href="#" data-toggle="modal" data-id="${row.id}"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>`;
                            }
                            if (row.line_manager == window.userId && row.status == "accepted") {
                                btn_edit = ` <a href="{{url('/performance')}}/${row.id}/edit" class="dropdown-item" data-id="${row.id}">
                                            <i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')
                                        </a>`;
                            }
                            return `
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url('performance')}}/${row.id}">
                                            <i class="fa fa-regular fa-eye"></i> Preview
                                        </a>
                                        ${btn_edit}
                                        ${btn_delete}
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
        }
    </script>
@endsection