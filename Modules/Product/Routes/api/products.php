<?php
  Route::middleware('auth:api')->prefix('products')->group(function() {
    Route::get('/', 'ProductController@index');
    Route::post('/', 'ProductController@load');
    Route::post('/import', 'ProductController@import');
    Route::patch('/', 'ProductController@save');
    Route::delete('/', 'ProductController@delete');
  });
