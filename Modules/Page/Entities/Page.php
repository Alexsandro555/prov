<?php
namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\CoreTrait;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\ActiveTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Page extends Model
{
	use SoftDeletes, CoreTrait, TableColumnsTrait, SortTrait, ActiveTrait, Cachable;

  protected $guarded=[];

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

	protected $dates = ['deleted_at','updated_at'];
}
