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
    ],
    'utm_source' => [
      'enabled' => true,
    ],
    'utm_medium' => [
      'enabled' => true,
    ],
    'utm_campaign' => [
      'enabled' => true,
    ],
    'utm_content' => [
      'enabled' => true,
    ],
    'utm_term' => [
      'enabled' => true,
    ],
    'params' => [
      'enabled' => true,
    ]
  ];

  public function guest() {
    return $this->belongsTo(Guest::class);
  }


  protected $casts = [
    'params' => 'collection'
  ];
}
