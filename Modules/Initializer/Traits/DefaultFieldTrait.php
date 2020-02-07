<?php

namespace Modules\Initializer\Traits;

use Modules\Initializer\Events\ListValueSaved;

trait DefaultFieldTrait {
  protected static function bootDefaultFieldTrait() {
    static::creating(function ($model) {
      if(request('default')) {
        $model->default = true;
      }
    });

    static::saved(function($model) {
      event(new ListValueSaved($model));
    });
  }
}