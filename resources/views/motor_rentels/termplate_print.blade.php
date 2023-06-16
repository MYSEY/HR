<div id="print_purchase" hidden>
    <div class="card-header">
        {{-- logo company --}}
        <div style="margin-top: 10px">
            <img style="width:auto;height: 80px;"alt='White' id="image_logo_print"
                src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
        </div>

        <div style="margin-top:-75px; margin-left:243px">
            <h3 class="payslip-title-center">EMPLOYEE PAYSLIP</h3>
            <p class="payslip-title-center">Monthly Motor Rental Fee &nbsp;
                <strong>{{ \Carbon\Carbon::parse($data->created_at)->format('M-Y') ?? '' }}</strong>
            </p>
        </div>
        <div style="width: 35%">
            <label>Camma Microfinance Limited</label>
            <span>{{$data->MotorEmployee->BranchAddress}}</span>
        </div>
        <div style="display:flex; margin-top: 5%;">
            
            <div style="width: 350%">
                <span><strong>Employee ID:</strong> {{ $data->MotorEmployee->number_employee }}</span><br>
                <span><strong>Position:</strong> {{ $data->MotorEmployee->EmployeePosition }}</span><br>
                <span><strong>Date of Commencement:</strong>
                    {{ \Carbon\Carbon::parse($data->MotorEmployee->date_of_commencement)->format('d-M-Y') }}</span><br>
                <span><strong>Total Amount of workday:</strong> {{ $data->total_work_day }}</span><br>
                <span><strong>Total Casoline (Month):</strong>
                    {{ number_format($data->total_gasoline * $data->total_work_day * $data->gasoline_price_per_liter) }}
                    ៛</span>
            </div>
            <div style="width: 350%">
                <span><strong>Name:</strong> {{ $data->MotorEmployee->employee_name_en }}</span><br>
                <span><strong>Department:</strong> {{ $data->MotorEmployee->department->name_khmer }}</span><br>
                <span><strong>Branch:</strong> {{ $data->MotorEmployee->branch->branch_name_en }}</span><br>
                <span><strong>Average Unit Price (Gasoline/1L):</strong>
                    {{ number_format($data->gasoline_price_per_liter) }} ៛</span>
            </div>
        </div>
        <br>
        <span>
            <table class="table-a">
                <thead>
                    <tr class="tr-bckground-ch">
                        <th>Earning </th>
                        <th>Amount</th>
                        <th>Deduction </th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gross Motor rental fee ($) :</td>
                        <td>
                            <span class="float-end">$
                                {{ number_format($data->price_motor_rentel, 2) }}</span>
                        </td>
                        <td>Motor rental fee Tax (10%) : </td>
                        <td>
                            <span class="float-end">$
                                {{ number_format(($data->price_motor_rentel * $data->tax_rate) / 100, 2) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Gross Taplab fee ($): </td>
                        <td><span class="float-end">$
                            {{ number_format($data->price_taplab_rentel, 2) }}</span></td>
                        <td>Taplab fee Tax (10%) :</td>
                        <td>
                            <span class="float-end">$
                                {{ number_format(($data->price_taplab_rentel * $data->tax_rate) / 100, 2) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Engine oil ($):</td>
                        <td><span class="float-end">$ {{ $data->price_engine_oil }}</span></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Gasoline (Reil)</td>
                        <td>
                            <span class="float-end">៛ {{ number_format($data->gasoline_price_per_liter) }} </span>
                        </td>
                        <td>Other Deduction: </td>
                        <td>

                        </td>
                    </tr>
                    <tr class="tr-background-83">
                        <td>Total Earnings ($): </td>
                        <td>
                            <span class="float-end">$ {{ number_format($data->price_motor_rentel + $data->price_taplab_rentel + $data->price_engine_oil, 2) }}</span>
                        </td>
                        <td>Total Deductions ($): </td>
                        <td>
                            <span class="float-end">$
                                {{ number_format((($data->price_taplab_rentel * $data->tax_rate) + ($data->price_motor_rentel * $data->tax_rate)) / 100, 2) }}</span>
                        </td>
                    </tr>
                    <tr class="tr-background-83">
                        <td>Total Earnings (Reil): </td>
                        <td>
                            <span class="float-end">៛
                                {{ number_format($data->gasoline_price_per_liter) }} </span>    
                        </td>
                        <td>Total Deductions (Reil): </td>
                        <td>
                            <span class="float-end">៛ 0.00</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-border"></td>
                        <td class="td-border"></td>
                        <td class="td-background-cc">Total Net Pay ($):</td>
                        <td class="td-background-cc">
                            <span class="float-end">$ {{number_format(($data->price_motor_rentel + $data->price_taplab_rentel + $data->price_engine_oil) - ((($data->price_taplab_rentel * $data->tax_rate) + ($data->price_motor_rentel * $data->tax_rate)) / 100), 2) }} </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-border"> </td>
                        <td class="td-border"></td>
                        <td class="td-background-cc">Total Net Pay (Reil):</td>
                        <td class="td-background-cc">
                            <span class="float-end">៛ {{ number_format(($data->total_gasoline * $data->total_work_day) * $data->gasoline_price_per_liter) }}</span>
                        </td>
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