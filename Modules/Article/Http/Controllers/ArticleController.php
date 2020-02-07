<?php

namespace Modules\Article\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Article\Models\Article;

class ArticleController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model=new Article;
  }

  public function list() {
    $articles = Article::with('files')->get();
    return view('article::index', compact('articles'));
  }

  public function show($slug) {
    $article = Article::where('url_key', $slug)->firstOrFail();
    return view('article::show', compact('article'));
  }
}
