<?php

namespace Modules\Callback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Callback\Models\Callback;
use Modules\Callback\Emails\CallbackShipped;
use Illuminate\Support\Facades\Mail;
use Modules\Initializer\Traits\ControllerTrait;

class CallbackController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Callback;
  }

  public function store(Request $request)
  {
    $model = new Callback;
    $model->fio = $request->fio;
    $model->telephone = $request->telephone;
    $model->comment = $request->comment;
    $model->save();
    Mail::to(config('info.manager_email'))->send(new CallbackShipped($model));
    return [];
  }
}
