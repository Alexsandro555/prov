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
use Modules\Product\Entities\AttributeType;
use Modules\Product\Entities\AttributeValue;

class SiteController extends Controller
{
  public function index()
  {
    return view('index')->with('news', News::last()->get());
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
    $model = TypeProduct::with(['lineProducts'])->where('url_key', $slug)->firstOrFail();
    $products = Product::withFiles()->where('type_product_id', $model->id)->get();
    $attributes = Attribute::with(['attributeListValue'])->where('attribute_type_id', 8)->where('filtered', 1)->where('active', 1)->get();
    return view('lineProduct', compact('model', 'products', 'attributes'));
  }

  public function section($slugSection, $slugProductCategory, $slug)
  {
    $model = TypeProduct::with(['lineProducts' => function ($query) {
      $query->where('active', 1);
    }])->where('url_key', $slug)->firstOrFail();
    /*$products = Product::whereHas('lineProduct.sections',function($query) use (&$slugSection) {
      $query->where('url_key', $slugSection);
    })->with(['files', 'lineProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function($query) {
      $query->doesntHave('figure');
    }])->where('type_product_id', $model->id)->get();*/
    $products = Product::whereHas('lineProduct.sections', function ($query) use (&$slugSection) {
      $query->where('url_key', $slugSection);
    })->with(['files', 'lineProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function ($query) {
      $query->doesntHave('figure');
    }])->where('type_product_id', $model->id)->get();
    //return view('catalog', compact('model'));

    //$products = Product::with(['attributes','files'])->where('type_product_id', $model->id)->where('active',1)->get();
    $attributes = Attribute::with(['attributeListValue'])->where('attribute_type_id', 8)->where('filtered', 1)->where('active', 1)->get();
    return view('lineProduct', compact('model', 'products', 'attributes'));
  }

  public function lineProduct($slugProductCategory, $slugTypeProduct, $slug)
  {
    $model = LineProduct::where('url_key', $slug)->firstOrFail();
    $products = Product::with(['attributes', 'files', 'lineProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function ($query) {
      $query->doesntHave('figure');
    }])->where('line_product_id', $model->id)->where('active', 1)->get();
    $attributes = Attribute::with(['attributeListValue'])->where('attribute_type_id', 8)->where('filtered', 1)->where('active', 1)->get();
    return view('lineProduct', compact('model', 'products', 'attributes'));
  }

  public function sale()
  {
    $products = Product::with(['attributes', 'files', 'lineProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function ($query) {
      $query->doesntHave('figure');
    }])->where('onsale', 1)->get();
    $attributes = [];
    return view('sale', compact('products', 'attributes'));
  }

  public function menuLeft()
  {
    return ProductCategory::has('products')->with([
      'typeProducts' => function ($query) {
        $query->has('products')->orderBy('sort');
      },
      'typeProducts.lineProducts' => function ($query) {
        $query->has('products')->orderBy('sort');
      }
    ])->orderBy('sort')->get();
  }


  public function detail($slug)
  {
    $groups = AttributeGroup::orderBy('sort', 'asc')->get();
    $product = Product::with([
      'files',
      'attributes.attributeListValue',
      'attributes.attributeUnit',
      'lineProduct.attributes.attributeType' => function ($query) {
        $query->where('title', 'Списковый');
      }, 'lineProduct.attributes.attributeListValue',
      'typeProduct.attributes.attributeType' => function ($query) {
        $query->where('title', 'Списковый');
      }, 'typeProduct.attributes.attributeListValue',
      'productCategory.attributes.attributeType' => function ($query) {
        $query->where('title', 'Списковый');
      }, 'productCategory.attributes.attributeListValue'
    ])->where('url_key', $slug)->firstOrFail();
    return view('detail', compact('product', 'groups'));
  }


  public function filter(Request $request, $modelId, $modelColumnName)
  {
    $query = Product::query();
    $query = $query->where($modelColumnName,'=', $modelId);
    $query->with(
      [
        'files',
        'lineProduct.files' => function($query) {
          $query->doesntHave('figure');
        },
        'typeProduct.files' => function($query) {
          $query->doesntHave('figure');
        },
        'productCategory.files' => function($query) {
          $query->doesntHave('figure');
        },
        'attributes' => function($query) {
          $query->where('filtered',1);
        }
      ]
    );

    $ignoreId = null;
    if(count($request->except('sortBy'))==1) {
      foreach ($request->except('sortBy') as $key => $value) {
        $ignoreId = str_replace('param_id', '', $key);
        break;
      }
    }

    foreach($request->except('sortBy') as $attributeId => $optionsIds) {
      $query->whereHas('attributeValues', function($q) use ($attributeId, $optionsIds) {
        $q->where('attribute_id', str_replace('param_id','',$attributeId))->whereIn('list_value', $optionsIds);
      });
    }
    $sortyBy = explode("|",$request->sortBy);
    $products = $query->where('active',1)->orderBy($sortyBy[0],$sortyBy[1])->get();

    if($modelColumnName == 'line_producrt_id') {
      $model = LineProduct::find($modelId);
      $attributes = Attribute::with(['attributeUnit','attributeListValue' => function($query) {
        $query->orderBy('sort', 'asc');
      }])
        ->where('attribute_type_id',AttributeType::LIST)
        ->where(function($query) use ($model) {
          $query->whereHas('lineProducts', function($q1) use ($model) {
            $q1->where(['id' => $model->id]);
          })->orWhereHas('typeProducts', function($q2) use ($model) {
            $q2->where(['id' => $model->typeProduct->id]);
          })->orWhereHas('productCategories', function($q3) use ($model) {
            $q3->where(['id' => $model->typeProduct->productCategory->id]);
          });
        })->orderBy('sort','asc')
        ->get();
    } else
    {
      $model = TypeProduct::find($modelId);
      $attributes = Attribute::with(['attributeUnit','attributeListValue' => function($query) {
        $query->orderBy('sort', 'asc');
      }])
        ->where('attribute_type_id',AttributeType::LIST)
        ->where(function($query) use ($model) {
          $query->whereHas('typeProducts', function($q2) use ($model) {
            $q2->where(['id' => $model->id]);
          })->orWhereHas('productCategories', function($q3) use ($model) {
            $q3->where(['id' => $model->productCategory->id]);
          });
        })->orderBy('sort','asc')
        ->get();
    }


    $productIds = $products->pluck('id')->all();

    $attributes->each(function($attribute) use ($productIds, $ignoreId) {
      $attribute->attributeListValue->each(function($value) use ($attribute, $productIds, $ignoreId) {
        if($ignoreId && $attribute->id == $ignoreId) {
          $value->disabled = false;
        } else {
          $value->disabled = AttributeValue::where('attribute_id', $attribute->id)->whereIn('product_id', $productIds)->where('list_value', $value->id)->first()?false:true;
        }
      });
    });

    return [
      'attributes' => $attributes,
      'products' => $products
    ];
  }

  public function products()
  {
    $products = Product::with(['attributes' => function ($query) {
      $query->where('attribute_type_id', 8);
    }, 'files', 'lineProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'typeProduct.files' => function ($query) {
      $query->doesntHave('figure');
    }, 'productCategory.files' => function ($query) {
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
