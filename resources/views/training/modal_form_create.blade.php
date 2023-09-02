<div id="add_training" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.add_new_training')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('training/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.training_type') <span class="text-danger">*</span></label>
                                <select class="form-control" name="training_type" id="training_type" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.course_name') <span class="text-danger">*</span></label>
                                <input class="form-control @error('course_name') is-invalid @enderror" type="text" name="course_name" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.trainer') <span class="text-danger">*</span></label>
                                <select class="form-control select" multiple="" name="trainer_id[]" id="trainer" required>
                                    <option selected disabled value="">@lang('lang.select') ...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.employees') <span class="text-danger">*</span></label>
                                <select class="select form-control" multiple="" name="employee_id[]" required>
                                    @foreach ($employee as $item)
                                        <option value="{{$item->id}}">{{$item->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.start_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('start_date') is-invalid @enderror" type="text" required id="start_date" name="start_date" value="{{old('start_date')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.end_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker @error('end_date') is-invalid @enderror" type="text" required id="end_date" name="end_date" value="{{old('end_date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.course_fee')</label>
                                <input class="form-control @error('cost_price') is-invalid @enderror" type="number" name="cost_price">
                            </div>
                        </div>
                        <div class="col-sm-6 hidden" id="inp_contract">
                            <div class="form-group">
                                <label class="">@lang('lang.contract')</label>
                                <select class="select form-control" id="status" name="status">
                                    <option selected value="0">@lang('lang.no')</option>
                                    <option value="1">@lang('lang.yes')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 hidden" id="inp_discount">
                            <div class="form-group">
                                <label>@lang('lang.discount')</label>
                                <input class="form-control " type="number"  name="discount" id="discount" value="{{old('discount')}}">
                            </div>
                        </div>

                        <div class="col-sm-6 hidden" id="inp_duration">
                            <div class="form-group">
                                <label>@lang('lang.duration') (@lang('lang.month')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('duration_month') is-invalid @enderror" type="number"  name="duration_month" id="duration" value="{{old('duration_month')}}">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="">@lang('lang.remark')</label>
                                <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>