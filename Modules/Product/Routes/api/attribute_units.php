<?php
  Route::middleware('auth:api')->prefix('attribute_units')->group(function() {
    Route::get('/', 'AttributeUnitController@index');
    Route::post('/', 'AttributeUnitController@load');
    Route::patch('/', 'AttributeUnitController@save');
    Route::delete('/', 'AttributeUnitController@delete');
  });