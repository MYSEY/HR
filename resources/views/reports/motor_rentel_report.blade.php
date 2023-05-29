@extends('layouts.master')
<style>
    .filter-row .btn {
        min-height: 44px !important;
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
                    <h3 class="page-title">Motor rental report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Motor rental report</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Administrator')
                        <a href="#" class="btn add-btn btn-export"><i class="fa fa-plus"></i>
                            Export Data</a>
                    @endif
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->RolePermission == 'Administrator')
        <div class="row filter-row">
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
                        <option value="">Branch name</option>
                        @foreach ($branchs as $item)
                            <option value="{{$item->id}}">{{$item->branch_name_kh}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date" placeholder="From date">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date" placeholder="To date">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <button type="submit" class="btn btn-success w-100 btn-search" data-dismiss="modal">Search</button>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-motor-rport"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Profle: activate to sort column descending"
                                            style="width: 265.913px;">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                            style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Employee name: activate to sort column descending"
                                            style="width: 178px;">Employee name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="Gender: activate to sort column ascending"
                                            style="width: 125.15px;">Gender</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="Branch name: activate to sort column ascending"
                                            style="width: 125.15px;">Branch name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="Position: activate to sort column ascending"
                                            style="width: 125.15px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department: activate to sort column ascending"
                                            style="width: 125.15px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Start Date: activate to sort column ascending"
                                            style="width: 89.6px;">Created At</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Start Date: activate to sort column ascending"
                                            style="width: 89.6px;">Start Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="End Date: activate to sort column ascending"
                                            style="width: 89.6px;">End Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Year of manufature: activate to sort column ascending"
                                            style="width: 89.6px;">Year of manufature</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Expiretion year: activate to sort column ascending"
                                            style="width: 89.6px;">Expiretion year</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Shelt life: activate to sort column ascending"
                                            style="width: 89.6px;">Shelt life</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Number plate: activate to sort column ascending"
                                            style="width: 125.15px;">Number plate</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Total gasoline: activate to sort column ascending"
                                            style="width: 89.6px;">Total gasoline</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Total working days: activate to sort column ascending"
                                            style="width: 89.6px;">Total working days</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Total gasoline liters: activate to sort column ascending"
                                            style="width: 89.6px;">Total gasoline liters</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Total price gasoline: activate to sort column ascending"
                                            style="width: 89.6px;">Total price gasoline</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Price engine oil: activate to sort column ascending"
                                            style="width: 89.6px;">Price engine oil</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Price motor rentel: activate to sort column ascending"
                                            style="width: 89.6px;">Price motor rentel</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Tax rate: activate to sort column ascending"
                                            style="width: 89.6px;">Tax rate</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Taxes on fees: activate to sort column ascending"
                                            style="width: 89.6px;">Taxes on fees</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Amount: activate to sort column ascending"
                                            style="width: 51.475px;">Amount</th>
                                        <th class="text-center sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Status: activate to sort column ascending"
                                            style="width: 55.5625px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr class="odd">
                                                <td class="ids">{{ $item->id }}</td>
                                                <td class="number_employee_id">
                                                    <a href="{{ url('/motor-rentel/detail', $item->id) }}">{{ $item->MotorEmployee->number_employee }}</a>
                                                </td>
                                                <td>{{ $item->MotorEmployee->employee_name_en }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeeGender }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeeBranch }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeePosition }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeeDepartment }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                <td class="start_date">{{ \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') ?? '' }}</td>
                                                <td class="end_date">{{  \Carbon\Carbon::parse($item->end_date)->format('d-M-Y') ?? '' }}</td>
                                                <td class="product_year">{{ $item->product_year }}</td>
                                                <td class="expired_year">{{ $item->expired_year }}</td>
                                                <td class="shelt_life">{{ $item->shelt_life }}</td>
                                                <td class="number_plate">{{ $item->number_plate }}</td>
                                                <td class="total_gasoline">{{ $item->total_gasoline }} (L)</td>
                                                <td class="total_work_day">{{ $item->total_work_day }}</td>

                                                <td>{{ $item->total_gasoline * $item->total_work_day }}</td>
                                                <td>{{ number_format($item->total_gasoline * $item->total_work_day * $item->gasoline_price_per_liter, 2) }}៛
                                                </td>
                                                <td class="price_engine_oil">$ {{ $item->price_engine_oil }}</td>
                                                <td class="price_motor_rentel">$ {{ $item->price_motor_rentel }}</td>
                                                <td class="tax_rate">{{ $item->tax_rate }}%</td>
                                                <td>$ {{ ($item->price_motor_rentel * $item->tax_rate) / 100 }}</td>

                                                <td>$
                                                    {{ $item->price_motor_rentel - ($item->price_motor_rentel * $item->tax_rate) / 100 }}
                                                </td>
                                                <td>
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="material-icons">more_vert</i></a>
                                                        @if (Auth::user()->RolePermission == 'Administrator')
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item motor_detail"
                                                                    data-id="{{ $item->id }}"
                                                                    href="{{ url('/motor-rentel/detail', $item->id) }}"><i
                                                                        class="fa fa-eye m-r-5"></i> View
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
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
@endsection

@include('includs.script')

<script>
    $(function() {
        $(".btn-export").on("click", function(){
            var query = {
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'branch_id': $("#branch_id").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }
            var url = "{{URL::to('motor-rentel/export')}}?" + $.param(query)
            window.location = url;
        });
        $(".btn-search").on("click", function() {
            axios.post('{{ URL('reports/motor-rentel-report') }}', {
                'research':true,
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'branch_id': $("#branch_id").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }).then(function(response) {
                var rows = response.data.data;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let created_at = moment(row.created_at).format('D-MMM-YYYY')
                        let start_date = moment(row.start_date).format('D-MMM-YYYY')
                        let end_date = moment(row.end_date).format('D-MMM-YYYY')
                        tr += '<tr class="odd">'+
                                    '<td class="ids">'+(row.id)+'</td>'+
                                    '<td class="number_employee_id"><a href="{{url("motor-rentel/detail")}}/'+row.id+'">' + (row.number_employee) + '</a></td>'+
                                    '<td>'+( row.employee_name_en )+'</td>'+
                                    '<td>'+( row.user.gender == null ? "" : row.user.gender.name_english )+'</td>'+
                                    '<td>'+( row.user.branch.branch_name_en )+'</td>'+
                                    '<td>'+( row.user.position ? row.user.position.name_khmer : "" )+'</td>'+
                                    '<td>'+( row.user.department.name_khmer )+'</td>'+
                                    '<td>'+( created_at )+'</td>'+
                                    '<td class="start_date">'+( start_date )+'</td>'+
                                    '<td class="end_date">'+( end_date )+'</td>'+
                                    '<td class="product_year">'+( row.product_year )+'</td>'+
                                    '<td class="expired_year">'+( row.expired_year )+'</td>'+
                                    '<td class="shelt_life">'+( row.shelt_life )+'</td>'+
                                    '<td class="number_plate">'+( row.number_plate )+'</td>'+
                                    '<td class="total_gasoline">'+( row.total_gasoline )+' (L)</td>'+
                                    '<td class="total_work_day">'+( row.total_work_day )+'</td>'+

                                    '<td>'+( row.total_gasoline * row.total_work_day )+'</td>'+
                                    '<td>'+( (row.total_gasoline * row.total_work_day * row.gasoline_price_per_liter).toFixed(2))+'៛</td>'+
                                    '<td class="price_engine_oil">$'+ ( row.price_engine_oil )+'</td>'+
                                    '<td class="price_motor_rentel">$'+ ( row.price_motor_rentel )+'</td>'+
                                    '<td class="tax_rate">'+( row.tax_rate )+'%</td>'+
                                    '<td>$'+ ( (row.price_motor_rentel * row.tax_rate) / 100 )+'</td>'+

                                    '<td>$ '+( row.price_motor_rentel - (row.price_motor_rentel * row.tax_rate) / 100 )+'</td>'+
                                    '<td>'+
                                        '<div class="dropdown dropdown-action">' +
                                        '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
                                        '<i class="material-icons">more_vert</i>' +
                                        '</a>' +
                                        '<div class="dropdown-menu dropdown-menu-right">' +
                                        '<a class="dropdown-item motor_detail" data-id="{{'(row.id)'}}" href="{{url("motor-rentel/detail")}}/'+row.id+'">' +
                                        '<i class="fa fa-eye m-r-5"></i> View' +
                                        '</a>' +
                                        '</div>' +
                                        '</div>' +
                                    '</td>'+
                                '</tr>';
                    });
                } else {
                    var tr =
                        '<tr><td colspan=9 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-motor-rport tbody").html(tr);
            })
        });
    });
</script>
