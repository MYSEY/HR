
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

        <link rel="stylesheet" href="{{asset('/admin/css/style.css')}}">
        {{-- message toastr --}}
        <link rel="stylesheet" href="{{ asset('/admin/css/toastr.min.css')}}">
        <script src="{{asset('/admin/js/toastr_jquery.min.js') }}"></script>
        <script src="{{asset('/admin/js/toastr.min.js')}}"></script>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            <div class="main-wrapper">
                <div class="account-content">
                    <div class="container">
                        <div class="account-box" style="width: 366px;">
                            <div class="account-wrapper">
                                <div class="account-logo">
                                   Change Password
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
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <input id="password" type="password" class="form-control pass-input " name="password" autocomplete="current-password"><span class="fa fa-eye-slash toggle-password"></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm">Confirm Password</label>
                                        <div class="position-relative">
                                            <input id="password-confirm" type="password" class="form-control pass-input" name="password_confirmation" autocomplete="confirm-assword"><span class="fa fa-eye-slash toggle-password"></span>
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
        </div>
    </body>
</html>