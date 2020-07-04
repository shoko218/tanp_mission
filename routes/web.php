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

Route::get('/', 'Main\IndexController');
Route::get('/result', 'Main\ResultController');
Route::get('/product', 'Main\ProductController');
Route::post('/product/favorite', 'Main\ProductFavoriteController');
Route::post('/product/unfavorite', 'Main\ProductUnfavoriteController');
Route::get('/product', 'Main\ProductController');
Route::get('/cart', 'Main\CartController');
Route::post('/cart/in', 'Main\CartInController');
Route::post('/cart/out', 'Main\CartOutController');
Route::post('/cart/minus_count', 'Main\CartMinusController');
Route::post('/cart/plus_count', 'Main\CartPlusController');
Route::get('/logout',function(){
    Auth::logout();
    return redirect('/');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('/mypage')->group(function () {
        Route::get('/order_history', 'MyPage\OrderHistoryController');
        Route::get('/favorite', 'MyPage\FavoriteController');
        Route::prefix('/reminder')->group(function () {
            Route::get('/top', 'MyPage\Reminder\TopController');
            Route::get('/register', 'MyPage\Reminder\RegisterController');
            Route::post('/register_process','MyPage\Reminder\RegisterProcessController');
            Route::post('/detail', 'MyPage\Reminder\DetailController');
            Route::get('/detail', function(){return redirect('/mypage/reminder/top');});
        });
        Route::prefix('/lovers')->group(function () {
            Route::get('/top', 'MyPage\Lovers\TopController');
            Route::post('/lover', 'MyPage\Lovers\LoverController');
            Route::get('/lover', function(){return redirect('/mypage/lovers/top');});
            Route::get('/gift_history', 'MyPage\Lovers\GiftHistoryController');
            Route::get('/register', 'MyPage\Lovers\RegisterController');
            Route::post('/register_process','MyPage\Lovers\RegisterProcessController');
        });
        Route::prefix('/register_info')->group(function () {
            Route::get('/top', 'MyPage\Register_info\TopController');
        });
    });
});

