<?php

namespace Modules\Initializer\Traits;

use Illuminate\Http\Request;

trait UrlKeyTrait {
  protected static function bootUrlKeyTrait() {
    static::creating(function ($model) {
      $normTitle = str_replace("/"," ",$model->title);
      $model->url_key = \Slug::make($normTitle);
    });

    static::updating(function ($model) {
      /*if($request->has('title')) {
        $normTitle = str_replace("/"," ",$model->title);
        $model->url_key = \Slug::make($normTitle);
      }*/
    });
  }
}