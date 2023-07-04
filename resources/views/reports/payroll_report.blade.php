@extends('layouts.master')
<style>
    .filter-row .btn {
        min-height: 44px !important;
        padding: 9px !important;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Payroll Report</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payroll Report</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="content">
        @if (Auth::user()->RolePermission == 'Administrator')
            <form action="{{url('report/search')}}" method="POST">
                @csrf
                <div class="row filter-row"> 
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Employee name" value="{{old('employee_name')}}">
                            <label class="focus-label">Filter</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group form-focus focused">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text">
                            </div>
                                <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group form-focus focused">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" type="text">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <button type="submit" class="btn btn-success w-100" data-dismiss="modal">Search</button>
                    </div>
                </div>
            </form>
        @endif
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
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_Seniority" aria-selected="false" role="tab" tabindex="-1">Seniority Pay</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_Severance_pay" aria-selected="false" role="tab" tabindex="-1">Severance Pay</a>
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
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee Name: activate to sort column descending" style="width: 178px;">Employee Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Department</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Position</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Branch</th>
                                                    <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Join Date</th>
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
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 51.475px;">Net Salary</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending" style="width: 89.6px;">Payment Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($payroll)>0)
                                                    @foreach ($payroll as $item)
                                                        <tr class="odd">
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->employee_name_en }}</a></td>
                                                            <td><a href="#">{{$item->users == null ? '' : $item->users->EmployeeDepartment}}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeePosition}}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeBranch}}</a></td>
                                                            <td>{{ $item->users == null ? '' : $item->users->joinOfDate}}</td>
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
                                                            <td>{{ $item->payment_date}}</td>
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
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1">Employee ID</th>
                                                    <th class="sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee: activate to sort column descending">Full Name
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">Join Date
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">Total salary
                                                        before tax dollars</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">Total salary
                                                        before tax Riel</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">Average wage
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Payslip: activate to sort column ascending">
                                                        Occupational risk</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Payslip: activate to sort column ascending">Health Care
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Payslip: activate to sort column ascending">Pension
                                                        contribution dollars</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Payslip: activate to sort column ascending">Pension
                                                        contribution Riel</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Payslip: activate to sort column ascending">Enterprise
                                                        pension contribution</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">Created At
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($dataNSSF) > 0)
                                                    @foreach ($dataNSSF as $item)
                                                        <tr class="odd">
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->employee_name_en }}</a></td></td></td>
                                                            <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                            <td>$ {{ $item->total_pre_tax_salary_usd }}</td>
                                                            <td><span>៛</span> {{ $item->total_pre_tax_salary_riel }}</td>
                                                            <td>{{ $item->total_average_wage }}</td>
                                                            <td>{{ $item->total_occupational_risk }}</td>
                                                            <td>{{ $item->total_health_care }}</td>
                                                            <td>$ {{ $item->pension_contribution_usd }}</td>
                                                            <td><span></span> {{ $item->pension_contribution_riel }}</td>
                                                            <td>{{ $item->corporate_contribution }}</td>
                                                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="18" style="text-align: center">No record to display</td>
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
                                        <table class="table table-striped custom-table datatable dataTable no-footer"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Employee ID</th>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">Full Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Position</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Join Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Months</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Total Average Salary</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Total Salary Receive</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Tax Exemption Salary</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Taxable Salary</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($dataSeniority) > 0)
                                                    @foreach ($dataSeniority as $item)
                                                        <tr class="odd">
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->employee_name_en }}</a></td>
                                                            <td>{{ $item->users == null ? '' : $item->users->EmployeePosition }}</td>
                                                            <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                            <td>{{ $item->payment_of_month }}</td>
                                                            <td>{{ $item->total_average_salary }}</td>
                                                            <td>{{ $item->total_salary_receive }}</td>
                                                            <td>{{ $item->tax_exemption_salary }}</td>
                                                            <td>{{ $item->taxable_salary }}</td>
                                                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
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
            <div class="tab-pane show" id="tab_Severance_pay" role="tabpanel">
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
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Employee ID</th>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee: activate to sort column descending">Full Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Position</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Join Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Total Severanec Pay</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Payslip: activate to sort column ascending">Total Contract Severance Pay</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($severancePay) > 0)
                                                    @foreach ($severancePay as $item)
                                                        <tr class="odd">
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->employee_name_en }}</a></td>
                                                            <td>{{ $item->users == null ? '' : $item->users->EmployeePosition }}</td>
                                                            <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                            <td>{{ $item->total_severanec_pay }}</td>
                                                            <td>{{ $item->total_contract_severance_pay }}</td>
                                                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
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
@endsection
