<div id="experience_edite" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{url('/employee/experience/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-scroll">
                        <div class="row" id="experience-container-repeatable-elements">
                            <div class="card experience-repeatable-element">
                                <div class="card-body">
                                    <h3 class="card-title">@lang('lang.experience_informations') <a href="javascript:void(0);" class="delete-icon experience-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('lang.company_name')<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" id="e_company_name" name="company_name" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('lang.employment_type')</label>
                                                <select class="form-control form-select" id="e_employment_type" name="employment_type">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('lang.job_position')<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" id="e_position" name="position" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('lang.period_from')<span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input type="date" class="form-control floating datetimepicker" id="e_start_date_experience" name="start_date_experience" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('lang.period_to')<span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input type="date" class="form-control floating datetimepicker" id="e_end_date_experience" name="end_date_experience" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">@lang('lang.location')</label>
                                                <textarea type="text" rows="2" class="form-control" name="location" id="e_location" value=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a class="add-repeatable-element-button" id="btn-add-experience"><i class="fa fa-plus-circle"></i> @lang('lang.add_more')</a>
                        </div>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="id" id="e_experience_id" value="">
                        <input type="hidden" name="employee_id" id="e_ex_employee_id" value="">
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