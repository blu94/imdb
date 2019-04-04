<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //
    protected $fillable = [
      "title",
      "usage",
      "path",
      "format",
      "size",
      "orders",
      "user_id",
      "assetable_id",
      "assetable_type",
    ];

    public function assetable()
    {
      return $this->morphTo();
    }
}
