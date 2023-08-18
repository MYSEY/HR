<div id="add_motor_rentel" class="modal custom-modal fade hr-modal-select2" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Rental</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('motor-rentel/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Moto Rentals</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group hr-form-group-select2">
                                <label>Employee</label>
                                <select class="form-control hr-select2-option requered" id="employee_id" name="employee_id" value="{{old('employee_id')}}" required>
                                    <option selected disabled value="">Select employee...</option>
                                    @foreach ($employees as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Number Plate <span class="text-danger">*</span></label>
                                <input class="form-control @error('number_plate') is-invalid @enderror" type="text" id="number_plate" required name="number_plate" value="{{old('number_plate')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">Start Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('start_date') is-invalid @enderror" type="text" id="start_date" required name="start_date" value="{{old('employee_name_kh')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">End Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('end_date') is-invalid @enderror" type="text" id="end_date" required name="end_date" value="{{old('end_date')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label class="">Year of manufature <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <select id="product_year" name="product_year"  class="form-control floating select select2-hidden-accessible" data-select2-id="select2-data-4-f353" tabindex="-1" aria-hidden="true" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Expiretion year <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <select id="expired_year" name="expired_year"  class="form-control floating select select2-hidden-accessible" data-select2-id="select2-data-4-f353" tabindex="-1" aria-hidden="true" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Shelt life <span class="text-danger">*</span></label>
                                <input class="form-control @error('shelt_life') is-invalid @enderror" type="Number" id="shelt_life" required name="shelt_life" value="{{old('shelt_life')}}">
                            </div>
                        </div>
                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Total Gasoline <span class="text-danger">*</span></label>
                                <input class="form-control @error('total_gasoline') is-invalid @enderror" type="number" id="total_gasoline" required name="total_gasoline" value="{{old('total_gasoline')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Total working days <span class="text-danger">*</span></label>
                                <input class="form-control @error('total_work_day') is-invalid @enderror" type="number" id="total_work_day" required name="total_work_day" value="{{old('total_work_day')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Price engine oil<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control @error('price_engine_oil') is-invalid @enderror" type="number" id="price_engine_oil" required name="price_engine_oil" value="{{old('price_engine_oil')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Price motor rentel<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control @error('price_motor_rentel') is-invalid @enderror" type="number" id="price_motor_rentel" required name="price_motor_rentel" value="{{old('price_motor_rentel')}}">
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">Taplabs</label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Taplab</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="taplab_rentel" name="taplab_rentel" placeholder="" value="{{old('taplab_rentel')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Taplab Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input class="form-control" type="number" name="price_taplab_rentel" id="price_taplab_rentel" value="{{old('price_taplab_rentel')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            {{-- Submit --}}
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                            <span class="btn-txt">{{ __('Submit') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>