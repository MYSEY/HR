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
                    <h3 class="page-title">@lang('lang.kpi_process')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.kpi_process')</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row filter-btn">
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                @if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO']))
                    <div class="form-group">
                        <select class="select form-control hr-select2-option filter" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
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
                        <select class="select form-control hr-select2-option filter" id="department_id" data-select2-id="select2-data-2-c0n2" name="department_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_department')</option>
                            @foreach ($department as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                @if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO']))
                    <div class="form-group">
                        <select class="select form-control hr-select2-option filter" id="status" data-select2-id="select2-data-2-c09n2" name="status">
                            <option value="">@lang('lang.all') @lang('lang.status')</option>
                            {{-- <option value="preparing">Preparing</option>
                            <option value="accepted">Accepted</option>
                            <option value="approved">Approved</option> --}}

                            <option value="1">Pending Review</option>
                            <option value="2">Pending Accepted</option>
                            <option value="3">Pending Verify</option>
                            <option value="4">Pending Approve</option>
                            {{-- <option value="5">Return</option> --}}
                        </select>
                    </div>
                @endif
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:void(0);" class="btn btn-sm btn-secondary mb-3" id="btnApprovedAll" data-userid="{{Auth::user()->id}}">
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
                                            <th class="text-nowrap sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.status')</th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc ">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.from_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.to_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.kpi_year')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">@lang('lang.total_weight')</th>
                                            <th>@lang('lang.incharge_by')</th>
                                            <th>@lang('lang.asign_to')</th>
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
            dataTables()
            $('.filter').on('change', function() {
                dataTables();
            });
            $('.checkAll').on('click', function(e) {
                if($(this).is(':checked',true)){
                    $(".sub_chk:not(:disabled)").prop("checked", true);
                } else {
                    $(".sub_chk:not(:disabled)").prop("checked", false);
                }
            });

            $('body').on('click','#btnApprovedAll',function(){
                var userid = $(this).data("userid");
                var allVals = [];
                var statuses = new Set();
                var condistionStatus = "";
                $(".sub_chk:checked:not(:disabled)").each(function() {
                    allVals.push($(this).attr('data-id'));
                    statuses.add($(this).data('status'));
                    condistionStatus = $(this).data('status');
                });
                var performance_id = allVals.join(",");
                if(allVals.length <=0)
                {
                    $.alert({
                        title: '@lang("lang.approve")!',
                        content: '@lang("lang.please_select_item_befor").',
                        type: 'red',
                    });
                }  else {
                    if (statuses.size > 1) {
                        $.alert({
                            title: '@lang("lang.you_cannot_approve")',
                            content: '@lang("lang.selected_items_must_have_the_same_status").',
                            type: 'red',
                        });
                        return;
                    }
                    var actionBtn = "";
                    var titleText = "";
                    var formContent = "";
                    var columnClassText = 'col-md-4';
                    if (condistionStatus == 1 ||  condistionStatus == 2 || condistionStatus == "accepted"|| condistionStatus == 3 || condistionStatus == "approved") {
                        titleText = '@lang("lang.asign_to_employee")';
                        columnClassText = 'col-md-6'
                        formContent = ''+
                            '<form id="add-style" style="height: 25em;">'+
                                // '<span class="text-danger">Old employee review: </span><span>'+employee_old+'</span><br>'+
                                '<div class="mt-2">'+
                                    '<label class="container-checkbox">Review'+
                                        '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="1"> <span class="checkmark"></span>'+
                                    '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                     '<label class="container-checkbox">Accepted'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="2"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                    '<label class="container-checkbox">Verify'+
                                        '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="3"> <span class="checkmark"></span>'+
                                    '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                    '<label class="container-checkbox">Approve'+
                                        '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="4"> <span class="checkmark"></span>'+
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
                                axios.post('{{ URL('performance-admin/asigns') }}', {
                                    'performance_id': performance_id,
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
                    }
                    if (condistionStatus === 4) {
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
                                axios.post('{{ URL('performance-admin/approveds') }}', {
                                    'performance_id': performance_id,
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
                                    let remark = this.$content.find('.remark').val();
                                    var asign_employee_id = this.$content.find('.asign_employee_id').val();
                                    if (!remark) {
                                        this.$content.find('.remark').css("border-color","#dc3545");
                                        $.alert({
                                            title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                            content: 'Please to remark!',
                                        });
                                        return false;
                                    }
                                    $('#modal-loading').modal('show');
                                    axios.post('{{ URL('performance-admin/returns') }}', {
                                        'performance_id': performance_id,
                                        'actionAsign': 5,
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
                                'get_employee_id': userid,
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
                }
            });
            $(document).on('click','.checkbox-group', function(){
                $(".checkbox-group").not(this).prop("checked", false);
            });
            $('.performanceDelete').on('click',function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
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
                if (status == 1 || status == 2 || status == "accepted" || status == 3 || status == "preparing" || status == 5) {
                    titleText = '@lang("lang.asign_to_employee")';
                    columnClassText = 'col-md-6'
                    formContent = ''+
                        '<form id="add-style" style="height: 25em;">'+
                            // '<span class="text-danger">Old employee review: </span><span>'+employee_old+'</span><br>'+
                            '<div class="mt-2">'+
                                '<label class="container-checkbox">Review'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="1"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Accepted'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="2"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Verify'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="3"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Approve'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="4"> <span class="checkmark"></span>'+
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
                            axios.post('{{ URL('performance-admin/asign') }}', {
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
                }
                if (status === 4) {
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
                            axios.post('{{ URL('performance-admin/approved') }}', {
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
                                axios.post('{{ URL('performance-admin/return') }}', {
                                    'id': pa_id,
                                    'actionAsign': 5,
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
        function toggle(source) {
            checkboxes = $('.checkAll');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
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
                    url: '{{ URL("performance-admin") }}',
                    type: 'GET',
                    data: function (d) {
                        d.employee_id = $('input[name="employee_id"]').val();
                        d.employee_name = $('input[name="employee_name"]').val();
                        d.branch_id = $('select[name="branch_id"]').val();
                        d.department_id = $('select[name="department_id"]').val();
                        d.status = $('select[name="status"]').val();
                    },
                    dataSrc: function (json) {
                        userPermission = json.permission || {}; // 👈 Save permission
                        userIdLog = json.userIdLog;
                        // console.log("Permission Data:", userPermission);
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
                            let disabledAttr = "";
                            if (row.review_employee_id != userIdLog) {
                                disabledAttr = "disabled";
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
                        orderable: false,
                        searchable: false,
                        className: 'stuck-scroll-3',
                        render: function (data, type, row) {
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
                            return `
                                ${statusText}
                            `;
                        }
                    },
                    {
                        data: 'number_employee',
                        name: 'number_employee',
                        className: 'stuck-scroll-3',
                    },
                    {
                        data: 'employee_name_kh',
                        name: 'employee_name_kh',
                    },
                    { data: 'branch_name_en', name: 'branch_name_en' },
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
                            if (row.status == 4) {
                                textBtn = "@lang('lang.approved')";
                            }
                            if (userIdLog == data.review_employee_id || userPermission.is_access == 1 && (row.status !="preparing" && row.status != "approved")) {
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
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url('performance-admin')}}/${row.id}/performance-admin">
                                            <i class="fa fa-regular fa-eye"></i> Preview
                                        </a>
                                        <a class="dropdown-item" href="{{url("performance-admin/histories")}}/${row.id}/performance-admin" ><i class="fa fa-eye m-r-5"></i> @lang('lang.view_history')</a>
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
