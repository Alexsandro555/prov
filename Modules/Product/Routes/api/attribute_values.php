<?php
  Route::middleware('auth:api')->prefix('attribute_values')->group(function() {
    Route::get('/', 'AttributeValueController@index');
    Route::post('/', 'AttributeValueController@load');
    Route::patch('/', 'AttributeValueController@save');
    Route::patch('/multiple', 'AttributeValueController@saveMultiple');
    Route::delete('/', 'AttributeValueController@delete');
  });