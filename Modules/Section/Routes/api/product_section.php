<?php
Route::middleware('auth:api')->prefix('product_section')->group(function() {
  Route::get('/', 'ProductSectionController@index');
  Route::patch('/', 'ProductSectionController@save');
  Route::post('/', 'ProductSectionController@load');
  Route::delete('/', 'ProductSectionController@delete');
});