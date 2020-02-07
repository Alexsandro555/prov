<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\ProductCategory;

class ProductCategoryController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new ProductCategory;
  }
}
