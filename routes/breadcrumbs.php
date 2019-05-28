<?php
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\TypeProduct;
use Modules\Product\Entities\LineProduct;

Breadcrumbs::for('main', function ($trail) {
  $trail->add('Главная', route('main'));
});

Breadcrumbs::for('catalog.product-category', function($trail, $slug) {
  $productCategory = ProductCategory::where('url_key', $slug)->firstOrFail();
  $trail->parent('main');
  $trail->add($productCategory->title, route('catalog.product-category',[$productCategory->url_key]));
});

Breadcrumbs::for('catalog.type-product', function($trail, $slugProductCategory, $slugTypeProduct) {
  $typeProduct = TypeProduct::where('url_key', $slugTypeProduct)->firstOrFail();
  $trail->parent('catalog.product-category',$slugProductCategory);
  $trail->add($typeProduct->title, route('catalog.type-product',[$slugProductCategory, $typeProduct->url_key]));
});

Breadcrumbs::for('catalog.line-product', function($trail, $slugProductCategory, $slugTypeProduct, $slug) {
  $lineProduct = LineProduct::where('url_key', $slug)->firstOrFail();
  $trail->parent('catalog.type-product',$slugProductCategory, $slugTypeProduct);
  $trail->add($lineProduct->title, route('catalog.type-product',[$slugProductCategory, $slugTypeProduct, $slug]));
});

Breadcrumbs::for('catalog.detail', function($trail, $urlKeyProduct) {
  $product = Product::with('productCategory','typeProduct','lineProduct')->where('url_key',$urlKeyProduct)->firstOrFail();
  $trail->parent('main');
  if($product->productCategory) {
    $trail->add($product->productCategory->title, route('catalog.product-category',[$product->productCategory->url_key]));
  }
  if($product->typeProduct) {
    $trail->add($product->typeProduct->title, route('catalog.type-product',[$product->productCategory->url_key, $product->typeProduct->url_key]));
  }
  if($product->lineProduct) {
    $trail->add($product->lineProduct->title, route('catalog.line-product',[$product->productCategory->url_key, $product->typeProduct->url_key, $product->lineProduct->url_key]));
  }
  $trail->add($product->title, route('catalog.detail',[$product->url_key]));
});