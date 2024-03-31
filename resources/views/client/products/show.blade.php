@extends('client.layout')
@section('tieudetrang')
    Chi tiết
@endsection
@section('noidungchinh')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>{{ $product->name }}</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->



    <!--product details start-->
    <section class="product-details-area ptb-120">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-12">
                    <div class="product-details">
                        <!-- product-view-box -->
                        @include(
                            'client.partials.products.product-view-box',
                            compact('product'))
                        <!-- product-view-box -->

                        <!-- description -->
                        @include(
                            'client.partials.products.description',
                            compact('product'))
                        <!-- description -->
                    </div>
                </div>
            </div>
    </section>
    <!--product details end-->
@endsection
