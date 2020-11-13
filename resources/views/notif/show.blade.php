@extends('layouts.master')
@section('title',$title)
@section('head_icon')
  <i class="ik ik-bell bg-blue"></i>
@endsection
@section('head_title',$title)
@section('head_desc','Detail Notifikasi Permintaan Kunjungan')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('notif.index') }}">Notifikasi</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{ $data->id_request }}</li>
@endsection

@section('content')
<div class="card m-1">
  <div class="card-body">
    <a href="{{ route('notif.index') }}" class="btn btn-lg btn-link"><h5 class="m-0 p-0"><i class="fas fa-arrow-left"></i> Kembali</h5></a>
    <table class="table table-striped mt-3">
      <caption style="caption-side: top;color: white" class="bg-primary p-2 font-weight-bold">Data Pengunjung</caption>
      <tr>
        <td width="25%">Nama</td>
        <td width="1">:</td>
        <th>{{ $data->nama }}</th>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <th>{{ $data->alamat }}</th>
      </tr>
      <tr>
        <td>Nomor Telepon</td>
        <td>:</td>
        <th>{{ $data->telp }}</th>
      </tr>
      <tr>
        <td>Pekerjaan/Tempat Kerja</td>
        <td>:</td>
        <th>{{ $data->pekerjaan }}</th>
      </tr>
    </table>

    <table class="table table-striped mt-3">
      <caption style="caption-side: top;color: white" class="bg-primary p-2 font-weight-bold">Detail Kunjungan</caption>
      <tr>
        <td width="25%">Ruang/Bidang</td>
        <td width="1">:</td>
        <th>{{ $data->nama_ruang }}</th>
      </tr>
      <tr>
        <td>Tanggal Kunjungan</td>
        <td>:</td>
        <th>{{ $data->cin->locale('id')->translatedFormat('j F Y') }}</th>
      </tr>
      <tr>
        <td>Tujuan Kunjungan</td>
        <td>:</td>
        <th>{{ $data->tujuan }}</th>
      </tr>
      <tr>
        <td>Status</td>
        <td>:</td>
        <th id="status">
          @if (is_null($data->status))
            <span class="p-1 pl-2 pr-2 alert alert-warning">Menunggu Konfirmasi</span>
          @elseif ($data->status)
            <span class="p-1 pl-2 pr-2 alert alert-success">Disetujui</span>
          @elseif ($data->status==0)
            <span class="p-1 pl-2 pr-2 alert alert-danger">Ditolak</span>
          @endif
        </th>
      </tr>
      <tr class="dstatus {{ is_null($data->status)?'d-none':'' }}">
        <td>Disetujui/Ditolak oleh</td>
        <td>:</td>
        <th>{{ $data->approved_by??'-' }}</th>
      </tr>
      <tr class="dstatus {{ is_null($data->status)?'d-none':'' }}">
        <td>Keterangan</td>
        <td>:</td>
        <th>{{ $data->keterangan??'-' }}</th>
      </tr>
    </table>

    @if (is_null($data->status))
      <div class="mt-5">
        <div class="row">
          <form class="col-md-6 offset-md-3" action="{{ route('notif.action',['uuid'=>$data->uuid]) }}" method="post">
            @csrf
            <div class="form-group">
              <select class="form-control" name="action" required>
                <option value="">Pilih Aksi</option>
                <option {{ $data->status==1?'selected':'' }} value="1">Terima</option>
                <option {{ !is_null($data->status)&&$data->status==0?'selected':'' }} value="0">Tolak</option>
              </select>
            </div>
            <div class="form-group">
              <textarea name="keterangan" rows="5" class="form-control" placeholder="Keterangan" required>{{ $data->keterangan }}</textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" style="width: 100%">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
  @if (session()->has('message'))
    showSuccessToast('{{ session()->get('message') }}')
  @elseif ($errors->any())
    @foreach ($errors->all() as $key => $err)
      showDangerToast('{{ $err }}')
    @endforeach
  @endif
</script>
@endsection
