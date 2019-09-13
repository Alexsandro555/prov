<?php

namespace Modules\Faq\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\SortTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\RelationTrait;

class Faq extends Model
{
  use SoftDeletes, TableColumnsTrait, RelationTrait, SortTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = [];

  protected $table = 'faqs';

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'title' => [
      'enabled' => true,
      'validations' => [
        'required' => true
      ]
    ],
    'answer' => [
      'enabled' => true,
    ],
    'meta_description' => [
      'enabled' => true,
    ],
    'meta_keywords' => [
      'enabled' => true,
    ],
    'active' => [
      'enabled' => true
    ],
    'sort' => [
      'enabled' => true
    ],
    'email' => [
      'enabled' => true
    ]
  ];

}
