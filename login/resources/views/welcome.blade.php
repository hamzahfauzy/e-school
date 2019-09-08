<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-School Landing Page</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .overlay {
                width: 100%;
                height: 100%;
                background: #FFF;
                z-index: 1;
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
        <!-- <div class="overlay">
            <div class="loader"></div>
        </div> -->
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title" style="font-size: 50px">
                    E-School Landing Page
                </div>

                <div>
                    <h2 align="center" style="margin: 0px;">Welcome, Administrator</h2>
                </div>

                <br>

                <div class="links">
                    <a href="#">Users</a>
                    <a href="#">Roles</a>
                    <a href="{{env('CLOUD_URL')}}">Cloud</a>
                    <a href="#">Profile</a>
                    <a href="{{env('IS_URL')}}">Teachers</a>
                    <a href="{{env('IS_URL')}}">Employments</a>
                    <a href="{{env('IS_URL')}}">Students</a>
                    <a href="{{env('IS_URL')}}">Class Group</a>
                    <a href="#">Schedule</a>
                    <a href="{{env('ADMINISTRATIVE_URL')}}">Configuration</a>
                    <a href="{{env('ADMINISTRATIVE_URL')}}">Pembayaran Uang Sekolah</a>
                    <a href="{{env('ADMINISTRATIVE_URL')}}">Pembayaran Gaji pegawai</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
    Logout
</a>    
<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
                    <!-- <a href="javascript:void(0)" onclick="doLogout()">Log Out</a> -->
                </div>
            </div>
        </div>
    <script src="{{asset('template/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript">
    // $(document).ready(()=>{
    //     if (localStorage.getItem("eschool_token_app") === null) {
    //         location='/login'
    //     }
    //     else
    //     {
    //         var token = localStorage.getItem("eschool_token_app")
    //         $('.overlay').hide()
    //     }
    // });
    // function doLogout()
    // {
    //     localStorage.removeItem("eschool_token_app");
    //     location='/login'
    // }
    </script>
    </body>
</html>
