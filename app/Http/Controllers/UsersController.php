<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\User;
use Validator;
use DataTables;
use Str;

class UsersController extends Controller
{
  public function index()
  {
    if (request()->ajax()) {
      $data = User::orderBy('name','asc')
      ->where('id','!=',auth()->user()->id)->with('ruang');
      return DataTables::of($data)
      ->addColumn('tgl_dibuat',function($row){
        return $row->tgl_dibuat;
      })
      ->addColumn('ruang',function($row){
        return $row->nama_ruang;
      })
      ->addColumn('action', function($row){

        $btn = '<div class="table-actions">';

        if (\Auth::user()->role == 'admin') {
          $btn .= ' <a href="'.route('users.edit',['uuid'=>$row->uuid]).'" class="text-primary" title="Ubah"><i class="ik ik-edit"></i></a>';

          $btn .= ' <a href="'.route('users.destroy',['uuid'=>$row->uuid]).'" class="text-danger confirm" data-text="Hapus data '.$row->name.'?" title="Hapus"><i class="ik ik-trash-2"></i></a>';
        }

        $btn .= '</div>';

        return $btn;
      })
      ->rawColumns(['ruang','action'])
      ->make(true);
    }
    $data = [
      'title'=>'Pengguna',
      'subtitle'=>'Daftar Pengguna',
    ];
    return view('users.index',$data);
  }

  public function create()
  {
    $data = [
      'title'=>'Pengguna Baru',
      'subtitle'=>'Tambah Pengguna Baru',
    ];
    return view('users.create',$data);
  }

  public function store(Request $r)
  {
    $rules = [
      'name'=>'required',
      'username'=>'required|unique:users,username',
      'password'=>'required|confirmed',
      'role'=>'required',
    ];

    $msgs = [
      'name.required'=>'Nama Lengkap tidak boleh kosong!',
      'username.required'=>'Username tidak boleh kosong!',
      'username.unique'=>'Username telah digunakan!',
      'password.required'=>'Password tidak boleh kosong!',
      'password.confirmed'=>'Perulangan Password tidak benar!',
      'role.required'=>'Role harus dipilih!',
    ];

    if ($r->role=='operator') {
      $rules['ruang'] = 'required';
      $msgs['ruang.required'] = 'ruang harus dipilih!';
    }

    Validator::make($r->all(),$rules,$msgs)->validate();

    $insert = new User;
    $insert->uuid = Str::uuid();
    $insert->name = $r->name;
    $insert->username = $r->username;
    $insert->password = $r->password;
    $insert->role = $r->role;

    if ($insert->save()) {
      if ($r->role == 'operator') {
        $insert->ruang()->attach($r->ruang);
      }
      return redirect()->route('users.index')->with('message','Data berhasil disimpan!');
    }
    return redirect()->back()->withErrors('Data gagal disimpan!');
  }

  public function edit($uuid)
  {
    $user = User::where('uuid',$uuid)->first();
    $data = [
      'title'=>'Ubah Pengguna',
      'subtitle'=>'Ubah Data Pengguna',
      'data'=>$user,
    ];
    return view('users.edit',$data);
  }

  public function update(Request $r,$uuid)
  {
    $insert = User::where('uuid',$uuid)->first();
    $rules = [
      'name'=>'required',
      'username'=>'required|unique:users,username,'.$uuid.',uuid',
      'role'=>'required',
    ];

    $msgs = [
      'name.required'=>'Nama Lengkap tidak boleh kosong!',
      'username.required'=>'Username tidak boleh kosong!',
      'username.unique'=>'Username telah digunakan!',
      'role.required'=>'Role harus dipilih!',
    ];

    if ($r->password) {
      $rules['password'] = 'required|confirmed';
      $msgs['password.required'] = 'Password tidak boleh kosong!';
      $msgs['password.confirmed'] = 'Perulangan Password tidak benar!';
    }

    if ($r->role=='operator') {
      $rules['ruang'] = 'required';
      $msgs['ruang.required'] = 'ruang harus dipilih!';
    }

    Validator::make($r->all(),$rules,$msgs)->validate();

    $insert->name = $r->name;
    $insert->username = $r->username;
    if ($r->password) {
      $insert->password = $r->password;
    }
    $insert->role = $r->role;

    if ($insert->save()) {
      if ($r->role == 'operator') {
        $insert->ruang()->sync($r->ruang);
      }
      return redirect()->route('users.index')->with('message','Data berhasil disimpan!');
    }
    return redirect()->back()->withErrors('Data gagal disimpan!');
  }

  public function destroy($uuid)
  {
    $user = User::where('uuid',$uuid)->first();
    $user->ruang()->detach();
    $user->user_token()->delete();
    if ($user->delete()) {
      return redirect()->route('users.index')->with('message','Data berhasil dihapus!');
    }
    return redirect()->back()->withErrors('Data gagal dihapus!');
  }
}
