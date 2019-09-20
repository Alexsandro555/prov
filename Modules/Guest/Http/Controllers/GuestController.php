<?php

namespace Modules\Guest\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Guest\Entities\Guest;
use Modules\Initializer\Traits\DefaultTrait;

class GuestController extends Controller
{
  Use ControllerTrait, DefaultTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Guest();
  }
}
