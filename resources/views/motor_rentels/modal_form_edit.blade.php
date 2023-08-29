<div id="edit_motor_rentel" class="modal custom-modal fade hr-modal-select2" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.edit_motor_rentel')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('motor-rentel/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.motor_rentals')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.employee')</label>
                                <select class="form-control hr-select2-option requered" id="e_employee_id" name="employee_id" value="{{old('employee_id')}}" required>
                                    {{-- <option value="">select employee</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.number_plate') <span class="text-danger">*</span></label>
                                <input class="form-control @error('number_plate') is-invalid @enderror" type="text" id="e_number_plate" required name="number_plate" value="{{old('number_plate')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.start_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('start_date') is-invalid @enderror" type="text" id="e_start_date" required name="start_date" value="{{old('employee_name_kh')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.end_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('end_date') is-invalid @enderror" type="text" id="e_end_date" required name="end_date" value="{{old('end_date')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label class="">@lang('lang.year_of_manufature') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <select id="e_product_year" name="product_year"  class="form-control floating select select2-hidden-accessible" data-select2-id="select2-data-4-f353" tabindex="-1" aria-hidden="true">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.expiretion_year') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <select id="e_expired_year" name="expired_year"  class="form-control floating select select2-hidden-accessible" >
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.shelt_life') <span class="text-danger">*</span></label>
                                <input class="form-control @error('shelt_life') is-invalid @enderror" type="Number" id="e_shelt_life" required name="shelt_life" value="{{old('shelt_life')}}">
                            </div>
                        </div>
                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.total_gasoline') <span class="text-danger">*</span></label>
                                <input class="form-control @error('total_gasoline') is-invalid @enderror" type="number" id="e_total_gasoline" required name="total_gasoline" value="{{old('total_gasoline')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.total_working_days') <span class="text-danger">*</span></label>
                                <input class="form-control @error('total_work_day') is-invalid @enderror" type="number" id="e_total_work_day" required name="total_work_day" value="{{old('total_work_day')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.price_engine_oil') ($)<span class="text-danger">*</span></label>
                                <input class="form-control @error('price_engine_oil') is-invalid @enderror" type="number" id="e_price_engine_oil" required name="price_engine_oil" value="{{old('price_engine_oil')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.price_motor_rentel') ($)<span class="text-danger">*</span></label>
                                <input class="form-control @error('price_motor_rentel') is-invalid @enderror" type="number" id="e_price_motor_rentel" required name="price_motor_rentel" value="{{old('price_motor_rentel')}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.taplabs')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.taplab')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="e_taplab_rentel" name="taplab_rentel" placeholder="" value="{{old('taplab_rentel')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.taplab_price')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control" type="number" name="price_taplab_rentel" id="e_price_taplab_rentel" value="{{old('price_taplab_rentel')}}">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Tax rate (%)<span class="text-danger">*</span></label>
                                <input class="form-control @error('tax_rate') is-invalid @enderror" type="number" id="e_tax_rate" required name="tax_rate" value="{{old('tax_rate')}}">
                            </div>
                        </div> --}}
                    </div>
                    <input type="hidden" name="id" id="e_id">
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            {{-- Submit --}}
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>