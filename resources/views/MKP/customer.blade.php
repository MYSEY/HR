@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">MKP</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">MKP</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
       
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer" id="tbl_mkp" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc stuck-scroll-4">ID</th>
                                                    <th class="sorting sorting_asc stuck-scroll-4">ContractCustomerID</th>
                                                    <th class="sorting sorting_asc stuck-scroll-4">CustomerName</th>
                                                    <th class="sorting sorting_asc">Branch</th>
                                                    <th class="sorting sorting_asc">Gender</th>
                                                    <th class="sorting sorting_asc">AddressCode</th>
                                                    <th class="sorting sorting_asc">Village</th>
                                                    <th class="sorting sorting_asc">Commune</th>
                                                    <th class="sorting sorting_asc">District</th>
                                                    <th class="sorting sorting_asc">Province</th>
                                                    <th class="sorting sorting_asc">Amount</th>
                                                    <th class="sorting sorting_asc">Currency</th>
                                                    <th class="sorting sorting_asc">Disbursed</th>
                                                    <th class="sorting sorting_asc">LoanBalanceAS</th>
                                                    <th class="sorting sorting_asc">OutstandingAmountAS</th>
                                                    <th class="sorting sorting_asc">InterestRate</th>
                                                    <th class="sorting sorting_asc">AIRAS</th>
                                                    <th class="sorting sorting_asc">AIRCurrentAS</th>
                                                    <th class="sorting sorting_asc">TotalInterest</th>
                                                    <th class="sorting sorting_asc">ValueDate</th>
                                                    <th class="sorting sorting_asc">MaturityDate</th>
                                                    <th class="sorting sorting_asc">LoanProduct</th>
                                                    <th class="sorting sorting_asc">Term</th>
                                                    <th class="sorting sorting_asc">DisbursedStat</th>
                                                    <th class="sorting sorting_asc">AssetClass</th>
                                                    <th class="sorting sorting_asc">MoreThanOneYear</th>
                                                    <th class="sorting sorting_asc">CBCSubSection</th>
                                                    <th class="sorting sorting_asc">CBCISSubSectionCuSt</th>
                                                    <th class="sorting sorting_asc">MACode</th>
                                                    <th class="sorting sorting_asc">MADes</th>
                                                    <th class="sorting sorting_asc">LoanPurpose</th>
                                                    <th class="sorting sorting_asc">ContractOfficerID</th>
                                                    <th class="sorting sorting_asc">DueDay</th>
                                                    <th class="sorting sorting_asc">LoanType</th>
                                                    <th class="sorting sorting_asc">LoanCharge</th>
                                                    <th class="sorting sorting_asc">RestructuredCycle</th>
                                                    <th class="sorting sorting_asc">CollateralID</th>
                                                    <th class="sorting sorting_asc">Amount</th>
                                                    <th class="sorting sorting_asc">OutstandingAmount</th>
                                                    <th class="sorting sorting_asc">EIRRate</th>
                                                    <th class="sorting sorting_asc">AccrInterest</th>
                                                    <th class="sorting sorting_asc">IntIncEarned</th>
                                                    <th class="sorting sorting_asc">RegularCharge</th>
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
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
    <script>
        var number_employee = null;
        const userRole = "{{ Auth::user()->RolePermission }}";
        $(function(){
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
            // Reload only (DON'T destroy/reinit)
            $('.btn-search').on('click', function() {
                number_employee = $('#employee_id').val();
                employee_name = $('#employee_name').val();
                branch_id = $('#branch_id').val();
                department_id = $('#department_id').val();
                $('#tbl_mkp').DataTable().ajax.reload(null, false);
            });
            // Initialize only once
            dataTables();
            $(".reset-btn").on("click", function() {
                $(this).prop('disabled', true);
                $(".btn-text-reset").hide();
                $("#btn-text-loading").css('display', 'block');
                window.location.replace("{{ URL('performance-appraisal') }}");
            });
        });

        function dataTables() {
            $('#loading-overlay').show();
            // Check if DataTable instance exists, then destroy it
            if ($.fn.DataTable.isDataTable('#tbl_mkp')) {
                $('#tbl_mkp').DataTable().clear().destroy();
            }
            $('#tbl_mkp').DataTable({
                destroy: true,
                pageLength: 10,
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: {
                    url: '{{ URL("MKP") }}',
                    type: 'GET',
                    data: function (d) {
                        d.employee_id = $('input[name="employee_id"]').val();
                        d.employee_name = $('input[name="employee_name"]').val();
                        d.branch_id = $('select[name="branch_id"]').val();
                        d.department_id = $('select[name="department_id"]').val();
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
                        data: 'AddressCode', 
                        name: 'AddressCode',
                        orderable: true,
                        searchable: true,
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
                        data: 'Amount', 
                        name: 'Amount',
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
                    },
                    { 
                        data: 'LoanBalanceAS', 
                        name: 'LoanBalanceAS',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'OutstandingAmountAS', 
                        name: 'OutstandingAmountAS',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'InterestRate', 
                        name: 'InterestRate',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'AIRAS', 
                        name: 'AIRAS',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'AIRCurrentAS', 
                        name: 'AIRCurrentAS',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'TotalInterest', 
                        name: 'TotalInterest',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'ValueDate', 
                        name: 'ValueDate',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'MaturityDate', 
                        name: 'MaturityDate',
                        orderable: true,
                        searchable: true,
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
                        data: 'DueDay', 
                        name: 'DueDay',
                        orderable: true,
                        searchable: true,
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
                    },
                    { 
                        data: 'RestructuredCycle', 
                        name: 'RestructuredCycle',
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
                        data: 'Amount', 
                        name: 'Amount',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'OutstandingAmount', 
                        name: 'OutstandingAmount',
                        orderable: true,
                        searchable: true,
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
                    },
                    { 
                        data: 'IntIncEarned', 
                        name: 'IntIncEarned',
                        orderable: true,
                        searchable: true,
                    },
                    { 
                        data: 'RegularCharge', 
                        name: 'RegularCharge',
                        orderable: true,
                        searchable: true,
                    },
                ],
                order: [[0, 'desc']],
                initComplete: function() {
                    $('#loading-overlay').hide(); // Hide spinner when data is fully loaded
                }
            });

            $('#tbl_mkp').on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    $('#loading-overlay').show();
                } else {
                    $('#loading-overlay').hide();
                }
            });
        }
    </script>
@endsection