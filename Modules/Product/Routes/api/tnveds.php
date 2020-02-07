<?php

  Route::middleware('auth:api')->prefix('tnveds')->group(function() {
    Route::get('/', 'TnvedController@index');
    Route::post('/', 'TnvedController@load');
    Route::patch('/', 'TnvedController@save');
    Route::delete('/', 'TnvedController@delete');
  });
