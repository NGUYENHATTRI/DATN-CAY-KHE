<div class="quickview-double-slider">
    @php
        if (!is_null($product->gallery_images)) {
            $galleryImages = explode(',', $product->gallery_images);
        } else {
            $product->thumbnail_image ? ($galleryImages[] = $product->thumbnail_image) : ($galleryImages = []);
        }
    @endphp

    <div class="quickview-product-slider swiper">
        <div class="swiper-wrapper">
            @forelse($galleryImages as $galleryImage)
                <div class="swiper-slide text-center">
                    <img src="{{ asset($galleryImage) }}" alt="{{ $product->name }}"
                        loading="lazy" class="img-fluid">
                </div>
            @empty
                <div class="swiper-slide text-center">
                    <img src="{{  asset('images/shop/' . $variants[0]->image_url )  }}" loading="lazy" alt="No Image" class="img-fluid" id="productImage">
                </div>
            @endforelse
        </div>
    </div>

    <div class="product-thumbnail-slider swiper mt-80">
        <div class="swiper-wrapper">
            @foreach ($galleryImages as $galleryImage)
                <div
                    class="swiper-slide product-thumb-single rounded-2 d-flex align-items-center justify-content-center">
                    <img loading="lazy" src="{{ asset($galleryImage) }}?thumb"
                        alt="{{ $product->name }}" class="img-fluid" />
                </div>
            @endforeach
        </div>
    </div>
</div>
