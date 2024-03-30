<?php

namespace App\Http\Controllers;

use App\Models\OrderDetailModel;
use App\Models\OrderModel;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VoucherModel;
use App\Models\VoucherTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public $hash_secret;
    public $tmncode;

    public function __construct()
    {
        // có thể lên https://sandbox.vnpayment.vn/devreg/ để đăng ký sanbox
        $this->hash_secret = 'TSUHRVGRSQRFWCCTVNUUJBENWNHVTRBB';
        $this->tmncode = '1J7H9XAA';
    }

    public function index()
    {
        return view('example');
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

    public function checkAmount($id)
    {
        $product_id = $id;
        // Kiểm tra nếu không có product_id thì trả về kết quả rỗng
        if (!$product_id) {
            return ['totalPrice' => 0, 'status' => false];
        }
        try {
            // Giải mã product_id để có danh sách các sản phẩm
            $decodedProductIds = array_map(function ($hashedId) {
                return decrypt($hashedId);
            }, $product_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Xử lý lỗi nếu có vấn đề khi giải mã
            return ['totalPrice' => 0, 'status' => false];
        }
        // Kiểm tra xem có sản phẩm nào không hợp lệ không
        if (in_array(false, $decodedProductIds, true)) {
            return ['totalPrice' => 0, 'status' => false];
        }
        $products = Product::whereIn('productID', $decodedProductIds)->get();
        $productIds = $products->pluck('productID')->toArray();
        $variants = Variant::whereIn('product_id', $productIds)->get();
        //Tính tổng giá tiền sản phẩm
        $totalPrice = $variants->sum('price');
        $status = false;
        $discountAmountSave = 0;
        $voucher = NULL;
        // Kiểm tra xem có voucher được áp dụng hay không
        if (Session::has('voucher')) {
            $voucher_type = VoucherTypeModel::where('name', session()->get('voucher'))->first();
            if ($voucher_type) {
                $voucher = VoucherModel::where('voucher_typeID', $voucher_type->voucher_typeID)->first();

                // Kiểm tra voucher tồn tại và số lượng > 0
                if ($voucher && $voucher->voucher_quantity > 0) {
                    //kiểm tra ngày bắt đầu, kết thúc
                    $currentDate = now();
                    $startDate = $voucher->start_date;
                    $endDate = $voucher->expired_date;

                    if ($currentDate >= $startDate && $currentDate <= $endDate) {
                        $voucherDiscount = $voucher_type ? $voucher_type->discount : 0;
                        // Tính voucher theo %
                        if ($voucherDiscount > 0 && $voucherDiscount <= 100) {
                            // Tính %
                            $discountAmount = ($voucherDiscount / 100) * $totalPrice; // số tiền giảm
                            $totalPriceAfterDiscount = round($totalPrice - $discountAmount); // tổng tiền sau khi giảm
                        } else {
                            // Tính voucher theo số tiền
                            $discount = $totalPrice - $voucherDiscount;
                            $totalPriceAfterDiscount = max($discount, 0); // tổng tiền sau khi giảm
                            $discountAmount = round($totalPrice - $totalPriceAfterDiscount); // số tiền giảm
                        }
                        if ($totalPriceAfterDiscount > 0) {
                            $status = true;
                            $discountAmountSave = $discountAmount;
                        }
                    } else {
                        // báo lỗi nếu voucher hết hạn
                    }
                } else {
                    // báo lỗi voucher không tồn tại hoặc hết lượt
                }
            } else {
                // Voucher không tồn tại
                echo 'Voucher không tồn tại';
            }
        } else {
            // Nếu không có voucher, kiểm tra giá của giỏ hàng có bằng tổng giá sản phẩm không
            // Vì ở đây chưa làm giỏ hàng nên chỉ demo mẫu
            if ($totalPrice > 0) {
                $status = true;
                $totalPriceAfterDiscount = $totalPrice;
            }
        }
        // Trả về kết quả cuối cùng
        return [
            'totalPrice' => $status ? $totalPriceAfterDiscount : 0,
            'status' => $status,
            'discountAmount' => $status ? $discountAmountSave : 0,
            'voucherID' => $voucher ? $voucher->voucherID : NULL,
            'variants' => $status ? $variants : 0
        ];
    }
    public function payWithVNPAY(Request $request)
    {
        $product_id = $request->input("product_id");
        if (Session::has('voucher')) {
            Session::forget('voucher');
        }
        // $voucher = $request->input('voucher');
        if (getCoupon() != '') {
            $voucher = getCoupon();
        }
        if ($voucher) {
            session()->put('voucher', $voucher);
        }
        if ($product_id) {
            $checkPrice = $this->checkAmount($product_id);
            if ($checkPrice) {
                $response = $this->createLinkPayment($checkPrice['totalPrice']);
                if ($checkPrice['status']) {
                    if ($response['code'] == 00 && $response['orderCode']) {
                        $data = [
                            'total_ammount' => $checkPrice['totalPrice'],
                            'user_id' => auth()->user()->userID,
                            'order_date' => now(),
                            'coupon_id' => $checkPrice['voucherID'] ? $checkPrice['voucherID'] : NULL,
                            'order_status' => 'PENDING',
                            'shipment_status' => 'ORDERPLACE',
                            'payment_method' => 'VNPAY',
                            'payment_id' => $response['orderCode'],
                        ];
                        $order = OrderModel::create($data);
                        if ($order) {
                            // Bởi vì chưa có giỏ hàng nên dùng tạm cái khác.
                            $carts = $checkPrice['variants'];
                            foreach ($carts as $cart) {
                                $product = Product::where('productID', $cart->product_id)->first();
                                $orderItem = new OrderDetailModel();
                                $orderItem->product_id = $product->productID;
                                $orderItem->quantity = 1; // này vì không có cart nên đặt demo là 1
                                $orderItem->save();
                            }
                            // quên session (voucher + nếu cart dùng session thì quên luôn đi)
                            Session::forget('voucher');
                            return redirect()->to($response["data"]);
                        } else {
                            $notification = array('messege' => 'Lỗi quá trình xử lý.', 'alert-type' => 'error');
                            return redirect()->back()->with($notification);
                        }
                    } else {
                        //Báo lỗi xử lý vnpay thất bại
                    }
                } else {
                    // VOucher không tồn tại
                }
            } else {
                // Báo lỗi đơn hàng không hợp lệ
            }
        } else {
            // báo lỗi hoặc chuyển hướng khi không có product_id.
            // return redirect()->route('home')
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
                    return redirect()->route('home');
                } else {
                    // Lỗi trong quá trình update Order
                }
            }
        } else {
            // Lỗi phát sinh. Hoá đơn chưa được tạo
        }
    }
}
