@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Generate Leave All Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Generate Leave All Employee</li>
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
                                        <label>Annual Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="annual_leave" value="{{$AnnualLeave->default_day}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sick Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="sick_leave" value="{{$SickLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Special Leave <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="special_leave" value="{{$SpecialLeave->default_day}}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
