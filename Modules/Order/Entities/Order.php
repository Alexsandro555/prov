<?php

namespace Modules\Order\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class Order extends Model
{
    protected $guarded = [];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function products() {
      return $this->belongsToMany(Product::class)->withPivot('price', 'qty');
    }
}
