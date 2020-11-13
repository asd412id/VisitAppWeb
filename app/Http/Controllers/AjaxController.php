<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\UserToken;
use App\Models\Notification;
use App\Models\Guest;

class AjaxController extends BaseController
{

  public function searchruang(Request $r)
  {
    if ($r->ajax()) {
      $data['results'] = [];
      $users = \App\Models\Ruang::when($r->term,function($q,$role){
        $search = "%".$role."%";
        $q->where('nama','like',$search)
        ->orWhere('kepala','like',$search)
        ->orWhere('telp','like',$search);
      })
      ->select('id','nama')
      ->orderBy('nama','asc')
      ->get();
      if (count($users)) {
        foreach ($users as $key => $u) {
          array_push($data['results'],[
            'id' => $u->id,
            'text' => $u->nama
          ]);
        }
      }

      return response()->json($data);
    }

    return response()->json([
      'status'=>'error',
      'message'=>'Page not Found'
    ],404);
  }

  public function storeToken(Request $r)
  {
    if ($r->u_type == 'user') {
      $user = auth()->user();
    }else {
      $user = Guest::where('id_request',$r->id_request)->first();
    }

    $cek = UserToken::where('type',$r->u_type)
    ->where('type_id',$user->id)
    ->where('token',$r->token)->first();

    if (!$cek) {
      $token = new UserToken;
      $token->type = $r->u_type;
      $token->type_id = $user->id;
      $token->token = $r->token;

      if ($token->save()) {
        return response()->json([
          'status' => 'success',
          'data' => $token
        ],201);
      }
    }else {
      return response()->json([
        'status' => 'success',
        'data' => $cek
      ],200);
    }

    return response()->json([
      'status'=>'error',
      'message'=>'Page not Found'
    ],404);
  }

  public function storeNotification(Request $r)
  {
    $user = auth()->user();

    $data = json_decode($r->payload);

    $token = new Notification;
    $token->type = 'guest';
    $token->type_id = $user->id;
    $token->token = $r->token;

    if ($token->save()) {
      return response()->json([
        'status' => 'success',
        'data' => $token
      ],201);
    }


    return response()->json([
      'status'=>'error',
      'message'=>'Page not Found'
    ],404);
  }

}
