<div class="sidebar-widget py-5 px-4 bg-white rounded-2">
    <div class="widget-title d-flex">
        <h5 class="mb-0 flex-shrink-0">Tóm tắt</h5>
        <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
    </div>
    <table class="sidebar-table w-100 mt-5">
        <tr>
            <td>(+) Sản phẩm ({{ count($carts) }}):</td>
            <td class="text-end">{{ formatPrice(getSubTotal($carts, false, '', false)) }}</td>
        </tr>

        {{-- <tr>
            <td>(+) Tax:</td>
            <td class="text-end">{{ formatPrice(getTotalTax($carts)) }}</td>
        </tr> --}}


        @if (getCoupon() != '')
            @if (getCouponDiscount(getSubTotal($carts, false), getCoupon()) > 0)
                <tr>
                    <td>(-) Giảm giá:</td>
                    <td class="text-end">{{ getCoupon('coupon_data') }}
                    </td>
                </tr>
                <tr>
                    <td>(-) Tổng tiền sau giảm giá:</td>
                    <td class="text-end"> {{ formatPrice(getCouponDiscount(getSubTotal($carts, false), getCoupon())) }}
                    </td>
                </tr>
            @endif

            {{-- @if ($is_free_shipping && isset($shippingAmount))
                <tr>
                    <td>(-) Miễn phí shipping:</td>
                    <td class="text-end">{{ formatPrice($shippingAmount) }}
                    </td>
                </tr>
            @endif --}}
        @endif
    </table>

    <span class="sidebar-spacer d-block my-4 opacity-50"></span>

    <div class="d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fs-md">Tổng</h6>
        <h6 class="mb-0 fs-md">
            @if (getCoupon() != '')
                {{ formatPrice(getCouponDiscount(getSubTotal($carts, false), getCoupon())) }}
            @else
                {{ formatPrice(getSubTotal($carts, false)) }}
            @endif
        </h6>
    </div>

    <span class="sidebar-spacer d-block my-4 opacity-50"></span>


    <button type="submit" class="btn btn-primary btn-md rounded mt-6 w-100">Tiếp tục</button>
</div>
