@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Employee Report</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee Report</li>
                </ul>
            </div>
        </div>
    </div>
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
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee Name: activate to sort column descending" style="width: 178px;">Employee Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee Type: activate to sort column ascending" style="width: 108.188px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 191.625px;">Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending" style="width: 89.6px;">Start Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending" style="width: 89.6px;">End Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="DOB: activate to sort column ascending" style="width: 81.0625px;">DOB</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Martial Status: activate to sort column ascending" style="width: 100.25px;">Martial Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 52.95px;">Gender</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 51.475px;">Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending" style="width: 349.275px;">Address</th>
                                        <th class="text-center sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 55.5625px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users)>0)
                                        @foreach ($users as $item)
                                            <tr class="odd">
                                                <td class="sorting_1">
                                                    <h2 class="table-avatar">
                                                        <a href="{{asset('/uploads/images/'.$item->profile)}}" class="avatar">
                                                            <img alt="" src="{{asset('/uploads/images/'.$item->profile)}}">
                                                        </a>
                                                        <a href="{{asset('/uploads/images/'.$item->profile)}}" class="text-primary">{{$item->employee_name_en}} <span>#{{$item->number_employee}}</span></a>
                                                    </h2>
                                                </td>
                                                <td>{{$item->RolePermission}}</td>
                                                <td class="text-info">{{$item->email}}</td>
                                                <td>{{$item->EmployeeDepartment}}</td>
                                                <td>{{$item->EmployeePosition}}</td>
                                                <td>{{$item->FDCStartDate}}</td>
                                                <td>{{$item->FDCEndDate}}</td>
                                                <td>{{$item->DOB ?? ''}}</td>
                                                <td>{{$item->marital_status}}</td>
                                                <td>{{ $item->gender == 1 ? 'Male' : 'Female' }}</td>
                                                <td>$20000</td>
                                                <td>
                                                   {{$item->FullAddressEn}}
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-success btn-sm">{{ $item->emp_status == 1 ? "FDC" : ""}}</button>
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
