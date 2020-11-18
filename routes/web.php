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

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => false]);
// Auth::routes(['verify' => true]);

Route::get('/', 'Main\IndexController');
Route::get('/rules',function(){
    return view('main.rules');
});
Route::get('/change', 'Main\ChangeController');
Route::get('/result', 'Main\ResultController');
Route::get('/product', 'Main\ProductController');
Route::get('/search', 'Main\SearchController');
Route::post('/product/favorite', 'Main\ProductFavoriteController');
Route::get('/product', 'Main\ProductController');
Route::get('/msg', 'Main\MsgController');
Route::get('/select_product/{catalog_param}', 'Main\SelectProductController');
Route::get('/select_product_detail/{url_str}', 'Main\SelectProductDetailController');
Route::post('/select_product_process/{url_str}', 'Main\SelectProductProcessController');
Route::get('/edit_email_process/{token}', 'MyPage\Register_info\EditEmailProcessController');
Route::prefix('/cart')->group(function () {
    Route::get('/', 'Main\Cart\CartController');
    Route::post('/in', 'Main\Cart\CartInController');
    Route::post('/complete_out', 'Main\Cart\CartCompleteOutController');
    Route::post('/minus', 'Main\Cart\CartMinusController');
    Route::post('/plus', 'Main\Cart\CartPlusController');
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

Route::middleware(['auth'])->group(function () {
    Route::prefix('/mypage')->group(function () {
        Route::get('/order_history', 'MyPage\OrderHistoryController');
        Route::get('/favorite', 'MyPage\FavoriteController');
        Route::prefix('/reminder')->group(function () {
            Route::get('/', 'MyPage\Reminder\TopController');
            Route::get('/register', 'MyPage\Reminder\RegisterController');
            Route::post('/register', 'MyPage\Reminder\PostRegisterController');
            Route::post('/register_process','MyPage\Reminder\RegisterProcessController');
            Route::post('/edit_process', 'MyPage\Reminder\EditProcessController');
            Route::post('/delete_process','MyPage\Reminder\DeleteProcessController');
            Route::group(['middleware' => ['event.check']], function () {
                Route::get('/{event_id}/edit', 'MyPage\Reminder\EditController');
                Route::get('/{event_id}', 'MyPage\Reminder\DetailController');
            });
        });
        Route::prefix('/lovers')->group(function () {
            Route::get('/', 'MyPage\Lovers\TopController');
            Route::post('/edit_process','MyPage\Lovers\EditProcessController');
            Route::get('/register', 'MyPage\Lovers\RegisterController');
            Route::post('/register_process','MyPage\Lovers\RegisterProcessController');
            Route::post('/delete_process','MyPage\Lovers\DeleteProcessController');
            Route::group(['middleware' => ['lover.check']], function () {
                Route::get('/{lover_id}/gift_history', 'MyPage\Lovers\GiftHistoryController');
                Route::get('/{lover_id}/edit', 'MyPage\Lovers\EditController');
                Route::get('/{lover_id}', 'MyPage\Lovers\DetailController');
            });
        });

        Route::prefix('/original_catalog')->group(function () {
            Route::get('/', 'MyPage\Original_catalog\TopController');
            Route::post('/result_get', 'MyPage\Original_catalog\ResultGetController');
            Route::get('/register', 'MyPage\Original_catalog\RegisterController');
            Route::post('/register_process', 'MyPage\Original_catalog\RegisterProcessController');
            Route::get('/select_which_catalog/{product_id}', 'MyPage\Original_catalog\SelectCatalogController');
            Route::group(['middleware' => ['catalog.check']], function () {
                Route::get('/{catalog_id}', 'MyPage\Original_catalog\DetailController');
                Route::get('/{catalog_id}/edit', 'MyPage\Original_catalog\EditController');
                Route::post('/add_process', 'MyPage\Original_catalog\AddProcessController');
                Route::post('/edit_process', 'MyPage\Original_catalog\EditProcessController');
                Route::post('/send_process', 'MyPage\Original_catalog\SendProcessController');
                Route::post('/remove_process', 'MyPage\Original_catalog\RemoveProcessController');
                Route::post('/delete_process','MyPage\Original_catalog\DeleteProcessController');
            });
        });


        Route::middleware('password.confirm')->group(function(){
            Route::prefix('/register_info')->group(function () {
                Route::get('/', 'MyPage\Register_info\TopController');
                Route::get('/edit', 'MyPage\Register_info\EditController');
                Route::post('/edit_process', 'MyPage\Register_info\EditProcessController');
                Route::get('/edit_email', 'MyPage\Register_info\EditEmailController');
                Route::post('/send_mail_to_edit_email_process', 'MyPage\Register_info\SendMailToEditEmailProcessController');
                Route::get('/edit_pass', 'MyPage\Register_info\EditPassController');
                Route::post('/edit_pass_process', 'MyPage\Register_info\EditPassProcessController');
                Route::post('/delete', 'MyPage\Register_info\DeleteProcessController');
            });
        });
    });

});

