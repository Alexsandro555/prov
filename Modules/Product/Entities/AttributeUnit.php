<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Initializer\Traits\ActiveTrait;

class AttributeUnit extends Model
{
  use SoftDeletes, TableColumnsTrait, CoreTrait, SortTrait, Sluggable, ActiveTrait;

  protected $guarded = [];

  protected $dates = ['deleted_at'];

  public $hidden = ['remote_id', 'url_key'];

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

  static public function load_all()
  {
    return true;
  }

  public function attributes() {
    return $this->hasMany(Attribute::class);
  }
}
