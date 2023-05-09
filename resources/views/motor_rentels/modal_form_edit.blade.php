<div id="edit_motor_rentel" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Motor rentel</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('motor-rentel/update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Employee</label>
                                <select class="select form-control" id="e_employee_id" name="employee_id" value="{{old('employee_id')}}" required>
                                    {{-- <option value="">select employee</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="">Gasoline price per liter (kh)<span class="text-danger">*</span></label>
                            <input class="form-control @error('gasoline_price_per_liter') is-invalid @enderror" type="number" step="0.00" value="" id="e_gasoline_price_per_liter" required name="gasoline_price_per_liter">
                        </div>
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">Start Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('start_date') is-invalid @enderror" type="text" id="e_start_date" required name="start_date" value="{{old('employee_name_kh')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">End Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('end_date') is-invalid @enderror" type="text" id="e_end_date" required name="end_date" value="{{old('end_date')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label class="">Year of manufature <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <select id="e_product_year" name="product_year"  class="form-control floating select select2-hidden-accessible" data-select2-id="select2-data-4-f353" tabindex="-1" aria-hidden="true">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Expiretion year <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <select id="e_expired_year" name="expired_year"  class="form-control floating select select2-hidden-accessible" >
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Shelt life <span class="text-danger">*</span></label>
                                <input class="form-control @error('shelt_life') is-invalid @enderror" type="Number" id="e_shelt_life" required name="shelt_life" value="{{old('shelt_life')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Number Plate <span class="text-danger">*</span></label>
                                <input class="form-control @error('number_plate') is-invalid @enderror" type="text" id="e_number_plate" required name="number_plate" value="{{old('number_plate')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Total Gasoline <span class="text-danger">*</span></label>
                                <input class="form-control @error('total_gasoline') is-invalid @enderror" type="number" id="e_total_gasoline" required name="total_gasoline" value="{{old('total_gasoline')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Total working days <span class="text-danger">*</span></label>
                                <input class="form-control @error('total_work_day') is-invalid @enderror" type="number" id="e_total_work_day" required name="total_work_day" value="{{old('total_work_day')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Price engine oil ($)<span class="text-danger">*</span></label>
                                <input class="form-control @error('price_engine_oil') is-invalid @enderror" type="number" id="e_price_engine_oil" required name="price_engine_oil" value="{{old('price_engine_oil')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Price motor rentel ($)<span class="text-danger">*</span></label>
                                <input class="form-control @error('price_motor_rentel') is-invalid @enderror" type="number" id="e_price_motor_rentel" required name="price_motor_rentel" value="{{old('price_motor_rentel')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Tax rate (%)<span class="text-danger">*</span></label>
                                <input class="form-control @error('tax_rate') is-invalid @enderror" type="number" id="e_tax_rate" required name="tax_rate" value="{{old('tax_rate')}}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="e_id">
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>