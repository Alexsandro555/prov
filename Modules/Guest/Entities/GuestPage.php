<?php

namespace Modules\Guest\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\RelationTrait;

class GuestPage extends Model
{
  use SoftDeletes, TableColumnsTrait, RelationTrait;

  protected $dates = ['deleted_at'];

  protected $table = 'guest_pages';

  protected $guarded = [];

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'url' => [
      'enabled' => true,
    ],
    'referer' => [
      'enabled' => true,
    ],
    'ip' => [
      'enabled' => true,
    ]
  ];

  public function guest() {
    return $this->belongsTo(Guest::class);
  }
}
