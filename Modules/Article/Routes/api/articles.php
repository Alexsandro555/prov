<?php
  Route::middleware('auth:api')->prefix('articles')->group(function() {
    Route::get('/', 'ArticleController@index');
    Route::post('/', 'ArticleController@load');
    Route::patch('/', 'ArticleController@save');
    Route::delete('/', 'ArticleController@delete');
  });