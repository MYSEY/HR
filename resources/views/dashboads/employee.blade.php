@extends('layouts.master')
@section('content')
    <div class="">
        @if ($LeaveRequest)
            <div class="row">
                <div class="col-md-12">
                    <div class="employee-alert-box">
                        <div class="alert alert-outline-success alert-dismissible fade show">
                            <div class="employee-alert-request">
                                <i class="far fa-circle-question"></i>Your Leave Request on <span>“{{ Carbon\Carbon::parse($LeaveRequest->created_at)->format('F d M Y') }}”</span> has been {{$LeaveRequest->status}}!!!
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card employee-welcome-card flex-fill">
                    <div class="card-body">
                        <div class="welcome-info">
                            <div class="welcome-content">
                                <h4>@lang('lang.welcome'), {{ Helper::getLang() == 'en' ? Auth::user()->employee_name_en : Auth::user()->employee_name_kh }}</h4>
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
                            <a href="{{route('employee.profile',Auth::user()->id)}}" class="btn">@lang('lang.view_profile')</a>
                            <a class="btn" href="{{ url('leaves/employee') }}">Apply Leave</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="statistic-header">
                            <h4>Carried forward &amp; Leaves</h4>
                        </div>
                        <div class="attendance-list">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="attendance-details">
                                        <h5 >@lang('lang.year') 1 = {{ number_format($data->year_1 ?? 0) }} Days</h5>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="attendance-details">
                                        <h5 >@lang('lang.year') 2 = {{ number_format($data->year_2 ?? 0) }} Days</h5>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="attendance-details">
                                        <h5 >@lang('lang.year') 3 = {{ number_format($data->year_3 ?? 0) }} Days</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="statistic-header">
                            <h4>Leave Type</h4>
                        </div>
                        <p><i class="fa fa-dot-circle-o text-secondary me-2"></i>@lang('lang.annual_leave')<span
                            class="float-end">{{ number_format($data->total_annual_leave ?? 0, 1) }} Days</span></p>
                        <p><i class="fa fa-dot-circle-o text-danger me-2"></i>@lang('lang.sick_leave')<span
                            class="float-end">{{ number_format($data->total_sick_leave ?? 0, 1) }} Days</span></p>
                        <p><i class="fa fa-dot-circle-o text-info me-2"></i>@lang('lang.special_leave')<span
                            class="float-end">{{ number_format($data->total_special_leave ?? 0, 1) }} Days</span></p>
                        <p><i class="fa fa-dot-circle-o text-danger me-2"></i>@lang('lang.unpaid_leave') <span
                            class="float-end">{{ $data->total_unpaid_leave ?? 0 }} Days</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="statistic-header">
                            <h4>@lang('lang.expense_request')</h4>
                        </div>
                        <div class="attendance-list">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="attendance-details">
                                        <h4 class="text-info"> 
                                            {{ isset($groupedExpenseCounts["pending"]) ? $groupedExpenseCounts["pending"] : 0 }}
                                        </h4>
                                        <p>@lang('lang.pending_review')</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="attendance-details">
                                        <h4 class="text-success">
                                            {{ isset($groupedExpenseCounts["pending_approve"]) ? $groupedExpenseCounts["pending_approve"] : 0 }}
                                        </h4>
                                        <p>@lang('lang.pending_approved')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="view-attendance">
                            <a href="{{ url('/expense-request/list') }}">
                                <i class="fa fa-arrow-right"></i> @lang('lang.click_to') @lang('lang.review') @lang('lang.or') @lang('lang.approval')</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        {{-- <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="card employee-welcome-card flex-fill">
                            <div class="card-body">
                                <div class="welcome-info">
                                    <div class="welcome-content">
                                        <h4>@lang('lang.welcome'), {{ Helper::getLang() == 'en' ? Auth::user()->employee_name_en : Auth::user()->employee_name_kh }}</h4>
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
                                    <a href="{{route('employee.profile',Auth::user()->id)}}" class="btn">@lang('lang.view_profile')</a>
                                    <a class="btn" href="{{ url('leaves/employee') }}">Apply Leave</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="dash-widget-info">
                                            <h3>{{ number_format($data->total_annual_leave ?? 0) }}</h3>
                                            <span>@lang('lang.annual_leave')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="dash-widget-info">
                                            <h3>{{ number_format($data->total_sick_leave ?? 0) }}</h3>
                                            <span>@lang('lang.sick_leave')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="dash-widget-info">
                                            <h3>{{ number_format($data->total_special_leave ?? 0) }}</h3>
                                            <span>@lang('lang.special_leave')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="dash-widget-info">
                                            <h3>{{ $data->total_unpaid_leave ?? 0 }}</h3>
                                            <span>@lang('lang.unpaid_leave')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
@include('includs.script')
