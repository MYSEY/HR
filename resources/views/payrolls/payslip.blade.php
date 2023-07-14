

@extends('layouts.master_print')
<style>
    .profile-info-left {
        border-right: 0px dashed #cccccc !important;
    }

    .td-border {
        border: none !important
    }

    .tr-bckground-ch {
        background-color: chocolate !important
    }

    .tr-background-83 {
        background-color: #83d85c;
    }

    .td-background-cc {
        background-color: #cccccc !important;
    }
</style>
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Payslip</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payslip / <a href="{{url('payroll')}}">back to list</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group btn-group-sm">
                        {{-- <button class="btn btn-white">CSV</button>
                        <button class="btn btn-white">PDF</button> --}}
                        <button class="btn btn-white" target="_blank" id="btn_print_payroll"><i class="fa fa-print fa-lg"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 m-b-20">
                                <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" class="inv-logo" alt="">
                                <ul class="list-unstyled mb-0">
                                    <li>Camma Microfinance Limited</li>
                                    <li>{{$payslip->users == null ? "" : $payslip->users->BranchAddress}}</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h4 class="payslip-title">EMPLOYEE PAYSLIP</h4>
                                <h5 class="payslip-title" style="color: red">Monthly Payroll : {{Carbon\Carbon::createFromDate($payslip->payment_date)->format('M Y')}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>Employee ID :</strong> {{$payslip->users == null ? "" : $payslip->users->number_employee}}</li>
                                    <li><strong>Position :</strong> {{$payslip->users == null ? "" : $payslip->users->EmployeePosition}}</li>
                                    <li><strong>Joining Date :</strong> {{$payslip->users == null ? "" : $payslip->users->joinOfDate}}</li>
                                    <li><strong>Location :</strong> {{$payslip->users == null ? "" : $payslip->users->EmployeeBranch}}</li>
                                </ul>
                            </div>
                            <div class="col-lg-4 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>Employee Name :</strong> {{$payslip->users == null ? "" : $payslip->users->employee_name_en}}</li>
                                    <li><strong>Departement :</strong> {{$payslip->users == null ? "" : $payslip->users->EmployeeDepartment}}</li>
                                    <li><strong>Basic Rate :</strong> {{$payslip->total_rate}}%</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="tr-bckground-ch">
                                                <th>Earning </th>
                                                <th style="text-align: center;">Amount</th>
                                                <th>Deduction </th>
                                                <th style="text-align: center;">Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Gross Salary</td>
                                                <td>
                                                    <span class="float-end">$ {{$payslip->total_gross_salary}}</span>
                                                </td>
                                                <td>Personal Tax</td>
                                                <td>
                                                    <span class="float-end">$ {{$payslip->total_salary_tax_usd}}</span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Increasment</td>
                                                <td>
                                                    <span class="float-end">$ 0.00</span>
                                                </td>
                                                <td>Pension Fund</td>
                                                <td>
                                                    <span class="float-end">$ {{$payslip->total_pension_fund}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Incentive</td>
                                                <td>
                                                    <span class="float-end">$ 0.00</span>
                                                </td>
                                                <td>Staff loan</td>
                                                <td>
                                                    <span class="float-end">$ 0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bonus(Annual/PB/KNY)</td>
                                                <td>
                                                    <span class="float-end">$ {{$payslip->total_kny_phcumben}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Seniority pay</td>
                                                <td>
                                                    <span class="float-end">$ {{$payslip->tax_free_seniority_allowance}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Severance Pay</td>
                                                <td>
                                                    <span class="float-end">$ {{$payslip->total_severance_pay}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Adjustment(+/-)</td>
                                                <td>
                                                    <span class="float-end">$ 0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Leaves  (+/-)</td>
                                                <td>
                                                    <span class="float-end">$ 0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Phone Allowance</td>
                                                <td>
                                                    <span class="float-end">$ {{$payslip->phone_allowance}}</span>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #d2dbdb;">
                                                <td><strong>Total Earnings</strong></td>
                                                <td>
                                                    <span class="float-end"><strong>$ {{$payslip->total_gross_salary + $payslip->phone_allowance + $payslip->total_severance_pay + $payslip->tax_free_seniority_allowance + $payslip->total_kny_phcumben}}</strong></span>
                                                </td>
                                                <td><strong>Total Deductions :</strong></td>
                                                <td><span class="float-end"><strong>$ {{$payslip->total_salary_tax_usd +$payslip->total_pension_fund}}</strong></span></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><p><strong>Total Net Pay:</strong></p></td>
                                                <td><span class="float-end"><strong>$ 598</strong></span></td>
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
    </div>
    @include('payrolls.print_payroll')
@endsection

@include('includs.script')
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script type="text/javascript">

    $(function() {
        $("#btn_print_payroll").on("click", function() {
            printPayroll_pdf();
        });
    });

    function printPayroll_pdf(type) {
        $("#print_payroll").show();

        $("#btn-print-loading").css('display', 'block');
        $("#btn_print").prop('disabled', true);
        $(".btn-text-print").hide();

        window.setTimeout(function() {
            $("#print_payroll").hide();
            $("#btn_print").prop('disabled', false);
            $(".btn-text-print").show();
            $("#btn-print-loading").css('display', 'none');
        }, 2000);

        $("#print_payroll").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "/admin/css/style_table.css",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>