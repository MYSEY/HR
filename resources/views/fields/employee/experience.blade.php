<div class="card-body">
    <form>
        <div class="row">
            <div class="form-group col-md-12" id="experience-container-repeatable-elements">
                @if (!empty($entry->experiences) && !empty($entry->experiences))
                    @if (count($entry->experiences))
                        @foreach ($entry->experiences as $key => $experience)
                            <div class="row experience-repeatable-element repeatable-element mt-3">
                                <button type="button" class="close experience-delete-element delete-element"><span
                                        aria-hidden="true">×</span></button>
                                <div class="col-sm-6 col-md-6 mb-3">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title[]"
                                        value="{{ $experience->title }}" />
                                </div>
                                <div class="col-sm-6 col-md-6 mb-3">
                                    <label>Employment Type</label>
                                    <select name="employment_type[]" class="form-control employment-type">
                                        <option value="" disabled selected>select employment type</option>
                                        <?php
                                        $employmentType = \App\Models\Option::find($experience->employment_type);
                                        ?>
                                        @if (!empty($employmentType))
                                            <option value="{{ $experience->employment_type }}" selected>
                                                {{ $employmentType->name_khmer }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-6 mb-3">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company_name[]"
                                        value="{{ $experience->company_name }}" />
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">Start
                                            Date</span></label>
                                    <input type="date" name="start_date[]" class="form-control"
                                        value="{{ $experience->start_date }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">End
                                            Date</span></label>
                                    <input type="date" name="end_date[]" class="form-control"
                                        value="{{ $experience->end_date }}">
                                </div>
                                <div class="col-sm-6 col-md-6 mb-3">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="location[]"
                                        value="{{ $experience->location }}" />
                                </div>
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" name="description[]">{{ $experience->description }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row experience-repeatable-element repeatable-element mt-3">
                            <button type="button" class="close experience-delete-element delete-element"><span
                                    aria-hidden="true">×</span></button>
                            <div class="col-sm-6 col-md-6 mb-3">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title[]" />
                            </div>
                            <div class="col-sm-6 col-md-6 mb-3">
                                <label>Employment Type</label>
                                <select name="employment_type[]" class="form-control employment-type">
                                    <option value="" disabled selected>select employment type</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-6 mb-3">
                                <label>Company Name</label>
                                <input type="text" class="form-control" name="company_name[]" />
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">Start
                                        Date</span></label>
                                <input type="date" name="start_date[]" class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">End
                                        Date</span></label>
                                <input type="date" name="end_date[]" class="form-control">
                            </div>
                            <div class="col-sm-6 col-md-6 mb-3">
                                <label>Location</label>
                                <input type="text" class="form-control" name="location[]" />
                            </div>
                            <div class="col-sm-12 col-md-12 mb-3">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="description[]"></textarea>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- <div class="row experience-repeatable-element repeatable-element mt-3">
                        <button type="button" class="close experience-delete-element delete-element"><span aria-hidden="true">×</span></button>
                        <div class="col-sm-6 col-md-6 mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title[]"/>
                        </div>
                        <div class="col-sm-6 col-md-6 mb-3">
                            <label>Employment Type</label>
                            <select name="employment_type[]" class="form-control employment-type">
                                <option value="" disabled selected>select employment type</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-6 mb-3">
                            <label>Company Name</label>
                            <input type="text" class="form-control" name="company_name[]"/>
                        </div>
                        <div class="form-group col-md-6 col-12">    
                            <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">Start Date</span></label>
                            <input type="date" name="start_date[]" class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-12">    
                            <label><span data-toggle="tooltip" data-placement="top" title="Tooltip on top">End Date</span></label>
                            <input type="date" name="end_date[]" class="form-control">
                        </div>
                        <div class="col-sm-6 col-md-6 mb-3">
                            <label>Location</label>
                            <input type="text" class="form-control" name="location[]"/>
                        </div>
                        <div class="col-sm-12 col-md-12 mb-3">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" name="description[]"></textarea>
                        </div>
                    </div> --}}
                    <form>
                        <div class="form-scroll">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
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
                                    <div class="add-more">
                                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </form>
</div>

@push('after_styles')
    <style>
        .label-required {
            color: #ff0000;
        }

        .no-error-border {
            border-color: #d2d6de !important;
        }

        .no-error-label {
            color: #333 !important;
        }

        .repeatable-element {
            padding: 10px;
            border: 1px solid rgba(0, 40, 100, .12);
            border-radius: 5px;
            background-color: #f0f3f94f;
            margin-right: 0px;
            margin-left: 0;
        }

        .delete-element {
            z-index: 2;
            position: absolute !important;
            margin-left: -25px;
            margin-top: 0px;
            height: 30px;
            width: 30px;
            border-radius: 15px;
            text-align: center;
            background-color: #e8ebf0 !important;
        }
    </style>
@endpush


@push('after_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(function() {
            var fetchEmploymentType = function() {
                axios.get('{{ URL('experience') }}', {
                    params: {
                        employment_type: 'experience'
                    }
                }).then(function(response) {
                    var object = response.data;
                    $('.employment-type').each(function(index) {
                        $.each(object, function(ind, row) {
                            if ($('.employment-type:eq(' + index + ') option[value="' +
                                    row.id + '"]').length == 0) {
                                var option = '<option value="' + row.id + '">' + row
                                    .name_khmer + '</option>';
                                $('.employment-type').eq(index).append(option);
                            }
                        });
                    });
                })
            };
            $('body').on('click', '#experience-add-repeatable-element-button', function() {
                $('.experience-repeatable-element:first').clone().appendTo(
                    '#experience-container-repeatable-elements');
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
            fetchEmploymentType();
        });
    </script>
@endpush
