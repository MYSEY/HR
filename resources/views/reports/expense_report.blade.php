@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: normal !important;
        text-align: left !important;
        max-width: 300px !important; 
        word-wrap: break-word !important;
    }
</style>
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">@lang('lang.expense_report')</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                <li class="breadcrumb-item active">@lang('lang.expense_report')</li>
            </ul>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-expense-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr>
                            <th class="stuck-scroll-3">#</th>
                            <th class="stuck-scroll-3">@lang('lang.tracking_id')</th>
                            <th class="stuck-scroll-3">@lang('lang.status')</th>
                            <th >@lang('lang.type')</th>
                            <th>@lang('lang.type_of_expense')</th>
                            <th>@lang('lang.amount') @lang('lang.usd')</th>
                            <th>@lang('lang.amount') @lang('lang.kh')</th>
                            <th>@lang('lang.type_of_payment')</th>
                            <th>@lang('lang.reference')</th>
                            <th>@lang('lang.description')</th>
                            <th>@lang('lang.request_date')</th>
                            <th>@lang('lang.approved_date')</th>
                            <th>@lang('lang.department')/@lang('lang.branch')</th>
                            <th>@lang('lang.request_by')</th>
                            <th>@lang('lang.review')</th>
                            <th style="text-align: center;">@lang('lang.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($datas)>0)
                            @foreach ($datas as $key=>$item)
                            
                                <tr class="odd">
                                    <td class="stuck-scroll-3">{{$key+1}}</td>
                                    <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                    <td class="stuck-scroll-3"> 
                                        @if ($item->status == "" || $item->status == "pending")
                                            <span class="badge bg-inverse-info" style="font-size: 13px;">@lang('lang.pending') @lang('lang.review')</span>
                                        @elseif ($item->status == "rejected")
                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                        @elseif($item->status == "approved")
                                            <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                        @endif
                                        
                                    </td>
                                    <td>{{$item->type == "1" ? "Special Expense": "General Expense"}}</td>
                                    <td >{{$item->expense_type == "1" ? "Regular Expense": "Irregular Expense"}}</td>
                                    <td >{{$item->ge_total_amount_usd}}</td>
                                    <td>{{$item->ge_total_amount_riel}}</td>
                                    <td>{{$item->payment_term}}</td>
                                    @if(count($item->References) <= 1)
                                        <td>
                                            @if(isset($item->References[0]->file_upload))
                                                <small class="block text-ellipsis">
                                                    <a href="{{ url('uploads/FnRegularExspenses/' . $item->References[0]->file_upload) }}" target="_blank">
                                                        {{ $item->reference }}
                                                    </a>
                                                </small>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            @foreach ($item->References as $rf)
                                                <small class="block text-ellipsis">
                                                    <a href="{{ url('uploads/FnRegularExspenses/' . $rf->file_upload) }}" target="_blank">
                                                        {{ $rf->serialref }}
                                                    </a>
                                                </small>
                                            @endforeach
                                        </td>
                                    @endif
                                    <td data-toggle="tooltip" data-html="true" title="{!! $item->subject !!}">
                                        {{ Str::limit($item->subject, 30, '...') }}
                                    </td>
                                    <td>{{$item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y H:i') : ''}}</td>
                                    <td>{{$item->date_approve ? \Carbon\Carbon::parse($item->date_approve)->format('d-M-Y') : ''}}</td>

                                    @php
                                        $locations = "";
                                        if (count($item->locationDetails)>0) {
                                            
                                            foreach ($item->locationDetails as $key => $location) {
                                                // dd($location->Location);
                                                if ($location->Location) {
                                                    $locations .= $location->Location->branch_name_en.", ";
                                                }
                                                
                                            }
                                        }
                                    @endphp

                                    <td data-toggle="tooltip" data-html="true" title="{!! $locations !!}" >
                                        {{ Str::limit($locations, 30, '...') }}
                                    </td>
                                    <td>{{$item->createdBy ? $item->createdBy->employee_name_en: ""}}</td>
                                    <td></td>
                                    <td style="text-align: center;">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item {{ $item->type == '2' ? 'btn-TEXP-print' : 'btn-GEXP-print'}}" href="#" data-datas="{{$item}}"><i class="fa fa-print fa-lg m-r-5"></i> @lang('lang.print')</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('FN_ExpenseRequests.print')
    @include('FN_tax_expenses.print')
    @include('components.loading-modal')
</div>
@endsection
@include('includs.script')
<script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>
<script src="{{asset('/admin/js/convertNumberToWordsExp.js')}}"></script>
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script src="{{asset('/admin/js/format-date-kh.js')}}"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({ 
            html: true,
            container: 'tr' 
        });
    });
    $(function() {
        $('.btn-GEXP-print').on('click', function() {
            $('#modal-loading').modal('show');
            var datas = $(this).data('datas');
            $(".p_kind_regard").text(datas.kind_regard);
            $(".p_subject").text(datas.subject);
            $(".p_reference").text(datas.reference);
            $(".p_reason_subject").text(datas.reason_subject);
            $(".p_ge_cost_material_usd").text(datas.ge_cost_material_usd);
            $(".p_ge_cost_lso_usd").text(datas.ge_cost_lso_usd);
            $(".p_ge_total_cost_usd").text(datas.ge_total_cost_usd);
            $(".p_ge_tax_usd").text(datas.ge_tax_usd);
            $(".p_ge_vat_reverse_charge_usd").text(datas.ge_vat_reverse_charge_usd);
            $(".p_ge_total_amount_usd").text(datas.ge_total_amount_usd);
            let convertNumber = convertNumberToWordsExp(datas.ge_total_amount_usd,"dollar");
            $(".p_convertNumberDollar").text(convertNumber);
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
            var datas = $(this).data('datas');
            console.log("datas: ", datas);
            $(".p_kind_regard").text(datas.kind_regard);
            $(".p_subject").text(datas.subject);
            $(".p_reference").text(datas.reference);
            $(".p_reason_subject").text(datas.reason_subject);
            $(".p_ge_cost_material_riel").text(datas.ge_cost_material_riel);
            $(".p_ge_cost_lso_riel").text(datas.ge_cost_lso_riel);
            $(".p_te_tax_income").text(datas.te_tax_income);
            $(".p_ge_total_cost_riel").text(datas.ge_total_cost_riel);
            $(".p_vat_reverse_charge_riel").text(datas.vat_reverse_charge_riel);
            $(".p_te_total_tax").text(datas.te_total_tax);
            let convertNumber = convertNumberToWordsExp(datas.te_total_tax,"rial");
            $(".p_convertNumberDollar").text(convertNumber);
            document.getElementById("TEXP_remark").innerHTML = nl2brWithIndent(datas.remark);
            $(".p_payment_term").text(datas.payment_term);
            $(".p_approved_by").text(datas.approve_by.employee_name_kh);
            $(".p_request_by").text(datas.request_by.employee_name_kh);
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
