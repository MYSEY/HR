<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .relate {
            position: relative;
        }
        .page[size="A5"] {
            width: 21cm;
            height: 29.7cm;
        }
        .page[size="A5"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }
        .img-sign {
            width:auto;
            height: 90px;
            object-fit: cover;
        }
        .table-font{
            font-family: 'Nunito','Nokora', sans-serif, serif;
            border-collapse: collapse;
            width: 90%;
            font-size: 11px;
        }
        .A5{
            font-size: 11px;
        }
        table .table-font{
            font-family: 'Nunito','Nokora', sans-serif, serif;
            border-collapse: collapse;
            border: 1px;
        }
    </style>
</head>
<body>
    <div id="print_payroll" hidden>
        <div size="A5" class="relate page">
            <div style="justify-content: center;justify-item:center">
                <div>
                    <img alt='logo' class="img-sign" src="{{ asset('/admin/img/logo/commalogo1.png') }}">
                </div>
        
                <div style="margin-top:-85px; text-align: center">
                    <h3 class="payslip-title-center">@lang('lang.employee_payslip')</h3>
                    <p class="payslip-title-center">{{ Helper::getLang() == 'en' ? Helper::geENMonths($payslip->payment_date)  : Helper::getKhmerMonths($payslip->payment_date)}}</p>
                </div>
                <div style="width: 40%">
                    <label>@lang('lang.camma_microfinance_limited')</label><br>
                    <span>{{$payslip->users == null ? "" : $payslip->users->BranchAddress}}</span>
                </div>
                <div style="display:flex; margin-top: 5%;">
                    <div style="width: 350%">
                        <strong>@lang('lang.employee_id') :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->number_employee}}</span><br>
                        <strong>@lang('lang.position') :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->EmployeePosition}}</span><br>
                        <strong>@lang('lang.joining_date') :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->joinOfDate}}</span><br>
                        <strong>@lang('lang.location') :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->EmployeeBranch}}</span><br>
                    </div>
                    <div style="width: 350%">
                        <strong>@lang('lang.employee_name') :</strong> <span>{{Helper::getLang() == 'en' ? $payslip->users->employee_name_en :  $payslip->users->employee_name_kh}}</span><br>
                        <strong>@lang('lang.department') :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->EmployeeDepartment}}</span><br>
                        <strong>@lang('lang.basic_rate') :</strong> <span>{{$payslip->total_rate}}%</span><br>
                    </div>
                </div>
                <br>
                <table class="table-font">
                    <thead>
                        <tr>
                            <th>@lang('lang.earning') </th>
                            <th>@lang('lang.amount')</th>
                            <th>@lang('lang.deduction') </th>
                            <th>@lang('lang.amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-0 text-nowrap">@lang('lang.gross_salary')</td>
                            <td class="border-0 fw-bolder"><span class="float-end">${{$payslip->total_gross_salary}}</span></td>
                            <td class="border-0 text-nowrap">@lang('lang.personal_tax')</td>
                            <td class="border-0 fw-bolder"><span class="float-end">${{$payslip->total_salary_tax_usd}}</span></td>
                        </tr>
                        
                        <tr>
                            <td class="border-0 text-nowrap">@lang('lang.increasment')</td>
                            <td class="border-0 fw-bolder"><span class="float-end">${{$payslip->salary_increas ?? '0'}}</span></td>
                            <td class="border-0 text-nowrap">@lang('lang.pension_fund')</td>
                            <td class="border-0 fw-bolder"><span class="float-end">${{$payslip->total_pension_fund}}</span></td>
                        </tr>
                        <tr>
                            <td class="border-0 text-nowrap">@lang('lang.incentive')</td>
                            <td class="border-0 fw-bolder">
                                <span class="float-end">$0.00</span>
                            </td>
                            <td class="border-0 text-nowrap">@lang('lang.staff_loan')</td>
                            <td><span class="float-end">$0.00</span></td>
                        </tr>
                        <tr>
                            <td class="border-0 text-nowrap">@lang('lang.allowance')(@lang('lang.annual/PB/KNY'))</td>
                            <td class="border-0 fw-bolder"><span class="float-end">${{$payslip->total_kny_phcumben}}</span></td>
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
                            <td class="border-0 text-nowrap">@lang('lang.severance_pay')</td>
                            <td class="border-0 fw-bolder">
                                <span class="float-end">${{$payslip->total_severance_pay}}</span>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td class="border-0 text-nowrap">Adjustment(+/-)</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ 0.00</span></td>
                        </tr>
                        <tr>
                            <td class="border-0 text-nowrap">Leaves  (+/-)</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ 0.00</span></td>
                        </tr> --}}
                        <tr>
                            <td class="border-0 text-nowrap">@lang('lang.phone_allowance')</td>
                            <td class="border-0 fw-bolder"><span class="float-end">${{$payslip->phone_allowance ?? '0.00'}}</span></td>
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
                        <tr style="background-color: #d2dbdb;">
                            <td><strong>@lang('lang.total_earnings') :</strong></td>
                            <td>
                                <span class="float-end"><strong>${{number_format($TotalEarnings, 2)}}</strong></span>
                            </td>
                            <td><strong>@lang('lang.total_deductions') :</strong></td>
                            <td><span class="float-end"><strong>${{number_format($TotalDeductions, 2)}}</strong></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><p><strong>@lang('lang.total_net_pay') :</strong></p></td>
                            <td><span class="float-end"><strong>${{number_format($totalNetPay, 2)}}</strong></span></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div style="display: flex">
                    <div class="payslip-title-center">
                        <p style="text-align: center"><strong>@lang('lang.employer_signature')</strong></p><br><br><br>
                        <p>......... /............. /..........</p>
                    </div>
                    <div class="payslip-title-center" style="margin-left: 58%">
                        <p style="text-align: center"><strong>@lang('lang.employee_signature')</strong></p><br><br><br>
                        <p>......... /............ /..........</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>