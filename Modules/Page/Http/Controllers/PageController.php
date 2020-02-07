<?php

namespace Modules\Page\Http\Controllers;

use Modules\Page\Entities\Page;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;

class PageController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model=new Page;
  }

  public function show($slug) {
    $article = Page::where('url_key', $slug)->firstOrFail();
    return view('article::show', compact('article'));
  }
}
