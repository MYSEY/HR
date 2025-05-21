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
                                <a class="nav-link clearTabs" data-bs-toggle="tab" id="tab_assign" href="#tbl_assign" aria-selected="false" role="tab" data-tab-id="3" tabindex="-1">@lang('lang.assigned_to_me')
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
                $("#v_tax_riel").text("៛ "+datas.te_tax_income);
                $("#v_total_amount_riel").text("៛ "+datas.te_total_tax);
            }else{
                $("#v_expense_type").text("សរុបចំណាយ (១+២)");
                $("#v_total_cost_text").text("ពន្ធកាត់ទុក");
                convertNumberKH = convertNumberToWordsExp(datas.ge_total_amount_riel,"rial");
                $("#block_fringe_benefit").css("display","block");
                $("#v_tax_fringe_benefit_usd").text("$ "+datas.ge_tax_fringe_benefit_usd);
                $("#v_tax_fringe_benefit_riel").text("៛ "+datas.tax_fringe_benefit_riel);
                $("#v_tax_riel").text("៛ "+datas.tax_riel);
                $("#v_total_amount_riel").text("៛ "+datas.ge_total_amount_riel);
            }

            $("#v_kind_regard").val(datas.kind_regard);
            $("#v_subject").val(datas.subject);
            $("#v_reason_subject").val(datas.reason_subject);
            $("#v_payment_term").text(datas.payment_term);
            $("#v_cost_material_usd").text("$ "+datas.ge_cost_material_usd);
            $("#v_cost_material_riel").text("៛ "+datas.ge_cost_material_riel);
            $("#v_cost_lso_usd").text("$ "+datas.ge_cost_lso_usd);
            $("#v_cost_lso_riel").text("៛ "+datas.ge_cost_lso_riel);
            $("#v_total_cost_usd").text("$ "+datas.ge_total_cost_usd);
            $("#v_total_cost_riel").text("៛ "+datas.ge_total_cost_riel);
            $("#v_tax_usd").text("$ "+datas.ge_tax_usd);
            $("#v_vat_reverse_charge_usd").text("$ "+datas.ge_vat_reverse_charge_usd);
            $("#v_vat_reverse_charge_riel").text("៛ "+datas.vat_reverse_charge_riel);
            $("#v_total_amount_usd").text("$ "+datas.ge_total_amount_usd);
            $("#v_convert_money_dollar").text(convertNumberUSA);
            $("#v_convert_money_rial").text(convertNumberKH);
            $("#v_remark").val(datas.remark);
            let tr_a = "";
            let tr_b = "";
            if (datas.location_details.length === 1) {
                tr_a = '<tr>' +
                        '<td class="table_tr_">' +  "- " + datas.location_details[0].location.branch_name_kh +
                        'ចំនួនទឹកប្រាក់​ $ ' + datas.location_details[0].amount_usd + '</td>' +
                    '</tr>';
            } else {
                let mid = Math.ceil(datas.location_details.length / 2);

                for (let index = 0; index < datas.location_details.length; index++) {
                    let detail = datas.location_details[index];
                    let row = '<tr>' +
                                '<td class="table_tr_">' + "- " + detail.location.branch_name_kh +
                                'ចំនួនទឹកប្រាក់​ $ ' + detail.amount_usd + '</td>' +
                            '</tr>';

                    if (index < mid) {
                        tr_a += row;
                    } else {
                        tr_b += row;
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
                text: '@lang("lang.approve")',
                btnClass: 'btn-green btn-sm',
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
                    axios.post('{{ URL('fn/expense-request/processing') }}', {
                        'id': id,
                        'approve_date': approve_date,
                        'remark': remark,
                    }).then(function(response) {
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
                        axios.post('{{ URL('fn/expense-request/reject') }}', {
                            'id': id,
                            'remark': remark,
                        }).then(function(response) {
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
            $('#modal-loading').modal('show');
            var datas = $(this).data('datas');
            $(".p_kind_regard").text(datas.kind_regard);
            $(".p_subject").text(datas.subject);
            $(".p_reference").text(datas.reference);
            $(".p_reason_subject").text(datas.reason_subject);
            $(".p_ge_cost_material_usd").text(datas.ge_cost_material_usd);
            $(".p_ge_cost_material_kh").text(datas.ge_cost_material_riel);
            $(".p_ge_cost_lso_usd").text(datas.ge_cost_lso_usd);
            $(".p_ge_cost_lso_kh").text(datas.ge_cost_lso_riel);
            $(".p_ge_total_cost_usd").text(datas.ge_total_cost_usd);
            $(".p_ge_total_cost_kh").text(datas.ge_total_cost_riel);
            $(".p_ge_tax_usd").text(datas.ge_tax_usd);
            $(".p_ge_tax_kh").text(datas.tax_riel);
            $(".p_ge_vat_reverse_charge_usd").text(datas.ge_vat_reverse_charge_usd);
            $(".p_ge_vat_reverse_charge_kh").text(datas.vat_reverse_charge_riel);
            $(".p_ge_total_amount_usd").text(datas.ge_total_amount_usd);
            $(".p_ge_total_amount_kh").text(datas.ge_total_amount_riel);
            let convertNumber = convertNumberToWordsExp(datas.ge_total_amount_usd,"dollar");
            let convertNumberRiel = convertNumberToWordsExp(datas.ge_total_amount_riel,"rial");
            $(".p_convertNumberDollar").text(convertNumber);
            $(".p_convertNumberRiel").text(convertNumberRiel);
            document.getElementById("GEXP_remark").innerHTML = nl2brWithIndent(datas.remark);
            $(".p_payment_term").text(datas.payment_term);
            $(".p_approved_by").text(datas.approve_by.employee_name_kh);
            $(".p_request_by").text(datas.request_by.employee_name_kh);
            let day = ".......";
            let month = ".......";
            let year = ".......";
            if (datas.date_approve) {
                let date_approve = new Date(datas.date_approve);
                day = formatDate( date_approve, 'km', format_date={day: true});
                month = formatDate( date_approve, 'km', format_date={month: true});
                year = formatDate( date_approve, 'km', format_date={year: true});
            }
            $(".p_day").text(day);
            $(".p_month").text(month);
            $(".p_year").text(year);
            let tr_a = "";
            let tr_b = "";
            if (datas.location_details.length === 1) {
                tr_a = '<tr>' +
                        '<td class="table_tr_">' + datas.location_details[0].location.branch_name_kh +
                        'ចំនួនទឹកប្រាក់​ $ ' + datas.location_details[0].amount_usd + '</td>' +
                    '</tr>';
            } else {
                let mid = Math.ceil(datas.location_details.length / 2);

                for (let index = 0; index < datas.location_details.length; index++) {
                    let detail = datas.location_details[index];
                    let row = '<tr>' +
                                '<td class="table_tr_">' + detail.location.branch_name_kh +
                                'ចំនួនទឹកប្រាក់​ $ ' + detail.amount_usd + '</td>' +
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
            $('#modal-loading').modal('show');
            var datas = $(this).data('datas');
            $(".p_kind_regard").text(datas.kind_regard);
            $(".p_subject").text(datas.subject);
            $(".p_reference").text(datas.reference);
            $(".p_reason_subject").text(datas.reason_subject);
            $(".p_ge_cost_material_usd").text(datas.ge_cost_material_usd);
            $(".p_ge_cost_material_riel").text(datas.ge_cost_material_riel);
            $(".p_ge_cost_lso_usd").text(datas.ge_cost_lso_usd);
            $(".p_ge_cost_lso_riel").text(datas.ge_cost_lso_riel);
            $(".p_te_tax_usd").text(datas.ge_tax_usd);
            $(".p_te_tax_income").text(datas.te_tax_income);
            $(".p_ge_total_cost_usd").text(datas.ge_total_cost_usd);
            $(".p_ge_total_cost_riel").text(datas.ge_total_cost_riel);
            $(".p_vat_reverse_charge_usd").text(datas.ge_vat_reverse_charge_usd);
            $(".p_vat_reverse_charge_riel").text(datas.vat_reverse_charge_riel);
            $(".p_te_total_usd").text(datas.ge_total_amount_usd);
            $(".p_te_total_tax").text(datas.te_total_tax);
            let convertNumberRiel = convertNumberToWordsExp(datas.te_total_tax,"rial");
            let convertNumber = convertNumberToWordsExp(datas.ge_total_amount_usd,"dollar");
            $(".p_convertNumberRiel").text(convertNumberRiel);
            $(".p_convertNumberDollar").text(convertNumber);
            document.getElementById("TEXP_remark").innerHTML = nl2brWithIndent(datas.remark);
            $(".p_payment_term").text(datas.payment_term);
            $(".p_approved_by").text(datas.approve_by.employee_name_kh);
            $(".p_request_by").text(datas.request_by.employee_name_kh);
            let day = ".......";
            let month = ".......";
            let year = ".......";
            if (datas.date_approve) {
                let date_approve = new Date(datas.date_approve);
                day = formatDate( date_approve, 'km', format_date={day: true});
                month = formatDate( date_approve, 'km', format_date={month: true});
                year = formatDate( date_approve, 'km', format_date={year: true});
            }
            $(".p_day").text(day);
            $(".p_month").text(month);
            $(".p_year").text(year);
            // let tr_a = "";
            // let tr_b = "";
            // if (datas.departments.length === 1) {
            //     tr_a = '<tr>' +
            //             '<td class="table_tr_">' + datas.departments[0].department.name_khmer +
            //             'ចំនួនទឹកប្រាក់​ $ ' + datas.departments[0].amount_usd + '</td>' +
            //         '</tr>';
            // } else {
            //     let mid = Math.ceil(datas.departments.length / 2);

            //     for (let index = 0; index < datas.departments.length; index++) {
            //         let detail = datas.departments[index];
            //         let row = '<tr>' +
            //                     '<td class="table_tr_">' + detail.department.name_khmer +
            //                     'ចំនួនទឹកប្រាក់​ $ ' + detail.amount_usd + '</td>' +
            //                 '</tr>';

            //         if (index < mid) {
            //             tr_a += row;
            //         } else {
            //             tr_b += row;
            //         }
            //     }
            // }
            // $(".locations_a tr").html(tr_a);
            // $(".locations_b tr").html(tr_b);
           
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
