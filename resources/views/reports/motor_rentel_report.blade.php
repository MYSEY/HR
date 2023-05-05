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
                    <h3 class="page-title">Motor rentel report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Motor rentel report</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Administrator')
                        <a href="{{ url('motor-rentel/export') }}" class="btn add-btn"><i class="fa fa-plus"></i>
                            Export Data</a>
                    @endif
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->RolePermission == 'Administrator')
        <form action="{{ url('motor-rentel/search') }}" method="POST">
            @csrf
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_id" id="employee_id"
                            placeholder="Employee ID" value="{{ old('employee_id') }}">
                        <label class="focus-label">Filter</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_name" id="employee_name"
                            placeholder="Employee Name" value="{{ old('employee_name') }}">
                        <label class="focus-label">Filter</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <button type="submit" class="btn btn-success w-100" data-dismiss="modal">Search</button>
                </div>
            </div>
        </form>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
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
                                            colspan="1" aria-label="Position: activate to sort column ascending"
                                            style="width: 125.15px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department: activate to sort column ascending"
                                            style="width: 125.15px;">Department</th>
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
                                                <td class="number_employee_id">{{ $item->MotorEmployee->number_employee }}
                                                </td>
                                                <td>{{ $item->MotorEmployee->employee_name_en }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeeGender }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeePosition }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeeDepartment }}</td>
                                                <td class="start_date">{{ $item->start_date }}</td>
                                                <td class="end_date">{{ $item->end_date }}</td>
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
    });
</script>
