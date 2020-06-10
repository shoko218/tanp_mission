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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'IndexController');
Route::get('/result', 'ResultController');
Route::get('/product', 'ProductController');
Route::get('/cart', 'CartController');

Route::prefix('/mypage')->group(function () {
    Route::get('/order_history', 'OrderHistoryController');
    Route::get('/favorite', 'FavoriteController');
    Route::prefix('/reminder')->group(function () {
        Route::get('/top', 'Reminder\TopController');
        Route::get('/register', 'Reminder\RegisterController');
        Route::get('/detail', 'Reminder\DetailController');
    });
    Route::prefix('/lovers')->group(function () {
        Route::get('/top', 'Lovers\TopController');
        Route::get('/lover', 'Lovers\LoverController');
        Route::get('/gift_history', 'Lovers\GiftHistoryController');
        Route::get('/register', 'Lovers\RegisterController');
    });
    Route::prefix('/register_info')->group(function () {
        Route::get('/top', 'Register_info\TopController');
    });
});

