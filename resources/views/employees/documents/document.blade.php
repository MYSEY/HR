<div class="tab-pane fade" id="document" role="tabpanel">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="project-title"><a href="">Guarantee Letter</a></h4>
                    <small class="block text-ellipsis m-b-15">
                        <span class="text-xs">Preview guarantee letter click this <a href="{{ url('uploads/images/', $data->guarantee_letter) }}" target="_blank">link</a></span>
                    </small>
                    <embed src="{{url('uploads/images/', $data->guarantee_letter)}}" style="width:100%; height:100%;">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="project-title"><a href="">Employment Book</a></h4>
                    @if ($data->employment_book !=null)
                        <small class="block text-ellipsis m-b-15">
                            <span class="text-xs">Preview employment book click this <a href="{{ url('uploads/images/', $data->employment_book) }}" target="_blank">link</a></span>
                        </small>
                        <embed src="{{url('uploads/images/', $data->employment_book)}}" style="width:100%; height:100%;">
                    @else
                        <span class="text-xs">Preview employment book not found</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>