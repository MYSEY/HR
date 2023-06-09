

@extends('layouts.master')
@section('content')
    
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Payslip</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payslip</li>
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
                    <h4 class="payslip-title">EMPLOYEE PAYSLIP</h4>
                    <h5 class="payslip-title" style="color: red">Monthly Payroll : {{Carbon\Carbon::now()->format('M Y')}}</h5>
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" class="inv-logo" alt="">
                            <ul class="list-unstyled mb-0">
                                <li>Camma Microfinance Limited</li>
                                <li>289 Samdech Pen Nuth (St. 289), Phnom Penh</li>
                            </ul>
                        </div>
                        {{-- <div class="col-sm-6 m-b-20">
                            <div class="invoice-details">
                                <h3 class="text-uppercase">Payslip #49029</h3>
                                <ul class="list-unstyled">
                                    <li>Salary Month: <span>{{Carbon\Carbon::now()->format('M Y')}}</span></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-lg-12 m-b-20">
                            <ul class="list-unstyled">
                                <li>Employee ID : {{$payslip->users == null ? "" : $payslip->users->number_employee}}</li>
                                <li>Employee Name  : {{$payslip->users == null ? "" : $payslip->users->employee_name_en}}</li>
                                <li>Departement : {{$payslip->users == null ? "" : $payslip->users->EmployeeDepartment}}</li>
                                <li>Position : {{$payslip->users == null ? "" : $payslip->users->EmployeePosition}}</li>
                                <li>Branch : {{$payslip->users == null ? "" : $payslip->users->EmployeeBranch}}</li>
                                <li><span>Joining Date</span> : {{$payslip->users == null ? "" : $payslip->users->joinOfDate}}</li>
                                <li><span>Basic Rate</span> : {{$payslip->total_rate}}%</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Gross Salary <span class="float-end">$ {{$payslip->total_gross_salary}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Increasment <span class="float-end">$55</span></td>
                                        </tr>
                                        <tr>
                                            <td>Incentive <span class="float-end">$55</span></td>
                                        </tr>
                                        <tr>
                                            <td>Bonus(Annual/PB/KNY) <span class="float-end">$ {{$payslip->bunus == null ? 0 : $payslip->bunus->total_allowance}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Seniority pay <span class="float-end">$ {{$payslip->seniority == null ? 0 : $payslip->seniority->total_salary_receive}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Severance Pay <span class="float-end">$ {{$payslip->severancePay == null ? 0 : $payslip->severancePay->total_contract_severance_pay}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Adjustment(+/-) <span class="float-end">$55</span></td>
                                        </tr>
                                        <tr>
                                            <td>Leaves  (+/-) <span class="float-end">$55</span></td>
                                        </tr>
                                        <tr>
                                            <td>Phone <span class="float-end">$ {{$payslip->phone_allowance == null ? 0 : $payslip->phone_allowance}}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Earnings</strong> <span class="float-end"><strong>$ {{$payslip->total_gross_salary}}</strong></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <h4 class="m-b-10"><strong>Deductions</strong></h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Personal Tax <span class="float-end">$0</span></td>
                                        </tr>
                                        <tr>
                                            <td>Pension Fund <span class="float-end">$0</span></td>
                                        </tr>
                                        <tr>
                                            <td>Staff loan <span class="float-end">$550</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Deductions</strong> <span class="float-end"><strong>$59698</strong></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <p><strong>Total Net Pay: $59698</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('includs.script')