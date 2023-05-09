@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Employee Salary</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Salary</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
    </div>
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
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending" style="width: 273.8px;">Employee</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 88.675px;">Employee ID</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 208.438px;">Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 67.3px;">Join Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 149.337px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 51.1625px;">Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending" style="width: 101.438px;">Payslip</th>
                                        <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 47.1375px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd">
                                        <td class="sorting_1">
                                            <h2 class="table-avatar">
                                                <a href="https://smarthr.dreamguystech.com/laravel/template/public/profile" class="avatar">
                                                    <img src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-13.jpg" alt="">
                                                </a>
                                                <a href="https://smarthr.dreamguystech.com/laravel/template/public/profile">Bernardo Galaviz <span>Web Developer</span></a>
                                            </h2>
                                        </td>
                                        <td>FT-0007</td>
                                        <td>bernardogalaviz@example.com</td>
                                        <td>1 Jan 2014</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">Web Developer </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Software Engineer</a>
                                                    <a class="dropdown-item" href="#">Software Tester</a>
                                                    <a class="dropdown-item" href="#">Frontend Developer</a>
                                                    <a class="dropdown-item" href="#">UI/UX Developer</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>$38400</td>
                                        <td><a class="btn btn-sm btn-primary" href="https://smarthr.dreamguystech.com/laravel/template/public/salary-view">Generate Slip</a></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_salary"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_salary"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
    <div id="add_salary" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff Salary</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('payroll/store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Employee <span class="text-danger">*</span></label>
                                    <select class="select select2-hidden-accessible" data-select2-id="select2-data-7-pany" name="employee_id" id="employee_id" tabindex="-1" aria-hidden="true" required>
                                        @foreach ($user as $item)
                                            <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-gorup">
                                    <label>Net Salary <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="net_salary" name="net_salary" placeholder="net salary amount" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Phone allowance</label>
                                    <input class="form-control" type="number" name="phone_allowance" id="phone_allowance">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Monthly and quarterly bonuses</label>
                                    <input type="number" class="form-control" name="monthly_quarterly_bonuses" id="monthly_quarterly_bonuses">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Khmer new year Or Pchum Ben allowance(%)</label>
                                    <input type="number" class="form-control" name="khmer_new_year_pchum_ben_allowance" id="khmer_new_year_pchum_ben_allowance">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Annual Incentive Bonus</label>
                                    <input type="number" class="form-control" name="annual_incentive_bonus" id="annual_incentive_bonus">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Other allowances</label>
                                    <input type="number" class="form-control" name="other_allowances" id="other_allowances">
                                    {{-- <textarea type="number" rows="3" class="form-control" name="other_allowances" id="other_allowances" value=""></textarea> --}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Spouse</label>
                                    <input type="number" class="form-control" name="spouse" id="spouse">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
