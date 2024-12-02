@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.review_performance')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.review_performance')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('users/create') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-sm-4 m-b-20">
                        <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" class="inv-logo" alt="">
                    </div>
                    <div class="col-md-4">
                        <h4 class="payslip-title">ទម្រង់វាយតម្លៃការងាររបស់បុគ្គលិកសាកល្បង</h4>
                        <h5 class="payslip-title">ប្រចាំឆ្នាំ៖ ២០២២</h5>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.employee_id')</label>
                            <input type="text" class="form-control" value="220-413" min="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.employee')</label>
                            <input type="text" class="form-control" value="មី សី" min="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.location')</label>
                            <input type="text" class="form-control" value="Head Quarter" min="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.department')</label>
                            <input type="text" class="form-control" value="IT Department" min="">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 350px;">(KPI)</th>
                                        <th style="min-width: 350px;">Action Plan</th>
                                        <th style="min-width: 350px;">Goal</th>
                                        <th style="min-width: 150px;">% Weight</th>
                                        <th style="min-width: 150px;">Score achieved</th>
                                        <th style="min-width: 150px;">Score</th>
                                        <th style="min-width: 150px;">បុគ្គលិកផ្ទាល់</th>
                                        <th style="min-width: 150px;">ប្រធានផ្ទាល់</th>
                                        <th style="min-width: 350px;">កត្តាដែលងាយស្រួល និងលំបាក</th>
                                        <th style="min-width: 350px;">យោបល់/កំណត់សម្គាល់</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_performance">
                                    @foreach ($data as $item)
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <input type="text" class="form-control" value="" required>
                                            </td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <input type="text" class="form-control" value="" required>
                                            </td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="text-center">
                                                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required>{{$item->key_kpi}}</textarea>
                                            </td>
                                            <td class="text-center">
                                                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required>{{$item->action_plan}}</textarea>
                                            </td>
                                            <td class="text-center">
                                                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required>{{$item->goal}}</textarea>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" step="any" class="form-control weight" placeholder="%" min="0" value="{{$item->weight}}" id="weight" required>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" step="any" class="form-control score_achieved" placeholder="0" id="score_achieved">
                                            </td>
                                            <td class="text-center">
                                                <input type="number" step="any" class="form-control score" placeholder="0" min="0" id="score" readonly>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" step="any" class="form-control personnel_score" placeholder="0" min="0" id="personnel_score" readonly>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" step="any" class="form-control direct_chairman" placeholder="0" min="0" id="direct_chairman" readonly>
                                            </td>
                                            <td class="text-center">
                                                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false"></textarea>
                                            </td>
                                            <td class="text-center">
                                                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false"></textarea>
                                            </td>
                                        </tr>
                                        
                                        <tr class="total">
                                            <td colspan="5" class="text-center">សរុប = </td>
                                            <td colspan="1" class="text-center">
                                                <input type="text" class="form-control tr_score" placeholder="0" id="tr_score" value="" readonly>
                                            </td>
                                            <td colspan="1" class="text-center">
                                                <input type="text" class="form-control tr_personnel_score" placeholder="0" id="tr_personnel_score" value="" readonly>
                                            </td>
                                            <td colspan="1" class="text-center">
                                                <input type="text" class="form-control tr_direct_chairman" placeholder="0" id="tr_direct_chairman" value="" readonly>
                                            </td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center">សរុបរួម</td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control" id="total-weight" placeholder="%" value="" readonly>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control" placeholder="លទ្ធផលរួម =" value="" readonly>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control" placeholder="" id="total_score" value="" readonly>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control" placeholder="" id="total_personnel_score" value="" readonly>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control" placeholder="" id="total_direct_chairman" value="" readonly>
                                        </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center">% ពិន្ទុវាយតម្លៃតាមគោលដៅ</td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="3" class="text-center">
                                            <input type="text" id="overall_results" class="form-control" placeholder="Overall Results" readonly>
                                        </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="submit-section mb-2">
                    <button type="submit" class="btn btn-primary submit-btn">
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
        $(document).on('input', '.score_achieved', function() {
            let value = parseFloat($(this).val());
            // Handle case when the input is empty
            if (isNaN(value)) {
                $(this).val(''); // Clear the input if not a number
                return;
            }
            // Custom validation range (0 to 5)
            if (value < 0) {
                $(this).val(0); // Set to 0 if below 0
            } else if (value > 5) {
                $(this).val(5); // Set to 5 if above 5
            }
        });
        $(document).ready(function() {
            // Attach event listeners to inputs with class .weight and .score_achieved
            $('#tbl_performance').on('input', '.weight, .score_achieved', function () {
                var row = $(this).closest('tr');
                var weightInput = row.find('.weight');
                // Validate weight input
                var weightValue = parseFloat(weightInput.val());
                // Check if weightValue is NaN or out of range
                if (isNaN(weightValue) || weightValue < 0 || weightValue > 100) {
                    weightInput.val(10); // Reset to a default value or keep it empty
                    toastr.error('Please enter a weight between 0 and 100.', 'Error');
                }
                calculateRowTotals(row);
            });
            // Initial calculation on page load
            calculateTotals();
        });
        $(document).ready(function () {
            $('#tbl_performance').on('input', '.score_achieved, .weight', function () {
                var row = $(this).closest('tr');
                calculateRowTotals(row);
                calculateTotals();
            });
        });
    });
    function calculateRowTotals(row) {
        var weight = parseFloat(row.find(".weight").val()) || 0;
        var scoreAchieved = parseFloat(row.find(".score_achieved").val()) || 0;
        // Constrain weight to be within 0 and 100
        if (weight < 0) weight = 0;
        if (weight > 100) weight = 100;
        row.find(".weight").val(weight); // Update the input field to reflect valid weight

        if (scoreAchieved < 0) scoreAchieved = 0;
        if (scoreAchieved > 5) scoreAchieved = 5;
        if (scoreAchieved <= 5) {
            var totalWeight = weight / 100;
            var score = totalWeight * scoreAchieved;
            row.find(".score").val(score.toFixed(1));
            row.find(".personnel_score").val(score.toFixed(2));
            row.find(".direct_chairman").val(score.toFixed(2));
            var totalRow = row.next(".total");
            totalRow.find(".tr_score").val(score.toFixed(1));
            totalRow.find(".tr_personnel_score").val(score.toFixed(2));
            totalRow.find(".tr_direct_chairman").val(score.toFixed(2));   
        }
    }
    function calculateTotals() {
        let totalTrScore = 0;
        // Sum up all row scores to calculate the total
        $('#tbl_performance .tr_score').each(function () {
            const trScore = parseFloat($(this).val()) || 0;
            totalTrScore += trScore;
        });
        // Check if totalScore exceeds 5
        if (totalTrScore >= 5) {
            // Optionally, set total_score to 5 or limit further input
            totalTrScore = 5; // This can be changed based on how you want to handle it
        }
        // Set the total score
        $('#total_score').val(totalTrScore.toFixed(2));
        $('#total_personnel_score').val(totalTrScore.toFixed(2));
        $('#total_direct_chairman').val(totalTrScore.toFixed(2));
        updateOverallResults(totalTrScore);
        calculateTotalWeight();
    }
    function updateOverallResults(totalScore) {
        var overallResults = '';
        var color = '';
        if (totalScore === 0) {
            overallResults = '';
        } else if (totalScore < 2) {
            overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
            color = 'red';
        } else if (totalScore <= 2.99) {
            overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
            color = 'orange';
        } else if (totalScore <= 3.99) {
            overallResults = 'ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
            color = 'info';
        } else if (totalScore <= 4.99) {
            overallResults = 'ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)';
            color = 'lightgreen';
        } else {
            overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
            color = 'green';
        }
        $('#overall_results').val(overallResults).css('color', color);
    }
    function calculateTotalWeight() {
        let totalWeight = 0;
        // Sum the weights from all input fields
        $('#tbl_performance .weight').each(function () {
            const weight = parseFloat($(this).val()) || 0;
            totalWeight += weight;
        });
        // Check if totalWeight exceeds 100
        if (totalWeight > 100) {
            // Optionally alert the user or adjust weights
            // toastr.error('Total weight cannot exceed 100%. Please adjust the values.', 'Error');
            totalWeight = 100; // You can set it back to 100 or any logic you prefer
        }
        // Update the total weight display
        $('#total-weight').val(totalWeight + '%');
        // Optionally, if you want to adjust individual weights to meet the limit
        $('#tbl_performance .weight').each(function () {
            const weightInput = $(this);
            const weight = parseFloat(weightInput.val()) || 0;
            // If total weight is 100, make sure to not allow further input
            if (totalWeight === 100) {
                weightInput.prop('max', weight); // Set max to current value
            } else {
                weightInput.prop('max', 100 - (totalWeight - weight)); // Adjust max based on remaining capacity
            }
        });
    }
</script>
