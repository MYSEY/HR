<div id="view_information_expense" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.view_information') <span class="type_request_expense"></span></h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    {{-- <label style="display: none" class="v_type_exp" style="font-weight: bold;">Special Expense</label><br> --}}
                    <div class="row">
                        <label class="col-sm-2 col-form-label" style="font-weight: bold;">សូមគោរពជូន</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea type="text" rows="3" class="form-control" disabled  id="v_kind_regard"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" style="font-weight: bold;">កម្មវត្ថុ៖</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea type="text" rows="3" class="form-control" disabled  id="v_subject"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" style="font-weight: bold;">យោង៖</label>
                        <div class="col-sm-10">
                            <div class="col-form-label" id="v_reference"></div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea type="text" rows="3" class="form-control" disabled id="v_reason_subject"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                        </div>
                    </div>
                    @if (Auth::user()->branch->abbreviations == "HQ")
                        <fieldset class="row">
                            <div class="col-sm-6">
                                <table style="width:100%" class="v_locations_a">
                                    <tr >
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <table style="width:100%" class="v_locations_b">
                                    <tr>
                                       
                                    </tr>
                                </table>
                            </div>
                        </fieldset><br>
                    @endif
                    <label style="font-weight: bold;">ចំណាយរួមមាន៖</label>
                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6">១. ថ្លៃទំនិញឬសម្ភារ <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-2" id="v_cost_material_usd"> </label>
                        <label class="col-form-label col-sm-3" id="v_cost_material_riel"> </label>
                    </div>
                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6">២. ថ្លៃពលកម្ម/ជួល/សេវា/ផ្សេងៗ <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-2" id="v_cost_lso_usd"> </label>
                        <label class="col-form-label col-sm-3" id="v_cost_lso_riel"> </label>
                    </div>
                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6">៣. <span id="v_expense_type"></span> <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-2" id="v_total_cost_usd"> </label>
                        <label class="col-form-label col-sm-3" id="v_total_cost_riel"> </label>
                    </div>
                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6">៤. <span id="v_total_cost_text"></span> <span class="percentage_tax_wht_usd"></span> <span class="percentage_tax_wht_riel"></span> <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-2" id="v_tax_usd"> </label>
                        <label class="col-form-label col-sm-3" id="v_tax_riel"> </label>
                    </div>
                    <div id="block_fringe_benefit" style="display: none">
                        <div class="row">
                            <label class="col-form-label col-sm-1"></label>
                            <label class="col-form-label col-sm-6"><span class="m-3"> ឬពន្ធលើអត្ថប្រយោជន៍បន្ថែម/ប្រាក់បៀវត្ស</span> <span style="float: right">:</span></label>
                            <label class="col-form-label col-sm-2" id="v_tax_fringe_benefit_usd"> </label>
                            <label class="col-form-label col-sm-3" id="v_tax_fringe_benefit_riel"> </label>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-1"></label>
                            <label class="col-form-label col-sm-6">៥. អាករជំនួស (VAT Reverse Charge) ១០% <span style="float: right">:</span></label>
                            <label class="col-form-label col-sm-2" id="v_vat_reverse_charge_usd"> </label>
                            <label class="col-form-label col-sm-3" id="v_vat_reverse_charge_riel"> </label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6"><span id="v_suppliers"></span> <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-2" id="v_total_amount_usd"> </label>
                        <label class="col-form-label col-sm-3" id="v_total_amount_riel"> </label>
                    </div>


                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6"> <span class="m-3">- បើកជូនអ្នកផ្គត់ផ្គង់ជាអក្សរ (ដុល្លារអាមេរិក)</span> <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-5" id="v_convert_money_dollar"> </label>
                    </div>
                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6"> <span class="m-3">- បើកជូនអ្នកផ្គត់ផ្គង់ជាអក្សរ (រៀល)</span> <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-5" id="v_convert_money_rial"> </label>
                    </div>
                    <div class="row">
                        <label class="col-form-label col-sm-1"></label>
                        <label class="col-form-label col-sm-6">លក្ខខណ្ឌទូទាត់ <span style="float: right">:</span></label>
                        <label class="col-form-label col-sm-5" id="v_payment_term"></label>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea type="text" rows="3" class="form-control" disabled id="v_remark"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <input type="text" hidden name="Stage_review" id="Stage_review">
                        <button type="button" class="btn btn-reject" id="v-btn-reject" style="background-color: #fccf0a; color:white">
                            <span class="btn-text-print">@lang('lang.return')</span>
                            <span id="btn-print-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                        <button type="button" class="btn btn-approved" id="v-btn-approve">
                            <span class="btn-text-save"></span>
                            <span id="btn-save-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                            @lang('lang.cancel')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>