<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\AttributeType;
use Modules\Product\Entities\AttributeListValues;

class AttributeValueController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new AttributeValue();
  }

  private function checkValue($id, $value)
  {
    switch ($id) {
      case AttributeType::BOOLEAN:
        return (boolean)$value;
      case AttributeType::STRING:
        return (string)$value;
      case AttributeType::INTEGER:
        return (integer)$value;
      case AttributeType::DOUBLE:
        return doubleval(str_replace(',','.', $value));
      case AttributeType::TEXT:
        return (string)$value;
      case AttributeType::DECIMAL:
        return floatval($value);
      case AttributeType::LIST:
        return AttributeListValues::where('title', $value)->firstOrFail()->id;
    }
    return null;
  }

  public function saveMultiple(Request $request)
  {
    // Получаем значения
    $values = json_decode($request->values);
    // Убеждаемся что массив не пустой
    if(!$values) return abort(404);

    // атрибуты по-горизонтали
    if ($request->direction) {
      $row = [];
      $products = Product::find($request->productIds);
      foreach($products as $product) {
        $row = array_pop($values)?:$row;
        $reversRow = array_reverse($row);
        $cell = '';
        $attributes = Attribute::find($request->attributeIds);
        foreach($attributes as $attribute) {
          $cell = array_pop($reversRow)?:$cell;
          $value = $this->checkValue($attribute->attribute_type_id,trim($cell));
          if($value) {
            $attribute->prod()->attach($product->id, ['value' => $value]);
          } else {
            return abort(404);
          }
        }
      }
    }
    else
    {
      $attributes = Attribute::find($request->attributeIds);
      $row = current($values);
      $cell = current($row);
      foreach ($attributes as $attribute) {
        foreach($request->productIds as $productId) {
            $value = $this->checkValue($attribute->attribute_type_id,trim($cell));
            if($value) {
              $attribute->prod()->attach($productId, ['value' => $value]);
            } else {
              return abort(404);
            }
            $temp = next($row);
            $cell = ($temp)?$temp:$cell;
        }
        $temp = next($values);
        $row = ($temp)?$temp:reset($values);
      }
    }
    return AttributeValue::all();
  }
}
