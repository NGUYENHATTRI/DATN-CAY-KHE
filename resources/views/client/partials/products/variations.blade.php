@if (count(generateVariationOptions($product->variations())) > 0)
    @foreach (generateVariationOptions($product->variations()) as $variation)
        <input type="hidden" name="variation_id[]" value="{{ $variation['id'] }}" class="variation-for-cart">
        <input type="hidden" name="product_id" value="{{ $product->productID }}">

        <ul
            class="@if ($loop->first) ps-0 @endif product-radio-btn mt-1 mb-3 d-flex align-items-center gap-2 @if ($loop->last) mb-6 @endif">
            @foreach ($variation['values'] as $value)
                <li>
                    <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}"
                        value="{{ $value['id'] }}" id="val-{{ $value['id'] }}">
                    <label for="val-{{ $value['id'] }}">{{ $value['name'] }}</label>
                </li>
            @endforeach
        </ul>
    @endforeach
@endif
