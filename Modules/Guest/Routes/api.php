<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->prefix('guests')->group(function() {
  Route::get('/', 'GuestController@index');
  Route::post('/', 'GuestController@load');
  Route::post('/default', 'GuestController@create');
  Route::patch('/', 'GuestController@save');
});

Route::middleware('auth:api')->prefix('guest_pages')->group(function() {
  Route::get('/', 'GuestPageController@index');
  Route::post('/', 'GuestPageController@load');
  Route::post('/default', 'GuestPageController@create');
  Route::patch('/', 'GuestPageController@save');
});