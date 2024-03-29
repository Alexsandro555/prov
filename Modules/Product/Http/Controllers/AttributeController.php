<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Attribute;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\AttributeValue;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\LineProduct;
use Spatie\PdfToText\Pdf;

class AttributeController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Attribute();
  }

  public function attributes($id) {
    $product = Product::findOrFail($id);
    $productCategoriesAttributeCollection = collect();
    $typeProductsAttributeCollection = collect();
    $lineProductsAttributeCollection = collect();
    $productAttributesCollection = collect();
    if ($product->product_category_id) {
      $productCategoriesAttributeCollection = Attribute::whereHas('productCategories', function($query) use (&$product) {
        $query->where('id', $product->product_category_id);
      })->with(['attribureUnit', 'attributeType', 'attributeGroup', 'attributeListValue'])->get();
    }
    if ($product->type_product_id) {
      $typeProductsAttributeCollection = Attribute::whereHas('typeProducts', function($query) use (&$product) {
        $query->where('id', $product->type_product_id);
      })->with(['attribureUnit', 'attributeType', 'attributeGroup', 'attributeListValue'])->get();
    }
    if ($product->line_product_id) {
      $lineProductsAttributeCollection = Attribute::whereHas('lineProducts', function($query) use (&$product) {
        $query->where('id', $product->line_product_id);
      })->with(['attribureUnit', 'attributeType', 'attributeGroup', 'attributeListValue'])->get();
    }
    $productAttributeCollection = $productCategoriesAttributeCollection->concat($typeProductsAttributeCollection)->concat($lineProductsAttributeCollection);
    $attributesValue = Product::find($id)->attributes()->with(['attribureUnit', 'attributeType', 'attributeGroup', 'attributeListValue'])->get();
    $diff = $productAttributeCollection->diff($attributesValue);
    $attributeNotValues = $diff->all();
    $resultCollection = $attributesValue->concat($attributeNotValues);
    return $resultCollection;
  }

  public function saveAttributes(Request $request) {
    $productId = $request->productId;
    $attributes = $request->attr;
    $product = Product::find($productId);
    foreach($attributes as $attribute) {
      $product->{'attribute_'.$attribute['type']['title']}()->detach($attribute['id']);
      $product->{'attribute_'.$attribute['type']['title']}()->attach($attribute['id'], ['value' => $attribute['state']['value']]);
    }
    return ['message' => 'Атрибуты сохранены!'];
  }

  public function binding() {
    return Attribute::with('productCategories', 'typeProducts', 'lineProducts')->get();
  }


  public function saveBindings(Request $request) {
    if($request->line_product_id) {
      foreach ($request->selectedRemainAttr as $attributeId) {
        DB::table('attributables')->insert([
          'attribute_id' => $attributeId,
          'attributable_id' => $request->line_product_id,
          'attributable_type' => 'Modules\Product\Entities\LineProduct'
        ]);
      }
      return Attribute::with('productCategories', 'typeProducts', 'lineProducts')->get();
    }

    if($request->type_product_id) {
      foreach ($request->selectedRemainAttr as $attributeId) {
        DB::table('attributables')->insert([
          'attribute_id' => $attributeId,
          'attributable_id' => $request->type_product_id,
          'attributable_type' => 'Modules\Product\Entities\TypeProduct'
        ]);
      }
      return Attribute::with('productCategories', 'typeProducts', 'lineProducts')->get();
    }

    if($request->product_category_id) {
      foreach ($request->selectedRemainAttr as $attributeId) {
        DB::table('attributables')->insert([
          'attribute_id' => $attributeId,
          'attributable_id' => $request->product_category_id,
          'attributable_type' => 'Modules\Product\Entities\ProductCategory'
        ]);
      }
      return Attribute::with('productCategories', 'typeProducts', 'lineProducts')->get();
    }
  }

  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    foreach($request->attr as $attribute) {
      $attributeValue = AttributeValue::firstOrNew(['product_id' =>  $request->id, 'attribute_id' => $attribute['attribute_id']]);
      $attributeValue->value = $attribute['value'];
      $attributeValue->save();
    }
    return AttributeValue::all();
  }

  public function removeBindAttributes(Request $request)
  {
    if($request->type_product_id) {
      foreach ($request->attr as $attribute_id) {
        DB::table('attributables')->where('attribute_id', $attribute_id)->where('attributable_type', 'Modules\Product\Entities\TypeProduct')->where('attributable_id',$request->type_product_id)->delete();
      }
    }
    if($request->product_category_id) {
      foreach ($request->attr as $attribute_id) {
        DB::table('attributables')->where('attribute_id', $attribute_id)->where('attributable_type', 'Modules\Product\Entities\ProductCategory')->where('attributable_id',$request->product_category_id)->delete();
      }
    }
    if($request->line_product_id) {
      foreach ($request->attr as $attribute_id) {
        DB::table('attributables')->where('attribute_id', $attribute_id)->where('attributable_type', LineProduct::class)->where('attributable_id',$request->line_product_id)->delete();
      }
    }
  }

  public function loadPdf(Request $request)
  {
    if($request->hasFile('file')) {
      if ($request->file('file')->isValid()) {
        try {
          return response((new Pdf('/usr/local/bin/pdftotext'))->setPdf($request->file('file'))->text())->withHeaders([
            'Content-Type' => 'text/plain'
          ]);
        } catch (FileNotFoundException $e) { }
      }
    }
  }
}
