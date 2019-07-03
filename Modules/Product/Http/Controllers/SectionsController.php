<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\Section;

class SectionsController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Section;
  }

  public function index() {
    return $this->model::with('lineProducts')->where('active', 1)->get();
  }
}
