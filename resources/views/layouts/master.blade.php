<!DOCTYPE html>
<!-- saved from url=(0065)https://smarthr.dreamguystech.com/laravel/template/public/profile -->
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-layout-mode="orange" data-layout-width="fluid" data-layout-position="fixed"
    data-layout-style="default">

<head>
    @if (App::getLocale() == "kh")
        <link href="{{ asset('admin/css/style-font-kh.css') }}" rel="stylesheet" type="text/css">
    @else
        <link href="{{ asset('admin/css/style-font-en.css') }}" rel="stylesheet" type="text/css">
    @endif
    <style>
        .page-wrapper{
            min-height: 0px !important
        }
        /** class scroll 2 nth child*/
        thead th.stuck {
            background: #fff !important;
            position: sticky !important;
            left: 0 !important;
            z-index: 1 !important;
        }
        thead th.stuck:nth-child(2) {
            left:  80px !important;
        }
        tbody td.stuck {
            background: #fff !important;
            position: sticky;
            left: 0;
            z-index: 1;
        }
        tbody td.stuck:nth-child(2) {
            left: 84px;
        }

        /** class scroll 3 bth-child */
        thead th.stuck-scroll-3 {
            background: #fff !important;
            position: sticky !important;
            left: 0 !important;
            z-index: 1 !important;
        }
        thead th.stuck-scroll-3:nth-child(3) {
            left:  80px !important;
        }
        tbody td.stuck-scroll-3 {
            background: #fff !important;
            position: sticky;
            left: 0;
            z-index: 1;
        }
        tbody td.stuck-scroll-3:nth-child(3) {
            left: 84px;
        }
        
        /** class scroll 4 bth-child */
        thead th.stuck-scroll-4 {
            background: #fff !important;
            position: sticky !important;
            left: 0 !important;
            z-index: 1 !important;
        }
        thead th.stuck-scroll-4:nth-child(4) {
            left:  80px !important;
        }
        tbody td.stuck-scroll-4 {
            background: #fff !important;
            position: sticky;
            left: 0;
            z-index: 1;
        }
        tbody td.stuck-scroll-4:nth-child(4) {
            left: 84px;
        }

        /** class scroll one nth-child*/
        thead th.stuck-scroll {
            background: #fff !important;
            position: sticky !important;
            left: 0 !important;
            z-index: 1 !important;
        }
        .table-striped .stuck-scroll {
            background-color: #fff;
            position: sticky;
            left: 0;
            z-index: 1;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
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
    <link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/mint.css') }}">
    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>

<body>

    <div class="main-wrapper">
        <div class="header">
            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <svg viewBox="64 64 896 896" focusable="false" data-icon="menu-fold" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                        <path style="display: none" id="menu-unfold" d="M408 442h480c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H408c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8zm-8 204c0 4.4 3.6 8 8 8h480c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H408c-4.4 0-8 3.6-8 8v56zm504-486H120c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8zm0 632H120c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8zM142.4 642.1L298.7 519a8.84 8.84 0 000-13.9L142.4 381.9c-5.8-4.6-14.4-.5-14.4 6.9v246.3a8.9 8.9 0 0014.4 7z"></path>
                        <path id="menu-fold" d="M408 442h480c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H408c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8zm-8 204c0 4.4 3.6 8 8 8h480c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H408c-4.4 0-8 3.6-8 8v56zm504-486H120c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8zm0 632H120c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8zM115.4 518.9L271.7 642c5.8 4.6 14.4.5 14.4-6.9V388.9c0-7.4-8.5-11.5-14.4-6.9L115.4 505.1a8.74 8.74 0 000 13.8z"></path>
                    </svg>
                </span>
            <div class="header-left">
                <a href="#" class="logo">
                    <img src="{{ asset('/admin/img/camma-logo.png') }}" alt="Image" style="width: 100%;
                    max-width: 248px;
                    height: auto;
                    margin: 0 auto;">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href=""></a>

            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="" role="button">
                        @switch(App::getLocale())
                            @case('en')
                                <img src="{{asset('/admin/img/us.png')}}" alt="" height="20"><span>English</span>
                            @break
                            @case('kh')
                                <img src="{{asset('/admin/img/flag-of-cambodia-logo.png')}}" alt="" height="20"><span>English</span>
                            @break
                            @default
                            <img src="{{asset('/admin/img/us.png')}}" alt="" height="20"><span>English</span>
                        @endswitch
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ url('lang/en') }}" class="dropdown-item">
                            <img src="{{asset('/admin/img/us.png')}}" alt="" height="20"> English
                        </a>
                        <a href="{{ url('lang/kh') }}" class="dropdown-item">
                            <img src="{{asset('/admin/img/flag-of-cambodia-logo.png')}}" alt="" height="20"> Khmer
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="avatar">
                            @if (Auth::user()->profile == null)
                                <img alt="avatar" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                            @else
                                <img src="{{ asset('/uploads/images/' . Auth::user()->profile) }}" alt="">
                            @endif
                            <span class="status online"></span>
                        </span>
                        <span>{{ Auth::user()->employee_name_en }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('/employee/profile/' . Auth::user()->id) }}">@lang("lang.my_profile")</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            @lang("lang.log_out")
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ url('/employee/profile/' . Auth::user()->id) }}">@lang("lang.my_profile")</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        @lang("lang.log_out")
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
                        <ul class="sidebar-vertical">
                            <li class="menu-title"><span style="border-bottom: 3px solid #dc0000; font-weight: bold; font-size: 17px;">@lang('lang.hr_management_system')</span></li>
                            @foreach (RolePermission()->menu as $menu)
                                <li class="submenu">
                                    <a href="javascript:void(0);" style="border-bottom: 3px solid #f0f0f0;">
                                        <i class="{{$menu["icon"]}}"></i><span>@lang($menu["name"])</span><span class="menu-arrow"></span>
                                    </a>
                                    <ul style="display: none;">
                                        @foreach (RolePermission()->subMenu as $sub_menu)
                                            @if ($sub_menu["sub_menu_id"] == $menu["menu_id"])
                                                <li>
                                                    <a class="" href="{{url($sub_menu['url'])}}">@lang($sub_menu["name"])</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                            @foreach (RolePermission()->singleMenu as $singlemenu)
                                <li class="">
                                    <a href="{{url($singlemenu['url'])}}"><i class="{{$singlemenu["icon"]}}"></i><span>@lang($singlemenu["name"])</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="slimScrollBar"
                    style="background: rgb(204, 204, 204); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 68.5659px;">
                </div>
                <div class="slimScrollRail"
                    style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                </div>
            </div>
        </div>

        <div class="page-wrapper" style="min-height: 406px;">
            <div class="content">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('/admin/js/jquery.min.js.download') }}"></script>

    <script type="text/javascript" src="{{ asset('/admin/js/printThis.js') }}"></script>

    <script src="{{ asset('/admin/js/bootstrap.bundle.min.js.download') }}"></script>

    <script src="{{ asset('/admin/js/jquery.slimscroll.min.js.download') }}"></script>
    <script src="{{ asset('/admin/js/moment.min.js.download') }}"></script>
    <script src="{{ asset('/admin/js/jquery-ui.min.js.download') }}"></script>

    <script src="{{ asset('/admin/js/select2.min.js') }}"></script>

    <script src="{{ asset('/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin/js/dataTables.bootstrap4.min.js.download') }}"></script>

    <script src="{{ asset('/admin/js/bootstrap-datetimepicker.min.js.download') }}"></script>
    <script src="{{ asset('/admin/js/daterangepicker.js.download') }}"></script>

    <script src="{{ asset('/admin/js/bootstrap-tagsinput.min.js.download') }}"></script>

    <script src="{{ asset('/admin/js/sticky-kit.min.js.download') }}"></script>

    <script src="{{ asset('/admin/js/summernote-bs4.js.download') }}"></script>

    <script src="{{ asset('/admin/js/fullcalendar.min.js.download') }}"></script>
    <script src="{{ asset('/admin/js/jquery.fullcalendar.js.download') }}"></script>

    <script src="{{ asset('/admin/js/jquery.maskedinput.js.download') }}"></script>

    <script src="{{ asset('/admin/js/task.js.download') }}"></script>

    <script src="{{ asset('/admin/js/layout.js.download') }}"></script>
    <script src="{{ asset('/admin/js/theme-settings.js.download') }}"></script>
    <script src="{{ asset('/admin/js/greedynav.js.download') }}"></script>

    <script src="{{ asset('/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admin/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{ asset('/admin/js/chart_board.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script type="text/javascript" src="{{ asset('/admin/js/noty.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/noty.min.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    {{-- <script src="{{asset('/admin/js/MSelectDBox.min.js')}}"></script> --}}
    <div class="sidebar-overlay"></div>
</body>

</html>
