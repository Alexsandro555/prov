<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\DefaultFieldTrait;
use Modules\Initializer\Traits\TableColumnsTrait;

class AttributeListValues extends Model
{
  use SoftDeletes, SortTrait, TableColumnsTrait, CoreTrait, DefaultFieldTrait;

  protected $guarded = [];

  public function attributes() {
    return $this->belongsTo(Attribute::class);
  }

  public $matched = ['attribute_id'];

  protected $dates = ['deleted_at'];

  public function getRules()
  {
    return [
      'title' => 'max:255'
    ];
  }

}
