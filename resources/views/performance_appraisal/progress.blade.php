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
                                    <th>ឯកសារយោង</th>
                                </tr>
                            </thead>
                            @php
                                $totalWeight = 0;
                                $totalsByTitleId = [];
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
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                        
                                        @foreach ($purposeItem->performanceDetail as $Detailitem)
                                            @php
                                                $totalWeight += (float) $Detailitem->weight;
                                                $titleId = $Detailitem->title_id;
                                                if (!isset($totalsByTitleId[$titleId])) {
                                                    $totalsByTitleId[$titleId] = [
                                                        'total_score' => 0,
                                                        'total_personnel_score' => 0,
                                                        'total_direct_chairman' => 0,
                                                    ];
                                                }
                                                $totalsByTitleId[$titleId]['total_score'] += (float) ($Detailitem->score ?? 0);
                                                $totalsByTitleId[$titleId]['total_personnel_score'] += (float) ($Detailitem->score_live_staff ?? 0);
                                                $totalsByTitleId[$titleId]['total_direct_chairman'] += (float) ($Detailitem->score_direct_chairman ?? 0);

                                                $currentTitleTotal = $totalsByTitleId[$item->id] ?? [
                                                    'total_score' => 0,
                                                    'total_personnel_score' => 0,
                                                    'total_direct_chairman' => 0,
                                                ];
                                                $hasFile = $Detailitem->reference->isNotEmpty();
                                                $file = $hasFile ? $Detailitem->reference->first() : null;
                                                $file_name = $file ? $file->reference : '';
                                            @endphp
                                            <tr class="performance-row">
                                                <td class="text-center" hidden>
                                                    <input type="number" step="any" class="form-control performance_id" name="performance_id[]" value="{{$Detailitem->id}}" id="performance_id">
                                                </td>
                                                <td class="text-center">
                                                    <textarea rows="5" class="form-control" placeholder="Enter text here" readonly>{{$Detailitem->key_kpi}}</textarea>
                                                </td>
                                                <td class="text-center">
                                                    <textarea rows="7" class="form-control" placeholder="Enter text here" readonly>{{$Detailitem->action_plan}}</textarea>
                                                </td>
                                                <td class="text-center">
                                                    {{-- <select class="form-control goal-type-selec goal_type" name="goal_type" disabled>
                                                        <option value="number" {{ $Detailitem->goal_type == 'number' ? 'selected' : '' }}>Number</option>
                                                        <option value="date" {{ $Detailitem->goal_type == 'date' ? 'selected' : '' }}>Date</option>
                                                        <option value="currency" {{ $Detailitem->goal_type == 'currency' ? 'selected' : '' }}>Currency</option>
                                                        <option value="percent" {{ $Detailitem->goal_type == 'percent' ? 'selected' : '' }}>Percent</option>
                                                    </select> --}}
                                                    <select class="form-control goal-type-selec goal_type" name="goal_type" disabled>
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
                                                        <textarea rows="5" class="form-control goal" placeholder="Enter text here" id="goal" readonly>{{ $Detailitem->goal }}</textarea>
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
                                                <td>
                                                    <div class="d-flex float-end">
                                                            <span class="ml-2 text-name-reference" style="display: {{ $hasFile ? 'block' : 'none' }}; margin-right: 10px;">{{ $file_name }}</span>
                                                            <input type="file" class="pa_reference" 
                                                                data-performenceid="{{$data->id}}" 
                                                                data-titleid="{{$item->id}}" 
                                                                data-purposeid="{{$purposeItem->id}}" 
                                                                data-id="{{$Detailitem->id}}" 
                                                                name="reference" 
                                                                accept=".pdf, .rar, .zip, .xlsx, .xls" style="display: {{ $hasFile ? 'none' : 'block' }}">

                                                        <a href="{{ $hasFile ? url('/performance/view-reference/'.$file->id) : 'javascript:void(0)' }}" 
                                                            class="btn btn-info btn-sm viewReference" 
                                                            target="_blank"
                                                            style="display: {{ $hasFile ? 'block' : 'none' }}; margin-right: 2px;">
                                                                <i class="fa fa-eye"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-danger btn-sm removeReference" 
                                                                data-id="{{ $hasFile ? $file->id : '' }}"
                                                                style="display: {{ $hasFile ? 'block' : 'none' }}">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <tr class="total">
                                        <td colspan="4" class="text-center">សរុប = </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control tr_score" id="tr_score" value="{{ number_format($currentTitleTotal['total_score'], 2) }}" readonly>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control tr_personnel_score" id="tr_personnel_score" value="{{ number_format($currentTitleTotal['total_personnel_score'], 2) }}" readonly>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <input type="text" class="form-control tr_direct_chairman" id="tr_direct_chairman" value="{{ number_format($currentTitleTotal['total_direct_chairman'], 2) }}" readonly>
                                        </td>
                                        <td colspan="3"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">សរុបរួម</td>
                                    <td colspan="1" class="text-center">
                                        <input type="text" class="form-control" id="total-weight" placeholder="%" value="{{$totalWeight}}%" readonly>
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
                                    <td colspan="1" class="text-center"></td>
                                </tr>
                            </tbody>
                            @php
                                $overallResults = '';
                                $color = '';
                                $score = (float) $data->total_score_direct_chairman;
                                if ($score === 0.00) {
                                    $overallResults = '';
                                } else if ($score < 2) {
                                    $overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
                                    $color = 'red';
                                } else if ($score <= 2.99) {
                                    $overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
                                    $color = 'orange';
                                } else if ($score <= 3.99) {
                                    $overallResults = 'ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
                                    $color = 'info';
                                } else if ($score <= 4.99) {
                                    $overallResults = 'ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)';
                                    $color = 'lightgreen';
                                } else {                
                                    $overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
                                    $color = 'green';
                                }
                            @endphp
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">% ពិន្ទុវាយតម្លៃតាមគោលដៅ</td>
                                    <td colspan="1" class="text-center"></td>
                                    <td colspan="1" class="text-center"></td>
                                    <td colspan="3" class="text-center">
                                        <input type="text" id="overall_results" class="form-control"  value="{{$overallResults}}" placeholder="Overall Results" readonly style="color: {{ $color }};">
                                    </td>
                                    <td colspan="1" class="text-center"></td>
                                    <td colspan="1" class="text-center"></td>
                                    <td colspan="1" class="text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="submit-section mb-2">
                @if ($data->status !="approved")
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                            @lang('lang.loading') </span>
                        <span class="btn-txt">@lang('lang.submit')</span>
                    </button>
                @endif
                
                <input type="text" name="id" id="id" value="{{ $data->id }}" hidden>
                <input type="text" name="employee_id" id="employee_id" value="{{ $data->employee_id }}" hidden>
                <a href=" @if ($data->status =='approved') {{ url('performance/appraisal/pa-report') }} @else {{ url('performance-appraisal') }} @endif" class="btn btn-secondary btn-cancel">@if ($data->status =='approved') @lang('lang.back') @else @lang('lang.cancel')@endif</a>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(document).ready(function () {
        $(document).on('change', '.pa_reference', function (e) {
            let fileInput = $(this);
            let container = fileInput.closest('.d-flex');
            let removeBtn = container.find('.removeReference');
            let nameReference = container.find('.text-name-reference');
            let file = e.target.files[0];

            if (!file) return;

            // ឆែកទំហំ File (5MB)
            let fileSize = file.size / 1024; // KB
            if (fileSize > 5120) {
                new Noty({
                    text: 'Please check file size less than or equal to 5MB.',
                    type: "error",
                    timeout: 5000
                }).show();
                fileInput.val("");
                return false;
            }

            let formData = new FormData();
            formData.append('performance_id', fileInput.data("performenceid"));
            formData.append('title_id', fileInput.data("titleid"));
            formData.append('purpose_id', fileInput.data("purposeid"));
            formData.append('detail_id', fileInput.data("id"));
            formData.append('reference', file);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                url: "{{ url('/performance/upload-reference') }}",
                type: 'POST',
                data: formData,
                processData: false, 
                contentType: false,
                success: function (response) {
                    if(response.status == 200) {
                        // រក្សាទុក ID ក្នុងប៊ូតុងលុប
                        let viewBtn = container.find('.viewReference');
                        viewBtn.attr('href', '/performance/view-reference/' + response.id).show();
                        removeBtn.attr('data-id', response.id).show();
                        nameReference.text(response.file_name).show();
                        fileInput.css('display', "none");
                        fileInput.prop('disabled', false);
                        new Noty({
                            text: 'File uploaded to Drive D successfully',
                            type: "success",
                            timeout: 3000
                        }).show();
                    }
                },
                error: function (xhr) {
                    fileInput.prop('disabled', false);
                    let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong';
                    new Noty({ text: errorMsg, type: "error" }).show();
                }
            });
        });
        $(document).on('click', '.viewReference', function(e) {
            let url = $(this).attr('href');
            if(url !== "javascript:void(0)") {
                window.open(url, '_blank'); // បើកក្នុង Tab ថ្មី
            }
        });
        $(document).on('click', '.removeReference', function () {
            let btn = $(this); 
            let dFlexContainer = btn.closest('.d-flex');
            let fileInput = dFlexContainer.find('.pa_reference');
            let nameReference = dFlexContainer.find('.text-name-reference');
            let viewReference = dFlexContainer.find('.viewReference');
            let id = btn.attr('data-id'); // ទាញយក ID ពីប៊ូតុងផ្ទាល់
            if (!id) {
                fileInput.prop('disabled', false).val('');
                btn.hide();
                return;
            }
            $.ajax({
                url: "{{ url('/performance/delete-reference') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.status == 200) {
                        nameReference.css('display', "none");
                        viewReference.css('display', "none");
                        fileInput.css('display', "block");
                        fileInput.val('');
                        btn.hide().removeAttr('data-id');
                        new Noty({ text: 'File deleted from Drive D!', type: "success", timeout: 3000 }).show();
                    }
                },
                error: function (xhr) {
                    alert('Error deleting file.');
                }
            });
        });

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
                if (!val) return null;
                val = val.toString().trim();

                switch (type) {
                    case 'date_increment':
                    case 'date_decrement':
                        return Date.parse(val);

                    case 'percent_increment':
                    case 'percent_decrement':
                        return parseFloat(val.replace('%', ''));

                    case 'currency_increment':
                    case 'currency_decrement':
                        return parseFloat(val.replace(/[^\d.]/g, ''));

                    case 'number_increment':
                    case 'number_decrement':
                        return parseFloat(val); // NO replace needed

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
                if (isNaN(input) || isNaN(min) || isNaN(max)) return;
                let matched = false;
                // Increment types → value increases
                if (goalType.includes("increment")) {
                    if (input >= min && input <= max) matched = true;
                }
                // Decrement types → value decreases
                if (goalType.includes("decrement")) {
                    if (input <= min && input <= max) matched = true;
                }
                if (matched) {
                    scoreAchieved = index + 1;
                    return false; // stop loop
                }
            });


            // const getParsedValue = (val, type) => {
            //     switch (type) {
            //         case 'date':
            //             return Date.parse(val);
            //         case 'percent':
            //             return parseFloat(val.replace('%', ''));
            //         case 'currency':
            //             return parseFloat(val.replace(/[^\d.]/g, ''));
            //         default:
            //             return parseFloat(val);
            //     }
            // };

            // const input = getParsedValue(progress, goalType);
            // lines.forEach((element, index) => {
            //     let [minRaw, maxRaw] = element.trim().split(/\s+/);
            //     let min = getParsedValue(minRaw, goalType);
            //     let max = getParsedValue(maxRaw, goalType);
            //     lastMax = max;
            //     if (!isNaN(input) && input >= min && input <= max) {
            //         scoreAchieved = index + 1;
            //         return false; // stop looping
            //     }
            // });

            // Check for exceeding max range
            // if (scoreAchieved === 0 && !isNaN(input) && lastMax !== null && input > lastMax) {
            //     scoreAchieved = (goalType === 'date') ? 0 : 5;
            // }

            if (scoreAchieved === 0 && !isNaN(input) && lastMax !== null && input > lastMax) {
                // If goal type is date, don't force 5 here
                scoreAchieved = (goalType === 'date') ? 0 : 5;
            } else if (goalType === 'date' && lastMax !== null) {
                // Handle date type specifically
                let inputDate = new Date(input);
                let lastMaxDate = new Date(lastMax);

                if (!isNaN(inputDate) && !isNaN(lastMaxDate) && inputDate < lastMaxDate) {
                    scoreAchieved = 5;
                }
            }
            $row.find('.score_achieved').val(scoreAchieved);
            // Calculate and update scores
            let weight = parseFloat($row.find('.weight').val()) || 0;
            let score = (weight * scoreAchieved) / 100;

            $row.find('.score').val(score.toFixed(2));
            $row.find('.personnel_score').val(score.toFixed(2));
            $row.find('.direct_chairman').val(score.toFixed(2));

            calculateSubtotals();
            calculateGrandTotals();
        });

        $(document).on('click', '#btnSubmit', function (e) {
            e.preventDefault();

            let token = $('meta[name="csrf-token"]').attr('content');
            let id = $('#id').val();
            let employee_id = $('#employee_id').val();
            let total_score = $('#total_score').val();
            let total_personnel_score = $('#total_personnel_score').val();
            let total_direct_chairman = $('#total_direct_chairman').val();

            let performanceDetail = [];
            $('tr.performance-row').each(function () {
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
                let $rows = $totalRow.prevUntil('tr.total, tr.title-row');
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
            
            var overallResults = '';
            var color = '';
            if (totalScore.toFixed(2) === 0) {
                overallResults = '';
            } else if (totalScore.toFixed(2) < 2) {
                overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
                color = 'red';
            } else if (totalScore.toFixed(2) <= 2.99) {
                overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
                color = 'orange';
            } else if (totalScore.toFixed(2) <= 3.99) {
                overallResults = 'ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
                color = 'info';
            } else if (totalScore.toFixed(2) <= 4.99) {
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
