@extends('layouts.master')
<style>
    .card_background_color {
        background-color: #f8f9fa !important;
    }
     /* The container checkbox */
     .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.tax_request')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.tax_request')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade active show hr-modal-select2" id="bank_statutory" role="tabpanel">
        <div class="row" style="justify-content: center">
            <div class="col-10">
                <div class="card card_background_color">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">@lang('lang.submit_to') <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="form-group hr-form-group-select2">
                                        <select class="form-control requered fn_require hr-select2-option" id="fn_approve" name="fn_approve" required>
                                            <option selected disabled value=""> @lang('lang.please_select') </option>
                                            @foreach ($FnApproval as $item)
                                                <option value="{{$item->title}}" data-description="{{$item->description}}" data-approved="{{json_encode($item->employee_id)}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">@lang('lang.object') <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea type="text" rows="3" class="form-control fn_require" name="fn_subject" id="fn_subject" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">@lang('lang.reference') <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="form-group input-group" id="view-Irregular_reference">
                                        <button class="btn btn-outline-secondary" type="button"
                                                onclick="document.getElementById('IrregularFile').click();">
                                            @lang('lang.choose_new_file')
                                        </button>
                                        {{-- Show the file name (from DB or newly selected) --}}
                                        <input type="text" id="IrregularFileName" class="form-control form-control-lg" placeholder="No file selected" readonly>
                                        <input type="file" name="IrregularFile" class="d-none" id="IrregularFile" onchange="updateFileName(this)">
                                        <button class="btn btn-outline-secondary" type="button" onclick="openFileInNewTab()">@lang('lang.review_file')</button>
                                        <button class="btn btn-outline-danger btn-clear-file" type="button"> @lang('lang.clear') </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea type="text" rows="3" class="form-control fn_require"  name="reason_subject" id="fn_reason_subject" required>តបតាមកម្មវត្ថុ និងយោងខាងលើ ខ្ញុំបាទ/នាងខ្ញុំស្នើសុំ</textarea>
                                    </div>
                                </div>
                            </div>

                            <fieldset class="row">
                                @if (Auth::user()->branch->abbreviations == "HQ")
                                    <legend class="col-form-label col-sm-2 pt-0">@lang('lang.add_departments') <span class="text-danger">*</span></legend>
                                    <div class="col-sm-10">
                                        <div class="form-group hr-form-group-select2">
                                            <select class="form-control required hr-select2-option" id="addLocations" name="location_id" required>
                                                <option value="" disabled selected> @lang('lang.please_select_department') </option>
                                                @foreach ($locations as $lt)
                                                    {{-- @if ($lt->abbreviations !="HQ") --}}
                                                        <option value="{{$lt->id}}" data-leocatiotype="branch" data-name="{{Helper::getLang() == 'en' ? $lt->branch_name_en : $lt->branch_name_kh}}">{{Helper::getLang() == 'en' ? $lt->branch_name_en : $lt->branch_name_kh}}</option>
                                                    {{-- @endif --}}
                                                @endforeach
                                                @foreach ($department as $item)
                                                    <option value="{{$item->id}}" data-leocatiotype="department" data-name="{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                                @endforeach
                                            </select>
                                            <div class="table-responsive my-1" style="display: none" id="view-tbl_location">
                                                <table class="table table-striped custom-table mb-0 tbl-locations">
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </fieldset>

                            <label class="">@lang('lang.including_expense')</label>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.goods_or_materials')</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control khmer-toEnglish-number-only costs_include_required exp_costs_dollar" id="exp_costs_dollar" placeholder="0.00" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" placeholder="0.00" class="form-control khmer-toEnglish-number-only costs_include_required exp_costs_rial" id="exp_costs_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.labor_fee/services/sthers')</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control khmer-toEnglish-number-only costs_include_required exp_costs_dollar" placeholder="0.00" id="exp_LSOC_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" placeholder="0.00" class="form-control khmer-toEnglish-number-only costs_include_required exp_costs_rial" id="exp_LSOC_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.tax_declaration_expenses')</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control khmer-toEnglish-number-only costs_include_required exp_tax_declaration_dollar exp_costs_dollar" id="exp_tax_declaration_dollar" placeholder="0.00" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" placeholder="0.00" class="form-control khmer-toEnglish-number-only costs_include_required exp_tax_declaration_rial exp_costs_rial" id="exp_tax_declaration_rial">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"><span class="text-danger" id="include_required" style="display: none">Please input amount USD or amount KH</span></div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.total_expense(១+២+៣)')</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" disabled placeholder="0.00" id="exp_total_cost_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="number" disabled placeholder="0.00" class="form-control" id="exp_total_cost_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.paid_to_supplier(4)')</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" disabled placeholder="0.00" id="exp_total_paid_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="number" disabled placeholder="0.00" class="form-control" id="exp_total_paid_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5"> <span class="m-3">- @lang('lang.paid_to_supplier(USD)')</span> <span style="float: right">:</span></label>
                                <label class="col-form-label col-sm-6" id="convert_money_dollar"> </label>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5"> <span class="m-3">- @lang('lang.paid_to_supplier(KHR)')</span> <span style="float: right">:</span></label>
                                <label class="col-form-label col-sm-6" id="convert_money_rial"> </label>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-4">@lang('lang.payment_term')</label>
                                <div class="col-sm-3">
                                    <div class="form-group hr-form-group-select2">
                                        <label>@lang('lang.payment_by')</label>
                                        <select class="select form-control hr-select2-option fn_paymentterm paymentterm_requered" multiple="" name="fn_paymentterm[]" required>
                                            <option value=""> </option>
                                            @if (count($FnPaymentTerms)>0)
                                                @foreach ($FnPaymentTerms as $item)
                                                    <option value="{{$item->title}}">{{$item->title}}</option>
                                                @endforeach 
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang('lang.other')</label>
                                        <textarea type="text" style="height: 45px;" class="form-control" name="paymentterm_remark" id="paymentterm_remark"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-7"><span class="text-danger" id="paymentterm_required" style="display: none">@lang('lang.please_select_payment_by_or_Other')</span></div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea type="text" rows="3" class="form-control" disabled name="remark" id="remark"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="button" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                        @lang('lang.loading') </span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                                <a href="{{ url('expense-request/list') }}"
                                    class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script src="{{asset('/admin/js/convertNumberToWordsExp.js')}}"></script>
<script src="{{asset('/admin/js/khmerToEnglishNumber.js')}}"></script>
<script>
    const expenseRequestUrl = "{{ url('/fn/expense-request') }}";
    const expenseRequestListUrl = "{{ url('/expense-request/list') }}";
    const buttonSubmit = "submit-btn";
</script>
<script src="{{asset('/admin/component-js/tax_expense.js')}}"></script>
											

