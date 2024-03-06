@extends('layouts.master')
@section('content')
    <div class="">
        {{-- <div class="row">
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
        </div> --}}

        {{-- <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>{{ number_format($data->total_annual_leave ?? 0) }}</h3>
                            <span>@lang('lang.annual_leave')</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>{{ number_format($data->total_sick_leave ?? 0) }}</h3>
                            <span>@lang('lang.sick_leave')</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>{{ number_format($data->total_special_leave ?? 0) }}</h3>
                            <span>@lang('lang.special_leave')</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <div class="dash-widget-info">
                            <h3>{{ $data->total_unpaid_leave ?? 0 }}</h3>
                            <span>@lang('lang.unpaid_leave')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="row">
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
                                    <a class="btn btn-primary" href="{{ url('leaves/employee') }}">Apply Leave</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="employee-alert-box">
                    <div class="alert alert-outline-success alert-dismissible fade show">
                        <div class="employee-alert-request">
                            <i class="far fa-circle-question"></i>Your Leave Request on <span>“24th April 2024”</span> has been Approved!!!
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="card employee-welcome-card flex-fill">
                            <div class="card-body">
                                <div class="welcome-info">
                                    <div class="welcome-content">
                                        <h4>@lang('lang.welcome'), {{ Auth::user()->employee_name_en }}</h4>
                                        <p>@lang('lang.join_date') <span>{{ Carbon\Carbon::parse(Auth::user()->date_of_commencement)->format('d M Y') }}</span></p>
                                    </div>
                                    <div class="welcome-img">
                                        @if (Auth::user()->profile != null)
                                            <img alt="" src="{{ asset('/uploads/images/' . Auth::user()->profile) }}">
                                        @else
                                            <img alt="" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="welcome-btn">
                                    <a href="{{route('employee.profile',$data->employee_id)}}" class="btn">View Profile</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card info-card flex-fill">
                            <div class="card-body">
                                <h4>Upcoming Holidays</h4>
                                <div class="holiday-details">
                                    <div class="holiday-calendar">
                                        <div class="holiday-calendar-icon">
                                            <img src="https://smarthr.dreamstechnologies.com/laravel/template/public/assets/img/icons/holiday-calendar.svg"
                                                alt="Icon">
                                        </div>
                                        <div class="holiday-calendar-content">
                                            <h6>Ramzan</h6>
                                            <p>Mon 20 May 2024</p>
                                        </div>
                                    </div>
                                    <div class="holiday-btn">
                                        <a href="{{url('holidays')}}" class="btn">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <div class="statistic-header">
                                    <h4>@lang('lang.leave')</h4>
                                    <div class="dropdown statistic-dropdown">
                                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);"
                                            aria-expanded="false">
                                            2024
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                2025
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                2026
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                2027
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="attendance-list">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="dash-widget-info">
                                                <h3>{{ number_format($data->total_annual_leave ?? 0) }}</h3>
                                                <span>@lang('lang.annual_leave')</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            {{-- <div class="attendance-details">
                                                <h4 class="text-pink">5.5</h4>
                                                <p>Leaves Taken</p>
                                            </div> --}}
                                            <div class="dash-widget-info">
                                                <h3>{{ number_format($data->total_sick_leave ?? 0) }}</h3>
                                                <span>@lang('lang.sick_leave')</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="attendance-details">
                                                {{-- <h4 class="text-purple">0</h4>
                                                <p>Pending Approval</p> --}}
                                                <div class="dash-widget-info">
                                                    <h3>{{ number_format($data->total_special_leave ?? 0) }}</h3>
                                                    <span>@lang('lang.special_leave')</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="attendance-details">
                                                <div class="dash-widget-info">
                                                    <h3>{{ $data->total_unpaid_leave ?? 0 }}</h3>
                                                    <span>@lang('lang.unpaid_leave')</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="view-attendance">
                                    <a class="btn btn-primary" href="{{ url('leaves/employee') }}">Apply Leave</a>
                                    {{-- <a
                                        href="https://smarthr.dreamstechnologies.com/laravel/template/public/leaves-employee">
                                        Apply Leave <i class="fe fe-arrow-right-circle"></i>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
