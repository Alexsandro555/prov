<?php
Route::middleware('auth:api')->prefix('sections')->group(function() {
  Route::get('/', 'SectionController@index');
  Route::patch('/', 'SectionController@save');
  Route::post('/', 'SectionController@load');
  Route::delete('/', 'SectionController@delete');
});