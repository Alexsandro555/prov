<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Initializer\Traits\ActiveTrait;

class AttributeGroup extends Model
{
  use SoftDeletes, CoreTrait, TableColumnsTrait, SortTrait, Sluggable, ActiveTrait;

  protected $guarded = [];

  protected $dates = ['deleted_at'];

  public $hidden = ['remote_id', 'url_key'];

  public function getRules()
  {
    return [
      'title' => 'max:50'
    ];
  }

  static public function load_all()
  {
    return true;
  }

  public function sluggable(): array
  {
    return [
      'url_key' => [
        'source' => 'title'
      ]
    ];
  }

  public function attributes() {
    return $this->hasMany(Attribute::class);
  }
}
