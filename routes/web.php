<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/menu-left', 'SiteController@menuLeft');
Route::get('/left-menu', 'SiteController@menuLeft');
Route::get('/admin', ['uses' => '\Modules\Auth\Http\Controllers\AdminController@index', 'as' => 'master']);

//Route::middleware(['visitor'])->group(function() {
  Route::get('/', 'SiteController@index')->name('main');
  Route::get('/catalog/{slug}', ['uses'=>'SiteController@catalog', 'as'=>'catalog.product-category']);
  Route::get('/catalog/detail/{slug}',['uses' => 'SiteController@detail', 'as' => 'catalog.detail']);
  Route::get('/catalog/{slugProductCategory}/{slug}', ['uses' => 'SiteController@typeProduct', 'as'=>'catalog.type-product']);
  Route::get('/catalog/section-{slugSection}/{slugProductCategory}/{slug}', ['uses' => 'SiteController@section', 'as'=>'catalog.section']);
  Route::get('/catalog/{slugProductCategory}/{slugTypeProduct}/{slug}', ['uses' => 'SiteController@lineProduct', 'as'=>'catalog.line-product']);
  Route::get('/find/{text?}', ['uses' => 'FindController@index', 'as' => 'find']);
  Route::get('/sale', ['uses' => 'SiteController@sale', 'as' => 'sale']);
  Route::get('/{slug}', '\Modules\Page\Http\Controllers\PagesController@show');
//});



