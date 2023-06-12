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
                                    <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon experience-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" class="form-control floating" id="company_name[]" name="company_name[]" value="" required>
                                                <label class="focus-label">Company Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <select class="select" id="employment_type[]" name="employment_type[]">
                                                    <option value="1">Full-Time</option>
                                                    <option value="2">Path-Time</option>
                                                </select>
                                                <label class="focus-label">Employment Type</label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" class="form-control floating" id="position[]" name="position[]" value="" required>
                                                <label class="focus-label">Job Position <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="">
                                                    <input type="text" class="form-control floating datetimepicker" id="start_date_experience[]" name="start_date_experience[]" value="" required>
                                                </div>
                                                <label class="focus-label">Period From <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="">
                                                    <input type="text" class="form-control floating datetimepicker" id="end_date_experience[]" name="end_date_experience[]" value="" required>
                                                </div>
                                                <label class="focus-label">Period To <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" class="form-control floating" id="location[]" name="location[]" value="">
                                                <label class="focus-label">Location</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" id="btn-add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                        <button type="submit" class="btn btn-primary" id="bntExperience">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>