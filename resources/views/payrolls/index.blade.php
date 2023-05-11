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
    {!! Toastr::message() !!}
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
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">Profile</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Employee ID</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Branch</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">DOB</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Join Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Salary</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Created At</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Payslip</th>
                                        <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr class="odd">
                                                <td class="sorting_1">
                                                    @if ($item->profile != null)
                                                        <a href="#" class="avatar">
                                                            <img src="{{asset('/uploads/images/'.$item->users->profile)}}" alt="">
                                                        </a>
                                                    @else
                                                        <a href="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                            <img alt="" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                        </a>
                                                    @endif
                                                </td>
                                                <td> <a href="#">{{$item->users == null ? "" : $item->users->employee_name_en}}</span></a></td>
                                                <td>{{$item->users == null ? "" : $item->users->number_employee}}</td>
                                                <td>{{$item->users == null ? "" : $item->users->EmployeeDepartment}}</td>
                                                <td>{{$item->users == null ? "" : $item->users->EmployeeBrnach}}</td>
                                                <td>{{$item->users == null ? "" : $item->users->DOB}}</td>
                                                <td>{{$item->users == null ? "" : $item->users->joinOfDate}}</td>
                                                <td>${{$item->total_salary}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td><a class="btn btn-sm btn-primary" href="#">Generate Slip</a></td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_salary"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="16" style="text-align: center">No record to display</td>
                                        </tr>
                                    @endif
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
                                        <input type="number" class="form-control" id="net_salary" name="net_salary" placeholder="" value="" required>
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
                                    <input type="number" class="form-control" name="spouse" id="spouse" maxlength="1" placeholder="">
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
@include('includs.script')