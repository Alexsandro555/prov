<?php

namespace Modules\Callback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Callback\Http\Requests\CallbackRequest;
use Modules\Callback\Models\Callback;
use Modules\Callback\Emails\CallbackShipped;
use Illuminate\Support\Facades\Mail;

class CallbackController extends Controller
{
  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function store(CallbackRequest $request)
  {
    $model = Callback::create($request->all());
    Mail::to(config('info.manager_email'))->send(new CallbackShipped($model));
    return [];
  }
}
