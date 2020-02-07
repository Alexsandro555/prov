<?php
  Route::middleware('auth:api')->prefix('news')->group(function() {
    Route::get('/', 'NewsController@index');
    Route::post('/', 'NewsController@load');
    Route::patch('/', 'NewsController@save');
    Route::delete('/', 'NewsController@delete');
  });
