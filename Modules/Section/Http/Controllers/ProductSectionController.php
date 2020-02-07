<?php

namespace Modules\Section\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Section\Entities\ProductSection;

class ProductSectionController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new ProductSection();
  }
}
