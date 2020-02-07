<?php
namespace Modules\Callback\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\RelationTrait;
use Modules\Initializer\Traits\TableColumnsTrait;

class Callback extends Model
{
  use SoftDeletes, RelationTrait, TableColumnsTrait;

	protected $guarded=[];

	protected $dates = ['deleted_at','updated_at'];
}
