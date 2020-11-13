<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
  protected $table = 'user_token';
  protected $fillable = ['type','type_id','token'];
}
