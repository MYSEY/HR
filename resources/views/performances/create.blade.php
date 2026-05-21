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
                                        <th style="min-width: 450px;">(KPI)</th>
                                        <th style="min-width: 500px;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
                                        <th style="min-width: 350px;">គោលដៅ (Goal)</th>
                                        <th style="min-width: 150px;">ទម្ងន់ (Weight %) <span id="total_weight"></span></th>
                                        <th style="min-width: 150px;">Is Lock</th>
                                        <th style="min-width: 500px;">Comments</th>
                                        <th>@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div>
                                        <tr class="title-group" style="background-color: #e5e1e1">
                                            <td colspan="6" class="text-center">
                                                <input type="text" class="form-control required" style="background: #efa781" id="title" name="title[]" placeholder="កត្តាប្រតិបត្តិការ (%)" value="{{old('title')}}">
                                            </td>
                                            {{-- <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"><p id="total_weight">0</p></td>
                                            <td colspan="1" class="text-center"></td> --}}
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                        <div>
                                            <tr class="purpose-group" style="background-color: #e5e1e1">
                                                <td colspan="6" class="text-center">
                                                    <input type="text" class="form-control required" style="background: #f0cc9b" id="purpose" name="purpose[]" placeholder="គោលបំណង" value="{{old('purpose')}}">
                                                </td>
                                                {{-- <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td> --}}
                                                <td colspan="1" class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btnRemovePurpose"><i class="fa fa-minus"></i></button>
                                                    <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i></button>
                                                </td>
                                            </tr>
                                            <div>
                                                <tr class="kpi-group">
                                                    <td class="text-center">
                                                        <textarea rows="9" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="9" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <select class="form-control goal-type-select mt-1 goal_type" name="goal_type[]">
                                                            <option value="number_increment">Number Increment</option>
                                                            <option value="number_decrement">Number Decrement</option>

                                                            <option value="percent_increment">Percent Increment</option>
                                                            <option value="percent_decrement">Percent Decrement</option>

                                                            <option value="currency_increment">Currency Increment</option>
                                                            <option value="currency_decrement">Currency Decrement</option>

                                                            <option value="date_increment">Date Increment</option>
                                                            <option value="date_decrement">Date Decrement</option>
                                                        </select>
                                                        <div class="goal-input-wrapper mt-1">
                                                            <div class="row mb-1">
                                                                <div class="group d-flex align-items-center">
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-center">To</div>
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="group d-flex align-items-center">
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-center">To</div>
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row mb-1">
                                                                <div class="group d-flex align-items-center">
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-center">To</div>
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="group d-flex align-items-center">
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-center">To</div>
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="group d-flex align-items-center">
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 text-center">To</div>
                                                                    <div class="col-md-5">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text" style="height: 35px;">#</span>
                                                                            <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                   
                                                    <td class="text-center">
                                                        <input type="number" step="any" class="form-control sum_total_weight required" name="weight[]" placeholder="%" value="{{old('weight')}}">
                                                    </td>
                                                    <td class="text-center">
                                                        <select class="form-control" name="is_lock[]" required>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="6" class="form-control" name="comment[]" placeholder="Enter text comment here" spellcheck="false">{{ old('comment') }}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger me-1 btn-sm removeRecord"><i class="fa fa-trash-o"></i></button>
                                                        <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <textarea rows="6" class="form-control" name="main_comment" id="main_comment" placeholder="Enter text comment here" spellcheck="false">{{ old('main_comment') }}</textarea>
                                        </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
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
                        <span class="btn-txt">@lang('lang.save')</span>
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
        $(document).on('input', '.sum_total_weight', calculateTotal);
        let dataKeyKpi = [];
        $(document).on('change', '.goal-type-select', function () {
            let selectedType = $(this).val();
            let wrapper = $(this).closest('td').find('.goal-input-wrapper');

            let [dataType, direction] = selectedType.split('_');

            let inputType = 'number';
            let step = 'any';
            let symbol = '';
            let placeholderFrom = 'From';
            let placeholderTo = 'To';

            if (dataType === 'date') {
                inputType = 'date';
            } 
            else if (dataType === 'percent') {
                inputType = 'number';
                step = '0.01';
                symbol = '%';
                placeholderFrom = 'From';
                placeholderTo = 'To';
            } 
            else if (dataType === 'currency') {
                inputType = 'number';
                step = '0.01';
                symbol = '$';
                placeholderFrom = 'From';
                placeholderTo = 'To';
            } 
            else if (dataType === 'number') {
                inputType = 'number';
                step = 'any';
                symbol = '#'; // 🔥 ADD THIS
                placeholderFrom = 'From';
                placeholderTo = 'To';
            }

            function generateRow() {
                return `
                <div class="row mb-1">
                    <div class="group d-flex align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                ${symbol ? `<span class="input-group-text" style="height: 35px;">${symbol}</span>` : ''}
                                <input type="${inputType}" step="${step}" class="form-control goal-from required" name="goal_from[]" placeholder="${placeholderFrom}" style="height:35px;">
                            </div>
                        </div>
                        <div class="col-md-2 text-center">To</div>
                        <div class="col-md-5">
                            <div class="input-group">
                                ${symbol ? `<span class="input-group-text" style="height: 35px;">${symbol}</span>` : ''}
                                <input type="${inputType}" step="${step}" class="form-control goal-to required" name="goal_to[]" placeholder="${placeholderTo}" style="height:35px;">
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            let html = '';
            for (let i = 0; i < 5; i++) {
                html += generateRow();
            }
            wrapper.html(html);
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
            // $(this).closest('tr').before(addNewRecord());
            $("#tbl_performance").append(addNewRecord());
        });
        $(document).on('click', '.removeRecord', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.btnRemovePurpose', function() {
            let currentRow = $(this).closest('tr');
            currentRow.nextUntil('tr:not(.section-purpose)').addBack().remove();
        });
        $(document).on('click', '.btnRemoveMore', function() {
            $(this).closest('tr').nextAll().remove();
            $(this).closest('tr').remove();
        });
        $(document).on('input', '.weight', function () {
            let total = 0;
            $('.weight').each(function () {
                let value = parseFloat($(this).val()) || 0;
                if (value < 0 || value > 100) {
                    $(this).css("border-color", "red");
                    value = 0;
                } else {
                    $(this).css("border-color", "");
                }
                total += value;
            });
            $('#total_weight').text(total);
        });
        $(document).ready(function() {
            $('#tbl_performance').on('input', '.weight', function () {
                var row = $(this).closest('tr');
                var weightInput = row.find('.weight');
                var weightValue = parseFloat(weightInput.val());
                if (isNaN(weightValue) || weightValue < 0 || weightValue > 100) {
                    weightInput.val(0);
                    $('.weight').css("border-color","red");
                    // toastr.error('Please enter a weight between 0 and 100.', 'Error');
                }
            });
        });
        $(document).on('focus', '.required', function () {
            $(this).css("border-color", "#1e9ff2");
        });

        $(document).on('blur', '.required', function () {
            if ($(this).val().trim() === "") {
                $(this).css("border-color", "#d8d2d2");
            }
        });

        $(document).on('click', '#btnCreatePerformance', function(e) {
            e.preventDefault();
            $(this).attr('disabled',true);
            $('.btn-cancel').addClass('disabled');
            $(".loading-icon").css("display", "block");
            $(".btn-txt").css("display", "none");
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
                while (i < $rows.length && !$($rows[i]).hasClass('title-group')) {
                    if ($($rows[i]).hasClass('purpose-group')) {
                        let purpose = $($rows[i]).find('input[name="purpose[]"]').val();
                        i++;
                        let dataKPi = [];
                        while (i < $rows.length && !$($rows[i]).hasClass('title-group') && !$($rows[i]).hasClass('purpose-group')) {
                            let $kpiRow = $($rows[i]);
                            let key_kpi = $kpiRow.find('textarea[name="key_kpi[]"]').val();
                            let action_plan = $kpiRow.find('textarea[name="action_plan[]"]').val();
                            let weight = $kpiRow.find('input[name="weight[]"]').val();
                            let goal_type = $kpiRow.find('select[name="goal_type[]"]').val();
                            let is_lock = $kpiRow.find('select[name="is_lock[]"]').val();
                            let comment = $kpiRow.find('textarea[name="comment[]"]').val();

                            let goal = [];
                            $kpiRow.find('.goal-from').each(function(index) {
                                let fromVal = $(this).val();
                                let toVal = $kpiRow.find('.goal-to').eq(index).val();
                                if (fromVal || toVal) {
                                    goal.push({ from: fromVal, to: toVal });
                                }
                            });
                            dataKPi.push({ key_kpi, action_plan, goal, weight,goal_type,is_lock,comment });
                            i++;
                        }
                        dataPurpose.push({ purpose, dataKPi });
                    } else {
                        i++;
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
                $("#btnCreatePerformance").attr('disabled',false);
                $('.btn-cancel').removeClass('disabled');;
                $(".loading-icon").css("display", "none");
                $(".btn-txt").css("display", "block");
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ url('performance/store') }}",
                    data: {
                        employee_id : $("#employee_id").val(),
                        from_date : $("#from_date").val(),
                        to_date : $("#to_date").val(),
                        main_comment : $("#main_comment").val(),
                        data: dataKeyKpi,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $("#btnCreatePerformance").attr('disabled',false);
                        $('.btn-cancel').removeClass('disabled');;
                        $(".loading-icon").css("display", "none");
                        $(".btn-txt").css("display", "block");
                        if (response.message=='successfully') {
                            toastr.success(response.message, 'Success');
                            setTimeout(function () {
                                window.location.href = "{{ url('performance') }}";
                            }, 2000);
                            $('#performanceForm').trigger("reset");
                        } else if (response.message === 'not_goal') {
                            let index = response.kpi_index;
                            $(".goal_type").css("border-color", "");
                            let color = 'red';
                            if (response.goal_type.includes('percent')) {
                                color = 'orange';
                            } else if (response.goal_type.includes('currency')) {
                                color = 'green';
                            } else if (response.goal_type.includes('date')) {
                                color = 'blue';
                            }
                            $(".goal_type").eq(index).css("border-color", color);
                            toastr.error(
                                response.error || 'Invalid goal format for type ' + response.goal_type,
                                'Error'
                            );
                        } else {
                            toastr.error(response.message || 'សរុបទម្ងន់ត្រូវតែស្មើនឹង 100%', 'Error');
                        }
                    }
                });
            }
        });
    });
    function addPurposeRow() {
        return `<tr class='section-purpose purpose-group' style='text-align: center; background-color: #e5e1e1'>
            <td colspan="6" class="text-center">
                <input type="text" class="form-control required" style='background-color: #efa781' name="purpose[]" placeholder="គោលបំណង" value="{{old('purpose')}}">
            </td>
            <td colspan="1" class="text-center">
                <button type="button" class="btn btn-danger btn-sm btnRemovePurpose"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i></button>
            </td>
        </tr>
        <tr class='section-purpose kpi-group' style='text-align: center'>
            <td class="text-center">
                <textarea rows="9" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false"></textarea>
            </td>
            <td class="text-center">
                <textarea rows="9" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false"></textarea>
            </td>
            <td class="text-center">
                <select class="form-control goal-type-select mt-1 goal_type" name="goal_type[]">
                    <option value="number_increment">Number Increment</option>
                    <option value="number_decrement">Number Decrement</option>

                    <option value="percent_increment">Percent Increment</option>
                    <option value="percent_decrement">Percent Decrement</option>

                    <option value="currency_increment">Currency Increment</option>
                    <option value="currency_decrement">Currency Decrement</option>

                    <option value="date_increment">Date Increment</option>
                    <option value="date_decrement">Date Decrement</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="text-center"><input type="number" name="weight[]" step="any" class="form-control sum_total_weight weight required" placeholder="%"></td>
            <td class="text-center">
                <select class="form-control" name="is_lock[]" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>
            <td class="text-center">
                <textarea rows="6" class="form-control" name="comment[]" placeholder="Enter text comment here" spellcheck="false">{{ old('comment') }}</textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger me-1 btn-sm removeRecord"><i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
            </td>
        </tr>`;
    }
    function addNewRecord() {
        return `<tr class='section-purpose kpi-group' style='text-align: center'>
            <td class="text-center">
                <textarea rows="9" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
            </td>
            <td class="text-center">
                <textarea rows="9" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
            </td>
            <td class="text-center">
                <select class="form-control goal-type-select mt-1 goal_type" name="goal_type[]">
                    <option value="number_increment">Number Increment</option>
                    <option value="number_decrement">Number Decrement</option>

                    <option value="percent_increment">Percent Increment</option>
                    <option value="percent_decrement">Percent Decrement</option>

                    <option value="currency_increment">Currency Increment</option>
                    <option value="currency_decrement">Currency Decrement</option>

                    <option value="date_increment">Date Increment</option>
                    <option value="date_decrement">Date Decrement</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="text-center"><input type="number" name="weight[]" step="any" class="form-control sum_total_weight required" placeholder="%" min="0" value="{{old('weight')}}"></td>
            <td class="text-center">
                <select class="form-control" name="is_lock[]" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>
            <td class="text-center">
                <textarea rows="6" class="form-control" name="comment[]" placeholder="Enter text comment here" spellcheck="false">{{ old('comment') }}</textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger me-1 btn-sm removeRecord"><i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
            </td>
        </tr>`;
    }
    function addMoreRow() {
        return `<tr class='title-group' style='background-color: #e5e1e1'>
            <td colspan="6" class="text-center">
                <input type="text" class="form-control required" style='background-color: #f0cc9b' name="title[]" placeholder="កត្តាប្រតិបត្តិការ (%)" value="{{old('title')}}">
            </td>
            <td colspan="1" class="text-center">
                <a class="btn btn-danger btn-sm btnRemoveMore"><i class="fa fa-plus-circle"></i>Remove More</a>
            </td>
        </tr>
        <tr class='purpose-group' style='text-align: center; background-color: #e5e1e1'>
            <td colspan="6" class="text-center">
                <input type="text" class="form-control required" style='background-color: #f0cc9b' name="purpose[]" placeholder="គោលបំណង" value="{{old('purpose')}}">
            </td>
            <td colspan="1" class="text-center">
                <button type="button" class="btn btn-danger btn-sm btnRemovePurpose"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i></button>
            </td>
        </tr>
        <tr class='kpi-group' style='text-align: center'>
            <td class="text-center">
                <textarea rows="9" class="form-control required" name="key_kpi[]" placeholder="Enter text here" spellcheck="false">{{ old('key_kpi') }}</textarea>
            </td>
            <td class="text-center">
                <textarea rows="9" class="form-control required" name="action_plan[]" placeholder="Enter text here" spellcheck="false">{{ old('action_plan') }}</textarea>
            </td>
            <td class="text-center">
                <select class="form-control goal-type-select mt-1 goal_type" name="goal_type[]">
                    <option value="number_increment">Number Increment</option>
                    <option value="number_decrement">Number Decrement</option>

                    <option value="percent_increment">Percent Increment</option>
                    <option value="percent_decrement">Percent Decrement</option>

                    <option value="currency_increment">Currency Increment</option>
                    <option value="currency_decrement">Currency Decrement</option>

                    <option value="date_increment">Date Increment</option>
                    <option value="date_decrement">Date Decrement</option>
                </select>
                <div class="goal-input-wrapper mt-1">
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="group d-flex align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-from required" name="goal_from[]" placeholder="From" style="height: 35px;">
                                </div>
                            </div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text" style="height: 35px;">#</span>
                                    <input type="number" step="any" class="form-control goal-to required" name="goal_from[]" placeholder="To" style="height:35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="text-center"><input type="number" name="weight[]" step="any" class="form-control sum_total_weight required" placeholder="%" min="0" value="{{old('weight')}}"></td>
            <td class="text-center">
                <select class="form-control" name="is_lock[]" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>
            <td class="text-center">
                <textarea rows="6" class="form-control" name="comment[]" placeholder="Enter text comment here" spellcheck="false">{{ old('comment') }}</textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger me-1 btn-sm removeRecord"><i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
            </td>
        </tr>`;
    }
    function calculateTotal() {
        let total_weight = 0;
        $(".sum_total_weight").each(function () {
            let value = parseFloat($(this).val()) || 0;
            total_weight += value;
        });
        if (total_weight > 100) {
            new Noty({
                title: "Please to check weight",
                text: "សរុបទម្ងន់ត្រូវតែស្មើនឹង 100%",
                type: "error",
                timeout: 5000,
                icon: true
            }).show();
        }
        $("#total_weight").text(total_weight);
    }
</script>
