<?php
  Route::middleware('auth:api')->prefix('attributables')->group(function() {
    Route::get('/', 'AttributablesController@index');
    Route::patch('/', 'AttributablesController@save');
    Route::delete('/', 'AttributablesController@delete');
  });