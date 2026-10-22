@extends('layouts.master')

@section('content')
<style>
    .card_background_color {
        background-color: #f8f9fa !important;
    }
    .select2-container {
        width: 100% !important;
        display: block !important;
    }
    .select2-container--open {
        z-index: 99999 !important;
    }
    
</style>

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">@lang('lang.add_new_rental')</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                <li class="breadcrumb-item active">@lang('lang.add_new_rental')</li>
            </ul>
        </div>
    </div>
</div>

{{-- Form តែមួយ --}}
<form id="mainRentalForm">
    @csrf
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group employee-form-group-select2">
                <label>@lang('lang.employee')</label>
                <select class="form-control select2 hr-select2-option emp_required requered m_clear" id="employee_id" name="employee_id" required>
                    <option selected disabled value="">--- @lang('lang.select') ---</option>
                    @foreach ($employees as $item)
                        <option value="{{ $item->id }}">{{ $item->employee_name_en }}</option>
                    @endforeach
                </select>
            </div>
            <!-- 2. Select Form To Add Box (ដាក់នៅពីក្រោម Employee Select) -->
            <div class="form-group" id="select_form_wrapper" style="display: none;">
                <label class="text-primary font-weight-bold">
                    <i class="fa fa-plus-circle"></i> ជ្រើសរើស Form បន្ថែម៖
                </label>
                <div class="input-group">
                    <select class="form-control me-1" id="select_additional_form">
                        <option value="" selected disabled>--- Select Form ---</option>
                    </select>
                    <div class="input-group-append mt-1">
                        <button type="button" class="btn btn-success" id="btn_add_selected_form">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    {{-- Container Dynamic HTML --}}
                    <div id="dynamic_form_container">
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i> Loading Form...
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <div class="submit-section">
        <a href="{{ url('motor-rentel/list') }}" class="btn btn-secondary">@lang('lang.cancel')</a>
        <button type="button" class="btn btn-primary submit-btn">
            <span class="btn-text-save">@lang('lang.save')</span>
            <span id="btn-save-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
        </button>
    </div>
</form><br>

@include('includs.script')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/jquery-datepicker-1.11.4-ui.css') }}">
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script>
    const appBaseUrl   = "{{ url('/') }}";
    const submitUrl = "{{ url('motor-rentel/store') }}";
    const listUrl = "{{ url('motor-rentel/list') }}";
    const buttonSubmit = "submit-btn";
</script>

<script src="{{ asset('/admin/component-js/employee_rental.js') }}"></script>
@endsection