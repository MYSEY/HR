@extends('layouts.master')
<style>
     .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .reset-btn {
        color: #fff !important
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
                    <h3 class="page-title">Staff Transferred Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Staff Transferred Reports</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    {{-- @if (Auth::user()->RolePermission == 'Administrator')
                        <a href="#" class="btn add-btn btn-export"><i class="fa fa-plus"></i>
                            Export Data</a>
                    @endif --}}
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->RolePermission == 'Administrator')
        <div class="row filter-btn">
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name" id="employee_name"
                        placeholder="Employee Name" value="{{ old('employee_name') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date" placeholder="From Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date" placeholder="To Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-success btn-search me-2" data-dismiss="modal">
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                        <span class="btn-text-search">{{ __('Search') }}</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning reset-btn">
                        <span class="btn-text-reset">Reload</span>
                        <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer staff-transfer-report"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="2" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 94.0625px;">Name</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                colspan="2"
                                                aria-label="Location: activate to sort column descending"
                                                style="width: 94.0625px; text-align: center">Location</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                colspan="2"  aria-sort="ascending"
                                                aria-label="Position: activate to sort column descending"
                                                style="width: 94.0625px; text-align: center">Position</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="2" aria-sort="ascending"
                                                aria-label="Profle: activate to sort column descending"
                                                style="width: 94.0625px;">Effective Date</th>
                                        </tr>
                                        <tr>
                                            <th>Previous</th>
                                            <th>Current</th>
                                            <th>Previous</th>
                                            <th>Current</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($transferred) > 0)
                                            @php
                                                $branch_name = "";
                                                $position_name = "";
                                            @endphp
                                            @foreach ($transferred as $key=>$item)
                                                <tr>
                                                    <td>{{ $item->TransferEmp->employee_name_en }}</td>
                                                    <td>{{ $key == 0 ? $item->TransferEmp->branch->abbreviations: $branch_name }}</td>
                                                    <td>{{ $item->TransferredBranch->abbreviations }}</td>
                                                    <td>{{ $key == 0 ? $item->TransferEmp->position->name_english : $position_name}}</td>
                                                    <td>{{ $item->TransferredPosition->name_english}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-M-Y') ?? '' }}</td>
                                                </tr>
                                                @php
                                                    $branch_name = $item->TransferredBranch->abbreviations;
                                                    $position_name = $item->TransferredPosition->name_english;
                                                @endphp
                                            @endforeach
                                        @endif
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

<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/transferred-staff-report') }}");
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('reports/transferred-staff-report') }}', {
                'research':true,
                'employee_name': $("#employee_name").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }).then(function(response) {
                var rows = response.data.transferred;
                if (rows.length > 0) {
                    var tr = "";
                    let branch_name = "";
                    let position_name = "";
                    $(rows).each(function(e, row) {
                        let date = moment(row.date).format('D-MMM-YYYY');
                        tr += '<tr class="odd">'+
                                '<td>' + (row.employee.employee_name_en) + '</a></td>' +
                                '<td>' +(e == 0 ? row.employee.branch.abbreviations: branch_name)+ '</td>' +
                                '<td>' +(row.branch.abbreviations)+ '</td>' +
                                '<td>' +(e == 0 ? row.employee.position.name_khmer : position_name)+ '</td>' +
                                '<td>' +(row.position.name_khmer)+ '</td>' +
                                '<td>' + (date) + '</td>' +
                                '</tr>';
                        branch_name = row.branch.abbreviations;
                        position_name = row.position.name_khmer;
                    });
                } else {
                    var tr =
                        '<tr><td colspan=6 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".staff-transfer-report tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
    });
</script>
