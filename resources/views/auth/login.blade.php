
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Camma Microfinance Limited">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>HRMS Admin</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/admin/img/logo/favicon.ico') }}">

        <link rel="stylesheet" href="{{asset('/admin/css/bootstrap.min.css')}}">

        <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/line-awesome.min.css') }}">

        <link rel="stylesheet" href="{{asset('/admin/css/style.css')}}">
        {{-- message toastr --}}
        <link rel="stylesheet" href="{{ asset('/admin/css/toastr.min.css')}}">
        <script src="{{asset('/admin/js/toastr_jquery.min.js') }}"></script>
        <script src="{{asset('/admin/js/toastr.min.js')}}"></script>
        <script src="{{asset('/admin/js/app.js')}}"></script>
        <style>
            body {
                background: url({{asset('/admin/img/logo/hero-bg.png')}});
                /* background: url({{asset('/admin/img/logo/background_login.png')}}); */
                background-size: cover;
                font-family: Montserrat;
            }
            .login {
                height: 100vh;
                width: 100%;
                position: relative;
            }
            .login_box {
                width: 60vh;
                height: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                background: #fff;
                border-radius: 10px;
                box-shadow: 0px 0px 20px 0px #0002;
                display: flex;
                overflow: hidden;
            }
            .login_box .left{
                width: 100%;
                height: 100%;
                padding: 25px 25px;
            }           
            .left .contact{
                display: flex;
                align-items: center;
                justify-content: center;
                align-self: center;
                height: 100%;
                width: 85%;
                margin: auto;
            }
            .left h3{
                text-align: center;
                margin-bottom: 40px;
            }
            .left input {
                border: none;
                margin: 15px 0px;
                border-bottom: 1px solid #4f30677d;
                padding: 7px 9px;
                width: 100%;
                overflow: hidden;
                background: transparent;
                font-weight: 600;
                font-size: 14px;
            }
            .left{
                background: linear-gradient(-45deg, #dcd7e0, #fff);
            }
            .submit {
                border: none;
                padding: 15px 70px;
                border-radius: 8px;
                display: block;
                margin: auto;
                margin-top: 30px;
                background: #cf2e2e;
                color: #fff;
                font-weight: bold;
                -webkit-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
                -moz-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
                box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
            }

            .modal {
                display: none;
            }
            .animate {
                -webkit-animation: animatezoom 0.6s;
                animation: animatezoom 0.6s
            }
            @-webkit-keyframes animatezoom {
                from {-webkit-transform: scale(0)} 
                to {-webkit-transform: scale(1)}
            }
        </style>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            {!! Toastr::message() !!}
            <section class="login">
                <div id="form-login">
                    <div class="login_box">
                        <div class="left">
                            <div class="contact">
                                {{-- <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
                                    <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                        <img src="{{asset('admin/img/logo/cammalogo.png')}}" alt="Support Form" aria-roledescription="logo" style="width: 85px !important">
                                    </a>
                                </div> --}}
                                <form id="form-login">
                                {{-- <form method="POST" action="{{ route('login') }}"> --}}
                                    {{-- @csrf --}}
                                    <div style="text-align: center">
                                        <img src="{{asset('admin/img/logo/cammalogo.png')}}" aria-roledescription="logo" style="width: 60% !important">
                                        <h4>Welcome! Please log in</h4>
                                    </div>
                                    <div class="form-group">
                                        <input id="number_employee" type="text" class="form-control @error('number_employee') is-invalid @enderror" placeholder="Employee ID"  required name="number_employee">
                                        @error('number_employee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group Password-icon">
                                        <div style="display: flex;" class="position-relative" id="old_password">
                                            <input id="password" type="password" class="form-control pass-input " name="password" required placeholder="Password" autocomplete="current-password">
                                            <span class="fa fa-eye-slash toggle-password"></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="button" class="submit" onclick="submitForm()" id="btn-login">Click here to login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal" id="id01">
                <div class="animate">
                    <section class="login">
                        <div class="login_box">
                            <div class="left">
                                <div class="contact">
                                    <form  id="btn-change-pass" method="POST" action="{{ url('login/change/password') }}">
                                        {{-- {!! Toastr::message() !!} --}}
                                        @csrf
                                        <h3>Please change password!</h3>
                                        <input id="cha_number_employee" type="text" name="number_employee" hidden>
                                        <div class="form-group Password-icon">
                                            <div style="display: flex;" class="position-relative">
                                                <input id="new_password" type="password" class="form-control pass-input " name="new_password" required placeholder="New password" autocomplete="new-password">
                                                <span class="fa fa-eye-slash toggle-password"></span>
                                                @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <p id="passwordError" style="color: red;"></p>
                                        </div>
                                        <div class="form-group Password-icon">
                                            <div style="display: flex;" class="position-relative" id="old_password">
                                                <input id="confirm_password" type="password" class="form-control pass-input " name="confirm_password" required placeholder="Confirm password" autocomplete="current-password">
                                                <span class="fa fa-eye-slash toggle-password"></span>
                                                @error('confirm_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="submit">Click change password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div id="errorMessage"></div>
        </div>
        <script>
            const loginUrl = "{{ url('/login') }}";
            const dashboadEmployee = "{{ URL('dashboad/employee') }}";
            const dashboadAdmin = "{{ URL('dashboad/admin') }}";
        </script>
        <script src="{{asset('/admin/component-js/login.js')}}"></script>
    </body>
</html>