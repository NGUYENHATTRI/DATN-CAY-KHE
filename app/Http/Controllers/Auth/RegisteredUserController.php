<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image_url' => 'images/user/default-avatar.jpg',
        ]);

        event(new Registered($user));

        Auth::login($user);

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
}
