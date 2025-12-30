@extends('layouts.master')
<style>
    .co-performance-wrapper {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e6e6e6;
    }

    .table-title {
        font-size: 20px;
        font-weight: bold;
        padding-bottom: 12px;
        color: #1a237e;
    }

    /* Table Header */
    .table-header th {
        background: #1a237e;
        color: white;
        text-align: center;
        font-size: 13px;
        white-space: nowrap;
    }

    /* Table Footer */
    .table-footer td {
        background: #efefef;
        font-weight: bold;
        font-size: 13px;
    }

    /* Sticky columns */
    .sticky-col-1 {
        position: sticky;
        left: 0;
        background: white;
        z-index: 7;
    }

    .sticky-col-2 {
        position: sticky;
        left: 110px;
        background: white;
        z-index: 7;
    }

    /* General Table Style */
    .co-table th,
    .co-table td {
        vertical-align: middle !important;
        font-size: 13px;
        white-space: nowrap;
    }

    .text-right {
        text-align: right !important;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">CO Performance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">CO Performance</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row filter-btn"> 
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group">
                    <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                        <option value="" data-select2-id="select2-data-2-c0n2">All Branch</option>
                        @foreach ($branch as $item)
                            <option value="{{ $item->ID }}">
                                {{ Helper::getLang() == 'en' ? $item->Description : $item->LocalDescription }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group">
                    <select class="select form-control" id="asset_class" data-select2-id="select2-data-2-c0n2" name="asset_class">
                        @foreach ($AssetClass as $item)
                            <option value="{{ $item->ID }}">
                                {{ $item->ID }} - {{$item->Description}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="col-sm-6 col-md-6">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-txt"><i class="fa fa-search"></i></span>
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                        <span class="btn-text-excel"><i class="fa fa-arrow-circle-down"></i></span>
                        <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    {{-- <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                        <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button> --}}
                </div>
            </div>
        </div>

        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable" id="tbl_co_performance">
                                        <thead>
                                            <tr>
                                                <th>CO ID</th>
                                                <th>CO Name</th>
                                                <th>Currency</th>
                                                <th>#Borrowers</th>
                                                <th>#Loans</th>
                                                <th>Disbursed Amt.</th>
                                                <th>Oustanding Amt.</th>
                                                <th>Loan Balance</th>
                                                <th>#PARs</th>
                                                <th>PAR Amt.</th>
                                                <th>PAR Rate</th>
                                                <th>PD Principal</th>
                                                <th>PD Interest</th>
                                                <th>PD Penalty</th>
                                                <th>Arrear Rate</th>
                                                <th>#Loans</th>
                                                <th>Oustanding Amt.</th>
                                                <th>#PARs</th>
                                                <th>PAR Amt.</th>
                                                <th>PAR Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-bold cls-border odd">
                                                <td class="text-left"></td> 
                                                <td class="text-left"></td>
                                                <td class="text-left"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
    <script>
        var number_employee = null;
        const userRole = "{{ Auth::user()->RolePermission }}";
        $(function(){
            $(".btn_excel").on("click", function() {
                let query = {
                    branch_id: $("#branch_id").val(),
                    asset_class: $("#asset_class").val(),
                };
                var url = "{{URL::to('cbs/report/co-performance/download')}}?" + $.param(query)
                window.location = url;
            });
            // Reload only (DON'T destroy/reinit)
            $('.btn-search').on('click', function() {
                $('#loading-overlay').hide();
                branch_id = $('#branch_id').val();
                asset_class = $('#asset_class').val();
                $('#tbl_co_performance').DataTable().ajax.reload(null, false);
            });
            $(".reset-btn").on("click", function() {
                $(this).prop('disabled', true);
                $(".btn-text-reset").hide();
                $("#btn-text-loading").css('display', 'block');
                window.location.replace("{{ URL('cbs/report/co-performance') }}");
            });
            // Initialize only once
            dataTables();
        });

        function dataTables() {
            $('#loading-overlay').show();
            // Check if DataTable instance exists, then destroy it
            if ($.fn.DataTable.isDataTable('#tbl_co_performance')) {
                $('#tbl_co_performance').DataTable().clear().destroy();
            }
            $('#tbl_co_performance').DataTable({
                responsive: false,
                pageLength: 10,
                destroy: true,
                processing: true,
                serverSide: true,
                scrollX: true,
                scrollY: '400px',
                scroller: true,
                order: [[0, 'desc']],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100,"All"]],
                ajax: {
                    url: '{{ URL("cbs/report/co-performance") }}',
                    type: 'GET',
                    data: function (d) {
                        d.branch_id = $('select[name="branch_id"]').val();
                    },
                    dataSrc: function (json) {
                        window.mktSub = json.subtotal;
                        return json.data;
                    }
                },
                columns: [
                    {
                        data: 'ContractOfficerID', 
                        name: 'ContractOfficerID',
                        className: 'stuck-scroll-3',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'DisplayName', 
                        name: 'DisplayName',
                        className: 'stuck-scroll-3',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'Currency', 
                        name: 'Currency',
                        className: 'stuck-scroll-3',
                    },
                    {
                        data: 'TotalBorrowers', 
                        name: 'TotalBorrowers',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'TotalLoans', 
                        name: 'TotalLoans',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'TotalDisbursed', 
                        name: 'TotalDisbursed',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'TotalOutstanding', 
                        name: 'TotalOutstanding',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'TotalLoanBalanceAs', 
                        name: 'TotalLoanBalanceAs',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'Pars', 
                        name: 'Pars',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'ParAmount', 
                        name: 'ParAmount',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "0";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    { 
                        data: 'parRate', 
                        name: 'parRate',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            if (data === null || data === undefined || data === "") {
                                return "";
                            }

                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' %';
                        }
                    },
                    { 
                        data: 'TotalPDPrincipal', 
                        name: 'TotalPDPrincipal',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "0";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    { 
                        data: 'TotalPDInterest', 
                        name: 'TotalPDInterest',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "0";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    { 
                        data: 'TotalPDPenalty', 
                        name: 'TotalPDPenalty',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "0";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    { 
                        data: 'ArrearRate', 
                        name: 'ArrearRate',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            if (data === null || data === undefined || data === "") {
                                return "";
                            }

                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' %';
                        }
                    },
                    { 
                        data: 'Loans', 
                        name: 'Loans',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'OutstandingAmt', 
                        name: 'OutstandingAmt',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "0.00";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    { 
                        data: 'OutPARs', 
                        name: 'OutPARs',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'ParAmtAS', 
                        name: 'ParAmtAS',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "0.00";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    { 
                        data: 'OutPARRate', 
                        name: 'OutPARRate',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            if (data === null || data === undefined || data === "") {
                                return "";
                            }

                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }) + ' %';
                        }
                    },
                ],
                rowCallback: function (row, data) {
                    if (data.subtotal_row) {
                        $('td', row).css({
                            "font-weight": "bold",
                            "color": "#080808",
                            "font-size": "14px",
                            "font-family": '"Khmer Battambang", sans-serif',
                        });
                    }
                },
                initComplete: function() {
                    $('#loading-overlay').hide();
                },
            });
            $('#tbl_co_performance').on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    $('#loading-overlay').show();
                } else {
                    $('#loading-overlay').hide();
                }
            });
        }
        function numberFormat(num) {
            if (!num) return '';
            return Number(num).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    </script>
@endsection