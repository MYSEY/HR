@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }

    .ui-datepicker-calendar {
        display: none;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.motor_rental_reports')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.motor_rental_reports')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 col-md-8">
            <div class="row">
                @if (Auth::user()->RolePermission == "Developer" || Auth::user()->RolePermission == "admin" || Auth::user()->RolePermission == "HRAdmin")
                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <select class="select form-control action-filter" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                                <option value="">@lang('lang.location')</option>
                                @foreach ($branchs as $item)
                                    <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                            <select class="select form-control" id="department_id" name="department_id" value="{{old('department_id')}}">
                                <option value="">@lang('lang.department')</option>
                                @foreach ($departments as $item)
                                    <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                @endif
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group ">
                        <input class="form-control action-filter" type="month" id="filter_month" name="filter_month">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-12">
            <div style="display: flex" class="float-end">
                @if ($permission->is_export == "1")
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-export me-2" id="icon-search-download-reload">
                        <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                        <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                @endif
                <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                    <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                    <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                </button>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 tbl-motor" id="DataTables_Table_0">
                                    <thead>
                                        <tr>
                                            <th class="stuck-scroll-3">#</th>
                                            <th class="stuck-scroll-3">@lang('lang.employee_id')</th>
                                            <th class="stuck-scroll-3">@lang('lang.employee_name')</th>
                                            <th>@lang('lang.gender')</th>
                                            <th>@lang('lang.position')</th>
                                            <th>@lang('lang.join_date')</th>
                                            <th>@lang('lang.location')</th>
                                            <th>@lang('lang.form_rental')</th>
                                            <th>@lang('lang.last_working_day')</th>
                                            <th>@lang('lang.from_date')</th>
                                            <th>@lang('lang.to_date')</th>
                                            <th>@lang('lang.generate_date')</th>
                                            <th>@lang('lang.total_leave_amount')</th>
                                            <th>@lang('lang.total_amount')</th>
                                            <th>@lang('lang.total_tax_fee')</th>
                                            <th>@lang('lang.total_adjust_incl')</th>
                                            <th>@lang('lang.total_adjust_tax_fee')</th>
                                            <th>@lang('lang.total_adjust_excl')</th>
                                            <th>@lang('lang.total_adjust_khr')</th>
                                            <th>@lang('lang.total_net_amount')</th>
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
    <!-- Single Form Detail Modal -->
    <div class="modal fade" id="modal_view_form_details" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold text-primary" id="modal_form_title">
                        <i class="fa fa-file-text-o me-2"></i> Form Detail
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="detail_form_container" class="row g-3">
                        <!-- Dynamic form details will be injected here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">@lang('lang.close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
@section('script')
<script>
    $(function() {
        datashowTables();
        $(".action-filter").on("change", function() {
            datashowTables();
        });
        $(".btn-export").on("click", function(){
            var query = {
                'branch_id': $("#branch_id").val(),
                'department_id': $("#department_id").val(),
                'year_month': $("#filter_month").val(),
            }
            var url = "{{URL::to('reports/rental-export')}}?" + $.param(query)
            window.location = url;
        });
        $(document).on("click", ".btn-view-single-form", function () {
            let formIndex = $(this).data('form-index');
            
            let table = $('#DataTables_Table_0').DataTable();
            let rowData = table.row($(this).closest('tr')).data();
            
            if (!rowData) return;

            let detailsList = rowData.details || [];
            let currentDetail = detailsList[formIndex] || {};

            // 1. Parse dynamic fields JSON
            let fieldsData = {};
            if (currentDetail.fields) {
                try {
                    fieldsData = typeof currentDetail.fields === 'string' ? JSON.parse(currentDetail.fields) : currentDetail.fields;
                } catch (e) {
                    fieldsData = {};
                }
            }

            let currency = (currentDetail.currency || 'USD').toUpperCase();
            let formTitle = currentDetail.type ? currentDetail.type.toUpperCase() : 'Rental Form Detail';
            $('#modal_form_title').html(`<i class="fa fa-file-text-o me-2"></i> ${formTitle}`);

            let detailHtml = '';

            // ==========================================
            // SECTION 1: Dynamic Form Fields (Brand, Plate, etc.)
            // ==========================================
            if (Object.keys(fieldsData).length > 0) {
                detailHtml += `<div class="col-12 mb-1"><h6 class="fw-bold text-primary border-bottom pb-1 mb-2"><i class="fa fa-info-circle me-1"></i> Form Information</h6></div>`;
                $.each(fieldsData, function (key, fieldObj) {
                    let label = fieldObj.field_label || 'Field';
                    let val = fieldObj.value || '-';
                    detailHtml += `
                        <div class="col-6 mb-2">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block fw-normal" style="font-size: 11px;">${label}</small>
                                <span class="fw-bold text-dark" style="font-size: 13px;">${val}</span>
                            </div>
                        </div>`;
                });
            }

            // ==========================================
            // SECTION 2: Rental & Calculation Details
            // ==========================================
            let priceVal     = `${parseFloat(currentDetail.price || 0).toFixed(2)} ${currency}`;
            let amountVal    = `${parseFloat(currentDetail.amount || 0).toFixed(2)} ${currency}`;
            let amountExclTax = `${parseFloat(currentDetail.amount_excl_tax || 0).toFixed(2)} ${currency}`;
            
            let taxFeeVal    = `${parseFloat(currentDetail.tax_fee || 0).toFixed(2)} ${currency}`;
            let netAmountVal = `${parseFloat(currentDetail.net_amount || 0).toFixed(2)} ${currency}`;
            let workDays     = parseFloat(currentDetail.total_work_day || 0).toFixed(1);
            let leaveDays    = currentDetail.total_leave_days ? parseFloat(currentDetail.total_leave_days).toFixed(1) : '0';
            let leaveAmt     = `${parseFloat(currentDetail.leave_amount || 0).toFixed(2)} ${currency}`;

            detailHtml += `
                <div class="col-12 mt-2 mb-1">
                    <h6 class="fw-bold text-primary border-bottom pb-1 mb-2"><i class="fa fa-calculator me-1"></i> Calculation & Work Details</h6>
                </div>

                <div class="col-4 mb-2">
                    <div class="p-2 border rounded bg-light border-info">
                        <small class="text-muted d-block" style="font-size: 11px;">Rental Price</small>
                        <span class="fw-bold text-dark" style="font-size: 13px;">${priceVal}</span>
                    </div>
                </div>
                <div class="col-4 mb-2">
                    <div class="p-2 border rounded bg-light border-info">
                        <small class="text-muted d-block" style="font-size: 11px;">Total Work Days</small>
                        <span class="fw-bold text-primary" style="font-size: 13px;">${workDays} ថ្ងៃ</span>
                    </div>
                </div>

                <div class="col-4 mb-2">
                    <div class="p-2 border rounded bg-light border-info">
                        <small class="text-muted d-block" style="font-size: 11px;">Total Leave Days / Amt</small>
                        <span class="fw-bold text-warning" style="font-size: 13px;">${leaveDays} ថ្ងៃ / ${leaveAmt}</span>
                    </div>
                </div>

                <div class="col-4 mb-2">
                    <div class="p-2 border rounded bg-light">
                        <small class="text-muted d-block" style="font-size: 11px;">Calculated Amount</small>
                        <span class="fw-bold text-dark" style="font-size: 13px;">${amountVal}</span>
                    </div>
                </div>

                <div class="col-4 mb-2">
                    <div class="p-2 border rounded bg-light">
                        <small class="text-muted d-block" style="font-size: 11px;">Tax Fee (${currentDetail.tax_rate || 0}%)</small>
                        <span class="fw-bold text-danger" style="font-size: 13px;">${taxFeeVal}</span>
                    </div>
                </div>
                <div class="col-4 mb-2">
                    <div class="p-2 border rounded bg-light border-success">
                        <small class="text-muted d-block" style="font-size: 11px;">Amount excluding tax</small>
                        <span class="fw-bold text-success" style="font-size: 13px;">${amountExclTax}</span>
                    </div>
                </div>
            `;

            // ==========================================
            // SECTION 3: Adjustments Breakdown
            // ==========================================
            let adjEx  = `${parseFloat(currentDetail.adjust_amount_excl || 0).toFixed(2)} ${currency}`;
            let adjIn  = `${parseFloat(currentDetail.adjust_amount_incl || 0).toFixed(2)} ${currency}`;
            let adjTax = `${parseFloat(currentDetail.adjust_tax_fee || 0).toFixed(2)} ${currency}`;
            let adjKhr = `${parseFloat(currentDetail.adjust_amount_khr || 0)}`;

            detailHtml += `
                <div class="col-12 mt-2 mb-1">
                    <h6 class="fw-bold text-primary border-bottom pb-1 mb-2"><i class="fa fa-sliders me-1"></i> Adjustment Breakdown</h6>
                </div>

                <div class="col-3 mb-2">
                    <div class="p-2 border rounded bg-light">
                        <small class="text-muted d-block" style="font-size: 11px;">Adjust Excl. Tax</small>
                        <span class="fw-bold text-secondary" style="font-size: 12px;">${adjEx}</span>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="p-2 border rounded bg-light">
                        <small class="text-muted d-block" style="font-size: 11px;">Adjust Incl. Tax</small>
                        <span class="fw-bold text-secondary" style="font-size: 12px;">${adjIn}</span>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="p-2 border rounded bg-light">
                        <small class="text-muted d-block" style="font-size: 11px;">Adjust Tax Fee</small>
                        <span class="fw-bold text-secondary" style="font-size: 12px;">${adjTax}</span>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="p-2 border rounded bg-light">
                        <small class="text-muted d-block" style="font-size: 11px;">Adjust (KHR)</small>
                        <span class="fw-bold text-secondary" style="font-size: 12px;">${formatMoney(adjKhr, "KHR")} KHR</span>
                    </div>
                </div>
            `;
            detailHtml += `
                <div class="col-12 mt-2 mb-1">
                    <h6 class="fw-bold text-primary border-bottom pb-1 mb-2">
                        <i class="fa fa-calculator me-1"></i> Net amount pay
                    </h6>
                </div>
                <div class="col-4 mb-2">
                    <div class="p-2 border rounded bg-light border-success">
                        <small class="text-muted d-block" style="font-size: 11px;">Net Amount</small>
                        <span class="fw-bold text-success" style="font-size: 13px;">${netAmountVal}</span>
                    </div>
                </div>
            `;

            // ==========================================
            // SECTION 4: Status / Termination Check
            // ==========================================
            if (currentDetail.status === 'terminated') {
                detailHtml += `
                    <div class="col-12 mt-2">
                        <div class="alert alert-danger d-flex align-items-center mb-0 p-2" role="alert">
                            <i class="fa fa-exclamation-triangle me-2 fs-5"></i>
                            <div>
                                <strong>ស្ថានភាព៖ </strong> បានបញ្ចប់ការជួល (Terminated)<br>
                                <small><strong>កាលបរិច្ឆេទបញ្ចប់៖ </strong> ${currentDetail.terminate_date || 'N/A'}</small>
                            </div>
                        </div>
                    </div>`;
                $('.btnStopRenting').addClass('d-none');$('.btnPrint').addClass('d-none');
            } else {
                let formType = (currentDetail.type || '').toLowerCase().trim();

                $('.btnPrint').removeClass('d-none').attr('data-type', formType);

                $('.btnStopRenting')
                    .removeClass('d-none')
                    .attr('data-motor-id', rowData.id)
                    .attr('data-form-id', currentDetail.id);
            }

            // Inject ចូលទៅក្នុង Modal
            $('#detail_form_container').html(detailHtml);
            $('#modal_view_form_details').modal('show');
        });
    });
    function datashowTables() {
        $('#loading-overlay').show();

        var tableId = '#DataTables_Table_0';
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().clear().destroy();
            $(tableId + ' tbody').empty(); 
        }
        var dynamicHeight = $(window).height() - 350;
        if (dynamicHeight < 200) dynamicHeight = 200;
        $(tableId).DataTable({
            pageLength: 20,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            scrollY: dynamicHeight + 'px',
            scroller: false,
            order: [[0, 'desc']],
            lengthMenu: [
                [20, 25, 50, 100, -1],
                [20, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ url("/reports/rental") }}',
                type: 'GET',
                data: function (d) {
                    d.branch_id = $("#branch_id").val();
                    d.year_month = $("#filter_month").val();
                },
                dataSrc: function (json) {
                    return json.data;
                },
                error: function (xhr, error, code) {
                    $('#loading-overlay').hide();
                    console.error("DataTables Error: ", xhr.responseText);
                }
            },
            createdRow: function (row, data, dataIndex) {
                if (data.resigned_date) {
                    $(row).addClass('bg-inverse-danger');
                }
            },
            columns: [
                { data: null, name: 'num', className: 'ids stuck-scroll-3', orderable: false, searchable: false, render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, 
                { 
                    data: 'user.number_employee', 
                    name: 'user.number_employee', 
                    className: 'number_employee_id stuck-scroll-3',
                    defaultContent: ''
                },
                { 
                    data: null, 
                    name: 'user.employee_name_en',
                    className: 'stuck-scroll-3',
                    render: function (data, type, row) {
                        if (!row.user) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.employee_name_en : row.user.employee_name_kh;
                    }
                },
                { 
                    data: null, 
                    name: 'user.gender',
                    render: function (data, type, row) {
                        if (!row.user.gender) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.gender.name_english : row.user.gender.name_khmer;
                    }
                },
                { 
                    data: null, 
                    name: 'user.position',
                    render: function (data, type, row) {
                        if (!row.user.position) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.position.name_english : row.user.position.name_khmer;
                    }
                },
                { 
                    data: 'user.date_of_commencement', 
                    name: 'user.date_of_commencement',
                    render: function (data) {
                        if (!data) return '';
                        return data ? moment(data).format('DD-MMM-YYYY') : '';
                        // return `<span style="font-size: 13px" class="badge bg-inverse-danger">${moment(data).format('DD-MMM-YYYY')}</span>`;
                    }
                },
                { 
                    data: null, 
                    name: 'user.branch',
                    render: function (data, type, row) {
                        if (!row.user.branch) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.user.branch.branch_name_en : row.user.branch.branch_name_kh;
                    }
                },
                {
                    data: 'details',
                    name: 'details',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        if (!data) return '';

                        let forms = [];
                        try {
                            forms = typeof data === 'string' ? JSON.parse(data) : data;
                        } catch (e) {
                            forms = [];
                        }

                        if (!Array.isArray(forms) || forms.length === 0) return '';

                        let badges = '';
                        forms.forEach(function (formItem, index) {
                            let formName = formItem.type;
                            let status = formItem.status;

                            // បើ Terminated ប្រើ bg-danger, បើ Active ប្រើ bg-inverse-info
                            let badgeClass = (status === 'terminated') ? 'bg-danger' : 'bg-inverse-info';

                            badges += `<span class="badge ${badgeClass} me-1 mb-1 btn-view-single-form" 
                                            style="font-size: 11px; cursor: pointer;" 
                                            data-row-id="${row.id}" 
                                            data-form-index="${index}">
                                            <i class="fa fa-eye me-1"></i>${formName}
                                    </span>`;
                        });

                        return badges;
                    }
                },
                { 
                    data: "resigned_date", 
                    name: 'resigned_date',
                    render: function (data) {
                        return data ? moment(data).format('DD-MMM-YYYY') : '';
                    }
                },
                { 
                    data: 'from_date', 
                    name: 'from_date',
                    render: function (data) {
                        return data ? moment(data).format('DD-MMM-YYYY') : '';
                    }
                },
                { 
                    data: 'to_date', 
                    name: 'to_date',
                    render: function (data) {
                        return data ? moment(data).format('DD-MMM-YYYY') : '';
                    }
                },
                { 
                    data: 'created_at', 
                    name: 'created_at',
                    render: function (data) {
                        return data ? moment(data).format('DD-MMM-YYYY HH:mm') : '';
                    }
                },
                { 
                    data: 'total_leave_amount_usd', 
                    name: 'total_leave_amount_usd',
                    render: function (data, type) {
                        if (!data) return '0.00';
                        let formattedPrice = formatMoney(data, "USD") //parseFloat(data).toFixed(3);
                        return `<span class="fw-bold text-dark">$${formattedPrice}</span>`;
                    }
                },
                { 
                    data: 'total_amount_usd', 
                    name: 'total_amount_usd',
                    render: function (data, type) {
                        let formattedPrice = formatMoney(data, "USD") //parseFloat(data).toFixed(3);
                        return `<span class="fw-bold text-dark">$${formattedPrice}</span>`;
                    }
                },
                { 
                    data: 'total_tax_fee_usd', 
                    name: 'total_tax_fee_usd',
                    render: function (data, type) {
                        let formattedPrice = formatMoney(data, "USD") //parseFloat(data).toFixed(3);
                        return `<span class="fw-bold text-dark">$${formattedPrice}</span>`;
                    }
                },
                { 
                    data: 'total_adjust_amount_incl', 
                    name: 'total_adjust_amount_incl',
                    render: function (data, type) {
                        if (!data) return '0.00';
                        let formattedPrice = formatMoney(data, "USD") //parseFloat(data).toFixed(3);
                        return `<span class="fw-bold text-dark">$${formattedPrice}</span>`;
                    }
                },
                { 
                    data: 'total_adjust_tax_fee', 
                    name: 'total_adjust_tax_fee',
                    render: function (data, type) {
                        if (!data) return '0.00';
                        let formattedPrice = formatMoney(data, "USD") //parseFloat(data).toFixed(3);
                        return `<span class="fw-bold text-dark">$${formattedPrice}</span>`;
                    }
                },
                { 
                    data: 'total_adjust_amount_excl', 
                    name: 'total_adjust_amount_excl',
                    render: function (data, type) {
                        if (!data) return '0.00';
                        let formattedPrice = formatMoney(data, "USD") // parseFloat(data).toFixed(3);
                        return `<span class="fw-bold text-dark">$${formattedPrice}</span>`;
                    }
                },
                { 
                    data: 'total_adjust_amount_khr', 
                    name: 'total_adjust_amount_khr',
                    render: function (data, type) {
                        if (!data) return '0.00';
                        let formattedPrice = formatMoney(data, "KHR") //parseFloat(data).toFixed(0);
                        return `<span class="fw-bold text-dark">៛${formattedPrice}</span>`;
                    }
                },
                { 
                    data: 'total_net_amount_usd', 
                    name: 'total_net_amount_usd',
                    render: function (data, type) {
                        let formattedPrice = formatMoney(data, "USD") //parseFloat(data).toFixed(3);
                        return `<span class="fw-bold text-dark">$${formattedPrice}</span>`;
                    }
                },
            ],
            drawCallback: function() {
                $('#loading-overlay').hide();
            }
        });
    }
    function formatMoney(amount, currency = 'USD') {
        let num = parseFloat(amount) || 0;

        if (currency.toUpperCase() === 'KHR') {
            // សម្រាប់ KHR: ពុះ 3 ខ្ទង់ និងគ្មានទសភាគ (0 decimal places)
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        } else {
            // សម្រាប់ USD ឬផ្សេងៗ: ពុះ 3 ខ្ទង់ និងមានទសភាគ 3 ខ្ទង់
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 3,
                maximumFractionDigits: 3
            });
        }
    }
</script>
@endsection