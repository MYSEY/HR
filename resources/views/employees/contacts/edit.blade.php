<div id="emergency_contact_modal_update" class="modal custom-modal fade" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.emergency_contact')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('employee/contact/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="e_name" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.relationship') <span class="text-danger">*</span></label>
                                <select class="form-control @error('relationship') is-invalid @enderror" id="e_relationship" name="relationship" value="{{old('relationship')}}" required>
                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                    @foreach ($relationship as $item)
                                        <option value="{{ $item->id }}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.phone') <span class="text-danger">*</span></label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="number" id="e_phone" name="phone" value="{{old('phone')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.phone') 2</label>
                                <input class="form-control" type="number" id="e_phone_2" name="phone_2">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="id" id="e_contact_id" value="">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                        <button class="btn btn-primary submit-btn">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>