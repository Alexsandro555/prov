<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\SortTrait;
use Modules\Files\Entities\File;
use Modules\Files\Entities\Figure;

class Product extends Model
{
  protected $table = 'products';

  use SoftDeletes, \Staudenmeir\EloquentHasManyDeep\HasRelationships, SortTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = ['attribute_values'];

  public function productCategory()
  {
    return $this->belongsTo(ProductCategory::class);
  }

  public function typeProduct()
  {
    return $this->belongsTo(TypeProduct::class);
  }

  public function lineProduct()
  {
    return $this->belongsTo(LineProduct::class);
  }

  public function attributes()
  {
    return $this->belongsToMany(Attribute::class, 'attribute_values')->withPivot('boolean_value', 'date_value', 'integer_value', 'string_value', 'decimal_value', 'text_value', 'list_value', 'double_value');
  }

  public function attr()
  {
    return $this->belongsToMany(Attribute::class, 'attribute_values')->withPivot('boolean_value', 'date_value', 'integer_value', 'string_value', 'decimal_value', 'text_value', 'list_value', 'double_value')->using(AttrVal::class);
  }

  public function attributeValues()
  {
    return $this->hasMany(AttributeValue::class);
  }

  public function attributesProductCategory()
  {
    return $this->hasManyDeep(Attribute::class, [ProductCategory::class, 'attributables'], ['id', ['attributable_type', 'attributable_id']]);
  }

  public function attributesTypeProduct()
  {
    return $this->hasManyDeep(Attribute::class, [TypeProduct::class, 'attributables'], ['id', ['attributable_type', 'attributable_id']]);
  }

  public function attributesLineProduct()
  {
    return $this->hasManyDeep(Attribute::class, [LineProduct::class, 'attributables'], ['id', ['attributable_type', 'attributable_id']]);
  }

  public function skus()
  {
    return $this->hasMany(Sku::class);
  }

  public function files()
  {
    return $this->morphMany(File::class, 'fileable');
  }

  public function filesFigure()
  {
    return $this->hasManyDeep(Figure::class, [LineProduct::class, File::class], ['id', ['fileable_type', 'fileable_id'], 'file_id'], ['line_product_id', 'id', 'id']);
  }

  public function getPricesAttribute()
  {
    $resultArr = [];
    $this->skus->each(function($sku) use (&$resultArr) {
      $arr = [];
      $arr['price'] = $sku->price;
      $sku->skuAttributes->each(function($attribute) use (&$arr) {
        $arr[$attribute->id] = $attribute->attribute_list_value_id;
      });
      array_push($resultArr, $arr);
    });
    return $resultArr;
  }

  protected $appends = ['prices'];
}
