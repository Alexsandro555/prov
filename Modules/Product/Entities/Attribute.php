<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Initializer\Traits\ActiveTrait;

class Attribute extends Model
{
  use SoftDeletes, CoreTrait, TableColumnsTrait, SortTrait, Sluggable, ActiveTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = ['computed'];

  public $hidden = ['remote_id', 'url_key'];

  public function getRules()
  {
    return [
      'title' => 'max:50'
    ];
  }

  public function sluggable(): array
  {
    return [
      'url_key' => [
        'source' => 'title'
      ]
    ];
  }

  protected $casts = [
    'computed' => 'collection'
  ];

  public function attributeUnit() {
    return $this->belongsTo(AttributeUnit::class);
  }

  public function attributeType() {
    return $this->belongsTo(AttributeType::class);
  }

  public function attributeGroup() {
    return $this->belongsTo(AttributeGroup::class);
  }

  public function attributeListValue() {
    return $this->hasMany(AttributeListValues::class);
  }

  public function attributeValue() {
    return $this->hasMany(AttributeValue::class);
  }

  public function productCategories() {
    return $this->morphedByMany(ProductCategory::class, 'attributable');
  }

  public function typeProducts() {
    return $this->morphedByMany(TypeProduct::class, 'attributable');
  }

  public function lineProducts() {
    return $this->morphedByMany(LineProduct::class, 'attributable');
  }


  public function prod() {
    return $this->belongsToMany(Product::class, 'attribute_values')->withPivot('boolean_value', 'date_value', 'integer_value', 'string_value', 'decimal_value', 'text_value', 'list_value', 'double_value')->using(AttrVal::class);
  }

  public function products() {
    return $this->belongsToMany(Product::class, 'attribute_values')->withPivot('boolean_value', 'date_value', 'integer_value', 'string_value', 'decimal_value', 'text_value', 'list_value');
  }
}
