<!DOCTYPE html>
<!-- saved from url=(0065)https://smarthr.dreamguystech.com/laravel/template/public/profile -->
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-layout-mode="orange" data-layout-width="fluid" data-layout-position="fixed"
    data-layout-style="default">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>HRMS</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/admin/img/logo/commalogo1.png') }}">
    {{-- <link rel="shortcut icon" type="image/x-icon" href="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/favicon.png"> --}}

    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/material.css') }}">

    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('admin/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('admin/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('admin/css/daterangepicker.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/daterangepicker/daterangepicker.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('admin/css/summernote-bs4.css') }}"> --}}

    <link href="{{ asset('admin/css/morris.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('admin/css/fullcalendar.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/noty.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('admin/css/noty.css.map')}}"> --}}
    <link rel="stylesheet" href="{{ asset('admin/css/mint.css')}}">
    {{-- message toastr --}}
	<link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>

<body>

    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="#" class="logo">
                    <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" width="100" height="100" alt="">
                </a>
                <a href="#" class="logo2">
                    <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" width="100" height="100" alt="">
                </a>
            </div>

            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a id="mobile_btn" class="mobile_btn" href=""><i class="fa fa-bars"></i></a>

            <ul class="nav user-menu">

                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="" role="button">
                        <img src="{{asset('/admin/img/us.png')}}" alt="" height="20">
                        <span>English</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{asset('/admin/img/us.png')}}" alt="" height="16"> English
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{asset('/admin/img/flag-of-cambodia-logo.png')}}" alt="" height="16"> Khmer
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    {{-- <a href="" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <i class="fa fa-bell-o"></i> <span class="badge rounded-pill">3</span>
                    </a> --}}
                    {{-- <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="{{asset('/admin/img/avatar-02.jpg')}}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">John Doe</span> added new task 
                                                    <span class="noti-title">Patient appointment booking</span>
                                                </p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="">View all Notifications</a>
                        </div>
                    </div> --}}
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="avatar">
                            @if (Auth::user()->profile==null)
                                <img alt="avatar" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                            @else
                                <img src="{{asset('/uploads/images/'.Auth::user()->profile)}}" alt="">
                            @endif
                            <span class="status online"></span></span>
                        <span>{{Auth::user()->employee_name_en}}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('/employee/profile/'.Auth::user()->id)}}">My Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{url('/employee/profile/'.Auth::user()->id)}}">My Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
       
        <div class="sidebar" id="sidebar">
            <div class="slimScrollDiv" style="position: relative; overflow:hidden; width: 100%; height: 346px;">
                <div class="sidebar-inner slimscroll" style="overflow: auto; width: 100%; height: 346px;">
                    <div id="sidebar-menu" class="sidebar-menu">
                        <ul class="sidebar-vertical" >
                            @foreach (menu() as $key=>$menu)
                                @if (isset($menu['child']))
                                    @if (RolePermission($menu['table'],$menu['permission']))
                                        <li class="menu-title">
                                            <span>{{$menu['name']}}</span>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" data-toggle="collapse" href="#dropdown-{{$key}}">
                                                {!! $menu['icon'] !!}
                                                <span class="sidebar-menu-text">{{$menu['value']}}</span>
                                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                            </a>
                                            <ul style="display: none;">
                                                @foreach ($menu['child'] as $sub_menu)
                                                    @if (RolePermission($sub_menu['table'],$sub_menu['permission']))
                                                        <li class="sidebar-menu-item">
                                                            <a class="sidebar-menu-button" href="{{url($sub_menu['url'])}}">
                                                                <span class="sidebar-menu-text">{{$sub_menu['value']}}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @else
                                    @if (RolePermission($menu['table'],$menu['permission']))
                                        <li class="menu-title">
                                            <span>{{$menu['name']}}</span>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="{{url($menu['url'])}}">
                                                {!! $menu['icon'] !!}
                                                <span class="sidebar-menu-text">{{$menu['value']}}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="slimScrollBar" style="background: rgb(204, 204, 204); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 68.5659px;"></div>
                <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
            </div>
        </div>
        <div class="page-wrapper" style="min-height: 406px;">
            <div class="content container-fluid">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

   

    <script src="{{asset('/admin/js/jquery.min.js.download')}}"></script>

    <script src="{{asset('/admin/js/bootstrap.bundle.min.js.download')}}"></script>

    <script src="{{asset('/admin/js/jquery.slimscroll.min.js.download')}}"></script>
    <script src="{{asset('/admin/js/moment.min.js.download')}}"></script>
    <script src="{{asset('/admin/js/jquery-ui.min.js.download')}}"></script>

    <script src="{{asset('/admin/js/select2.min.js.download')}}"></script>

    <script src="{{asset('/admin/js/jquery.dataTables.min.js.download')}}"></script>
    <script src="{{asset('/admin/js/dataTables.bootstrap4.min.js.download')}}"></script>

    <script src="{{asset('/admin/js/bootstrap-datetimepicker.min.js.download')}}"></script>
    <script src="{{asset('/admin/js/daterangepicker.js.download')}}"></script>

    <script src="{{asset('/admin/js/bootstrap-tagsinput.min.js.download')}}"></script>

    <script src="{{asset('/admin/js/sticky-kit.min.js.download')}}"></script>

    <script src="{{asset('/admin/js/summernote-bs4.js.download')}}"></script>

    <script src="{{asset('/admin/js/fullcalendar.min.js.download')}}"></script>
    <script src="{{asset('/admin/js/jquery.fullcalendar.js.download')}}"></script>

    <script src="{{asset('/admin/js/jquery.maskedinput.js.download')}}"></script>

    <script src="{{asset('/admin/js/task.js.download')}}"></script>

    <script src="{{asset('/admin/js/layout.js.download')}}"></script>
    <script src="{{asset('/admin/js/theme-settings.js.download')}}"></script>
    <script src="{{asset('/admin/js/greedynav.js.download')}}"></script>

    <script src="{{asset('/admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/admin/js/app.js.download')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{asset('/admin/js/chart_board.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script type="text/javascript" src="{{asset('/admin/js/noty.js')}}"></script>
    <script type="text/javascript" src="{{asset('/admin/js/noty.min.js')}}"></script>

    <div class="sidebar-overlay"></div>
</body>

</html>
