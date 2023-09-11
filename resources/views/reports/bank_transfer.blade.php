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
                    <h3 class="page-title">@lang('lang.bank_transfer_report')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.bank_transfer_report')</li>
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
                            <button class="btn btn-white" id="btn_export">
                                <span class="btn-text-print-excel"><i class="fa fa-file-excel-o"></i> @lang('lang.excel')</span>
                                <span id="btn-print-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
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
                                            <a href="#"><img alt="" src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png"></a>
                                        </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="profile-info-left">
                                                    <h3 class="payslip-title-center">@lang('lang.camma_microfinance_limited')</h3>
                                                    <p class="payslip-title-center">@lang('lang.payroll_statement')(…......April.........) &nbsp;
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <ul class="list-unstyled mb-0">
                                    <li>@lang('lang.please_kindly_transfer_from_account_number_3100-02-146868-68_to_camma_microfinanace_limited._employees_as_below') :</li>
                                </ul>
                            </div>
                            <div class="col-md-12 mt-4">
                                <table class="w-100">
                                    <body>
                                        <tr>
                                            <td>@lang('lang.payroll_amount')</td>
                                            <th>$ 103602.48</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.payroll_service')</td>
                                            <th>$ 47.48</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.local_fee')</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.total_pay')</td>
                                            <th>$ 1036490.96</th>
                                            <td>@lang('lang.valid_date') : ( 1/25/2023 )</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.fee_charge_deduce_from_main_account')</td>
                                            <td></td>
                                            <td>@lang('lang.valid_time') : ( 11:00AM )</td>
                                        </tr>
                                    </body>
                                </table>
                            </div>
                            <div class="col-md-12 mt-4">
                                <table class="table table-striped ">
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
                                            <th colspan="4" class="text-end">@lang('lang.total_amount')</th>
                                            <th>$ {{$totolFee}}</th>
                                            <th>$ {{$totolSaraly}}</th>
                                            <td></td>
                                        </tr>
                                    </body>
                                </table>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3">
                                <p>@lang('lang.date'): ......... /............. /..........</p>
                                <p>@lang('lang.approved_by')</p><br><br><br>

                                <p><strong>@lang('lang.mrs_nuth_seila')</strong></p>
                                <p>@lang('lang.deputy_head_of_accounting_and_inance_epartment')</p>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3" style="margin-left: auto">
                                <p>@lang('lang.date'): ......... /............ /..........</p>
                                <p>@lang('lang.verified_by')</p><br><br><br>

                                <p><strong>@lang('lang.mr_pheng_putmetrey')</strong></p>
                                <p>@lang('lang.head_of_hr_and_admin_department').</p>
                            </div>
                            <div class="col-sm-3 payslip-title-center mt-3" style="margin-left: auto">
                                <p>@lang('lang.date'): ......... /............ /..........</p>
                                <p>@lang('lang.prepare_by')</p><br><br><br>

                                <p><strong>@lang('lang.mr._chhor_oudam')</strong></p>
                                <p>@lang('lang.senior_personnel_&_recruitement_manager')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('payrolls.print_bank_transfer')
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
            loadCSS: "{{asset('/admin/css/style-bank-transfer.css')}}",
            header: "",
            printDelay: 1500,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>
