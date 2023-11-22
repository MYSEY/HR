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
    <div id="print_purchase" hidden>
        <div size="A5" class="relate page">
            {{-- logo company --}}
            <div>
                <img alt='logo' class="img-sign" src="{{ asset('/admin/img/logo/commalogo1.png') }}">
            </div>
    
            <div style="margin-top:-100px; text-align: center">
                <h3 class="payslip-title-center">@lang('lang.employee_payslip')</h3>
                <p class="payslip-title-center">{{ Helper::getLang() == 'en' ? Helper::getENMonthsMotorRantal($data->created_at) : Helper::getKhmerMonthsMotorRantal($data->created_at) }}</p>
            </div>
            <div style="width: 35%">
                <label>@lang('lang.camma_microfinance_limited')</label><br>
                <span>{{$data->MotorEmployee->BranchAddress}}</span>
            </div>
            <div style="display:flex; margin-top: 5%;">
                
                <div style="width: 350%">
                    <span><strong>@lang('lang.employee_id') : </strong>{{ $data->MotorEmployee->number_employee }}</span><br>
                    <span><strong>@lang('lang.position') : </strong>{{ $data->MotorEmployee->EmployeePosition }}</span><br>
                    <span><strong>@lang('lang.date_of_commencement') : </strong>{{ \Carbon\Carbon::parse($data->MotorEmployee->date_of_commencement)->format('d-M-Y') }}</span><br>
                    <span><strong>@lang('lang.total_amount_of_workday') : </strong>{{ $data->total_work_day }}</span><br>
                    <span><strong>@lang('lang.total_gasoline') (@lang('lang.month')) : </strong>{{ number_format($data->total_gasoline * $data->total_work_day) }} L
                    </span>
                </div>
                <div style="width: 350%">
                    <span><strong>@lang('lang.name') : </strong>{{ Helper::getLang() == 'en' ? $data->MotorEmployee->employee_name_en : $data->MotorEmployee->employee_name_kh }}</span><br>
                    <span><strong>@lang('lang.department') : </strong>{{ Helper::getLang() == 'en' ? $data->MotorEmployee->department->name_english :$data->MotorEmployee->department->name_khmer }}</span><br>
                    <span><strong>@lang('lang.location') : </strong>{{ Helper::getLang() == 'en' ? $data->MotorEmployee->branch->branch_name_en : $data->MotorEmployee->branch->branch_name_kh }}</span><br>
                    <span><strong>@lang('lang.average_unit_price') (@lang('lang.gasoline')/1L) : </strong>{{ number_format($data->gasoline_price_per_liter) }} ៛</span>
                </div>
            </div>
            <br>
            <span>
                <table class="table-font">
                    <thead>
                        <tr class="tr-bckground-ch">
                            <th>@lang('lang.earning') </th>
                            <th>@lang('lang.amount')</th>
                            <th>@lang('lang.deduction') </th>
                            <th>@lang('lang.amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>@lang('lang.gross_motor_rental_fee') (៛) :</td>
                            <td>
                                <span class="float-end">{{ number_format($data->amount_price_motor_rentel) }} ៛</span>
                            </td>
                            <td>@lang('lang.motor_rental_fee_tax') ({{$data->tax_rate}}%) : </td>
                            <td>
                                <span class="float-end">{{ number_format(($data->amount_price_motor_rentel * $data->tax_rate) / 100) }} ៛</span>
                            </td>
                        </tr>
                        <tr>
                            <td>@lang('lang.gross_taplab_fee') (៛): </td>
                            <td><span class="float-end">{{ number_format($data->amount_price_taplab_rentel) }} ៛</span></td>
                            <td>@lang('lang.taplab_fee_tax') ({{$data->tax_rate}}%) :</td>
                            <td>
                                <span class="float-end">{{ number_format(($data->amount_price_taplab_rentel * $data->tax_rate) / 100) }} ៛</span>
                            </td>
                        </tr>
                        <tr>
                            <td>@lang('lang.engine_oil') (៛):</td>
                            <td><span class="float-end">{{ number_format($data->amount_price_engine_oil) }} ៛</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>@lang('lang.gasoline') (៛)</td>
                            <td>
                                <span class="float-end">{{ number_format($data->gasoline_price_per_liter) }} ៛</span>
                            </td>
                            <td>@lang('lang.other_deduction'): </td>
                            <td>
    
                            </td>
                        </tr>
                        <tr class="tr-background-83">
                            <td>@lang('lang.total_earnings') (៛): </td>
                            <td>
                                <span class="float-end">{{ number_format(($data->gasoline_price_per_liter)+ $data->amount_price_motor_rentel + $data->amount_price_taplab_rentel + $data->amount_price_engine_oil) }} ៛</span>
                            </td>
                            <td>@lang('lang.total_deductions') (៛): </td>
                            <td>
                                <span class="float-end">{{ number_format((($data->amount_price_taplab_rentel * $data->tax_rate) + ($data->amount_price_motor_rentel * $data->tax_rate)) / 100) }} ៛</span>
                            </td>
                        </tr>
                        {{-- <tr class="tr-background-83">
                            <td>@lang('lang.total_earnings') (@lang('lang.reil')): </td>
                            <td>
                                <span class="float-end">{{ number_format($data->gasoline_price_per_liter) }} ៛</span>    
                            </td>
                            <td>@lang('lang.total_deductions') (@lang('lang.reil')): </td>
                            <td>
                                <span class="float-end">0000 ៛</span>
                            </td>
                        </tr> --}}
                        <tr>
                            <td class="td-border"></td>
                            <td class="td-border"></td>
                            <td class="td-background-cc">@lang('lang.total_net_pay') (៛):</td>
                            <td class="td-background-cc">
                                <span class="float-end">{{number_format((($data->total_gasoline * $data->total_work_day) * $data->gasoline_price_per_liter) + $data->amount_price_engine_oil + ($data->amount_price_motor_rentel - ($data->amount_price_motor_rentel * $data->tax_rate) / 100) + ($data->amount_price_taplab_rentel - ($data->amount_price_taplab_rentel * $data->tax_rate) / 100 )) }} ៛</span>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td class="td-border"> </td>
                            <td class="td-border"></td>
                            <td class="td-background-cc">@lang('lang.total_net_pay') (@lang('lang.reil')):</td>
                            <td class="td-background-cc">
                                <span class="float-end">៛ {{ number_format(($data->total_gasoline * $data->total_work_day) * $data->gasoline_price_per_liter) }}</span>
                            </td>
                        </tr> --}}
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
</body>
</html>