@extends('layouts.master')
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
                    <h3 class="page-title">@lang('lang.detail_motor_rentel')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item">@lang('lang.detail_motor_rentel')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group">
                        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white" id="btn_print">
                                <span class="btn-text-print"><i class="fa fa-print fa-lg"></i> @lang('lang.print')</span>
                                <span id="btn-print-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                        </div>
                        @endif
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
                                    <li><p>{{$data->MotorEmployee->BranchAddress}}</p></li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="profile-info-left">
                                    <h3 class="payslip-title-center">@lang('lang.employee_payslip')</h3>
                                    <p class="payslip-title-center"><strong>{{ Helper::getLang() == 'en' ? Helper::getENMonthsMotorRantal($data->created_at) : Helper::getKhmerMonthsMotorRantal($data->created_at) }}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>@lang('lang.employee_id') : </strong> {{ $data->MotorEmployee->number_employee }}</li>
                                    <li><strong>@lang('lang.position') : </strong> {{ $data->MotorEmployee->EmployeePosition }}</li>
                                    <li><strong>@lang('lang.date_of_commencement') : </strong>{{ \Carbon\Carbon::parse($data->MotorEmployee->date_of_commencement)->format('d-M-Y') }}
                                    </li>
                                    <li><strong>@lang('lang.total_amount_of_workday'):</strong> {{ $data->total_work_day }}</li>
                                    <li><strong>@lang('lang.total_gasoline') (@lang('lang.month')):</strong>
                                        {{ number_format($data->total_gasoline * $data->total_work_day) }} L
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>@lang('lang.employee_name') : </strong> {{ Helper::getLang() == 'en' ? $data->MotorEmployee->employee_name_en : $data->MotorEmployee->employee_name_kh}}</li>
                                    <li><strong>@lang('lang.department') : </strong> {{ Helper::getLang() == 'en' ? $data->MotorEmployee->department->name_english :$data->MotorEmployee->department->name_khmer }}</li>
                                    <li><strong>@lang('lang.location') : </strong> {{ Helper::getLang() == 'en' ? $data->MotorEmployee->branch->branch_name_en : $data->MotorEmployee->branch->branch_name_kh }}</li>
                                    <li><strong>@lang('lang.average_unit_price') (@lang('lang.gasoline')/1L) : </strong>{{ number_format($data->gasoline_price_per_liter) }} ៛ </li>
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
                                                <th>@lang('lang.amount')</th>
                                                <th>@lang('lang.deduction') </th>
                                                <th>@lang('lang.amount')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>@lang('lang.gross_motor_rental_fee') (៛) :</td>
                                                <td>
                                                    <span class="float-end">​{{ number_format($data->amount_price_motor_rentel) }} ៛</span>
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
                                                    <span class="float-end">{{ number_format(($data->gasoline_price_per_liter) + $data->amount_price_motor_rentel + $data->amount_price_taplab_rentel + $data->amount_price_engine_oil) }} ៛</span>
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
                                                    <span class="float-end">{{ number_format(($data->total_gasoline * $data->total_work_day) * $data->gasoline_price_per_liter) }} ៛</span>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3">
                                <p><strong>@lang('lang.employer_signature')</strong></p><br><br>
                                <p>......... /............. /..........</p>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3" style="margin-left: auto">
                                <p><strong>@lang('lang.employee_signature')</strong></p><br><br>
                                <p>......... /............ /..........</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('motor_rentels.termplate_print')
@endsection

@include('includs.script')
<script type="text/javascript">
    $(function() {
        $("#btn_print").on("click", function() {
            print_pdf();
        });
    });

    function print_pdf(type) {
        $("#print_purchase").show();

        $("#btn-print-loading").css('display', 'block');
        $("#btn_print").prop('disabled', true);
        $(".btn-text-print").hide();

        window.setTimeout(function() {
            $("#print_purchase").hide();
            $("#btn_print").prop('disabled', false);
            $(".btn-text-print").show();
            $("#btn-print-loading").css('display', 'none');

        }, 2000);
        $("#print_purchase").printThis({
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
