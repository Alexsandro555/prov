<?php
  Route::middleware('auth:api')->prefix('callbacks')->group(function() {
    Route::get('/', 'CallbackController@index');
    Route::post('/', 'CallbackController@load');
    Route::patch('/', 'CallbackController@save');
    Route::delete('/', 'CallbackController@delete');
  });