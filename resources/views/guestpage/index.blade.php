@extends('guestpage.layout')
@section('title',$title)
@section('head')
   {!! NoCaptcha::renderJs('id') !!}
@endsection
@section('content')
  <div class="wrap-contact100">
    <div class="container-fluid text-center">
      @if (@$configs->logo)
        <img style="width: 75px;margin-top:-30px;margin-bottom: 15px" src="{{ asset('uploaded/'.$configs->logo) }}" alt="">
      @endif
    </div>

    <span class="contact100-form-title">
      Form Kunjungan<br>
      {{ @$configs->nama_instansi }}
    </span>

    @if ($errors->any())
      @foreach ($errors->all() as $key => $err)
        <div class="alert alert-danger d-block">{{ $err }}</div>
      @endforeach
    @endif

    <form class="contact100-form validate-form" method="post">
      @csrf
      <input type="hidden" name="f_token" id="f_token">
      <div class="wrap-input100 validate-input bg1" data-validate="ID Request harus diisi">
        <span class="label-input100">ID REQUEST *</span>
        <input class="input100" type="text" name="id_request" value="{{ old('id_request') }}" placeholder="Masukkan ID Request untuk mengecek status kunjungan">
      </div>

      <h5 style="width: 100%" class="text-center text-danger mb-2">Klik/centang gambar di bawah untuk memverifikasi bahwa Anda bukan robot!</h5>
      <div style="display: inline-block;margin: 0 auto !important">
        {!! NoCaptcha::display() !!}
      </div>

      <div class="container-contact100-form-btn">
        <button class="contact100-form-btn" type="submit">
          <span>
            Cek Status
            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
          </span>
        </button>
        <p class="text-center m-2 font-weight-bold">ATAU</p>
        <button class="contact100-form-btn bg-success" onclick="location.href='{{ route('visit.form') }}'" type="button">
          <span>
            Registrasi
            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
          </span>
        </button>
      </div>
    </form>
  </div>
@endsection
