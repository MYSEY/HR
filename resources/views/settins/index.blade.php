
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
                                <h3 class="account-title">Forgot Password?</h3>
                                <p class="account-subtitle" style="font-size: 17px !important">Enter your employee ID to get a password reset link</p>
                                {!! Toastr::message() !!}

                                <form method="POST" action="{{ url('update/password') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Employee ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control requered @error('number_employee') is-invalid @enderror" name="number_employee" value="{{ old('number_employee') }}" required>
                                        @error('number_employee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group Password-icon">
                                        <label >New Password <span class="text-danger">*</span></label>
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
                                        <label >Confirm Password <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control requered pass-input" name="password_confirmation" required>
                                            <span class="fa fa-eye-slash toggle-password"></span>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary account-btn submit-btn" type="submit">Reset Password</button>
                                    </div>
                                    <div class="account-footer">
                                        <p>Remember your password? <a href="{{url('/')}}">Login</a></p>
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