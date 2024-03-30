<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VoucherModel;
use App\Models\VoucherTypeModel;
use App\Models\VoucherUsage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $carts = null;
        if (Auth::check()) {
            $carts          = Cart::where('user_id', Auth::user()->userID)
                ->get();
        } else {
            $carts          = Cart::where('guest_user_id', request()->cookie('guest_user_id'))
                ->get();
        }
        // dd(request()->cookie('coupon_code'));
        return view('client.checkout.cart', ['carts' => $carts]);
    }

    # add to cart
    public function store(Request $request)
    {

        $productVariation = Variant::where('variantID', $request->product_variation_id)->first();

        if (!is_null($productVariation)) {

            $cart = null;
            $message = '';

            if (Auth::check()) {
                $cart  = Cart::where('user_id', Auth::user()->userID)
                    ->where('product_variation_id', $productVariation->variantID)->first();
            } else {
                $cart  = Cart::where('guest_user_id', request()->cookie('guest_user_id'))
                    ->where('product_variation_id', $productVariation->variantID)->first();
            }

            if (is_null($cart)) {
                $cart = new Cart;
                $cart->product_variation_id = $productVariation->variantID;
                if ($request->quantity > $productVariation->stock_quantity) {
                    $cart->qty                  = (int) $productVariation->stock_quantity;
                } else {
                    $cart->qty                  = (int) $request->quantity;
                }
                $cart->location_id          = NULL;
                $cart->product_id          = $productVariation->product_id;

                if (Auth::check()) {
                    $cart->user_id          = Auth::user()->userID;
                } else {
                    $cart->guest_user_id    = request()->cookie('guest_user_id');
                }
                $message =  'Sản phẩm đã thêm vào giỏ hàng';
            } else {
                if ($productVariation->stock_quantity > $cart->qty) {
                    $cart->qty                  += (int) $request->quantity;
                    $message =  'Số lượng sản phẩm đã tăng';
                } else {
                    $message = 'Vượt quá số lượng kho';
                    return $this->getCartsInfo($message, true, '', 'warning');
                }
            }

            $cart->save();
            // remove coupon
            // removeCoupon();
            return $this->getCartsInfo($message, false);
        }
    }

    # update cart
    public function update(Request $request)
    {
        try {
            if (Auth::check()) {
                $cart  = Cart::where('user_id', Auth::user()->userID)->where('id', $request->id)->first();
            } else {
                $cart  = Cart::where('guest_user_id', request()->cookie('guest_user_id'))->where('id', $request->id)->first();
            }
            if ($request->action == "increase") {
                $productVariation = Variant::where('variantID', $cart->product_variation_id)->first();

                if ($productVariation->stock_quantity > $cart->qty) {
                    $productVariationStock = $productVariation->stock_quantity;
                    if ($productVariationStock > $cart->qty) {
                        $cart->qty += 1;
                        $cart->save();
                        $message =  'Số lượng sản phẩm đã tăng';
                    }
                } else {
                    $message = 'Vượt quá số lượng kho';
                    return $this->getCartsInfo($message, true, '', 'warning');
                }
            } elseif ($request->action == "decrease") {
                if ($cart->qty > 1) {
                    $cart->qty -= 1;
                    $cart->save();
                    $message =  'Số lượng sản phẩm đã giảm';
                }
            } else {
                $cart->delete();
                $message =  'Xoá sản phẩm thành công';
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        removeCoupon();
        return $this->getCartsInfo($message, false);
    }

    # apply coupon
    public function applyCoupon(Request $request)
    {
        $voucherType = VoucherTypeModel::where('name', $request->code)->first();
        if ($voucherType) {
            $voucher = VoucherModel::where('voucher_typeID', $voucherType->voucher_typeID)->first();
            $currentDate = Carbon::now()->toDateString();

            # Kiểm tra xem phiếu giảm giá có hết hạn chưa
            if ($voucher->start_date <= $currentDate && $voucher->expired_date >= $currentDate) {
                $carts = null;
                if (Auth::check()) {
                    $carts  = Cart::where('user_id', Auth::user()->userID)->get();
                    if($voucher->voucher_quantity <=0){
                        removeCoupon();
                        return [
                            'status'    => false,
                            'message'   => 'Mã giảm giá đã hết lượt'
                        ];
                    }
                    # total coupon usage

                    $totalCouponUsage = VoucherUsage::where('name', $voucherType->name)->sum('usage_count');
                    if ($totalCouponUsage >= $voucherType->customer_usage_limit) {
                        removeCoupon();
                        return [
                            'status'    => false,
                            'message'   => 'Mã giảm giá đã sử dụng'
                        ];
                    }
                } else {
                    $carts  = Cart::where('guest_user_id', request()->cookie('guest_user_id'))->get();
                }


                # check min spend
                $subTotal = (float) getSubTotal($carts, false);
                if ($subTotal >= (float) $voucherType->min_spend) {
                    Log::info('Coupon applied successfully');
                    # SUCCESS::can apply coupon
                    setCoupon($voucherType);
                    setCouponTypeDiscount($voucherType->discount, $voucherType->discount_type);
                    return $this->getCartsInfo('Áp dụng mã giảm giá thành công', true, $voucherType->name);
                }



                # min spend
                removeCoupon();
                return $this->couponApplyFailed('Hãy mua sắm ít nhất ' . $voucherType->min_spend);
            }

            # expired
            removeCoupon();
            return $this->couponApplyFailed('Mã giảm giá đã hết hạn');
        }

        // coupon not found
        removeCoupon();
        return $this->couponApplyFailed('Mã giảm giá không tồn tại');
    }

    # coupon apply failed
    private function couponApplyFailed($message = '', $success = false)
    {
        $response = $this->getCartsInfo($message, false);
        $response['success'] = $success;
        return $response;
    }

    # clear coupon
    public function clearCoupon()
    {
        removeCoupon();
        return $this->couponApplyFailed('Mã giảm giá đã xoá', true);
    }

    # get cart information
    private function getCartsInfo($message = '', $couponDiscount = true, $couponCode = '', $alert = 'success')
    {
        $carts = null;
        if (Auth::check()) {
            $carts          = Cart::where('user_id', Auth::user()->userID)->get();
        } else {
            $carts          = Cart::where('guest_user_id', request()->cookie('guest_user_id'))->get();
        }
        $formattedAmount = NULL;
        if ($couponCode) {
            $voucherType = VoucherTypeModel::where('name',$couponCode)->first();
            $formattedAmount = '';
            if ($voucherType->discount_type === 'flat') {
                $formattedAmount = formatPrice($voucherType->discount);
            } else {
                $formattedAmount = $voucherType->discount . '%';
            }
        }

        return [
            'success'           => true,
            'message'           => $message,
            'alert'             => $alert,
            'carts'             => getRender('client.partials.carts.cart-listing', ['carts' => $carts]),
            'navCarts'          => getRender('client.partials.carts.cart-navbar', ['carts' => $carts]),
            'cartCount'         => count($carts),
            'subTotal'          => getSubTotal($carts, $couponDiscount, $couponCode),
            'couponDiscount'    => getCouponDiscount(getSubTotal($carts, false), $couponCode),
            'couponData'        => $formattedAmount,
        ];
    }
}
