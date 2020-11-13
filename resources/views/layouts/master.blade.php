@php
  $configs = \App\Models\Configs::getAll();
  if (@$configs->logo) {
    $logo = asset('uploaded/'.@$configs->logo);
  }else{
    $logo = url('assets/img/gbook.png');
  }
  $notif = \App\Models\Notification::where('type','ruang')
  ->whereIn('type_id',auth()->user()->ruang->pluck('id')->toarray())
  ->where('status',false)
  ->with('user')
  ->orderBy('created_at','desc')
  ->limit(10)
  ->get();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ count($notif)?'('.count($notif).') ':'' }}@yield('title','Administrator')</title>
  <meta name="csrf_token" content="{{ csrf_token() }}" />
  @if (!auth()->user()->is_admin)
    <meta name="u_type" content="{{ auth()->check()?'user':'guest' }}" />
    <meta name="ruang" content="{{ implode(',',auth()->user()->ruang->pluck('id')->toArray()) }}" />
  @endif
  <link rel="icon" href="{{ $logo }}" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ url('assets/vendor') }}/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/ionicons/dist/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/icon-kit/dist/css/iconkit.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/toast/jquery.toast.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/perfect-scrollbar/css/perfect-scrollbar.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/mohithg-switchery/dist/switchery.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/select2/select2.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/css/theme.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/css/style.min.css">
  <script>
    var token_url = '{{ route('ajax.token.store') }}';
  </script>
  @yield('header')
</head>
<body>
  <div class="wrapper">
    @include('layouts.header')
    <div class="page-wrap">
      @include('layouts.sidebar')
      <div class="main-content">
        <div class="container-fluid">
          <div class="page-header">
            <div class="row align-items-end">
              <div class="col-lg-7">
                <div class="page-header-title">
                  @yield('head_icon')
                  <div class="d-inline">
                    <h5>@yield('head_title','Menu Header')</h5>
                    <span>@yield('head_desc')</span>
                  </div>
                </div>
              </div>
              <div class="col-lg-5">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="{{ route('home') }}"><i class="ik ik-home"></i></a>
                    </li>
                    @yield('breadcrumb')
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          @yield('content')
        </div>
      </div>
      <footer class="footer">
        <div class="w-100 clearfix">
          <span class="text-center text-sm-left d-md-inline-block">Copyright © {{ date("Y").' '.(@$configs->nama_instansi??'UPTD SMP Negeri 39 Sinjai') }}.</span>
          <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Dikembangkan oleh <a href="https://www.facebook.com/aezdar" class="text-dark font-weight-bold">asd412id</a></span>
        </div>
      </footer>
    </div>
  </div>
  @if (!auth()->user()->is_admin)
    <audio id="notif-tone" class="d-none">
      <source src="{{ asset('assets/tones/notif.mp3') }}" type="audio/mp3">
    </audio>
  @endif
  @yield('modals')
</body>
@if (auth()->check())
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js"></script>
@endif
<script src="{{ url('assets/js') }}/jquery-3.3.1.min.js"></script>
<script src="{{ url('assets/js') }}/autoNumeric.js"></script>
<script>window.jQuery || document.write('<script src="{{ url('assets/js') }}/jquery-3.3.1.min.js"><\/script>')</script>
<script src="{{ url('assets/vendor') }}/popper.js/dist/umd/popper.min.js"></script>
<script src="{{ url('assets/vendor') }}/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ url('assets/vendor') }}/toast/jquery.toast.min.js"></script>
<script src="{{ url('assets/vendor') }}/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<script src="{{ url('assets/vendor') }}/screenfull/dist/screenfull.js"></script>
<script src="{{ url('assets/vendor') }}/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('assets/vendor') }}/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ url('assets/vendor') }}/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ url('assets/vendor') }}/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('assets/vendor/moment/moment.js') }}" charset="utf-8"></script>
<script src="{{ asset('assets/vendor/repeater/jquery.repeater.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('assets/vendor/datetimepicker/js/datetimepicker.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('assets/vendor/mohithg-switchery/dist/switchery.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('assets/vendor/select2/select2.full.min.js') }}" charset="utf-8"></script>
<script src="{{ url('assets') }}/js/theme.js"></script>
<script src="{{ asset('assets') }}/js/modernizr-2.8.3.min.js"></script>
<script src="{{ url('assets/js/script.js') }}" charset="utf-8"></script>
@yield('footer')
</html>
