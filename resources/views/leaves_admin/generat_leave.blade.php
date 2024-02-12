@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Generate Leave All Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Generate Leave All Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m9-s2","is_create")->value == "1")
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_postion"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table table-striped custom-table mb-0 datatable dataTable no-footer staff-transfer-report" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="employee_name: activate to sort column descending">#</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="employee_name: activate to sort column descending" >@lang('lang.employee_name')</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-label="Annual: activate to sort column descending">Annual Leave</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Sick: activate to sort column descending">Sick Leave</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">Special Leave</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">Year 1</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">Year 2</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" aria-sort="ascending" aria-label="Profle: activate to sort column descending">Year 3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) > 0)
                                    @foreach ($data as $item)
                                        <tr class="odd">
                                            <td class="sorting_1">{{$item->id}}</td>
                                            <td>{{$item->EmployeeName}}</td>
                                            <td>{{$item->default_annual_leave}}</td>
                                            <td>{{$item->default_sick_leave}}</td>
                                            <td>{{$item->default_special_leave}}</td>
                                            <td>{{$item->year_1}}</td>
                                            <td>{{$item->year_2}}</td>
                                            <td>{{$item->year_3}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="add_postion" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_postion')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('/generat/leaves/create')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Annual Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="annual_leave" value="{{$AnnualLeave->default_day}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sick Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="sick_leave" value="{{$SickLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Special Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="special_leave" value="{{$SpecialLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-body">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="{{url('/generat/leaves/create')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Annual Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="annual_leave" value="{{$AnnualLeave->default_day}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sick Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="sick_leave" value="{{$SickLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Special Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="special_leave" value="{{$SpecialLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
