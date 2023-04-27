@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Detai Motor rentel</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Detail motor rentel</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-white">CSV</button>
                        <button class="btn btn-white">PDF</button>
                        <button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        @if ($data->MotorEmployee->profile != null)
                                            <img alt="profile" src="{{ asset('/uploads/images/' .$data->MotorEmployee->profile) }}">
                                        @else
                                            <img alt="profile" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $data->MotorEmployee->employee_name_en }}</h3>
                                                <h6 class="text-muted">{{ $data->MotorEmployee->EmployeeDepartment }}</h6>
                                                <small class="text-muted">{{ $data->MotorEmployee->EmployeePosition }}</small>
                                                <div class="staff-id">Employee ID : {{ $data->MotorEmployee->number_employee }}</div>
                                                <div class="small doj text-muted">Date of Join : {{ $data->MotorEmployee->joinOfDate }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <label class="text">{{ $data->MotorEmployee->personal_phone_number }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <label class="text">{{ $data->MotorEmployee->email }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Birthday:</div>
                                                    <label class="text">{{ \Carbon\Carbon::parse($data->MotorEmployee->date_of_birth)->format('d-M-Y') ?? '' }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <label class="text">{{ $data->MotorEmployee->gender == 1 ? 'Male' : 'Female' }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <label style="display: block;overflow: hidden;color: #888888;">{{ $data->MotorEmployee->FullCurrentAddress ?? '' }}</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Start Data</th>
                                        <th class="d-none d-sm-table-cell">End Date</th>
                                        <th>Year of manufature</th>
                                        <th>Expiretion year</th>
                                        <th class="text-end">Shelt life</th>
                                        <th class="text-end">Number plate</th>
                                        <th class="text-end">Total gasoline</th>
                                        <th class="text-end">Total working days</th>
                                        <th class="text-end">Total gasoline liters</th>
                                        <th class="text-end">Total price gasoline</th>
                                        <th class="text-end">Price engine oil</th>
                                        <th class="text-end">Price motor rentel</th>
                                        <th class="text-end">Tax Rate</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="start_date">{{$data->start_date}}</td>
                                        <td class="end_date">{{$data->end_date}}</td>
                                        <td class="product_year">{{$data->product_year}}</td>
                                        <td class="expired_year">{{$data->expired_year}}</td>
                                        <td class="shelt_life">{{$data->shelt_life}}</td>
                                        <td class="number_plate">{{$data->number_plate}}</td>
                                        <td class="total_gasoline">{{$data->total_gasoline}}</td>
                                        <td class="total_work_day">{{$data->total_work_day}}</td>

                                        <td >{{$data->total_gasoline * $data->total_work_day}}</td>
                                        <td >{{($data->total_gasoline * $data->total_work_day) * $data->gasoline_price_per_liter}} ៛</td>
                                        <td class="price_engine_oil">$ {{$data->price_engine_oil}}</td>
                                        <td class="price_motor_rentel">$ {{$data->price_motor_rentel}}</td>
                                        <td class="tax_rate">{{$data->tax_rate}}%</td>

                                        <td >$ {{$data->price_motor_rentel-(($data->price_motor_rentel * $data->tax_rate)/100)}}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    $(function(){
    });
</script>