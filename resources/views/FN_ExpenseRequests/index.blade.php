@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: pre-line !important;
        text-align: left !important;
        max-width: 300px !important; 
        /* word-wrap: break-word !important; */
    }
    #v_reference {
        white-space: normal;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.expense_request')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.expense_request')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        @if (Auth::user()->branch->abbreviations == "HQ")
                            <a href="{{url('fn/tax-expense/create')}}" class="btn add-btn"><i class="fa fa-plus"></i> @lang('lang.tax_expense')</a>
                        @endif
                        <a href="{{url('fn/expense-request/create')}}" class="btn add-btn  me-1"><i class="fa fa-plus"></i> @lang('lang.general_expense')</a> 
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12 col-ms-12 p-0">
                        <ul class="nav nav-tabs nav-tabs-bottom" role="tablist" id="show-tabs-user">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active clearTabs" data-bs-toggle="tab" id="tab_request" href="#tbl_request" aria-selected="false" role="tab" data-tab-id="2" tabindex="1">@lang('lang.expense_request')
                                    <span id="dataShortList" class="badge bg-secondary ms-1 rounded-pill">{{count($datas)}}</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link clearTabs" data-bs-toggle="tab" id="tab_assign" href="#tbl_assign" aria-selected="false" role="tab" data-tab-id="3" tabindex="-1">@lang('lang.review_and_submit')
                                    <span id="dataShortList" class="badge bg-inverse-danger ms-1 rounded-pill">{{count($dataAsign)}}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            @include('FN_ExpenseRequests.table_expense')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Delete Taxes Modal -->
        <div class="modal custom-modal fade" id="delete_ER" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('/fn/expense-request/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('FN_ExpenseRequests.print')
        @include('FN_ExpenseRequests.modal_view_expense')
        @include('FN_tax_expenses.print')
        @include('components.loading-modal')
    </div>
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/convertNumberToWordsExp.js')}}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({ 
            html: true,
            container: 'tr' 
        });
    });
    $(function() {
        $(".btn-review").on("click", function () {
            var datas = $(this).data('datas');
            var reference = $(this).attr('data-reference');
            $("#v_reference").html(reference);
            $('#v-btn-reject').data('id', datas.id);
            $('#v-btn-approve').data('id', datas.id);
            $('#v-btn-approve').data('daterequest', datas.date_request);
            $('#v-btn-approve').data('status', datas.status);
            if (datas.status == "pending_approve") {
                $(".btn-text-save").text("@lang('lang.approve')");
                $(".btn-approved").css("background-color", "#e62329");
                $(".btn-approved").css("color","#ffffff");
            }else{
                $(".btn-text-save").text("@lang('lang.submit')"); 
                $(".btn-approved").css("background-color", "#48aa48");
                $(".btn-approved").css("color","#ffffff");
            }
            let review_type = (datas.review_type + 1);
            $('#Stage_review').val(review_type);
            if (datas.type == "1") {
                $(".v_type_exp").css("display","block");
            }else{
                $(".v_type_exp").css("display","none");
            }
            let convertNumberUSA = convertNumberToWordsExp(datas.ge_total_amount_usd,"dollar");
            let convertNumberKH = 0;
            if (datas.type == "2") {
                convertNumberKH = convertNumberToWordsExp(datas.te_total_tax,"rial");
                $("#v_expense_type").text("ចំណាយប្រកាសពន្ធ");
                $("#v_total_cost_text").text("សរុបចំណាយ (១+២)");
                $("#block_fringe_benefit").css("display","none");
                $("#v_tax_riel").text("៛ "+formatNumber(datas.te_tax_income));
                $("#v_total_amount_riel").text("៛ "+formatNumber(datas.te_total_tax));
            }else{
                $("#v_expense_type").text("សរុបចំណាយ (១+២)");
                $("#v_total_cost_text").text("ពន្ធកាត់ទុក");
                convertNumberKH = convertNumberToWordsExp(datas.ge_total_amount_riel,"rial");
                $("#block_fringe_benefit").css("display","block");
                $("#v_tax_fringe_benefit_usd").text("$ "+formatNumber(datas.ge_tax_fringe_benefit_usd));
                $("#v_tax_fringe_benefit_riel").text("៛ "+formatNumber(datas.tax_fringe_benefit_riel));
                $("#v_tax_riel").text("៛ "+formatNumber(datas.tax_riel));
                $("#v_total_amount_riel").text("៛ "+formatNumber(datas.ge_total_amount_riel));
            }
            let text_expense_type = "";
            if (datas.expense_type == "1") {
                text_expense_type = "Regular Expense";
            }
            if (datas.expense_type == "2") {  
                text_expense_type = "Irregular Expense";
            }
            $(".type_request_expense").text(text_expense_type);
            $("#v_kind_regard").val(datas.kind_regard);
            $("#v_subject").val(datas.subject);
            $("#v_reason_subject").val(datas.reason_subject);
            $("#v_payment_term").text(datas.payment_term);
            $("#v_cost_material_usd").text("$ "+formatNumber(datas.ge_cost_material_usd));
            $("#v_cost_material_riel").text("៛ "+formatNumber(datas.ge_cost_material_riel));
            $("#v_cost_lso_usd").text("$ "+formatNumber(datas.ge_cost_lso_usd));
            $("#v_cost_lso_riel").text("៛ "+formatNumber(datas.ge_cost_lso_riel));
            $("#v_total_cost_usd").text("$ "+formatNumber(datas.ge_total_cost_usd));
            $("#v_total_cost_riel").text("៛ "+formatNumber(datas.ge_total_cost_riel));
            $("#v_tax_usd").text("$ "+formatNumber(datas.ge_tax_usd));
            $("#v_vat_reverse_charge_usd").text("$ "+formatNumber(datas.ge_vat_reverse_charge_usd));
            $("#v_vat_reverse_charge_riel").text("៛ "+formatNumber(datas.vat_reverse_charge_riel));
            $("#v_total_amount_usd").text("$ "+formatNumber(datas.ge_total_amount_usd));
            $("#v_convert_money_dollar").text(convertNumberUSA);
            $("#v_convert_money_rial").text(convertNumberKH);
            $("#v_remark").val(datas.remark);
            let tr_a = "";
            let tr_b = "";
            let amountUSD = '';
            let amountRiel = '';
            if (datas.type == "2" ) {
                if (datas.location_details.length  > 0) {
                    let mid = Math.ceil(datas.location_details.length / 2);
                    let name_ =  "";
                    for (let index = 0; index < datas.location_details.length; index++) {
                        let detail = datas.location_details[index];
                        let amountUSD = '';
                        let amountRiel = '';

                        if (detail.amount_usd > 0) {
                            amountUSD = ' $ ' + formatNumber(detail.amount_usd);
                        }

                        if (detail.amount_riel > 0) {
                            amountRiel = ' ៛' + formatNumber(detail.amount_riel);
                        }

                        let currencyText = amountUSD;
                        if (amountUSD && amountRiel) currencyText += '&nbsp;&nbsp;';
                        currencyText += amountRiel;
                        
                        if (detail.location) {
                            name_ = detail.location.branch_name_kh;
                        }else{
                            name_ = detail.department.name_khmer;
                        }
                        let row = '<tr>' +
                            '<td class="table_tr_">- ' + name_ + currencyText + '</td>' +
                        '</tr>';

                        if (index < mid) {
                            tr_a += row;
                        } else {
                            tr_b += row;
                        }
                    }
                }
            }else{
                if (datas.location_details.length === 1) {
                    let detail = datas.location_details[0];

                    if (detail.amount_usd) {
                        amountUSD = ' $ ' + formatNumber(detail.amount_usd);
                    }

                    if (detail.amount_riel) {
                        amountRiel = ' ៛' + formatNumber(detail.amount_riel);
                    }

                    let currencyText = amountUSD;
                    if (amountUSD && amountRiel) currencyText += '&nbsp;&nbsp;';
                    currencyText += amountRiel;

                    tr_a = '<tr>' +
                        '<td class="table_tr_">- ' + detail.location.branch_name_kh + currencyText + '</td>' +
                    '</tr>';

                } else {
                    let mid = Math.ceil(datas.location_details.length / 2);

                    for (let index = 0; index < datas.location_details.length; index++) {
                        let detail = datas.location_details[index];
                        let amountUSD = '';
                        let amountRiel = '';

                        if (detail.amount_usd > 0) {
                            amountUSD = ' $ ' + formatNumber(detail.amount_usd);
                        }

                        if (detail.amount_riel > 0) {
                            amountRiel = ' ៛' + formatNumber(detail.amount_riel);
                        }

                        let currencyText = amountUSD;
                        if (amountUSD && amountRiel) currencyText += '&nbsp;&nbsp;';
                        currencyText += amountRiel;

                        let row = '<tr>' +
                            '<td class="table_tr_">- ' + detail.location.branch_name_kh + currencyText + '</td>' +
                        '</tr>';

                        if (index < mid) {
                            tr_a += row;
                        } else {
                            tr_b += row;
                        }
                    }
                }
            }
            $(".v_locations_a tr").html(tr_a);
            $(".v_locations_b tr").html(tr_b);
            $('#view_information_expense').modal('show');
        });
        $('.delete').on('click', function() {
            var _this = $(this).data('id');
            $('.e_id').val(_this);
        });
        $(document).on('click','.btn-approved', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            let review_type = $('#Stage_review').val();
            $('#view_information_expense').modal('hide');
            let dateRequest = moment($(this).data('daterequest')).format('D-MM-YYYY');
            let status = $(this).data('status');
            let id = $(this).data('id');
            let description = "@lang('lang.are_you_sure_want_to_approve')?";
            let text_label = "";
            let button_ok = "";
            let input_date_approve = "";
            if (status == "pending_approve") {
                input_date_approve = '<div class="form-group">' +
                            '<label>@lang("lang.approved_date")</label>'+
                            '<input type="date" class="form-control approve_date approve_date_required" min="' + dateRequest + '">' +
                        '</div>' ;
            }
            button_ok =   {
                text: '@lang("lang.submit")',
                btnClass: 'btn-danger btn-sm',
                action: function () {
                    var id = this.$content.find('.id').val();
                    let remark = this.$content.find('.remark').val();
                    let approve_date = this.$content.find('.approve_date').val();
                    if (status == "pending_approve") {
                        let approveDate = moment(this.$content.find('.approve_date').val()).format('D-MM-YYYY');
                        if (approveDate < dateRequest) {
                            $.alert('@lang("lang.approval_date_must_be_greater_than_or_equal_to_request_date")!');
                            $(".approve_date_required").css("border-color","#dc3545");
                            return false;
                        }
                    }
                    $('#modal-loading').modal('show');
                    axios.post('{{ URL('fn/expense-request/processing') }}', {
                        'id': id,
                        'review_type': review_type,
                        'approve_date': approve_date,
                        'remark': remark,
                    }).then(function(response) {
                        $('#modal-loading').modal('hide');
                        if (response.data.status == 400) {
                            new Noty({
                                title: "",
                                text: response.data.message,
                                type: "error",
                                timeout: 4000,
                                icon: true
                            }).show();
                        }else{
                            new Noty({
                                title: "",
                                text: "@lang('lang.the_process_has_been_successfully').",
                                type: "success",
                                timeout: 3000,
                                icon: true
                            }).show();
                            window.location.replace("{{ URL('/expense-request/list') }}"); 
                        }
                        
                        
                    }).catch(function(error) {
                        new Noty({
                            title: "",
                            text: "@lang('lang.something_went_wrong_please_try_again_later').",
                            type: "error",
                            icon: true
                        }).show();
                    });
                }
            };
            $.confirm({
                icon: 'fa fa-warning',
                title: '@lang("lang.employee_request_expense")',
                titleClass: 'text-center',
                type: 'blue',
                content: function () {
                    return '' +
                        '<form action="">' +
                        '<div class="form-group" style="text-align: center">' +
                            '<label>' + description + '</label>' +
                            '<input type="hidden" class="form-control id" value="' + id + '">' +
                        '</div>' +
                        input_date_approve+
                        '<div class="form-group">' +
                            '<label>@lang("lang.remark")</label>' +
                            '<textarea class="form-control remark" rows="4" placeholder="Enter remark..."></textarea>' +
                        '</div>' +
                        '</form>';
                },
                buttons: {
                    button_ok,
                    cancel: {
                        text: '@lang("lang.close")',
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function () {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        });
        $(document).on('click','.btn-reject', function(){
            $('#view_information_expense').modal('hide');
            let id = $(this).data("id");
            let description = "@lang('lang.are_you_sure_want_to_reject')?";
            let text_label = "";
            let button_ok = "";
                button_ok =   {
                    text: '@lang("lang.reject")',
                    btnClass: 'btn-danger btn-sm',
                    action: function () {
                        var id = this.$content.find('.id').val();
                        let remark = this.$content.find('.remark').val();
                        if (!remark) {
                            this.$content.find('.remark').css("border-color","#dc3545");
                            return false;
                        }
                        $('#modal-loading').modal('show');
                        axios.post('{{ URL('fn/expense-request/reject') }}', {
                            'id': id,
                            'remark': remark,
                        }).then(function(response) {
                            $('#modal-loading').modal('hide');
                            new Noty({
                                title: "",
                                text: "@lang('lang.the_process_has_been_successfully').",
                                type: "success",
                                timeout: 3000,
                                icon: true
                            }).show();
                            window.location.replace("{{ URL('/expense-request/list') }}"); 
                        }).catch(function(error) {
                            new Noty({
                                title: "",
                                text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                type: "error",
                                icon: true
                            }).show();
                        });
                    }
                };
          
            $.confirm({
                icon: 'fa fa-warning',
                title: '@lang("lang.employee_request_expense")',
                titleClass: 'text-center',
                type: 'blue',
                content: function () {
                    return '' +
                        '<form action="" class="formName">' +
                        '<div class="form-group" style="text-align: center">' +
                        '<label>' + description + '</label>' +
                        '<input type="hidden" class="form-control id" value="' + id + '">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>@lang("lang.remark") <span class="text-danger">*</span></label>' +
                        '<textarea class="form-control remark" rows="4" placeholder="Enter remark..."></textarea>' +
                        '</div>' +
                        '</form>';
                },
                buttons: {
                    button_ok,
                    cancel: {
                        text: '@lang("lang.close")',
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function () {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        });
        $('.btn-GEXP-print').on('click', function() {
            $('.number_supplier').text('៦ បើកជូនអ្នកផ្គត់ផ្គង់ (៣) ឫ (៣-(៤+៥))');
            $('#modal-loading').modal('show');
            var datas = $(this).data('datas');
            console.log(datas);
            
            $(".expense_tracking_id").text(datas.tracking_id);
            $(".p_kind_regard").text(datas.kind_regard);
            $(".p_subject").text(datas.subject);
            $(".p_reference").text(datas.reference);
            $(".p_reason_subject").text(datas.reason_subject);
            $(".p_ge_cost_material_usd").text(formatNumber(datas.ge_cost_material_usd));
            $(".p_ge_cost_material_kh").text(formatNumber(datas.ge_cost_material_riel));
            $(".p_ge_cost_lso_usd").text(formatNumber(datas.ge_cost_lso_usd));
            $(".p_ge_cost_lso_kh").text(formatNumber(datas.ge_cost_lso_riel));
            $(".p_ge_total_cost_usd").text(formatNumber(datas.ge_total_cost_usd));
            $(".p_ge_total_cost_kh").text(formatNumber(datas.ge_total_cost_riel));
            $(".p_ge_tax_usd").text(formatNumber(datas.ge_tax_usd));
            $(".p_ge_tax_kh").text(formatNumber(datas.tax_riel));
            $(".p_ge_vat_reverse_charge_usd").text(formatNumber(datas.ge_vat_reverse_charge_usd));
            $(".p_ge_vat_reverse_charge_kh").text(formatNumber(datas.vat_reverse_charge_riel));
            $(".p_ge_total_amount_usd").text(formatNumber(datas.ge_total_amount_usd));
            $(".p_ge_total_amount_kh").text(formatNumber(datas.ge_total_amount_riel));

            let convertNumber = convertNumberToWordsExp(datas.ge_total_amount_usd,"dollar");
            let convertNumberRiel = convertNumberToWordsExp(datas.ge_total_amount_riel,"rial");
            $(".p_convertNumberDollar").text(convertNumber);
            $(".p_convertNumberRiel").text(convertNumberRiel);
            document.getElementById("GEXP_remark").innerHTML = nl2brWithIndent(datas.remark);
            $(".p_payment_term").text(datas.payment_term);
            if (datas.approve_by) {
                $(".p_approved_by").text(datas.approve_by.employee_name_kh);
                let p_date_approve = moment(datas.date_approve).format('YYYY-MM-DD');
                $(".p_date_approve").text(p_date_approve);
            }
            $(".p_request_by").text(datas.request_by.employee_name_kh);
            let p_data_request = moment(datas.date_request).format('YYYY-MM-DD');
            $(".p_data_request").text(p_data_request);
            if(datas.review_by){
                $(".p_review_by").text(datas.review_by.employee_name_kh);
                let p_data_review = moment(datas.date_review).format('YYYY-MM-DD');
                $(".p_data_review").text(p_data_review);
            }
           
            let day = ".......";
            let month = ".......";
            let year = ".......";
            if (datas.date_request) {
                let date_request = new Date(datas.date_request);
                day = formatDate( date_request, 'km', format_date={day: true});
                month = formatDate( date_request, 'km', format_date={month: true});
                year = formatDate( date_request, 'km', format_date={year: true});
            }
            $(".p_day").text(day);
            $(".p_month").text(month);
            $(".p_year").text(year);
            let tr_a = "";
            let tr_b = "";
            let amountUSD = '';
            let amountRiel = '';
            if (datas.location_details.length === 1) {
                let detail = datas.location_details[0];

                if (detail.amount_usd) {
                    amountUSD = ' $ ' + formatNumber(detail.amount_usd);
                }

                if (detail.amount_riel) {
                    amountRiel = ' ៛' + formatNumber(detail.amount_riel);
                }

                let currencyText = amountUSD;
                if (amountUSD && amountRiel) currencyText += '&nbsp;&nbsp;';
                currencyText += amountRiel;

                tr_a = '<tr>' +
                    '<td class="table_tr_">- ' + detail.location.branch_name_kh + currencyText + '</td>' +
                '</tr>';

            } else {
                let mid = Math.ceil(datas.location_details.length / 2);

                for (let index = 0; index < datas.location_details.length; index++) {
                    let detail = datas.location_details[index];
                    let amountUSD = '';
                    let amountRiel = '';

                    if (detail.amount_usd > 0) {
                        amountUSD = ' $ ' + formatNumber(detail.amount_usd);
                    }

                    if (detail.amount_riel > 0) {
                        amountRiel = ' ៛' + formatNumber(detail.amount_riel);
                    }

                    let currencyText = amountUSD;
                    if (amountUSD && amountRiel) currencyText += '&nbsp;&nbsp;';
                    currencyText += amountRiel;

                    let row = '<tr>' +
                        '<td class="table_tr_">- ' + detail.location.branch_name_kh + currencyText + '</td>' +
                    '</tr>';

                    if (index < mid) {
                        tr_a += row;
                    } else {
                        tr_b += row;
                    }
                }
            }
            $(".p_locations_a tr").html(tr_a);
            $(".p_locations_b tr").html(tr_b);
           
            print_pdf("print_expense")
        });
        $('.btn-TEXP-print').on('click', function() {
            $('.p_reverse_charge').css('display','none');
            $('.number_supplier').text('៥ បើកជូនអ្នកផ្គត់ផ្គង់ (៤)');
            $('#modal-loading').modal('show');
            var datas = $(this).data('datas');
            $(".expense_tracking_id").text(datas.tracking_id);
            $(".p_kind_regard").text(datas.kind_regard);
            $(".p_subject").text(datas.subject);
            $(".p_reference").text(datas.reference);
            $(".p_reason_subject").text(datas.reason_subject);
            $(".p_ge_cost_material_usd").text(formatNumber(datas.ge_cost_material_usd));
            $(".p_ge_cost_material_riel").text(formatNumber(datas.ge_cost_material_riel));
            $(".p_ge_cost_lso_usd").text(formatNumber(datas.ge_cost_lso_usd));
            $(".p_ge_cost_lso_riel").text(formatNumber(datas.ge_cost_lso_riel));
            $(".p_te_tax_usd").text(formatNumber(datas.ge_tax_usd));
            $(".p_te_tax_income").text(formatNumber(datas.te_tax_income));
            $(".p_ge_total_cost_usd").text(formatNumber(datas.ge_total_cost_usd));
            $(".p_ge_total_cost_riel").text(formatNumber(datas.ge_total_cost_riel));
            // $(".p_vat_reverse_charge_usd").text(formatNumber(datas.ge_vat_reverse_charge_usd));
            // $(".p_vat_reverse_charge_riel").text(formatNumber(datas.vat_reverse_charge_riel));
            $(".p_te_total_usd").text(formatNumber(datas.ge_total_amount_usd));
            $(".p_te_total_tax").text(formatNumber(datas.te_total_tax));

            let convertNumberRiel = convertNumberToWordsExp(datas.te_total_tax,"rial");
            let convertNumber = convertNumberToWordsExp(datas.ge_total_amount_usd,"dollar");
            $(".p_convertNumberRiel").text(convertNumberRiel);
            $(".p_convertNumberDollar").text(convertNumber);
            document.getElementById("TEXP_remark").innerHTML = nl2brWithIndent(datas.remark);
            $(".p_payment_term").text(datas.payment_term);
            if (datas.approve_by) {
                $(".p_approved_by").text(datas.approve_by.employee_name_kh);
                let p_date_approve = moment(datas.date_approve).format('YYYY-MM-DD');
                $(".p_date_approve").text(p_date_approve);
            }
            $(".p_request_by").text(datas.request_by.employee_name_kh);
            let p_data_request = moment(datas.date_request).format('YYYY-MM-DD');
            $(".p_data_request").text(p_data_request);
            if(datas.review_by){
                $(".p_review_by").text(datas.review_by.employee_name_kh);
                let p_data_review = moment(datas.date_review).format('YYYY-MM-DD');
                $(".p_data_review").text(p_data_review);
            }
            // $(".p_approved_by").text(datas.approve_by.employee_name_kh);
            // $(".p_request_by").text(datas.request_by.employee_name_kh);
            let day = ".......";
            let month = ".......";
            let year = ".......";
            if (datas.date_request) {
                let date_request = new Date(datas.date_request);
                day = formatDate( date_request, 'km', format_date={day: true});
                month = formatDate( date_request, 'km', format_date={month: true});
                year = formatDate( date_request, 'km', format_date={year: true});
            }
            $(".p_day").text(day);
            $(".p_month").text(month);
            $(".p_year").text(year);
            let tr_a = "";
            let tr_b = "";

            let mid = Math.ceil(datas.location_details.length / 2);

            for (let index = 0; index < datas.location_details.length; index++) {
                let detail = datas.location_details[index];
                let amountUSD = '';
                let amountRiel = '';

                if (detail.amount_usd > 0) {
                    amountUSD = ' $ ' + formatNumber(detail.amount_usd);
                }

                if (detail.amount_riel > 0) {
                    amountRiel = ' ៛' + formatNumber(detail.amount_riel);
                }

                let currencyText = amountUSD;
                if (amountUSD && amountRiel) currencyText += '&nbsp;&nbsp;';
                currencyText += amountRiel;
                
                let row = ''
                if (detail.location) {
                    row = '<tr>' +
                        '<td class="table_tr_">- ' + detail.location.branch_name_kh + currencyText + '</td>' +
                    '</tr>';
                };
                if (detail.department) {
                    row = '<tr>' +
                        '<td class="table_tr_">- ' + detail.department.name_khmer + currencyText + '</td>' +
                    '</tr>';
                }

                if (index < mid) {
                    tr_a += row;
                } else {
                    tr_b += row;
                }
            }
            $(".locations_a tr").html(tr_a);
            $(".locations_b tr").html(tr_b);
           
            print_pdf("print_tax_expense")
        });
    });
    function nl2brWithIndent(str) {
        const lines = str.split('\n');
        return lines
            .map((line, index) => {
                if (index === 0) {
                    return line;
                } else {
                    return `<div style="margin-left:4%">${line}</div>`;
                }
            })
            .join('');
    }
    function formatNumber(amount) {
        let number = parseFloat(amount); 
        let result = number.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        return result;
    }
    function print_pdf(className) {
        $("#"+ className).show();
        window.setTimeout(function() {
            $('#modal-loading').modal('hide');
        }, 2000);
        $("#"+ className).printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: "{{asset('/admin/css/exp_print_style.css')}}",
            header: "",
            printDelay: 2500,
            formValues: false,
            canvas: false,
            doctypeString: "",
        });
    }
</script>
