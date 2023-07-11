@extends('layouts.master')
<style>
    .filter-row .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }

    .ui-datepicker-calendar {
        display: none;
    }
    .reset-btn{
        /* background: #ffbc34 !important; */
        color: #fff !important
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Training Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Training Reports</li>
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
        <form action="{{url('/reports/training-report')}}" method="POST" class="needs-validation" novalidate>
            @csrf
            
            <div class="row">
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <input type="text" class="form-control" name="employee_id" placeholder="Employee ID"
                            value="{{ old('employee_id') }}">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <input class="form-control floating" type="text" id="employee_name" name="employee_name"
                            placeholder="Employee Name">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <input class="form-control floating" type="text" id="course_name" name="course_name" placeholder="Course Name">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <select class="select form-control" data-select2-id="select2-data-2-c0n2" name="traing_type">
                            <option value="" data-select2-id="select2-data-2-c0n2">All Training Type</option>
                            <option value="1">Internal</option>
                            <option value="2">External</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" id="start_date" name="start_date"
                                placeholder="Start Date">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" id="end_date" name="end_date"
                                placeholder="End Date">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row filter-row">
                <div class="col-sm-2 col-md-12">
                    <div style="display: flex" class="float-end">
                        <button type="submit" class="btn btn-sm btn-success submit-btn me-2" data-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> </span>
                            <span class="btn-txt">{{ __('Search') }}</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning reset-btn">
                            <span class="btn-text-reset">Reset</span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
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
                            <table
                                class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-traingin-report"
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
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 125.15px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Date of Employment: activate to sort column ascending"
                                            style="width: 125.15px;">Date of Employment</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Seniority: activate to sort column ascending"
                                            style="width: 125.15px;">Employee Period</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Course Name: activate to sort column ascending"
                                            style="width: 125.15px;">Course Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Branch name: activate to sort column ascending"
                                            style="width: 125.15px;">Location</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Start Date: activate to sort column ascending"
                                            style="width: 125.15px;">Start Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="End Date: activate to sort column ascending"
                                            style="width: 125.15px;">End Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Duration of service: activate to sort column ascending"
                                            style="width: 125.15px;">Duration Term</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Price/Unit: activate to sort column ascending"
                                            style="width: 125.15px;">Price/Unit</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Discount Price: activate to sort column ascending"
                                            style="width: 125.15px;">Discount Fee</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Total: activate to sort column ascending"
                                            style="width: 125.15px;">Total</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Trainer: activate to sort column ascending"
                                            style="width: 125.15px;">Trainer</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Type of Training: activate to sort column ascending"
                                            style="width: 125.15px;">Type of Training</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1"
                                            aria-label="Remarks: activate to sort column ascending"
                                            style="width: 125.15px;">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($dataTrainings) > 0)
                                        @foreach ($dataTrainings as $item)
                                            @php
                                                $price = 0;
                                                $discount = 0;
                                                $total = 0;
                                                if (count($item->employee_id) > 0) {
                                                    $price =  $item->cost_price / count($item->employee_id);
                                                    $discount = ($price * $item->discount) / 100;
                                                    $total = $price - $discount;
                                                }
                                                $trainer = null;
                                                if (count($item->trainers) == 1) {
                                                    $trainer = $item->trainers[0]->type == 2 ? $item->trainers[0]->name_en : $item->trainers[0]->employee->employee_name_en;
                                                }else{
                                                    foreach ($item->trainers as $key => $trai) {
                                                        $trainer .= $trai->type == 2 ? $trai->name_en : $trai->employee->employee_name_en.', ';
                                                    }
                                                }
                                            @endphp
                                            @foreach ($item->employees as $key=>$emp)
                                                <tr class="odd">
                                                    <td class="ids">{{ $item->id }}</td>
                                                    <td>{{ $emp->number_employee }}</td>
                                                    <td>{{ $emp->employee_name_kh }}</td>
                                                    <td>{{$emp->employee_name_en}}</td>
                                                    <td>{{$emp->EmployeeGender}}</td>
                                                    <td>{{$emp->EmployeePosition}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($emp->date_of_commencement)->format('d-M-Y') ?? '' }}</td>
                                                    <td>{{$emp->SeniorityYearsOfEmployee}}</td>
                                                    <td>{{$item->course_name}}</td>
                                                    <td>{{$emp->EmployeeBranch}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') ?? '' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d-M-Y') ?? '' }}</td>
                                                    <td>
                                                        <span style="font-size: 13px" class="badge bg-inverse-danger">{{ $item->duration_month ? \Carbon\Carbon::parse($item->end_date)->addMonth($item->duration_month)->format('d-M-Y'): 0}}</span>
                                                    </td>
                                                    <td>$ {{round($price, 2)}}</td>
                                                    <td>$ {{round($discount, 2)}}</td>
                                                    <td>$ {{round($total, 2)}}</td>
                                                    <td> {{$trainer}}</td>
                                                    <td>{{ $item->training_type == 1 ? "Internal" : "External"}}</td>
                                                    <td>{{$item->remark ? $item->remark : ""}}</td>
                                                </tr>
                                            @endforeach
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
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/reports/training-report') }}"); 
        });
    });
</script>
