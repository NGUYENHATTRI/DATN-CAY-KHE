<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->intended(RouteServiceProvider::HOME);
        return $this->redirectCustomer();
    }
    protected function redirectCustomer()
    {
        if (isset($_COOKIE['guest_user_id'])) {
            $carts  = Cart::where('guest_user_id', request()->cookie('guest_user_id'))->get();
            $userId = auth()->user()->userID;
            if ($carts) {
                foreach ($carts as $cart) {
                    $existInUserCart = Cart::where('user_id', $userId)->where('product_variation_id', $cart->product_variation_id)->first();
                    if (!is_null($existInUserCart)) {
                        $existInUserCart->qty += $cart->qty;
                        $existInUserCart->save();
                        $cart->delete();
                    } else {
                        $cart->user_id = $userId;
                        $cart->guest_user_id = null;
                        $cart->save();
                    }
                }
            }
        }
        $noti = ['message' => 'Đăng nhập thành công', 'alert-type' => 'success'];
        return redirect()->route('home')->with($noti);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
