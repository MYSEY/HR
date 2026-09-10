
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
        </style>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            <section class="login">
                <div class="login_box">
                    <div class="left">
                        <div class="">
                            <form method="POST" action="{{ url('user/change/password') }}">
                                @csrf
                                <h3>Please change password</h3>
                                <div class="form-group">
                                    <label for="">Employee ID <span class="text-danger">*</span></label>
                                    <input id="number_employee" type="text" class="form-control @error('number_employee') is-invalid @enderror" placeholder="Employee ID"  required name="number_employee">
                                    @error('number_employee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group Password-icon">
                                    <label >@lang('lang.new_password') <span class="text-danger">*</span></label>
                                    <div class="position-relative" id="old_password">
                                        <input id="new_password" type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="new_password" required placeholder="New Password">
                                        <span class="fa fa-eye-slash toggle-password"></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group Password-icon">
                                    <label>@lang('lang.confirm_password') <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control requered pass-input @error('confirm_password') is-invalid @enderror" name="password_confirmation" required>
                                        <span class="fa fa-eye-slash toggle-password"></span>
                                    </div>
                                </div>
                                <div class="form-group" style="float: right;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>