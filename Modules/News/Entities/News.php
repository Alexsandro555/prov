<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Files\Entities\File;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Modules\Initializer\Scopes\ActiveScope;

class News extends Model
{
  use SoftDeletes, CoreTrait, TableColumnsTrait, Sluggable, Cachable;

  protected $dates = ['deleted_at','updated_at'];

  protected $guarded = [];

  public function getRules()
  {
    return [
      'title' => 'max:255'
    ];
  }

  static public function load_all()
  {
    return true;
  }

  public function scopeLast($query)
  {
    $query->orderBy('updated_at','DESC')->take(4);
  }

  public function sluggable(): array
  {
    return [
      'url_key' => [
        'source' => 'title'
      ]
    ];
  }

  public function files() {
    return $this->morphMany(File::class, 'fileable');
  }

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new ActiveScope);
  }

}
