@extends('layouts.master')
@section('title',$title)

@section('head_icon')
  <i class="fas fa-user-tie bg-green"></i>
@endsection
@section('head_title',$title)
@section('head_desc',$subtitle)
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection
@section('content')
<form action="{{ route('users.update',['uuid'=>$data->uuid]) }}" enctype="multipart/form-data" method="post">
  @csrf
  <div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-header">
          <h3>Ubah Data Pengguna</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $data->name }}" placeholder="Nama Lengkap" required>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" id="username" value="{{ $data->username }}" placeholder="Username" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label>Ulang Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Ulang Password">
          </div>
          <div class="form-group">
            <label>Role</label>
            <select class="form-control select2" name="role" id="role" required>
              <option {{ $data->role=='operator'?'selected':'' }} value="operator">Operator</option>
              <option {{ $data->role=='admin'?'selected':'' }} value="admin">Admin</option>
            </select>
          </div>
          <div class="form-group" id="ruang-wrap">
            <label>Pilih ruang</label>
            <select class="form-control select2-ajax-multiple" data-placeholder="Pilih ruang" data-url="{{ route('ajax.ruang') }}" name="ruang[]" required multiple>
              @if ($data->ruang)
              @php
              foreach ($data->ruang as $key => $r) {
                echo '<option selected value="'.$r->id.'">'.$r->nama.'</option>';
              }
              @endphp
            @endif
            </select>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> SIMPAN</button>
          <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="fa fa-fw fa-undo"></i> KEMBALI</a>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('footer')
<script type="text/javascript">
  $("#role").change(function(){
    init();
  })
  function init() {
    if ($("#role").val()!='operator') {
      $("#ruang-wrap").hide();
      $("#ruang-wrap").find('select').val('').trigger('change');
      $("#ruang-wrap").find('select').prop('required',false);
    }else{
      $("#ruang-wrap").show();
      $("#ruang-wrap").find('select').prop('required',true);
    }
  }
  init();
  @if ($errors->any())
    @foreach ($errors->all() as $key => $err)
      showDangerToast('{{ $err }}')
    @endforeach
  @endif
</script>
@endsection
