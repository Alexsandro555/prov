<?php

namespace Modules\Section\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Section\Entities\Section;

class SectionController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Section();
  }

  public function set(Request $request)
  {
    $request->session()->put('section', $request->section_id);
    return $request->section_id;
  }
}
