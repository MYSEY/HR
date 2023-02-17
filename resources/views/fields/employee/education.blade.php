<!-- field_type_name -->
<div class="card-body">
    <form action="/employee" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row" id="education-container-repeatable-elements">
            <div class="form-scroll education-repeatable-element repeatable-element">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o"></i></a></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-focus focused">
                                    <input type="text" value="" name="school[]" class="form-control floating">
                                    <label class="focus-label">Institution</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus focused">
                                    <input type="text" value="" name="field_of_study[]" class="form-control floating">
                                    <label class="focus-label">Subject</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus focused">
                                    <div class="cal-icon">
                                        <input type="text" value="" name="start_date[]" class="form-control floating datetimepicker">
                                    </div>
                                    <label class="focus-label">Starting Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus focused">
                                    <div class="cal-icon">
                                        <input type="text" value="" name="end_date[]" class="form-control floating datetimepicker">
                                    </div>
                                    <label class="focus-label">Complete Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus focused">
                                    <input type="text" value="" name="degree[]" class="form-control floating">
                                    <label class="focus-label">Degree</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus focused">
                                    <input type="text" value="" name="degree[]" class="form-control floating">
                                    <label class="focus-label">Grade</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-more">
            <a class="add-repeatable-element-button" id="btnAddEducation"><i class="fa fa-plus-circle"></i> Add More</button>
        </div>
        <div class="submit-section form-group" style="text-align: right;">
            <button class="btn btn-primary submit-btn">Submit</button>
        </div>
    </form>
</div>

@include('includs.index')
<script>
    $(function() {
        // var fetchDegree = function() {
        //     axios.get('{{ URL('education') }}', {
        //         params: {
        //             degree: 'degree'
        //         }
        //     }).then(function(response) {
        //         var object = response.data;
        //         $('.degree').each(function(index) {
        //             $.each(object, function(ind, row) {
        //                 if ($('.degree:eq(' + index + ') option[value="' + row.id +
        //                         '"]').length == 0) {
        //                     var option = '<option value="' + row.id + '">' + row
        //                         .name_khmer + '</option>';
        //                     $('.degree').eq(index).append(option);
        //                 }
        //             });
        //         });
        //     })
        // };
        // var fetchFieldOfStudy = function() {
        //     axios.get('{{ URL('education') }}', {
        //         params: {
        //             field_of_study: 'field_of_study'
        //         }
        //     }).then(function(response) {
        //         var object = response.data;
        //         $('.field-of-study').each(function(index) {
        //             $.each(object, function(ind, row) {
        //                 if ($('.field-of-study:eq(' + index + ') option[value="' +
        //                         row.id + '"]').length == 0) {
        //                     var option = '<option value="' + row.id + '">' + row
        //                         .name_khmer + '</option>';
        //                     $('.field-of-study').eq(index).append(option);
        //                 }
        //             });
        //         });
        //     })
        // };
        $('body').on('click', '#btnAddEducation', function() {
            $('.education-repeatable-element:first').clone().appendTo('#education-container-repeatable-elements');
            var lastRepeatableElement = $('.education-repeatable-element:last');
            var input = lastRepeatableElement.find('input');
            var textarea = lastRepeatableElement.find('textarea');
            var select = lastRepeatableElement.find('select');
            input.val('');
            textarea.val('');
            select.prop('selectedIndex', 0)
        });
        $('body').on('click', '.education-delete-element', function() {
            if ($('.education-repeatable-element').length > 1) {
                $(this).closest('.education-repeatable-element').remove();
            }
        });
        // fetchDegree();
        // fetchFieldOfStudy();
    });
</script>