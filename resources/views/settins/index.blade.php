
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

    <head>
        <style>
            body,option,label,.chartjs-size-monitor-shrink,#k_chart_cashin_cahout,.chartjs-render-monitor,canvas,#k_chart_receive_pay,.chartjs-size-monitor,.fontKH,.f,.form-control,.modal-title,.menu-item,.menu-title,.k-portlet__head-title,tr,li,a,label,.ui-helper-hidden-accessible,div,button,h1,h2,b,h3,title,.swal2-title,.content-header-title,.btn,.swal2-title{
                font-family:  'Nunito', "Khmer OS Battambang", sans-serif, serif;
                /* font-family: 'Jaldi', sans-serif; */
            }
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Camma Microfinance Limited">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>HRMS Admin</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/admin/img/logo/cammalogo.png') }}">

        <link rel="stylesheet" href="{{asset('/admin/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{asset('/admin/css/style.css')}}">
        {{-- message toastr --}}
        <link rel="stylesheet" href="{{ asset('/admin/css/toastr.min.css')}}">
        <script src="{{asset('/admin/js/toastr_jquery.min.js') }}"></script>
        <script src="{{asset('/admin/js/toastr.min.js')}}"></script>
        <script src="{{asset('/admin/js/app.js')}}"></script>
        <script src="{{asset('/admin/js/validation-field.js')}}"></script>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            <div class="main-wrapper">
                <div class="account-content">
                    <div class="container">
                        <div class="account-box" >
                            <div class="account-wrapper">
                                <div class="text-center">
                                    <img src="{{asset('/admin/img/logo/aa15d5f1-6051-4731-85c3-9f8e7dbc4b88.jfif')}}" style="width: 30%" alt="Dreamguy&#39;s Technologies">
                                </div>
                                <h3 class="account-title">@lang('lang.forgot_password?')</h3>
                                <p class="account-subtitle" style="font-size: 12px !important">@lang('lang.enter_your_employee_id_to_get_a_password_reset_link')</p>
                                {!! Toastr::message() !!}

                                <form method="POST" action="{{ url('update/password') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>@lang('lang.employee_id') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control requered @error('number_employee') is-invalid @enderror" name="number_employee" value="{{ old('number_employee') }}" required>
                                        @error('number_employee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group Password-icon">
                                        <label >@lang('lang.new_password') <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control requered pass-input " name="password" required>
                                            <span class="fa fa-eye-slash toggle-password"></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group Password-icon">
                                        <label >@lang('lang.confirm_password') <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control requered pass-input" name="password_confirmation" required>
                                            <span class="fa fa-eye-slash toggle-password"></span>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        @if (permissionAccess("m9-s5","is_create")->value == "1")
                                        <button class="btn btn-primary account-btn submit-btn" type="submit">@lang('lang.reset_password')</button>
                                        @endif
                                    </div>
                                    <div class="account-footer">
                                        <p>@lang('lang.remember_your_password')? <a href="{{url('/')}}">@lang('lang.login')</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>