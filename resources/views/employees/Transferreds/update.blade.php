<div id="TransferrendModalUdate" class="modal custom-modal fade hr-modal-select2" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.edit_transferrend')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/transferred/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.branch')</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.transferred_from')</label>
                                @if (count($empTranferend)>0)
                                    <input class="form-control" type="text" id="e_branch_id" name="branch_id" value="{{$empTranferend[0]->tranferend_branch_name}}" readonly="">
                                @else
                                    <input class="form-control" type="text" id="e_branch_id" name="branch_id" value="{{$data->EmployeeBranch}}" readonly="">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.transferred_to')<span class="text-danger">*</span></label>
                                <select class="form-control form-select hr-select2-option requered" id="e_tranferend_branch_name" name="tranferend_branch_name" required>
                                    <option value="">--@lang('lang.select')--</option>
                                    @if (count($branch)>0)
                                        @foreach ($branch as $item)
                                            <option value="{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}">{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                        <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.position')</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.transferred_from')</label>
                                @if (count($empTranferend)>0)
                                    <input class="form-control" type="text" id="e_position_id" name="position_id" value="{{$empTranferend[0]->tranferend_position_name}}" readonly="">
                                @else
                                    <input class="form-control" type="text" id="e_position_id" name="position_id" value="{{$data->EmployeePosition}}" readonly="">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.transferred_to')<span class="text-danger">*</span></label>
                                <select class="form-control form-select hr-select2-option requered" id="e_tranferend_position_name" name="tranferend_position_name" required>
                                    <option value="">--@lang('lang.select')--</option>
                                    @if (count($position)>0)
                                        @foreach ($position as $item)
                                            <option value="{{Helper::getLang() == 'en' ? $item->name_english : $item->name_english}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_english}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.transferred_date')</label>
                                <div class="cal-icon">
                                    <input type="text" id="e_date" name="date" class="form-control datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.remark')</label>
                                <textarea class="form-control" rows="2" spellcheck="false" id="e_descrition" name="descrition" style="position: relative;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <input type="hidden" name="id" id="e_transferrend_id">
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