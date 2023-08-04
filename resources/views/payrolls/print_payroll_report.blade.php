<div id="print_purchase" hidden>
    <div class="card-header">
        <div style="margin-top: 10px">
            <img style="width:auto;height: 90px;"alt='White' id="image_logo_print"
                src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
        </div>

        <div style="margin-top:-75px; text-align: center">
            <h2>CAMMA Microfinance Limited</h2>
        </div>
        
        <div class="font-sub-title">
            <label class="title">Report of <span id="title_print">Basic Salary</span></label><br>
        </div><br>
        <div id="table_print_basic_salary">
            <table class="table-print" id="table_print_filter_basic_salary">
                <thead>
                    <tr>
                        <th >Employee ID</th>
                        <th >Employee Name</th>
                        <th >Department</th>
                        <th >Position</th>
                        <th >Branch</th>
                        <th >Join Date</th>
                        <th >Basic Salary ($)</th>
                        <th >Child Allowance ($)</th>
                        <th >Phone Allowance ($)</th>
                        <th >KNY / Pchum Ben ($)</th>
                        <th >Total Gross Salary ($)</th>
                        <th >Seniority Payable Tax ($)</th>
                        <th >Pension Fund ($)</th>
                        <th >Base Salary Received ($)</th>
                        <th >Tax-free Seniority ($)</th>
                        <th >Severance Pay ($)</th>
                        <th >Net Salary ($)</th>
                        <th >Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($payroll)>0)
                        @foreach ($payroll as $item)
                            <tr class="odd">
                                <td>{{ $item->users == null ? '' : $item->users->number_employee }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->employee_name_en }}</td>
                                <td>{{$item->users == null ? '' : $item->users->EmployeeDepartment}}</td>
                                <td>{{ $item->users == null ? '' : $item->users->EmployeePosition}}</td>
                                <td>{{ $item->users == null ? '' : $item->users->EmployeeBranch}}</td>
                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate}}</td>
                                <td>{{ $item->basic_salary }}</td>
                                <td>{{ $item->total_child_allowance }}</td>
                                <td>{{ $item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</td>
                                <td>{{ $item->total_kny_phcumben}}</td>
                                <td>{{ $item->total_gross_salary }}</td>
                                <td>{{ $item->seniority_payable_tax}}</td>
                                <td>{{ $item->total_pension_fund}}</td>
                                <td>{{ $item->base_salary_received_usd}}</td>
                                <td>{{ $item->tax_free_seniority_allowance}}</td>
                                <td>{{ $item->total_severance_pay}}</td>
                                <td>{{ $item->total_salary }}</td>
                                <td>{{ $item->payment_date}}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="18" style="text-align: center">No data available for display</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="table_print_nssf" hidden>
            <table class="table-print" id="table_print_filter_nssf">
                <thead>
                    <tr>
                        <th >Employee ID</th>
                        <th >Full Name</th>
                        <th >Join Date</th>
                        <th >Total salary before tax dollars</th>
                        <th >Total salary before tax Riel</th>
                        <th >Average wage</th>
                        <th >Occupational risk</th>
                        <th >Health Care </th>
                        <th >Pension contribution Riel</th>
                        <th >Pension contribution dollar</th>
                        <th >Enterprise pension contribution</th>
                        <th  >Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($dataNSSF) > 0)
                        @foreach ($dataNSSF as $item)
                            <tr class="odd">
                                <td>{{ $item->users == null ? '' : $item->users->number_employee }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->employee_name_en }}</td></td></td>
                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                <td>$ {{ $item->total_pre_tax_salary_usd }}</td>
                                <td><span>៛</span> {{ $item->total_pre_tax_salary_riel }}</td>
                                <td>{{ $item->total_average_wage }}</td>
                                <td>{{ $item->total_occupational_risk }}</td>
                                <td>{{ $item->total_health_care }}</td>
                                <td><span>៛</span> {{ $item->pension_contribution_usd }}</td>
                                <td>$  {{ $item->pension_contribution_riel }}</td>
                                <td>{{ $item->corporate_contribution }}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="12" style="text-align: center">No data available for display</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="table_print_benefit" hidden>
            <table class="table-print" id="table_print_filter_benefit">
                <thead>
                    <tr>
                        <th >Employee ID</th>
                        <th >Full Name</th>
                        <th >Join Date</th>
                        <th >Number Of Working Days</th>
                        <th >Basic Salary</th>
                        <th >Basic Salary Received </th>
                        <th > Total Allowance</th>
                        <th >Created At </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($benefit) > 0)
                        @foreach ($benefit as $item)
                            <tr class="odd">
                                <td>{{ $item->users == null ? '' : $item->users->number_employee }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->employee_name_en }}</td></td></td>
                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>

                                <td>{{ $item->number_of_working_days }} Days</td>
                                <td>$ {{ $item->base_salary }}</td>
                                <td>{{ $item->base_salary_received }}</td>
                                <td>{{ $item->total_allowance }}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align: center">No data available for display</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="table_print_seniority_pay" hidden>
            <table class="table-print" id="table_print_filter_seniority_pay">
                <thead>
                    <tr>
                        <th >Employee ID</th>
                        <th >Full Name</th>
                        <th >Position</th>
                        <th >Join Date</th>
                        <th >Months</th>
                        <th >Total Average Salary</th>
                        <th >Total Salary Receive</th>
                        <th >Tax Exemption Salary</th>
                        <th >Taxable Salary</th>
                        <th >Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($dataSeniority) > 0)
                        @foreach ($dataSeniority as $item)
                            <tr class="odd">
                                <td>{{ $item->users == null ? '' : $item->users->number_employee }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->employee_name_en }}</td>
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
                            <td colspan="10" style="text-align: center">No data available for display</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="table_print_severance_pay" hidden>
            <table class="table-print" id="table_print_filter_severance_pay">
                <thead>
                    <tr>
                        <th >Employee ID</th>
                        <th >Full Name</th>
                        <th >Position</th>
                        <th >Join Date</th>
                        <th >Total Severanec Pay</th>
                        <th >Total Contract Severance Pay</th>
                        <th >Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($severancePay) > 0)
                        @foreach ($severancePay as $item)
                            <tr class="odd">
                                <td>{{ $item->users == null ? '' : $item->users->number_employee }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->employee_name_en }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->EmployeePosition }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                <td>{{ $item->total_severanec_pay }}</td>
                                <td>{{ $item->total_contract_severance_pay }}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" style="text-align: center">No data available for display</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

