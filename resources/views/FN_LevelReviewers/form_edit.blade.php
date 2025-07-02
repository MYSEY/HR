@extends('layouts.master')
<style>
    .card_background_color{
        background-color: #f8f9fa !important;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.level_review')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.level_review')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-pane fade active show" id="bank_statutory" role="tabpanel">
        <div class="card card_background_color">
            <div class="card-body">
                <form id="levelReviewerForm"  enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                     <input type="text" hidden value="{{$datas[0]->group_id}}" id="group_id">
                    <div class="row">
                        <div class="col-sm-4">
                             <div class="form-group">
                                <label>@lang('lang.from_location') <span class="text-danger">*</span></label>
                                <select class="form-control data_required" id="from_location" name="from_location" required>
                                    <option value="1" <?= ($datas[0]->from_location == '1') ? 'selected' : '' ?>>Branch</option>
                                    <option value="2" <?= ($datas[0]->from_location == '2') ? 'selected' : '' ?>>Department</option>
                                </select>
                            </div>
                             <div class="form-group" id="view_model_review" style="<?= ($datas[0]->from_location == '2') ? '' : 'display: none;' ?>">
                                <label>@lang('lang.model_review')</label>
                                <select class="form-control model_review" id="model_review" name="model_review">
                                    <option value="" selected> </option>
                                    @foreach ($departments as $item)
                                        <option value="{{$item->id}}" <?= ($datas[0]->model_review == $item->id) ? 'selected' : '' ?>>{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.request_type') <span class="text-danger">*</span></label>
                                <select class="form-control data_required" id="request_type" name="request_type" required>
                                    <option value="0" <?= ($datas[0]->request_type == '0') ? 'selected' : '' ?>>@lang('lang.general_expense')</option>
                                    <option value="2" <?= ($datas[0]->request_type == '2') ? 'selected' : '' ?>>@lang('lang.tax_expense')</option>
                                    <option value="1" <?= ($datas[0]->request_type == '1') ? 'selected' : '' ?>>@lang('lang.special_expense')</option>
                                </select>
                            </div>
                            <div class="reference_type" style="<?= ($datas[0]->request_type == '0') ? '' : 'display: none;' ?>">
                                <div class="form-group">
                                    <label>@lang('lang.reference') @lang('lang.type') <span class="text-danger">*</span></label>
                                    <select class="form-control" id="reference_type" name="reference_type">
                                        <option value="1" <?= ($datas[0]->reference_type == '1') ? 'selected' : '' ?>>@lang('lang.regular_expense')</option>
                                        <option value="2" <?= ($datas[0]->reference_type == '2') ? 'selected' : '' ?>>@lang('lang.irregular_expense')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="focus-label">@lang('lang.from_amount')</label>
                                <input type="text" value="{{$datas[0]->from_amount}}" id="from_amount" name="from_amount" class="form-control floating">
                            </div>
                            <div class="form-group">
                                <label class="focus-label">@lang('lang.to_amount')<span class="text-danger">*</span></label>
                                <input type="text" value="{{$datas[0]->to_amount}}" id="to_amount" name="to_amount" class="form-control floating data_required" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.description')</label>
                                <textarea type="text" rows="3" class="form-control" name="description" id="description" value="{{old('description')}}">{{$datas[0]->description}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <label class="text-danger">Please to setup level review</label>
                            <div class="form-scroll">
                                <div class="row" id="education-container-repeatable-elements">
                                    @foreach ($datas as $key=>$item)
                                        @php
                                            $position_review = json_decode($item->position_review, true);
                                            $selected_position_ids = array_column($position_review, 'id');
                                            $requestType = [
                                                ['id' => '1', 'value' => __("lang.review")],
                                                ['id' => '2', 'value' => __("lang.review")],
                                                ['id' => '3', 'value' => __("lang.review")],
                                                ['id' => '4', 'value' => __("lang.review")],
                                                ['id' => '5', 'value' => __("lang.review")],
                                                ['id' => '6', 'value' => __("lang.review")],
                                                ['id' => '7', 'value' => __("lang.review")],
                                                ['id' => '8', 'value' => __("lang.review")],
                                                ['id' => '9', 'value' => __("lang.review")],
                                                ['id' => '10', 'value' => __("lang.review")],
                                            ];
                                        @endphp
                                        <div class="education-repeatable-element repeatable-element">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="text" hidden value="{{$item->id}}" class="id_edit">
                                                    <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o"></i></a>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                        <div class="form-group">
                                                                <label>@lang('lang.type') <span class="text-danger">*</span></label>
                                                                <select class="form-control level_type data_required" name="type[]" required>
                                                                    @foreach ($requestType as $rev)
                                                                        <option value="{{ $rev['id'] }}" {{ ($item->type == $rev['id']) ? 'selected' : '' }}>
                                                                            {{ $rev['id'] . ' ' . $rev['value'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('lang.department_review') <span class="text-danger">*</span></label>
                                                                <select class="form-control department_review" name="department_review">
                                                                    <option value="" selected> </option>
                                                                    @foreach ($departments as $dep)
                                                                        <option value="{{$dep->id}}" <?= ($item->department_review == $dep->id) ? 'selected' : '' ?>>{{$dep->name_english}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div id="position-review-container">
                                                                <div class="position-review-group">
                                                                    <label>@lang('lang.position_review') <span class="text-danger">*</span></label>
                                                                    <select class="select form-control position-review-select data_required" name="position_review" multiple="" required>
                                                                        <option value=""> </option>
                                                                        @foreach ($positions as $pos)
                                                                            <option value="{{$pos->id}}"  {{ in_array($pos->id, $selected_position_ids) ? 'selected' : '' }}>{{$pos->name_english}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="add-more float-end">
                                <a class="add-repeatable-element-button" id="btnAddMore"><i class="fa fa-plus-circle"></i> @lang('lang.add_more')</a>
                            </div>
                        </div>
                    </div><br>
                    <div class="submit-section">
                        <a href="{{url('fn/level-reviewer')}}"  class="btn btn-secondary">@lang('lang.cancel')</a>
                        <button type="button" class="btn btn-primary submit-update-btn">
                            <span class="btn-text-save">@lang('lang.submit')</span>
                            <span id="btn-save-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                        </button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{asset('/admin/js/noty.js')}}"></script>

<script>
    const submitUrl = "{{ url('/fn/level-reviewer/update') }}";
    const listUrl = "{{ url('/fn/level-reviewer') }}";
    const buttonSubmit = "submit-update-btn";
</script>
<script src="{{asset('/admin/component-js/fn_level_review.js')}}"></script>