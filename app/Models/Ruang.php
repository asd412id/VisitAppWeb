<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
  protected $table = 'ruang';

  protected $fillable = ['uuid','nama','kepala','telp'];

  public function user()
  {
    return $this->belongsToMany(User::class,'user_ruang');
  }

  public function getStatusTextAttribute()
  {
    return $this->status?'<span class="badge badge-success">Aktif</span>':'<span class="badge badge-danger">Tidak Aktif</span>';
  }

  public function configs()
  {
    return $this->hasMany(Configs::class,'ruang_id');
  }

  public function getConfigsAllAttribute()
  {
    $configs = $this->configs()
    ->get()
    ->pluck('value','config')
    ->toArray();

    return (object) $configs;
  }
}
