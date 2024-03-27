
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

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/admin/img/logo/favicon.ico') }}">

        <link rel="stylesheet" href="{{asset('/admin/css/bootstrap.min.css')}}">

        <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/line-awesome.min.css') }}">

        <link rel="stylesheet" href="{{asset('/admin/css/style.css')}}">
        {{-- message toastr --}}
        <link rel="stylesheet" href="{{ asset('/admin/css/toastr.min.css')}}">
        <script src="{{asset('/admin/js/toastr_jquery.min.js') }}"></script>
        <script src="{{asset('/admin/js/app.js')}}"></script>
        <style>
            body {
                background: url({{asset('/admin/img/404-page-not-found.png')}});
                background-size: cover;
                font-family: Montserrat;
            }
            .login_box {
                /* width: 60vh; */
                height: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                background: #fff;
                border-radius: 10px;
                display: flex;
                overflow: hidden;
            }
        </style>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
            <div class="login_box">
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <img src="{{ asset('/admin/img/Error-404-Page-Not-Found.png') }}" />
                        <button type="button" id="go-back" data-permissio="{{Auth::user()->RolePermission}}" class="btn btn-danger">Go Back</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function(){
                $("#go-back").on("click", function() {
                    if ($(this).data("permissio") == "Employee") {
                        window.location.replace("{{ URL('/dashboad/employee') }}"); 
                    }else{
                        window.location.replace("{{ URL('/dashboad/admin') }}"); 
                    }
                });
            });
        </script>
    </body>
</html>