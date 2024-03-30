@extends('client.layout')
@section('tieudetrang')
    Thanh toán
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



    <!--checkout form start-->
    <form class="checkout-form" action="{{ route('checkout.complete') }}" method="POST">
        @csrf
        <div class="checkout-section ptb-120 untree_co-section">
            <div class="container">
                <div class="row g-4">
                    <!-- form data -->
                    <div class="col-xl-8">
                        <div class="checkout-steps">

                            <div class="sidebar-widget py-5 px-4 bg-white rounded-2">
                                <div class="widget-title d-flex">
                                    <h5 class="mb-0 flex-shrink-0">Thông tin</h5>
                                    <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                                </div>
                                <!-- personal information -->

                                <div class="checkout-form mt-3 p-5 bg-white rounded-2">
                                    <div class="row g-4 form-group">

                                        <div class="col-md-6">
                                            <label for="name" class="text-black">Họ và tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="text-black">Số điện thoại <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ isset($user->phone) ? $user->phone : '' }}">
                                        </div>


                                        <div class="col-xl-6">
                                            <div class="wsus__profile_form_item">
                                                <label>Tỉnh/Thành phố*</label>
                                                <select class="form-control" name="country_id" id="country_id">
                                                    <option value="">Chọn tỉnh/thành phố</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->code }}"
                                                            {{ $user->country_id == $country->code ? 'selected' : '' }}>
                                                            {{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="wsus__profile_form_item">
                                                <label>Quận/Huyện*</label>
                                                <select class="form-control" id="state_id" name="state_id">
                                                    <option value="">Chọn quận/huyện</option>
                                                    @foreach ($stats as $state)
                                                        <option value="{{ $state->code }}"
                                                            {{ $user->state_id == $state->code ? 'selected' : '' }}>
                                                            {{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="wsus__profile_form_item">
                                                <label>Phường/Xã*</label>
                                                <select class="form-control" name="city_id" id="city_id">
                                                    <option value="">Chọn phường/xã</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->code }}"
                                                            {{ $user->city_id == $city->code ? 'selected' : '' }}>
                                                            {{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="wsus__profile_form_item">
                                                <label>Địa chỉ chi tiết*</label>
                                                <input type="text" name="address" value="{{ $user->address }}"
                                                    placeholder="Số nhà 47/10" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="c_order_notes" class="text-black">Ghi chú</label>
                                            <textarea name="note" id="c_order_notes" cols="30" rows="5" class="form-control"
                                            placeholder="Viết ghi chú cho shop ở đây"></textarea>
                                          </div>
                                    </div>
                                </div>
                                <!-- personal information -->

                                <!-- payment methods -->
                                <div class="widget-title d-flex mb-3">
                                    <h5 class="mb-0 flex-shrink-0">Phương thức thanh toán</h5>
                                    <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
                                </div>
                                <select class="form-control" name="payment_method" id="payment_method">
                                    <option value="COD">Thanh toán khi nhận hàng</option>
                                    <option value="VNPAY">Thanh toán bằng VNPAY</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <!-- form data -->

                    <!-- order summary -->
                    <div class="col-xl-4">
                        <div class="checkout-sidebar">
                            @include('client.partials.checkout.orderSummary', [
                                'carts' => $carts,
                            ])
                        </div>
                    </div>
                    <!-- order summary -->
                </div>
            </div>
        </div>
    </form>
    <!--checkout form end-->

@endsection
@section('js')
    {!! $validator->selector('.checkout-form') !!}
@endsection
