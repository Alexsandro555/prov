<?php
  Route::middleware('auth:api')->prefix('attribute_list_values')->group(function() {
  Route::get('/', 'AttributeListValueController@index');
  Route::post('/', 'AttributeListValueController@load');
  Route::patch('/', 'AttributeListValueController@save');
  Route::delete('/', 'AttributeListValueController@delete');
});