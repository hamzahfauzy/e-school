<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-School Login Service</title>
    <script type="text/javascript">window.Laravel = {csrfToken:'{{csrf_token()}}'}</script>
    <link rel="icon" type="image/png" href="{{asset('template/images/icons/favicon.ico')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('template/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/vendor/animate/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/vendor/css-hamburgers/hamburgers.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/vendor/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('template/css/main.css')}}">
    <style type="text/css">
            .overlay {
                width: 100%;
                height: 100%;
                background: #FFF;
                z-index: 2;
                position: fixed;
                overflow: hidden;
            }
            
    .loader{
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('//upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Phi_fenomeni.gif/50px-Phi_fenomeni.gif') 
                          50% 50% no-repeat rgb(249,249,249);
    }
    </style>
</head>
<body>
    <div id="app">
        <login-component></login-component>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('template/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('template/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('template/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('template/vendor/select2/select2.min.js')}}"></script>
    <script src="{{asset('template/js/main.js')}}"></script>
</body>
</html>
