<div id="edit_training" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.edit_training_list')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('training/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.training_type') <span class="text-danger">*</span></label>
                                <select class="select form-control" id="e_training_type" name="training_type" required value="{{old('training_type')}}">
                                    {{-- <option value="">Select type</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.course_name') <span class="text-danger">*</span></label>
                                <input class="form-control @error('course_name') is-invalid @enderror" type="text" name="course_name" id="e_course_name" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.trainer') <span class="text-danger">*</span></label>
                                <select class="select form-control" id="e_trainer" multiple="" name="trainer_id[]" required value="{{old('trainer')}}">
                                    {{-- <option value="">Select trainer</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.employees') <span class="text-danger">*</span></label>
                                <select class="select form-control" id="e_employee" multiple="" name="employee_id[]" required value="{{old('employee')}}">
                                    {{-- <option value="">Select employee</option> --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.start_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('start_date') is-invalid @enderror" type="text" required id="e_start_date" name="start_date" value="{{old('start_date')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.end_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('end_date') is-invalid @enderror" type="text" required id="e_end_date" name="end_date" value="{{old('end_date')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.course_fee')</label>
                                <input class="form-control @error('cost_price') is-invalid @enderror" type="number" id="e_cost_price" name="cost_price">
                            </div>
                        </div>
                        <div class="col-sm-6 hidden" id="e_inp_contract">
                            <div class="form-group">
                                <label class="">@lang('lang.contract')</label>
                                <select class="select form-control" id="e_status" name="status">
                                    <option selected value="0">@lang('lang.no')</option>
                                    <option value="1">@lang('lang.yes')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 hidden" id="e_inp_discount">
                            <div class="form-group">
                                <label>@lang('lang.discount')</label>
                                <input class="form-control " type="number"  name="discount" id="e_discount" value="{{old('discount')}}">
                            </div>
                        </div>

                        <div class="col-sm-6 hidden" id="e_inp_duration">
                            <div class="form-group">
                                <label>@lang('lang.duration') (@lang('lang.month')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('duration_month') is-invalid @enderror" type="number"  name="duration_month" id="e_duration" value="{{old('duration_month')}}">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="">@lang('lang.remark')</label>
                                <textarea type="text" rows="3" class="form-control" name="remark" id="e_remark" value="{{old('remark')}}"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="e_id">
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-bs-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>