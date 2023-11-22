<div id="edit_staff" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.edit_candidate_cv')</h5>
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
                                <label class="">@lang('lang.last_name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('last_name_kh') is-invalid @enderror" type="text" id="e_last_name_kh" required name="last_name_kh" value="{{old('last_name_kh')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="e_first_name_kh" required name="first_name_kh" value="{{old('first_name')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.last_name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="e_last_name_en" required name="last_name_en" value="{{old('last_name')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.first_name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="e_first_name_en" required name="first_name_en" value="{{old('first_name')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.gender')</label>
                                <select class="form-control select floating" name="gender" id="e_gender">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.current_position')</label>
                                <input class="form-control @error('current_position') is-invalid @enderror" type="text" id="e_current_position" name="current_position" value="{{old('current_position')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.company_name')</label>
                                <input class="form-control @error('companey_name') is-invalid @enderror" type="text" id="e_companey_name" name="companey_name" value="{{old('companey_name')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.current_address')</label>
                                <input class="form-control @error('current_address') is-invalid @enderror" type="text" id="e_current_address" name="current_address" value="{{old('current_address')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.position_applied') <span class="text-danger">*</span></label>
                                <select class="hr-select2-option requered" required name="position_applied" id="e_position_applied">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.location_applied') <span class="text-danger">*</span></label>
                                <select class="hr-select2-option requered" required name="location_applied" id="e_location_applied">
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.received_date') <span class="text-danger">*</span></label>
                                <input class="form-control @error('received_date') is-invalid @enderror" type="date" id="e_received_date" required name="received_date" value="{{old('received_date')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.recruitment_channel')</label>
                                <input class="form-control @error('recruitment_channel') is-invalid @enderror" type="text" id="e_recruitment_channel" name="recruitment_channel" value="{{old('recruitment_channel')}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.contact_number') <span class="text-danger">*</span></label>
                                <input class="form-control @error('contact_number') is-invalid @enderror" type="number" id="e_contact_number" required name="contact_number" value="{{old('contact_number')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('lang.cv')</label>
                                <input class="form-control " type="file" name="cv">
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