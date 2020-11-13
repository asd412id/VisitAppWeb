@extends('layouts.master')
@section('title',$title)
@section('head_icon')
  <i class="ik ik-bell bg-blue"></i>
@endsection
@section('head_title',$title)
@section('head_desc','Daftar Notifikasi Permintaan Kunjungan')
@section('breadcrumb')
  <li class="breadcrumb-item active" aria-current="page">Notifikasi</li>
@endsection

@section('content')
  <a href="{{ route('notif.index') }}" id="newnotif" class="d-none">
    <div class="alert alert-info text-center h6">
      Ada permintaan baru! Klik untuk merefresh halaman!
    </div>
  </a>
  @if (count($data))
    @foreach ($data as $key => $v)
      @php
        $tc = '<span class="badge badge-warning">Belum Dikonfirmasi</span>';
        if (!is_null($v->guest->status)) {
          $tc = $v->guest->status?'<span class="badge badge-success">Disetujui</span>':'<span class="badge badge-danger">Ditolak</span>';
        }
      @endphp
      <div class="card m-1">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-11">
              <a href="{{ route('notif.show',['uuid'=>$v->guest->uuid]) }}">
                <em class="text-muted">{{ $v->created_at->locale('id')->translatedFormat('j F Y H:i:s') }}</em>
                <h6 class="m-0 {{ !$v->status?'font-weight-bold':'' }}">{{ $v->message }} {!! $tc !!}</h6>
              </a>
            </div>
            <div class="col-sm-1 text-right pt-1">
              <a href="{{ route('notif.destroy',['uuid'=>$v->guest->uuid]) }}" class="confirm btn btn-icon btn-outline-dark" data-text="Hapus permintaan kunjungan ini?">
                <i class="fas fa-times"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    <div class="text-center mt-3">
      <div class="d-inline-block">
        {!! $data->links() !!}
      </div>
    </div>
  @else
    <div class="card">
      <div class="card-body text-center">
        <h5 class="m-0">Tidak ada notifikasi</h5>
      </div>
    </div>
  @endif
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
