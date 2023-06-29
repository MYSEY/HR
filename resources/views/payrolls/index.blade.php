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
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable dataTable no-footer"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                    aria-sort="ascending"
                                                    aria-label="Employee: activate to sort column descending">Profile
                                                </th>
                                                <th class="sorting sorting_asc" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                    aria-sort="ascending"
                                                    aria-label="Employee: activate to sort column descending">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1">Employee ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Email: activate to sort column ascending">Department
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Email: activate to sort column ascending">Branch</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Join Date
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Basic Salary
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Child Allowance
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Phone Allowance
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">KNY / Pchum Ben
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Total Gross Salary
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Seniority Payable Tax
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Pension Fund
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Base Salary Received
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Tax-free Seniority
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Join Date: activate to sort column ascending">Severance Pay
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Salary: activate to sort column ascending">Net Salary
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Salary: activate to sort column ascending">Payment Date
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Salary: activate to sort column ascending">Created At
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Payslip: activate to sort column ascending">Payslip
                                                </th>
                                                <th class="text-end sorting" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                    aria-label="Action: activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data) > 0)
                                                @foreach ($data as $item)
                                                    <tr class="odd">
                                                        <td class="sorting_1">
                                                            <h2 class="table-avatar">
                                                                @if ($item->profile != null)
                                                                    <a href="{{ asset('/uploads/images/' . $item->users->profile) }}" class="avatar">
                                                                        <img src="{{ asset('/uploads/images/' . $item->users->profile) }}" alt="">
                                                                    </a>
                                                                @else
                                                                    <a href="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                        <img alt="" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                    </a>
                                                                @endif
                                                            </h2>
                                                        </td>
                                                        <td> <a href="#">{{ $item->users == null ? '' : $item->users->employee_name_en }}</span></a></td>
                                                        <td>{{ $item->users == null ? '' : $item->users->number_employee }}</td>
                                                        <td>{{ $item->users == null ? '' : $item->users->EmployeeDepartment }}</td>
                                                        <td>{{ $item->users == null ? '' : $item->users->EmployeeBranch }}</td>
                                                        <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                        <td>$ <a href="#">{{ $item->basic_salary }}</a></td>
                                                        <td>$ <a href="#">{{ $item->total_child_allowance }}</a></td>
                                                        <td>$ <a href="#">{{ $item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                        <td>$ <a href="#">{{ $item->total_kny_phcumben}}</a></td>
                                                        <td>$ <a href="#">{{ $item->total_gross_salary }}</a></td>
                                                        <td>$ <a href="#">{{ $item->seniority_payable_tax}}</a></td>
                                                        <td>$ <a href="#">{{ $item->total_pension_fund}}</a></td>
                                                        <td>$ <a href="#">{{ $item->base_salary_received_usd}}</a></td>
                                                        <td>$ <a href="#">{{ $item->tax_free_seniority_allowance}}</a></td>
                                                        <td>$ <a href="#">{{ $item->total_severance_pay}}</a></td>
                                                        <td>$ <a href="#">{{ $item->total_salary }}</a></td>
                                                        <td>{{ $item->PayrollPaymentDate }}</td>
                                                        <td>{{ $item->Created }}</td>
                                                        <td><a class="btn btn-sm btn-primary" href="{{ url('payslip', $item->employee_id) }}">Generate Slip</a></td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (Auth::user()->RolePermission == 'Administrator')
                                                                        <a class="dropdown-item" href="#"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#edit_salary"><i
                                                                                class="fa fa-pencil m-r-5"></i>
                                                                            Edit</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="20" style="text-align: center">No record to display</td>
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
                    <form action="{{ url('payroll/store') }}" method="POST">
                        @csrf
                        <h5>Exchange Rate</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-gorup">
                                    <label>USD</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="" name=""
                                            placeholder="" value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-gorup">
                                    <label>Riel</label>
                                    <div class="input-group">
                                        <span class="input-group-text">៛</span>
                                        <input type="number" class="form-control" id="exchange_rate"
                                            name="exchange_rate" placeholder=""
                                            value="{{ $exChangeRate->amount_riel }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Payment Date</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="payment_date" name="payment_date" required>
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
