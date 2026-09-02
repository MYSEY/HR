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
                    <h3 class="page-title">@lang('lang.new_staff_reports')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.new_staff_reports')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (permissionAccess("m7-s13","is_view")->value == "1")
        <div class="row filter-btn">
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{ old('employee_id') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{ old('employee_name') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <select class="select form-control" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                        <option value="">@lang('lang.location')</option>
                        @foreach ($branch as $item)
                            <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date" placeholder="@lang('lang.from_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date" placeholder="@lang('lang.to_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-text-search"><i class="fa fa-search"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    @if (permissionAccess("m7-s13","is_export")->value == "1")
                        <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                            <span class="btn-text-excel"><i class="fa fa-arrow-circle-down"></i></span>
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
                        <div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0" id="tbl-new-staff-report">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('lang.id_card')</th>
                                                <th>@lang('lang.name_kh')</th>
                                                <th>@lang('lang.name_en')</th>
                                                <th>@lang('lang.gender')</th>
                                                <th>@lang('lang.position')</th>
                                                <th>@lang('lang.location')</th>
                                                <th>@lang('lang.join_date')</th>
                                                <th>@lang('lang.remark')</th>
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
        <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading Data...</p>
        </div>
    </div>
    @endif
@endsection

@include('includs.script')
<script src="{{asset('admin/js/export_xlsx.bundle.js')}}"></script>
@section('script')
    <script>
        $(function() {
            datashowTables();
            $(".reset-btn").on("click", function() {
                $(this).prop('disabled', true);
                $(".btn-text-reset").hide();
                $("#btn-reset-text-loading").css('display', 'block');
                window.location.replace("{{ URL('reports/new_staff-report') }}");
            });
            $(".btn-search").on("click", function() {
                datashowTables();
            });
            $('.btn_excel').click(function(e) {
                e.preventDefault();

                // ១. ចាប់យក Element របស់តារាង HTML 
                var table = document.getElementById("tbl-new-staff-report");

                var ws = XLSX.utils.table_to_sheet(table);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "New Staff Report");

                var headers = ['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1'];
                
                headers.forEach(function(cellRef) {
                    if (ws[cellRef]) {
                        // ប្រសិនបើមិនទាន់មាន style ទេ ត្រូវបង្កើត Object ថ្មី
                        if (!ws[cellRef].s) ws[cellRef].s = {};
                        
                        // កំណត់ឱ្យអក្សរដិត (Bold)
                        ws[cellRef].s.font = {
                            bold: true,
                            name: "Arial", // អាចប្តូរឈ្មោះ Font តាមចិត្ត
                            sz: 11         // ទំហំអក្សរ (Font Size)
                        };
                        ws[cellRef].s.fill = {
                            fgColor: { rgb: "F2F2F2" }
                        };
                    }
                });

                // ៥. បង្កើតឈ្មោះ File ទៅតាមថ្ងៃខែបច្ចុប្បន្ន
                var today = new Date().toISOString().slice(0, 10);
                var filename = "New_Staff_Report_" + today + ".xlsx";

                // ៦. បញ្ជាឱ្យ Browser ទាញយក File Excel មកភ្លាមៗ
                XLSX.writeFile(wb, filename);
            });
        });
        function datashowTables() {
            $('#loading-overlay').show();
            
            if ($.fn.DataTable.isDataTable('#tbl-new-staff-report')) {
                $('#tbl-new-staff-report').DataTable().clear().destroy();
            }
            $('#tbl-new-staff-report').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                order: [[0, 'desc']],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                ajax: {
                    url: '{{ url("/reports/new_staff-report") }}',
                    type: 'GET',
                    data: function (d) {
                        d.employee_id = $("#employee_id").val();
                        d.employee_name = $("#employee_name").val();
                        d.branch_id = $("#branch_id").val();
                        d.from_date = $("#from_date").val();
                        d.to_date = $("#to_date").val();
                    },
                },
                columns: [
                    {
                        data: null,
                        name: 'num',
                        className: 'ids',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'number_employee', defaultContent: '' },
                    { data: 'employee_name_kh', defaultContent: '' },
                    { data: 'employee_name_en', defaultContent: '' },
                    { 
                        data: "{{ Helper::getLang() == 'en' ? 'gender.name_english' : 'gender.name_khmer' }}", 
                        defaultContent: '' 
                    },
                    { 
                        data: "{{ Helper::getLang() == 'en' ? 'position.name_english' : 'position.name_khmer' }}", 
                        defaultContent: '' 
                    },
                    { 
                        data: "{{ Helper::getLang() == 'en' ? 'branch.branch_name_en' : 'branch.branch_name_kh' }}", 
                        defaultContent: '' 
                    },
                    { 
                        data: 'date_of_commencement',
                        render: function(data, type, row) {
                            return data ? moment(data).format('D-MMM-YYYY') : '';
                        }
                    },
                    { data: 'remark', defaultContent: '' },
                ],
                initComplete: function () {
                    $('#loading-overlay').hide();
                }
            });

            // គ្រប់គ្រងការឆែកមើលការ Loading
            $('#tbl-new-staff-report').off('processing.dt').on('processing.dt', function (e, settings, processing) {
                processing ? $('#loading-overlay').show() : $('#loading-overlay').hide();
            });
        }
    </script>
@endsection
