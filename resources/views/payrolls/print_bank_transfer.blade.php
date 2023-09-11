<div id="print_purchase" hidden>
    <div class="card-header">
        {{-- logo company --}}
        <div style="margin-top: 10px">
            <img style="width:auto;height: 90px;"alt='White' id="image_logo_print"
                src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
        </div>
        <div style="margin-top:-90px; text-align: center">
            <h3>@lang('lang.camma_microfinance_limited')</h3>
            <p class="payslip-title-center">@lang('lang.payroll_statement')(…......April.........)  &nbsp;
            </p>
        </div>
        <div style="display:flex;">
            <span style="font-size: 13px">@lang('lang.please_kindly_transfer_from_account_number_3100-02-146868-68_to_camma_microfinanace_limited._employees_as_below') :</span><br>
        </div>
        <div>
            <table class="table-print">
                <body>
                    <tr>
                        <td class="style-oadding-lest">@lang('lang.payroll_amount')</td>
                        <th>$ 103602.48</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="style-oadding-lest">@lang('lang.payroll_service')</td>
                        <th>$ 47.48</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="style-oadding-lest">@lang('lang.local_fee')</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="style-oadding-lest">@lang('lang.total_pay')</td>
                        <th>$ 1036490.96</th>
                        <td>@lang('lang.valid_date') : ( 1/25/2023 )</td>
                    </tr>
                    <tr>
                        <td class="style-oadding-lest">@lang('lang.fee_charge_deduce_from_main_account')</td>
                        <td></td>
                        <td>@lang('lang.valid_time') : ( 11:00AM )</td>
                    </tr>
                </body>
            </table>
        </div><br>
        <div>
            <table class="table-print-body">
                <thead>
                    <tr>
                        <th>@lang('lang._no').</th>
                        <th>@lang('lang.name_in_khmer')</th>
                        <th>@lang('lang.name_in_english')</th>
                        <th>@lang('lang.bank_account_number')</th>
                        <th>@lang('lang.fee')</th>
                        <th>@lang('lang.amounts')</th>
                        <th>@lang('lang.other')</th>
                    </tr>
                </thead>
                <body>
                    @php
                        $totolSaraly = 0;
                        $totolFee = 0;
                    @endphp
                    @if (count($data)>0)
                        @foreach ($data as $key=>$item)
                            @php
                                $totolSaraly += $item->total_salary;
                                $totolFee += 0.20;
                            @endphp
                            <tr class="odd">
                                <td>{{++$key}}</td>
                                <td>{{ $item->users == null ? '' : $item->users->employee_name_kh}}</td>
                                <td>{{ $item->users == null ? '' : $item->users->employee_name_en }}</td>
                                <td>{{ $item->users == null ? '' : $item->users->account_number }}</td>
                                <td>$ 0.20</td>
                                <td>$ {{$item->total_salary}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <th colspan="4" style="text-align: center">@lang('lang.total_amount')</th>
                        <th>$ {{$totolFee}}</th>
                        <th>$ {{$totolSaraly}}</th>
                        <td></td>
                    </tr>
                </body>
            </table>
        </div>
        <div style="display: flex; margin-top: 5px">
            <div class="payslip-title-center">
                <p>@lang('lang.date'): ......... /............. /..........</p>
                <p style="margin-left: 10%">@lang('lang.approved_by')</p><br><br><br>

                <p><strong>@lang('lang.mrs_nuth_seila')</strong></p>
                {{-- <div style="text-align: center"> --}}
                    <p>@lang('lang.deputy_head_of_accounting_and_inance_epartment').</p>
                {{-- </div> --}}
            </div>
            <div class="payslip-title-center" style="text-align: center">
                <p>@lang('lang.date'): ......... /............. /..........</p>
                <p>@lang('lang.verified_by')</p><br><br><br>

                <p><strong>@lang('lang.mr_pheng_putmetrey')</strong></p>
                <p>@lang('lang.head_of_hr_and_admin_department').</p>
            </div>
            <div class="payslip-title-center" style="margin-left: 8%">
                <p>@lang('lang.date'): ......... /............. /..........</p>
                <div style="text-align: center">
                    <p>@lang('lang.prepare_by')</p><br><br><br>

                    <p><strong>@lang('lang.mr._chhor_oudam')</strong></p>
                    <p>@lang('lang.senior_personnel_&_recruitement_manager').</p>
                </div>
            </div>
        </div>
    </div>
</div>