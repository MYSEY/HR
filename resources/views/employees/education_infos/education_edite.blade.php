<div id="education_edite" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/employee/education/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-scroll">
                        <div class="row" id="education-container-repeatable-elements">
                            <div class="education-repeatable-element repeatable-element">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">@lang('lang.education_informations') <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="focus-label">@lang('lang.institution')<span class="text-danger">*</span></label>
                                                    <input type="text" value="" id="e_school" name="school" class="form-control floating" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang('lang.field_of_study')</label>
                                                    <select class="form-control" id="e_field_of_study" name="field_of_study" value="">
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang('lang.degree')</label>
                                                    <select class="form-control" id="e_degree" name="degree" value="">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="focus-label">@lang('lang.grade')</label>
                                                    <input type="text" value="" id="e_grade" name="grade" class="form-control floating">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="focus-label">@lang('lang.starting_date')<span class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="date" value="" name="start_date" id="e_start_date" class="form-control floating datetimepicker" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="focus-label">@lang('lang.complete_date')<span class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="date" value="" name="end_date" id="e_end_date" class="form-control floating datetimepicker" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-more">
                        <a class="add-repeatable-element-button" id="btnAddEducation"><i class="fa fa-plus-circle"></i> @lang('lang.add_more')</a>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="employee_id" id="e_edu_employee_id" value="">
                        <input type="hidden" name="id" id="e_education_id">
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