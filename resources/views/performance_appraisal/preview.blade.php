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
                                        <th>ទម្ងន់ (Weight %)</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_performance">
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
                                            
                                            @foreach ($purposeItem->performanceAppraiDetail as $Detailitem)
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
