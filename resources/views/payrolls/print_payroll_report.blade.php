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
                                <td>{{ $item->number_employee}}</td>
                                <td>{{ Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh }}</td>
                                <td>{{Helper::getLang() == 'en' ? $item->depart_name_en : $item->depart_name_kh}}</td>
                                <td>{{Helper::getLang() == 'en' ? $item->position_name_english : $item->position_name_khmer}}</td>
                                <td>{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</td>
                                <td>{{ Carbon\Carbon::parse($item->date_of_commencement)->format('d-M-Y')}}</td>
                                <td>{{ $item->basic_salary }}</td>
                                <td>{{ $item->total_child_allowance }}</td>
                                <td>{{ $item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</td>
                                <td>{{ $item->total_kny_phcumben}}</td>
                                <td>{{ $item->total_gross_salary }}</td>
                                <td>{{ $item->seniority_pay_excluded_tax}}</td>
                                <td>{{ $item->total_pension_fund}}</td>
                                <td>{{ $item->base_salary_received_usd}}</td>
                                <td>{{ $item->seniority_pay_excluded_tax}}</td>
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
    </div>
</div>

