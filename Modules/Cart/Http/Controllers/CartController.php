<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Cart;
use Illuminate\Support\Facades\Config;


class CartController extends Controller
{

    /**
     * Get array elements in cart
     * @return array
     */
    private function getCart() {
      $cart = Cart::content()->toArray();
      $arr = [];
      foreach($cart as $key=>$elem) {
        $arr[] = $elem;
      }
      return $arr;
    }


    /**
     * Get current cart
    * @return array
    */
    public function index() {
      return  [
        'cart' => $this->getCart(),
        'count' => Cart::count(),
        'total' => Cart::subtotal()
      ];
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('cart::create');
    }


    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function store(Request $request)
    {
      $product = Product::with(['files', 'lineProduct.files' => function($query) {
        $query->doesntHave('figure');
      }, 'typeProduct.files' => function($query) {
        $query->doesntHave('figure');
      }, 'productCategory.files' => function($query) {
        $query->doesntHave('figure');
      }])->findOrFail($request->id);

      /*if($product->productCategory && $product->productCategory->files->count()>0) {
        foreach($product->productCategory->files->random()->config as $filesItem) {
          foreach($filesItem as $key => $fileItem) {
            if($key == 'medium') {
              $filename = $fileItem['filename'];
            }
          }
        }
      } else if($product->typeProduct && $product->typeProduct->files->count()>0) {
        foreach($product->typeProduct->files->random()->config as $filesItem) {
          foreach($filesItem as $key => $fileItem) {
            if($key == 'medium') {
              $filename = $fileItem['filename']
            }
          }
        }
      } else if($product->lineProduct && $product->lineProduct->files->count()>0) {
        foreach($product->lineProduct->files->random()->config as $filesItem) {
          foreach($filesItem as $key => $fileItem) {
            if($key == 'medium') {
              $filename = $fileItem['filename']
            }
          }
        }
      } else {
        $filename = "/images/no-image-small.png";
      }*/

      Cart::add($product->id, $product->title, $request->count, $request->price?$request->price:$product->price,
        [
          'type'=>$product->productCategory->title,
          'slug'=> '/catalog/detail/'.$product->url_key,
          'filename'=>'/images/no-image-small.png'
        ]
      );
      $total = Cart::subtotal();
      $count = Cart::count();
      return $this->getCart();
    }

    public function setQty($id, $qty) {
      Cart::update($id,$qty);
      return [];
    }

    /**
     * @return array
     */
    public function current() {
      $total = Cart::subtotal();
      $count = Cart::count();
      return ["total"=>$total,"count"=>$count];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
      return view('cart::index');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('cart::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * @param $rowId
     * @return array
     */
    public function destroy($rowId)
    {
      if($rowId) {
        Cart::remove($rowId);
        return [];
      }
    }
}
