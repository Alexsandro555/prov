<?php
  Route::middleware('auth:api')->prefix('producers')->group(function () {
    Route::get('/', 'ProducerController@index');
    Route::post('/', 'ProducerController@load');
    Route::patch('/', 'ProducerController@save');
    Route::delete('/', 'ProducerController@delete');
  });
