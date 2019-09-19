<?php

namespace Modules\Guest\Entities;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\RelationTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


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
    ]
  ];

  /**
   * Store a newly created guest
   *
   * @param Request $request
   */
  public function store($userAgent)
  {
    $this->id = (string) Str::uuid();
    $this->user_agent = $userAgent;
    $this->save();
  }

  public function storePath($params, $ip, $path, $referer)
  {
    if(!preg_match('/^192.168./', $ip)) {
      $this->pages()->create([
        'url' => $path,
        'params' => $params,
        'utm_source' => Arr::get($params, 'utm_source', null),
        'utm_medium' => Arr::get($params, 'utm_medium', null),
        'utm_campaign' => Arr::get($params, 'utm_campaign', null),
        'utm_content' => Arr::get($params, 'utm_content', null),
        'utm_term' => Arr::get($params, 'utm_term', null),
        'referer' => $referer,
        'ip' => $ip
      ]);
    }
  }

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
}
