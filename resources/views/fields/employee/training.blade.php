<div class="form-group col-md-12" id="training-container-repeatable-elements">
    @if(!empty($entry->training) && !empty($entry->training))
        @if(count($entry->training))
            @foreach($entry->training as $key => $item)
                <div class="row training-repeatable-element repeatable-element mt-3">
                    <button type="button" class="close training-delete-element delete-element"><span aria-hidden="true">×</span></button>
                    <div class="col-sm-6 col-md-6 mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title[]" value="{{$item->title}}"/>
                    </div>
                    <div class="form-group col-md-6 col-12">    
                        <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">Start Date</span></label>
                        <input type="date" name="start_date[]" class="form-control" value="{{$item->start_date}}">
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">End Date</span></label>
                        <input type="date" name="end_date[]" class="form-control" value="{{$item->end_date}}">
                    </div>
                </div>
            @endforeach
        @else 
            <div class="row training-repeatable-element repeatable-element mt-3">
                <button type="button" class="close training-delete-element delete-element"><span aria-hidden="true">×</span></button>
                <div class="col-sm-6 col-md-6 mb-3">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title[]"/>
                </div>
                <div class="form-group col-md-6 col-12">    
                    <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">Start Date</span></label>
                    <input type="date" name="start_date[]" class="form-control">
                </div>
                <div class="form-group col-md-6 col-12">    
                    <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">End Date</span></label>
                    <input type="date" name="end_date[]" class="form-control">
                </div>
            </div>
        @endif
    @else 
        <div class="row training-repeatable-element repeatable-element mt-3">
            <button type="button" class="close training-delete-element delete-element"><span aria-hidden="true">×</span></button>
            <div class="col-sm-6 col-md-6 mb-3">
                <label>Title</label>
                <input type="text" class="form-control" name="title[]"/>
            </div>
            <div class="form-group col-md-6 col-12">    
                <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">Start Date</span></label>
                <input type="date" name="start_date[]" class="form-control">
            </div>
            <div class="form-group col-md-6 col-12">    
                <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">End Date</span></label>
                <input type="date" name="end_date[]" class="form-control">
            </div>
        </div>
    @endif
</div>
<div class="form-group col-md-12">
    <button type="button" class="btn btn-success btn-sm ml-1 add-repeatable-element-button" id="training-add-repeatable-element-button">+ Add New</button>
</div>

@push('after_styles')
    <style>
        .label-required { color:#ff0000; }
        .no-error-border { border-color: #d2d6de !important; }
        .no-error-label { color: #333 !important; }
        .repeatable-element{padding: 10px;border: 1px solid rgba(0,40,100,.12);border-radius: 5px;background-color: #f0f3f94f;margin-right: 0px;margin-left: 0;}
        .delete-element{z-index: 2; position: absolute !important; margin-left: -25px; margin-top: 0px; height: 30px; width: 30px; border-radius: 15px; text-align: center; background-color: #e8ebf0 !important;}
    </style>
@endpush


@push('after_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(function(){
            $('body').on('click', '#training-add-repeatable-element-button', function(){
                $('.training-repeatable-element:first').clone().appendTo('#training-container-repeatable-elements');
                var lastRepeatableElement = $('.training-repeatable-element:last');
                var input = lastRepeatableElement.find('input');
                var textarea = lastRepeatableElement.find('textarea');
                var select = lastRepeatableElement.find('select');
                input.val('');
                textarea.val('');
                select.prop('selectedIndex',0)
            });
            $('body').on('click', '.training-delete-element', function(){
                if($('.training-repeatable-element').length > 1){
                    $(this).closest('.training-repeatable-element').remove();
                }
            });
        });
    </script>
@endpush