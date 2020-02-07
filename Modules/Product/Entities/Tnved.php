<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\TableColumnsTrait;

class Tnved extends Model
{
  use SoftDeletes, TableColumnsTrait, CoreTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = [];

  public $hidden = ['remote_id'];

  static public function load_all()
  {
    return true;
  }

  public function typeProducts() {
    return $this->hasMany(TypeProduct::class);
  }
}
