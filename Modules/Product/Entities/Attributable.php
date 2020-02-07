<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;

class Attributable extends Model
{
  use SoftDeletes, CoreTrait;

  protected $guarded = ['id'];

  public function attribute()
  {
    return $this->belongsTo(Attribute::class);
  }
}
