@forelse ($carts as $cart)

    <li class="d-flex align-items-center pb-3 @if (!$loop->first) pt-3 @endif">
        <div class="thumb-wrapper">
            <a href="{{ route('product', ['slug'=> getTable($cart->product_id,'product')->slug]) }}"><img
                    src="{{ asset("images/shop/" . getTable($cart->product_id, 'product')->thumnail) }}" alt="products"
                    class="img-fluid rounded-circle" style="max-width:50px"></a>
        </div>
        <div class="items-content ms-3">
            <a href="{{ route('product',  getTable($cart->product_id,'product')->slug) }}">
                <h6 class="mb-0">{{  getTable($cart->product_id,'product')->name }}</h6>
            </a>

            {{-- @foreach (generateVariationOptions($cart->product_variation->combinations) as $variation)
                <span class="fs-xs text-muted">

                    @foreach ($variation['values'] as $value)
                        {{ $value['name'] }}
                    @endforeach
                    @if (!$loop->last)
                        ,
                    @endif
                </span>
            @endforeach --}}

            <div class="products_meta mt-1 d-flex align-items-center">
                <div>
                    <span
                        class="price text-primary fw-semibold">{{ $cart->product_variation_id }}</span>
                    <span class="count fs-semibold">x {{ $cart->qty }}</span>
                </div>
                <button class="remove_cart_btn ms-2 rounded-0" style="border:0;background:none" onclick="handleCartItem('delete', {{ $cart->id }})"><i
                        class="fa-solid fa-trash-can"></i></button>
            </div>
        </div>
    </li>
@empty
    <li>
        <img src="{{ asset('images/empty-cart.svg') }}" alt="" srcset=""
            class="img-fluid">
    </li>
@endforelse
