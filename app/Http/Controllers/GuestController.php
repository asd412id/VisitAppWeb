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
      'title' => 'Data Tamu',
      'subtitle' => 'Lihat Data Tamu',
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
      ->when($r->ruang,function($q,$r){
        $q->where('ruang_id',$r);
      })
      ->where('cin','>=',$d->startOfDay()->format($dformat))
      ->where('cin','<=',$d->endOfDay()->format($dformat))
      ->get();
      if (count($guest)) {
        foreach ($guest as $key1 => $g) {
          $logs[$key]['tanggal'] = $d;
          $logs[$key]['data'][$key1] = $g;
        }
      }
    }

    $ruang = \App\Ruang::find($r->ruang);

    $data = [
      'title' => 'Data Tamu',
      'subtitle' => 'Lihat Data Tamu',
      'data' => $logs,
      'ruang' => $ruang,
      'configs' => !auth()->user()->is_admin?auth()->user()->configs_all:$ruang->configs_all
    ];

    if ($r->download_pdf) {
      if (!count($logs)) {
        return redirect()->route('guest.index')->withErrors(['Data tamu tidak tersedia!']);
      }
      if ($r->start_date!=$r->end_date) {
        $tgl = Carbon::parse($r->start_date)->locale('id')->translatedFormat('j F Y').' s.d. '.Carbon::parse($r->end_date)->locale('id')->translatedFormat('j F Y');
      }else {
        $tgl = Carbon::parse($r->start_date)->locale('id')->translatedFormat('j F Y');
      }
      $data['title'] = ($r->title??'Data Tamu').' ('.$tgl.')';

      $params = [
        'page-width'=>'21.5cm',
        'page-height'=>'33cm',
      ];
      $params['orientation'] = 'landscape';

      $filename = $data['title'].'.pdf';

      $pdf = PDF::loadView('guest.print',$data)
      ->setOptions($params);
      return $pdf->download($filename);

    }

    return view('guest.show',$data);
  }
}
