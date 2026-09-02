@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.performance_appraisal_review')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.performance_appraisal_review')</li>
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
                        <h4 class="payslip-title">{{$data->pa_form}}</h4>
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
                                        <th style="min-width: 250px;">Progress</th>
                                        <th>ទម្ងន់ (Weight %)</th>
                                        <th>ពិន្ទុសម្រេចបាន (Score Achieved)</th>
                                        <th>ពិន្ទុ (Score)</th>
                                        <th>បុគ្គលិកផ្ទាល់</th>
                                        <th>ប្រធានផ្ទាល់</th>
                                        <th>ឯកសារយោង</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_performance">
                                    @foreach ($data->titles as $item)
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <input style="background: #efa781"  type="text" class="form-control" value="{{ $item->title ?? '' }}" required>
                                            </td>
                                            {{-- <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td> --}}
                                        </tr>

                                        @foreach ($item->purposes as $purposeItem)
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <input style="background: #f0cc9b" type="text" class="form-control" value="{{ $purposeItem->name ?? '' }}" required>
                                                </td>
                                                {{-- <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td> --}}
                                            </tr>

                                            @foreach ($purposeItem->performanceDetail as $Detailitem)
                                                @php
                                                    $hasFile = $Detailitem->reference->isNotEmpty();
                                                    $file = $hasFile ? $Detailitem->reference->first() : null;
                                                    $file_name = $file ? $file->reference : '';
                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        <textarea rows="7" class="form-control" placeholder="Enter text here" required>{{$Detailitem->key_kpi}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="7" class="form-control" placeholder="Enter text here" required>{{$Detailitem->action_plan}}</textarea>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $typeArray = explode('_', $Detailitem->goal_type);
                                                            $type = $typeArray[0] ?? 'number';
                                                            $symbol = '';
                                                            if ($type == 'percent') {
                                                                $symbol = '%';
                                                            } elseif ($type == 'currency') {
                                                                $symbol = '$';
                                                            } elseif ($type == 'number') {
                                                                $symbol = '';
                                                            }
                                                        @endphp

                                                        @foreach ($Detailitem->performanceGoals as $key => $pGoal)
                                                            <span>
                                                                {{ "ពិន្ទុ " . ($key + 1) . " = " . $pGoal->from . $symbol . " ដល់ " . $pGoal->to . $symbol }}
                                                            </span><br>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" step="any" class="form-control" id="progress" name="progress[]" value="{{$Detailitem->progress}}" readonly>
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
                                                    <td>
                                                        <div class="d-flex float-end">
                                                            <span class="ml-2 text-name-reference" style="display: {{ $hasFile ? 'block' : 'none' }}; margin-right: 10px;">{{ $file_name }}</span>
                                                            <a href="{{ $hasFile ? url('/performance/view-reference/'.$file->id) : 'javascript:void(0)' }}"
                                                                class="btn btn-info btn-sm viewReference"
                                                                target="_blank"
                                                                style="display: {{ $hasFile ? 'block' : 'none' }}; margin-right: 2px;">
                                                                    <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="submit-section mb-2">
                    <a href="{{ url('performance-appraisal') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(document).ready(function () {


    });
</script>
