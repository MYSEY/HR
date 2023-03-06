<!DOCTYPE html>
<!-- saved from url=(0065) -->
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="orange" data-layout-width="fluid" data-layout-position="fixed" data-layout-style="default">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>HRMS Admin</title>

    <link rel="shortcut icon" type="image/x-icon" href="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/favicon.png">

    <link rel="stylesheet" href="{{asset('/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/css/material.css')}}">

    <link href="{{asset('/admin/css/select2.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('/admin/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('/admin/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('/admin/css/daterangepicker.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('/admin/css/bootstrap-tagsinput.css')}}">

    <link rel="stylesheet" href="{{asset('/admin/css/summernote-bs4.css')}}">

    <link href="{{asset('/admin/css/morris.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('/admin/css/fullcalendar.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('/admin/css/style.css')}}">
    {{-- message toastr --}}
	<link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">
</head>

<body>

    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="" class="logo">
                    <img src="{{asset('/admin/img/logo.png')}}" width="40" height="40" alt="">
                </a>
                <a href="" class="logo2">
                    <img src="{{asset('/admin/img/logo2.png')}}" width="40" height="40" alt="">
                </a>
            </div>

            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <div class="page-title-box">
                <h3>CAMMA HR</h3>
            </div>

            <a id="mobile_btn" class="mobile_btn"
                href="sidebar"><i class="fa fa-bars"></i>
            </a>

            <ul class="nav user-menu">
                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="">
                            <input class="form-control" type="text" placeholder="Search here">
                            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                        href="" role="button">
                        <img src="{{asset('/admin/img/us.png')}}" alt="" height="20">
                        <span>English</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{asset('/admin/img/us.png')}}" alt="" height="16"> English
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{asset('/admin/img/fr.png')}}" alt="" height="16"> French
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{asset('/admin/img/es.png')}}" alt="" height="16"> Spanish
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{asset('/admin/img/de.png')}}" alt="" height="16"> German
                        </a>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a href="" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <i class="fa fa-bell-o"></i> <span class="badge rounded-pill">3</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
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
                                                <p class="noti-details"><span class="noti-title">John Doe</span> added
                                                    new task <span class="noti-title">Patient appointment booking</span>
                                                </p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="{{asset('/admin/img/avatar-03.jpg')}}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Tarah Shropshire</span>
                                                    changed the task name <span class="noti-title">Appointment booking
                                                        with payment gateway</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="{{asset('/admin/img/avatar-06.jpg')}}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Misty Tison</span>
                                                    added <span class="noti-title">Domenic Houston</span> and <span
                                                        class="noti-title">Claire Mapes</span> to project <span
                                                        class="noti-title">Doctor available module</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="{{asset('/admin/img/avatar-17.jpg')}}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Rolland Webber</span>
                                                    completed task <span class="noti-title">Patient and Doctor video
                                                        conferencing</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="{{asset('/admin/img/avatar-13.jpg')}}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span>
                                                    added new task <span class="noti-title">Private chat module</span>
                                                </p>
                                                <p class="noti-time"><span class="notification-time">2 days ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="">View all Notifications</a>
                        </div>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a href=""
                        class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <i class="fa fa-comment-o"></i> <span class="badge rounded-pill">8</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Messages</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">
                                                    <img alt="" src="{{asset('/admin/img/avatar-09.jpg')}}">
                                                </span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Richard Miles </span>
                                                <span class="message-time">12:28 AM</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">
                                                    <img alt="" src="{{asset('/admin/img/avatar-02.jpg')}}">
                                                </span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">John Doe</span>
                                                <span class="message-time">6 Mar</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">
                                                    <img alt="" src="{{asset('/admin/img/avatar-03.jpg')}}">
                                                </span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Tarah Shropshire </span>
                                                <span class="message-time">5 Mar</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                                    adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">
                                                    <img alt="" src="{{asset('/admin/img/avatar-05.jpg')}}">
                                                </span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author">Mike Litorus</span>
                                                <span class="message-time">3 Mar</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="">
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar">
                                                    <img src="{{asset('/admin/img/avatar-08.jpg')}}" alt="">
                                                </span>
                                            </div>
                                            <div class="list-body">
                                                <span class="message-author"> Catherine Manseau </span>
                                                <span class="message-time">27 Feb</span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="">View all Messages</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="{{asset('/admin/img/avatar-21.jpg')}}" alt="">
                            <span class="status online"></span></span>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('/employee/profile',Auth::user()->id)}}">My Profile</a>
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
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{url('/employee/profile',Auth::user()->id)}}">My Profile</a>
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
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 346px;">
                <div class="sidebar-inner slimscroll" style="overflow: hidden; width: 100%; height: 346px;">
                    <div id="sidebar-menu" class="sidebar-menu">
                        {{-- mobil --}}
                        <ul class="sidebar-vertical">
                            <li class="menu-title">
                                <span>Main</span>
                            </li>
                            <li class="submenu">
                                <a href=""><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="" href="{{url('/dashboad/admin')}}">Admin Dashboard</a></li>
                                    <li><a class="" href="{{url('/dashboad/employee')}}">Employee Dashboard</a></li>
                                </ul>
                            </li>
                            {{-- <li class="submenu">
                                <a href=""><i  class="la la-cube"></i> <span> Apps</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li class=""><a href="">Chat</a></li>
                                    <li class="submenu">
                                        <a href=""><span> Calls</span> <span class="menu-arrow"></span></a>
                                        <ul style="display: none;">
                                            <li class=""><a href="">Voice Call</a></li>
                                            <li class=""><a href="">Video Call</a></li>
                                            <li class=""><a href="">Outgoing Call</a></li>
                                            <li class=""><a  href="">Incoming Call</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="" href="">Calendar</a></li>
                                    <li><a class="" href="">Contacts</a></li>
                                    <li class="" href=""><a href="">Email</a></li>
                                    <li><a class="" href="">File Manager</a></li>
                                </ul>
                            </li> --}}
                            <li class="menu-title">
                                <span>Employees</span>
                            </li>
                            <li class="submenu">
                                <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="" href="{{url('employee')}}">All Employees</a></li>
                                    {{-- <li><a class="" href="{{url('holidays')}}">Holidays</a></li>
                                    <li><a class="" href="{{url('leaves/admin')}}">Leaves (Admin) <span class="badge rounded-pill bg-primary float-end">1</span></a></li>
                                    <li><a class="" href="{{url('leaves/employee')}}">Leaves (Employee)</a></li>
                                    <li><a class="" href="{{url('attendance/admin')}}">Attendance(Admin)</a></li>
                                    <li><a class="" href="{{url('attendance/employee')}}">Attendance(Employee)</a></li> --}}
                                    {{-- <li><a class="" href="{{url('department')}}">Departments</a></li> --}}
                                </ul>
                            </li>
                            <li class="">
                                <a href="{{url('role')}}"><i class="la la-key"></i> <span>Roles &amp; Permissions</span></a>
                            </li>
                            <li class="active">
                                <a href="{{url('users')}}"><i class="la la-user-plus"></i> <span>Users</span></a>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-cog"></i> <span> Setting</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="" href="{{url('department')}}">Departments</a></li>
                                    <li><a class="" href="{{url('position')}}">Position</a></li>
                                    <li><a class="" href="{{url('branch')}}">Branch</a></li>
                                </ul>
                            </li>
                            
                            {{-- <li class="menu-title">
                                <span>HR</span>
                            </li>
                            
                            <li class="submenu">
                                <a href=""><i class="la la-money"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="" href="">Employee Salary </a></li>
                                    <li><a class="" href="">Payslip </a></li>
                                    <li><a class="" href="">Payroll Items</a></li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href=""><i class="la la-edit"></i> <span> Training </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="" href="">Training List </a></li>
                                    <li><a class="" href=""> Trainers</a></li>
                                    <li><a class="" href=""> Training Type </a></li>
                                </ul>
                            </li>
                            <li class=""><a href=""><i class="la la-bullhorn"></i> <span>Promotion</span></a></li>
                           
                            <li class="submenu">
                                <a href=""><i class="la la-key"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li class=""><a href="">Login </a></li>
                                    <li class=""><a href=""> Register </a></li>
                                    <li class=""><a href=""> Forgot Password </a></li>
                                    <li class=""><a href=""> OTP</a></li>
                                    <li class=""><a href="">Lock Screen </a></li>
                                </ul>
                            </li> --}}
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

    <script src="{{asset('/admin/js/app.js.download')}}"></script>
    <script src="{{asset('/admin/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/js/toastr_jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/toastr.min.js') }}"></script>
    <div class="sidebar-overlay"></div>
    {{-- <gdiv class="ginger-extension-writer" style="display: none;">
        <gdiv class="ginger-extension-writer-frame"><iframe
                src="./Dashboard - HRMS admin template_files/index.html"></iframe></gdiv>
    </gdiv> --}}
</body>

</html>