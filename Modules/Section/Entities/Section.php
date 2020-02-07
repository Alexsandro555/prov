<?php

namespace Modules\Section\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\ActiveTrait;
use Modules\Product\Entities\Product;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Section extends Model
{
  use SoftDeletes, TableColumnsTrait, CoreTrait, SortTrait, ActiveTrait, Cachable;

  protected $dates = ['deleted_at'];

  public $hidden = ['remote_id'];

  protected $guarded = [];

  static public function load_all()
  {
    return true;
  }

  public function getRules()
  {
    return [
      'title' => 'max:255'
    ];
  }

  public function products()
  {
    return $this->belongsToMany(Product::class);
  }

  public function productSections()
  {
    return $this->hasMany(ProductSection::class);
  }
}
