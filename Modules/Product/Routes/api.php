<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->prefix('attribute_types')->group(function() {
  Route::get('/', 'AttributeTypeController@index');
  Route::post('/', 'AttributeTypeController@load');
});

Route::middleware('auth:api')->prefix('category')->group(function() {
  Route::get('/{parentId?}', 'CategoryController@index');
  Route::post('/', 'CategoryController@create');
  Route::patch('/', 'CategoryController@store');
});

Route::middleware('auth:api')->prefix('skus')->group(function() {
  Route::get('/', 'SkuController@index');
  Route::post('/default', 'SkuController@save');
  Route::patch('/', 'SkuController@update');
  Route::delete('/', 'SkuController@delete');
});

Route::middleware('auth:api')->prefix('attribute_sku_options')->group(function() {
  Route::get('/', 'SkuOptionsController@index');
});



