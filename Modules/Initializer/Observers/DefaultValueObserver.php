<?php

namespace Modules\Initializer\Observers;

use Illuminate\Database\Eloquent\Model;

class DefaultValueObserver {
  public function creating(Model $model) {
    if(request('default')) {
      if($model->_defaultFiled) {
        $collection = $model::where($model->_defaultField, request($model->_defaultField))->get();
        $collection->each(function($item) {
          $item->defailt = 0;
        })->save();
        $collection = $model->findOrFail(request('id'));
        $collection->default = 1;
        $collection->save();
      }
    }
  }
}