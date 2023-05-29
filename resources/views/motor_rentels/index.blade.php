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
                    <h3 class="page-title">Motor rental</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Motor rental</li>
                    </ul>
                </div>

                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Administrator')
                        <a href="#" class="btn add-btn" data-toggle="modal" data-toggle="modal" id="add_new"><i
                                class="fa fa-plus"></i>
                            Add New</a>
                    @endif
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'Administrator')
                        <a href="#" class="btn add-btn" data-toggle="modal" id="import_new_motor_rentel"><i
                                class="fa fa-plus"></i>
                            Import Data</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->RolePermission == 'Administrator')
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="Employee ID"
                        value="{{ old('employee_id') }}">
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
                        <input type="text" class="form-control floating datetimepicker" name="from_date" id="from_date" value="">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus focused">
                    <div class="cal-icon">
                        <input type="text" class="form-control floating datetimepicker" name="to_date" id="to_date" value="">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <button class="btn btn-success w-100 btn-search" data-dismiss="modal">Search</button>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-motor"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Profle: activate to sort column descending"
                                            style="width: 94.0625px;">#</th>
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
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 125.15px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Department: activate to sort column ascending"
                                            style="width: 125.15px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Create at: activate to sort column ascending"
                                            style="width: 51.475px;">Created At</th>
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
                                                <td class="number_employee_id"><a
                                                        href="{{ url('/motor-rentel/detail', $item->id) }}">{{ $item->MotorEmployee->number_employee }}</a>
                                                </td>
                                                <td>{{ $item->MotorEmployee->employee_name_en }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeeGender }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeePosition }}</td>
                                                <td>{{ $item->MotorEmployee->EmployeeDepartment }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}
                                                </td>
                                                <td>{{ $item->price_motor_rentel - ($item->price_motor_rentel * $item->tax_rate) / 100 }}
                                                </td>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="material-icons">more_vert</i></a>
                                                        @if (Auth::user()->RolePermission == 'Administrator')
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item motor_detail"
                                                                    data-id="{{ $item->id }}"
                                                                    href="{{ url('/motor-rentel/detail', $item->id) }}"><i
                                                                        class="fa fa-eye m-r-5"></i> View</a>
                                                                <a class="dropdown-item update"
                                                                    data-id="{{ $item->id }}"><i
                                                                        class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item delete" href="#"
                                                                    data-toggle="modal" data-id="{{ $item->id }}"
                                                                    data-target="#delete_motor_rentel"><i
                                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
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

        @include('motor_rentels.modal_form_create')
        @include('motor_rentels.modal_form_edit')
        @include('motor_rentels.import')
        
        <!-- Delete Training Modal -->
        <div class="modal custom-modal fade" id="delete_motor_rentel" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ url('motor-rentel/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit"
                                            class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal"
                                            class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includs.script')

{{-- <script src="{{asset('/admin/js/simple-chart.js')}}"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script>
    
    $(function() {
        var currentYear = 2010;
        var newYear = moment(new Date()).format('YYYY');
        var currentDiff = moment(new Date()).diff(new Date(`01/01/${currentYear}`), 'years');

        $("#product_year, #e_product_year").on('change', function() {
            $('#e_expired_year').html('<option value=""> </option>');
            let dateYear = moment(new Date(`01/01/${$(this).val()}`)).format('YYYY-MM-DD');
            let ageMotorrentel = calculateAge(dateYear);

            $("#shelt_life").val(ageMotorrentel);
            $('#e_shelt_life').val(ageMotorrentel);

            // block Price motor rentel
            if (ageMotorrentel >= 0 && ageMotorrentel <= 5) {
                $("#price_motor_rentel").val(30);
                $('#e_price_motor_rentel').val(30);
            } else if (ageMotorrentel > 5 && ageMotorrentel <= 7) {
                $("#price_motor_rentel").val(25);
                $('#e_price_motor_rentel').val(25);
            } else if (ageMotorrentel > 7 && ageMotorrentel <= 10) {
                $("#price_motor_rentel").val(20);
                $('#e_price_motor_rentel').val(20);
            } else {
                $("#price_motor_rentel").val(0);
                $('#e_price_motor_rentel').val(0);
            }

            $('#expired_year').html('<option value=""> </option>');
            let currentY = $(this).val();
            let newYearExpireted = Number(currentY) + 11;
            if (newYearExpireted <= Number(newYear)) {
                newYearExpireted = newYear;
            }
            calculatorYearExpire(currentY, newYearExpireted);
        });

        $("#import_new_motor_rentel").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#import_motor_rentel').modal('show');
        });

        $("#add_new").on("click", function() {
            $('#expired_year').html('<option value=""> </option>');
            $("#shelt_life").val('');
            $("#price_motor_rentel").val('');
            calculatorYearExpire(newYear, Number(newYear) + 11);
            [...Array(currentDiff >= 0 ? currentDiff + 1 : 0).keys()].map((num) => {
                let year = currentYear + num;
                let option = {
                    value: year,
                    text: year,
                    selected: false
                }
                if (newYear == year) {
                    option.selected = true;
                }
                $('#product_year').append($('<option>', option));
            });
            $('#add_motor_rentel').modal('show');
        });


        $('.update').on('click', function() {
            $('#e_expired_year').html('<option value=""> </option>');
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{ url('motor-rentel/edit') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        if (response.employee != '') {
                            $('#e_employee_id').html('<option value=""> </option>');
                            $.each(response.employee, function(i, item) {
                                $('#e_employee_id').append($('<option>', {
                                    value: item.id,
                                    text: item.employee_name_en,
                                    selected: item.id == response
                                        .success.employee_id
                                }));
                            });
                        }

                        $('#e_id').val(response.success.id);
                        $('#e_gasoline_price_per_liter').val(response.success
                            .gasoline_price_per_liter);
                        $('#e_start_date').val(response.success.start_date);
                        $('#e_end_date').val(response.success.end_date);
                        [...Array(currentDiff >= 0 ? currentDiff + 1 : 0).keys()].map((
                            num) => {
                            let year = currentYear + num;
                            let option = {
                                value: year,
                                text: year,
                                selected: false
                            }
                            if (year == response.success.product_year) {
                                option.selected = true;
                            }
                            $('#e_product_year').append($('<option>', option));
                        });
                        let newYearExpireted = Number(response.success.product_year) + 11;
                        if (newYearExpireted <= Number(newYear)) {
                            newYearExpireted = newYear;
                        }
                        calculatorYearExpire(response.success.product_year,
                            newYearExpireted);
                        $('#e_shelt_life').val(response.success.shelt_life);
                        $('#e_number_plate').val(response.success.number_plate);
                        $('#e_total_gasoline').val(response.success.total_gasoline);
                        $('#e_total_work_day').val(response.success.total_work_day);
                        $('#e_price_engine_oil').val(response.success.price_engine_oil);
                        $('#e_price_motor_rentel').val(response.success.price_motor_rentel);
                        $('#e_tax_rate').val(response.success.tax_rate);

                        $('#edit_motor_rentel').modal('show');
                    }
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });

        $(".btn-search").on("click", function() {
            axios.post('{{ URL('motor-rentel/list') }}', {
                'research':true,
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }).then(function(response) {
                var rows = response.data.data;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let createdAt = moment(row.created_at).format('MMM-D-YYYY')
                        tr += '<tr class="odd">' +
                            '<td class="ids">' + (row.id) + '</td>' +
                            '<td class="number_employee_id"><a href="{{url("motor-rentel/detail")}}/'+row.id+'">' + (row.number_employee) + '</a></td>' +
                            '<td>' + (row.employee_name_en) + '</td>' +
                            '<td>' + (row.user.gender == null ? "" : row.user.gender.name_english) + '</td>' +
                            '<td>' + (row.user.position ? row.user.position.name_khmer : "") + '</td>' +
                            '<td>' + (row.user.department.name_khmer) + '</td>' +
                            '<td>' + (createdAt) + '</td>' +
                            '<td>' + (row.price_motor_rentel - (row.price_motor_rentel * row.tax_rate) / 100) + '</td>' +
                            '<td class="text-end">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
                            '<i class="material-icons">more_vert</i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item motor_detail" data-id="{{'(row.id)'}}" href="{{url("motor-rentel/detail")}}/'+row.id+'">' +
                            '<i class="fa fa-eye m-r-5"></i> View' +
                            '</a>' +
                            ' <a class="dropdown-item update" data-id="{{'(row.id)'}}">' +
                            '<i class="fa fa-pencil m-r-5"></i> Edit' +
                            '</a>' +
                            '<a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{'(row.id)'}}" data-target="#delete_motor_rentel">' +
                            '<i class="fa fa-trash-o m-r-5"></i> Delete' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            ' </tr>';
                    });
                } else {
                    var tr =
                        '<tr><td colspan=9 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-motor tbody").html(tr);
            })
        });
    });

    function calculatorYearExpire(currentYear, expiretedYear) {
        const expiredDiff = moment(new Date(`01/01/${expiretedYear}`)).diff(new Date(`01/01/${currentYear}`), 'years');
        let seletedYear = 0;
        [...Array(expiredDiff >= 0 ? expiredDiff + 1 : 0).keys()].map((num) => {
            seletedYear++;
            let year = Number(currentYear) + num;
            let option = {
                value: year,
                text: year,
                selected: false
            }
            if (seletedYear == 6) {
                option.selected = true
            }
            $('#expired_year').append($('<option>', option));
            $('#e_expired_year').append($('<option>', option));
        });
    }

    function calculateAge(year) {
        var now = new Date();
        var past = new Date(year);
        var nowYear = now.getFullYear();
        var pastYear = past.getFullYear();
        var age = nowYear - pastYear;
        return age;
    };
</script>
