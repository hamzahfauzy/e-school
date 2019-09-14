<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Information System - @yield('title')</title>
  <script type="text/javascript">window.Laravel = {csrfToken:'{{csrf_token()}}'}

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
    window.doLogout = () => {
      var token = window.getCookie('eschool_token_app')
      fetch('api/logout', {
        method:'post',
        headers: {
          'Authorization': 'Bearer '+token
        }
      })
      .then(res => {
          window.deleteCookie('eschool_token_app')
          window.location = "{{env('MIX_ES_URL')}}/login"
      })
    }

  </script>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('template/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('template/vendors/base/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('template/css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('template/images/favicon.png')}}" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('layouts.navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar -->
        @include('layouts.sidebar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- partial:partials/_footer.html -->
        @include('layouts.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{asset('template/vendors/base/vendor.bundle.base.js')}}" async></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="{{asset('template/vendors/chart.js/Chart.min.js')}}" async></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{asset('template/js/off-canvas.js')}}" async></script>
  <script src="{{asset('template/js/hoverable-collapse.js')}}" async></script>
  <script src="{{asset('template/js/template.js')}}" async></script>
  <script src="{{asset('template/js/todolist.js')}}" async></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('template/js/dashboard.js')}}" async></script>
  <!-- End custom js for this page-->

</body>

</html>