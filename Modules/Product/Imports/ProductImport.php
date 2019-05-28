<?php

namespace Modules\Product\Imports;

use Modules\Product\Entities\LineProduct;
use Modules\Product\Entities\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Alexusmai\Ruslug\Slug;

class ProductImport implements ToModel
{
  public function model(array $row)
  {
    list($name, $size) = explode("-", $row[0]);
    $lineProduct = LineProduct::where('title', $name.' '.$size)->first();
    if(!$lineProduct)  throw new \Exception('Линейка не была найдена!');
    $product = new Product([
      'title' => str_replace("-"," ", $row[0]),
      'price' => $row[1],
      'url_key' => \Slug::make(str_replace("/"," ",$row[0])),
      'product_category_id' => 2,
      'type_product_id' => 1,
      'line_product_id' => $lineProduct->id
    ]);
    return $product;
  }
}