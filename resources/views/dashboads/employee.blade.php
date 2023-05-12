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
                        <h3>Welcome, {{Auth::user()->employee_name_en}}</h3>
                        <p>{{Carbon\Carbon::parse(Auth::user()->date_of_commencement)->format('d M Y')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                        <div class="dash-widget-info">
                            <h3>22</h3>
                            <span>Total Leaves</span>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                        <div class="dash-widget-info">
                            <h3>37</h3>
                            <span>Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <section class="dash-section">
                    <h1 class="dash-sec-title">Today</h1>
                    <div class="dash-sec-content">
                        <div class="dash-info-list">
                            <a href="#" class="dash-card text-danger">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-hourglass-o"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>Richard Miles is off sick today</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar">
                                            <img src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-09.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dash-info-list">
                            <a href="#" class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-suitcase"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>You are away today</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar">
                                            <img src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-02.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dash-info-list">
                            <a href="#" class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-building-o"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>You are working from home today</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar">
                                            <img src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-02.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
                
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="dash-sidebar">
                    <section>
                        <h5 class="dash-title">Projects</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>71</h4>
                                        <p>Total Tasks</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>14</h4>
                                        <p>Pending Tasks</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <div class="dash-stats-list">
                                        <h4>2</h4>
                                        <p>Total Projects</p>
                                    </div>
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
