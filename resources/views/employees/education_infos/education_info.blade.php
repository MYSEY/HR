<div id="education_info" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/employee/education')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-scroll">
                        <div class="row" id="education-container-repeatable-elements">
                            <div class="education-repeatable-element repeatable-element">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">@lang('lang.education_informations') <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="" id="school[]" name="school[]" class="form-control floating" required>
                                                    <label class="focus-label">@lang('lang.institution') <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <select class="form-control" id="field_of_study[]" name="field_of_study[]" value="">
                                                        <option value="">@lang('lang.select_field_of_study')</option>
                                                        @foreach ($optionOfStudy as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name_khmer }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="date" value="" name="start_date[]" class="form-control floating datetimepicker" required>
                                                    </div>
                                                    <label class="focus-label">@lang('lang.starting_date') <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="date" value="" name="end_date[]" class="form-control floating datetimepicker" required>
                                                    </div>
                                                    <label class="focus-label">@lang('lang.complete_date') <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <select class="form-control" id="degree[]"
                                                        name="degree[]" value="">
                                                        <option value="">@lang('lang.select_degree')</option>
                                                        @foreach ($optionDegree as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name_khmer }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="" id="grade[]"
                                                        name="grade[]" class="form-control floating">
                                                    <label class="focus-label">@lang('lang.grade')</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-more">
                        <a class="add-repeatable-element-button" id="btnAddEducation"><i class="fa fa-plus-circle"></i> @lang('lang.add_more')</button>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                        <button type="submit" class="btn btn-primary submit-btn" id="bntEducation">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>