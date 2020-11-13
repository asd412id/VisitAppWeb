<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title')</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf_token" content="{{ csrf_token() }}" />
  <link rel="icon" type="image/png" href="{{ @$configs?asset('uploaded/'.$configs->logo):asset('assets/img/sinjai.png') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/fonts/iconic/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/vendor/animate/animate.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/vendor/css-hamburgers/hamburgers.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/vendor/animsition/css/animsition.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/vendor/select2/select2.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/vendor/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/vendor/noui/nouislider.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/css/util.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/guestpage') }}/css/main.css">
  @yield('head')
</head>
<body>

  <div class="container-contact100">
    @yield('content')
  </div>
  <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/animsition/js/animsition.min.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/bootstrap/js/popper.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/select2/select2.min.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/daterangepicker/moment.min.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/daterangepicker/daterangepicker.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/countdowntime/countdowntime.js"></script>
  <script src="{{ asset('assets/guestpage') }}/vendor/noui/nouislider.min.js"></script>
  <script src="{{ asset('assets/guestpage') }}/js/main.js"></script>
  @yield('foot')
</body>
</html>
