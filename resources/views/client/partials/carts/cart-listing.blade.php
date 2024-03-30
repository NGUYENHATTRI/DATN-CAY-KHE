@if ($carts && $carts->isNotEmpty())
    @foreach ($carts as $cart)
        <tr>
            <td class="h-100px">
                <img src="{{ asset('images/shop/' . getTable($cart->product_id, 'product')->thumnail) }}"
                    alt="{{ getTable($cart->product_id, 'product')->name }}" class="img-fluid" width="100">
            </td>
            <td class="text-center product-title">
                <h6 class="mb-0">
                    {{ getTable($cart->product_id, 'product')->name }}
                </h6>
                <span class="fs-xs">
                    {{ getVariantDetail($cart->product_variation_id) }}
                </span>
                {{-- @foreach (generateVariationOptions($cart->product_variation->combinations) as $variation)
                    <span class="fs-xs">
                        {{ $variation['name'] }}:
                        @foreach ($variation['values'] as $value)
                            {{ $value['name'] }}
                        @endforeach
                        @if (!$loop->last)
                            ,
                        @endif
                    </span>
                @endforeach --}}
            </td>
            <td>
                <span class="text-dark fw-bold me-2 d-lg-none">Đơn giá:</span>
                <span class="text-dark fw-bold">
                    {{ formatPrice(getTable($cart->product_id, 'variant')->price) }}
                </span>
            </td>

            <td>
                <div class="product-qty d-inline-flex align-items-center">
                    <button class="decrese" type="button"
                        onclick="handleCartItem('decrease',{{ $cart->id }})">-</button>
                    <input type="text" readonly value="{{ $cart->qty }} ">
                    <button class="increase" type="button"
                        onclick="handleCartItem('increase', {{ $cart->id }})">+</button>
                </div>
            </td>

            <td>
                <span class="text-dark fw-bold me-2 d-lg-none">Tổng tiền:</span>
                <span class="text-dark fw-bold">
                    {{ formatPrice(getTable($cart->product_id, 'variant')->price * $cart->qty) }}
                </span>
            </td>
            <td>
                <span class="text-dark fw-bold me-2 d-lg-none">Xoá:</span>
                <span class="text-dark fw-bold"><button type="button" class="close-btn ms-3"
                        onclick="handleCartItem('delete', {{ $cart->id }})" style="border:0;background:0"><i
                            class="fas fa-close"></i></button></span>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="py-4">Không có sản phẩm nào trong giỏ hàng</td>
    </tr>
@endif
