<div class="card-body">
    <div class="row" id="experience-container-repeatable-elements">
        <div class="form-scroll experience-repeatable-element">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon experience-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus focused">
                                <input type="text" class="form-control floating" id="title[]" name="title[]" value="">
                                <label class="focus-label">Title</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus focused">
                                <input type="text" class="form-control floating" id="company_name[]" name="company_name[]" value="">
                                <label class="focus-label">Company Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus focused">
                                <select class="select" id="employment_type[]" name="employment_type[]">
                                    <option value="1">Full-Time</option>
                                    <option value="2">Path-Time</option>
                                </select>
                                <label class="focus-label">Employment Type</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group form-focus focused">
                                <input type="text" class="form-control floating" value="">
                                <label class="focus-label">Job Position</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus focused">
                                <div class="">
                                    <input type="text" class="form-control floating datetimepicker" id="start_date[]" name="start_date[]" value="">
                                </div>
                                <label class="focus-label">Period From</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus focused">
                                <div class="">
                                    <input type="text" class="form-control floating datetimepicker" id="end_date[]" id="end_date[]" value="">
                                </div>
                                <label class="focus-label">Period To</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus focused">
                                <input type="text" class="form-control floating" value="">
                                <label class="focus-label">Location</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="add-more">
        <a href="javascript:void(0);" id="btn-add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
    </div>
    <div class="submit-section">
        <button class="btn btn-primary submit-btn">Submit</button>
    </div>
</div>
@include('includs.index')
<script>
    $(function() {
        // var fetchEmploymentType = function() {
        //     axios.get('{{ URL('experience') }}', {
        //         params: {
        //             employment_type: 'experience'
        //         }
        //     }).then(function(response) {
        //         var object = response.data;
        //         $('.employment-type').each(function(index) {
        //             $.each(object, function(ind, row) {
        //                 if ($('.employment-type:eq(' + index + ') option[value="' +
        //                         row.id + '"]').length == 0) {
        //                     var option = '<option value="' + row.id + '">' + row
        //                         .name_khmer + '</option>';
        //                     $('.employment-type').eq(index).append(option);
        //                 }
        //             });
        //         });
        //     })
        // };
        $('body').on('click', '#btn-add-experience', function() {
            $('.experience-repeatable-element:first').clone().appendTo('#experience-container-repeatable-elements');
            var lastRepeatableElement = $('.experience-repeatable-element:last');
            var input = lastRepeatableElement.find('input');
            var textarea = lastRepeatableElement.find('textarea');
            var select = lastRepeatableElement.find('select');
            input.val('');
            textarea.val('');
            select.prop('selectedIndex', 0)
        });
        $('body').on('click', '.experience-delete-element', function() {
            if ($('.experience-repeatable-element').length > 1) {
                $(this).closest('.experience-repeatable-element').remove();
            }
        });
        // fetchEmploymentType();
    });
</script>