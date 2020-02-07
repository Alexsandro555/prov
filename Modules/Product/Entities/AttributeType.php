<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\RelationTrait;
use Modules\Initializer\Traits\SortTrait;

class AttributeType extends Model
{
  use SoftDeletes, CoreTrait, SortTrait, RelationTrait;

  const BOOLEAN = 1;
  const STRING = 2;
  const INTEGER = 3;
  const DOUBLE = 4;
  const DATE = 5;
  const TEXT = 6;
  const DECIMAL = 7;
  const LIST = 8;

  protected $guarded = [];

  protected $table = 'attribute_types';

  static public function load_all()
  {
    return true;
  }

  public function attributes() {
    return $this->hasMany(Attribute::class);
  }
}
