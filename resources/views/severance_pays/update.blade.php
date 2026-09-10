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
                <h3 class="page-title">@lang('lang.edit_severance_pay')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.edit_severance_pay')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{url('severance/update')}}" method="POST" enctype="multipart/form-data"  class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.employee_name') @lang('lang.en')<span class="text-danger">*</span></label>
                                    <input class="form-control @error('employee_name_en') is-invalid @enderror" type="text" id="employee_name_en" name="employee_name_en" value="{{$data->employee_name_en}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.employee_name') @lang('lang.kh')<span class="text-danger">*</span></label>
                                    <input class="form-control @error('employee_name_kh') is-invalid @enderror" type="text" id="employee_name_kh" name="employee_name_kh" value="{{$data->employee_name_kh}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.employee_id')</label>
                                    <input type="text" class="form-control" id="number_employee" readonly name="number_employee" value="{{$data->number_employee}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.basic_salary')<span class="text-danger">*</span></label>
                                    <input class="form-control @error('basic_salary') is-invalid @enderror" type="text" readonly id="basic_salary" name="basic_salary" value="{{$data->basic_salary}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.base_salary_received')<span class="text-danger">*</span></label>
                                    <input class="form-control @error('total_gross_salary') is-invalid @enderror" type="text" readonly id="total_gross_salary" name="total_gross_salary" value="{{$data->total_gross_salary}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.position')</label>
                                    <input type="text" class="form-control" id="position_name_english" name="position_name_english" value="{{$data->position_name_english}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.total_fdc1')<span class="text-danger">*</span></label>
                                    <input class="form-control @error('total_fdc1') is-invalid @enderror" type="text" id="total_fdc1" name="total_fdc1" value="{{$data->total_fdc1}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.type_fdc1')</label>
                                    <input type="text" class="form-control" id="type_fdc1" readonly name="type_fdc1" value="{{$data->type_fdc1}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.branch')</label>
                                    <input type="text" class="form-control" id="branch_name_en" name="branch_name_en" value="{{$data->branch_name_en}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.total_fdc2')</label>
                                    <input class="form-control @error('total_fdc2') is-invalid @enderror" type="text" id="total_fdc2" name="total_fdc2" value="{{$data->total_fdc2}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.type_fdc2')</label>
                                    <input type="text" class="form-control" id="type_fdc2" readonly name="type_fdc2" value="{{$data->type_fdc2}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">@lang('lang.department')</label>
                                    <input type="text" class="form-control" id="depart_name_en" name="depart_name_en" value="{{$data->depart_name_en}}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="submit-section">
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="hidden" name="employee_id" value="{{$data->employee_id}}">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                    @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.submit')</span>
                            </button>
                            <a href="{{ url('severance-pay') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection