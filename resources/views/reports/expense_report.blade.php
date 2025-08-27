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
<form>
    {{-- @csrf --}}
    <div class="row filter-btn"> 
        <div class="col-sm-9 col-md-9"> 
            <div class="row">
                <div class="col-4">
                    <div class="form-group cls-research">
                        <input type="text" class="form-control" name="tracking_id" id="tracking_id" placeholder="@lang('lang.tracking_id')" value="{{old('tracking_id')}}">
                    </div>
                    <div class="form-group">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" id="request_date" placeholder="@lang('lang.request_date')">
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <select class="select form-control" id="type" data-select2-id="select2-data-2" name="type">
                            <option value="" data-select2-id="select2-data-2-"> All Type</option>
                            <option value="3">@lang('lang.general_expense')</option>
                            <option value="2">@lang('lang.tax_expense')</option>
                            <option value="1">@lang('lang.special_expense')</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" id="approved_date" placeholder="@lang('lang.approved_date')">
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group" id="col-branch">
                        <select class="select form-control" id="type_of_expense" data-select2-id="select2-data-2-c" name="type_of_expense">
                            <option value="" data-select2-id="select2-data-2-c">All @lang('lang.type_of_expense')</option>
                            <option value="1">@lang('lang.regular_expense')</option>
                            <option value="2">@lang('lang.irregular_expense')</option>
                        </select>
                    </div>
                    <div class="form-group" id="col-branch">
                        <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                            @foreach ($locations as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="col-sm-3 col-md-3">
            <div style="display: flex" class="float-end">
               <button type="button" class="btn btn-sm btn-outline-secondary submit-btn btn-research me-2" data-dismiss="modal" id="icon-search-download-reload">
                    <span class="btn-txt"><i class="fa fa-search"></i></span>
                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                </button>
                @if ($permission->is_export == "1")
                    <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                        <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                        <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                @endif
                <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                    <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                    <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                </button>
            </div>
        </div>
    </div>
</form>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                             @if (method_exists($datas, 'total') && $datas->total() > 9)
                            {{-- @if ($datas->total() > 9) --}}
                                <form method="GET" class="mb-3">
                                    <label>Show 
                                        <select name="per_page" onchange="this.form.submit()" class="per_page">
                                            <?php
                                                for ($i = 10; $i <= $datas->total(); $i *= 2) {
                                                    echo '<option value="'.$i.'" '.(request('per_page') == $i ? 'selected' : '').'>'.$i.'</option>';
                                                }
                                                if ($datas->total() > $i / 2) {
                                                    echo '<option value="'.$datas->total().'" '.(request('per_page') == $datas->total() ? 'selected' : '').'>'.$datas->total().'</option>';
                                                }
                                            ?>
                                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
                                        </select> entries
                                    </label>
                                </form>
                            @endif
                            <table class="table table-striped custom-table mb-0  no-footer tbl-expense-report">
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
                                        <th>@lang('lang.approved_by')</th>
                                        <th>@lang('lang.location')</th>
                                        <th>@lang('lang.request_by') @lang('lang.location')</th>
                                        <th>@lang('lang.request_by')</th>
                                        <th style="text-align: center;">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($datas)>0)
                                    {{-- @dd($datas) --}}
                                        @foreach ($datas as $key=>$item)
                                        
                                            <tr class="odd">
                                                <td class="stuck-scroll-3">{{$key+1}}</td>
                                                <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                                <td class="stuck-scroll-3"> 
                                                    @if ($item->status == "" || $item->status == "pending")
                                                        <span class="badge bg-inverse-info" style="font-size: 13px;">@lang('lang.pending') @lang('lang.review')</span>
                                                    @elseif ($item->status == "rejected")
                                                        <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>
                                                    @elseif ($item->status == "cancel")
                                                        <span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>
                                                    @elseif($item->status == "approved")
                                                        <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    @if ($item->type == "1")
                                                        <span >Special Expense</span>
                                                    @elseif ($item->type == "2")
                                                        <span >Tax Expense</span>
                                                    @else
                                                        <span >General Expense</span>
                                                    @endif
                                                </td>
                                                <td >{{
                                                        $item->type == "0" ?  $item->expense_type == "1" ? "Regular Expense": "Irregular Expense" : ""
                                                    }}</td>
                                                <td >$ {{number_format($item->amount_usd, 2)}}</td>
                                                <td>៛ {{number_format($item->amount_riel, 2)}}</td>
                                                <td>{{$item->payment_term}}</td>
                                                @if(count($item->expenseRequest->References) <= 1)
                                                    <td>
                                                        @if(isset($item->expenseRequest->References[0]->file_upload))
                                                            <small class="block text-ellipsis">
                                                                <a href="{{ url('uploads/FnRegularExspenses/' . $item->expenseRequest->References[0]->file_upload) }}" target="_blank">
                                                                    {{ $item->reference }}
                                                                </a>
                                                            </small>
                                                        @endif
                                                    </td>
                                                @else
                                                    <td>
                                                        @foreach ($item->expenseRequest->References as $rf)
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
                                                <td>{{$item->approver_employee_name_en}}</td>
                                                
                                                <td>
                                                    @if ($item->type == "2")
                                                        {{$item->department ? $item->department->name_english : $item->location->branch_name_en}}
                                                    @else
                                                        {{$item->location->branch_name_en}}
                                                    @endif
                                                    {{-- {{ $item->type == "2" ?  $item->department->name_english : $item->location->branch_name_en}} --}}
                                                </td>
                                                
                                                <td>
                                                    {{
                                                        $item->expenseRequest->requestBy->department->name_english." / ".$item->expenseRequest->requestBy->branch->branch_name_en

                                                    }}
                                                </td>
                                                <td>
                                                    {{$item->expenseRequest->createdBy ? $item->expenseRequest->createdBy->employee_name_en: ""}}
                                                </td>
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
                            @if ($datas instanceof \Illuminate\Contracts\Pagination\Paginator)
                             {!! $datas->withQueryString()->links('pagination::bootstrap-5') !!}
                            @endif
                            
                        </div>
                    </div>
                </div>
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
         $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('/fn/expense/report') }}"); 
        });
        $(".btn-research").on("click", function () {
            $(this).prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block');
            let currentPage = $(".per_page").val();
            let param = {
                "_token": "{{ csrf_token() }}",
                tracking_id:     $("#tracking_id").val(),
                date_request:    $("#request_date").val(),
                date_approve:    $("#approved_date").val(),
                type:            $("#type").val(),
                expense_type:    $("#type_of_expense").val(),
                location_id:     $("#branch_id").val(),
                per_page: currentPage,
            };
            showdatas(param);
        });
        $(".btn_excel").on("click", function () {
            let currentPage = $(".per_page").val();
            let query = {
                "_token": "{{ csrf_token() }}",
                tracking_id:     $("#tracking_id").val(),
                date_request:    $("#request_date").val(),
                date_approve:    $("#approved_date").val(),
                type:            $("#type").val(),
                expense_type:    $("#type_of_expense").val(),
                location_id:     $("#branch_id").val(),
                per_page: currentPage,
            };
            var url = "{{URL::to('fn/expense/report/export')}}?" + $.param(query)
            window.location = url;
        });
        $(document).on('click','.btn-GEXP-print', function() {
            $('.number_supplier').text('៦ បើកជូនអ្នកផ្គត់ផ្គង់ (៣) ឫ (៣-(៤+៥))');
            $('#modal-loading').modal('show');
            var datas = $(this).data('datas');
             $(".expense_tracking_id").text(datas.tracking_id);
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
            $(".p_approved_by").text(datas.expense_request.approve_by.employee_name_kh);
            $(".p_request_by").text(datas.expense_request.request_by.employee_name_kh);
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
            if (datas.expense_request.location_details.length === 1) {
                tr_a = '<tr>' +
                        '<td class="table_tr_">' + datas.expense_request.location_details[0].location.branch_name_kh +
                        'ចំនួនទឹកប្រាក់​ $ ' + datas.expense_request.location_details[0].amount_usd + '</td>' +
                    '</tr>';
            } else {
                let mid = Math.ceil(datas.expense_request.location_details.length / 2);

                for (let index = 0; index < datas.expense_request.location_details.length; index++) {
                    let detail = datas.expense_request.location_details[index];
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
        $(document).on('click','.btn-TEXP-print', function() {
            $('.p_reverse_charge').css('display','none');
            $('.number_supplier').text('៥ បើកជូនអ្នកផ្គត់ផ្គង់ (៤)');
            $('#modal-loading').modal('show');
            var datas = $(this).data('datas');
             $(".expense_tracking_id").text(datas.tracking_id);
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
            // $(".p_vat_reverse_charge_usd").text(datas.ge_vat_reverse_charge_usd);
            // $(".p_vat_reverse_charge_riel").text(datas.vat_reverse_charge_riel);
            $(".p_te_total_usd").text(datas.ge_total_amount_usd);
            $(".p_te_total_tax").text(datas.te_total_tax);
            let convertNumberRiel = convertNumberToWordsExp(datas.te_total_tax,"rial");
            let convertNumber = convertNumberToWordsExp(datas.ge_total_amount_usd,"dollar");
            $(".p_convertNumberRiel").text(convertNumberRiel);
            $(".p_convertNumberDollar").text(convertNumber);
            document.getElementById("TEXP_remark").innerHTML = nl2brWithIndent(datas.remark);
            $(".p_payment_term").text(datas.payment_term);
            $(".p_approved_by").text(datas.expense_request.approve_by.employee_name_kh);
            $(".p_request_by").text(datas.expense_request.request_by.employee_name_kh);
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
            let mid = Math.ceil(datas.expense_request.location_details.length / 2);

            for (let index = 0; index < datas.expense_request.location_details.length; index++) {
                let detail = datas.expense_request.location_details[index];
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

    function showdatas(param) {  
        $.ajax({
            url: "{{ url('fn/expense/search') }}",
            type: 'POST',
            data:param,
            dataType: 'JSON',
            success: function(response){
                let datas = response.data;
                var tr = "";
                let num = 0;
                let status = "";
                let type = "";
                if (datas.length > 0) {
                    datas.forEach(item => {
                        num ++;
                        let date_request = moment(item.date_request).format('DD-MMM-YYYY');
                        let date_approve = moment(item.date_approve).format('DD-MMM-YYYY');
                        if (item.status == "" || item.status == "pending") {
                             status = '<span class="badge bg-inverse-info" style="font-size: 13px;">@lang("lang.pending") @lang("lang.review")</span>';
                        }else if (item.status == "rejected") {
                            status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected</span>';
                        }else if (item.status == "cancel") {
                            status = '<span class="badge bg-inverse-danger" style="font-size: 13px;">Cancel</span>';
                        }else if (item.status == "approved") {
                            status = '<span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>';
                        };
                        if (item.type == "1"){
                           type = '<span >Special Expense</span>';
                        }else if (item.type == "2"){
                           type = '<span >Tax Expense</span>';
                        }else{
                            type = '<span >General Expense</span>';
                        };

                        let referenceTd = '<td>';
                        let references = item.expense_request?.references || []; // use lowercase 'references'

                        // Handle if there’s only one reference
                        if (references.length === 1) {
                            const ref = references[0];
                            if (ref?.file_upload) {
                                referenceTd += `
                                    <small class="block text-ellipsis">
                                        <a href="/uploads/FnRegularExspenses/${ref.file_upload}" target="_blank">
                                            ${ref.serialref || item.reference}
                                        </a>
                                    </small>
                                `;
                            }
                        } else if (references.length > 1) {
                            references.forEach(ref => {
                                if (ref?.file_upload) {
                                    referenceTd += `
                                        <small class="block text-ellipsis">
                                            <a href="/uploads/FnRegularExspenses/${ref.file_upload}" target="_blank">
                                                ${ref.serialref}
                                            </a>
                                        </small>
                                    `;
                                }
                            });
                        }
                        let location = "";
                        if (item.department) {
                            location = item.department.name_english;
                        }
                        if (item.location) {
                            location = item.location.branch_name_en;
                        }

                        referenceTd += '</td>';
                        let printClass = item.type == "2" ? "btn-TEXP-print" : "btn-GEXP-print";
                        let btn = '<div class="dropdown-menu dropdown-menu-right">'+
                                    '<a class="dropdown-item ' + printClass + '" href="#" data-datas=\'' + JSON.stringify(item) + '\'>' +
                                        '<i class="fa fa-print fa-lg m-r-5"></i> ' + '@lang("lang.print")' +
                                    '</a>' +
                                '</div>';

                        tr +='<tr class="odd">'+
                            '<td class="ids stuck-scroll-3">'+(num)+'</td>'+
                            '<td class="stuck-scroll-3">'+ item.tracking_id  +'</td>'+
                            '<td class="stuck-scroll-3">'+ status +'</td>'+
                            '<td >'+ type +'</td>'+
                            '<td >'+(item.expense_type == "1" ? "Regular Expense": "Irregular Expense")+'</td>'+
                            '<td >$ '+formatNumber(item.amount_usd)+'</td>'+
                            '<td>៛​​ '+formatNumber(item.amount_riel)+'</td>'+
                            '<td>'+item.payment_term+'</td>'+
                            referenceTd+
                            '<td data-toggle="tooltip" data-html="true" title="'+ item.subject +'">'+
                                strLimit(item.subject, 30, '...') +
                            '</td>'+
                            '<td>'+date_request+'</td>'+
                            '<td>'+date_approve+'</td>'+
                            '<td>'+item.approver_employee_name_en+'</td>'+

                            '<td>'+(location)+'</td>'+

                            '<td>'+(item.expense_request.request_by.department.name_english)+' / '+(item.expense_request.request_by.branch.branch_name_en)+'</td>'+
                            '<td>'+item.expense_request.request_by.employee_name_en+'</td>'+
                            '<td style="text-align: center;">'+
                                '<div class="dropdown dropdown-action">'+
                                    '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>'+
                                    btn+
                                '</div>'+
                            '</td>'+
                        '</tr>';
                            
                    });
                }
                $(".tbl-expense-report tbody").html(tr);
                $(".btn-research").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none');
            }
        });
    }
     function formatNumber(amount) {
        let number = parseFloat(amount); 
        let result = number.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        return result;
    }
    function strLimit(str, limit = 30, end = '...') {
        return str.length > limit ? str.substring(0, limit) + end : str;
    }
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
