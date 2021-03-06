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

Route::get('/', 'Shop\HomePageController@index')->name('homepage');


Route::group(['namespace' => 'Shop', 'prefix' => 'shop'], function () {
    Route::get('show-urgents-tabs', 'OrderController@showUrgentsTabs')->name('show-urgents-tabs');
    Route::resource('orders', 'OrderController')->names('orders')->only(['index', 'edit', 'update']);
    Route::get('products', 'ProductController@index')->name('products');
    Route::post('products/updateprice', 'ProductController@updateprice')->name('updateprice');
});