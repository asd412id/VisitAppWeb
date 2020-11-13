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

class VisitController extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function __construct()
  {
    $this->configs = Configs::getAll();
  }

  public function index()
  {

    $data = [
      'title' => 'Selamat Datang'.(@$this->configs->nama_instansi??' - '),
      'configs' => $this->configs
    ];

    return view('guestpage.index',$data);
  }

  public function check(Request $r)
  {
    $roles = [
      'id_request' => 'required',
      'g-recaptcha-response' => 'required|captcha',
    ];
    $messages = [
      'id_request.required' => 'ID Request tidak boleh kosong!',
      'g-recaptcha-response.required' => 'Pastikan anda bukan robot! Captcha harus dicentang!',
      'g-recaptcha-response.captcha' => 'Captcha tidak benar! Silahkan coba kembali!',
    ];
    Validator::make($r->all(),$roles,$messages)->validate();

    $guest = Guest::where('id_request',$r->id_request)->first();
    if (!$guest) {
      return redirect()->route('visit.index')->withErrors(['ID Request tidak ditemukan!']);
    }

    return redirect()->route('visit.status',['uuid'=>$guest->uuid]);
  }

  public function formKunjungan()
  {

    $data = [
      'title' => 'Form Kunjungan'.(@$this->configs?' - '.$this->configs->nama_instansi:''),
      'configs' => $this->configs,
      'ruang' => Ruang::whereHas('user')->orderBy('nama','asc')->get()
    ];

    return view('guestpage.form',$data);
  }

  public function store(Request $r)
  {
    $roles = [
      'name' => 'required',
      'pekerjaan' => 'required',
      'telp' => 'required',
      'tgl_berkunjung' => 'required',
      'ruang' => 'required',
      'tujuan' => 'required',
      'g-recaptcha-response' => 'required|captcha',
    ];
    $messages = [
      'name.required' => 'Nama lengkap tidak boleh kosong!',
      'pekerjaan.required' => 'Pekerjaan tidak boleh kosong!',
      'telp.required' => 'Nomor telepon tidak boleh kosong!',
      'tgl_berkunjung.required' => 'Tanggal kunjungan tidak boleh kosong!',
      'ruang.required' => 'Bidang/Ruang harus dipilih!',
      'tujuan.required' => 'Tujuan kunjungan tidak boleh kosong!',
      'g-recaptcha-response.required' => 'Pastikan anda bukan robot! Captcha harus dicentang!',
      'g-recaptcha-response.captcha' => 'Captcha tidak valid! Silahkan coba kembali!',
    ];
    Validator::make($r->all(),$roles,$messages)->validate();

    $ruang = Ruang::find($r->ruang);

    if (!$ruang) {
      return redirect()->back()->withErrors(['Bidang/Ruang tidak tersedia!']);
    }

    $guest = new Guest;
    $guest->uuid = (string) Str::uuid();
    $guest->nama = $r->name;
    $guest->alamat = $r->alamat;
    $guest->telp = $r->telp;
    $guest->pekerjaan = $r->pekerjaan;
    $guest->alamat = $r->alamat;
    $guest->tujuan = $r->tujuan;
    $guest->cin = Carbon::createFromFormat('d/m/Y',$r->tgl_berkunjung)->format('Y-m-d 00:00:00');
    $guest->ruang_id = $ruang->id;
    $guest->nama_ruang = $ruang->nama;

    if ($guest->save()) {
      $token = strtoupper(Str::random(3));
      $guest->id_request = 'DS'.$token.'-'.$guest->id;
      $guest->save();

      if (count($ruang->user)) {
        foreach ($ruang->user as $key => $u) {
          $notif = new Notification;
          $notif->uuid = (string) Str::uuid();
          $notif->type = 'ruang';
          $notif->type_id = $ruang->id;
          $notif->target = $guest->id;
          $notif->message = $r->name.' ingin mengunjungi '.$ruang->nama.' pada tanggal '.$guest->cin->locale('id')->translatedFormat('j F Y');
          if ($notif->save()) {
            $this->sendNotification($u,$guest,$notif);
          }
        }
      }
      return redirect()->route('visit.status',['uuid'=>$guest->uuid]);
    }
    return redirect()->back()->withErrors(['Sistem bermasalah!']);
  }

  public function sendNotification($u,$g,$n)
  {
    if (count($u->token)) {
      if (@$this->configs->logo) {
        $logo = asset('uploaded/'.@$this->configs->logo);
      }else{
        $logo = url('assets/img/gbook.png');
      }
      foreach ($u->token as $key => $t) {
        $data = [
          'to' => $t->token,
          'data' => [
            'id' => $n->type_id,
            'type' => 'ruang',
            'message' => $n->message,
            'url' => route('notif.show',['uuid'=>$g->uuid]),
            'icon' => $logo,
          ]
        ];
        $response = Http::withHeaders([
          'Content-Type' => 'application/json',
          'Authorization' => 'Bearer '.getenv('FIREBASE_SERVER_TOKEN')
          ])->post('https://fcm.googleapis.com/fcm/send',$data);

        if ($response->ok()) {
          $r = $response->json();
          if ($r['failure'] > 0) {
            $t->delete();
          }
        }
      }
    }
  }

  public function status($uuid=null)
  {
    $guest = Guest::where('uuid',$uuid)->first();
    if (!$uuid || !$guest) {
      return redirect()->route('visit.index')->withErrors(['ID Request tidak ditemukan!']);
    }

    $data = [
      'title' => 'Status Kunjungan'.(@$this->configs?' - '.$this->configs->nama_instansi:''),
      'configs' => $this->configs,
      'data' => $guest
    ];

    return view('guestpage.status',$data);
  }

}
