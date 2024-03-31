<?php

use App\Models\MaterialModel;
use App\Models\Product;
use App\Models\SizeModel;
use App\Models\Variant;
use App\Models\VoucherModel;
use App\Models\VoucherTypeModel;
use App\Models\VoucherUsage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Collection;

if (!function_exists('countTable')) {
    function countTable($table)
    {
        if ($table) {
            return DB::table($table)->count();
        }
        return 0;
    }
}
function getImage($image)
{
    $urlComponents = parse_url($image);
    if (isset($urlComponents['scheme']) && in_array($urlComponents['scheme'], ['http', 'https'])) {
        return $image;
    } else {
        $basePath = env('APP_URL');

        if (strpos($image, '/') === 0) {
            return $basePath . '/' . ltrim($image, '/');
        } else {
            return $basePath . '/' . $image;
        }
    }
}
function format_cash($amount)
{

    $formatted_amount = number_format($amount, 0, ',', '.') . ' ₫';

    return $formatted_amount;
}
function getRender($path, $data = [])
{
    return view($path, $data)->render();
}
// function variationTaxAmount($product, $variation)
// {
//     $price = $variation->price;
//     $tax   = 0;

//     $discount_applicable = false;

//     if ($product->discount_start_date == null || $product->discount_end_date == null) {
//         $discount_applicable = false;
//     } elseif (
//         strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
//         strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
//     ) {
//         $discount_applicable = true;
//     }

//     if ($discount_applicable) {
//         if ($product->discount_type == 'percent') {
//             $price -= ($price * $product->discount_value) / 100;
//         } elseif ($product->discount_type == 'flat') {
//             $price -= $product->discount_value;
//         }
//     }

//     foreach ($product->taxes as $product_tax) {
//         if ($product_tax->tax_type == 'percent') {
//             $tax += ($price * $product_tax->tax_value) / 100;
//         } elseif ($product_tax->tax_type == 'flat') {
//             $tax += $product_tax->tax_value;
//         }
//     }

//     return $tax;
// }
function getSubTotal($carts, $couponDiscount = true, $couponCode = '')
{
    $price = 0;
    $amount = 0;
    if (count($carts) > 0) {
        foreach ($carts as $cart) {
            $variation  = $cart->product_variation_id;
            $product    = Variant::where('variantID', $variation)->first();
            $discountedVariationPriceWithTax = $product->price;
            $price += (float) $discountedVariationPriceWithTax * $cart->qty;
        }

        # calculate coupon discount
        if ($couponDiscount) {
            $amount = getCouponDiscount($price, $couponCode);
        }
    }

    return $price - $amount;
}
// function variationDiscountedPrice($product)
// {
//     $price = $product->price;
//     return $price;
// }
function getCouponDiscount($subTotal, $code = '')
{
    $amount = 0;
    $voucherType = VoucherTypeModel::where('name', $code)->first();
    if ($voucherType) {
        $voucher = VoucherModel::where('voucher_typeID', $voucherType->voucher_typeID)->first();
        $currentDate = Carbon::now()->toDateString();
        # check if coupon is not expired
        if ($voucher->start_date <= $currentDate && $voucher->expired_date >= $currentDate) {
            if ($voucherType->discount_type == 'flat') {
                $amount = $subTotal - (float) $voucherType->discount;
            } else {
                $amount = $subTotal - ((float) $voucherType->discount * $subTotal) / 100;
            }
            if ($amount < 0) {
                $amount = 0;
            }
        } else {
            removeCoupon();
        }
    } else {
        removeCoupon();
    }

    return $amount;
}
function removeCoupon()
{
    if (request()->hasCookie('coupon_code')) {
        $response = new Response();
        Cookie::queue(Cookie::forget('coupon_code'));
        Cookie::queue(Cookie::forget('coupon_data'));
        return $response;
    }
}


function setCoupon($coupon)
{
    $theTime = now()->addDays(7)->timestamp;
    // setCouponTypeDiscount($coupon->discount,$coupon->discount_type);
    return Cookie::queue('coupon_code', $coupon->name, $theTime);
}

function setCouponTypeDiscount($amount, $type)
{
    $theTime = now()->addDays(7)->timestamp;

    $formattedAmount = '';
    if ($type === 'flat') {
        $formattedAmount = formatPrice($amount);
    } else {
        $formattedAmount = $amount . '%';
    }
    return Cookie::queue('coupon_data', $formattedAmount, $theTime);
}




function getCoupon($type = "default")
{
    if ($type == "default") {
        if (request()->hasHeader("Coupon-Code")) {
            return request()->header("Coupon-Code");
        }
        if (request()->hasCookie('coupon_code')) {
            return request()->cookie('coupon_code');
        }
    }
    if ($type == "coupon_data") {
        if (request()->hasCookie('coupon_data')) {
            return request()->cookie('coupon_data');
        }
    }

    return '';
}


function checkCouponValidityForCheckout($carts)
{
    if (getCoupon() != '') {
        // $currentDate = Carbon::now()->toDateString();
        // $voucherType = VoucherTypeModel::where('name', getCoupon())->first();
        // if ($voucherType) {
        $voucherType = VoucherTypeModel::where('name', getCoupon())->first();
        if ($voucherType) {
            $voucher = VoucherModel::where('voucher_typeID', $voucherType->voucher_typeID)->first();
            $currentDate = Carbon::now()->toDateString();
            if ($voucher->voucher_quantity <= 0) {
                removeCoupon();
                return [
                    'status'    => false,
                    'message'   => 'Mã giảm giá đã hết lượt'
                ];
            }
            # total coupon usage
            $totalCouponUsage = VoucherUsage::where('name', $voucher->name)->sum('usage_count');
            if ($totalCouponUsage > $voucher->customer_usage_limit) {
                # coupon usage limit reached
                removeCoupon();
                return [
                    'status'    => false,
                    'message'   => 'Mã giảm giá đã sử dụng'
                ];
            }


            # check if coupon is expired
            if ($voucher->start_date <= $currentDate && $voucher->expired_date >= $currentDate) {
                $subTotal = (float) getSubTotal($carts, false);
                if ($subTotal >= (float) $voucher->min_spend) {
                    return [
                        'status'    => true,
                        'message'   => ''
                    ];
                } else {
                    # min amount not reached
                    removeCoupon();
                    return [
                        'status'    => false,
                        'message'   => 'Không đạt được số tiền tối thiểu để sử dụng phiếu giảm giá này'
                    ];
                }
            } else {
                # expired
                removeCoupon();
                return [
                    'status'    => false,
                    'message'   => 'Mã giảm giá đã hết hạn'
                ];
            }
        } else {
            # coupon not found
            removeCoupon();
            return [
                'status'    => false,
                'message'   => 'Mã giảm giá không tồn tại'
            ];
        }
    }

    // coupon not set - so return true
    return [
        'status'    => true,
        'message'   => ''
    ];
}


function getTotalTax($carts)
{
    $tax = 0;
    if ($carts) {

        foreach ($carts as $cart) {
            $product    = $cart->product_variation->product;
            $variation  = $cart->product_variation;

            $variationTaxAmount = variationTaxAmount($product, $variation);
            $tax += (float) $variationTaxAmount * $cart->qty;
        }
    }
    return $tax;
}


function getTable($id, $type)
{
    if ($id) {
        if ($type == 'product') {
            return Product::where('productID', $id)->first();
        }
        if ($type == 'variant') {
            return Variant::where('variantID', $id)->first();
        }
    }
}

function formatPrice($price, $type = "default")
{
    if ($type == "default") {
        return str_replace(",", ".", number_format($price)) . ' đ';
    } else {
        return str_replace(",", ".", number_format($price));
    }
}

function getVariantDetail($id)
{
    if ($id) {
        $variant = Variant::where('variantID', $id)->first();
        if ($variant) {
            $size = SizeModel::where('sizeID', $variant->size_id)->first();
            $material = MaterialModel::where('materialID', $variant->material_id)->first();

            // Xây dựng chuỗi mô tả
            $description = $material ? $material->name : 'null';
            $description .= ' x Size: ';
            $description .= $size ? $size->name : 'null';

            return $description;
        }
    }

    return null;
}
function noImage()
{
    return asset("images/no-data-found.png");
}
// function generateVariationOptions($options, bool $withTrash = true)
// {
//     $variationIds = [];

//     $options->each(function ($option) use (&$variationIds) {
//         $variationIds[$option->variantID][] = $option->variantID;
//     });

//     $result = [];

//     foreach ($variationIds as $id => $values) {
//         $variationValues = [];
//         foreach ($values as $value) {
//             $variationValue = Variant::find($value);
//             if ($variationValue) {
//                 $variationValues[] = [
//                     'id'   => $value,
//                     'name' => $variationValue->color,
//                     'code' => null,
//                 ];
//             }
//         }

//         $variation = [
//             'id'     => $id,
//             'name'   => $withTrash ? Variant::find($id)->color : null,
//             'values' => $variationValues,
//         ];

//         $result[] = $variation;
//     }

//     return $result;
// }
function generateVariationOptions($options, $withTrash = true)
{
    $variationIds = [];

    $options->each(function ($option) use (&$variationIds) {
        $variationIds[$option->product_id][] = $option->variantID;
    });

    $result = [];

    foreach ($variationIds as $id => $values) {
        $variationValues = [];
        foreach ($values as $value) {
            $variationValue = Variant::find($value);
            if ($variationValue) {
                $variationValues[] = [
                    'id'   => $value,
                    'name' => $variationValue->color,
                    'code' => null,
                ];
            }
        }
        foreach ($values as $value) {
            $variationValue = Variant::find($value);
            if ($variationValue) {
                $size = SizeModel::find($variationValue->size_id);
                $variationValues[] = [
                    'id'        => $value,
                    'name'      => $size->name,
                    'code'      => null,
                ];
            }
        }
        foreach ($values as $value) {
            $variationValue = Variant::find($value);
            if ($variationValue) {
                $material = MaterialModel::find($variationValue->material_id);
                $variationValues[] = [
                    'id'        => $value,
                    'name'      => $material->name,
                    'code'      => null,
                ];
            }
        }


        $variation = [
            'id'     => $id,
            'name'   => $withTrash ? Variant::find($id)->color : null,
            'values' => $variationValues,
        ];

        $result[] = $variation;
    }

    return $result;
}
function variationPrice($product, $variation)
{
    $price = $variation->price;
    return $price;
}
function discountedProductBasePrice($product, $formatted = false)
{
    $price = $product->min_price;

    return $formatted ? formatPrice($price) : $price;
}
function getStatusOrder($text)
{
    $statusHtml = '';

    switch ($text) {
        case 'PAID':
            $statusHtml = "Đã thanh toán";
            break;
        case 'CANCELED':
            $statusHtml = "Đã huỷ";
            break;
        case 'PENDING':
            $statusHtml = "Chưa thanh toán";
            break;
        default:
            break;
    }

    return $statusHtml;
}

function getStatusOrderShip($text)
{
    $statusHtml = '';

    switch ($text) {
        case 'ORDERPLACE':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Đơn hàng đã được tạo
                        </span>";
            break;
        case 'PACKED':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Đơn hàng đã nhận và đang đóng gói
                        </span>";
            break;
        case 'SHIPPED':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Gói hàng đã được chuyển giao
                        </span>";
            break;
        case 'IN_TRANSIT':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Gói hàng đang trên đường đến điểm đến
                        </span>";
            break;
        case 'OUT_FOR_DELIVERY':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Gói hàng đang được giao cho người nhận
                        </span>";
            break;
        case 'DELIVERED':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Gói hàng đã được giao thành công
                        </span>";
            break;
        case 'DELAYED':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Gói hàng gặp trễ hẹn trong quá trình vận chuyển
                        </span>";
            break;
        case 'EXCEPTION':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Gặp vấn đề hoặc ngoại lệ trong quá trình vận chuyển
                        </span>";
            break;
        case 'RETURNED':
            $statusHtml = "<span class='badge rounded-pill bg-primary-light text-primary fw-medium p-0' style='text-align:left;font-size:16px'>
                            Gói hàng đã được trả lại cho người gửi
                        </span>";
            break;
        default:

            break;
    }

    return $statusHtml;
}

