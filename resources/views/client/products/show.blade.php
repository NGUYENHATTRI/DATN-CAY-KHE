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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        let variantID = $('.variant').find('input[type="radio"]:checked').val();
        let materialID = $('.material').find('input[type="radio"]:checked').val();
        let sizeID = $('.size').find('input[type="radio"]:checked').val();
        function getSize(e){
            let ele = $(e);
            sizeID = ele.val();
        }

        function getMaterial(e){
            let ele = $(e);
            materialID = ele.val();
        }

        function getVariant(e){
            let ele = $(e);
            variantID = ele.val();
        }

        $(document).ready(function() {

        });
    </script>
@endsection
