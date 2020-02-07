<?php
  Route::middleware('auth:api')->prefix('attributes')->group(function() {
    Route::get('/', 'AttributeController@index');
    Route::post('/', 'AttributeController@load');
    Route::get('/bindings', 'AttributeController@binding');
    Route::patch('/bindings', 'AttributeController@saveBindings');
    Route::get('/{id}', 'AttributeController@attributes');
    Route::post('/save', 'AttributeController@store');
    Route::patch('/', 'AttributeController@save');
    Route::patch('/remove-bind-attributes', 'AttributeController@removeBindAttributes');
    Route::post('/load-pdf', 'AttributeController@loadPdf');
    Route::delete('/', 'AttributeController@delete');
  });