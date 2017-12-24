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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'ShopsController@nearby_index')->name('home');

Route::get('/nearby-shops', 'ShopsController@nearby_index')->name('nearby_shops');
Route::get('/api/v1/get_shops', 'ShopsController@getShops');

Route::get('/my-preferred-shops', 'ShopsController@preferred_index')->name('preferred_shop');
Route::get('/api/v1/preferred_shop', 'ShopsController@preferredShop');

Route::get('/api/v1/like_shop', 'ShopsController@LikeShop');
Route::get('/api/v1/dislike_shop', 'ShopsController@DislikeShop');
Route::get('/api/v1/remove_shop', 'ShopsController@remove_shop');



