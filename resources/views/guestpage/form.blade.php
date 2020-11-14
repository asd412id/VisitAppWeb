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
      Registrasi Kunjungan<br>
      {{ @$configs->nama_instansi }}
    </span>

    @if ($errors->any())
      @foreach ($errors->all() as $key => $err)
        <div class="alert alert-danger d-block">{{ $err }}</div>
      @endforeach
    @endif

    <form class="contact100-form validate-form" method="post">
      @csrf
      <div class="wrap-input100 validate-input bg1" data-validate="Nama lengkap harus diisi">
        <span class="label-input100">Nama Lengkap *</span>
        <input class="input100" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Anda">
      </div>

      <div class="wrap-input100 validate-input bg1" data-validate="Mohon isi alamat tempat tinggal Anda">
        <span class="label-input100">Alamat *</span>
        <textarea class="input100" name="alamat" placeholder="Alamat tempat tinggal">{{ old('alamat') }}</textarea>
      </div>

      <div class="wrap-input100 bg1 validate-input" data-validate="Pekerjaan harus diisi">
        <span class="label-input100">Pekerjaan/Tempat Kerja *</span>
        <input class="input100" type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Masukkan Nama Pekerjaan/Tempat Kerja">
      </div>

      <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate="Nomor telepon harus diisi">
        <span class="label-input100">Nomor Telepon *</span>
        <input class="input100" type="text" name="telp" value="{{ old('telp') }}" placeholder="Masukkan Nomor Telepon">
      </div>

      <div class="wrap-input100 bg1 rs1-wrap-input100 validate-input" data-validate="Tanggal berkunjung harus diisi">
        <span class="label-input100">Tanggal Berkunjung *</span>
        <input class="input100" id="tgl" type="text" name="tgl_berkunjung" value="{{ old('tgl_berkunjung') }}" placeholder="Masukkan tanggal berkunjung">
      </div>

      <div class="wrap-input100 input100-select bg1">
        <span class="label-input100">Bidang/Ruang *</span>
        <div>
          <select class="js-select2" name="ruang" required>
            <option>Silahkan Pilih</option>
            @foreach ($ruang as $key => $r)
              <option {{ old('ruang')==$r->id?'selected':'' }} value="{{ $r->id }}">{{ $r->nama }}</option>
            @endforeach
          </select>
          <div class="dropDownSelect2"></div>
        </div>
      </div>

      <div class="wrap-input100 validate-input bg0 rs1-alert-validate" data-validate = "Mohon isi tujuan kunjungan Anda">
        <span class="label-input100">Tujuan Kunjungan *</span>
        <textarea class="input100" name="tujuan" placeholder="Isi tujuan kunjungan Anda, jam kunjungan, atau ingin bertemu dengan siapa">{{ old('tujuan') }}</textarea>
      </div>

      <h5 style="width: 100%" class="text-center text-danger mb-2">Klik/centang gambar di bawah untuk memverifikasi bahwa Anda bukan robot!</h5>
      <div style="display: inline-block;margin: 0 auto !important">
        {!! NoCaptcha::display() !!}
      </div>

      <div class="container-contact100-form-btn">
        <button class="contact100-form-btn" type="submit">
          <span>
            Kirim Permintaan
            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
          </span>
        </button>
        <p class="text-center m-2 font-weight-bold">ATAU</p>
        <button class="contact100-form-btn bg-success" onclick="location.href='{{ route('visit.index') }}'" type="button">
          <span>
            <i class="fa fa-long-arrow-left m-r-7" aria-hidden="true"></i>
            Cek Status Kunjungan
          </span>
        </button>
      </div>
    </form>
  </div>
@endsection
@section('foot')
<script>
$("#tgl").daterangepicker({
  singleDatePicker: true,
  locale: {
    format: 'DD/MM/YYYY'
  }
});
$(".js-select2").each(function(){
  $(this).select2({
    minimumResultsForSearch: 20,
    dropdownParent: $(this).next('.dropDownSelect2')
  });
})
</script>
@endsection
