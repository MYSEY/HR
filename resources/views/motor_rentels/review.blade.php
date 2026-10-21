@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .content-title {
        border-bottom: 1px solid #ccc;
        padding-top: 6px;
        padding-bottom: 5px;
        color: #983D3A;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.motor_rental_review')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.motor_rental_review')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_pay_motor_rentel" id="add_new"><i
                                class="fa fa-plus"></i>
                            @lang('lang.generate_payment')</a>
                    @endif
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
                        {{-- <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group ">
                                <input class="form-control action-filter" type="month" id="filter_month" name="filter_month">
                            </div>
                        </div> --}}
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
        {!! Toastr::message() !!}
        @if ($permission->is_delete == "1")
            <button type="butto4n" class="btn btn-sm btn-danger delete_all">@lang('lang.delete')</button>
        @endif
        @if ($permission->is_approve == "1")
            <button type="button" class="btn btn-sm btn-success btn_approved" href="#" data-id=""> @lang('lang.approve') @lang('lang.to') @lang('lang.payroll')</button> 
        @endif

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
                                                    <th><input type="checkbox" id="checkAll"></th>
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
    @include('motor_rentels.modal_generate_payment')
    @include('motor_rentels.rental_view_calculation')
    @include('motor_rentels.modal_approve')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script src="{{asset('/admin/js/convertNumberToWords.js')}}"></script>
<script src="{{asset('/admin/js/convertNumberToWordsExp.js')}}"></script>
@section('script')
    <script>
        $(function() {
            datashowTables();
            $(".reset-btn").on("click", function() {
                $(this).prop('disabled', true);
                $(".btn-text-reset").hide();
                $("#btn-reset-text-loading").css('display', 'block');
                window.location.replace("{{ URL('rental-pay/generate') }}"); 
            });
            $(".action-filter").on("change", function() {
                datashowTables();
            });
            $('#checkAll').on('click', function(e) {
                if($(this).is(':checked',true)){
                    $(".sub_chk").prop('checked', true);
                } else {  
                    $(".sub_chk").prop('checked',false);
                }  
            });

            $(".btn_excel").on("click", function() {
                let query = {
                    branch_id: $("#branch_id").val(),
                    year_month: $("#filter_month").val()
                };
                var url = "{{URL::to('/rental-pay/preview/export')}}?" + $.param(query)
                window.location = url;
            });

            $('.delete_all').on('click', function(e) {
                var allValNumberemployee = [];
                $(".sub_chk:checked").each(function() {  
                    allValNumberemployee.push($(this).attr('data-id'));
                });
                var ids = allValNumberemployee.join(",");
                if(allValNumberemployee.length <=0){
                    $.alert({
                        title: '@lang("lang.delete")!',
                        content: '@lang("lang.please_select_item_befor_delete").',
                        type: 'red',
                    });
                }  else {
                    $.confirm({
                        title: '@lang("lang.delete")!',
                        content: "@lang('lang.are_you_sure_want_to_delete')?",
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: 'ok',
                                btnClass: 'btn-red',
                                action: function(){
                                    axios.post('{{ URL("rental-pay/generate/delete") }}', {
                                        id : ids,
                                    }).then(function(response) {
                                        new Noty({
                                            title: "",
                                            text: "@lang('lang.the_process_has_been_successfully').",
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('rental-pay/generate') }}");
                                    }).catch(function(error) {
                                        new Noty({
                                            title: "",
                                            text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                            type: "error",
                                            icon: true
                                        }).show();
                                    });
                                }
                            },
                                close: function () {
                            }
                        }
                    }); 
                } 
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
            if ($.fn.DataTable.isDataTable('#tbl-recruitment-report')) {
                $('#tbl-recruitment-report').DataTable().clear().destroy();
            }
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
                    url: '{{ url("/rental-pay/generate") }}',
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
                        data: 'id',
                        name: 'id',
                        className: 'stuck-scroll-3',
                        render: function(data, type, row) {
                            return `<div class="form-check form-check-md">
                                <input class="form-check-input sub_chk" type="checkbox" data-has-listeners="true" data-id="${row.id}">
                            </div>`;
                        },
                        orderable: false,
                        searchable: false
                    },
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
                    }
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