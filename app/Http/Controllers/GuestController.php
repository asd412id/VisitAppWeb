<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Models\Guest;
use Carbon\Carbon;
use App\Models\Configs;
use PDF;

class GuestController extends Controller
{
  public function index()
  {
    $data = [
      'title' => 'Data Pengunjung',
      'subtitle' => 'Lihat Data Pengunjung',
      'ruang' => null
    ];
    return view('guest.index',$data);
  }

  public function show(Request $r)
  {

    $dates = Carbon::parse($r->start_date)->toPeriod($r->end_date);

    $logs = [];
    $dformat = "Y-m-d H:i:s";
    foreach ($dates as $key => $d) {
      $guest = Guest::orderBy('cin','asc')
      ->where('cin','>=',$d->startOfDay()->format($dformat))
      ->where('cin','<=',$d->endOfDay()->format($dformat));
      if (!auth()->user()->is_admin) {
        $guest = $guest->whereIn('ruang_id',auth()->user()->ruang->pluck('id')->toArray());
      }
      $guest = $guest->get();
      if (count($guest)) {
        foreach ($guest as $key1 => $g) {
          $logs[$key]['tanggal'] = $d;
          $logs[$key]['data'][$key1] = $g;
        }
      }
    }

    $data = [
      'title' => 'Data Pengunjung',
      'subtitle' => 'Lihat Data Pengunjung',
      'data' => $logs,
      'configs' => \App\Models\Configs::getAll(),
    ];

    if ($r->download_pdf) {
      if (!count($logs)) {
        return redirect()->route('guest.index')->withErrors(['Data pengunjung tidak tersedia!']);
      }
      if ($r->start_date!=$r->end_date) {
        $tgl = Carbon::parse($r->start_date)->locale('id')->translatedFormat('j F Y').' s.d. '.Carbon::parse($r->end_date)->locale('id')->translatedFormat('j F Y');
      }else {
        $tgl = Carbon::parse($r->start_date)->locale('id')->translatedFormat('j F Y');
      }
      $data['title'] = ($r->title??'Data Pengunjung').' ('.$tgl.')';

      $params = [
        'format'=>[215,330]
      ];
      if (!request()->user||count($users)>1) {
        $params['orientation'] = 'L';
      }

      $filename = $data['title'].'.pdf';

      $pdf = PDF::loadView('guest.print',$data,[],$params);
      return $pdf->stream($filename);

    }

    return view('guest.show',$data);
  }
}
