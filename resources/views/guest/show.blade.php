@extends('guest.layouts.master')
@section('log-content')
  <div class="col-sm-12 text-center">
    @if (count($data))
      @include('guest.layouts.table')
    @else
      <div class="alert alert-info">
        <h5 class="m0 p0">Data pengunjung tidak tersedia!</h5>
      </div>
    @endif
  </div>
@endsection
