
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
    </head>
    <body class="account-page">
        <div class="main-wrapper">
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
                                    <p id="show_change_password" hidden></p>
                                    <div class="form-group">
                                        <label>Employee ID <span class="text-danger">*</span></label>
                                        <input id="number_employee" type="text" class="form-control @error('number_employee') is-invalid @enderror" required name="number_employee" value="{{ old('number_employee') }}">
                                        @error('number_employee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- <div style="display: none;" class="new_change_password form-group">
                                        <label>Current Password <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control pass-input " name="current_password" autocomplete="current-password"><span class="fa fa-eye-slash toggle-password"></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    {{-- <div style="display: none;" class="new_change_password form-group">
                                        <label for="password">New Password <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control pass-input" name="new_password" autocomplete="new-password"><span class="fa fa-eye-slash toggle-password"></span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{-- <div style="display: none;" class="new_change_password">
                                        <label for="password-confirm">Confirm New Password</label>
                                        <div class="position-relative">
                                            <input id="password-confirm" type="password" class="form-control pass-input" name="password_confirmation" autocomplete="confirm-assword"><span class="fa fa-eye-slash toggle-password"></span>
                                        </div>
                                    </div> --}}
                                    <div class="form-group Password-icon">
                                        <div class="row">
                                            <div class="col">
                                                <label style="display: flex;" class="old_password">Password <span class="text-danger">*</span></label>
                                            </div>
                                            {{-- <div class="col-auto">
                                                <a class="text-muted change_password" href="#"> Forgot password? </a>
                                            </div> --}}
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
        </div>

        <script>
            $(function(){
                $('.change_password').on('click', function () {
                    if ($('#show_change_password').text() === 'show' || $('#show_change_password').text() === '') {
                        $(".old_password").text('');
                        $("#old_password").hide();
                        $('.new_change_password').show();
                        $('.account-logo').hide();
                        $('#show_change_password').text('hide');
                        $(".change_password").text("Back?");
                    }else {
                        $(".change_password").text("Change password?");
                        $("#old_password").show();
                        $(".old_password").text('Password');
                        $('#show_change_password').text('show');
                        $('.new_change_password').hide();
                        $('.account-logo').show();
                    }
                });
            });
        </script>
    </body>
</html>