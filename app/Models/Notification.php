<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  protected $table = 'notification';
  protected $fillable = ['uuid','type','type_id','message','status','target'];
  protected $dates =['created_at','updated_at'];

  public function user()
  {
    return $this->belongsTo(User::class,'target');
  }

  public function guest()
  {
    return $this->belongsTo(Guest::class,'target');
  }
}
