@extends('layouts.master')
<style>
    .filter-row-btn .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<link rel="stylesheet" href="{{ asset('admin/css/loarding-table.css') }}">
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.pay_motor_rental')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.pay_motor_rental')</li>
                    </ul>
                </div>
            </div>
        </div>
        <form>
            <div class="row filter-btn"> 
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <select class="select form-control action-filter" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                    <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                                    @foreach ($locations as $item)
                                        <option value="{{$item->id}}">{{ app()->getLocale() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group ">
                                <input class="form-control action-filter" type="month" id="filter_month" name="filter_month">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 ">
                    <div style="display: flex" class="float-end">
                        @if ($permission->is_export == "1")
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                                <span class="btn-text-excel"><i class="fa fa-arrow-circle-down"></i></span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        @endif
                        
                        <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                            <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table mb-0 tbl-motor" id="DataTables_Table_0">
                                            <thead>
                                                <tr>
                                                    <th class="sorting stuck-scroll-3" >@lang('lang.employee_id')</th>
                                                    <th class="sorting sorting_asc stuck-scroll-3">@lang('lang.employee_name')</th>
                                                    <th>@lang('lang.gender')</th>
                                                    <th>@lang('lang.position')</th>
                                                    <th>@lang('lang.join_date')</th>
                                                    <th>@lang('lang.location')</th>
                                                    <th>@lang('lang.form_rental')</th>
                                                    <th>@lang('lang.total_leave_amount')</th>
                                                    <th>@lang('lang.total_amount')</th>
                                                    <th>@lang('lang.total_tax_fee')</th>
                                                    <th>@lang('lang.total_adjust_incl')</th>
                                                    <th>@lang('lang.total_adjust_tax_fee')</th>
                                                    <th>@lang('lang.total_adjust_excl')</th>
                                                    <th>@lang('lang.total_adjust_khr')</th>
                                                    <th>@lang('lang.total_net_amount')</th>
                                                    <th>@lang('lang.from_date')</th>
                                                    <th>@lang('lang.to_date')</th>
                                                    <th>@lang('lang.generate_date')</th>
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
    @include('motor_rentels.rental_view_calculation')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script>
    $(function() {
        datashowTables();
        $(".action-filter").on("change", function() {
            datashowTables();
        });
        $(".btn_excel").on("click", function() {
            let query = {
                branch_id: $("#branch_id").val(),
                year_month: $("#filter_month").val()
            };
            var url = "{{URL::to('/rental-pay/export')}}?" + $.param(query)
            window.location = url;
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
                url: '{{ url("/rental-pay") }}',
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
            columns: [
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
                    name: 'branch',
                    render: function (data, type, row) {
                        if (!row.branch) return '';
                        let isEn = '{{ Helper::getLang() }}' === 'en';
                        return isEn ? row.branch.branch_name_en : row.branch.branch_name_kh;
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
                        let seenTypes = new Set(); // ប្រើ Set សម្រាប់កត់ត្រា Form Type ដែលបានបង្ហាញរួច

                        forms.forEach(function (formItem, index) {
                            let formName = formItem.type;
                            let status = formItem.status;

                            // ប្រសិនបើ type នេះបានបង្ហាញរួចហើយ វានឹង skip ចោលមិនបង្ហាញទៀតទេ
                            if (seenTypes.has(formName)) {
                                return;
                            }
                            seenTypes.add(formName); // កត់ត្រា type ដែលបានបង្ហាញដំបូង

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
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    }
</script>
@endsection
