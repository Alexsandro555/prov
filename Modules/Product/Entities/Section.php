<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\LineProduct;
use Barryvdh\Debugbar;

class Section extends Model
{
  protected $guarded = [];

  public function lineProducts()
  {
    return $this->belongsToMany(LineProduct::class);
  }

  public function getLineProductIdsAttribute() {
    return $this->lineProducts->map(function($item) {
      return $item->id;
    })->all();
  }

  protected $appends = ['LineProductIds'];
}
