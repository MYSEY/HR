@extends('layouts.master')
<style>
    .profile-info-left {
        border-right: 0px dashed #cccccc !important;
    }
</style>
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Detail For Training</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Training Detail</li>
                    </ul>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item ">Training Type: <label for="" style="color: red">{{$training->training_type == 1 ? "Internal" : "External" }}</label></li>
                    </ul>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item ">Course name: <label for="" style="color: red">{{$training->course_name}}</label></li>
                    </ul>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item ">Time Duration: <label for="" style="color: red">
                            {{ \Carbon\Carbon::parse($training->start_date)->format('d-M-Y') ?? '' }}
                            -
                            {{ \Carbon\Carbon::parse($training->end_date)->format('d-M-Y') ?? '' }}
                        </label></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <h4 class=""><a href="{{url('/training/list')}}">Back to list</a></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Trainer</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0 table-new-staff">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Name kh</th>
                                        <th>Name EN</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Remark</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($trainer) > 0)
                                        @foreach ($trainer as $item)
                                            <tr>
                                                <td >{{$item->id}}</td>
                                                <td >{{$item->type == 1 ? "Internal" : "External"}}</td>
                                                <td >{{$item->type == 1 ? $item->EmployeeIn->employee_name_kh : $item->name_kh}}</td>
                                                <td >{{$item->type == 1 ? $item->EmployeeIn->employee_name_en : $item->name_en}}</td>
                                                <td >{{$item->type == 1 ? $item->EmployeeIn->personal_phone_number : $item->number_phone}}</td>
                                                <td >{{$item->type == 1 ? $item->EmployeeIn->email : $item->email}}</td>
                                                <td >{{$item->type == 1 ? $item->EmployeeIn->remark : $item->remark}}</td>
                                                <td >{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Employee</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0 table-resigned-staff">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID Card</th>
                                        <th>Name kh</th>
                                        <th>Name EN</th>
                                        <th>Gender</th>
                                        <th>Position</th>
                                        <th>Dept/ Branch</th>
                                        <th>Join Date</th>
                                        <th>Rmark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($employees) > 0)
                                        @foreach ($employees as $item)
                                            <tr>
                                                <td >{{$item->id}}</td>
                                                <td >{{$item->number_employee}}</td>
                                                <td >{{$item->employee_name_kh}}</td>
                                                <td >{{$item->employee_name_en}}</td>
                                                <td >{{$item->EmployeeGender}}</td>
                                                <td >{{$item->EmployeePosition}}</td>
                                                <td >{{$item->EmployeeBranch}}</td>
                                                <td >{{ \Carbon\Carbon::parse($item->date_of_commencement)->format('d-M-Y') ?? '' }}</td>
                                                <td >{{ $item->remark}}</td>
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

<script type="text/javascript">
    $(function() {
    });
</script>
