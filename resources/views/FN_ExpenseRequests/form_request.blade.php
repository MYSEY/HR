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
                <h3 class="page-title">@lang('lang.form_expense_request')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.form_expense_request')</li>
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
                                            <option selected disabled value="">@lang('lang.please_select') </option>
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
                                    <span class="text-danger" id="RI_required" style="display: none">@lang('lang.please_select_any_checkbox_to_request')</span>
                                    <label class="container-checkbox">@lang('lang.special_expense')
                                        <input type="checkbox" class="checkbox-group" id="exp-type" name="type"> <span class="checkmark"></span>
                                    </label>
                                    <div class="mx-4 my-3" id="special_fixed_asset" style="display: none">
                                        <label class="container-checkbox">@lang('lang.non_fixed_asset')
                                            <input type="checkbox" value="0" class="checkbox-group-fixed special_fixed_asset" name="special_fixed_asset"> <span class="checkmark"></span>
                                        </label>
                                        <label class="container-checkbox">@lang('lang.fixed_asset')
                                            <input type="checkbox" value="1" class="checkbox-group-fixed special_fixed_asset" name="special_fixed_asset"> <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <label class="container-checkbox">@lang('lang.regular_expense')
                                        <input type="checkbox" class="checkbox-group" name="selected_item" value="1"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.irregular_expense')
                                        <input type="checkbox" class="checkbox-group" name="selected_item" value="2"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="form-group hr-form-group-fn-select2" id="view-Regular_reference" style="display: none">
                                        {{-- <div class="input-group"> --}}
                                            <select class="form-control hr-select2-option fn_reference_require" id="fn_reference">
                                                <option value="">@lang('lang.select')</option>
                                                @foreach ($FnRegularExspenses as $item)
                                                    <option value="{{$item->serialref}}" data-file="{{ $item->file_upload ? url('uploads/FnRegularExspenses/' . $item->file_upload) : '' }}">
                                                        {{ $item->serialref." ".  $item->description}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button id="reviewBtn" style="display: none;" class="btn btn-sm btn-outline-secondary" type="button">
                                                <a id="reviewLink" href="#" target="_blank" style="text-decoration: none; color: inherit;">Review file regular</a>
                                            </button>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group input-group" id="view-Irregular_reference">
                                        <button class="btn btn-outline-secondary" type="button"
                                                onclick="document.getElementById('IrregularFile').click();">
                                            @lang('lang.choose_new_file')
                                        </button>
                                        {{-- Show the file name (from DB or newly selected) --}}
                                        <input type="text" id="IrregularFileName" class="form-control form-control-lg" placeholder="PDF តែមួយ File" readonly>
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
                                        <textarea type="text" rows="3" class="form-control fn_require" name="reason_subject" id="fn_reason_subject" required>តបតាមកម្មវត្ថុ និងយោងខាងលើ ខ្ញុំបាទ/នាងខ្ញុំស្នើសុំ</textarea>
                                    </div>
                                </div>
                            </div>

                            <fieldset class="row">
                                @if (Auth::user()->branch->abbreviations == "HQ")
                                    <legend class="col-form-label col-sm-2 pt-0">@lang('lang.add_locations') <span class="text-danger">*</span></legend>
                                    <div class="col-sm-10">
                                        <div class="form-group hr-form-group-select2">
                                            <select class="form-control required hr-select2-option" id="addLocations" name="location_id" required>
                                                <option value="" disabled selected> @lang('lang.please_select_location') </option>
                                                @foreach ($locations as $item)
                                                    <option value="{{$item->id}}" data-name="{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}">{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
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
                                            <input type="text" class="form-control khmer-toEnglish-number-only costs_include_required 1costs_include_requiredEn exp_costs_dollar" id="exp_costs_dollar" placeholder="0.00" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" placeholder="0.00" class="form-control khmer-toEnglish-number-only costs_include_required 1costs_include_requiredKh exp_costs_rial" id="exp_costs_rial">
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
                                            <input type="text" class="form-control khmer-toEnglish-number-only costs_include_required 2costs_include_requiredEn exp_costs_dollar" placeholder="0.00" id="exp_LSOC_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" placeholder="0.00" class="form-control khmer-toEnglish-number-only costs_include_required 2costs_include_requiredKh exp_costs_rial" id="exp_LSOC_rial">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"><span class="text-danger" id="include_required" style="display: none">Please input amount USD or amount KH</span></div>
                                
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.total_expense')</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control khmer-toEnglish-number-only" disabled placeholder="0.00" id="exp_total_cost_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" disabled placeholder="0.00" class="form-control khmer-toEnglish-number-only" id="exp_total_cost_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.withholding_tax')</label>
                                <div class="col-sm-3">
                                    <div class="input-group" style="margin-bottom: 0.4rem !important;">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control khmer-toEnglish-number-only exp_total_paid" data-taxpaid="1" placeholder="0.00" id="exp_tax_wht_dollar">
                                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span id="withholding_tax_text_usd"></span>%</button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if (count($taxWHT)>0)
                                                @foreach ($taxWHT as $item)
                                                    <li><a class="dropdown-item action_tax_wht_dollar" data-tax="{{$item->tax_rate}}" role="button">{{$item->tax_rate}}%</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group" style="margin-bottom: 0.4rem !important;">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" class="form-control khmer-toEnglish-number-only exp_total_paid_rial" data-taxpaid="2" placeholder="0.00" id="exp_tax_wht_rial">
                                            <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span id="withholding_tax_text_riel"></span>%</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if (count($taxWHT)>0)
                                                    @foreach ($taxWHT as $item)
                                                        <li><a class="dropdown-item action_tax_wht_rial" data-tax="{{$item->tax_rate}}">{{$item->tax_rate}}%</a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5"><span class="m-3">@lang('lang.or_tax_on_fring_benefit')</span></label>
                                <div class="col-sm-3">
                                    <div class="input-group" style="margin-bottom: 0.4rem !important;">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control khmer-toEnglish-number-only exp_total_paid" data-taxpaid="3" placeholder="0.00" id="exp_tax_wbt_dollar">
                                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span id="exp_tax_wbt_text_usd"></span>%</button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if (count($taxeFBT)>0)
                                                @foreach ($taxeFBT as $item)
                                                    <li><a class="dropdown-item action_tax_wbt_dollar" data-tax="{{$item->tax_rate}}">{{$item->tax_rate}}%</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group" style="margin-bottom: 0.4rem !important;">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" class="form-control khmer-toEnglish-number-only exp_total_paid_rial" data-taxpaid="4" placeholder="0.00" id="exp_tax_wbt_rial">
                                            <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span id="exp_tax_wbt_text_riel"></span>%</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if (count($taxeFBT)>0)
                                                    @foreach ($taxeFBT as $item)
                                                        <li><a class="dropdown-item action_tax_wbt_rial" data-tax="{{$item->tax_rate}}">{{$item->tax_rate}}%</a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.vat_reverse_charge_10')</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control khmer-toEnglish-number-only exp_total_paid" placeholder="0.00" id="exp_reverse_charge_usd">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="text" placeholder="0.00" class="form-control khmer-toEnglish-number-only exp_total_paid_rial" id="exp_reverse_charge_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">@lang('lang.paid_to_supplier(3)or(3-(4+5))')</label>
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
<script src="{{asset('/admin/component-js/expense_request.js')}}"></script>
											

