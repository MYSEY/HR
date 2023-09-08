

@extends('layouts.master')
@inject('numbersToWords', 'App\Traits\Convertors\ConvertNumbersToWordsClassForBlade')
@inject('number_trait', 'App\Traits\Convertors\NumberBlade')
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
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.payslip')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.payslip') / <a href="{{url('payroll')}}">@lang('lang.back_to_list')</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group btn-group-sm">
                        {{-- <button class="btn btn-white">CSV</button>
                        <button class="btn btn-white">PDF</button> --}}
                        <button class="btn btn-white" target="_blank" id="btn_print_payroll"><i class="fa fa-print fa-lg"></i> @lang('lang.print')</button>
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
                                    <li>@lang('lang.camma_microfinance_limited')</li>
                                    <li>{{$payslip->users == null ? "" : $payslip->users->BranchAddress}}</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h4 class="payslip-title">@lang('lang.employee_payslip')</h4>
                                <h5 class="payslip-title">{{Helper::getLang() == 'en' ? Helper::geENMonths($payslip->payment_date)  : Helper::getKhmerMonths($payslip->payment_date)}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>@lang('lang.employee_id') :</strong> {{$payslip->users == null ? "" : $payslip->users->number_employee}}</li>
                                    <li><strong>@lang('lang.position') :</strong> {{$payslip->users == null ? "" : $payslip->users->EmployeePosition}}</li>
                                    <li><strong>@lang('lang.joining_date') :</strong> {{$payslip->users == null ? "" : $payslip->users->joinOfDate}}</li>
                                    <li><strong>@lang('lang.location') :</strong> {{$payslip->users == null ? "" : $payslip->users->EmployeeBranch}}</li>
                                </ul>
                            </div>
                            <div class="col-lg-6 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>@lang('lang.employee_name') :</strong> {{Helper::getLang() == 'en' ? $payslip->users->employee_name_en : $payslip->users->employee_name_kh}}</li>
                                    <li><strong>@lang('lang.department') :</strong> {{$payslip->users == null ? "" : $payslip->users->EmployeeDepartment}}</li>
                                    <li><strong>@lang('lang.basic_rate') :</strong> {{$payslip->total_rate}}%</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="tr-bckground-ch">
                                                <th>@lang('lang.earning') </th>
                                                <th style="text-align: right;">@lang('lang.amount')</th>
                                                <th>@lang('lang.deduction') </th>
                                                <th style="text-align: right;">@lang('lang.amount')</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr>
                                                <td>@lang('lang.gross_salary')</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->total_gross_salary}}</span>
                                                </td>
                                                <td>@lang('lang.personal_tax')</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->total_salary_tax_usd}}</span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>@lang('lang.increasment')</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->users->salary_increas == null ? "0.00" : $payslip->users->salary_increas}}</span>
                                                </td>
                                                <td>@lang('lang.pension_fund')</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->total_pension_fund}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>@lang('lang.incentive')</td>
                                                <td>
                                                    <span class="float-end">$0.00</span>
                                                </td>
                                                <td>@lang('lang.staff_loan')</td>
                                                <td>
                                                    <span class="float-end">$0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>@lang('lang.bonus')(@lang('lang.annual/PB/KNY'))</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->total_kny_phcumben}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>@lang('lang.seniority_pay') (@lang('lang.included_tax'))</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->seniority_pay_included_tax}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>@lang('lang.seniority_pay') (@lang('lang.excluded_tax'))</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->seniority_pay_excluded_tax}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>@lang('lang.severance_pay')</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->total_severance_pay}}</span>
                                                </td>
                                            </tr>
                                            {{-- <tr>
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
                                            </tr> --}}
                                            <tr>
                                                <td>@lang('lang.phone')</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->phone_allowance ?? '0.00'}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>@lang('lang.child_allowance')</td>
                                                <td>
                                                    <span class="float-end">${{$payslip->total_child_allowance}}</span>
                                                </td>
                                            </tr>
                                            @php
                                                $TotalEarnings = $payslip->total_gross_salary + $payslip->phone_allowance + $payslip->total_severance_pay + $payslip->seniority_pay_excluded_tax + $payslip->seniority_pay_included_tax + $payslip->total_kny_phcumben
                                            @endphp
                                            @php
                                                $TotalDeductions = $payslip->total_salary_tax_usd + $payslip->total_pension_fund;
                                            @endphp
                                            @php
                                                $totalNetPay = $TotalEarnings - $TotalDeductions;
                                            @endphp
                                            {{-- @dd($numbersToWords->convertNumbers2Words($TotalDeductions, 1)) --}}
                                            <tr style="background-color: #d2dbdb;">
                                                <td><strong>@lang('lang.total_earnings')</strong></td>
                                                <td>
                                                    <span class="float-end"><strong>${{number_format($TotalEarnings, 2)}}</strong></span>
                                                </td>
                                                <td><strong>@lang('lang.total_deductions') :</strong></td>
                                                <td><span class="float-end"><strong>${{number_format($TotalDeductions, 2)}}</strong></span></td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><p><strong>@lang('lang.total_net_pay'):</strong></p></td>
                                                <td><span class="float-end"><strong>${{number_format($totalNetPay, 2)}}</strong></span></td>
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
            loadCSS: "{{asset('/admin/css/style_table.css')}}",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>