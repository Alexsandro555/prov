<?php
  Route::middleware('auth:api')->prefix('attribute_groups')->group(function() {
    Route::get('/', 'AttributeGroupController@index');
    Route::post('/', 'AttributeGroupController@load');
    Route::patch('/', 'AttributeGroupController@save');
    Route::delete('/', 'AttributeGroupController@delete');
  });
