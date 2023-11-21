
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

    <head>
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
        <style>
            body {
                background: url('/admin/img/logo/hero-bg.png');
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
                box-shadow: -15px 15px 20px -4px #0004;
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
                margin-top: 120px;
                background: #cf2e2e;
                color: #fff;
                font-weight: bold;
                -webkit-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
                -moz-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
                box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
            }
        </style>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            <section class="login">
                <div class="login_box">
                    <div class="left">
                        <div class="contact">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <h3>Welcome! Please log in</h3>
                                <div class="form-group">
                                    <input id="number_employee" type="text" class="form-control" placeholder="Employee ID"  required name="number_employee">
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
                                <button class="submit">Click here to login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        {{-- <div class="main-wrapper">
            <div class="main-wrapper">
                <div class="account-content">
                    <div class="container">
                        <div class="account-box" style="width: 366px;">
                            <div class="account-wrapper">
                                <div class="account-logo">
                                    <img src="{{asset('/admin/img/logo/aa15d5f1-6051-4731-85c3-9f8e7dbc4b88.jfif')}}" style="width: 50%" alt="Dreamguy&#39;s Technologies">
                                </div>
                                {!! Toastr::message() !!}
    
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Employee ID <span class="text-danger">*</span></label>
                                        <input id="number_employee" type="text" class="form-control @error('number_employee') is-invalid @enderror" required name="number_employee" value="{{ old('number_employee') }}">
                                        @error('number_employee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group Password-icon">
                                        <div class="row">
                                            <div class="col">
                                                <label style="display: flex;" class="old_password">Password <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div style="display: flex;" class="position-relative" id="old_password">
                                            <input id="password" type="password" class="form-control pass-input " name="password" autocomplete="current-password">
                                            <span class="fa fa-eye-slash toggle-password"></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary account-btn" type="submit">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </body>
</html>