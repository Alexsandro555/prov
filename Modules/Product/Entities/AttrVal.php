<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;


class AttrVal extends Pivot
{
  public function getValueAttribute() {
    $attributeTypeId = $this->pivotParent->attributes['attribute_type_id'];
    //$attributeTypeId = Attribute::find($this->attributes['attribute_id'])->attribute_type_id;
    switch ($attributeTypeId) {
      case 1:
        return $this->attributes['boolean_value'];
      case 2:
        return $this->attributes['string_value'];
      case 3:
        return $this->attributes['integer_value'];
      case 4:
        return $this->attributes['double_value'];
      case 5:
        return $this->attributes['date_value'];
      case 6:
        return $this->attributes['text_value'];
      case 7:
        return $this->attributes['decimal_value'];
      case 8:
        return $this->attributes['list_value'];
    }
  }

  public function setValueAttribute($value) {
    //$attributeTypeId = Attribute::find($this->attributes['attribute_id'])->attribute_type_id;
    $attributeTypeId = $this->pivotParent->attributes['attribute_type_id'];
    $this->attributes['boolean_value'] = null;
    $this->attributes['string_value'] = null;
    $this->attributes['integer_value'] = null;
    $this->attributes['double_value'] = null;
    $this->attributes['date_value'] = null;
    $this->attributes['text_value'] = null;
    $this->attributes['decimal_value'] = null;
    $this->attributes['list_value'] = null;
    switch ($attributeTypeId) {
      case 1:
        $this->attributes['boolean_value'] = $value;
        break;
      case 2:
        $this->attributes['string_value'] = $value;
        break;
      case 3:
        $this->attributes['integer_value'] = $value;
        break;
      case 4:
        $this->attributes['double_value'] = $value;
        break;
      case 5:
        $this->attributes['date_value'] = $value;
        break;
      case 6:
        $this->attributes['text_value'] = $value;
        break;
      case 7:
        $this->attributes['decimal_value'] = $value;
        break;
      case 8:
        $this->attributes['list_value'] = $value;
        break;
    }
  }
  protected $appends = ['value'];
}