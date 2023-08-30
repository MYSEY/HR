<div class="tab-pane fade" id="promote" role="tabpanel">
    <div class="col-md-12 d-flex">
        <div class="card profile-box flex-fill">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.promoted') <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#PromotionModal"><i class="fa fa-pencil"></i></a></h3>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.department_from')</th>
                                <th>@lang('lang.department_to')</th>
                                <th>@lang('lang.position_from')</th>
                                <th>@lang('lang.position_to')</th>
                                <th>@lang('lang.promoted_date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($empPromoted)>0)
                                @foreach ($empPromoted as $item)   
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->depart_id}}</td>
                                        <td style="color:#26AF49">
                                            {{$item->department_promoted_to}}
                                        </td>
                                        <td>{{$item->posit_id}}</td>
                                        <td style="color:#26AF49">{{$item->position_promoted_to}}</td>
                                        <td>{{$item->PormotDate}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="7" style="text-align: center">@lang('lang.no_record_to_display')</td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="PromotionModal" class="modal custom-modal fade hr-modal-select2" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/employee/promote')}}" method="POST" data-select2-id="select2-data-9-apez" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.position')</label>
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('lang.promoted_from')</label>
                            @if (count($empPromoted) > 0)
                                <input class="form-control" type="text" id="posit_id" name="posit_id" value="{{$empPromoted[0]->department_promoted_to}}" readonly="">
                            @else
                                <input class="form-control" type="text" id="posit_id" name="posit_id" value="{{$data->EmployeePosition}}" readonly="">
                            @endif
                        </div>
                        <div class="form-group hr-form-group-select2">
                            <label>@lang('lang.promoted_to') <span class="text-danger">*</span></label>
                            <select class="form-control form-select hr-select2-option requered" id="position_promoted_to" name="position_promoted_to" required>
                                <option value="">-- @lang('lang.select') --</option>
                                @if (count($position)>0)
                                    @foreach ($position as $item)
                                        <option value="{{session()->get('locale') == 'en' ? $item->name_english :  $item->name_khmer}}">{{session()->get('locale') == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-12 col-12" element="div" bp-field-wrapper="true" bp-field-name="Identity" bp-field-type="custom_html">
                            <label class="navbar-brand custom-navbar-brand mb-0" style="width: 100%; background: #dfe6e9; padding: 6px;font-size: 15px;font-weight: normal !important;">@lang('lang.department')</label>
                        </div>
                        <div class="form-group">
                            <label>@lang('lang.promoted_from')</label>
                            <input class="form-control" type="text" id="depart_id" name="depart_id" value="{{$data->EmployeeDepartment}}" readonly="">
                        </div>
                        <div class="form-group hr-form-group-select2">
                            <label>@lang('lang.promoted_to') <span class="text-danger">*</span></label>
                            <select class="form-control form-select hr-select2-option requered" id="department_promoted_to" name="department_promoted_to" required>
                                <option value="">-- @lang('lang.select')  --</option>
                                @if (count($department)>0)
                                    @foreach ($department as $item)
                                        <option value="{{session()->get('locale') == 'en' ? $item->name_english: $item->name_khmer}}">{{session()->get('locale') == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('lang.promoted_date') <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" id="promote_date" name="promote_date" class="form-control datetimepicker" required>
                            </div>
                        </div>
                        <div class="submit-section">
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
</div>
<script src="{{asset('/admin/js/validation-field.js')}}"></script>