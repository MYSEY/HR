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
                    {{-- action="{{url('fn/level-reviewer')}}" --}}
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                             <div class="form-group">
                                <label>@lang('lang.from_location') <span class="text-danger">*</span></label>
                                <select class="form-control data_required" id="from_location" name="from_location" required>
                                    <option value="" selected> </option>
                                    <option value="1"> Branch </option>
                                    <option value="2"> Department </option>
                                </select>
                            </div>
                             <div class="form-group" id="view_model_review">
                                <label>@lang('lang.model_review')</label>
                                <select class="form-control model_review" id="model_review" name="model_review">
                                    <option value="" selected> </option>
                                    @foreach ($departments as $item)
                                        <option value="{{$item->id}}">{{$item->name_english}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.request_type') <span class="text-danger">*</span></label>
                                <select class="form-control data_required" id="request_type" name="request_type" required>
                                    <option value="" selected> </option>
                                    <option value="0">@lang('lang.general_expense')</option>
                                    <option value="2">@lang('lang.tax_expense')</option>
                                    <option value="1">@lang('lang.special_expense')</option>
                                </select>
                            </div>
                            <div class="reference_type" style="display: none">
                                <div class="form-group">
                                    <label>@lang('lang.reference') @lang('lang.type') <span class="text-danger">*</span></label>
                                    <select class="form-control" id="reference_type" name="reference_type">
                                        <option value="" selected> </option>
                                        <option value="1">@lang('lang.regular_expense')</option>
                                        <option value="2">@lang('lang.irregular_expense')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="focus-label">@lang('lang.from_amount')</label>
                                <input type="text" value="" id="from_amount" name="from_amount" class="form-control floating">
                            </div>
                            <div class="form-group">
                                <label class="focus-label">@lang('lang.to_amount')<span class="text-danger">*</span></label>
                                <input type="text" value="" id="to_amount" name="to_amount" class="form-control floating data_required" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.description')</label>
                                <textarea type="text" rows="3" class="form-control" name="description" id="description" value="{{old('description')}}"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <label class="text-danger">Please to setup level review</label>
                            <div class="form-scroll">
                                <div class="row" id="education-container-repeatable-elements">
                                    <div class="education-repeatable-element repeatable-element">
                                        <div class="card">
                                            <div class="card-body">
                                                <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o"></i></a>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label>@lang('lang.type') <span class="text-danger">*</span></label>
                                                            <select class="form-control level_type data_required" name="type[]" required>
                                                                <option value="" selected> </option>
                                                                <option value="1">@lang('lang.review') 1</option>
                                                                <option value="2">@lang('lang.review') 2</option>
                                                                <option value="3">@lang('lang.review') 3</option>
                                                                <option value="4">@lang('lang.review') 4</option>
                                                                <option value="5">@lang('lang.review') 5</option>
                                                                <option value="6">@lang('lang.review') 6</option>
                                                                <option value="7">@lang('lang.review') 7</option>
                                                                <option value="8">@lang('lang.review') 8</option>
                                                                <option value="9">@lang('lang.review') 9</option>
                                                                <option value="10">@lang('lang.review') 10</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('lang.department_review') <span class="text-danger">*</span></label>
                                                            <select class="form-control department_review" name="department_review">
                                                                <option value="" selected> </option>
                                                                @foreach ($departments as $item)
                                                                    <option value="{{$item->id}}">{{$item->name_english}}</option>
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
                                                                    @foreach ($positions as $item)
                                                                        <option value="{{$item->id}}">{{$item->name_english}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-more float-end">
                                <a class="add-repeatable-element-button" id="btnAddMore"><i class="fa fa-plus-circle"></i> @lang('lang.add_more')</a>
                            </div>
                        </div>
                    </div><br>
                    <div class="submit-section">
                        <a href="{{url('fn/level-reviewer')}}"  class="btn btn-secondary">@lang('lang.cancel')</a>
                        <button type="button" class="btn btn-primary submit-btn">
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
    const submitUrl = "{{ url('fn/level-reviewer/create') }}";
    const listUrl = "{{ url('fn/level-reviewer') }}";
    const buttonSubmit = "submit-btn";
</script>
<script src="{{asset('/admin/component-js/fn_level_review.js')}}"></script>