<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
  protected $table = 'guest';

  protected $casts = [
    'cin'=>'datetime',
    'cout'=>'datetime'
  ];

  public function getRatingTextAttribute()
  {
    if (!$this->rating) {
      return null;
    }
    switch ($this->rating) {
      case 5:
        $text = 'Memuaskan';
        break;
      case 4:
        $text = 'Sangat Baik';
        break;
      case 3:
        $text = 'Baik';
        break;
      case 2:
        $text = 'Buruk';
        break;
      default:
        $text = 'Mengecewakan';
        break;
    }

    return $text;
  }

  public function ruang()
  {
    return $this->belongsTo(Ruang::class,'ruang_id');
  }

  public function token()
  {
    return $this->hasMany(UserToken::class,'type_id')->where('type','guest');
  }

  public function notif()
  {
    return $this->hasOne(Notification::class,'target');
  }
}
