@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Loan Detail Listing</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">Loan Detail Listing {{ $data->LastSystemDate ?? 'N/A' }}</li>
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
                                <div class="col-sm-12" style="height: 400%;">
                                    <table class="table table-hover table-striped custom-table datatable dataTable no-footer" id="tbl_loan_detail" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="sorting stuck-scroll-3">ID</th>
                                                <th class="sorting stuck-scroll-3">Customer ID</th>
                                                <th class="sorting stuck-scroll-3">Customer Name</th>
                                                <th class="sorting">Branch</th>
                                                <th class="sorting">Gender</th>
                                                <th class="sorting">Address</th>
                                                <th class="sorting">Village</th>
                                                <th class="sorting">Commune</th>
                                                <th class="sorting">District</th>
                                                <th class="sorting">Province</th>
                                                <th class="sorting">Account #</th>
                                                <th class="sorting">Currency</th>
                                                <th class="sorting">Disbursed</th>
                                                <th class="sorting">Loan Balance AS</th>
                                                <th class="sorting">Outstanding Amount AS</th>
                                                <th class="sorting">Interest Rate AS</th>
                                                <th class="sorting">Accrued Interest AS</th>
                                                <th class="sorting">Interest Earned ($)</th>
                                                <th class="sorting">Total Interest</th>
                                                <th class="sorting">Disbursement Date</th>
                                                <th class="sorting">Maturity Date</th>
                                                <th class="sorting">Loan Product</th>
                                                <th class="sorting">Term</th>
                                                <th class="sorting">Status</th>
                                                <th class="sorting">Asset Class</th>
                                                <th class="sorting">More Than One Year</th>
                                                <th class="sorting">CBCSubSection (Loan)</th>
                                                <th class="sorting">CBCSubSection (Customer)</th>
                                                <th class="sorting">MA Code</th>
                                                <th class="sorting">MA Description</th>
                                                <th class="sorting">Loan Purpose</th>
                                                <th class="sorting">Officer</th>
                                                <th class="sorting">ID Type</th>
                                                <th class="sorting">ID Number</th>
                                                <th class="sorting">Last Payment Date</th>
                                                <th class="sorting">Overdue Days</th>
                                                <th class="sorting">Overdue Date</th>
                                                <th class="sorting">Loan Type</th>
                                                <th class="sorting">Loan Charge(%)</th>
                                                <th class="sorting">Charge Earned</th>
                                                <th class="sorting">Charge Unearned</th>
                                                <th class="sorting">ScheduleType</th>
                                                <th class="sorting">Customer Occupation</th>
                                                <th class="sorting">Restructured Cycle</th>
                                                <th class="sorting">Address Code</th>
                                                <th class="sorting">Collateral ID</th>
                                                <th class="sorting">Customer Phone Number</th>
                                                <th class="sorting">Loan Cycle</th>
                                                <th class="sorting">Loan Amount FIRS</th>
                                                <th class="sorting">Outstanding Amount FIRS</th>
                                                <th class="sorting">Interest Rate FIRS</th>
                                                <th class="sorting">Interest Per Day FIRS</th>
                                                <th class="sorting">Accrued Interest FIRS</th>
                                                <th class="sorting">Regular Charge(%)</th>
                                                <th class="sorting">Sub Amount</th>
                                                <th class="sorting">Sub Loan Purpose</th>
                                                <th class="sorting">Partnered With</th>
                                                <th class="sorting">Restructure Type</th>
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
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
    <script>
        var number_employee = null;
        const userRole = "{{ Auth::user()->RolePermission }}";
        $(function(){
            // Initialize only once
            dataTables();
            $(".btn_excel").on("click", function() {
                let query = {
                    branch_id: $("#branch_id").val(),
                };
                var url = "{{URL::to('cbs/report/loan/detail/listing/download')}}?" + $.param(query)
                window.location = url;
            });
            // Reload only (DON'T destroy/reinit)
            $('.btn-search').on('click', function() {
                $('#loading-overlay').hide();
                branch_id = $('#branch_id').val();
                $('#tbl_loan_detail').DataTable().ajax.reload(null, false);
            });
            $(".reset-btn").on("click", function() {
                $(this).prop('disabled', true);
                $(".btn-text-reset").hide();
                $("#btn-text-loading").css('display', 'block');
                window.location.replace("{{ URL('cbs/report/loan/detail/listing') }}");
            });
        });

        function dataTables() {
            $('#loading-overlay').show();
            // Check if DataTable instance exists, then destroy it
            if ($.fn.DataTable.isDataTable('#tbl_loan_detail')) {
                $('#tbl_loan_detail').DataTable().clear().destroy();
            }
            $('#tbl_loan_detail').DataTable({
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
                    url: '{{ URL("cbs/report/loan/detail/listing") }}',
                    type: 'GET',
                    data: function (d) {
                        d.branch_id = $('select[name="branch_id"]').val();
                    },
                },
                columns: [
                    { 
                        data: 'ID', 
                        name: 'ID',
                        className: 'stuck-scroll-3',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'ContractCustomerID', 
                        name: 'ContractCustomerID',
                        className: 'stuck-scroll-3',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'CustomerName', 
                        name: 'LastNameEn',
                        className: 'stuck-scroll-3',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return row.LastNameEn + ' ' + row.FirstNameEn;
                        }
                    },
                    { 
                        data: 'Branch', 
                        name: 'Branch',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Gender', 
                        name: 'Gender',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Address', 
                        name: 'Address',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return row.Street;
                        }
                    },
                    { 
                        data: 'Village', 
                        name: 'Village',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Commune', 
                        name: 'Commune',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'District', 
                        name: 'District',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Province', 
                        name: 'Province',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Account', 
                        name: 'Account',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Currency', 
                        name: 'Currency',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Disbursed', 
                        name: 'Disbursed',
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
                        data: 'LoanBalanceAS', 
                        name: 'LoanBalanceAS',
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
                        data: 'OutstandingAmountAS', 
                        name: 'OutstandingAmountAS',
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
                        data: 'InterestRate', 
                        name: 'InterestRate',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'AIRCurrentAS', 
                        name: 'AIRCurrentAS',
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
                        data: 'AIRAS', 
                        name: 'AIRAS',
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
                        data: 'TotalInterest', 
                        name: 'TotalInterest',
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
                        data: 'ValueDate', 
                        name: 'ValueDate',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return '';

                            const date = new Date(data);
                            const mm = String(date.getMonth() + 1).padStart(2, '0');
                            const dd = String(date.getDate()).padStart(2, '0');
                            const yyyy = date.getFullYear();

                            return mm + '/' + dd + '/' + yyyy;
                        }
                    },
                    { 
                        data: 'MaturityDate', 
                        name: 'MaturityDate',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return '';

                            const date = new Date(data);
                            const mm = String(date.getMonth() + 1).padStart(2, '0');
                            const dd = String(date.getDate()).padStart(2, '0');
                            const yyyy = date.getFullYear();

                            return mm + '/' + dd + '/' + yyyy;
                        }
                    },
                    { 
                        data: 'LoanProduct', 
                        name: 'LoanProduct',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return row.LoanProduct + ' ' + row.LoanProductDes;
                        }
                    },
                    { 
                        data: 'Term', 
                        name: 'Term',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'DisbursedStat', 
                        name: 'DisbursedStat',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'AssetClass', 
                        name: 'AssetClass',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'MoreThanOneYear', 
                        name: 'MoreThanOneYear',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'CBCSubSection', 
                        name: 'CBCSubSection',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'CBCISSubSectionCuSt', 
                        name: 'CBCISSubSectionCuSt',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'MACode', 
                        name: 'MACode',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'MADes', 
                        name: 'MADes',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'LoanPurpose', 
                        name: 'LoanPurpose',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'ContractOfficerID', 
                        name: 'ContractOfficerID',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'IDType', 
                        name: 'IDType',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'IDNumber', 
                        name: 'IDNumber',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'LastPaymentDate', 
                        name: 'LastPaymentDate',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return '';

                            const date = new Date(data);
                            const mm = String(date.getMonth() + 1).padStart(2, '0');
                            const dd = String(date.getDate()).padStart(2, '0');
                            const yyyy = date.getFullYear();

                            return mm + '/' + dd + '/' + yyyy;
                        }
                    },
                    { 
                        data: 'DueDay', 
                        name: 'DueDay',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'OverdueDate', 
                        name: 'OverdueDate',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return '';

                            const date = new Date(data);
                            const mm = String(date.getMonth() + 1).padStart(2, '0');
                            const dd = String(date.getDate()).padStart(2, '0');
                            const yyyy = date.getFullYear();

                            return mm + '/' + dd + '/' + yyyy;
                        }
                    },
                    { 
                        data: 'LoanType', 
                        name: 'LoanType',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'LoanCharge', 
                        name: 'LoanCharge',
                        orderable: true,
                        searchable: true,
                        render: function (data) {
                            if (!data) return "";
                            return Number(data).toLocaleString(undefined, {
                                minimumFractionDigits: 1,
                                maximumFractionDigits: 1
                            });
                        }
                    },
                    { 
                        data: 'ChargeEarned', 
                        name: 'ChargeEarned',
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
                        data: 'ChargeUnearned', 
                        name: 'ChargeUnearned',
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
                        data: 'ScheduleType', 
                        name: 'ScheduleType',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'CustomerOccupation', 
                        name: 'CustomerOccupation',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'RestructuredCycle', 
                        name: 'RestructuredCycle',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'AddressCode', 
                        name: 'AddressCode',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'CollateralID', 
                        name: 'CollateralID',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Mobile1', 
                        name: 'Mobile1',
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return row.Mobile1 + ' ' + row.Mobile2;
                        }
                    },
                    { 
                        data: 'Cycle', 
                        name: 'Cycle',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'Amount', 
                        name: 'Amount',
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
                        data: 'OutstandingAmount', 
                        name: 'OutstandingAmount',
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
                        data: 'EIRRate', 
                        name: 'EIRRate',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'AccrInterest', 
                        name: 'AccrInterest',
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
                        data: 'IntIncEarned', 
                        name: 'IntIncEarned',
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
                        data: 'RegularCharge', 
                        name: 'RegularCharge',
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
                        data: 'SubAmount', 
                        name: 'SubAmount',
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
                        data: 'SubLoanPurpose', 
                        name: 'SubLoanPurpose',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'PartneredWith', 
                        name: 'PartneredWith',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'RestructureType', 
                        name: 'RestructureType',
                        orderable: true,
                        searchable: true,
                    },
                ],
                initComplete: function() {
                    $('#loading-overlay').hide();
                }
            });
            $('#tbl_loan_detail').on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    $('#loading-overlay').show();
                } else {
                    $('#loading-overlay').hide();
                }
            });
        }
    </script>
@endsection