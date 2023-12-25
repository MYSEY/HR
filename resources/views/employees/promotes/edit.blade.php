<div id="promotionModalEdit" class="modal custom-modal fade hr-modal-select2" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.edit_promoted')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/promote/update')}}" method="POST" data-select2-id="select2-data-9-apez" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.position')</label>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.promoted_from')</label>
                                @if (count($empPromoted) > 0)
                                    <input class="form-control" type="text" id="e_posit_id" name="posit_id" value="{{$empPromoted[0]->department_promoted_to}}" readonly="">
                                @else
                                    <input class="form-control" type="text" id="e_posit_id" name="posit_id" value="{{$data->EmployeePosition}}" readonly="">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.promoted_to')<span class="text-danger">*</span></label>
                                <select class="form-control form-select hr-select2-option requered" id="e_position_promoted_to" name="position_promoted_to" required>
                                    <option value="">-- @lang('lang.select') --</option>
                                    @if (count($position)>0)
                                        @foreach ($position as $item)
                                            <option value="{{Helper::getLang() == 'en' ? $item->name_english :  $item->name_khmer}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    

                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.department')</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.promoted_from')</label>
                                <input class="form-control" type="text" id="e_depart_id" name="depart_id" value="{{$data->EmployeeDepartment}}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.promoted_to')<span class="text-danger">*</span></label>
                                <select class="form-control form-select hr-select2-option requered" id="e_department_promoted_to" name="department_promoted_to" required>
                                    <option value="">-- @lang('lang.select')  --</option>
                                    @if (count($department)>0)
                                        @foreach ($department as $item)
                                            <option value="{{Helper::getLang() == 'en' ? $item->name_english: $item->name_khmer}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.promoted_date')<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" id="e_promote_date" name="promote_date" class="form-control datetimepicker" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="id" id="e_promote_id">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                        <button type="submit" class="btn btn-primary submit-btn" id="bntEmpPromote">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>