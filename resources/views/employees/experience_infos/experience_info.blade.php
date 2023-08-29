<div id="experience_info" class="modal custom-modal fade" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/employee/experience')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-scroll" id="experienceModal">
                        <div class="row" id="experience-container-repeatable-elements">
                            <div class="card experience-repeatable-element">
                                <div class="card-body">
                                    <h3 class="card-title">@lang('lang.experience_informations') <a href="javascript:void(0);" class="delete-icon experience-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" class="form-control floating" id="company_name[]" name="company_name[]" value="" required>
                                                <label class="focus-label">@lang('lang.company_name') <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <label class="focus-label">@lang('lang.employment_type')</label>
                                                <select class="form-control form-select" id="employment_type[]" name="employment_type[]">
                                                    <option value="1">Full-Time</option>
                                                    <option value="2">Path-Time</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" class="form-control floating" id="position[]" name="position[]" value="" required>
                                                <label class="focus-label">@lang('lang.job_position') <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="">
                                                    <input type="text" class="form-control floating datetimepicker" id="start_date_experience[]" name="start_date_experience[]" value="" required>
                                                </div>
                                                <label class="focus-label">@lang('lang.period_from') <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="">
                                                    <input type="text" class="form-control floating datetimepicker" id="end_date_experience[]" name="end_date_experience[]" value="" required>
                                                </div>
                                                <label class="focus-label">@lang('lang.period_to') <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" class="form-control floating" id="location[]" name="location[]" value="">
                                                <label class="focus-label">@lang('lang.location')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" id="btn-add-experience"><i class="fa fa-plus-circle"></i> @lang('lang.add_more')</a>
                        </div>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                        <button type="submit" class="btn btn-primary submit-btn" id="bntExperience">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>