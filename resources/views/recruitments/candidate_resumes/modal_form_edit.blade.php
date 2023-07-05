<div id="edit_staff" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Candidate Resume</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('recruitment/candidate-resume/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <input hidden  type="text" name="id" id="e_id">
                    <input hidden  type="text" name="status" id="status">
                    <input hidden type="text" name="hidden_cv" id="hidden_cv">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">Name (KH) <span class="text-danger">*</span></label>
                                <input class="form-control @error('name_kh') is-invalid @enderror" type="text" id="e_name_kh" required name="name_kh" value="{{old('name_kh')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Name (EN) <span class="text-danger">*</span></label>
                                <input class="form-control @error('name_en') is-invalid @enderror" type="text" id="e_name_en" required name="name_en" value="{{old('name_en')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">Gender</label>
                                <select class="form-control form-select" name="gender" id="e_gender">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Current Position</label>
                                <input class="form-control @error('current_position') is-invalid @enderror" type="text" id="e_current_position" name="current_position" value="{{old('current_position')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input class="form-control @error('companey_name') is-invalid @enderror" type="text" id="e_companey_name" name="companey_name" value="{{old('companey_name')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Current Address</label>
                                <input class="form-control @error('current_address') is-invalid @enderror" type="text" id="e_current_address" name="current_address" value="{{old('current_address')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Position Applied <span class="text-danger">*</span></label>
                                <select class="form-control form-select" required name="position_applied" id="e_position_applied">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location Applied <span class="text-danger">*</span></label>
                                <select class="form-control form-select" required name="location_applied" id="e_location_applied">
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Received Date <span class="text-danger">*</span></label>
                                <input class="form-control @error('received_date') is-invalid @enderror" type="date" id="e_received_date" required name="received_date" value="{{old('received_date')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Recruitment Channel</label>
                                <input class="form-control @error('recruitment_channel') is-invalid @enderror" type="text" id="e_recruitment_channel" name="recruitment_channel" value="{{old('recruitment_channel')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contact number <span class="text-danger">*</span></label>
                                <input class="form-control @error('contact_number') is-invalid @enderror" type="number" id="e_contact_number" required name="contact_number" value="{{old('contact_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>CV</label>
                                <input class="form-control " type="file" name="cv">
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                            <span class="btn-txt">{{ __('Submit') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>