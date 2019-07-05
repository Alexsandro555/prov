<?php

namespace Modules\Initializer\Traits;

use Illuminate\Support\Facades\DB;

trait DefaultFieldTrait {
  protected static function bootDefaultFieldTrait() {
    static::saving(function ($model) {
      if(request('default')) {
        if($model->_defaultField) {
          DB::table('attribute_list_values')->where($model->_defaultField, request($model->_defaultField))->update(['default' => 0]);
          $model->default = 1;
        }
      }
    });
  }
}