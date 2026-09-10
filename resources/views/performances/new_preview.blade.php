@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.performance_review')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.performance_review')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('users/create') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" class="inv-logo" alt="">
                    </div>
                    <div class="col-md-4">
                        <h4 class="payslip-title">ទម្រង់វាយតម្លៃការងាររបស់បុគ្គលិកសាកល្បង</h4>
                        <h5 class="payslip-title">ប្រចាំឆ្នាំ៖ ២០២២</h5>
                    </div>
                </div>
                <div class="row" style="text-align: center;justify-content: center;justify-items: center;">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>(ពីថ្ងៃខែឆ្នាំ៖ 05/12/2022</strong></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>ដល់ថ្ងៃខែឆ្នាំ៖ 05/03/2023)</strong></label>
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
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 350px;">(KPI)</th>
                                        <th style="min-width: 350px;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
                                        <th style="min-width: 350px;">គោលដៅ (Goal)</th>
                                        <th>ទម្ងន់ (Weight %)</th>
                                        <th style="min-width: 100px;">ពិន្ទុសម្រេចបាន (Score achieved)</th>
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
                                <tbody id="tbl_performance">
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
                                            </tr>
                                            
                                            @foreach ($purposeItem->performanceDetail as $Detailitem)
                                                @php
                                                    $totalWeight += (float) $Detailitem->weight;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here" required>{{$Detailitem->key_kpi}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here" required>{{$Detailitem->action_plan}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here" required>{{$Detailitem->goal}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" step="any" class="form-control weight" placeholder="%" min="0" value="{{$Detailitem->weight}}" id="weight" readonly>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" step="any" class="form-control score_achieved" placeholder="0" id="score_achieved" min="0" max="5">
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
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here"></textarea>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        
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
                                            <input type="text" class="form-control" id="total-weight" placeholder="%" value="{{$totalWeight}}" readonly>
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
    $(document).ready(function () {
        document.querySelectorAll('.score_achieved').forEach(input => {
            input.addEventListener('input', function () {
                let val = parseFloat(this.value);
                if (val > 5) this.value = 5;
                if (val < 0) this.value = 0;
            });
        });

        // Trigger sum calculation when any score_achieved is changed
        $(document).on('input', '.score_achieved', function () {
            let $row = $(this).closest('tr');
            let weight = parseFloat($row.find('.weight').val()) || 0;
            let achieved = parseFloat($(this).val()) || 0;

            // Calculate and update scores
            let score = (weight * achieved) / 100;
            $row.find('.score').val(score.toFixed(2));
            $row.find('.personnel_score').val(score.toFixed(2));
            $row.find('.direct_chairman').val(score.toFixed(2));

            // Recalculate subtotals
            calculateSubtotals();
            calculateGrandTotals();
        });

        function calculateSubtotals() {
            $('#tbl_performance').find('tr.total').each(function () {
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
                overallResults = 'មធ្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
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
