<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $current_user = User::where('google_token', $user->token)->first();
            if ($current_user) {
                Auth::login($current_user);
                return $this->redirectCustomer();
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'google_token' => $user->token,
                ]);
                Auth::login($newUser);
                return $this->redirectCustomer();
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
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
}
