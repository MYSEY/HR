@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="welcome-box">
                    <div class="welcome-img">
                        @if (Auth::user()->profile != null)
                            <img alt="" src="{{ asset('/uploads/images/' . Auth::user()->profile) }}">
                        @else
                            <img alt="" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                        @endif
                    </div>
                    <div class="welcome-det">
                        <h3>Welcome, {{ Auth::user()->employee_name_en }}</h3>
                        <p>{{ Carbon\Carbon::parse(Auth::user()->date_of_commencement)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>22</h3>
                            <span>Annual Leave</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>3</h3>
                            <span>Medical Leave</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>4</h3>
                            <span>Other Leave</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>5</h3>
                            <span>Remaining Leave</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="dash-sidebar">
                    <section>
                        <h5 class="dash-title">Your Leave</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>4.5</h4>
                                        <p>Leave Taken</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>12</h4>
                                        <p>Remaining</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <a class="btn btn-primary" href="#">Apply Leave</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
