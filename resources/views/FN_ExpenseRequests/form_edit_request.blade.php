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
                <h3 class="page-title">@lang('lang.edit_expense_request')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.edit_expense_request')</li>
                </ul>
            </div>
        </div>
    </div>
    @php
        $reference = explode(',', $data->reference);
        $items = array_map('trim', explode(',', $data->payment_term));
        $lastValue = end($items);
        $viewFile ="";
        foreach ($data->References as $key => $value) {
           if ($value->is_contactual !=1) {
            $viewFile = $value->file_upload;
           }
        }
    @endphp
    <div class="tab-pane fade active show hr-modal-select2" id="bank_statutory" role="tabpanel">
        <div class="row" style="justify-content: center">
            <div class="col-10">
                <div class="card card_background_color">
                    <div class="card-body">
                        <form>
                            <input type="text" hidden id="fn_id" value="{{$data->id}}">
                            <label class="container-checkbox">Special Expense
                                <input type="checkbox" id="exp-type" name="type" {{ $data->type == 1 ? 'checked' : '' }}> <span class="checkmark"></span>
                            </label><br>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">សូមគោរពជូន <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="form-group hr-form-group-select2">
                                        <select class="form-control requered fn_require hr-select2-option" id="fn_approve" name="fn_approve" required>
                                            @foreach ($FnApproval as $item)
                                                <option value="{{$item->title}}"  @if ($item->title == $data->kind_regard) selected @endif
                                                    data-description="{{$item->description}}" data-approved="{{$item->employee_id}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">កម្មវត្ថុ៖ <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea type="text" rows="3" class="form-control fn_require" name="fn_subject" id="fn_subject" required>{{ trim($data->subject ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">យោង៖ <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <label class="container-checkbox">Regular Expense
                                        <input type="checkbox" class="checkbox-group" name="selected_item" value="1" {{ $data->expense_type == 1 ? 'checked' : '' }}> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">Irregular Expense
                                        <input type="checkbox" class="checkbox-group" name="selected_item" value="2" {{ $data->expense_type == 2 ? 'checked' : '' }}> <span class="checkmark"></span>
                                    </label>
                                    <span class="text-danger" id="RI_required" style="display: none">Please check Regular Expense on Irregular Expense</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="form-group" id="view-Regular_reference" style="display: {{$data->expense_type == 1 ? 'block' : 'none'}}">
                                        <div class="input-group">
                                            <select class="form-control form-select" id="fn_reference">
                                                <option value="" >-- Select --</option>
                                                @foreach ($FnRegularExspenses as $item)
                                                    <option value="{{ $item->serialref }}"
                                                        @if (in_array($item->serialref, $reference)) selected @endif
                                                        data-file="{{ $item->file_upload ? url('uploads/FnRegularExspenses/' . $item->file_upload) : '' }}">
                                                        {{ $item->serialref . " " . $item->description }}
                                                    </option>
                                            @endforeach
                                            </select>
                                            <button id="reviewBtn" style="display: {{$data->expense_type == 1 ? 'block' : 'none'}}" class="btn btn-sm btn-outline-secondary" type="button">
                                                <a id="reviewLink" href="#" target="_blank" style="text-decoration: none; color: inherit;">Review File</a>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group input-group" id="view-Irregular_reference">
                                        {{-- Hidden input to keep the reference value --}}
                                        <input type="hidden" name="e_fn_invoice" id="e_fn_invoice" value="{{ $viewFile }}">
                                        {{-- Button to trigger file selection --}}
                                        <button class="btn btn-outline-secondary" type="button"
                                                onclick="document.getElementById('IrregularFile').click();">
                                            Choose New File
                                        </button>
                                        {{-- Show the file name (from DB or newly selected) --}}
                                        <input type="text" id="IrregularFileName" class="form-control form-control-lg"
                                               placeholder="No file selected" readonly value="{{ $viewFile }}">
                                        {{-- Hidden file input for uploading new file --}}
                                        <input type="file" name="IrregularFile" class="d-none" id="IrregularFile" onchange="updateFileName(this)">
                                    
                                        {{-- Review existing file --}}
                                        @if ($viewFile)
                                            <button class="btn btn-sm btn-outline-secondary" type="button">
                                                <a href="{{ url('uploads/FnRegularExspenses/' . $viewFile) }}" target="_blank" style="text-decoration: none; color: inherit;">Review File</a>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea type="text" rows="3" class="form-control fn_require" name="reason_subject" id="fn_reason_subject" required>{{ trim($data->reason_subject ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <fieldset class="row">
                                @if (Auth::user()->branch->abbreviations == "HQ")
                                    <legend class="col-form-label col-sm-2 pt-0">Add Locations <span class="text-danger">*</span></legend>
                                    <div class="col-sm-10">
                                        <div class="form-group hr-form-group-select2">
                                            <select class="form-control required hr-select2-option" id="addLocations" name="location_id" required>
                                                <option value="" disabled selected> Please select location </option>
                                                @foreach ($locations as $item)
                                                    <option value="{{$item->id}}" @if ($data->locationDetails[0]->location->id == $item->id) selected @endif data-name="{{$item->branch_name_en}}">{{$item->branch_name_en}}</option>
                                                @endforeach
                                            </select>
                                            <div class="table-responsive my-1" id="view-tbl_location">
                                                <table class="table table-striped custom-table mb-0 tbl-locations">
                                                    <tbody>
                                                        @foreach ($data->locationDetails as $item)
                                                            <tr class="odd">
                                                                <td class="align-middle">
                                                                    <div class="input-group d-flex justify-content-center">
                                                                        <input type="text" disabled class="form-control" data-id="{{$item->location->id}}" value="{{$item->location->branch_name_en}}">
                                                                    </div>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <div class="input-group d-flex justify-content-center">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" class="form-control " placeholder="0.00" value="{{$item->amount_usd}}">
                                                                    </div>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <div class="input-group d-flex justify-content-center">
                                                                        <span class="input-group-text" style="font-size: 20px">៛</span>
                                                                        <input type="number" placeholder="0" class="form-control" value="{{$item->amount_riel}}">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    <a class="btn btn-danger delete" href="#" data-id="{{$item->location->id}}">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </fieldset>

                            <label class="">ចំណាយរួមមាន៖</label>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">១. ថ្លៃទំនិញឬសម្ភារៈ</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" value="{{$data->ge_cost_material_usd}}" placeholder="0.00" class="form-control costs_include_required 1costs_include_requiredEn exp_costs_dollar" id="exp_costs_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="number" value="{{$data->ge_cost_material_riel}}" placeholder="0.00" class="form-control costs_include_required 1costs_include_requiredKh exp_costs_rial" id="exp_costs_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">២. ថ្លៃពលកម្ម/សេវា/ផ្សេងៗ</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" value="{{$data->ge_cost_lso_usd}}" class="form-control costs_include_required 2costs_include_requiredEn exp_costs_dollar" placeholder="0.00" id="exp_LSOC_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="number" value="{{$data->ge_cost_lso_riel}}" placeholder="0.00" class="form-control costs_include_required 2costs_include_requiredKh exp_costs_rial" id="exp_LSOC_rial">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"><span class="text-danger" id="include_required" style="display: none">Please input amount USD or amount KH</span></div>
                                
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">៣. សរុបចំណាយ (១+២)</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" value="{{$data->ge_total_cost_usd}}"class="form-control" disabled placeholder="0.00" id="exp_total_cost_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="number" value="{{$data->ge_total_cost_riel}}" disabled placeholder="0.00" class="form-control" id="exp_total_cost_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">៤. ពន្ធកាត់ទុក</label>
                                <div class="col-sm-3">
                                    <div class="input-group" style="margin-bottom: 0.4rem !important;">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control exp_total_paid" value="{{$data->ge_tax_usd}}" placeholder="0.00" id="exp_tax_wht_dollar">
                                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
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
                                            <input type="number" class="form-control exp_total_paid_rial" value="{{$data->tax_riel}}" placeholder="0.00" id="exp_tax_wht_rial">
                                            <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
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
                                <label class="col-form-label col-sm-5"><span class="m-3"> ឬពន្ធលើអត្ថប្រយោជន៍បន្ថែម</span></label>
                                <div class="col-sm-3">
                                    <div class="input-group" style="margin-bottom: 0.4rem !important;">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control exp_total_paid" value="{{$data->ge_tax_fringe_benefit_usd}}" placeholder="0.00" id="exp_tax_wbt_dollar">
                                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
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
                                            <input type="number" class="form-control exp_total_paid_rial" value="{{$data->tax_fringe_benefit_riel}}" placeholder="0.00" id="exp_tax_wbt_rial">
                                            <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
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
                                <label class="col-form-label col-sm-5">៥. អាករជំនួស (VAT Reverse Charge) ១០%</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control exp_total_paid" value="{{$data->ge_vat_reverse_charge_usd}}" placeholder="0.00" id="exp_reverse_charge_usd">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="number" value="{{$data->vat_reverse_charge_riel}}" placeholder="0.00" class="form-control exp_total_paid_rial" id="exp_reverse_charge_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5">៦. បើកជូនអ្នកផ្គត់ផ្គង់ (៣) ឬ (៣-(៤+៥))</label>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" value="{{$data->ge_total_amount_usd}}" disabled placeholder="0.00" id="exp_total_paid_dollar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="margin-bottom: 0.4rem;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size: 20px">៛</span>
                                            <input type="number" disabled value="{{$data->ge_total_amount_riel}}" placeholder="0.00" class="form-control" id="exp_total_paid_rial">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5"> <span class="m-3">- បើកជូនអ្នកផ្គត់ផ្គង់ជាអក្សរ (ដុល្លារអាមេរិក)</span> <span style="float: right">:</span></label>
                                <label class="col-form-label col-sm-6" id="convert_money_dollar"> </label>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-5"> <span class="m-3">- បើកជូនអ្នកផ្គត់ផ្គង់ជាអក្សរ (រៀល)</span> <span style="float: right">:</span></label>
                                <label class="col-form-label col-sm-6" id="convert_money_rial"> </label>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-sm-1"></label>
                                <label class="col-form-label col-sm-4">លក្ខខណ្ឌទូទាត់</label>
                                <div class="col-sm-3">
                                    <div class="form-group hr-form-group-select2">
                                        <label>@lang('lang.payment_by')</label>
                                        <select class="select form-control hr-select2-option fn_paymentterm paymentterm_requered" multiple="" name="fn_paymentterm[]" required>
                                            <option value=""> </option>
                                            @if (count($FnPaymentTerms)>0)
                                                @foreach ($FnPaymentTerms as $item)
                                                    <option value="{{$item->title}}" @if (in_array($item->title, $items)) selected @endif>{{$item->title}}</option>
                                                @endforeach 
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Other</label>
                                        <textarea rows="2"
                                                  class="form-control"
                                                  name="paymentterm_remark"
                                                  id="paymentterm_remark">{{ $lastValue }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-7"><span class="text-danger" id="paymentterm_required" style="display: none">Please select payment by or Other</span></div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea type="text" rows="3" class="form-control" disabled name="remark" id="remark">{{ $data->remark }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="button" class="btn btn-primary submit-update-btn">
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
<script>
    const expenseRequestUrl = "{{ url('/fn/expense-request/update') }}";
    const expenseRequestListUrl = "{{ url('/expense-request/list') }}";
    const buttonSubmit = "submit-update-btn";
</script>
<script src="{{asset('/admin/component-js/expense_request.js')}}"></script>
											

