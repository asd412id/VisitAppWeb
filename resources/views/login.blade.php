@php
  $configs = \App\Models\Configs::getAll();
  if (@$configs->logo) {
    $logo = asset('uploaded/'.@$configs->logo);
  }else{
    $logo = asset('assets/img/gbook.png');
  }
@endphp
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ $title }}</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ $logo }}" type="image/x-icon" />

  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/ionicons/dist/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/vendor') }}/icon-kit/dist/css/iconkit.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/css/theme.min.css">
</head>

<body>
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  <div class="auth-wrapper">
    <div class="container-fluid h-100">
      <div class="row flex-row h-100 bg-white">
        <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
          <div class="lavalite-bg" style="background-image: url('{{ @$config->login_bg?asset('uploaded/'.@$config->login_bg):asset('assets/img/bg.jpeg') }}')">
            <div class="lavalite-overlay"></div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
          <div class="authentication-form mx-auto">
            <div class="logo-centered">
              <a href="{{ route('login') }}"><img src="{{ $logo }}" alt="" style="width: 100%"></a>
            </div>
            <h3 class="text-center">Registrasi Kunjungan<br>{{ @$config->nama_instansi??'UPTD SMP NEGERI 39 SINJAI' }}</h3>
            <p class="text-center">Masuk Halaman Administrator</p>
            @if ($errors->any())
              <div class="alert alert-danger">{{ $errors->all()[0] }}</div>
            @endif
            <form action="{{ route('login.process') }}" method="post">
              @csrf
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" required value="{{ old('username') }}">
                <i class="ik ik-user"></i>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
                <i class="ik ik-lock"></i>
              </div>
              <div class="row">
                <div class="col text-left">
                  <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="item_checkbox" name="remember" {{ old('remember')?'checked':'' }}>
                    <span class="custom-control-label">&nbsp;Ingat Saya</span>
                  </label>
                </div>
              </div>
              <div class="sign-btn text-center">
                <button class="btn btn-theme">Masuk</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</html>
