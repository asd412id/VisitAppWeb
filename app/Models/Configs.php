<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{
  protected $table = 'configs';

  protected $fillable = ['ruang_id','config','value'];
  public $timestamps = false;

  public static function getAll()
  {
    $configs = self::select('ruang_id','value','config')
    ->whereNull('ruang_id')
    ->get()
    ->pluck('value','config')
    ->toArray();

    return (object) $configs;
  }
}
