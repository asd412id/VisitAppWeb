@extends('layouts.master')
@section('title',$title)

@section('head_icon')
  <i class="fas fa-door-open bg-green"></i>
@endsection
@section('head_title',$title)
@section('head_desc',$subtitle)
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('ruang.index') }}">Ruang</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection
@section('content')
<form action="{{ route('ruang.update',['uuid'=>$data->uuid]) }}" enctype="multipart/form-data" method="post">
  @csrf
  <div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-header">
          <h3>Update Data Ruang</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Nama Ruang</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ $data->nama }}" placeholder="Nama Ruang" required>
          </div>
          <div class="form-group">
            <label>Nama Kepala</label>
            <input type="text" name="kepala" class="form-control" id="kepala" value="{{ $data->kepala }}" placeholder="Nama Kepala" required>
          </div>
          <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" name="telp" class="form-control" id="telp" value="{{ $data->telp }}" placeholder="Nomor Telepon">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status">
              <option {{ $data->status==1?'selected':'' }} value="1">Aktif</option>
              <option {{ $data->status==0?'selected':'' }} value="0">Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> SIMPAN</button>
          <a href="{{ route('ruang.index') }}" class="btn btn-danger"><i class="fa fa-fw fa-undo"></i> KEMBALI</a>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('footer')
@if ($errors->any())
<script type="text/javascript">
  @foreach ($errors->all() as $key => $err)
    showDangerToast('{{ $err }}')
  @endforeach
</script>
@endif
@endsection
