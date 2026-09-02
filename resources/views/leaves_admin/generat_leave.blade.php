@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.generate_leave_all_employee')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.generate_leave_all_employee')</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="card">
            <div class="card-body">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="{{url('/generat/leaves/create')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.annual_leave') <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="annual_leave" value="{{$AnnualLeave->default_day}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.sick_leave') <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="sick_leave" value="{{$SickLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.special_leave') <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="special_leave" value="{{$SpecialLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">@lang('lang.submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
