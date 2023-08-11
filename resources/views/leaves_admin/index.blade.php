@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('/leaves/admin/create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Leave</a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Today Presents</h6>
                    <h4>12 / 60</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Planned Leaves</h6>
                    <h4>8 <span>Today</span></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Unplanned Leaves</h6>
                    <h4>0 <span>Today</span></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Pending Requests</h6>
                    <h4>12</h4>
                </div>
            </div>
        </div>


        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus focused">
                    <select class="select floating select2-hidden-accessible" data-select2-id="select2-data-1-aolh"
                        tabindex="-1" aria-hidden="true">
                        <option data-select2-id="select2-data-3-j3sl"> -- Select -- </option>
                        <option>Casual Leave</option>
                        <option>Medical Leave</option>
                        <option>Loss of Pay</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus focused">
                    <select class="select floating select2-hidden-accessible" data-select2-id="select2-data-4-jy2e"
                        tabindex="-1" aria-hidden="true">
                        <option data-select2-id="select2-data-6-0xul"> -- Select -- </option>
                        <option> Pending </option>
                        <option> Approved </option>
                        <option> Rejected </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <a href="#" class="btn btn-success w-100"> Search </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending" style="width: 270.775px;">Employee</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Leave Type: activate to sort column ascending"
                                                style="width: 108.275px;">Leave Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="From: activate to sort column ascending"
                                                style="width: 78.9px;">From</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="To: activate to sort column ascending"
                                                style="width: 78.025px;">To</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="No of Days: activate to sort column ascending"
                                                style="width: 76.925px;">No of Days</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Reason: activate to sort column ascending"
                                                style="width: 117.075px;">Reason</th>
                                            <th class="text-center sorting" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending"
                                                style="width: 108.613px;">Status</th>
                                            <th class="text-end sorting" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="Actions: activate to sort column ascending"
                                                style="width: 54.6125px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd">
                                            <td class="sorting_1">
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar">
                                                        <img alt="" src="{{asset('admin/img/avatar-02.jpg')}}"></a>
                                                    <a> John Doe <span>Web Designer</span></a>
                                                </h2>
                                            </td>
                                            <td>Medical Leave</td>
                                            <td>27 Feb 2019</td>
                                            <td>27 Feb 2019</td>
                                            <td>1 day</td>
                                            <td>Going to Hospital</td>
                                            <td class="text-center">
                                                <div class="dropdown action-label">
                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                        href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-dot-circle-o text-success"></i> Approved
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fa fa-dot-circle-o text-purple"></i> New</a>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fa fa-dot-circle-o text-info"></i>
                                                            Pending</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#approve_leave"><i
                                                                class="fa fa-dot-circle-o text-success"></i>
                                                            Approved</a>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fa fa-dot-circle-o text-danger"></i> Declined</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#edit_leave"><i
                                                                class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_approve"><i
                                                                class="fa fa-trash-o m-r-5"></i>
                                                            Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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
