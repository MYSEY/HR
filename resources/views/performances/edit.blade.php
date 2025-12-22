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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 hr-form-group-select2">
                    <div class="form-group">
                        <label>@lang('lang.employee')</label>
                        <select class="form-control hr-select2-option" id="employee_id" name="employee_id" value="{{ old('employee_id') }}">
                            <option selected value=""> -- @lang('lang.select')--</option>
                            @foreach ($employee as $item)
                                <option value="{{ $item->id }}" {{$item->id == $data->employee_id ? 'selected' : ''}}>
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
                            <input class="form-control datetimepicker required" type="text" id="from_date" name="from_date" value="{{$data->from_date}}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.to_date')</label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker required" type="text" id="to_date" name="to_date" value="{{$data->to_date}}" required>
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
                                    <th style="min-width: 450px;">(KPI)</th>
                                    <th style="min-width: 500px;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
                                    <th style="min-width: 350px;">គោលដៅ (Goal)</th>
                                    <th style="min-width: 150px;">ទម្ងន់ (Weight %)</th>
                                    <th style="min-width: 150px;">Is Lock</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->titles as $item)
                                    <tr class="title-group">
                                        <td colspan="2" class="text-center">
                                            <input type="text" class="form-control required" id="title" name="title[]" placeholder="កត្តាប្រតិបត្តិការ (%)" value="{{ $item->title ?? '' }}">
                                        </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                    </tr>
                                    @foreach ($item->purposes as $purposeItem)
                                        <tr class='section-purpose purpose-group' style='text-align: center'>
                                            <td colspan="2" class="text-center">
                                                <input type="text" class="form-control required" name="purpose[]" placeholder="គោលបំណង" value="{{ $purposeItem->name ?? '' }}">
                                            </td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td class="text-center">
                                                @if ($loop->index == 0)
                                                    <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i> Add Purpose</button>
                                                @else
                                                    <button type="button" class="btn btn-danger btn-sm btnRemovePurpose">Remove Purpose</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @foreach ($purposeItem->performanceDetail as $Detailitem)
                                            <tr class="section-purpose kpi-group">
                                                <td class="text-center">
                                                    <textarea rows="7" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false"
                                                        {{ $Detailitem->is_lock == 1 ? 'disabled' : '' }}>{{ $Detailitem->key_kpi }}
                                                    </textarea>
                                                </td>
                                                <td class="text-center">
                                                    <textarea rows="7" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false"
                                                        {{ $Detailitem->is_lock == 1 ? 'disabled' : '' }}>{{ $Detailitem->action_plan }}
                                                    </textarea>
                                                </td>
                                                <td class="text-center">
                                                    {{-- <select class="form-control goal-type-select" name="goal_type[]" {{ $Detailitem->is_lock == 1 ? 'disabled' : '' }}>
                                                        <option value="number" {{ $Detailitem->goal_type == 'number' ? 'selected' : '' }}>Number</option>
                                                        <option value="date" {{ $Detailitem->goal_type == 'date' ? 'selected' : '' }}>Date</option>
                                                        <option value="currency" {{ $Detailitem->goal_type == 'currency' ? 'selected' : '' }}>Currency</option>
                                                        <option value="percent" {{ $Detailitem->goal_type == 'percent' ? 'selected' : '' }}>Percent</option>
                                                    </select> --}}
                                                    <select class="form-control goal-type-select mt-1" name="goal_type[]" {{ $Detailitem->is_lock == 1 ? 'disabled' : '' }}>
                                                        <option value="number_increment" {{ $Detailitem->goal_type == 'number_increment' ? 'selected' : '' }}>Number Increment</option>
                                                        <option value="number_decrement" {{ $Detailitem->goal_type == 'number_decrement' ? 'selected' : '' }}>Number Decrement</option>

                                                        <option value="percent_increment" {{ $Detailitem->goal_type == 'percent_increment' ? 'selected' : '' }}>Percent Increment</option>
                                                        <option value="percent_decrement" {{ $Detailitem->goal_type == 'percent_decrement' ? 'selected' : '' }}>Percent Decrement</option>

                                                        <option value="currency_increment" {{ $Detailitem->goal_type == 'currency_increment' ? 'selected' : '' }}>Currency Increment</option>
                                                        <option value="currency_decrement" {{ $Detailitem->goal_type == 'currency_decrement' ? 'selected' : '' }}>Currency Decrement</option>

                                                        <option value="date_increment" {{ $Detailitem->goal_type == 'date_increment' ? 'selected' : '' }}>Date Increment</option>
                                                        <option value="date_decrement" {{ $Detailitem->goal_type == 'date_decrement' ? 'selected' : '' }}>Date Decrement</option>
                                                    </select>
                                                
                                                    <div class="goal-input-wrapper mt-1">
                                                        <textarea
                                                            class="form-control required"
                                                            name="goal[]"
                                                            rows="5"
                                                            placeholder="e.g.&#10;60 70&#10;70 80&#10;90 100"
                                                            spellcheck="false"
                                                            {{ $Detailitem->is_lock == 1 ? 'disabled' : '' }}
                                                        >{{ $Detailitem->goal }}</textarea>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <input type="number" step="any" class="form-control required weight" name="weight[]" id="weight" placeholder="%" value="{{ $Detailitem->weight }}" {{ $Detailitem->is_lock == 1 ? 'disabled' : '' }}>
                                                </td>
                                                @php
                                                    if (in_array(Auth::user()->RolePermission, ['admin', 'HRAdmin', 'developer', 'DHOD', 'DBM'])) {
                                                        $canEdit = 0;
                                                    } else {
                                                        $canEdit = $Detailitem->is_lock;
                                                    }
                                                @endphp
                                                <td class="text-center">
                                                    <select class="form-control" name="is_lock[]" id="is_lock" {{ $canEdit == 1 ? 'disabled' : '' }}>
                                                        <option value="0" {{ $Detailitem->is_lock == 0 ? 'selected' : '' }}>No</option>
                                                        <option value="1" {{ $Detailitem->is_lock == 1 ? 'selected' : '' }}>Yes</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    @if ($loop->index == 0)
                                                        <button type="button" class="btn btn-success btn-sm addRecord">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    @else
                                                        @if ($Detailitem->is_lock == 1)
                                                            <button type="button" class="btn btn-secondary btn-sm" disabled><i class="fa fa-lock"></i></button>
                                                        @else
                                                            <button type="button" class="btn btn-danger me-1 btn-sm removeRecord">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
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
                <input type="text" name="performance_id" id="performance_id" value="{{ $data->id }}" hidden>
                <button type="submit" class="btn btn-primary" id="btnCreatePerformance">
                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                        @lang('lang.loading') </span>
                    <span class="btn-txt">@lang('lang.submit')</span>
                </button>
                <a href="{{ url('performance') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
            </div>
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

            const textarea = `<textarea class="form-control required" name="goal[]" rows="5" placeholder="${placeholder}"></textarea>`;
            wrapper.html(textarea);
        });
        $(document).on('click', ".addNewPurpose", function () {
            let currentPurposeRow = $(this).closest('tr');
            // Find the nearest .title-group above this purpose
            let titleRow = currentPurposeRow.prevAll('.title-group').first();
            // Find all rows under this title group until the next title
            let rowsUnderTitle = titleRow.nextUntil('.title-group');
            // Find the last row of the current title group
            let lastRowInGroup = rowsUnderTitle.last();
            // Build new rows
            let newPurposeRow = $(addPurposeRow());
            // Insert them after the last row of the title group
            lastRowInGroup.after(newPurposeRow);
        });
        $(document).on('click',".addMore", function() {
            $("#tbl_performance").append(addMoreRow());
        });

        // Event to add a new record
        $(document).on('click', '.addRecord', function () {
            let currentTr = $(this).closest('tr');
            let purposeHeader = currentTr.prevAll('.purpose-group').first(); // Locate the related purpose row
            let rowsUnderPurpose = purposeHeader.nextUntil('.purpose-group, .title-group'); // All rows under this purpose
            let lastKpiRow = rowsUnderPurpose.filter('.kpi-group').last(); // Get last KPI row
            let newRow = currentTr.clone();
            // Reset fields
            newRow.find('textarea').val('');
            newRow.find('input[type=number]').val('').prop('disabled', false);
            newRow.find('select[name="is_lock[]"]').val('0').prop('disabled', false);
            // Replace buttons
            newRow.find('.addRecord').replaceWith(
                `<button type="button" class="btn btn-danger me-1 btn-sm removeRecord">
                    <i class="fa fa-trash-o"></i>
                </button>`
            );
            // Insert new row after last KPI row
            lastKpiRow.after(newRow);
        });

        // Event delegation for dynamically added Remove buttons in records
        $(document).on('click', '.removeRecord', function() {
            $(this).closest('tr').remove(); // Remove the clicked row
        });

        $(document).on('click', '.btnRemovePurpose', function () {
            let currentRow = $(this).closest('tr');
            // Select all rows until the next .purpose-group or .title-group
            let rowsToRemove = currentRow.nextUntil('.purpose-group, .title-group');
            // Include current purpose row too
            currentRow.add(rowsToRemove).remove();
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

            var performance_id = $("#performance_id").val();
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
                    url: "{{ url('performance/update') }}",
                    data: {
                        performance_id : performance_id,
                        employee_id : $("#employee_id").val(),
                        from_date : $("#from_date").val(),
                        to_date : $("#to_date").val(),
                        data: dataKeyKpi,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.message == 'successfully') {
                            toastr.success(response.message, 'Success');
                            setTimeout(function() {
                                window.location.href = "{{ url('performance') }}";
                            }, 2000);
                            $('#performanceForm').trigger("reset");
                        } else if(response.message == 'not_goal') {
                            toastr.error(response.error || 'Invalid goal format for type'+' '+response.goal_type || 'Error');
                        }else {
                            toastr.error(response.message || 'សរុបទម្ងន់ត្រូវតែស្មើនឹង 100%', 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred. Please try again.', 'Error');
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
                <textarea rows="7" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false"></textarea>
            </td>
            <td class="text-center">
                <textarea rows="7" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false"></textarea>
            </td>
            <td class="text-center">
                <select class="form-control goal-type-select" name="goal_type[]">
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="currency">Currency</option>
                    <option value="percent">Percent</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <textarea class="form-control required" name="goal[]" rows="5" placeholder="e.g.&#10;60 70&#10;70 80&#10;90 100"></textarea>
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
                <textarea rows="7" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
            </td>
            <td class="text-center">
                <textarea rows="7" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
            </td>
            <td class="text-center">
                <textarea rows="5" class="form-control required" name="goal[]" placeholder="Enter text here" spellcheck="false"></textarea>
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
            <td colspan="1" class="text-center">
                <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i> Add Purpose</button>
            </td>
        </tr>
        <tr class='kpi-group' style='text-align: center'>
            <td class="text-center">
                <textarea rows="7" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
            </td>
            <td class="text-center">
                <textarea rows="7" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
            </td>
            <td class="text-center">
                <select class="form-control goal-type-select" name="goal_type[]">
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="currency">Currency</option>
                    <option value="percent">Percent</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <textarea class="form-control required" name="goal[]" rows="5" placeholder="e.g.&#10;60 70&#10;70 80&#10;90 100"></textarea>
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
