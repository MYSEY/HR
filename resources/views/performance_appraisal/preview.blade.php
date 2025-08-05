@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.performance_appraisal')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.performance_appraisal')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" class="inv-logo" alt="">
                </div>
                
                <div class="col-md-4">
                    <h4 class="payslip-title">ទម្រង់វាយតម្លៃការងាររបស់បុគ្គលិកសាកល្បង</h4>
                    <h5 class="payslip-title">ប្រចាំឆ្នាំ៖ {{ \App\Helpers\Helper::toKhmerNumber(\Carbon\Carbon::parse($data->to_date)->format('Y')) }}</h5>
                </div>
            </div>
            <div class="row" style="text-align: center;justify-content: center;justify-items: center;">
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>(ពីថ្ងៃខែឆ្នាំ៖ {{$data->from_date}}</strong></label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>ដល់ថ្ងៃខែឆ្នាំ៖ {{$data->to_date}})</strong></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('lang.employee_id')</label>
                        <input type="text" class="form-control" value="{{$data->number_employee}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('lang.employee_name')</label>
                        <input type="text" class="form-control" value="{{$data->employee_name_kh}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('lang.location')</label>
                        <input type="text" class="form-control" value="{{$data->branch_name_en}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>@lang('lang.department')</label>
                        <input type="text" class="form-control" value="{{$data->dep_name}}">
                    </div>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered review-table mb-0" id="tbl_performance_appraisal">
                            <thead>
                                <tr>
                                    <th style="min-width: 350px;">(KPI)</th>
                                    <th style="min-width: 500px;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
                                    <th style="min-width: 300px;">គោលដៅ (Goal)</th>
                                    <th style="min-width: 250px;">Progress</th>
                                    <th>ទម្ងន់ (Weight %)</th>
                                    <th>ពិន្ទុសម្រេចបាន (Score Achieved)</th>
                                    <th>ពិន្ទុ (Score)</th>
                                    <th>បុគ្គលិកផ្ទាល់</th>
                                    <th>ប្រធានផ្ទាល់</th>
                                    <th style="min-width: 350px;">កត្តាដែលងាយស្រួល និងលំបាក</th>
                                    <th style="min-width: 350px;">យោបល់/កំណត់សម្គាល់</th>
                                </tr>
                            </thead>
                            @php
                                $totalWeight = 0;
                            @endphp
                            <tbody>
                                @foreach ($data->titles as $item)
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <input type="text" class="form-control" value="{{ $item->title ?? '' }}" required>
                                        </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                    </tr>
                                    
                                    @foreach ($item->purposes as $purposeItem)
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <input type="text" class="form-control" value="{{ $purposeItem->name ?? '' }}" required>
                                            </td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                        
                                        @foreach ($purposeItem->performanceDetail as $Detailitem)
                                            @php
                                                $totalWeight += (float) $Detailitem->weight;
                                            @endphp
                                            <tr class="performance-row">
                                                <td class="text-center" hidden>
                                                    <input type="number" step="any" class="form-control performance_id" name="performance_id[]" value="{{$Detailitem->id}}" id="performance_id">
                                                </td>
                                                <td class="text-center">
                                                    <textarea rows="5" class="form-control" placeholder="Enter text here" required>{{$Detailitem->key_kpi}}</textarea>
                                                </td>
                                                <td class="text-center">
                                                    <textarea rows="7" class="form-control" placeholder="Enter text here" required>{{$Detailitem->action_plan}}</textarea>
                                                </td>
                                                <td class="text-center">
                                                    <select class="form-control goal-type-selec goal_type" name="goal_type" disabled>
                                                        <option value="number" {{ $Detailitem->goal_type == 'number' ? 'selected' : '' }}>Number</option>
                                                        <option value="date" {{ $Detailitem->goal_type == 'date' ? 'selected' : '' }}>Date</option>
                                                        <option value="currency" {{ $Detailitem->goal_type == 'currency' ? 'selected' : '' }}>Currency</option>
                                                        <option value="percent" {{ $Detailitem->goal_type == 'percent' ? 'selected' : '' }}>Percent</option>
                                                    </select>
                                                    <div class="goal-input-wrapper mt-1">
                                                        <textarea rows="5" class="form-control goal" placeholder="Enter text here" id="goal" required>{{ $Detailitem->goal }}</textarea>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" step="any" class="form-control" id="progress" name="progress[]" value="{{$Detailitem->progress}}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="any" class="form-control weight" placeholder="%" min="0" value="{{$Detailitem->weight}}" id="weight" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="any" class="form-control score_achieved" name="score_achieved[]" placeholder="0" value="{{$Detailitem->score_achieved}}" id="score_achieved" min="0" max="5" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="any" class="form-control score" name="score[]" placeholder="0" min="0" id="score" value="{{$Detailitem->score}}" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="any" class="form-control personnel_score" name="personnel_score[]" placeholder="0" value="{{$Detailitem->score_live_staff}}" min="0" id="personnel_score" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="any" class="form-control direct_chairman" name="direct_chairman[]" placeholder="0" value="{{$Detailitem->score_direct_chairman}}" min="0" id="direct_chairman" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <textarea rows="5" class="form-control easy_difficult_factors" name="easy_difficult_factors[]" placeholder="Enter text here">{{$Detailitem->easy_difficult_factors}}</textarea>
                                                </td>
                                                <td class="text-center">
                                                    <textarea rows="5" class="form-control comment" name="comment[]" placeholder="Enter text here">{{$Detailitem->comment}}</textarea>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    
                                    <tr class="total">
                                        <td colspan="4" class="text-center">សរុប = </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
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
                                    <td colspan="4" class="text-center">សរុបរួម</td>
                                    <td colspan="1" class="text-center">
                                        <input type="text" class="form-control" id="total-weight" placeholder="%" value="{{$totalWeight}}" readonly>
                                    </td>
                                    <td colspan="1" class="text-center">
                                        <input type="text" class="form-control" placeholder="លទ្ធផលរួម =" value="" readonly>
                                    </td>
                                    <td colspan="1" class="text-center">
                                        <input type="text" class="form-control" placeholder="" id="total_score" value="{{$data->total_score}}" readonly>
                                    </td>
                                    <td colspan="1" class="text-center">
                                        <input type="text" class="form-control" placeholder="" id="total_personnel_score" value="{{$data->total_score_live_staff}}" readonly>
                                    </td>
                                    <td colspan="1" class="text-center">
                                        <input type="text" class="form-control" placeholder="" id="total_direct_chairman" value="{{$data->total_score_direct_chairman}}" readonly>
                                    </td>
                                    <td colspan="1" class="text-center"></td>
                                    <td colspan="1" class="text-center"></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">% ពិន្ទុវាយតម្លៃតាមគោលដៅ</td>
                                    <td colspan="1" class="text-center"></td>
                                    <td colspan="1" class="text-center"></td>
                                    <td colspan="3" class="text-center">
                                        <input type="text" id="overall_results" class="form-control" value="{{$data->overall_results}}" placeholder="Overall Results" readonly>
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
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                        @lang('lang.loading') </span>
                    <span class="btn-txt">@lang('lang.submit')</span>
                </button>
                <input type="text" name="id" id="id" value="{{ $data->id }}" hidden>
                <input type="text" name="employee_id" id="employee_id" value="{{ $data->employee_id }}" hidden>
                <a href="{{ url('performance-appraisal') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(document).ready(function () {
        $(document).on('change', '#progress', function (e) {
            let $row = $(this).closest('tr');
            let goal = $row.find('.goal').val();
            let progress = $(this).val();
            let goalType = $row.find('.goal_type').val();

            let scoreAchieved = 0;
            if (!goal || !progress) return;

            const lines = goal.trim().split('\n');
            let exceeded = false; // flag to track if progress exceeds max
            let lastMax = null;   // store last max to compare

            const getParsedValue = (val, type) => {
                switch (type) {
                    case 'date':
                        return Date.parse(val);
                    case 'percent':
                        return parseFloat(val.replace('%', ''));
                    case 'currency':
                        return parseFloat(val.replace(/[^\d.]/g, ''));
                    default:
                        return parseFloat(val);
                }
            };

            const input = getParsedValue(progress, goalType);
            lines.forEach((element, index) => {
                let [minRaw, maxRaw] = element.trim().split(/\s+/);
                let min = getParsedValue(minRaw, goalType);
                let max = getParsedValue(maxRaw, goalType);
                lastMax = max;
                if (!isNaN(input) && input >= min && input <= max) {
                    scoreAchieved = index + 1;
                    return false; // stop looping
                }
            });

            // Check for exceeding max range
            if (scoreAchieved === 0 && !isNaN(input) && lastMax !== null && input > lastMax) {
                scoreAchieved = (goalType === 'date') ? 1 : 5;
            }

            $row.find('.score_achieved').val(scoreAchieved.toFixed(2));
            // Calculate and update scores
            let weight = parseFloat($row.find('.weight').val()) || 0;
            let score = (weight * scoreAchieved) / 100;

            $row.find('.score').val(score.toFixed(2));
            $row.find('.personnel_score').val(score.toFixed(2));
            $row.find('.direct_chairman').val(score.toFixed(2));

            calculateSubtotals();
            calculateGrandTotals();
            updateOverallResults();
        });

        $(document).on('click', '#btnSubmit', function (e) {
            e.preventDefault();

            let token = $('meta[name="csrf-token"]').attr('content');
            let id = $('#id').val();
            let employee_id = $('#employee_id').val();
            let total_score = $('#total_score').val();
            let total_personnel_score = $('#total_personnel_score').val();
            let total_direct_chairman = $('#total_direct_chairman').val();
            let overall_results = $('#overall_results').val();

            let performanceDetail = [];
            $('tr.performance-row').each(function () {
                // $('#tbl_performance_appraisal tbody tr').each(function () {
                const $row = $(this);
                const performance_id = $row.find('input[name="performance_id[]"]').val();
                const progress = $row.find('input[name="progress[]"]').val();
                const score_achieved = $row.find('input[name="score_achieved[]"]').val();
                const score = $row.find('input[name="score[]"]').val();
                const personnel_score = $row.find('input[name="personnel_score[]"]').val();
                const direct_chairman = $row.find('input[name="direct_chairman[]"]').val();
                const easy_difficult_factors = $row.find('textarea[name="easy_difficult_factors[]"]').val();
                const comment = $row.find('textarea[name="comment[]"]').val();

                if (progress || score_achieved) {
                    performanceDetail.push({
                        performance_id,
                        progress,
                        score_achieved,
                        score,
                        personnel_score,
                        direct_chairman,
                        easy_difficult_factors,
                        comment
                    });
                }
            });
            $.ajax({
                type: 'PUT',
                url: "{{ url('performance-appraisal') }}/" + id,
                data: {
                    _token: token,
                    id,
                    employee_id,
                    total_score,
                    total_personnel_score,
                    total_direct_chairman,
                    overall_results,
                    performanceDetail: performanceDetail
                },
                dataType: 'JSON',
                success: function (response) {
                    if (response.message=='successfully') {
                        toastr.success(response.message, 'Success');
                        setTimeout(function () {
                            window.location.href = "{{ url('performance-appraisal') }}";
                        }, 2000);
                    }
                },
                error: function (xhr) {
                    toastr.error(response.message || 'An error occurred while saving', 'Error');
                }
            });
        });

        function calculateSubtotals() {
            $('#tbl_performance_appraisal').find('tr.total').each(function () {
                let $totalRow = $(this);
                let $rows = $totalRow.prevUntil('tr.total, tr:has(td[colspan="2"] input[type="text"])');

                let sumScore = 0, sumPersonnel = 0, sumChairman = 0;
                $rows.each(function () {
                    sumScore += parseFloat($(this).find('.score').val()) || 0;
                    sumPersonnel += parseFloat($(this).find('.personnel_score').val()) || 0;
                    sumChairman += parseFloat($(this).find('.direct_chairman').val()) || 0;
                });

                $totalRow.find('.tr_score').val(sumScore.toFixed(2));
                $totalRow.find('.tr_personnel_score').val(sumPersonnel.toFixed(2));
                $totalRow.find('.tr_direct_chairman').val(sumChairman.toFixed(2));
            });
        }

        function calculateGrandTotals() {
            let totalScore = 0, totalPersonnel = 0, totalChairman = 0, totalWeight = 0;

            $('.score').each(function () {
                totalScore += parseFloat($(this).val()) || 0;
            });
            $('.personnel_score').each(function () {
                totalPersonnel += parseFloat($(this).val()) || 0;
            });
            $('.direct_chairman').each(function () {
                totalChairman += parseFloat($(this).val()) || 0;
            });
            $('.weight').each(function () {
                totalWeight += parseFloat($(this).val()) || 0;
            });

            $('#total_score').val(totalScore.toFixed(2));
            $('#total_personnel_score').val(totalPersonnel.toFixed(2));
            $('#total_direct_chairman').val(totalChairman.toFixed(2));
            updateOverallResults(totalScore);
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
    });
</script>
