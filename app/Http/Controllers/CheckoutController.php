<?php

namespace App\Http\Controllers;

use App\Mail\SuccessInvoiceMail;
use App\Models\Cart;
use App\Models\Districts;
use App\Models\OrderDetailModel;
use App\Models\OrderModel;
use App\Models\Product;
use App\Models\Provinces;
use App\Models\Variant;
use App\Models\VoucherModel;
use App\Models\VoucherTypeModel;
use App\Models\VoucherUsage;
use App\Models\Wards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;
use Illuminate\Support\Facades\Mail;
class CheckoutController extends Controller
{
    public $hash_secret;
    public $tmncode;
    public function __construct()
    {
        // có thể lên https://sandbox.vnpayment.vn/devreg/ để đăng ký sanbox
        $this->hash_secret = 'TSUHRVGRSQRFWCCTVNUUJBENWNHVTRBB';
        $this->tmncode = '1J7H9XAA';
    }
    # checkout
    public function index()
    {
        $rules = [
            'name'       => 'required|max:100',
            'phone'      => 'required|numeric|digits_between:9,20',
            'address'    => 'required|max:255',
            'country_id' => 'required_with:state_id,city_id|numeric',
            'state_id' => 'required_with:country_id,city_id|numeric',
            'city_id'    => 'required_with:country_id,state_id|numeric',
        ];

        $messages = [
            'name.required'        => 'Vui lòng nhập tên.',
            'name.max'             => 'Tên không được vượt quá :max ký tự.',
            'phone.required'       => 'Vui lòng nhập số điện thoại.',
            'phone.numeric'        => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại không được vượt quá :max số.',
            'address.required'     => 'Vui lòng nhập địa chỉ.',
            'address.max'          => 'Địa chỉ không được vượt quá :max ký tự.',
            'country_id.required_with' => 'Vui lòng chọn tỉnh/thành phố.',
            'country_id.numeric'      => 'Tỉnh/thành phố phải là một số.',
            'state_id.required_with'  => 'Vui lòng chọn quận/huyện.',
            'state_id.numeric'        => 'Quận/huyện phải là một số.',
            'city_id.required_with'   => 'Vui lòng chọn phường/xã.',
            'city_id.numeric'         => 'Phường/xã phải là một số.',
        ];

        $validator = JsValidatorFacade::make($rules, $messages);

        $carts = Cart::where('user_id', auth()->user()->userID)->get();

        if (count($carts) > 0) {
            checkCouponValidityForCheckout($carts);
        }

        $user = auth()->user();

        $countries = Provinces::orderBy('name', 'asc')->get();
        $stats = Districts::where('code', $user->state_id)->get();
        $cities = Wards::where('code', $user->city_id)->get();

        return view('client.checkout.checkout', [
            'carts'          => $carts,
            'user'           => $user,
            'stats'      => $stats,
            'countries'      => $countries,
            'cities'         => $cities,
            'validator'      => $validator,
        ]);
    }
    public function createLinkPayment($amount)
    {

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('checkPayVNPAY');
        $vnp_TmnCode = $this->tmncode;
        $vnp_HashSecret = $this->hash_secret;
        $vnp_TxnRef = intval(substr(strval(microtime(true) * 10000), -6)); //Random Mã đơn hàng
        $user = auth()->user();
        $vnp_OrderInfo = "$user->name thanh toán đơn hàng";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $amount  * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        if (isset($_POST['redirect'])) {
            return redirect($vnp_Url);
        } else {
            session()->put('vnpay_orderCode', $vnp_TxnRef);
            return ['code' => '00', 'message' => 'success', 'data' => $vnp_Url, 'orderCode' => $vnp_TxnRef];
        }
    }
    public function checkPayVNPAY(Request $request)
    {
        $orderCode = session()->get('vnpay_orderCode');
        $order = OrderModel::where('payment_id', $orderCode)->first();
        $getInfoPayment = $this->getPaymentLinkInformation($orderCode);
        if ($order && $getInfoPayment->RspCode == 00 && $getInfoPayment) {
            if ($getInfoPayment->status != $order->order_status) {
                $data = [
                    'order_status' => $getInfoPayment->status,
                    'shipment_status' => $getInfoPayment->status == "PAID" ? 'PACKED' : 'ORDERPLACE',
                ];
                $update = OrderModel::where('orderID', $order->orderID)->where('user_id', auth()->user()->userID)->update($data);
                if ($update) {
                    // Gửi mail cho khách, nhân viên biết,...
                    if (Session::has('vnpay_orderCode')) {
                        Session::forget('vnpay_orderCode');
                    }
                    Mail::to(auth()->user()->email)->send(new SuccessInvoiceMail($order->orderID, auth()->user()->name,$order->total_ammount,$order->order_date));
                    $notification = array('messege' => 'Xử lý thành công.', 'alert-type' => 'success');
                    return redirect()->route('checkout.invoice', $order->orderID)->with($notification);
                } else {
                    $notification = array('messege' => 'Lỗi quá trình xử lý.', 'alert-type' => 'error');
                    return redirect()->back()->with($notification);
                }
            }
        } else {
            $notification = array('messege' => 'Lỗi quá trình xử lý hoá đơn.', 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }
    public function getPaymentLinkInformation($orderCode)
    {
        $inputData = array();
        $returnData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $this->hash_secret);
        $vnpTranId = $inputData['vnp_TransactionNo'];
        $vnp_BankCode = $inputData['vnp_BankCode'];
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi
        $Status = 0;
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid
            if ($orderCode == $inputData['vnp_TxnRef']) {
                //Kiểm tra checksum của dữ liệu
                if ($secureHash == $vnp_SecureHash) {
                    if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                        $Status = 1; // Trạng thái thanh toán thành công
                        $returnData['status'] = 'PAID';
                    } else {
                        $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                        $returnData['status'] = 'CANCELED';
                    }
                    $returnData['RspCode'] = '00';
                    $returnData['Message'] = 'Confirm Success';
                } else {
                    $returnData['RspCode'] = '97';
                    $returnData['Message'] = 'Invalid signature';
                    $returnData['status'] = 'UNKNOW';
                }
            } else {
                $returnData['RspCode'] = '99';
                $returnData['Message'] = 'Unknow error';
                $returnData['status'] = 'UNKNOW';
            }
        } catch (\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
            $returnData['status'] = 'UNKNOW';
        }
        return response()->json($returnData)->getData();
    }

    # complete checkout process
    public function complete(Request $request)
    {
        $rules = [
            'name'       => 'required|max:100',
            'phone'      => 'required|numeric|digits_between:9,20',
            'address'    => 'required|max:255',
            'country_id' => 'required_with:state_id,city_id|numeric',
            'state_id' => 'required_with:country_id,city_id|numeric',
            'city_id'    => 'required_with:country_id,state_id|numeric',
        ];

        $messages = [
            'name.required'        => 'Vui lòng nhập tên.',
            'name.max'             => 'Tên không được vượt quá :max ký tự.',
            'phone.required'       => 'Vui lòng nhập số điện thoại.',
            'phone.numeric'        => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại không được vượt quá :max số.',
            'address.required'     => 'Vui lòng nhập địa chỉ.',
            'address.max'          => 'Địa chỉ không được vượt quá :max ký tự.',
            'country_id.required_with' => 'Vui lòng chọn tỉnh/thành phố.',
            'country_id.numeric'      => 'Tỉnh/thành phố phải là một số.',
            'state_id.required_with'  => 'Vui lòng chọn quận/huyện.',
            'state_id.numeric'        => 'Quận/huyện phải là một số.',
            'city_id.required_with'   => 'Vui lòng chọn phường/xã.',
            'city_id.numeric'         => 'Phường/xã phải là một số.',
        ];
        $this->validate($request, $rules, $messages);

        $user = auth()->user();
        $userId = $user->userID;
        $carts  = Cart::where('user_id', $userId)->get();

        try {

            // DB::beginTransaction();
            if (count($carts) > 0) {

                if ($request->country_id) {
                    $province_id = $request->country_id;
                }
                if ($request->state_id) {
                    $district_id = $request->state_id;
                }
                if ($request->city_id) {
                    $ward_id = $request->city_id;
                }



                # check if coupon applied -> validate coupon
                $couponResponse = checkCouponValidityForCheckout($carts);
                if ($couponResponse['status'] == false) {
                    $noti = ['message' => $couponResponse['message'], 'alert-type' => 'error'];
                    return redirect()->back()->with($noti);
                }

                # kiểm tra hàng còn trong giỏ hàng -- chạy kiểm tra này trong khi lưu trữ OrderItems
                foreach ($carts as $cart) {

                    $product = Variant::where('variantID', $cart->product_variation_id)->first();

                    if ($product->stock_quantity <= $cart->qty) {
                        $p = Product::where('productID', $product->product_id)->first();
                        $message = $p->name . ' ' . 'đã hết hàng';
                        $noti = ['message' => $message, 'alert-type' => 'error'];
                        return redirect()->back()->with($noti);
                    }
                }

                $voucher = null;
                $voucherType = null;
                if (getCoupon() != '') {
                    $voucherType = VoucherTypeModel::where('name', getCoupon())->first();
                    if ($voucherType) {
                        $voucher = VoucherModel::where('voucher_typeID', $voucherType->voucher_typeID)->first();
                    }
                }
                if ($request->payment_method == 'VNPAY') {
                    $payment_method = "VNPAY";
                } else {
                    $payment_method = "COD";
                }
                # check location
                $provinceCode = Provinces::where('code', $province_id)->pluck('code')->first();
                $districtCode = Districts::where('code', $district_id)->where('province_code', $province_id)->pluck('code')->first();
                $wardCode = Wards::where('code', $ward_id)->where('district_code', $district_id)->pluck('code')->first();
                if ($provinceCode && $districtCode && $wardCode) {
                    # create new order
                    $order                                     = new OrderModel;
                    $order->user_id                            = $userId;
                    $order->order_date                         =  now();
                    $order->coupon_id                          = $voucher ? $voucher->voucherID : null;
                    $order->order_status                       = "PENDING";
                    $order->shipment_status                    = "ORDERPLACE";
                    $order->payment_method                     = $payment_method;
                    $order->payment_id                         = NULL;
                    $order->province_id                        = $provinceCode ?? null;
                    $order->district_id                        = $districtCode ?? null;
                    $order->ward_id                            = $wardCode ?? null;
                    $order->phone                              = $request->phone;
                    $order->address                            = $request->address;
                    $order->name                               = $request->name;
                    $order->note                               = $request->note ?? null;
                    $order->coupon_discount_amount             = $voucherType->discount ?? 0;
                    if (getCoupon() != '') {
                        $order->total_ammount  = getCouponDiscount(getSubTotal($carts, false), getCoupon());
                    }else{
                        $order->total_ammount      = getSubTotal($carts, false);
                    }
                    $order->save();
                } else {
                    $notification = array('messege' => 'Vui lòng chọn đúng địa chỉ.', 'alert-type' => 'error');
                    return redirect()->back()->with($notification);
                }


                // # order items
                foreach ($carts as $cart) {
                    $product = Product::where('productID', $cart->product_id)->first();
                    $orderItem = new OrderDetailModel();
                    $orderItem->product_id = $product->productID;
                    $orderItem->quantity = $cart->qty;
                    $orderItem->order_id = $order->orderID;
                    $orderItem->save();

                    // trừ số lượng
                    $variant = Variant::where('product_id', $product->productID)->first();
                    if ($variant->stock_quantity - $orderItem->quantity < 0) {
                        $variant->stock_quantity = 0; // Đặt giá trị bằng 0 nếu trừ ra âm
                    } else {
                        $variant->stock_quantity -= $orderItem->quantity;
                    }
                    $variant->save();
                    // Xoá cart
                    $cart->delete();
                }



                // # giảm số lần sử dụng voucher
                // if (getCoupon() != '' && $order->coupon_discount_amount > 0) {
                if (getCoupon() != '') {
                    $voucher->voucher_quantity -= 1;
                    $voucher->save();

                    # log lịch sử sử dụng
                    $couponUsageByUser = VoucherUsage::where('user_id', auth()->user()->userID)
                        ->where('name', $voucherType->name)->first();
                    if (!is_null($couponUsageByUser)) {
                        $couponUsageByUser->usage_count += 1;
                    } else {
                        $couponUsageByUser = new VoucherUsage;
                        $couponUsageByUser->usage_count = 1;
                        $couponUsageByUser->name = getCoupon();
                        $couponUsageByUser->user_id = $userId;
                    }
                    $couponUsageByUser->save();
                    removeCoupon();
                }
                #payment
                if ($request->payment_method == "VNPAY") {
                    $response = $this->createLinkPayment($order->total_ammount);
                    if ($response['code'] == 00 && $response['orderCode']) {
                        $data = [
                            'total_ammount' => $order->total_ammount,
                            'user_id' => auth()->user()->userID,
                            'order_date' => now(),
                            'order_status' => 'PENDING',
                            'shipment_status' => 'ORDERPLACE',
                            'payment_method' => 'VNPAY',
                            'payment_id' => $response['orderCode'],
                        ];
                        $orderUpdate = OrderModel::where('orderID', $order->orderID)->update($data);
                        if ($orderUpdate) {
                            return redirect()->to($response["data"]);
                        } else {
                            $notification = array('messege' => 'Lỗi quá trình xử lý.', 'alert-type' => 'error');
                            return redirect()->back()->with($notification);
                        }
                    } else {
                        $notification = array('messege' => 'Xử lý VNPAY thất bại.', 'alert-type' => 'error');
                        return redirect()->back()->with($notification);
                    }
                } else {
                    $data = [
                        'total_ammount' => $order->total_ammount,
                        'user_id' => auth()->user()->userID,
                        'order_date' => now(),
                        'order_status' => 'PENDING',
                        'shipment_status' => 'ORDERPLACE',
                        'payment_method' => 'COD',
                        'payment_id' => NULL,
                    ];
                    $orderUpdate = OrderModel::where('orderID', $order->orderID)->update($data);
                }

                $notification = array('messege' => 'Xử lý thành công.', 'alert-type' => 'success');
                return redirect()->route('checkout.invoice', $order->orderID)->with($notification);
            }
        } catch (\Throwable $th) {
            Log::info('checkout issue :' . $th->getMessage());
            DB::rollBack();
            dd($th);
            $notification = array('messege' => $th->getMessage(), 'alert-type' => 'error');
            return redirect()->route('home')->with($notification);
        }



        $notification = array('messege' => 'Giỏ hàng trống.', 'alert-type' => 'error');
        return redirect()->back()->with($notification);
    }


    # order invoice
    public function invoice($code)
    {
        $order = OrderModel::where('user_id', auth()->user()->userID)
            ->where('orderID', $code)->first();
        if (!$order) {
            return abort(404);
        }
        return view('client.checkout.invoice', ['order' => $order]);
    }
}
