<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>e-School - Landing Page</title>
  <script type="text/javascript">
  window.Laravel = {csrfToken:'{{csrf_token()}}'}
  window.setCookie = (cname, cvalue) => {
        document.cookie = cname + "=" + cvalue + ";";
    }

    window.getCookie = (cname) => {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
        }
        return "";
    }

    window.deleteCookie = name => {
        document.cookie = name + "=;domain=.{{env('APP_DOMAIN')}}";
    }
  </script>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <style>
        html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Lato', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                color: #FFF !important;
            }
        a {
            color: #FFF !important;
            margin-bottom: 10px;
            padding: 15px;
            padding-top: 20px;
            padding-bottom: 20px;
            border:2px solid #FFF;
            display: inline-block;
        }

        a:hover {
            color: blue !important;
            border:2px solid blue;
            background-color: #FFF;
        }
        img {
            border-radius: 50%;
            width: 200px;
        }
        .bg {
            background:url('images/bg.jpg');
            width: 100%;
            padding: 0px 10px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
            z-index: 1;
        }

        .bg::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: #000;
            opacity: 0.2;
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

            .d-none {
                display: none;
            }

            .d-block {
                display: block;
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
    <div class="bg">
        <div id="app">
            <admin-component></admin-component>
        </div>
    </div>
</body>
</html>