@extends('layouts.master')
<style>
    .filter-row-btn .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
    .reset-btn{
        color: #fff !important
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
                    <h3 class="page-title">Pay Motor rentals</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pay Motor rentals</li>
                    </ul>
                </div>
    
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Administrator')
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_pay_motor_rentel" id="add_new"><i
                                class="fa fa-plus"></i>
                            Add New</a>
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'Administrator')
            <div class="row filter-row-btn">
                <div class="col-sm-2 col-md-2">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="Employee ID"
                            value="{{ old('employee_id') }}">
                        <label class="focus-label">Filter</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_name" id="employee_name"
                            placeholder="Employee Name" value="{{ old('employee_name') }}">
                        <label class="focus-label">Filter</label>
                    </div>
                </div>
               
                <div class="col-sm-8 col-md-8">
                    <div style="display: flex" class="float-end">
                        <button class="btn btn-sm btn-success btn-search me-2" data-dismiss="modal" >
                            <span class="btn-text-search">Search</span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
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
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-pay-motor"
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
                                                    style="width: 178px;">Employee Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Gender: activate to sort column ascending"
                                                    style="width: 125.15px;">Gender</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Branch name: activate to sort column ascending"
                                                    style="width: 125.15px;">Branch Name</th>
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
                                                    style="width: 89.6px;">Year of Manufature</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Expiretion year: activate to sort column ascending"
                                                    style="width: 89.6px;">Expiretion Year</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Shelt life: activate to sort column ascending"
                                                    style="width: 89.6px;">Shelt Life</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Number plate: activate to sort column ascending"
                                                    style="width: 125.15px;">Number Plate</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total gasoline: activate to sort column ascending"
                                                    style="width: 89.6px;">Total Gasoline</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total working days: activate to sort column ascending"
                                                    style="width: 89.6px;">Total Working Days</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total gasoline liters: activate to sort column ascending"
                                                    style="width: 89.6px;">Total gasoline liters</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total price gasoline: activate to sort column ascending"
                                                    style="width: 89.6px;">Total Price Gasoline</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Price engine oil: activate to sort column ascending"
                                                    style="width: 89.6px;">Price Engine oil</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Price motor rentel: activate to sort column ascending"
                                                    style="width: 89.6px;">Price Motor Rentel</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Taplab Price: activate to sort column ascending"
                                                    style="width: 89.6px;">Taplab Price</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Tax rate: activate to sort column ascending"
                                                    style="width: 89.6px;">Tax Rate</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Taxes on fees: activate to sort column ascending"
                                                    style="width: 89.6px;">Taxes on Fees</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Amount: activate to sort column ascending"
                                                    style="width: 51.475px;">Amount</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Payment Date: activate to sort column ascending"
                                                    style="width: 51.475px;">Payment Date</th>
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
                                                        <td >$ {{ $item->price_taplab_rentel ? $item->price_taplab_rentel : "0.00" }}</td>
                                                        <td class="tax_rate">{{ $item->tax_rate }}%</td>
                                                        <td>$ {{ ($item->price_motor_rentel * $item->tax_rate) / 100 }}</td>
                                                        <td>$ {{ ($item->price_motor_rentel - ($item->price_motor_rentel * $item->tax_rate) / 100) + ($item->price_taplab_rentel - ($item->price_taplab_rentel * $item->tax_rate) / 100 )  }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
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
        </div>
    </div>
    @include('motor_rentels.modal_form_pay_motor')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('motor-rentel/pay') }}"); 
        });
        $(".btn-search").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('motor-rentel/search') }}', {
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
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
                                    '<td class="price_engine_oil">$ '+ ( row.price_engine_oil )+'</td>'+
                                    '<td class="price_motor_rentel">$ '+ ( row.price_motor_rentel )+'</td>'+
                                    '<td >$ '+ ( row.price_taplab_rentel )+'</td>'+

                                    '<td class="tax_rate">'+( row.tax_rate )+'%</td>'+
                                    '<td>$ '+ ( (row.price_motor_rentel * row.tax_rate) / 100 )+'</td>'+
                                    '<td>$ '+( (row.price_motor_rentel - (row.price_motor_rentel * row.tax_rate) / 100 ) + (row.price_taplab_rentel - (row.price_taplab_rentel * row.tax_rate) / 100 ))+'</td>'+
                                    '<td>'+(created_at)+'</td>'+
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
                    var tr = '<tr><td colspan=25 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-pay-motor tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
    });
</script>
