<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use App\Library\BaseClass;
use App\Model\Cart;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if(Cookie::get('cart_product_ids')!=null){
            list($products,$product_count)=BaseClass::getProductsFromCookie();
            $user_id=Auth::user()->id;
            for ($i=0; $i < count($products); $i++) {
                Cart::create(['user_id'=>$user_id,'product_id'=>$products[$i]->id,'count'=>$product_count[$i]]);
            }
            $product_ids='';
            Cookie::queue('cart_product_ids', $product_ids,0);
        }
        return redirect()->intended($this->redirectPath());
    }
}
