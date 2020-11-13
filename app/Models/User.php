<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'username', 'password', 'role', 'api_token'
    ];

    protected $dates = ['created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function setPasswordAttribute($value)
    {
      return $value?$this->attributes['password']=bcrypt($value):null;
    }

    public function ruang()
    {
      return $this->belongsToMany(Ruang::class,'user_ruang');
    }

    public function getNamaRuangAttribute()
    {
      $ruang = '-';
      if (count($this->ruang)) {
        $ruang = '';
        foreach ($this->ruang as $key => $r) {
          $ruang .= ' <span class="badge badge-primary">'.$r->nama.'</span> ';
        }
      }
      return $ruang;
    }

    public function configs()
    {
      return $this->hasMany(Configs::class,'ruang_id','ruang_id');
    }

    public function getTglDibuatAttribute()
    {
      return $this->created_at?$this->created_at->locale('id')->translatedFormat('j F Y'):null;
    }

    public function getConfigsAllAttribute()
    {
      $configs = $this->configs()
      ->get()
      ->pluck('value','config')
      ->toArray();

      return (object) $configs;
    }

    public function getIsAdminAttribute()
    {
      return $this->role=='admin';
    }

    public function token()
    {
      return $this->hasMany(UserToken::class,'type_id')->where('type','user');
    }

}
