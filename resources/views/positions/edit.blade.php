@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Position</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url('position')}}">Position / edit</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="modal-body">
                    <form action="{{route('position.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Name (KH) <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name_khmer" value="{{$data->name_khmer}}">
                            <p class="text-danger">{!! $errors->first('name_khmer') !!}</p>
                        </div>
                        <div class="form-group">
                            <label>Name (EN) <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name_english" value="{{$data->name_english}}">
                            <p class="text-danger">{!! $errors->first('name_english') !!}</p>
                        </div>
                        <div class="submit-section">
                            <a href="{{url('/position')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection