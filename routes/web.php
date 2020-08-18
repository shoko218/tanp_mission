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

Auth::routes(['verify' => true]);

Route::get('/', 'Main\IndexController');
Route::get('/result', 'Main\ResultController');
Route::get('/product', 'Main\ProductController');
Route::get('/search', 'Main\SearchController');
Route::post('/product/favorite', 'Main\ProductFavoriteController');
Route::post('/product/unfavorite', 'Main\ProductUnfavoriteController');
Route::get('/product', 'Main\ProductController');
Route::get('/msg', 'Main\MsgController');
Route::get('/select_product/{catalog_param}', 'Main\SelectProductController');
Route::get('/select_product_detail', 'Main\SelectProductDetailController');
Route::post('/select_product_process', 'Main\SelectProductProcessController');
Route::prefix('/cart')->group(function () {
    Route::get('/', 'Main\Cart\CartController');
    Route::post('/in', 'Main\Cart\CartInController');
    Route::post('/out', 'Main\Cart\CartOutController');
    Route::post('/minus_count', 'Main\Cart\CartMinusController');
    Route::post('/plus_count', 'Main\Cart\CartPlusController');
});
Route::prefix('/purchase')->group(function () {
    Route::get('/fillin_info', 'Main\Purchase\FillinInfoController');
    Route::post('/fillin_lover_info', 'Main\Purchase\FillinLoverInfoController');
    Route::post('/register_to_session', 'Main\Purchase\RegisterInfoToSessionController');
    Route::get('/payment','Main\Purchase\PaymentController');
    Route::post('/payment_process','Main\Purchase\PaymentProcessController');
});

Route::get('/logout',function(){
    Auth::logout();
    return redirect('/');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::prefix('/mypage')->group(function () {
        Route::get('/order_history', 'MyPage\OrderHistoryController');
        Route::get('/favorite', 'MyPage\FavoriteController');
        Route::prefix('/reminder')->group(function () {
            Route::get('/top', 'MyPage\Reminder\TopController');
            Route::get('/register', 'MyPage\Reminder\RegisterController');
            Route::post('/register', 'MyPage\Reminder\PostRegisterController');
            Route::post('/register_process','MyPage\Reminder\RegisterProcessController');
            Route::post('/detail', 'MyPage\Reminder\DetailController');
            Route::get('/detail', 'MyPage\Reminder\GetDetailController');
            Route::post('/delete_process','MyPage\Reminder\EventDeleteProcessController');
            Route::get('/edit', 'MyPage\Reminder\EditController');
            Route::post('/edit', 'MyPage\Reminder\EditController');
            Route::post('/edit_process', 'MyPage\Reminder\EditProcessController');
        });
        Route::prefix('/lovers')->group(function () {
            Route::get('/top', 'MyPage\Lovers\TopController');
            Route::post('/lover', 'MyPage\Lovers\LoverController');
            Route::get('/lover', 'MyPage\Lovers\GetLoverController');
            Route::post('/gift_history', 'MyPage\Lovers\GiftHistoryController');
            Route::get('/register', 'MyPage\Lovers\RegisterController');
            Route::post('/register_process','MyPage\Lovers\RegisterProcessController');
            Route::get('/edit', 'MyPage\Lovers\EditController');
            Route::post('/edit', 'MyPage\Lovers\EditController');
            Route::post('/edit_process','MyPage\Lovers\EditProcessController');
            Route::post('/delete_process','MyPage\Lovers\LoverDeleteProcessController');
        });

        Route::prefix('/original_catalog')->group(function () {
            Route::get('/top', 'MyPage\Original_catalog\TopController');
            Route::post('/detail', 'MyPage\Original_catalog\DetailController');
            Route::get('/detail', 'MyPage\Original_catalog\GetDetailController');
            Route::get('/register', 'MyPage\Original_catalog\RegisterController');
            Route::post('/register_process', 'MyPage\Original_catalog\RegisterProcessController');
            Route::get('/select_which_catalog', 'MyPage\Original_catalog\SelectCatalogController');
            Route::post('/select_which_catalog', 'MyPage\Original_catalog\SelectCatalogController');
            Route::post('/add_process', 'MyPage\Original_catalog\AddProcessController');
            Route::post('/remove_process', 'MyPage\Original_catalog\RemoveProcessController');
            Route::post('/send_process', 'MyPage\Original_catalog\SendProcessController');
            Route::get('/edit', 'MyPage\Original_catalog\EditController');
            Route::post('/edit', 'MyPage\Original_catalog\EditController');
            Route::post('/edit_process', 'MyPage\Original_catalog\EditProcessController');
            Route::post('/delete_process','MyPage\Original_catalog\DeleteProcessController');
        });


        Route::middleware('password.confirm')->group(function(){
            Route::prefix('/register_info')->group(function () {
                Route::get('/top', 'MyPage\Register_info\TopController');
                Route::get('/edit', 'MyPage\Register_info\EditController');
                Route::post('/edit_process', 'MyPage\Register_info\EditProcessController');
                Route::get('/edit_email', 'MyPage\Register_info\EditEmailController');
                Route::post('/send_mail_to_edit_email_process', 'MyPage\Register_info\SendMailToEditEmailProcessController');
                Route::get('/edit_email_process/{token}', 'MyPage\Register_info\EditEmailProcessController');
                Route::get('/edit_pass', 'MyPage\Register_info\EditPassController');
                Route::post('/edit_pass_process', 'MyPage\Register_info\EditPassProcessController');
                Route::post('/delete', 'MyPage\Register_info\DeleteProcessController');
            });
        });
    });

});

