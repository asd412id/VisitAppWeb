@extends('layouts.master')
@section('title',$title)
@section('head_icon')
  <i class="ik ik-bar-chart-2 bg-blue"></i>
@endsection
@section('head_title',$title)
@section('head_desc',$subtitle)
@section('breadcrumb')
  <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection
@section('content')
<div class="row clearfix">
  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="widget bg-primary">
      <div class="widget-body">
        <div class="d-flex justify-content-between align-items-center">
          <div class="state">
            <h6>Hari Ini</h6>
            <h2>{{ $guestDay }}</h2>
          </div>
          <div class="icon">
            <i class="ik ik-users"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="widget bg-success">
      <div class="widget-body">
        <div class="d-flex justify-content-between align-items-center">
          <div class="state">
            <h6>Pekan Ini</h6>
            <h2>{{ $guestWeek }}</h2>
          </div>
          <div class="icon">
            <i class="ik ik-users"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="widget bg-warning">
      <div class="widget-body">
        <div class="d-flex justify-content-between align-items-center">
          <div class="state">
            <h6>Bulan Ini</h6>
            <h2>{{ $guestMonth }}</h2>
          </div>
          <div class="icon">
            <i class="ik ik-users"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="widget bg-danger">
      <div class="widget-body">
        <div class="d-flex justify-content-between align-items-center">
          <div class="state">
            <h6>Total Pengunjung</h6>
            <h2>{{ $guestAll }}</h2>
          </div>
          <div class="icon">
            <i class="ik ik-users"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
