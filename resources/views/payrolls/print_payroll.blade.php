<div id="print_payroll" hidden>
    <div class="card-header">
        <div class="card-header">
            {{-- logo company --}}
            <div style="margin-top: 10px">
                <img style="width:auto;height: 80px;"alt='White' id="image_logo_print" src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
            </div>
    
            <div style="margin-top:-75px; text-align: center">
                <h3 class="payslip-title-center">EMPLOYEE PAYSLIP</h3>
                <p class="payslip-title-center">Monthly Payroll : {{Carbon\Carbon::createFromDate($payslip->payment_date)->format('M Y')}}</strong>
                </p>
            </div>
            <div style="width: 35%">
                <label>Camma Microfinance Limited</label>
                <span>{{$payslip->users == null ? "" : $payslip->users->BranchAddress}}</span>
            </div>
            <div style="display:flex; margin-top: 5%;">
                <div style="width: 350%">
                    <strong>Employee ID :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->number_employee}}</span><br>
                    <strong>Position :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->EmployeePosition}}</span><br>
                    <strong>Joining Date :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->joinOfDate}}</span><br>
                    <strong>Location :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->EmployeeBranch}}</span><br>
                </div>
                <div style="width: 350%">
                    <strong>Employee Name :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->employee_name_en}}</span><br>
                    <strong>Departement :</strong> <span>{{$payslip->users == null ? "" : $payslip->users->EmployeeDepartment}}</span><br>
                    <strong>Basic Rate :</strong> <span>{{$payslip->total_rate}}%</span><br>
                </div>
            </div>
            <br>
            <span>
                <table class="table-a">
                    <thead>
                        <tr>
                            <th>Earning </th>
                            <th>Amount</th>
                            <th>Deduction </th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-0 text-nowrap">Gross Salary</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ {{$payslip->total_gross_salary}}</span></td>
                            <td class="border-0 text-nowrap">Personal Tax</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ {{$payslip->total_salary_tax_usd}}</span></td>
                        </tr>
                        
                        <tr>
                            <td class="border-0 text-nowrap">Increasment</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ 0.00</span></td>
                            <td class="border-0 text-nowrap">Pension Fund</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ {{$payslip->total_pension_fund}}</span></td>
                        </tr>
                        <tr>
                            <td class="border-0 text-nowrap">Incentive</td>
                            <td class="border-0 fw-bolder">
                                <span class="float-end">$ 0.00</span>
                            </td>
                            <td class="border-0 text-nowrap">Staff loan</td>
                            <td><span class="float-end">$ 0.00</span></td>
                        </tr>
                        <tr>
                            <td class="border-0 text-nowrap">Bonus(Annual/PB/KNY)</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ {{$payslip->total_kny_phcumben}}</span></td>
                        </tr>
                        <tr>
                            <td class="border-0 text-nowrap">Seniority pay</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ {{$payslip->seniority_pay_excluded_tax}}</span></td>
                        </tr>
                        <tr>
                            <td class="border-0 text-nowrap">Severance Pay</td>
                            <td class="border-0 fw-bolder">
                                <span class="float-end">$ {{$payslip->total_severance_pay}}</span>
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
                            <td class="border-0 text-nowrap">Phone Allowance</td>
                            <td class="border-0 fw-bolder"><span class="float-end">$ {{$payslip->phone_allowance}}</span></td>
                        </tr>
                        <tr style="background-color: #d2dbdb;">
                            <td><strong>Total Earnings</strong></td>
                            <td>
                                <span class="float-end"><strong>$ {{$payslip->total_gross_salary + $payslip->phone_allowance + $payslip->total_severance_pay + $payslip->seniority_pay_excluded_tax + $payslip->total_kny_phcumben}}</strong></span>
                            </td>
                            <td><strong>Total Deductions :</strong></td>
                            <td><span class="float-end"><strong>$ {{$payslip->total_salary_tax_usd +$payslip->total_pension_fund}}</strong></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><p><strong>Total Net Pay :</strong></p></td>
                            <td><span class="float-end"><strong>$ 596</strong></span></td>
                        </tr>
                    </tbody>
                </table>
            </span><br>
            <div style="display: flex">
                <div class="payslip-title-center">
                    <p style="text-align: center"><strong>Employer Signature</strong></p><br><br><br>
                    <p>......... /............. /..........</p>
                </div>
                <div class="payslip-title-center" style="margin-left: 58%">
                    <p style="text-align: center"><strong>Employee Signature</strong></p><br><br><br>
                    <p>......... /............ /..........</p>
                </div>
            </div>
        </div>
    </div>
</div>