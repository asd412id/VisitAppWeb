<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor') }}/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor') }}/bootstrap/dist/css/bootstrap.min.css">
    <style media="screen">
      html,body{
        width: 100%;height: 100%;margin: 0;padding: 0;
        /* font-size: 9pt !important; */
        font-family: Arial !important;
      }
      .page{
        padding: 0 20px;
      }
      .page-break{
        page-break-before: always;
      }
      .table{
        width: 100%;
        border: solid 1px #000;
        border-collapse: collapse;
        break-inside: auto;
      }
      .table th{
        text-align: center;
        vertical-align: middle !important;
      }
      .table th, .table td{
        border: solid 1px #000 !important;
        border-bottom: solid 1px #000;
        border-collapse: collapse;
      }
      .table td{
        text-align: center;
        vertical-align: top;
      }
      .text-center{
        text-align: center !important;
      }
      .nowrap{
        white-space: nowrap !important;
      }
      tr, td, th, tbody, thead, tfoot {
        page-break-inside: avoid !important;
        break-inside: avoid-page !important;
        page-break-before: auto !important;
        page-break-after: auto !important;
      }
      .nowrap{
        white-space: nowrap;
      }
      .wrap{
        white-space: normal;
      }
      .table-guest td{
        text-align: left;
      }
      .text-center{
        text-align: center;
      }
      .text-left{
        text-align: left;
      }
      ol{
        margin-left: 7px !important;
      }
    </style>
  </head>
  <body>
    @php
    if (@$configs->logo2) {
      $logo = asset('uploaded/'.@$configs->logo2);
    }elseif (@$configs->logo1) {
      $logo = asset('uploaded/'.@$configs->logo1);
    }else{
      $logo = url('assets/img/sinjai.png');
    }
    @endphp
    <div class="page">
      @include('layouts.kop')
      <h1 class="text-center">Kode QR Buku Pengunjung</h1>
      <div class="text-center">
        <img src="data:image/png;base64,{!! base64_encode(\QrCode::format('png')->errorCorrection('H')->merge($logo,.3,true)->size('435')->generate($_token)) !!}" alt="">
      </div>
      <p class="mt-30 mb-10 text-center">* Scan Kode QR Menggunakan Aplikasi Buku Pengunjung</p>
    </div>
  </body>
</html>
