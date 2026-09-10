<div class="tab-pane fade" id="document" role="tabpanel">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="project-title"><a href="">@lang('lang.guarantee_letter')</a></h4>
                    <small class="block text-ellipsis m-b-15">
                        <span class="text-xs">@lang('lang.preview_guarantee_letter_click_here') <a href="{{ url('uploads/images/', $data->guarantee_letter) }}" target="_blank">link</a></span>
                    </small>
                    <embed src="{{url('uploads/images/', $data->guarantee_letter)}}" style="width:100%; height:100%;">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="project-title"><a href="">@lang('lang.employment_book')</a></h4>
                    @if ($data->employment_book !=null)
                        <small class="block text-ellipsis m-b-15">
                            <span class="text-xs">@lang('lang.preview_employment_book_click_here') <a href="{{ url('uploads/images/', $data->employment_book) }}" target="_blank">link</a></span>
                        </small>
                        <embed src="{{url('uploads/images/', $data->employment_book)}}" style="width:100%; height:100%;">
                    @else
                        <span class="text-xs">@lang('lang.preview_employment_book_not_found')</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>