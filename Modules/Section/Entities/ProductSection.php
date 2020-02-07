<?php

namespace Modules\Section\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Product\Entities\Product;

class ProductSection extends Model
{
  use CoreTrait;

  protected $table = 'product_section';

  protected $dates = ['deleted_at'];

  protected $guarded = [];

  public function section() {
    return $this->belongsTo(Section::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
