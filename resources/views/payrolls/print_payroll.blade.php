<div id="print_payroll" hidden>
    <div class="card-header">
        <div class="card-header">
            {{-- logo company --}}
            <div style="margin-top: 10px">
                <img style="width:auto;height: 80px;"alt='White' id="image_logo_print" src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
            </div>
    
            <div style="margin-top:-75px; text-align: center">
                <h3 class="payslip-title-center">@lang('lang.employee_payslip')</h3>
                <p class="payslip-title-center">@lang('lang.monthly_payroll') : {{Carbon\Carbon::createFromDate($payslip->payment_date)->format('M Y')}}</strong>
                </p>
            </div>
            <div style="width: 35%">
                <label>@lang('lang.camma_microfinance_limited')</label>
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
                    <strong>@lang('lang.employee_name') :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->employee_name_en}}</span><br>
                    <strong>@lang('lang.department') :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->EmployeeDepartment}}</span><br>
                    <strong>@lang('lang.basic_rate') :</strong> <span>{{$payslip->total_rate}}%</span><br>
                </div>
            </div>
            <br>
            <span>
                <table class="table-a">
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
                            <td class="border-0 fw-bolder"><span class="float-end">$ 0.00</span></td>
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
                            <td class="border-0 text-nowrap">@lang('lang.bonus')(@lang('lang.annual/PB/KNY'))</td>
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
                            <td class="border-0 text-nowrap">@lang('lang.phone')</td>
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
            </span><br>
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