<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\Attributable;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\LineProduct;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\TypeProduct;
use MongoDB\BSON\Type;

class AttributablesController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct() {
    $this->model = new Attributable;
  }

  public function save(Request $request) {
    // todo: Данный код желательно перенести в модель - и вообще данный код лучше переделать
    if($request->line_product_id) {
      $lineProduct = LineProduct::findOrFail($request->line_product_id);
      $lineProduct->attributes()->attach($request->selectedRemainAttr);
      return Attributable::where('attributable_id', $lineProduct->id)->where('attributable_type', LineProduct::class)->get();
    }
    if($request->type_product_id) {
      $typeProduct = TypeProduct::findOrFail($request->type_product_id);
      $typeProduct->attributes()->attach($request->selectedRemainAttr);
      return Attributable::where('attributable_id', $typeProduct->id)->where('attributable_type', TypeProduct::class)->get();
    }
    if($request->product_category_id) {
      $productCategory = ProductCategory::findOrFail($request->product_category_id);
      $productCategory->attributes()->attach($request->selectedRemainAttr);
      return Attributable::where('attributable_id', $productCategory->id)->where('attributable_type', ProductCategory::class)->get();
    }
  }

  public function delete(Request $request) {
    // todo: Данный код желательно перенести в модель - и вообще данный код лучше переделать
    if($request->line_product_id) {
      $lineProduct = LineProduct::findOrFail($request->line_product_id);
      $lineProduct->attributes()->detach($request->attr);
    }
    if($request->type_product_id) {
      $typeProduct = TypeProduct::findOrFail($request->type_product_id);
      $typeProduct->attributes()->detach($request->attr);
    }
    if($request->product_category_id) {
      $productCategory = ProductCategory::findOrFail($request->product_category_id);
      $productCategory->attributes()->detach($request->attr);
    }
    return ['attributable' => Attributable::all(), 'attribute_values' => AttributeValue::all()];
  }
}
