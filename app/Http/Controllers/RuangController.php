<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Ruang;

use Validator;
use DataTables;
use Str;

class RuangController extends Controller
{
  public function index()
  {
    if (request()->ajax()) {
      if (auth()->user()->isAdmin) {
        $data = Ruang::orderBy('nama','asc');
      }else {
        $data = auth()->user()->ruang()->orderBy('nama','asc');
      }
      return DataTables::of($data)
      ->addColumn('status_text',function($row){
        return $row->status_text;
      })
      ->addColumn('action', function($row){

        $btn = '<div class="table-actions">';

        $btn .= ' <a href="'.route('ruang.edit',['uuid'=>$row->uuid]).'" class="text-primary" title="Ubah"><i class="ik ik-edit"></i></a>';
        if (\Auth::user()->role == 'admin') {
          $btn .= ' <a href="'.route('ruang.destroy',['uuid'=>$row->uuid]).'" class="text-danger confirm" data-text="Hapus data '.$row->nama.'?" title="Hapus"><i class="ik ik-trash-2"></i></a>';
        }

        $btn .= '</div>';

        return $btn;
      })
      ->rawColumns(['status_text','action'])
      ->make(true);
    }
    $data = [
      'title'=>'Ruang',
      'subtitle'=>'Daftar Ruang',
    ];
    return view('ruang.index',$data);
  }

  public function create()
  {
    $data = [
      'title'=>'Ruang Baru',
      'subtitle'=>'Tambah Ruang Baru',
    ];
    return view('ruang.create',$data);
  }

  public function store(Request $r)
  {
    $rules = [
      'nama'=>'required|unique:ruang,nama',
    ];

    $msgs = [
      'nama.required'=>'Nama ruang tidak boleh kosong!',
      'nama.unique'=>'Nama ruang telah digunakan!',
    ];

    if ($r->telp) {
      $rules['telp'] = 'numeric';
      $msgs['telp.numeric'] = 'Format nomor telepon tidak benar!';
    }

    Validator::make($r->all(),$rules,$msgs)->validate();

    $insert = new ruang;
    $insert->uuid = (string) Str::uuid();
    $insert->nama = $r->nama;
    $insert->kepala = $r->kepala;
    $insert->telp = $r->telp;
    $insert->status = $r->status;

    if ($insert->save()) {
      return redirect()->route('ruang.index')->with('message','Data berhasil disimpan!');
    }
    return redirect()->back()->withErrors('Data gagal disimpan!');
  }

  public function edit($uuid)
  {
    $ruang = Ruang::where('uuid',$uuid)->first();
    $data = [
      'title'=>'Update Ruang',
      'subtitle'=>'Update Data Ruang',
      'data'=>$ruang,
    ];
    return view('ruang.edit',$data);
  }

  public function update(Request $r,$uuid)
  {
    $insert = Ruang::where('uuid',$uuid)->first();

    $rules = [
      'nama'=>'required|unique:ruang,nama,'.$uuid.',uuid',
    ];

    $msgs = [
      'nama.required'=>'Nama ruang tidak boleh kosong!',
      'nama.unique'=>'Nama ruang telah digunakan!',
    ];

    if ($r->telp) {
      $rules['telp'] = 'numeric';
      $msgs['telp.numeric'] = 'Format nomor telepon tidak benar!';
    }

    Validator::make($r->all(),$rules,$msgs)->validate();

    $insert->nama = $r->nama;
    $insert->kepala = $r->kepala;
    $insert->telp = $r->telp;
    $insert->status = $r->status;

    if ($insert->save()) {
      return redirect()->route('ruang.index')->with('message','Data berhasil disimpan!');
    }
    return redirect()->back()->withErrors('Data gagal disimpan!');
  }

  public function destroy($uuid)
  {
    $ruang = Ruang::where('uuid',$uuid)->first();
    $ruang->user()->detach();
    if ($ruang->delete()) {
      return redirect()->route('ruang.index')->with('message','Data berhasil dihapus!');
    }
    return redirect()->back()->withErrors('Data gagal dihapus!');
  }
}
