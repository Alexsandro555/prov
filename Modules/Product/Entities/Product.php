<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\CoreTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Initializer\Traits\ActiveTrait;
use Modules\Files\Entities\File;
use Modules\Initializer\Scopes\ActiveScope;
use Greabock\Tentacles\EloquentTentacle;
use Modules\Section\Entities\ProductSection;
use Modules\Section\Entities\Section;
use Modules\Section\Scopes\SectionScope;

class Product extends Model
{
  use EloquentTentacle, SoftDeletes, TableColumnsTrait, CoreTrait, SortTrait, ActiveTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = ['attribute_values', 'computed'];

  public $hidden = ['remote_id'];

  public function getRules()
  {
    return [
      'title' => 'max:255'
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

  public function attributeValues()
  {
    return $this->hasMany(AttributeValue::class);
  }

  public function productSections()
  {
    return $this->hasMany(ProductSection::class);
  }

  public function attributes()
  {
    return $this->belongsToMany(Attribute::class, 'attribute_values')->withPivot('boolean_value', 'date_value', 'integer_value', 'string_value', 'decimal_value', 'text_value', 'list_value', 'double_value');
  }

  public function files()
  {
    return $this->morphMany(File::class, 'fileable');
  }

  public function sections()
  {
    return $this->belongsToMany(Section::class);
  }

  public function scopeWithFiles($query)
  {
    $query->with([
        'files' => function($query) {
            $query->where('type_file_id', 2);
        },
        'lineProduct.files' => function($query) {
            $query->where('type_file_id', 2)->doesntHave('figure');
        },
        'typeProduct.files' => function($query) {
            $query->where('type_file_id', 2)->doesntHave('figure');
        },
        'productCategory.files' => function($query) {
          $query->where('type_file_id', 2)->doesntHave('figure');
        }
    ]);
  }

  public function scopeSpecial($query)
  {
    $query->where('special',1);
  }

  public function scopeSale($query)
  {
    $query->where('onsale', 1);
  }

  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new ActiveScope);
    static::addGlobalScope(new SectionScope);
  }

  /*public function skus()
  {
    return $this->hasMany(Sku::class);
  }


  public function attr()
  {
    return $this->belongsToMany(Attribute::class, 'attribute_values')->withPivot('boolean_value', 'date_value', 'integer_value', 'string_value', 'decimal_value', 'text_value', 'list_value', 'double_value')->using(AttrVal::class);
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

  public function filesFigure()
  {
    return $this->hasManyDeep(Figure::class, [LineProduct::class, File::class], ['id', ['fileable_type', 'fileable_id'], 'file_id'], ['line_product_id', 'id', 'id']);
  }*/

  /*public function files()
  {
    return $this->morphMany(File::class, 'fileable');
  }*/

  /*public function getPricesAttribute()
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
  }*/

  //protected $appends = ['prices'];
}
