<Style>
    .rounded {
        height: 50px;
        border-radius: 20px;
        /* Góc bo tròn */
        padding: 5px;
        /* Khoảng cách bên trong ô */
        border: 1px solid #ccc;
        /* Viền của ô */
        width: 300px;
        /* Độ rộng của ô */
    }

    .search__bar::placeholder {
        color: #999;
        /* Màu của placeholder */
        font-style: italic;
        /* Nghiêng chữ của placeholder */
    }
</Style>
@extends('client.layout')
@section('tieudetrang')
    SHOP
@endsection
@section('noidungchinh')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>{{ $category->name }}</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->



    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="row">
                @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                        <div class="col-12 col-md-4 col-lg-3 mb-5">
                            <a class="product-item" href="{{ route('product', ['slug' => $product->slug]) }}">
                                <img src="{{ asset('images/shop/' . $product->image_url) }}" class="img-fluid product-thumbnail">
                                <h3 class="product-title">{{ $product->name }}</h3>
                                <strong class="product-price">{{ format_cash($product->price) }}</strong>

                                <span class="icon-cross">
                                    <img src="images/cross.svg" class="img-fluid">
                                </span>
                            </a>
                        </div>
                    @endforeach
                    {{ $products->links() }}
                @else
                    <h3 class="text-center">Không có sản phẩm!</h3>
                @endif


            </div>
        </div>
    </div>
@endsection
