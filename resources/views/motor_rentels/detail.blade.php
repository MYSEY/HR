@extends('layouts.master_print')
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
                    {{-- <button id="tast_print" type="button" class="btn btn-light btn-sm mb-0 border">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </button>&nbsp; --}}
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group">
                        @if (Auth::user()->RolePermission == 'Administrator')
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white" id="tast_print"><i class="fa fa-print fa-lg"></i> Print</button>
                        </div>
                            {{-- <a href="#" class="btn add-btn" id="tast_print">
                                <label for=""><i class="fa fa-print fa-lg"></i>
                                    Print</label> --}}
                                {{-- <div id="btn-loadding" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> --}}

                            </a>
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
                        </div>
                        <div class="row mt-5">
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
                                    <li><strong>Branch:</strong> {{ $data->MotorEmployee->branch->branch_name_en }}</li>
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
                                                    {{ number_format($data->price_motor_rentel - ($data->price_motor_rentel * $data->tax_rate) / 100, 2) }}</span>
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
                                                {{ number_format($data->price_taplab_rentel - ($data->price_taplab_rentel * $data->tax_rate) / 100, 2) }}</span></td>
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

                                            </td>
                                            <td>Total Deductions ($): </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr class="tr-background-83">
                                            <td>Total Earnings (Reil): </td>
                                            <td>

                                            </td>
                                            <td>Total Deductions (Reil): </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-border"></td>
                                            <td class="td-border"></td>
                                            <td class="td-background-cc">Total Net Pay ($):</td>
                                            <td class="td-background-cc"></td>
                                        </tr>
                                        <tr>
                                            <td class="td-border"> </td>
                                            <td class="td-border"></td>
                                            <td class="td-background-cc">Total Net Pay (Reil):</td>
                                            <td class="td-background-cc">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3">
                                <p><strong>Employer Signature</strong></p><br><br><br>
                                <p>......... /............. /..........</p>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3">
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
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $("#tast_print").on("click", function() {
            print_pdf();
        });
    });

    function print_pdf(type) {
        $("#print_purchase").show();
        window.setTimeout(function() {
            $("#print_purchase").hide();
        }, 2000);
        $("#print_purchase").printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "/admin/css/style_table.css",
            header: "",
            printDelay: 1000,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>
