<?php

namespace Modules\Guest\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\RelationTrait;


class Guest extends Model
{
  use SoftDeletes, TableColumnsTrait, RelationTrait;

  protected $dates = ['deleted_at'];

  protected $table = 'guests';

  protected $guarded = [];

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'user_agent' => [
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

  public function getIncrementing()
  {
    return false;
  }

  public function getKeyType()
  {
    return 'string';
  }

  public function pages() {
    return $this->hasMany(GuestPage::class);
  }

  protected $casts = [
    'params' => 'collection'
  ];
}
