<?php
  Route::middleware('auth:api')->prefix('type_products')->group(function() {
    Route::get('/', 'TypeProductController@index');
    Route::post('/', 'TypeProductController@load');
    Route::patch('/', 'TypeProductController@save');
    Route::patch('/toggle', 'TypeProductController@toggle');
    Route::delete('/', 'TypeProductController@delete');
  });