<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\RelationTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\UrlKeyTrait;

class AttributeGroup extends Model
{
  use SoftDeletes, RelationTrait, TableColumnsTrait, SortTrait, UrlKeyTrait;

  protected $table = 'attribute_groups';

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'title' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 255
      ]
    ]
  ];

  protected $guarded = [];

  public function attributes() {
    return $this->hasMany(Attribute::class);
  }
}
