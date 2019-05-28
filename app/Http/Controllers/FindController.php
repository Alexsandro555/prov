<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Services\ProductService;

class FindController extends Controller
{
  public function index($text='', ProductService $service)
  {
    $products = $service->find($text);
    return view('find', compact('products', 'text'));
  }
}
