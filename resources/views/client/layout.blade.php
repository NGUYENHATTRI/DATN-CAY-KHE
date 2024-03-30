<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/detail.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.0.0/simplebar.min.css"
        integrity="sha512-iQBsppXZIltfj3yN99ljZ/JqWSXOMMArhR6paziJaU42nMPfTuDkXF+yE/PBqbF9guEczGppZctiZ32ZCYssXw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('tieudetrang')</title>
    <style>
         input[aria-describedby$="error"][aria-invalid="true"]{
            border:1px solid red;
            background:rgb(250 190 190 / 5%);
        }
        .error-help-block{
            color:red;
        }
    </style>
    <script>
        'use strict'

        var TT = TT || {};
        TT.localize = {
            buyNow: 'Buy Now',
            addToCart: 'Add to Cart',
            outOfStock: 'Out of Stock',
            addingToCart: 'Adding..',
            optionsAlert: 'Please choose all the available options',
            applyCoupon: 'Apply Coupon',
            pleaseWait: 'Please Wait',
        }

        TT.ProductSliders = () => {
            let quickViewProductSlider = new Swiper(".quickview-product-slider", {
                slidesPerView: 1,
                centeredSlides: true,
                speed: 700,
                loop: true,
                loopedSlides: 6,
            });
            let productThumbnailSlider = new Swiper(".product-thumbnail-slider", {
                slidesPerView: 4,
                speed: 700,
                loop: true,
                spaceBetween: 20,
                slideToClickedSlide: true,
                loopedSlides: 6,
                centeredSlides: true,
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                    },
                    380: {
                        slidesPerView: 3,
                    },
                    576: {
                        slidesPerView: 4,
                    },
                },
            });
            if (quickViewProductSlider && quickViewProductSlider.length > 0) {
                quickViewProductSlider.forEach(function(item, index) {
                    item.controller.control = productThumbnailSlider[index];
                    productThumbnailSlider[index].controller.control = item;
                });
            } else {
                quickViewProductSlider.controller.control = productThumbnailSlider;
                productThumbnailSlider.controller.control = quickViewProductSlider;
            }
        }
    </script>
</head>

<body>

    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark fixed-top" arial-label="Furni navigation bar">

        <div class="container">
            <a class="navbar-brand" href="/">Furni<span>.</span></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
                aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Trang chủ</a>
                    </li>
                    <li><a class="nav-link" href="/shop">Cửa hàng</a></li>
                    <li><a class="nav-link" href="/about">Về chúng tôi</a></li>
                    <li><a class="nav-link" href="/services">Services</a></li>
                    <li><a class="nav-link" href="/blog">Blog</a></li>
                    <li><a class="nav-link" href="/contact">Contact us</a></li>
                </ul>
                @php
                    $carts = [];
                    if (Auth::check()) {
                        $carts = App\Models\Cart::where('user_id', Auth::user()->userID)
                            ->where('location_id', session('stock_location_id'))
                            ->get();
                    } else {
                        if (isset($_COOKIE['guest_user_id'])) {
                            $carts = App\Models\Cart::where('guest_user_id', request()->cookie('guest_user_id'))
                                ->where('location_id', session('stock_location_id'))
                                ->get();
                        }
                    }
                @endphp
                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="/user"><img src="{{ asset('images/user.svg') }}"></a></li>
                    <li class="position-relative gshop-header-cart">
                        <button class="nav-link header-icon"
                            style="background: none;
                        border: none;">
                            <img src="{{ asset('images/cart.svg') }}">
                            @if (isset($carts))
                                <span
                                    class="cart-counter badge bg-primary rounded-circle p-0 {{ count($carts) > 0 ? '' : 'd-none' }}"
                                    style="position: absolute;
                                top: -2px;
                                right: -5px;
                                width: 20px;
                                height: 20px;
                                line-height: 20px;
                                font-size: 12px;">{{ count($carts) }}</span>
                            @endif
                        </button>
                        <div class="cart-box-wrapper">
                            <div class="apt_cart_box theme-scrollbar">
                                <ul class="at_scrollbar scrollbar cart-navbar-wrapper">
                                    <!--cart listing-->
                                    @include('client.partials.carts.cart-navbar', [
                                        'carts' => $carts,
                                    ])
                                    <!--cart listing-->

                                </ul>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <h6 class="mb-0">Tạm tính:</h6>
                                    <span
                                        class="fw-semibold text-secondary sub-total-price">{{ formatPrice(getSubTotal($carts, false)) }}</span>
                                </div>
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-6">
                                        <a href="{{ route('carts.index') }}"
                                            class="btn btn-secondary btn-md mt-4 w-100"><span class="me-2"><i
                                                    class="fa-solid fa-shopping-bag"></i></span>Xem giỏ
                                            hàng</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('checkout.proceed') }}" class="btn btn-primary btn-md mt-4 w-100"><span
                                                class="me-2"><i class="fa-solid fa-credit-card"></i></span>Thanh
                                            toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>

                </ul>
            </div>
        </div>

    </nav>
    <!-- End Header/Navigation -->






    <main>
        @yield('noidungchinh')
    </main>





















    <!-- Start Footer Section -->
    <footer class="footer-section">
        <div class="container relative">

            <div class="sofa-img">
                <img src="{{ asset('images/sofa.png') }}" alt="Image" class="img-fluid">
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="subscription-form">
                        <h3 class="d-flex align-items-center"><span class="me-1"><img
                                    src="{{ asset('images/envelope-outline.svg') }}" alt="Image"
                                    class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

                        <form action="#" class="row g-3">
                            <div class="col-auto">
                                <input type="text" class="form-control" placeholder="Enter your name">
                            </div>
                            <div class="col-auto">
                                <input type="email" class="form-control" placeholder="Enter your email">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary">
                                    <span class="fa fa-paper-plane"></span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="row g-5 mb-5">
                <div class="col-lg-4">
                    <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Furni<span>.</span></a>
                    </div>
                    <p class="mb-4">Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus
                        malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique.
                        Pellentesque habitant</p>

                    <ul class="list-unstyled custom-social">
                        <li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
                        <li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
                        <li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
                        <li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
                    </ul>
                </div>

                <div class="col-lg-8">
                    <div class="row links-wrap">
                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Contact us</a></li>
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Knowledge base</a></li>
                                <li><a href="#">Live chat</a></li>
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a href="#">Jobs</a></li>
                                <li><a href="#">Our team</a></li>
                                <li><a href="#">Leadership</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a href="#">Nordic Chair</a></li>
                                <li><a href="#">Kruzo Aero</a></li>
                                <li><a href="#">Ergonomic Chair</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-top copyright">
                <div class="row pt-4">
                    <div class="col-lg-6">
                        <p class="mb-2 text-center text-lg-start">Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>. All Rights Reserved. &mdash; Designed with love by <a
                                href="https://untree.co">Untree.co</a> Distributed By <a
                                hreff="https://themewagon.com">ThemeWagon</a>
                            <!-- License information: https://untree.co/license/ -->
                        </p>
                    </div>

                    <div class="col-lg-6 text-center text-lg-end">
                        <ul class="list-unstyled d-inline-flex ms-auto">
                            <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </footer>
    <!-- End Footer Section -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/simplebar.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    @yield('js')

    <script>
        jQuery(function($) {
            "use strict";
            //simple bar
            Array.from(document.querySelectorAll(".scrollbar")).forEach(
                (el) => new SimpleBar(el, {
                    autoHide: false,
                    classNames: {
                        // defaults
                        content: "simplebar-content",
                        scrollContent: "simplebar-scroll-content",
                        scrollbar: "simplebar-scrollbar",
                        track: "simplebar-track",
                    },
                })
            );
            $("#country_id").on("change", function() {
                var countryId = $("#country_id").val();
                if (countryId) {
                    $.ajax({
                        type: "get",
                        url: "{{ url('/state-by-country/') }}" + "/" + countryId,
                        success: function(response) {
                            $("#state_id").html(response.states);
                        },
                        error: function(err) {

                        }
                    })
                } else {
                    var response = "<option value=''>Chọn quận/huyện</option>";
                    $("#state_id").html(response);
                }

            });

            $("#state_id").on("change", function() {
                var stateId = $("#state_id").val();
                if (stateId) {
                    $.ajax({
                        type: "get",
                        url: "{{ url('/city-by-state/') }}" + "/" + stateId,
                        success: function(response) {
                            $("#city_id").html(response.cities);
                        },
                        error: function(err) {

                        }
                    })
                } else {
                    var response = "<option value=''>Chọn phường/xã</option>";
                    $("#state_id").html(response);
                }

            });
            $('.select2').select2();
        });



        // ajax toast
        function notifyMe(level, message) {
            if (level == 'danger') {
                level = 'error';
            }

            // Check if the toastr method corresponding to the level exists
            if (typeof toastr[level] == 'function') {
                toastr.options = {
                    "timeOut": "5000",
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                };
                toastr[level](message);
            } else {
                console.error('Invalid toastr level:', level);
            }
        }

        function showProductDetailsModal(productId) {
            $('#quickview_modal .product-info').html(null);
            $('.data-preloader-wrapper>div').addClass('spinner-border');
            $('.data-preloader-wrapper').addClass('min-h-400');
            $('#quickview_modal').modal('show');

            $.post('http://127.0.0.1:8000/products/show-product-info', {
                _token: 'YvEiotdKImHFbnZWhu3rUYZVlk3wDsqbPegbiQyA',
                id: productId
            }, function(data) {
                setTimeout(() => {
                    $('.data-preloader-wrapper>div').removeClass('spinner-border');
                    $('.data-preloader-wrapper').removeClass('min-h-400');
                    $('#quickview_modal .product-info').html(data);
                    TT.ProductSliders();
                    cartFunc();
                }, 200);
            });
        }

        $('#quickview_modal').on('hide.bs.modal', function(e) {
            $('#quickview_modal .product-info').html(null);
        });




        // get selected variation information
        function getVariationInfo() {
            if ($('.add-to-cart-form input[name=quantity]').val() > 0 && isValidForAddingToCart()) {
                let data = $('.add-to-cart-form').serializeArray();
                console.log(data)
                $.ajax({
                    type: "POST",
                    url: "{{ route('products.getVariationInfo') }}",
                    data: data,
                    success: function(response) {
                        console.log(response)
                        $('.all-pricing').addClass('d-none');
                        $('.variation-pricing').removeClass('d-none');
                        $('.variation-pricing').html(response.data.price);

                        $('.add-to-cart-form input[name=product_variation_id]').val(response.data
                            .id);
                        $('.add-to-cart-form input[name=quantity]').prop('max', response.data.stock);

                        if (response.data.stock < 1) {
                            $('.add-to-cart-btn').prop('disabled', true);
                            $('.add-to-cart-btn .add-to-cart-text').html('Hết hàng');
                        } else {
                            $('.add-to-cart-btn').prop('disabled', false);
                            $('.add-to-cart-btn .add-to-cart-text').html('Thêm vào giỏ hàng');
                            $('.qty-increase-decrease input[name=quantity]').val(1);
                        }
                    }
                });
            }
        }

        // check if it can be added to cart
        function isValidForAddingToCart() {

            var count = 0;
            $('.variation-for-cart').each(function() {
                // how many variations
                count++;
            });

            if ($('.product-radio-btn input:radio:checked').length == count) {
                return true;
            }

            return false;
        }



        // cart func
        function cartFunc() {
            // on selection of variation
            $('.product-radio-btn input').on('change', function() {
                getVariationInfo();
            });

            // increase qty
            $('.qty-increase-decrease .increase').on('click', function() {
                var prevValue = $('.product-qty input[name=quantity]').val();
                var maxValue = $('.product-qty input[name=quantity]').attr('max');
                if (maxValue == undefined || parseInt(prevValue) < parseInt(maxValue)) {
                    $('.qty-increase-decrease input[name=quantity]').val(parseInt(prevValue) + 1)
                }
            });

            // decrease qty
            $('.qty-increase-decrease .decrease').on('click', function() {
                var prevValue = $('.product-qty input[name=quantity]').val();
                if (prevValue > 1) {
                    $('.qty-increase-decrease input[name=quantity]').val(parseInt(prevValue) - 1)
                }
            });

            // add to cart form submit
            $('.add-to-cart-form').on('submit', function(e) {
                e.preventDefault();
                if (isValidForAddingToCart()) {
                    $('.add-to-cart-btn').prop('disabled', true);
                    $('.add-to-cart-btn .add-to-cart-text').html(TT.localize.addingToCart);

                    // add to cart here
                    let data = $('.add-to-cart-form').serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('carts.store') }}",
                        data: data,
                        success: function(data) {
                            $('.add-to-cart-btn').prop('disabled', false);
                            $('.add-to-cart-btn .add-to-cart-text').html(TT.localize.addToCart);
                            updateCarts(data);
                            notifyMe(data.alert, data.message);
                        }
                    });
                } else {
                    optionsAlert();
                }
            })
        }
        cartFunc();

        function directAddToCartFormSubmit(element) {
            var product_variation_id = $(element).data('product_variation_id');
            var quantity = $(element).data('quantity');

            var formData = $(element).closest('.direct-add-to-cart-form').serializeArray();
            formData.push({
                name: 'product_variation_id',
                value: product_variation_id
            });
            formData.push({
                name: 'quantity',
                value: quantity
            });
            console.log(formData)
            $.ajax({
                type: "POST",
                url: "{{ route('carts.store') }}",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    updateCarts(data);
                    notifyMe(data.alert, data.message);
                }
            });
        }



        function getCookie(name) {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.startsWith(name + '=')) {
                    return cookie.substring(name.length + 1);
                }
            }
            return null;
        }

        // please choose all the available options
        function optionsAlert() {
            notifyMe('warning', TT.localize.optionsAlert);
        }

        // handleCartItem
        function handleCartItem(action, id) {

            let data = {
                action: action,
                id: id,
            };
            console.log('run')
            $.ajax({
                type: "POST",
                url: "{{ route('carts.update') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == true) {
                        $('.apply-coupon-btn').removeClass('d-none');
                        $('.clear-coupon-btn').addClass('d-none');
                        $('.apply-coupon-btn').prop('disabled', false);
                        // $('.apply-coupon-btn').html(TT.localize.applyCoupon);
                        updateCarts(data);
                        // if (action == 'increase' && data.message) {
                        notifyMe(data.alert, data.message);
                        // }
                    }
                }
            });
        }

        // coupon-form form submit
        $('.coupon-form').on('submit', function(e) {
            e.preventDefault();
            $('.apply-coupon-btn').prop('disabled', true);
            $('.apply-coupon-btn').html('Vui lòng đợi');

            // apply coupon here
            let data = $('.coupon-form').serializeArray();
            $.ajax({
                type: "POST",
                url: "{{ route('carts.applyCoupon') }}",
                data: data,
                success: function(data) {
                    if (data.success == false) {
                        notifyMe('error', data.message);
                        $('.apply-coupon-btn').prop('disabled', false);
                        $('.apply-coupon-btn').html('Áp dụng');
                    } else {
                        // append clear button
                        $('.coupon-input').prop('disabled', false);
                        $('.apply-coupon-btn').addClass('d-none');
                        $('.clear-coupon-btn').removeClass('d-none');
                        $('.apply-coupon-btn').prop('disabled', false);
                        $('.apply-coupon-btn').html('Áp dụng');
                        updateCouponPrice(data);

                    }
                }
            });
        })

        // clear-coupon-btn clicked
        $('.clear-coupon-btn').on('click', function(e) {
            e.preventDefault();
            // append clear button
            $('.coupon-input').prop('disabled', false);
            $('.apply-coupon-btn').removeClass('d-none');
            $('.clear-coupon-btn').addClass('d-none');

            $.ajax({
                type: "GET",
                url: "{{ route('carts.clearCoupon') }}",
                success: function(data) {
                    updateCouponPrice(data);
                }
            });
        })

        function formatPrice(price) {
            return price.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
        }

        function updateCouponPrice(data) {
            $('.coupon-discount-wrapper').toggleClass('d-none');
            console.log(data)

            if(data.couponDiscount){
                $('.coupon-discount-price').html(formatPrice(data.couponDiscount));
            }
            if(data.couponData){
                $('.coupon-type').html(data.couponData);
            }
            var alert = 'error';
            if(data.message == 'Áp dụng mã giảm giá thành công'){
                alert = 'success';
            }else{
                alert = 'error';
            }
            notifyMe(alert, data.message);
        }


        // update carts markup
        function updateCarts(data) {
            $('.cart-counter').empty();
            $('.sub-total-price').empty();

            $('.cart-navbar-wrapper .simplebar-content').empty();
            $('.cart-listing').empty();

            if (data.cartCount > 0) {
                $('.cart-counter').removeClass('d-none');
            } else {
                $('.cart-counter').addClass('d-none');
            }

            $('.cart-counter').html(data.cartCount);
            $('.sub-total-price').html(formatPrice(data.subTotal));
            $('.cart-navbar-wrapper .simplebar-content').html(data.navCarts);
            $('.cart-listing').html(data.carts);
            $('.coupon-discount-wrapper').addClass('d-none');
            $('.checkout-sidebar').empty();

        }

        // get logistics to check out
        function getLogistics(city_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': 'YvEiotdKImHFbnZWhu3rUYZVlk3wDsqbPegbiQyA'
                },
                url: "http://127.0.0.1:8000/get-checkout-logistics",
                type: 'POST',
                data: {
                    city_id: city_id
                },
                success: function(data) {
                    $('.checkout-sidebar').empty();
                    $('.checkout-logistics').empty();
                    $('.checkout-logistics').html(data.logistics);
                    $('.checkout-sidebar').html(data.summary);
                }
            });
        }

        //  get logistics to check out -- onchange
        $(document).on('change', '[name=chosen_logistic_zone_id]', function() {
            var chosen_logistic_zone_id = $(this).val();
            getShippingAmount(chosen_logistic_zone_id);
        });

        // get logistics to check out
        function getShippingAmount(logistic_zone_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': 'YvEiotdKImHFbnZWhu3rUYZVlk3wDsqbPegbiQyA'
                },
                url: "http://127.0.0.1:8000/shipping-amount",
                type: 'POST',
                data: {
                    logistic_zone_id: logistic_zone_id
                },
                success: function(data) {
                    $('.checkout-sidebar').empty();
                    $('.checkout-sidebar').html(data);
                }
            });
        }

        //  submit checkout form
        // $(document).on('submit', '.checkout-form', function(e) {
        //     // shipping address not selected
        //     if ($('.checkout-form input[name=shipping_address_id]:checked').length == 0) {
        //         notifyMe('error', 'Please select shipping address');
        //         e.preventDefault();;
        //         return false;
        //     }

        //     // logistic not selected
        //     if ($('.checkout-form input[name=chosen_logistic_zone_id]:checked').length == 0) {
        //         notifyMe('error', 'Please select logistic');
        //         e.preventDefault();;
        //         return false;
        //     }

        //     // billing address not selected
        //     if ($('.checkout-form input[name=billing_address_id]:checked').length == 0) {
        //         notifyMe('error', 'Please select billing address');
        //         e.preventDefault();;
        //         return false;
        //     }
        // });

        // add to wishlist
        function addToWishlist(productId) {
            notifyMe('danger', 'Only customer can add products to wishlist');
        }
    </script>
    <script>
        @if ($errors->all())
            @foreach ($errors->all() as $error)
                notifyMe('danger', '{{ $error }}')
            @endforeach
        @endif
        @if (session('message'))
            notifyMe('{{ session('alert-type') }}', '{{ session('message') }}')
        @endif
    </script>
</body>



</html>
