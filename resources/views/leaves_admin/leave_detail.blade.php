@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.leaves_all_request')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.leaves_all_request')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a class="btn btn-outline-secondary" href="{{ url('/leaves/admin') }}">Back</a>
                    @if (permissionAccess("m10-s1","is_export")->value == "1")
                        <a href="#" class="btn btn btn-outline-secondary btn_excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> @lang('lang.export')</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="start_date" placeholder="@lang('lang.start_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="end_date" placeholder="@lang('lang.end_date')">
                    </div>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 w-100 tbl-leave-request">
                                    <thead>
                                        <tr>
                                            <th class="stuck-scroll-3">#</th>
                                            <th class="stuck-scroll-3">@lang('lang.employee_name')</th>
                                            <th class="stuck-scroll-3">@lang('lang.handover_staff')</th>
                                            <th>@lang('lang.delegated')</th>
                                            <th>@lang('lang.leave_type')</th>
                                            <th>@lang('lang.start_date')</th>
                                            <th>@lang('lang.end_date')</th>
                                            <th>@lang('lang.created_at')</th>
                                            <th>@lang('lang.duration')</th>
                                            <th>@lang('lang.created_by')</th>
                                            <th>@lang('lang.approved_by')</th>
                                            <th>@lang('lang.reason')</th>
                                            <th>@lang('lang.remark')</th>
                                            <th>@lang('lang.status')</th>
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
@section('script')
    <script>
        $(function(){
            let pathname = window.location.pathname; // e.g., "/leave-request/detail/12"
            var url_employee_id = pathname.split('/').pop();
            datashowTables(url_employee_id);
            $(".btn-cancel").on("click", function() {
                let id = $(this).data("id");
                let description = "@lang('lang.are_you_sure_want_to_cancel')?";
                let button_cancel = {
                    text: '@lang("lang.cancel")',
                    btnClass: 'btn-red btn-sm',
                    action: function () {
                        var id = this.$content.find('.id').val();
                        let remark = this.$content.find('.remark').val();
                        if (remark == ""){
                            $(".remark").css("border","solid 1px red");
                            new Noty({
                                title: "",
                                text: "Please enter infomation in the remark.",
                                type: "error",
                                timeout: 3000,
                                icon: true
                            }).show();
                            return false;
                        }
                        axios.post('{{ URL('leaves/admin/cancel') }}', {
                            'id': id,
                            'remark': remark,
                            'status': "cancel_hod",
                        }).then(function(response) {
                            new Noty({
                                title: "",
                                text: "@lang('lang.the_process_has_been_successfully').",
                                type: "success",
                                timeout: 3000,
                                icon: true
                            }).show();
                            window.location.replace("{{ URL('/leaves/admin') }}"); 
                        }).catch(function(error) {
                            new Noty({
                                title: "",
                                text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                type: "error",
                                icon: true
                            }).show();
                        });
                    }
                };
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Cancel request leave',
                    titleClass: 'text-center',
                    type: 'blue',
                    content: '' +
                    '<form action="" class="formName">' +
                        '<div class="form-group" style="text-align: center">' +
                            '<label>'+(description)+'</label>' +
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                        '</div>' +
                        '<div class="form-group">'+
                            '<label>Remark <span class="text-danger">*</span></label>'+
                            '<textarea class="form-control remark"></textarea>'+
                        '</div>'+
                    '</form>',
                    buttons: {
                        button_cancel,
                        cancel: {
                            text: '@lang("lang.close")',
                            btnClass: 'btn-secondary btn-sm',
                        },
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
            $(document).on("click", ".btn_excel", function (e) {
                e.preventDefault();
                let query = {
                    id: url_employee_id,
                    start_date: $("#start_date").val() || '',
                    end_date: $("#end_date").val() || ''
                };

                let baseUrl = "{{ url('leaves/employee/export') }}";
                let exportUrl = baseUrl + "?" + $.param(query);

                window.location.href = exportUrl;
            });
            $(document).on('click','.btn-rejected', function(){
                let id = $(this).data("id");
                let status = $(this).data("status");
                let condition = $(this).data("condition");
                if (condition == "HR" || condition == "HRAdmin" && (status != "approved_hod" || status == "approved_lm")) {
                    let text_message = "";
                    if (status == "approved_lm") {
                        text_message = "Pending head department approved";
                    }else{
                        text_message = "Pending line manager approved";
                    }
                    new Noty({
                        title: "",
                        text: text_message,
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                    return false;
                }
                let employeename = $(this).data("employeename");
                let startdate  = moment($(this).data("startdate")).format('D-MMM-YYYY');
                let enddate = moment($(this).data("enddate")).format('D-MMM-YYYY');
                let starthalfday = $(this).data("starthalfday") ? '  half day ( '+ $(this).data("starthalfday")+" )" : "";
                let endhalfday = $(this).data("endhalfday") ? '  half day ( '+ $(this).data("endhalfday")+" )" : "";
                let reason = $(this).data("reason");
                let description = "@lang('lang.are_you_sure_want_to_reject')?";
                let text_label = "";
                let danger = {
                    text: '@lang("lang.reject")',
                    btnClass: 'btn-red btn-sm',
                    action: function () {
                        var id = this.$content.find('.id').val();
                        var remark = this.$content.find('.remark').val();
                        if (remark == ""){
                            $(".remark").css("border","solid 1px red");
                            new Noty({
                                title: "",
                                text: "Please enter infomation in the remark.",
                                type: "error",
                                timeout: 3000,
                                icon: true
                            }).show();
                            return false;
                        }

                        axios.post('{{ URL('leaves/admin/reject') }}', {
                            'id': id,
                            'status': "rejected",
                            'remark': remark,
                        }).then(function(response) {
                            new Noty({
                                title: "",
                                text: "@lang('lang.the_process_has_been_successfully').",
                                type: "success",
                                timeout: 3000,
                                icon: true
                            }).show();
                            window.location.replace("{{ URL('/leaves/admin') }}"); 
                        }).catch(function(error) {
                            new Noty({
                                title: "",
                                text: "Som@lang('lang.something_went_wrong_please_try_again_later').",
                                type: "error",
                                icon: true
                            }).show();
                        });
                    }
                };
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Employee request leave',
                    titleClass: 'text-center',
                    type: 'blue',
                    content: '' +
                    '<form action="" class="formName">' +
                        '<div class="form-group" style="text-align: center">' +
                            '<label>'+(description)+'</label>' +
                            '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                        '</div>' +
                        '<div class="form-group">'+
                            '<p>Empployee Name: '+employeename+'</p>'+
                            '<p>From: '+startdate+starthalfday+'</p>'+
                            '<p>To: '+enddate+endhalfday+'</p>'+
                            '<label>Reason:</label>'+
                            '<textarea disabled class="form-control">'+reason+'</textarea>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>Remark</label>'+
                            '<textarea class="form-control remark"></textarea>'+
                        '</div>'+
                    '</form>',
                    buttons: {
                        danger,
                        cancel: {
                            text: '@lang("lang.close")',
                            btnClass: 'btn-secondary btn-sm',
                        },
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
            $('.datetimepicker').on('dp.change changeDate change', function (e) {
                datashowTables(url_employee_id);
            });
        });
        function datashowTables(id) {
            if (!id) return;
            let is_reject = "{{ Helper::permissionAccess('m10-s1','is_reject') }}";
            let is_approve = "{{ Helper::permissionAccess('m10-s1','is_approve') }}";

            $('#loading-overlay').show();

            if ($.fn.DataTable.isDataTable('.tbl-leave-request')) {
                $('.tbl-leave-request').DataTable().clear().destroy();
            }

            // Helper function for formatting dates (d-M-Y)
            function formatDate(dateStr) {
                if (!dateStr) return '';
                let d = new Date(dateStr);
                if (isNaN(d.getTime())) return dateStr;
                let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                let day = String(d.getDate()).padStart(2, '0');
                return `${day}-${months[d.getMonth()]}-${d.getFullYear()}`;
            }

            // Helper function for formatting datetime (d-M-Y H:i)
            function formatDateTime(dateStr) {
                if (!dateStr) return '';
                let d = new Date(dateStr);
                if (isNaN(d.getTime())) return dateStr;
                let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                let day = String(d.getDate()).padStart(2, '0');
                let hours = String(d.getHours()).padStart(2, '0');
                let minutes = String(d.getMinutes()).padStart(2, '0');
                return `${day}-${months[d.getMonth()]}-${d.getFullYear()} ${hours}:${minutes}`;
            }

            // Helper function to truncate string with ellipses
            function limitText(text, limit) {
                if (!text) return '';
                let cleanText = $('<div>').html(text).text(); // Strip HTML tags
                if (cleanText.length <= limit) return cleanText;
                return cleanText.substring(0, limit) + '...';
            }
            let requestUrl = '{{ url("/leave-request/detail") }}/' + id;
            $('.tbl-leave-request').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                pageLength: 10,
                order: [[0, 'desc']],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                ajax: {
                    url: requestUrl,
                    type: 'GET',
                    data: function (d) {
                        d.employee_id = id; // Sends ?employee_id=12
                        d.start_date = $("#start_date").val();
                        d.end_date = $("#end_date").val();
                    },
                    dataSrc: function (json) {
                        let total = json.recordsFiltered !== undefined ? json.recordsFiltered : (json.recordsTotal || 0);
                        $('#total_request').text(total);
                        return json.data;
                    }
                },
                columns: [
                    // 1. Index (#)
                    {
                        data: null,
                        className: 'ids stuck-scroll-3',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    // 2. Employee Name
                    {
                        data: 'employee.employee_name_en',
                        className: 'stuck-scroll-3 employee_name',
                        defaultContent: '',
                        render: function (data, type, row) {
                            return row.employee?.employee_name_en ?? '';
                        }
                    },
                    // 8. Handover Employee
                    {
                        data: 'handover.employee_name_en',
                        className: 'stuck-scroll-3',
                        defaultContent: '',
                        render: function (data, type, row) {
                            return row.handover?.employee_name_en ?? '';
                        }
                    },
                    // 9. Delegated
                    {
                        data: 'Delegated',
                        defaultContent: ''
                    },
                    // 3. Leave Type Name
                    {
                        data: 'leave_type.name',
                        defaultContent: '',
                        render: function (data, type, row) {
                            return row.leave_type?.name ?? row.leaveType?.name ?? '';
                        }
                    },
                    // 4. Start Date
                    {
                        data: 'start_date',
                        render: function (data) {
                            return formatDate(data);
                        }
                    },
                    // 5. End Date
                    {
                        data: 'end_date',
                        render: function (data) {
                            return formatDate(data);
                        }
                    },
                    // 6. Created At
                    {
                        data: 'created_at',
                        render: function (data) {
                            return formatDateTime(data);
                        }
                    },
                    // 7. Duration (Number of Days)
                    {
                        data: 'number_of_day',
                        render: function (data) {
                            return `${data ?? 0} Day`;
                        }
                    },
                    // 10. Created By
                    {
                        data: 'created_by.employee_name_en',
                        defaultContent: '',
                        render: function (data, type, row) {
                            return row.created_by?.employee_name_en ?? row.createdBy?.employee_name_en ?? '';
                        }
                    },
                    // 11. Approved By
                    {
                        data: 'approvedby.employee_name_en',
                        defaultContent: '',
                        render: function (data, type, row) {
                            return row.approvedby?.employee_name_en ?? '';
                        }
                    },
                    // 12. Reason
                    {
                        data: 'reason',
                        defaultContent: '',
                        render: function (data) {
                            if (!data) return '';
                            let truncated = limitText(data, 30);
                            let safeData = $('<div>').text(data).html(); // Escape HTML
                            return `<span data-bs-toggle="tooltip" data-bs-html="true" title="${safeData}">${truncated}</span>`;
                        }
                    },
                    // 13. Remark
                    {
                        data: 'remark',
                        defaultContent: '',
                        render: function (data) {
                            if (!data) return '';
                            let truncated = limitText(data, 30);
                            let safeData = $('<div>').text(data).html(); // Escape HTML
                            return `<span data-bs-toggle="tooltip" data-bs-html="true" title="${safeData}">${truncated}</span>`;
                        }
                    },
                    // 14. Status Badge
                    {
                        data: 'status',
                        render: function (status) {
                            let badgeClass = 'bg-inverse-secondary';
                            let label = status ?? '';

                            switch (status) {
                                case 'rejected':
                                    badgeClass = 'bg-inverse-danger';
                                    label = 'Rejected';
                                    break;
                                case 'pending_cancel':
                                    badgeClass = 'bg-inverse-danger';
                                    label = 'Pending Cancel';
                                    break;
                                case 'cancel_hod':
                                case 'cancel':
                                    badgeClass = 'bg-inverse-danger';
                                    label = 'Cancel';
                                    break;
                                case 'rejected_lm':
                                    badgeClass = 'bg-inverse-danger';
                                    label = 'Rejected by Line Manager';
                                    break;
                                case 'rejected_hod':
                                    badgeClass = 'bg-inverse-danger';
                                    label = 'Rejected by ACEO/Head/BM';
                                    break;
                                case 'approved_lm':
                                case 'pending':
                                    badgeClass = 'bg-inverse-info';
                                    label = 'Waiting Approve by CEO/Head/BM';
                                    break;
                                case 'approved_hod':
                                case 'approved':
                                    badgeClass = 'bg-inverse-success';
                                    label = 'Approved';
                                    break;
                            }

                            return `<span class="badge ${badgeClass}" style="font-size: 13px;">${label}</span>`;
                        }
                    }
                ],
                initComplete: function () {
                    $('#loading-overlay').hide();
                    // Re-initialize Bootstrap tooltips for dynamically generated elements
                    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }
                }
            });

            $('.tbl-leave-request').on('processing.dt', function (e, settings, processing) {
                processing ? $('#loading-overlay').show() : $('#loading-overlay').hide();
            });
        }
    </script>
@endsection