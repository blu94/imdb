<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //
    protected $fillable = [
      "name",
      "releseDate",
      "plot",
      "user_id",
      "producer_id",
    ];

    public function meta ()
    {
      return $this->morphMany("App\Meta", "metaable")->orderBy("orders", "ASC");
    }

    public function actors ()
    {
      return $this->meta()->where("type", "ACTOR_IN_MOVIE");
    }

    public function producer ()
    {
      return $this->belongsTo("App\User", "producer_id");
    }

    public function assets ()
    {
      return $this->morphMany("App\Asset", "assetable")->orderBy("orders", "ASC");
    }

    public function assetImgs ()
    {
      return $this->morphMany("App\Asset", "assetable")
      ->where(function($q) {
        $q->where("format", "jpg");
        $q->orWhere("format", "jpeg");
        $q->orWhere("format", "png");
        $q->orWhere("format", "JPG");
        $q->orWhere("format", "JPEG");
        $q->orWhere("format", "PNG");
      })
      ->orderBy("orders", "ASC");
    }
}
