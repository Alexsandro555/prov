<?php
Route::middleware('auth:api')->prefix('line_products')->group(function () {
  Route::get('/', 'LineProductController@index');
  Route::post('/', 'LineProductController@load');
  Route::patch('/', 'LineProductController@save');
  Route::patch('/toggle', 'ProductCategoryController@toggle');
  Route::delete('/', 'LineProductController@delete');
});