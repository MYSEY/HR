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
                @if (Auth::user()->RolePermission == 'Administrator')
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i class="fa fa-plus"></i> Add New</a>
                @endif
            </div>
        </div>
    </div>
    {!! Toastr::message() !!}
    <div class="content container-fluid">
        <div class="page-menu">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_basic_salary" aria-selected="true" role="tab">Basic Salary</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_NSSF" aria-selected="false" role="tab" tabindex="-1">NSSF</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_Seniority" aria-selected="false" role="tab" tabindex="-1">Seniority</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane active show" id="tab_basic_salary" role="tabpanel">
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
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Join Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Net Salary</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Payment Date</th>
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
                                                            <td>{{$item->users == null ? "" : $item->users->EmployeeBranch}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->joinOfDate}}</td>
                                                            <td>$ <a href="#">{{$item->total_salary}}</a></td>
                                                            <td>{{$item->PayrollDate}}</td>
                                                            <td>{{$item->Created}}</td>
                                                            <td><a class="btn btn-sm btn-primary" href="{{url('payslip',$item->employee_id)}}">Generate Slip</a></td>
                                                            <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        @if (Auth::user()->RolePermission == 'Administrator')
                                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_salary"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                        @endif
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
            </div>


            <div class="tab-pane show" id="tab_NSSF" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Employee ID</th>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">Full Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Gender</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Position</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Join Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Total salary before tax dollars</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Total salary before tax Riel</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Average wage</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Occupational risk</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Health Care</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Pension contribution dollars</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Pension contribution Riel</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Enterprise pension contribution</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Work location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($dataNSSF) > 0)
                                                    @foreach ($dataNSSF as $item)
                                                        <tr class="odd">
                                                            <td><a href="#">{{$item->users == null ? "" : $item->users->number_employee}}</a></td>
                                                            <td><a href="#">{{$item->users == null ? "" : $item->users->employee_name_en}}</a></td>
                                                            <td>{{$item->users == null ? "" : $item->users->EmployeeGender}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->EmployeePosition}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->joinOfDate}}</td>
                                                            <td>$ <a href="#">{{$item->total_pre_tax_salary_usd}}</a></td>
                                                            <td><span>៛</span> {{$item->total_pre_tax_salary_riel}}</td>
                                                            <td>{{$item->total_average_wage}}</td>
                                                            <td>{{$item->total_occupational_risk}}</td>
                                                            <td>{{$item->total_health_care}}</td>
                                                            <td>$ <a href="">{{$item->pension_contribution_usd}}</a></td>
                                                            <td><span>៛</span> {{$item->pension_contribution_riel}}</td>
                                                            <td>{{$item->corporate_contribution}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->EmployeeBranchAbbreviations}}</td>
                                                            <td>{{Carbon\Carbon::parse($item->created_at)->format('d-M-Y')}}</td>
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
            </div>

            <div class="tab-pane show" id="tab_Seniority" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Employee ID</th>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">Full Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Gender</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Position</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Work location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Join Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Number of working days</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Total Average Salary</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Number of years</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Total Salary Receive</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Taxable Salary</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($dataSeniority) > 0)
                                                    @foreach ($dataSeniority as $item)
                                                        <tr class="odd">
                                                            <td><a href="#">{{$item->users == null ? "" : $item->users->number_employee}}</a></td>
                                                            <td><a href="#">{{$item->users == null ? "" : $item->users->employee_name_en}}</a></td>
                                                            <td>{{$item->users == null ? "" : $item->users->EmployeeGender}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->EmployeePosition}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->EmployeeBranchAbbreviations}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->joinOfDate}}</td>
                                                            <td>{{$item->users == null ? "" : $item->users->NumberofWorkingDays}} days</td>
                                                            <td>{{$item->users == null ? "" : $item->users->NumberofYears}} days</td>
                                                            <td>{{$item->total_average_salary}}</td>
                                                            <td>{{$item->total_salary_receive}}</td>
                                                            <td>{{$item->taxable_salary}}</td>
                                                            <td>{{Carbon\Carbon::parse($item->created_at)->format('d-M-Y')}}</td>
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
                                    <label>Basic Salary <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="basic_salary" name="basic_salary" placeholder="" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Phone Allowance</label>
                                    <input class="form-control" type="number" name="phone_allowance" id="phone_allowance">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Spouse</label>
                                    <input type="number" class="form-control" name="spouse" id="spouse" maxlength="2" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Khmer new year Or Pchum Ben Allowance(%)</label>
                                    <input type="number" class="form-control" name="khmer_new_year_pchum_ben_allowance" id="khmer_new_year_pchum_ben_allowance">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Other Allowances</label>
                                    <input type="number" class="form-control" name="other_allowances" id="other_allowances">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Payment Date</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" type="text" value="" required>
                                    </div>
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