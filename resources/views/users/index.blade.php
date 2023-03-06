@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">

                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ url('users/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table datatable dataTable no-footer"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 291.163px;">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 227px;"> Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 202.6px;">Company</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Created Date: activate to sort column ascending" style="width: 114.95px;">Created Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 60.675px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd">
                                            <td class="sorting_1">
                                                <h2 class="table-avatar">
                                                    <a href="https://smarthr.dreamguystech.com/laravel/template/public/profile" class="avatar">
                                                        <img src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-19.jpg" alt="">
                                                    </a>
                                                    <a href="https://smarthr.dreamguystech.com/laravel/template/public/profile">Barry Cuda <span>Global Technologies</span></a>
                                                </h2>
                                            </td>
                                            <td>barrycuda@example.com</td>
                                            <td>Global Technologies</td>
                                            <td>1 Jan 2013</td>
                                            <td>
                                                <span class="badge bg-inverse-info">Client</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_user"><i  class="fa fa-trash-o m-r-5"></i> Delete</a>
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


        <div id="add_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Username <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input class="form-control" type="password">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-10-z86m" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-12-vnam">Admin</option>
                                            <option>Client</option>
                                            <option>Employee</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-11-se8q" style="width: 100%;"><span
                                                class="selection"><span class="select2-selection select2-selection--single"
                                                    role="combobox" aria-haspopup="true" aria-expanded="false"
                                                    tabindex="0" aria-disabled="false"
                                                    aria-labelledby="select2-tr8k-container"
                                                    aria-controls="select2-tr8k-container"><span
                                                        class="select2-selection__rendered" id="select2-tr8k-container"
                                                        role="textbox" aria-readonly="true" title="Admin">Admin</span><span
                                                        class="select2-selection__arrow" role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select class="select select2-hidden-accessible"
                                            data-select2-id="select2-data-13-3in7" tabindex="-1" aria-hidden="true">
                                            <option data-select2-id="select2-data-15-mqb3">Global Technologies</option>
                                            <option>Delta Infotech</option>
                                        </select><span class="select2 select2-container select2-container--default"
                                            dir="ltr" data-select2-id="select2-data-14-4enj" style="width: 100%;"><span
                                                class="selection"><span class="select2-selection select2-selection--single"
                                                    role="combobox" aria-haspopup="true" aria-expanded="false"
                                                    tabindex="0" aria-disabled="false"
                                                    aria-labelledby="select2-2wb7-container"
                                                    aria-controls="select2-2wb7-container"><span
                                                        class="select2-selection__rendered" id="select2-2wb7-container"
                                                        role="textbox" aria-readonly="true"
                                                        title="Global Technologies">Global Technologies</span><span
                                                        class="select2-selection__arrow" role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Employee ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive m-t-15">
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th>Module Permission</th>
                                            <th class="text-center">Read</th>
                                            <th class="text-center">Write</th>
                                            <th class="text-center">Create</th>
                                            <th class="text-center">Delete</th>
                                            <th class="text-center">Import</th>
                                            <th class="text-center">Export</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Employee</td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Holidays</td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Leaves</td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Events</td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                            <td class="text-center">
                                                <input checked="" type="checkbox">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
