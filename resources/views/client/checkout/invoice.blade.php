@extends('client.layout')
@section('tieudetrang')
    Hoá đơn
@endsection
@section('noidungchinh')


    <!--invoice section start-->
    @if (!is_null($order))
        @php
            $orderItems = $order->orderItems;
            $totalOrderPrice = 0;
        @endphp
        <section class="invoice-section pt-6 pb-120  untree_co-section">
            <div class="container">
                <div class="invoice-box bg-white rounded p-4 p-sm-6">
                    <div class="row g-5 justify-content-between">
                        <div class="col-lg-6">
                            <div class="invoice-title d-flex align-items-center">
                                <h3>Hoá đơn</h3>
                                <span
                                    class="badge rounded-pill
                                @if ($order->order_status == 'PAID') bg-primary-light text-primary
                                @elseif($order->order_status == 'PENDING') bg-danger text-white
                                @elseif($order->order_status == 'CANCELED') bg-secondary text-dark @endif
                                fw-medium ms-3">
                                    {{ getStatusOrder($order->order_status) }}
                                </span>

                            </div>
                            <table class="invoice-table-sm">
                                <tr>
                                    <td><strong>Mã đặt hàng</strong></td>
                                    <td>{{ $order->orderID }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Ngày đặt hàng</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-5 col-md-8">
                            <div class="text-lg-end">
                                <h3 class="mb-0 text-gray mt-4">{{ env('APP_NAME') }}</h3>
                            </div>
                        </div>
                    </div>
                    <span class="my-6 w-100 d-block border-top"></span>
                    <div class="row justify-content-center g-5">
                        <div class="col-xl-12 col-lg-12">
                            <div class="shipping-address d-flex justify-content-md-end mt-2">
                                <div class="border-end pe-2">
                                    <h6 class="mb-2 me-3">Tình trạng đơn hàng</h6>
                                    {!! getStatusOrderShip($order->shipment_status) !!}

                                </div>
                                <div class="ms-4">
                                    <h6 class="mb-2">Địa chỉ nhận hàng</h6>
                                    <p class="mb-0">{{ $order->address }},
                                        {{ $order->ward->name }},
                                        {{ $order->district->name }},
                                        {{ $order->province->name }}
                                    </p>
                                    <p>{{ $order->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-6">
                        <table class="table invoice-table">
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                            </tr>
                            @foreach ($orderItems as $key => $item)
                                @php
                                    $product = $item->product;
                                    $variant = $item->product_variation;
                                    $totalPrice = $variant->price * $item->quantity;
                                    $totalOrderPrice += $totalPrice;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/shop/' . $product->thumnail) }}"
                                                alt="{{ $product->name }}" class="img-fluid product-item me-2">
                                            {{-- <div class="ms-2"> --}}
                                            <div class="">
                                                <span>{{ $product->name }}</span>
                                                {{-- <div>
                                                    @foreach (generateVariationOptions($item) as $variation)
                                                        <span class="fs-xs">
                                                            {{ $variation['name'] }}:
                                                            @foreach ($variation['values'] as $value)
                                                                {{ $value['name'] }}
                                                            @endforeach
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ formatPrice($variant->price) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        {{ formatPrice($totalPrice) }}
                                    </td>


                                </tr>
                            @endforeach


                        </table>
                    </div>
                    <div class="mt-4 table-responsive">
                        @if($order->note)
                            <p class="text-dark fw-bold">Ghi chú từ khách hàng: <span class="fw-normal">{{ $order->note }}</span></p>
                        @endif
                        <table class="table footer-table">
                            <tr>
                                <td>
                                    <strong class="text-dark d-block text-nowrap">Phương thức thanh toán</strong>
                                    <span>
                                        {{ $order->payment_method == 'VNPAY' ? 'VNPAY' : 'Thanh toán khi nhận hàng' }}</span>
                                </td>
                                <td>
                                    <strong class="text-dark d-block text-nowrap">Tổng</strong>
                                    <span>{{ formatPrice($totalOrderPrice) }}</span>
                                </td>
                                <td>
                                    <strong class="text-dark d-block text-nowrap">Giảm giá</strong>
                                    <span>
                                        @if ($order->coupon_id && $order->coupon_discount_amount)
                                            {{ formatPrice($order->coupon_discount_amount) }}
                                        @else
                                            {{ formatPrice(0) }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-dark d-block text-nowrap">Tổng tiền</strong>
                                    <span class="text-primary fw-bold">{{ formatPrice($order->total_ammount) }}</span>
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--invoice section end-->

@endsection
@section('js')
    {{-- {!! $validator->selector('.checkout-form') !!} --}}
@endsection
