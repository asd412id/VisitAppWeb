<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
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
        padding: 3px 5px;
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
      @page{
        margin: 15px;
      }
    </style>
  </head>
  <body>
    <div class="page">
      @include('layouts.kop')
      @if (count($data))
        @php
          $carbon = new \Carbon\Carbon;
          $tanggal = request()->start_date==request()->end_date?$carbon->createFromFormat('Y/m/d',request()->start_date)->locale('id')->translatedFormat('l, d F Y'):$carbon->createFromFormat('Y/m/d',request()->start_date)->locale('id')->translatedFormat('d F Y').' s.d. '.$carbon->createFromFormat('Y/m/d',request()->end_date)->locale('id')->translatedFormat('d F Y');
          $qr = 'Daftar Pengunjung - '.time().' - by asd412id';
        @endphp
        <h3 class="text-center" style="margin: 0">{{ request()->title??'Daftar Pengunjung' }}</h3>
        <p class="text-center" style="margin-top: 5px">{{ $tanggal }}</p>
        @include('guest.layouts.table')
      @endif
      @include('layouts.ttd')
    </div>
  </body>
</html>
