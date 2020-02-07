<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Initializer\Traits\ActiveTrait;

class Producer extends Model
{
  use SoftDeletes, CoreTrait, TableColumnsTrait, SortTrait, Sluggable, ActiveTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = ['computed'];

  public $hidden = ['remote_id', 'url_key'];

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

  public function lineProducts() {
    return $this->belongsToMany(LineProduct::class);
  }
}
