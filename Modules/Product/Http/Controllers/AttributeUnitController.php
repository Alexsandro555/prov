<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\AttributeUnit;
use Modules\Initializer\Traits\ControllerTrait;

class AttributeUnitController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new AttributeUnit();
  }
}
