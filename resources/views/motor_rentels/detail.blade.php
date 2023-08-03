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
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Detail Motor rentel</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Detail motor rentel</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group">
                        @if (Auth::user()->RolePermission == 'Administrator')
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white" id="btn_print">
                                <span class="btn-text-print"><i class="fa fa-print fa-lg"></i> Print</span>
                                <span id="btn-print-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
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
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-img-wrap">
                                        <div class="profile-img">
                                            <a href="#"><img alt=""
                                                    src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png"></a>
                                                   
                                        </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="profile-info-left">
                                                    <h3 class="payslip-title-center">EMPLOYEE PAYSLIP</h3>
                                                    <p class="payslip-title-center">Monthly Motor Rental Fee: &nbsp;
                                                        <strong>{{ \Carbon\Carbon::parse($data->created_at)->format('M-Y') ?? '' }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <ul class="list-unstyled mb-0">
                                    <li>Camma Microfinance Limited</li>
                                    <li><p>{{$data->MotorEmployee->BranchAddress}}</p></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>Employee ID:</strong> {{ $data->MotorEmployee->number_employee }}</li>
                                    <li><strong>Position:</strong> {{ $data->MotorEmployee->EmployeePosition }}</li>
                                    <li><strong>Date of Commencement :</strong>
                                        {{ \Carbon\Carbon::parse($data->MotorEmployee->date_of_commencement)->format('d-M-Y') }}
                                    </li>
                                    <li><strong>Total Amount of workday:</strong> {{ $data->total_work_day }}</li>
                                    <li><strong>Total Casoline (Month):</strong>
                                        {{ number_format($data->total_gasoline * $data->total_work_day * $data->gasoline_price_per_liter) }}
                                        ៛</li>
                                </ul>
                            </div>
                            <div class="col-lg-6 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>Name:</strong> {{ $data->MotorEmployee->employee_name_en }}</li>
                                    <li><strong>Department:</strong> {{ $data->MotorEmployee->department->name_khmer }}</li>
                                    <li><strong>Location:</strong> {{ $data->MotorEmployee->branch->branch_name_en }}</li>
                                    <li><strong>Average Unit Price (Gasoline/1L) :</strong>
                                        {{ number_format($data->gasoline_price_per_liter) }} ៛ </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered">
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
                                                <span class="float-end">៛
                                                    {{ number_format($data->gasoline_price_per_liter) }} </span>
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
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-5">
                                <p><strong>Employer Signature</strong></p><br><br><br>
                                <p>......... /............. /..........</p>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-5" style="margin-left: auto">
                                <p><strong>Employee Signature</strong></p><br><br><br>
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
