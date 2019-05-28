<?php

namespace Modules\Product\Services;

use Modules\Product\Entities\Product;

class ProductService
{
  /**
   * Get product by $search word
   *
   * @param string $search
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Product[]
   */
  public function find($search = '')
  {
    $search = str_replace("_", "/", $search);
    return Product::with('files', 'productCategory', 'attributes')
      ->where('active', 1)
      ->whereRaw("MATCH (title,description) AGAINST ('\"".$search."\"' IN BOOLEAN MODE) OR title LIKE '%".$search."%'")
      ->get();
  }

  // TODO: возможно в будущем стоит убрать
  public function getImages($product)
  {
    return $images =$product->productCategory()->files()->with('typeFile')->get()
      .concat($product->typeProduct()->files()->with('typeFile')->get())
      .concat($product->lineProduct()->files()->with('typeFile')->get())
      .concat($product->files()->with('typeFile')->get());
  }
}