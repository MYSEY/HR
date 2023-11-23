<div id="family_edit_info_modal" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('employee/children/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-scroll" id="">
                        <div class="row" id="children-container-repeatable-elements">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">@lang('lang.edit_children_informations') <a href="javascript:void(0);" class="delete-icon children-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('lang.name') <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name" id="e_name_children" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <label>@lang('lang.date_of_birth') <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                    <input type="text" value="" name="date_of_birth" id="e_date_of_birth" class="form-control floating datetimepicker" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('lang.gender')</label>
                                                {{-- <input class="form-control" type="text" name="sex" id="e_sex"> --}}
                                                <select class="form-control" id="e_sex" name="sex" value="">
                                                    <option selected disabled value=""> -- @lang('lang.select') --</option>
                                                    @foreach ($optionGender as $item)
                                                        <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <input type="hidden" name="id" id="e_child_id" value="">
                        <input type="hidden" name="employee_id" id="e_employee_id" value="">
                        <button type="submit" class="btn btn-primary submit-btn" id="bntChildren">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>