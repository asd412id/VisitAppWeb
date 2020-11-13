@extends('guestpage.layout')
@section('title',$title)
@section('head')
<style media="print">
caption{
  color: #000 !important;
}
#print-wrap{
  display: none;
}
</style>
<script>
  var token_url = '{{ route('ajax.token.guest.store') }}';
</script>
@endsection
@section('content')
  <div class="wrap-contact100">
    <div class="container-fluid text-center">
      @if (@$configs->logo)
        <img style="width: 55px;margin-top:-45px;margin-bottom: 10px" src="{{ asset('uploaded/'.$configs->logo) }}" alt="">
      @endif
    </div>

    <span class="contact100-form-title" style="font-size: 1.5em">
      Status Kunjungan<br>
      {{ @$configs->nama_instansi }}
    </span>

    <table>
      <tr style="font-size: 1.5em">
        <th width="135">ID Request</th>
        <th class="pl-1 pr-1" width="1">:</th>
        <th><span class="alert alert-primary p-1 pl-3 pr-3" id="id-request">{{ $data->id_request }}</span></th>
      </tr>
      <tr>
        <td colspan="3"><span class="text-danger">(*Mohon dicatat <b><em>ID Request</em></b> untuk digunakan ketika mengecek status kunjungan)</span></td>
      </tr>
    </table>
    <div class="clearfix"></div>

    <table class="table table-striped mt-3">
      <caption style="caption-side: top;color: white" class="bg-primary p-2 font-weight-bold">Data Anda</caption>
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
      <caption style="caption-side: top;color: white" class="bg-primary p-2 font-weight-bold">Data Kunjungan</caption>
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
        <th id="{{ is_null($data->status)?'status':'' }}">
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
        <th id="approved_by">{{ $data->approved_by??'-' }}</th>
      </tr>
      <tr class="dstatus {{ is_null($data->status)?'d-none':'' }}">
        <td>Keterangan</td>
        <td>:</td>
        <th id="keterangan">{{ $data->keterangan??'-' }}</th>
      </tr>
    </table>

    <div class="text-center mt-5" id="print-wrap">
      <button type="button" class="btn btn-lg btn-success" onclick="window.print()"><i class="fa fa-fw fa-print"></i> Cetak</button>
    </div>

  </div>
  <audio id="notif-tone" class="d-none">
    <source src="{{ asset('assets/tones/notif.mp3') }}" type="audio/mp3">
  </audio>
@endsection
