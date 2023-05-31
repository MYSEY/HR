@extends('layouts.master_print')
<style>
    .profile-info-left {
        border-right: 0px dashed #cccccc !important;
    }
    .lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 70px;
  height: 28px;
}
.lds-ellipsis div {
  position: absolute;
  top: 10px;
  width: 9px;
  height: 9px;
  border-radius: 50%;
  background: #fff;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
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
                            <a href="#" class="btn add-btn"  id="tast_print">
                                <label for=""><i class="fa fa-print fa-lg"></i>
                                    Print</label>
                                 {{-- <div id="btn-loadding" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> --}}

                            </a>
                                
                        @endif
                        {{-- <button class="btn btn-white" id="tast_print"><i class="fa fa-print fa-lg"></i> Print</button> --}}
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
                                                    <h3 class="payslip-title-center">ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត</h3>
                                                    <p class="payslip-title-center">ថ្លៃឈ្នួលម៉ូតូសម្រាប់ខែ​ &nbsp;
                                                        <strong>{{ \Carbon\Carbon::parse($data->created_at)->format('M-d') ?? '' }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12 m-b-20">
                                <ul class="list-unstyled">
                                    <li><strong>Employee ID:</strong> {{ $data->MotorEmployee->number_employee }}</li>
                                    <li><strong>Name:</strong> {{ $data->MotorEmployee->employee_name_en }}</li>
                                    <li><strong>Gender:</strong> {{ $data->MotorEmployee->EmployeeGender}}
                                    </li>
                                    <li><strong>Position:</strong> {{ $data->MotorEmployee->EmployeePosition }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    {{-- <h4 class="m-b-10"><strong>Earnings</strong></h4> --}}
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Price motor rentel {{-- ថ្លៃឈ្នួលម៉ូតូ --}} ៖ <span class="float-end">$
                                                        {{ $data->price_motor_rentel }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Fee tax {{-- ពន្ធលើថ្លៃឈ្នួល --}}៖ <span class="float-end">$
                                                        {{ number_format($data->price_motor_rentel - ($data->price_motor_rentel * $data->tax_rate) / 100, 2) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Price engine oil {{-- ថ្លៃប្រេងម៉ាស៊ីន --}} ៖ <span class="float-end">$
                                                        {{ $data->price_engine_oil }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Money to be received after tax {{-- ប្រាក់ត្រូវទទួលបានបន្ទាប់ពីដកពន្ធ --}} </strong>
                                                    <span class="float-end"><strong> $
                                                            {{ number_format($data->price_motor_rentel - ($data->price_motor_rentel - ($data->price_motor_rentel * $data->tax_rate) / 100) + $data->price_engine_oil, 2) }}</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total price gasoline {{-- ថ្លៃសាំងម៉ូតូ --}} ៖ <span
                                                        class="float-end">{{ number_format($data->total_gasoline * $data->total_work_day * $data->gasoline_price_per_liter, 2) }}
                                                        ៛</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Money must be paid for gasoline {{-- ប្រាក់ត្រូវទទួលបានថ្លៃសាំងម៉ូតូ --}}</strong>
                                                    <span class="float-end"><strong>{{ number_format($data->total_gasoline * $data->total_work_day * $data->gasoline_price_per_liter, 2) }}
                                                            ៛</strong></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3">
                                <p><strong>អ្នកប្រគល់</strong></p><br><br>
                                <p>......... /............. /..........</p>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3">
                                <p><strong>អ្នកទទួល</strong></p><br><br>
                                <p>......... /............ /..........</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="print_purchase" hidden>
        <div class="card-header">

            {{-- logo company --}}
            <div style="margin-top: 10px">
                <img style="width:auto;height: 80px;"alt='White' id="image_logo_print"
                    src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
            </div>

            <div style="margin-top:-75px; margin-left:243px">
                <h3 class="payslip-title-center">ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត</h3>
                <p class="payslip-title-center">ថ្លៃឈ្នួលម៉ូតូសម្រាប់ខែ​ &nbsp;
                    <strong>{{ \Carbon\Carbon::parse($data->created_at)->format('M-d') ?? '' }}</strong></p>
            </div>

            <div>
                <span><strong>Employee ID:</strong> {{ $data->MotorEmployee->number_employee }}</span><br>
                <span><strong>Name:</strong> {{ $data->MotorEmployee->employee_name_en }}</span><br>
                <span><strong>Gender:</strong> {{ $data->MotorEmployee->EmployeeGender}}</span><br>
                <span><strong>Position:</strong> {{ $data->MotorEmployee->EmployeePosition }}</span>
            </div><br>

            <span>
                <table class="table-a">
                    <thead>
                        <tr>
                            <th style="padding: 6px" colspan="6"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Price motor rentel {{-- ថ្លៃឈ្នួលម៉ូតូ --}} ៖ <span class="float-end">$
                                    {{ $data->price_motor_rentel }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Fee tax {{-- ពន្ធលើថ្លៃឈ្នួល --}}៖ <span class="float-end">$
                                    {{ number_format($data->price_motor_rentel - ($data->price_motor_rentel * $data->tax_rate) / 100, 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Price engine oil {{-- ថ្លៃប្រេងម៉ាស៊ីន --}} ៖ <span class="float-end">$
                                    {{ $data->price_engine_oil }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Money to be received after tax {{-- ប្រាក់ត្រូវទទួលបានបន្ទាប់ពីដកពន្ធ --}} </strong> <span
                                    class="float-end"><strong> $
                                        {{ number_format($data->price_motor_rentel - ($data->price_motor_rentel - ($data->price_motor_rentel * $data->tax_rate) / 100) + $data->price_engine_oil, 2) }}</strong></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Total price gasoline {{-- ថ្លៃសាំងម៉ូតូ --}} ៖ <span
                                    class="float-end">{{ number_format($data->total_gasoline * $data->total_work_day * $data->gasoline_price_per_liter, 2) }}
                                    ៛</span></td>
                        </tr>
                        <tr>
                            <td><strong>Money must be paid for gasoline {{-- ប្រាក់ត្រូវទទួលបានថ្លៃសាំងម៉ូតូ --}}</strong> <span
                                    class="float-end"><strong>{{ number_format($data->total_gasoline * $data->total_work_day * $data->gasoline_price_per_liter, 2) }}
                                        ៛</strong></span></td>
                        </tr>
                    </tbody>
                </table>
            </span><br>
            <div  style="display: flex">
                <div class="payslip-title-center">
                    <p style="text-align: center"><strong>អ្នកប្រគល់</strong></p><br><br><br>
                    <p>......... /............. /..........</p>
                </div>
                <div class="payslip-title-center" style="margin-left: 20%">
                    <p style="text-align: center"><strong>អ្នកទទួល</strong></p><br><br><br>
                    <p>......... /............ /..........</p>
                </div>
            </div>
        </div>
    </div>
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
