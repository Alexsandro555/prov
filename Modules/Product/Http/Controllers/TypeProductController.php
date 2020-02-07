<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\TypeProduct;

class TypeProductController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new TypeProduct();
  }


}
