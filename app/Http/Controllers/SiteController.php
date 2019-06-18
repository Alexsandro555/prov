<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Product\Entities\Product;
//use Modules\Article\Entities\Article;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\TypeProduct;
use Modules\Product\Entities\LineProduct;
use Modules\News\Entities\News;
use Modules\Product\Entities\AttributeGroup;
use Modules\Product\Entities\Attribute;

class SiteController extends Controller
{
  public function index()
  {
    $ourProducts = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('type_product_id',1)->where('active',1)->inRandomOrder()->take(2)->get();
    $news = News::inRandomOrder()->take(4)->get();
    return view('index', compact('ourProducts', 'news'));
  }

  public function catalog($slug)
  {
    $model = ProductCategory::with(['typeProducts' => function ($query) {
      $query->where('active', 1);
    }])->where('url_key', $slug)->first();
    /*$products = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('product_category_id', $model->id)->where('active',1)->paginate(30);*/
    return view('catalog', compact('model'));
  }

  public function typeProduct($slugProductCategory, $slug)
  {
    $model = TypeProduct::with(['lineProducts' => function($query) {
      $query->where('active',1);
    }])->where('url_key', $slug)->firstOrFail();
    $products = Product::with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('type_product_id', $model->id)->paginate(30);
    //return view('catalog', compact('model'));

    //$products = Product::with(['attributes','files'])->where('type_product_id', $model->id)->where('active',1)->get();
    $attributes = Attribute::with(['attributeListValue'])->where('attribute_type_id', 8)->where('filtered', 1)->where('active',1)->get();
    return view('lineProduct', compact('model', 'products', 'attributes'));
  }

  public function lineProduct($slugProductCategory, $slugTypeProduct, $slug)
  {
    $model = LineProduct::where('url_key', $slug)->firstOrFail();
    $products = Product::with(['attributes','files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('line_product_id', $model->id)->where('active',1)->get();
    $attributes = Attribute::with(['attributeListValue'])->where('attribute_type_id', 8)->where('filtered', 1)->where('active',1)->get();
    return view('lineProduct', compact('model', 'products', 'attributes'));
  }

  public function menuLeft() {
    return ProductCategory::with(['typeProducts' => function($query) {
      $query->where('active',1)->orderBy('sort');
    }, 'typeProducts.lineProducts' => function($query) {
      $query->where('active', 1)->orderBy('sort');
    }])->where('active',1)->orderBy('sort')->get();
  }

  public function detail($slug) {
    $groups = AttributeGroup::orderBy('sort', 'asc')->get();
    $product = Product::with(
      [
        'files',
        'attributes.attributeListValue',
        'lineProduct.attributes.attribute_type' => function($query) {
             $query->where('title', 'Списковый');
        }, 'lineProduct.attributes.attributeListValue',
        'typeProduct.attributes.attribute_type' => function($query) {
          $query->where('title', 'Списковый');
        }, 'typeProduct.attributes.attributeListValue',
        'productCategory.attributes.attribute_type' => function($query) {
          $query->where('title', 'Списковый');
        }, 'productCategory.attributes.attributeListValue',
        'skus.attributes'
      ])->where('url_key',$slug)->first();
    return view('detail', compact('product', 'groups'));
  }

  public function products() {
    $products = Product::with(['attributes' => function($query) {
      $query->where('attribute_type_id', 8);
    },'files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('product_category_id', 2)->get();
    $attributes = Attribute::with(['attributeListValue'])->where('attribute_type_id', 8)->where('filtered', 1)->get();
    /*$attributes = ProductCategory::with(['attributes.attributeListValue', 'attributes' => function($query) {
      dd($query);
      $query->where('attribute_type_id' === 8);
    }])->find(2)->attributes;*/
    return view('test', compact('products', 'attributes'));
  }
}
