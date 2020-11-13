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
use Auth;
use Validator;
use Storage;
use Carbon\Carbon;
use PDF;
use Str;

class MainController extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function __construct()
  {
    $this->configs = Configs::getAll();
  }

  public function index()
  {
    $now = Carbon::now();
    $guestAll = Guest::whereNotNull('cin')
    ->when(auth()->user()->role!='admin',function($q,$r){
      $q->where('ruang_id',auth()->user()->ruang_id);
    })
    ->count();
    $guestMonth = Guest::whereNotNull('cin')
    ->when(auth()->user()->role!='admin',function($q,$r){
      $q->where('ruang_id',auth()->user()->ruang_id);
    })
    ->where('cin','>=',$now->copy()->startOfMonth()->format('Y-m-d H:i:s'))
    ->where('cin','<=',$now->copy()->endOfMonth()->format('Y-m-d H:i:s'))
    ->count();
    $guestWeek = Guest::whereNotNull('cin')
    ->when(auth()->user()->role!='admin',function($q,$r){
      $q->where('ruang_id',auth()->user()->ruang_id);
    })
    ->where('cin','>=',$now->copy()->startOfWeek()->format('Y-m-d H:i:s'))
    ->where('cin','<=',$now->copy()->endOfWeek()->format('Y-m-d H:i:s'))
    ->count();
    $guestDay = Guest::whereNotNull('cin')
    ->when(auth()->user()->role!='admin',function($q,$r){
      $q->where('ruang_id',auth()->user()->ruang_id);
    })
    ->where('cin','>=',$now->copy()->startOfDay()->format('Y-m-d H:i:s'))
    ->where('cin','<=',$now->copy()->endOfDay()->format('Y-m-d H:i:s'))
    ->count();

    $data = [
      'title' => 'Beranda',
      'subtitle' => 'Status Data Tamu',
      'guestAll' => $guestAll,
      'guestMonth' => $guestMonth,
      'guestWeek' => $guestWeek,
      'guestDay' => $guestDay
    ];

    return view('index',$data);
  }

  public function sysConf()
  {
    $data = [
      'title'=>'Pengaturan Sistem',
      'config'=>auth()->user()->role!='admin'?auth()->user()->configs_all:Configs::getAll()
    ];

    return view('config-sistem',$data);
  }

  public function sysConfUpdate(Request $r)
  {
    $filepathLogo = null;
    $filepathLoginBG = null;

    if ($r->hasFile('login_bg') && auth()->user()->role=='admin') {
      $login_bg = $r->file('login_bg');
      $allowed_ext = ['jpg','jpeg','png'];
      $peta_ext = $login_bg->getClientOriginalExtension();

      if ($login_bg->getSize() > (1024*1000)) {
        return redirect()->back()->withErrors('Ukuran File Background Login tidak boleh lebih dari 1MB')->withInput();
      }elseif (!in_array(strtolower($peta_ext),$allowed_ext)) {
        return redirect()->back()->withErrors('File Background Login harus berekstensi jpg, jpeg, atau png')->withInput();
      }

      $getloginbg = Configs::where('config','login_bg')->first();
      if ($getloginbg) {
        Storage::disk('public')->delete($getloginbg->value);
      }

      $filepathLoginBG = $login_bg->store('file_configs','public');
      $data = [
        'config'=>'login_bg',
        'value'=>$filepathLoginBG
      ];
      Configs::updateOrCreate(['config'=>'login_bg'],$data);
    }

    if ($r->hasFile('logo')) {
      $logo = $r->file('logo');
      $allowed_ext = ['jpg','jpeg','png'];
      $peta_ext = $logo->getClientOriginalExtension();

      if ($logo->getSize() > (1024*1000)) {
        return redirect()->back()->withErrors('Ukuran File Logo 1 tidak boleh lebih dari 1MB')->withInput();
      }elseif (!in_array(strtolower($peta_ext),$allowed_ext)) {
        return redirect()->back()->withErrors('File Logo 1 harus berekstensi jpg, jpeg, atau png')->withInput();
      }

      $getLogo = Configs::where('config','logo')
      ->first();
      if ($getLogo) {
        Storage::disk('public')->delete($getLogo->value);
      }

      $filepathLogo = $logo->store('file_configs','public');
      $data = [
        'config'=>'logo',
        'value'=>$filepathLogo
      ];
      Configs::updateOrCreate(['config'=>'logo'],$data);
    }

    $insert = null;
    foreach ($r->config as $key => $value) {
      $data = [
        'config'=>$key,
        'value'=>$value
      ];
      $insert = Configs::updateOrCreate(['config'=>$key],$data);
    }

    if ($insert) {
      return redirect()->route('configs')->with('message','Data berhasil disimpan');
    }
  }

  public function login()
  {
    $data = [
      'config'=>Configs::getAll(),
      'title' => 'Masuk Halaman Admin  - '.(@Configs::getAll()->nama_ruang??'UPTD SMP NEGERI 39 SINJAI')
    ];

    return view('login',$data);
  }

  public function loginProcess(Request $r)
  {
    $roles = [
      'username' => 'required',
      'password' => 'required'
    ];

    $messages = [
      'username.required' => 'Username tidak boleh kosong!',
      'password.required' => 'Password tidak boleh kosong!'
    ];

    Validator::make($r->all(),$roles,$messages)->validate();

    if (Auth::attempt([
      'username'=>$r->username,
      'password'=>$r->password,
    ],($r->remember?true:false))) {
      return redirect()->back();
    }

    return redirect()->back()->withErrors(['Username atau password tidak sesuai!'])->withInput($r->only('username','remember'));
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('login');
  }

  public function profile()
  {
    $data = [
      'title'=>'Pengaturan Akun',
      'data'=>auth()->user()
    ];

    return view('profile',$data);
  }

  public function profileUpdate(Request $r)
  {
    $roles = [
      'old_password' => 'required'
    ];

    $messages = [
      'old_password.required' => 'Password tidak boleh kosong!'
    ];

    $roles['name'] = 'required';
    $roles['username'] = 'required|unique:users,username,'.auth()->user()->uuid.',uuid';
    $messages['name.required'] = 'Nama tidak boleh kosong!';
    $messages['username.required'] = 'Username tidak boleh kosong!';
    $messages['username.unique'] = 'Username telah digunakan!';

    Validator::make($r->all(),$roles,$messages)->validate();

    $cek = auth()->validate(['id'=>auth()->user()->id,'password'=>$r->old_password]);

    if ($cek) {
      $user = User::where('id',auth()->user()->id)
      ->first();
      $user->name = $r->name;
      $user->username = $r->username;
      if ($r->new_password!='') {
        $user->password = $r->new_password;
      }
      $user->save();
      return redirect()->back()->withMessage('Profil berhasil diubah!');
    }

    return redirect()->back()->withErrors(['Password tidak sesuai!']);
  }

  public function deleteImg($img)
  {
    $config = !auth()->user()->is_admin?auth()->user()->configs()->where('config',$img)->first():Configs::where('config',$img)->whereNull('ruang_id')->first();
    if ($config && $config->value) {
      Storage::disk('public')->delete($config->value);
      if ($config->delete()) {
        return redirect()->route('configs')->withMessage('Logo berhasil dihapus!');
      }
    }
    return redirect()->back()->withErrors(['Logo gagal dihapus!']);
  }

  public function genKey($url)
  {
    $k = Str::random(10);
    if (strpos($url,$k)!==false) {
      return $this->genKey($url);
    }
    return $k;
  }

  public function printQR()
  {
    $user = auth()->user();
    $configs = $user->configs_all;
    $alamat_server = @Configs::getAll()->alamat_server;
    $url = base64_encode($alamat_server??url('/'));
    $min = ceil(strlen($url)/2);
    $u2 = substr($url,0,$min);
    $u1 = substr($url,$min,strlen($url));

    $key = $this->genKey($url);

    $generate = $u1.'.'.$user->ruang->uuid.'.'.$key.'.'.$u2;

    $uuid = str_replace('=',$key,$generate);

    $data = [
      'title' => 'Kode QR Buku Tamu - '.@$configs->nama_ruang??'UPTD SMPN 39 SINJAI',
      'uuid'=>$uuid,
      'configs'=>$configs,
    ];

    $params = [
      'page-width'=>'21.5cm',
      'page-height'=>'33cm',
    ];

    $filename = $data['title'].'.pdf';

    $pdf = PDF::loadView('configs.print',$data)
    ->setOptions($params);
    return $pdf->stream($filename);

  }

}
