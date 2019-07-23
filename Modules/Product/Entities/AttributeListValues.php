<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\DefaultFieldTrait;

class AttributeListValues extends Model
{
  use SoftDeletes, SortTrait, DefaultFieldTrait;

  protected $guarded = [];

  protected $table = 'attribute_list_values';

  public function attributes() {
    return $this->bolongsTo(Attribute::class);
  }

  public $matched = ['attribute_id'];

  public $unmatched = ['id'];
}
