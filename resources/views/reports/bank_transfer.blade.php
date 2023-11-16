@extends('layouts.master')
<style>
    input[type="time"] {
        position: relative;
    }
    input[type="time"]::-webkit-calendar-picker-indicator {
        display: block;
        top: 0;
        right: 0;
        height: 100%;
        width: 100%;
        position: absolute;
        background: transparent;
        transform: scale(12)
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
                            <div class="col-auto float-end ms-auto">
                                @if (permissionAccess("31","is_export")->value == "1")
                                    <a href="#" class="btn add-btn" id="btn-export"><i class="fa fa-file-excel-o"></i>@lang('lang.excel')</a>
                                @endif
                                @if (permissionAccess("31","is_print")->value == "1")
                                <a href="#" class="btn add-btn me-2" data-bs-toggle="modal" data-bs-target="#add_bank_transfer"><i class="fa fa-print fa-lg"></i> @lang('lang.print')</a>
                                @endif
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
        @if (permissionAccess("31","is_view")->value == "1")
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
                                                <h3 class="payslip-title-center">@lang('lang.camma_microfinance_limited')</h3>
                                                <p class="payslip-title-center">@lang('lang.payroll_statement')(..... <span id="monthly"></span> ......) &nbsp; </p>
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
                                            <th>$<span id="total_saraly"></span></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.payroll_service')</td>
                                            <th>$<span id="total_fee"></span></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.local_fee')</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.total_pay')</td>
                                            <th>$<span id="total_pay"></span></th>
                                            <td>@lang('lang.valid_date') : ( ......./....../....... )</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('lang.fee_charge_deduce_from_main_account')</td>
                                            <td></td>
                                            <td>@lang('lang.valid_time') : ( ......... )</td>
                                        </tr>
                                    </body>
                                </table>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-striped">
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
                                                        $totolFee += $item->users->bank ? $item->users->bank->fee : 0;
                                                    @endphp
                                                    <tr class="odd">
                                                        <td>{{++$key}}</td>
                                                        <td>{{ $item->users == null ? '' : $item->users->employee_name_kh}}</td>
                                                        <td>{{ $item->users == null ? '' : $item->users->employee_name_en }}</td>
                                                        <td>{{ $item->users == null ? '' : $item->users->account_number }}</td>
                                                        <td>${{$item->users->bank ? $item->users->bank->fee : 0.00}}</td>
                                                        <td>${{$item->total_salary}}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <th colspan="4" class="text-end">@lang('lang.total_amount')</th>
                                                <th>$<span class="td_total_fee">{{number_format($totolFee, 2)}}</span></th>
                                                <th>$<span class="td_total_saraly">{{$totolSaraly}}</span></th>
                                                <td></td>
                                            </tr>
                                        </body>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="col-sm-3 payslip-title-center mt-3">
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
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div id="add_bank_transfer" class="modal custom-modal fade" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('lang.bank_transfer')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('lang.valid_date') <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker required" type="text" id="bank_valid_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('lang.valid_time') <span class="text-danger">*</span></label>
                                    <input class="form-control required" type="time" id="bank_valid_time" >
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button type="button" class="btn btn-primary" id="btn_print">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-text">@lang('lang.submit')</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('payrolls.print_bank_transfer')
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script type="text/javascript">
    $(function() {
        let monthly = moment().format('MMMM');
        $("#monthly").text(monthly);
        $("#total_fee").text($(".td_total_fee").text());
        $("#total_saraly").text($(".td_total_saraly").text());
        $("#total_pay").text(parseFloat($(".td_total_saraly").text()) + parseFloat($(".td_total_fee").text()));

        $("#btn_print").on("click", function() {
            var num_miss = 0;
            $("#p_monthly").text(monthly);
            $("#p_total_fee").text($(".td_total_fee").text());
            $("#p_total_saraly").text($(".td_total_saraly").text());
            $("#p_total_pay").text(parseFloat($(".td_total_saraly").text()) + parseFloat($(".td_total_fee").text()));
            let date = moment($("#bank_valid_date").val()).format('D/M/YYYY');
            let time = moment($("#bank_valid_time").val(), "hh:mm:ss A").format("hh:mm A");
            $("#p_valid_date").text(date);
            $("#p_valid_date_time").text(time);
            $(".required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545")
                }else{
                    $(this).css("border-color","#198754")
                }
            });
            $(".loading-icon").css('display', 'block');
            $("#btn_print").prop('disabled', true);
            $(".btn-text").css("display", "none");
            if (num_miss>0) {
                setTimeout(function () {
                    $("#btn_print").attr('disabled',false);
                    $(".loading-icon").css('display', 'none');
                    $(".btn-text").css("display", 'block');
                }, 500);
                return false;
            }else{
                print_pdf();
            }
            
        });
        $("#btn-export").on("click", function(){
            var url = "{{URL::to('reports/bank-transfer-export')}}?"
            window.location = url;
        });
    });

    function print_pdf(type) {
        $("#print_purchase").show();
        window.setTimeout(function() {
            $("#print_purchase").hide();
            $("#btn_print").attr('disabled',false);
            $(".loading-icon").css('display', 'none');
            $(".btn-text").css("display", 'block');

            $("#add_bank_transfer").modal("hide")
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
