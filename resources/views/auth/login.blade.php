{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!DOCTYPE html>
<!-- saved from url=(0063)https://smarthr.dreamguystech.com/laravel/template/public/login -->
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

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

<body class="account-page">
    <div class="main-wrapper">
        <div class="main-wrapper">
            <div class="account-content">
                <div class="container">
                    {{-- <h3 class="account-title" style="text-align: center;">Login</h3> --}}
                    {!! Toastr::message() !!}
                    <div class="account-box" style="width: 366px;">
                        <div class="account-wrapper">
                            <div class="account-logo">
                                <a href=""><img src="{{asset('/admin/img/logo/aa15d5f1-6051-4731-85c3-9f8e7dbc4b88.jfif')}}" style="width: 50%" alt="Dreamguy&#39;s Technologies"></a>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group Password-icon">
                                    <div class="row">
                                        <div class="col">
                                            <label>Password</label>
                                        </div>
                                        <div class="col-auto">
                                            <a class="text-muted" href="">
                                                Forgot password?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="position-relative">
                                        <input id="password" type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"><span class="fa fa-eye-slash toggle-password"></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary account-btn" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
    <script src="{{asset('/admin/js/greedynav.js.download')}}"></script>

    <script src="{{asset('/admin/js/app.js.download')}}"></script>
    <script src="{{asset('admin/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{asset('/admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/js/toastr_jquery.min.js') }}"></script>
    <script src="{{asset('admin/js/toastr.min.js') }}"></script>
</body>

</html>