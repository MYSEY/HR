@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Branch</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url('branch')}}">Branch</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="modal-body">
                    <form action="/branch" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Name (KH) <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="branch_name_kh">
                            <p class="text-danger">{!! $errors->first('branch_name_kh') !!}</p>
                        </div>
                        <div class="form-group">
                            <label>Name (EN) <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="branch_name_en">
                            <p class="text-danger">{!! $errors->first('branch_name_en') !!}</p>
                        </div>
                        <div class="submit-section">
                            <a href="{{url('/branch')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection