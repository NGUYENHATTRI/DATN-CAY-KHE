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
                        <h1>Shop</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

<<<<<<< HEAD
=======
		<div class="untree_co-section product-section before-footer-section">
		    <div class="container">
				<div class="row">
					<div class=" col-md-4 desktop">
						<sidebar class="sidebar__filter-wrapper">
							<ul>
								<div class="sidebar__filter">
									<h2 class="sidebar__heading">Lọc theo giá</h2>
									<div class="range-slider-container" >
										<input type="range" class="range-slider" />
										<span id="range-value-bar"></span>
										<span id="range-value">0</span>
									</div>
									<div class="spw">
										<span class="sidebar__span">Giá: $7 - $56</span>
										<button class="button_shop button-filter">TÌM</button>
									</div>
								</div>
							</ul>	
	
							<ul class="sidebar__category">
								<h2 class="sidebar__heading">Danh mục sản phẩm</h2>
							
									<li class="sidebar__category-item">
										<div class="sidebar__category-link">
										@php foreach($categories as $cate) { @endphp
											<a href="/{{$cate->catergoryID}}">{{$cate->name}} </a><hr style="width: 85%;">	
										@php } @endphp
										</div>
									</li>
								
							</ul>
	
							<ul class="sidebar__tags" >
								<h2 class="sidebar__heading">TAGS</h2>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Bình thường</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Cổ điển</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Sáng tạo</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Đồ gốm</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Thẩm mỹ</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Hằng ngày</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Sành điệu</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Trang trí</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Kiểu mới</a></li>
								<li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Thời thượng</a></li>
							</ul>
							<ul class="sidebar__tags" >
								<h2 class="sidebar__heading">Sản phẩm nối bật</h2>
								
								<div class="sidebar__tag-item info-prod-div row" >
									<div class="col" href="" class="image-info-prod">
										<img src="images/product-1.png" alt="" class="image-info">
									</div>
									<div class="info-prod col">
										<div class="name-info">
											<span>Pok Classicle</span>
										</div>
										<div class="star">
											<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
										</div>
										<div class="price-info">
											<span>$</span><span>34.00</span>
										</div>
									</div>
									
								</div><div class="sidebar__tag-item info-prod-div row" >
									<div class="col" href="" class="image-info-prod">
										<img src="images/product-1.png" alt="" class="image-info">
									</div>
									<div class="info-prod col">
										<div class="name-info">
											<span>Pok Classicle</span>
										</div>
										<div class="star">
											<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
										</div>
										<div class="price-info">
											<span>$</span><span>34.00</span>
										</div>
									</div>
									
								</div>
								<div class="sidebar__tag-item info-prod-div row" >
									<div class="col" href="" class="image-info-prod">
										<img src="images/product-1.png" alt="" class="image-info">
									</div>
									<div class="info-prod col">
										<div class="name-info">
											<span>Pok Classicle</span>
										</div>
										<div class="star">
											<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
										</div>
										<div class="price-info">
											<span>$</span><span>34.00</span>
										</div>
									</div>
									
								</div>
							</ul>
							
						</sidebar>
					</div>
>>>>>>> 9567bff15f0db99f6408af068a59f4bdbf5001b1


    <div class="untree_co-section product-section before-footer-section">
        <div class="container">

            <form action="{{ Request::fullUrl() }}" class="filter-form" method="GET">

                <div class="row">
                    <div class=" col-md-4 desktop">
                        <sidebar class="sidebar__filter-wrapper">
                            <ul>
                                <div class="sidebar__filter">
                                    <h2 class="sidebar__heading">Lọc theo giá</h2>
                                    <div class="range-slider-container">
                                        <!-- Đây là thanh trượt giá -->
                                        <input type="range" name="price" class="range-slider" min="{{ $min_value }}"
                                            max="{{ $max_value }}"
                                            value="{{ request()->price ? request()->price : $min_value }}"
                                            onchange="updateRangeValue(this.value)" />
                                        <span id="range-value-bar" style="width:100%"></span>
                                        <span id="range-value">{{ request()->price ? request()->price : $min_value }}</span>
                                    </div>
                                    <div class="spw">
                                        <span class="sidebar__span" id="sidebar__span">Giá: {{ format_cash($min_value) }} -
                                            {{ format_cash($max_value) }}</span>
                                        <script>
                                            function updateRangeValue(value) {
                                                document.getElementById('sidebar__span').innerText = formatCurrency(value);
                                            }

                                            function formatCurrency(amount) {
                                                return parseFloat(amount).toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,') + ' đ';
                                            }
                                        </script>
                                        <button class="button_shop button-filter">TÌM</button>
                                    </div>
                                </div>

                            </ul>

                            <ul class="sidebar__category">
                                <h2 class="sidebar__heading">Danh mục sản phẩm</h2>

                                <li class="sidebar__category-item">
                                    <div class="sidebar__category-link">
                                        @foreach ($categories as $cate)
                                            <a href={{ route('all.productscate', ['slug' => $cate->slug]) }}>{{ $cate->name }}
                                            </a>
                                            <hr style="width: 85%;">
                                        @endforeach
                                    </div>
                                </li>

                            </ul>

                            {{-- <ul class="sidebar__tags">
                                <h2 class="sidebar__heading">TAGS</h2>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Bình thường</a>
                                </li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Cổ điển</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Sáng tạo</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Đồ gốm</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Thẩm mỹ</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Hằng ngày</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Sành điệu</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Trang trí</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Kiểu mới</a></li>
                                <li class="sidebar__tag-item"><a href="" class="sidebar__tag-link">Thời thượng</a>
                                </li>
                            </ul> --}}
                            <ul class="sidebar__tags">
                                <h2 class="sidebar__heading">Sản phẩm nối bật</h2>

                                <div class="sidebar__tag-item info-prod-div row">
                                    <div class="col" href="" class="image-info-prod">
                                        <img src="images/product-1.png" alt="" class="image-info">
                                    </div>
                                    <div class="info-prod col">
                                        <div class="name-info">
                                            <span>Pok Classicle</span>
                                        </div>
                                        <div class="star">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="price-info">
                                            <span>$</span><span>34.00</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="sidebar__tag-item info-prod-div row">
                                    <div class="col" href="" class="image-info-prod">
                                        <img src="images/product-1.png" alt="" class="image-info">
                                    </div>
                                    <div class="info-prod col">
                                        <div class="name-info">
                                            <span>Pok Classicle</span>
                                        </div>
                                        <div class="star">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="price-info">
                                            <span>$</span><span>34.00</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="sidebar__tag-item info-prod-div row">
                                    <div class="col" href="" class="image-info-prod">
                                        <img src="images/product-1.png" alt="" class="image-info">
                                    </div>
                                    <div class="info-prod col">
                                        <div class="name-info">
                                            <span>Pok Classicle</span>
                                        </div>
                                        <div class="star">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="price-info">
                                            <span>$</span><span>34.00</span>
                                        </div>
                                    </div>

                                </div>
                            </ul>

                        </sidebar>
                    </div>

                    <div class="col col-sm-6 col-md-8">
                        <div class="products__heading spw">


                            <input class="rounded search__bar" name="search" type="text" placeholder="Nhập tên sản phẩm"
                                value="{{ old('search', isset(request()->search) ? request()->search : '') }}">
                            <div class="products__heading-right d-flex ms-3">
                                <select name="category" class="category products__heading-right-select">
                                    <option value="" class="products__heading-right-option"
                                        {{ !request()->category ? 'selected' : '' }}>
                                        -- Chọn chuyên mục --
                                    </option>
                                    @foreach ($categories as $row)
                                        <option value="{{ $row->slug }}" class="products__heading-right-option"
                                            {{ $row->slug == request()->category ? 'selected' : '' }}>
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>



                                <select name="sort_by" id="" class="sort_by products__heading-right-select">
                                    <option value="new" class="products__heading-right-option"
                                        {{ $sort_by == 'new' ? 'selected' : '' }}>
                                        Sản phẩm mới
                                    </option>
                                    <option value="desc" class="products__heading-right-option"
                                        {{ $sort_by == 'desc' ? 'selected' : '' }}>
                                        Lọc theo giá cao đến thấp
                                    </option>
                                    <option value="asc" class="products__heading-right-option"
                                        {{ $sort_by == 'asc' ? 'selected' : '' }}>
                                        Lọc theo giá thấp đến cao
                                    </option>
                                </select>

                            </div>
                        </div>
                        <div class="row product-list">
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <!-- Start Column 2 -->
                                    <div class="col-12 col-md-4 col-lg-4 mb-5">
                                        <div class="product-item position-relative">
                                            <a href="{{ route('product', ['slug' => $product->slug]) }}"><img
                                                    src="{{ asset('images/shop/' . $product->image_url) }}"
                                                    class="img-fluid product-thumbnail"></a>
                                            
                                            <h3 class="product-title">{{ $product->name }}</h3>
                                            <strong class="product-price">{{ format_cash($product->price) }}</strong>

                                            <form class="direct-add-to-cart-form">
                                                <span class="icon-cross">
                                                    <img src="{{ asset('images/cross.svg') }}"
                                                        data-product_variation_id="{{ $product->product_variation_id }}"
                                                        data-quantity="1" onclick="directAddToCartFormSubmit(this)"
                                                        class="img-fluid">
                                                </span>
                                            </form>

                                        </div>
                                    </div>
                                    <!-- End Column 2 -->
                                @endforeach
                                {{ $products->links() }}
                            @else
                                <h3 class="text-center">Không có sản phẩm!</h3>
                            @endif
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $('.product-listing-pagination').on('focusout', function() {
            $('.filter-form').submit();
        });

        $('.sort_by').on('change', function() {
            $('.filter-form').submit();
        });
        $('.category').on('change', function() {
            $('.filter-form').submit();
        });
        const productList = $('.product-list');
        const searchBar = $('.search__bar');

        let typingTimer;
        const doneTypingInterval = 500; // milliseconds

        searchBar.on('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(performSearch, doneTypingInterval);
        });
    </script>
@endsection
