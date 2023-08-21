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
                    <h3 class="page-title">New Staff Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">New Staff Reports</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
        <div class="row filter-btn">
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_id" id="employee_id"
                        placeholder="Employee ID" value="{{ old('employee_id') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name" id="employee_name"
                        placeholder="Employee Name" value="{{ old('employee_name') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <select class="select form-control" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                        <option value="">Branch Name</option>
                        @foreach ($branch as $item)
                            <option value="{{$item->id}}">{{$item->branch_name_kh}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date" placeholder="From Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date" placeholder="To Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
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
            <div class="col-md-12 p-0">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-new-staff-report"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Profle: activate to sort column descending"
                                                style="width: 94.0625px;">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                                style="width: 94.0625px;">ID Card</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Employee name: activate to sort column descending"
                                                style="width: 178px;">Name Kh</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Employee name: activate to sort column descending"
                                                style="width: 178px;">Name En</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Gender: activate to sort column ascending"
                                                style="width: 125.15px;">Gender</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 125.15px;">Position</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="Branch name: activate to sort column ascending"
                                                style="width: 125.15px;">Dept/Branch</th>
                                            
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Join Date: activate to sort column ascending"
                                                style="width: 125.15px;">Join Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Remark: activate to sort column ascending"
                                                style="width: 125.15px;">Remark</th>
                                            {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Action: activate to sort column ascending"
                                                style="width: 125.15px;">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($employees) > 0)
                                            @foreach ($employees as $item)
                                                <tr class="odd">
                                                    <td class="ids">{{ $item->id }}</td>
                                                    <td>{{ $item->number_employee }}</td>
                                                    <td>{{ $item->employee_name_kh }}</td>
                                                    <td>{{ $item->employee_name_en }}</td>
                                                    <td>{{ $item->EmployeeGender }}</td>
                                                    <td>{{ $item->position ? $item->position->name_khmer : "" }}</td>
                                                    <td>{{ $item->branch ? $item->branch->branch_name_en: "" }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date_of_commencement)->format('d-M-Y') ?? '' }}</td>
                                                    <td>{{ $item->remark }}</td>
                                                </tr>
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
            window.location.replace("{{ URL('reports/new_staff-report') }}");
        });
        // $(".btn-export").on("click", function(){
        //     var query = {
        //         'employee_id': $("#employee_id").val(),
        //         'employee_name': $("#employee_name").val(),
        //         'branch_id': $("#branch_id").val(),
        //         'from_date': $("#from_date").val(),
        //         'to_date': $("#to_date").val(),
        //     }
        //     var url = "{{URL::to('motor-rentel/export')}}?" + $.param(query)
        //     window.location = url;
        // });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('reports/new_staff-report') }}', {
                'research':true,
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'branch_id': $("#branch_id").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }).then(function(response) {
                var rows = response.data.employees;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let date_of_commencement = moment(row.date_of_commencement).format('D-MMM-YYYY');
                        tr += '<tr class="odd">'+
                                    '<td class="ids">'+(row.id)+'</td>'+
                                    '<td><a href="#">' + (row.number_employee) + '</a></td>'+
                                    '<td>'+( row.employee_name_kh )+'</td>'+
                                    '<td>'+( row.employee_name_en )+'</td>'+
                                    '<td>'+( row.gender == null ? "" : row.gender.name_english )+'</td>'+
                                    '<td>'+( row.position ? row.position.name_khmer : "" )+'</td>'+
                                    '<td>'+( row.branch.branch_name_en )+'</td>'+
                                    '<td>'+( date_of_commencement )+'</td>'+
                                    '<td>'+( row.remark ? row.remark : "" )+'</td>'+
                                '</tr>';
                    });
                } else {
                    var tr =
                        '<tr><td colspan=9 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-new-staff-report tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
    });
</script>
