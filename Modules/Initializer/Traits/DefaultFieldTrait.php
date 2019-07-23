<?php

namespace Modules\Initializer\Traits;

use Illuminate\Support\Facades\DB;
use Modules\Initializer\Events\ListValueSaved;
use Illuminate\Support\Facades\Event;

trait DefaultFieldTrait {
  protected static function bootDefaultFieldTrait() {
    static::creating(function ($model) {
      if(request('default')) {
        $model->default = true;
      }
    });

    static::saved(function($model) {
      Event::fire(new ListValueSaved($model));
    });
  }
}