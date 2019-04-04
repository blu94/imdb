<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    //
    protected $fillable = [
      "type",
      "status",
      "user_id",
      "orders",
      "data",
      "metaable_id",
      "metaable_type",
    ];

    public function getDataAttribute($value)
    {
      $data = @unserialize($value);
      if ($data !== false) {
          return unserialize($value);
      } else {
          return $value;
      }
    }

    public function user ()
    {
      return $this->belongsTo("App\User");
    }

    public function metaable() {
      return $this->morphTo();
    }
}
