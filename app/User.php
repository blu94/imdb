<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
       "name",
       "email",
       "email_verified_at",
       "password",
       "role_id",
       "birthday",
       "gender",
       "bio",
     ];


     public function isAdmin() {
       if($this->role->codeName == "admin") {
         return true;
       }
       return false;
     }

     public function role ()
    {
      return $this->belongsTo('App\Role');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function assets()
    {
      return $this->morphMany("App\Asset", "assetable");
    }

    public function thumbnail()
    {
      return $this->assets()->where("usage", "PROFILE_IMAGE")->first();
    }

    public function thumbnailPath ()
    {
      if (count($this->thumbnail()) > 0) {
        return $this->thumbnail()->path;
      }
      return "https://via.placeholder.com/70x70";
    }

    public function meta ()
    {
      return $this->morphMany("App\Meta", "metaable")->orderBy("orders", "ASC");
    }
}
