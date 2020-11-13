<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use App\Models\Configs;
use App\Models\Guest;
use App\Models\Ruang;
use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Auth;
use Validator;
use Storage;
use Carbon\Carbon;
use PDF;
use Str;

class NotificationController extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function __construct()
  {
    $this->configs = Configs::getAll();
  }

  public function index()
  {
    $user = auth()->user();
    $notifs = Notification::where('type','ruang')
    ->whereIn('type_id',$user->ruang->pluck('id')->toArray())
    ->orderBy('created_at','desc')
    ->paginate(15);
    $data = [
      'title'=>'Notifikasi',
      'config'=>$this->configs,
      'data'=>$notifs,
    ];

    return view('notif.index',$data);
  }

  public function show($uuid)
  {
    $user = auth()->user();
    $guest = Guest::where('uuid',$uuid)
    ->whereIn('ruang_id',$user->ruang->pluck('id')->toArray())
    ->first();

    if (!$guest) {
      return redirect()->route('notif.index')->withErrors(['Data tidak ditemukan']);
    }

    $guest->notif()->update([
      'status' => true
    ]);

    $data = [
      'title'=>'Detail Notifikasi ('.$guest->id_request.')',
      'config'=>$this->configs,
      'data'=>$guest,
    ];

    return view('notif.show',$data);
  }

  public function action($uuid, Request $r)
  {
    $user = auth()->user();
    $guest = Guest::where('uuid',$uuid)
    ->whereIn('ruang_id',$user->ruang->pluck('id')->toArray())
    ->first();

    if (!$guest) {
      return redirect()->route('notif.index')->withErrors(['Data tidak ditemukan']);
    }

    $guest->status = $r->action;
    $guest->keterangan = $r->keterangan;
    $guest->approved_by = $user->name;

    if ($guest->save()) {
      if (count($guest->token)) {
        if (@$this->configs->logo) {
          $logo = asset('uploaded/'.@$this->configs->logo);
        }else{
          $logo = url('assets/img/gbook.png');
        }
        foreach ($guest->token as $key => $t) {
          $data = [
            'to' => $t->token,
            'data' => [
              'type' => 'guest',
              'id' => $guest->id_request,
              'action' => $guest->status,
              'keterangan' => $guest->keterangan,
              'approved_by' => $guest->approved_by,
              'message' => 'Permintaan kunjungan Anda '.($guest->status?'disetujui':'ditolak!'),
              'url' => route('visit.status',['uuid'=>$guest->uuid]),
              'icon' => $logo,
            ]
          ];
          $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.getenv('FIREBASE_SERVER_TOKEN')
            ])->post('https://fcm.googleapis.com/fcm/send',$data);

          if ($response->ok()) {
            $t->delete();
          }
        }
      }
      return redirect()->back()->with('message','Permintaan berhasil ditindaklanjuti');
    }

    return redirect()->back()->withErrors(['Sistem bermasalah']);
  }

  public function destroy($uuid)
  {
    $guest = Guest::where('uuid',$uuid)->first();
    if (!$guest) {
      return redirect()->route('notif.index')->withErrors(['Data tidak ditemukan']);
    }
    $guest->token()->delete();
    $guest->notif()->delete();
    if ($guest->delete()) {
      return redirect()->back()->with('message','Permintaan kunjungan berhasil dihapus');
    }
  }
}
