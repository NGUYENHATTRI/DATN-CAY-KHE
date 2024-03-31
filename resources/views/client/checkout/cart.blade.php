@extends('client.layout')
@section('tieudetrang')
    Giỏ hàng
@endsection
@section('noidungchinh')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Giỏ hàng</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->



    <div class="untree_co-section before-footer-section">
        <div class="container">
            <div class="row mb-5">
                <form class="col-md-12" method="post">
                    <div class="site-blocks-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Hình</th>
                                    <th class="product-name">Tên sản phẩm</th>
                                    <th class="product-price">Giá</th>
                                    <th class="product-quantity">Số lượng</th>
                                    <th class="product-total">Tổng</th>
                                    <th class="product-remove">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="cart-listing">
                                @include('client.partials.carts.cart-listing', ['carts' => $carts])


                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="row">
                        <div class="voucher-box py-7 px-5 position-relative z-1 overflow-hidden rounded mt-4">

                            <h4 class="mb-4">Có mã giảm giá?</h4>
                            <div class="font-bold mb-2">Áp dụng phiếu giảm giá để được giảm giá.</div>

                            <!-- coupon form -->
                            <form class="d-flex align-items-center coupon-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <input type="text" name="code" placeholder="Nhập mã giảm giá của bạn"
                                    class="form-control py-3 theme-input w-100 coupon-input"
                                    value="{{ old('code', request()->cookie('coupon_code')) }}"
                                    @if (request()->cookie('coupon_code')) disabled @endif required>

                                @if (request()->cookie('coupon_code'))
                                    <button type="submit"
                                        class="btn btn-secondary flex-shrink-0 apply-coupon-btn d-none px-4">Áp
                                        dụng</button>
                                    <button type="button" class="btn btn-secondary flex-shrink-0 clear-coupon-btn"><i
                                            class="fas fa-close"></i></button>
                                @else
                                    <button type="submit" class="btn btn-secondary flex-shrink-0 apply-coupon-btn px-4">Áp
                                        dụng</button>
                                    <button type="button"
                                        class="btn btn-secondary flex-shrink-0 clear-coupon-btn d-none"><i
                                            class="fas fa-close"></i></button>
                                @endif
                            </form>
                            <!-- coupon form -->

                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="cart-summery rounded-2 pt-4 pb-7 mt-4">
                            <table class="w-100">
                                <tr>
                                    <td class="py-3">
                                        <h5 class="mb-0 fw-medium">Tổng phụ</h5>
                                    </td>
                                    <td class="py-3">
                                        <h5 class="mb-0 text-end sub-total-price">
                                            {{ formatPrice(getSubTotal($carts, false)) }}

                                        </h5>
                                    </td>
                                </tr>
                                <tr class="coupon-discount-wrapper {{ getCoupon() == '' ? 'd-none' : '' }}">
                                    <td class="py-3">
                                        <h5 class="mb-0 fw-medium">Giảm giá</h5>
                                    </td>
                                    <td class="py-3">
                                        <h5 class="mb-0 text-end coupon-type">
                                            {{ getCoupon('coupon_data') }}
                                        </h5>
                                    </td>
                                </tr>


                                <tr class="coupon-discount-wrapper {{ getCoupon() == '' ? 'd-none' : '' }}">
                                    <td class="py-3">
                                        <h5 class="mb-0 fw-medium">Tổng tiền sau giảm giá</h5>
                                    </td>
                                    <td class="py-3">
                                        <h5 class="mb-0 text-end coupon-discount-price">
                                            {{ formatPrice(getCouponDiscount(getSubTotal($carts, false), getCoupon())) }}
                                        </h5>
                                    </td>
                                </tr>

                            </table>
                            <p class="mb-5 mt-2">Tùy chọn vận chuyển sẽ được cập nhật khi thanh toán</p>
                            <div class="btns-group d-flex flex-wrap gap-3">

                                <a href="{{ route('home') }}"
                                    class="btn btn-outline-secondary border-secondary btn-md rounded-1">Tiếp tục mua sắm</a>

                                <a href="{{ route('checkout.proceed') }}" type="submit"
                                    class="btn btn-primary btn-md rounded-1">Thanh
                                    toán</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
