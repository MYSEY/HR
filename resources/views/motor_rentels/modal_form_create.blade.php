<div id="add_motor_rentel" class="modal custom-modal fade hr-modal-select2" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.add_new_rental')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('motor-rentel/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.motor_rentals')</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.employee')</label>
                                <select class="form-control hr-select2-option emp_required requered" id="c_employee_id" name="employee_id" required>
                                    <option selected disabled value="">@lang('lang.select')</option>
                                    @foreach ($employees as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.number_plate') <span class="text-danger">*</span></label>
                                <input class="form-control emp_required " type="text" id="number_plate" name="number_plate" value="{{old('number_plate')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">@lang('lang.start_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker emp_required" type="text" id="start_date" name="start_date" value="{{old('employee_name_kh')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label class="">@lang('lang.year_of_manufature') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <select id="product_year" name="product_year"  class="form-control floating select select2-hidden-accessible emp_required" data-select2-id="select2-data-4-f353" tabindex="-1" aria-hidden="true" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.end_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker emp_required" type="text" id="end_date" name="end_date" value="{{old('end_date')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.expiretion_year') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control emp_required" name="expired_year" id="expired_year" required>
                                    {{-- <select id="expired_year" name="expired_year"  class="form-control floating select select2-hidden-accessible" data-select2-id="select2-data-4-f353" tabindex="-1" aria-hidden="true" required>
                                    </select> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.shelt_life') <span class="text-danger">*</span></label>
                                <input class="form-control emp_required" type="Number" id="shelt_life" name="shelt_life" value="{{old('shelt_life')}}" required>
                            </div>
                        </div>
                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.total_gasoline') <span class="text-danger">*</span></label>
                                <input class="form-control emp_required" type="number" id="total_gasoline" name="total_gasoline" value="{{old('total_gasoline')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.total_working_days') <span class="text-danger">*</span></label>
                                <input class="form-control emp_required " type="number" id="total_work_day" name="total_work_day" value="{{old('total_work_day')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.price_engine_oil')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control emp_required " type="number" id="price_engine_oil" required name="price_engine_oil" value="{{old('price_engine_oil')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.price_motor_rentel')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control emp_required" type="number" id="price_motor_rentel" name="price_motor_rentel" value="{{old('price_motor_rentel')}}" required>
                                </div> 
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
                                    <input type="text" class="form-control" id="taplab_rentel" name="taplab_rentel" placeholder="" value="{{old('taplab_rentel')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.taplab_price')</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control" type="number" name="price_taplab_rentel" id="price_taplab_rentel" value="{{old('price_taplab_rentel')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                        <button type="button" class="btn btn-primary" data-btn="1" id="save-print">
                            <span class="btn-text-print">@lang('lang.print')</span>
                            <span id="btn-print-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>