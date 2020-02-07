<?php

namespace Modules\Initializer\Traits;

trait ReactivityTrait {
  protected static function bootReactivityTrait() {
    static::saving(function ($model) {
      //$attributes = $model->getConncetion()->getSchemaBuilder()->get
    });

    static::saved(function($model) {

    });
  }
}