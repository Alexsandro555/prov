<?php
  Route::middleware('auth:api')->prefix('pages')->group(function() {
    Route::get('/', 'PageController@index');
    Route::post('/', 'PageController@load');
    Route::patch('/', 'PageController@save');
    Route::delete('/', 'PageController@delete');
  });