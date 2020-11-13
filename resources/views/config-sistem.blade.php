@extends('layouts.master')
@section('title',$title)
@section('header')
  <link rel="stylesheet" href="{{ url('assets/vendor/jquery.datetimepicker/jquery.datetimepicker.min.css') }}">
@endsection
@section('head_icon')
  <i class="ik ik-settings bg-red"></i>
@endsection
@section('head_title',$title)
@section('head_desc','Pengaturan Informasi Sistem')
@section('breadcrumb')
  <li class="breadcrumb-item active" aria-current="page">Pengaturan Sistem</li>
@endsection

@section('content')
  @include('configs.umum')
@endsection
@section('footer')
<script src="{{ url('assets/vendor/jquery.datetimepicker/jquery.datetimepicker.full.min.js') }}" charset="utf-8"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#start_clock').datetimepicker({
      format:'H:i',
      onShow:function( ct ){
        let end_clock = $('#end_clock').val();
        this.setOptions({
          maxTime:end_clock?end_clock:false
        })
      },
      datepicker: false,
      step: 5
    });
    $('#end_clock').datetimepicker({
      format:'H:i',
      onShow:function( ct ){
        let start_clock = $('#start_clock').val();
        this.setOptions({
          minTime:start_clock?start_clock:false
        })
      },
      datepicker: false,
      step: 5
    });
  })

  @if (session()->has('message'))
    showSuccessToast('{{ session()->get('message') }}')
  @elseif ($errors->any())
    @foreach ($errors->all() as $key => $err)
      showDangerToast('{{ $err }}')
    @endforeach
  @endif
</script>
@endsection
