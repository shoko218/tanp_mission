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

Route::get('/home', 'Main\HomeController@index')->name('home');
Route::get('/', 'Main\IndexController');
Route::get('/result', 'Main\ResultController');
Route::get('/product', 'Main\ProductController');
Route::get('/cart', 'Main\CartController');

Route::prefix('/mypage')->group(function () {
    Route::get('/order_history', 'MyPage\OrderHistoryController');
    Route::get('/favorite', 'MyPage\FavoriteController');
    Route::prefix('/reminder')->group(function () {
        Route::get('/top', 'MyPage\Reminder\TopController');
        Route::get('/register', 'MyPage\Reminder\RegisterController');
        Route::get('/detail', 'MyPage\Reminder\DetailController');
    });
    Route::prefix('/lovers')->group(function () {
        Route::get('/top', 'MyPage\Lovers\TopController');
        Route::get('/lover', 'MyPage\Lovers\LoverController');
        Route::get('/gift_history', 'MyPage\Lovers\GiftHistoryController');
        Route::get('/register', 'MyPage\Lovers\RegisterController');
    });
    Route::prefix('/register_info')->group(function () {
        Route::get('/top', 'MyPage\Register_info\TopController');
    });
});

