<?php

namespace Modules\Initializer\Traits;

use Illuminate\Http\Request;

trait DefaultTrait {

  public $model;

  public function create(Request $request) {
    $normTitle = str_replace("/"," ",$request->title);
    $this->model = $this->model->firstOrNew(['url_key' =>  \Slug::make($normTitle), 'active' => 1]);
    $this->model->fill($request->all());
    $this->model->save();
    return $this->model;
  }
}