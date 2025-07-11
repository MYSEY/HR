@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.performance')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.performance')</li>
                </ul>
            </div>
        </div>
    </div>
    {!! Toastr::message() !!}
    <div class="card">
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-4 hr-form-group-select2">
                        <div class="form-group">
                            <label>@lang('lang.employee')</label>
                            <select class="elect form-control hr-select2-option required" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" multiple>
                                <option value=""> -- @lang('lang.select')--</option>
                                @foreach ($employee as $item)
                                    <option data-id="{{ $item->id }}" value="{{ $item->id }}">
                                        {{ Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('lang.from_date')</label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker required" type="text" id="from_date" name="from_date" value="{{old('from_date')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('lang.to_date')</label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker required" type="text" id="to_date" name="to_date" value="{{old('to_date')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tbl_performance" class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 350px;">(KPI)</th>
                                        <th style="min-width: 350px;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
                                        <th style="min-width: 350px;">គោលដៅ (Goal)</th>
                                        <th style="min-width: 150px;">ទម្ងន់ (Weight %)</th>
                                        <th style="min-width: 150px;">Is Lock</th>
                                        <th>@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div>
                                        <tr class="title-group">
                                            <td colspan="2" class="text-center">
                                                <input type="text" class="form-control required" id="title" name="title[]" placeholder="កត្តាប្រតិបត្តិការ (%)" value="{{old('title')}}">
                                            </td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                        <div>
                                            <tr class="purpose-group">
                                                <td colspan="2" class="text-center">
                                                    <input type="text" class="form-control required" id="purpose" name="purpose[]" placeholder="គោលបំណង" value="{{old('purpose')}}">
                                                </td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center">
                                                    <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i> Add Purpose</button>
                                                </td>
                                            </tr>
                                            <div>
                                                <tr class="kpi-group">
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
                                                    </td>
                                                    {{-- <td class="text-center">
                                                        <textarea rows="3" class="form-control required" name="goal[]" placeholder="Enter text here" spellcheck="false">{{ old('goal') }}</textarea>
                                                    </td> --}}

                                                    <td class="text-center">
                                                        <select class="form-control goal-type-select" name="goal_type[]">
                                                            <option value="number">Number</option>
                                                            <option value="date">Date</option>
                                                            <option value="currency">Currency</option>
                                                            <option value="percent">Percent</option>
                                                        </select>
                                                        <div class="goal-input-wrapper mt-1">
                                                            <textarea class="form-control required" name="goal[]" rows="3" placeholder="e.g.&#10;60 70&#10;70 80&#10;90 100"></textarea>
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        <input type="number" step="any" class="form-control required" name="weight[]" id="weight" placeholder="%" value="{{old('weight')}}">
                                                    </td>
                                                    <td class="text-center">
                                                        <select class="form-control" name="is_lock[]" id="is_lock" required>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center">
                                            <div class="add-more">
                                                <a class="add-repeatable-element-button addMore"><i class="fa fa-plus-circle"></i> Add More</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="submit-section mb-2">
                    <button type="submit" class="btn btn-primary" id="btnCreatePerformance">
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                            @lang('lang.loading') </span>
                        <span class="btn-txt">@lang('lang.submit')</span>
                    </button>
                    <a href="{{ url('performance') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        let dataKeyKpi = [];
        $(document).on('change', '.goal-type-select', function () {
            const selectedType = $(this).val();
            const wrapper = $(this).closest('td').find('.goal-input-wrapper');

            let placeholder = "e.g.\n60 70\n70 80\n90 100";
            if (selectedType === 'date') {
                placeholder = "e.g.\n2025-01-01 2025-06-01\n2025-06-02 2025-12-31";
            } else if (selectedType === 'currency') {
                placeholder = "e.g.\n1000 2000\n2000 3000";
            } else if (selectedType === 'percent') {
                placeholder = "e.g.\n10 20\n20 30";
            }

            const textarea = `<textarea class="form-control required" name="goal[]" rows="3" placeholder="${placeholder}"></textarea>`;
            wrapper.html(textarea);
        });
        
        // Event to add a new purpose
        $(document).on('click',".addNewPurpose",function() {
            $("#tbl_performance").append(addPurposeRow());
            // $(this).closest('tr').before(addPurposeRow());
        });
        $(document).on('click',".addMore", function() {
            $("#tbl_performance").append(addMoreRow());
        });

        // Event to add a new record
        $(document).on('click', '.addRecord', function() {
            // Append a new record row to the last purpose section
            // $(this).closest('tr').before(addNewRecord());
            $("#tbl_performance").append(addNewRecord());
        });
        // Event delegation for dynamically added Remove buttons in records
        $(document).on('click', '.removeRecord', function() {
            $(this).closest('tr').remove(); // Remove the clicked row
        });

        // Event delegation for dynamically added Remove buttons in purposes
        $(document).on('click', '.btnRemovePurpose', function() {
            // Find all rows with the class 'section-purpose' starting from the clicked button's row
            let currentRow = $(this).closest('tr');
            // Remove the current row and the next row(s) associated with the purpose section
            currentRow.nextUntil('tr:not(.section-purpose)').addBack().remove();
        });
        $(document).on('click', '.btnRemoveMore', function() {
           // Remove the current tr and all subsequent tr elements
            $(this).closest('tr').nextAll().remove();
            $(this).closest('tr').remove(); // Remove the current tr as well
        });
        $(document).ready(function() {
            // Attach event listeners to inputs with class .weight and .score_achieved
            $('#tbl_performance').on('input', '.weight', function () {
                var row = $(this).closest('tr');
                var weightInput = row.find('.weight');
                // Validate weight input
                var weightValue = parseFloat(weightInput.val());
                // Check if weightValue is NaN or out of range
                if (isNaN(weightValue) || weightValue < 0 || weightValue > 100) {
                    weightInput.val(0); // Reset to a default value or keep it empty
                    $('.weight').css("border-color","red");
                    // toastr.error('Please enter a weight between 0 and 100.', 'Error');
                }
            });
        });
        
        $(".weight").on('focus',function(){
            $(this).css("border-color","#1e9ff2");
        });
        $(".weight").on('focusout',function(){
            $(this).css("border-color","#d8d2d2");
        });
        $(document).on('click', '#btnCreatePerformance', function(e) {
            e.preventDefault(); // Prevent the form from submitting the traditional way
            let numRequired = 0;
            $(".required").each(function(e){
                if($(this).val()==""){ numRequired++;}
            });

            let dataKeyKpi = [];
            let $rows = $('#tbl_performance tbody tr');
            let i = 0;
            while (i < $rows.length) {
                let $titleRow = $($rows[i]);
                let title = $titleRow.find('input[name="title[]"]').val();
                i++;
                let dataPurpose = [];
                // Process all purpose rows until the next title or end
                while (i < $rows.length && !$($rows[i]).hasClass('title-group')) {
                    if ($($rows[i]).hasClass('purpose-group')) {
                        let purpose = $($rows[i]).find('input[name="purpose[]"]').val();
                        i++;
                        let dataKPi = [];
                        // Process all KPI rows until next purpose or title or end
                        while (i < $rows.length && !$($rows[i]).hasClass('title-group') && !$($rows[i]).hasClass('purpose-group')) {
                            let $kpiRow = $($rows[i]);
                            let key_kpi = $kpiRow.find('textarea[name="key_kpi[]"]').val();
                            let action_plan = $kpiRow.find('textarea[name="action_plan[]"]').val();
                            let goal = $kpiRow.find('textarea[name="goal[]"]').val();
                            let weight = $kpiRow.find('input[name="weight[]"]').val();
                            let goal_type = $kpiRow.find('select[name="goal_type[]"]').val();
                            let is_lock = $kpiRow.find('select[name="is_lock[]"]').val();

                            dataKPi.push({ key_kpi, action_plan, goal, weight,goal_type,is_lock });
                            i++;
                        }

                        dataPurpose.push({ purpose, dataKPi });
                    } else {
                        i++; // just in case of stray rows
                    }
                }
                dataKeyKpi.push({ title, dataPurpose });
            }
            if (numRequired>0) {
                toastr.error("@lang('lang.input_required')", "@lang('lang.message_title')");
                $(".required").each(function(){
                    if($(this).val()==""){
                        $(this).css("border-color","red");
                    }
                });
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ url('performance/store') }}",
                    data: {
                        employee_id : $("#employee_id").val(),
                        from_date : $("#from_date").val(),
                        to_date : $("#to_date").val(),
                        data: dataKeyKpi,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.message=='successfully') {
                            toastr.success(response.message, 'Success');
                            setTimeout(function () {
                                window.location.href = "{{ url('performance') }}";
                            }, 2000);
                            $('#performanceForm').trigger("reset");
                        } else if (response.message === 'not_goal') {
                            toastr.error(response.error || 'Invalid goal format for type'+' '+response.goal_type || 'Error');
                        } else {
                            toastr.error(response.message || 'សរុបទម្ងន់ត្រូវតែស្មើនឹង 100%', 'Error');
                        }
                    }
                });
            }
        });
    });

    // Function to create a new purpose row
    function addPurposeRow() {
        return `<tr class='section-purpose purpose-group' style='text-align: center'>
            <td colspan="2" class="text-center">
                <input type="text" class="form-control required" name="purpose[]" placeholder="គោលបំណង" value="{{old('purpose')}}">
            </td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center">
                <button type="button" class="btn btn-danger btn-sm btnRemovePurpose">Remove Purpose</button>
            </td>
        </tr>
        <tr class='section-purpose kpi-group' style='text-align: center'>
            <td class="text-center">
                <textarea rows="3" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false"></textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false"></textarea>
            </td>
           <td class="text-center">
                <select class="form-control goal-type-select" name="goal_type[]">
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="currency">Currency</option>
                    <option value="percent">Percent</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <textarea class="form-control required" name="goal[]" rows="3" placeholder="e.g.&#10;60 70&#10;70 80&#10;90 100"></textarea>
                </div>
            </td>
            <td class="text-center"><input type="number" name="weight[]" step="any" class="form-control weight required" id="weight" placeholder="%"></td>
            <td class="text-center">
                <select class="form-control" name="is_lock[]" id="is_lock" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
            </td>
        </tr>`;
    }
    // Function to create a new record row
    function addNewRecord() {
        return `<tr class='section-purpose kpi-group' style='text-align: center'>
            <td class="text-center">
                <textarea rows="3" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
            </td>
            <td class="text-center">
                <select class="form-control goal-type-select" name="goal_type[]">
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="currency">Currency</option>
                    <option value="percent">Percent</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <textarea class="form-control required" name="goal[]" rows="3" placeholder="e.g.&#10;60 70&#10;70 80&#10;90 100"></textarea>
                </div>
            </td>
            <td class="text-center"><input type="number" name="weight[]" step="any" class="form-control required" placeholder="%" min="0" value="{{old('weight')}}"></td>
            <td class="text-center">
                <select class="form-control" name="is_lock[]" id="is_lock" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger me-1 btn-sm removeRecord"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>`;
    }
    function addMoreRow() {
        return `<tr class='title-group'>
            <td colspan="2" class="text-center">
                <input type="text" class="form-control required" name="title[]" placeholder="កត្តាប្រតិបត្តិការ (%)" value="{{old('title')}}">
            </td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center">
                <a class="btn btn-danger btn-sm btnRemoveMore"><i class="fa fa-plus-circle"></i>Remove More</a>
            </td>
        </tr>
        <tr class='purpose-group' style='text-align: center'>
            <td colspan="2" class="text-center">
                <input type="text" class="form-control required" name="purpose[]" placeholder="គោលបំណង" value="{{old('purpose')}}">
            </td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center">
                <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i>Add Purpose</button>
            </td>
        </tr>
        <tr class='kpi-group' style='text-align: center'>
            <td class="text-center">
                <textarea rows="3" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
            </td>
            <td class="text-center">
                <select class="form-control goal-type-select" name="goal_type[]">
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="currency">Currency</option>
                    <option value="percent">Percent</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <textarea class="form-control required" name="goal[]" rows="3" placeholder="e.g.&#10;60 70&#10;70 80&#10;90 100"></textarea>
                </div>
            </td>
            <td class="text-center"><input type="number" name="weight[]" step="any" class="form-control required" placeholder="%" min="0" value="{{old('weight')}}"></td>
            <td class="text-center">
                <select class="form-control" name="is_lock[]" id="is_lock" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
            </td>
        </tr>`;
    }
</script>
