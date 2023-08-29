<div class="tab-pane fade" id="training" role="tabpanel">
    <div class="col-md-12 d-flex">
        <div class="card profile-box flex-fill">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.training') <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#TrainingModal"><i class="fa fa-pencil"></i></a></h3>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.course_name')</th>
                                <th>@lang('lang.start_date')</th>
                                <th>@lang('lang.end_date')</th>
                                <th>@lang('lang.remark')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($training)>0)
                                @foreach ($training as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->TrainingStartDate}}</td>
                                        <td>{{$item->TrainingStartEndDate}}</td>
                                        <td>{{$item->descrition}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="5" style="text-align: center">@lang('lang.no_record_to_display')</td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="TrainingModal" class="modal custom-modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/employee/training')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label>@lang('lang.course_name') <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('lang.start_date') <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" id="start_date" name="start_date" class="form-control datetimepicker" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('lang.end_date') <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" id="end_date" name="end_date" class="form-control datetimepicker" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('lang.remark')</label>
                            <textarea class="form-control" rows="4" spellcheck="false" id="descrition" name="descrition" style="position: relative;"></textarea>
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