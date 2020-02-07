<?php
namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\ActiveTrait;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Files\Entities\File;
use Cviebrock\EloquentSluggable\Sluggable;

class Article extends Model
{
  use SoftDeletes, CoreTrait, TableColumnsTrait, SortTrait, Sluggable, ActiveTrait;

	protected $guarded=[];

  protected $dates = ['deleted_at','updated_at'];

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

  public function sluggable(): array
  {
    return [
      'url_key' => [
        'source' => 'title'
      ]
    ];
  }

  public function setTitleAttribute($value) {
    $this->attributes['title'] = strip_tags($value);
  }

  public function files() {
    return $this->morphMany(File::class, 'fileable');
  }
}
