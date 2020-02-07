<?php

namespace Modules\Initializer\Traits;

trait ActiveTrait {
  protected static function bootActiveTrait() {
    static::creating(function ($model) {
      $model->active = 1;
    });
  }
}