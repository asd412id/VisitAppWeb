<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\Guest;
use App\ruang;
use Str;
use Carbon\Carbon;

class MobileApiController extends Controller
{
  public function __construct()
  {
    $this->err_code = 403;
    $this->acc_code = 202;
    $this->err_msg = 'Akses Ditolak!';
  }

  public function index(Request $r)
  {
    $ruang = Ruang::where('_token',$r->header('ruang'))->first();
    $code = $this->err_code;
    if (!$ruang) {
      $data = [
        'status'=>'error',
        'message'=>'Kode QR tidak dikenali!'
      ];
    }else{
      $dataruang = $ruang;
      $configs = $ruang->configs_all;
      $dataruang->nama = @$configs->nama_ruang??$ruang->nama;
      if ($configs && @$configs->start_clock && @$configs->end_clock) {
        $start = Carbon::createFromFormat('H:i',$configs->start_clock);
        $end = Carbon::createFromFormat('H:i',$configs->end_clock);
        $now = Carbon::now();
        if ($now->lessThan($start) || $now->greaterThan($end)) {
          $data = [
            'status'=>'error',
            'message'=>"Jam kunjungan tidak tersedia!\nSilahkan berkunjung pada pukul ".$configs->start_clock." s.d. ".$configs->end_clock
          ];
        }else{
          $code = $this->acc_code;
          $data = [
            'status'=>'connected',
            'data'=>$dataruang
          ];
        }
      }else {
        $code = $this->acc_code;
        $data = [
          'status'=>'connected',
          'data'=>$dataruang
        ];
      }
    }
    return $this->returnResponse($data,$code);
  }

  public function startVisit(Request $r)
  {
    $ruang = Ruang::where('_token',$r->header('ruang'))->first();
    $code = 500;
    if (!$ruang) {
      $data = [
        'status'=>'error',
        'message'=>'Kode QR tidak dikenali!'
      ];
    }else {
      $guest = json_decode($r->header('user-data'));
      $configs = $ruang->configs_all;
      $ruang->nama = @$configs->nama_ruang??$ruang->nama;

      $insert = new Guest;
      $insert->uuid = Str::uuid();
      $insert->nama = $guest->nama;
      $insert->alamat = $guest->alamat;
      $insert->telp = $guest->telp;
      $insert->pekerjaan = $guest->pekerjaan;
      $insert->tujuan = $guest->tujuan;
      $insert->anggota = @$guest->anggota?explode("\n",$guest->anggota):null;
      $insert->cin = Carbon::now();
      $insert->cout = null;
      $insert->rating = null;
      $insert->kesan = null;
      $insert->ruang_id = $ruang->id;
      $insert->_token = $guest->_token;

      if ($insert->save()) {
        $insert->start_visit = $insert->cin->locale('id')->translatedFormat('j F Y H:i');
        $insert->ruang = $ruang;
        $code = $this->acc_code;
        $data = [
          'status'=>'success',
          'data'=>$insert
        ];
      }else {
        $data = [
          'status'=>'error',
          'message'=>'Permintaan tidak dapat diproses!'
        ];
      }
    }
    return $this->returnResponse($data,$code);
  }

  public function endVisit(Request $r)
  {
    $guest = Guest::where('uuid',$r->header('visitid'))
    ->whereNull('cout')
    ->first();
    $code = $this->err_code;
    if (!$guest) {
      $data = [
        'status'=>'error',
        'message'=>'Anda belum berkunjung sebelumnya!'
      ];
    }else {
      $guest->cout = Carbon::now();
      $guest->rating = $r->header('rating');
      $guest->kesan = $r->header('kesan');
      $ruang = $guest->getruang;
      $configs = $ruang->configs_all;
      $ruang->nama = @$configs->nama_ruang??$ruang->nama;

      if ($guest->save()) {
        $code = $this->acc_code;
        $guest->start_visit = $guest->cin->locale('id')->translatedFormat('j F Y H:i');
        $guest->end_visit = $guest->cout->locale('id')->translatedFormat('j F Y H:i');
        $guest->ruang = $ruang;
        $data = [
          'status'=>'success',
          'data'=>$guest
        ];
      }else {
        $data = [
          'status'=>'error',
          'message'=>'Permintaan tidak dapat diproses!'
        ];
      }
    }
    return $this->returnResponse($data,$code);
  }

  public function returnResponse($data,$code)
  {
    return response()->json($data,$code);
  }
}
