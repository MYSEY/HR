@extends('layouts.master')
<style>
    .big-checkbox .custom-control-input {
        transform: scale(1.5); /* make checkbox 1.5x bigger */
        margin-right: 8px;
    }
    .big-checkbox .custom-control-label {
        font-size: 18px; /* adjust label text if you add one */
    }
    .container-checkbox {
        /* display: block; */
        position: relative;
        padding-left: 25px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
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
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 450px;">(KPI)</th>
                                        <th style="min-width: 500px;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
                                        <th style="min-width: 250px;">គោលដៅ (Goal)</th>
                                        <th>ទម្ងន់ (Weight %) <span id="total_weight"></span></th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_performance">
                                    @php
                                        $total_weight = 0;
                                    @endphp
                                    @foreach ($data->titles as $item)
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <input type="text" class="form-control" value="{{ $item->title ?? '' }}" required>
                                            </td>
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
                                            </tr>
                                            
                                            @foreach ($purposeItem->performanceDetail as $Detailitem)
                                                @php
                                                    $total_weight += $Detailitem->weight;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        <textarea rows="7" class="form-control" placeholder="Enter text here" required>{{$Detailitem->key_kpi}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="7" class="form-control" placeholder="Enter text here" required>{{$Detailitem->action_plan}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <select class="form-control goal-type-selec goal_type" name="goal_type">
                                                            <option value="number" {{ $Detailitem->goal_type == 'number' ? 'selected' : '' }}>Number</option>
                                                            <option value="date" {{ $Detailitem->goal_type == 'date' ? 'selected' : '' }}>Date</option>
                                                            <option value="currency" {{ $Detailitem->goal_type == 'currency' ? 'selected' : '' }}>Currency</option>
                                                            <option value="percent" {{ $Detailitem->goal_type == 'percent' ? 'selected' : '' }}>Percent</option>
                                                        </select>
                                                        <div class="goal-input-wrapper mt-1">
                                                            <textarea rows="5" class="form-control goal" placeholder="Enter text here" id="goal">{{ $Detailitem->goal }}</textarea>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" step="any" class="form-control weight" placeholder="%" min="0" value="{{$Detailitem->weight}}" id="weight" readonly>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    <input type="number" class="preview_total_weight" hidden value="{{$total_weight}}">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="submit-section mb-2">
                    <input type="text" name="performance_id" id="performance_id" value="{{ $data->id }}" hidden>
                    @if ($data->employee_id == Auth::user()->id && $data->status === 'preparing' || $data->status == "5")
                        <a href="javascript:" class="btn btn-success" id="btnAccepted">@lang('lang.accepted')</a>
                    @endif
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
        $("#total_weight").text($(".preview_total_weight").val());
        $("#btnAccepted").on('click',function(){
            var id = $("#performance_id").val();
            $.confirm({
                title: '@lang("lang.accepted")',
                content: 'Are you sure want to accepted this performance?',
                type: "blue",
                buttons: {
                    submit: {
                        text: 'Submit',
                        btnClass: 'btn-green',
                        action: function () {
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL("performance/accepted") }}', {
                                id: id,
                            })
                            .then(function (response) {
                                $('#modal-loading').modal('hide');
                                if (response.data.success) {
                                    new Noty({
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        timeout: 2500
                                    }).show();
                                    window.location.replace("{{ URL('performance') }}");
                                    return;
                                }
                                // Validation Error: Weight must be 100%
                                if (response.data.message === 'weight_must_be_exactly') {
                                    new Noty({
                                        text: 'Total weight must be exactly 100% before approval.',
                                        type: "error",
                                        timeout: 3000
                                    }).show();
                                    return;
                                }
                                // Other backend errors
                                new Noty({
                                    text: response.data.message || 'Unknown error',
                                    type: "error"
                                }).show();
                            })
                            .catch(function (error) {
                                $('#modal-loading').modal('hide');
                                new Noty({
                                    text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                    type: "error",
                                    timeout: 3000
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-secondary btn-sm'
                    }
                }
            });
        });
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
