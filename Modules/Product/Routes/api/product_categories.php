<?php
  Route::middleware('auth:api')->prefix('product_categories')->group(function() {
    Route::get('/', 'ProductCategoryController@index');
    Route::post('/', 'ProductCategoryController@load');
    Route::patch('/', 'ProductCategoryController@save');
    Route::patch('/toggle', 'ProductCategoryController@toggle');
    Route::delete('/', 'ProductCategoryController@delete');
  });