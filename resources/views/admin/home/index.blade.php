@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
@endsection
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h4 class="mb-0">Xin chào, {{ auth()->user()->name }}</h4>
            <p class="mb-0 text-muted">Thống kê website!</p>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- row -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a href="{{ Route('admin.blog') }}">
                <div class="card overflow-hidden sales-card bg-primary-gradient p-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fa-solid fa-pen-nib fs-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-fixed-white">Bài viết</span>
                                <h3 class="text-fixed-white mb-0">{{ countTable('posts') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a href="{{ Route('admin.product') }}">
                <div class="card overflow-hidden sales-card bg-danger-gradient  p-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fa-solid fa-box fs-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-fixed-white">Sản phẩm</span>
                                <h3 class="text-fixed-white mb-0">{{ countTable('product') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a href="{{ Route('admin.user') }}">
                <div class="card overflow-hidden sales-card bg-success-gradient p-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fa-solid fa-user-plus fs-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-fixed-white">Khách hàng</span>
                                <h3 class="text-fixed-white mb-0">{{ countTable('users') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient p-4">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 mt-2 text-center">
                            <i class="fa-solid fa-address-book fs-40"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-0 text-center">
                            <span class="text-fixed-white">Đánh giá</span>
                            <h3 class="text-fixed-white mb-0">{{ countTable('review') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
           
                <div class="card overflow-hidden sales-card bg-danger-gradient  p-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fa-solid fa-box fs-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-fixed-white">Sản phẩm còn tồn kho</span>
                                <h3 class="text-fixed-white mb-0">{{ $products }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            
                <div class="card overflow-hidden sales-card bg-success-gradient p-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fa-solid fa-box fs-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-fixed-white">Sản phẩm mới trong 24h</span>
                                <h3 class="text-fixed-white mb-0">{{ $product24h }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
    <!-- row closed -->


    <!-- row opened -->
    <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header ">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">Thống kê đơn hàng</h4>
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light bg-transparent rounded-pill" data-bs-toggle="dropdown"><i
                                        class="fe fe-more-horizontal"></i></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);">Action</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Another
                                            Action</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Something Else
                                            Here</a>
                                    </div>
                                </div>
                                <p class="fs-12 text-muted mb-0">Thống kê đơn hàng theo bộ lọc</p>
                            </div>
                            <div class="card-body ">
                            <form autocomplete="off" > @csrf
                                <div class="total-revenue">
                                    <div>
                                        <h4> Từ ngày: </h4>
                                        <input type="text" id="datepicker" class="form-control">
                                    </div>
                                    <div>
                                        <h4> Đến ngày: </h4>
                                        <input type="text" id="datepicker2" class="form-control">
                                    </div>
                                    <div>
                                        <h4> Lọc theo </h4>
                                        <select class="filter_date form-control">
                                            <option>--Chọn--</option>
                                            <option value="7ngay">7 ngày qua</option>
                                            <option value="thangtruoc">Tháng trước</option>
                                            <option value="thangnay">Tháng này</option>
                                            <option value="365ngayqua">365 ngày qua</option>
                                        </select>
                                    </div>
                                    <div>
                                        <h4>Lọc: </h4>
                                        <input type="button" id="dates" class="btn btn-primary" value="Lọc kết quả">
                                    </div>
                                </div>
                            </form>
                            <br>
                            <br>
                            <br>
                            <div id="myfirstchart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row closed -->

                <!-- row opened -->
                <div class="row">
                    <div class="col-xl-4 col-md-12 col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="card-header pb-1">
                                <h3 class="card-title mb-2">Khách hàng mới</h3>
                                <p class="fs-12 mb-0 text-muted"></p>
                            </div>
                            <div class="card-body p-0 customers mt-1">
                                <div class="list-group list-lg-group list-group-flush">
                                    @foreach($users as $user)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex">
                                            <img class="avatar avatar-md rounded-circle my-auto me-3" src="../assets/images/faces/3.jpg" alt="Avatar">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="mt-0">
                                                        <h5 class="mb-1 fs-15">{{ $user->name }}</h5>
                                                        <p class="mb-0 fs-13 text-muted">User ID: #{{ $user->userID }} | {{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header pb-1">
                                <h3 class="card-title mb-2">Đơn hàng mới</h3>
                                <p class="fs-12 mb-0 text-muted"></p>
                            </div>
                            <div class="product-timeline card-body pt-2 mt-1">
                                <ul class="timeline-1 mb-0">
                                    @foreach($orders as $order)
                                    <li class="mt-0" style="padding-inline-start: 3rem;">
                                        <i class="fe fe-shopping-cart bg-danger-gradient text-fixed-white product-icon"></i> 
                                        <span class="fw-medium mb-4 fs-14">Đơn hàng #{{ $order->orderID }}</span>
                                        @foreach($orderUserDetails as $orderId => $user) 
                                            <a href="" class="float-end fs-11 text-muted">{{ $user->name }}</a>
                                        @endforeach
                                        <p class="mb-0 text-muted fs-12">Tổng tiền: {{ $order->total_ammount }} | trạng thái: {{ $order->order_status }}</p>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div> 
                    </div>
                    <div class="col-xl-4 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header pb-1">
                                <h3 class="card-title mb-2">Blog mới</h3>
                                <p class="fs-12 mb-0 text-muted"></p>
                            </div>
                            <div class="product-timeline card-body pt-2 mt-1">
                                <ul class="timeline-1 mb-0">
                                   
                                    <li class="mt-0 mb-0" style="padding-inline-start: 3rem;"> <i class="fe fe-edit bg-primary-gradient text-fixed-white product-icon"></i> 
                                    <span class="fw-medium mb-4 fs-14">Customer Reviews</span> 
                                    <a href="javascript:void(0);" class="float-end fs-11 text-muted">1 day ago</a>
                                        <p class="mb-0 text-muted fs-12">1.5k reviews</p>
                                    </li>
                                </ul>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- row close -->


                

                
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

  <script type="text/javascript">

  $( function() {
    $( "#datepicker" ).datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: ["thứ 2","thứ 3","thứ 4","thứ 5","thứ 6","thứ 7","Chủ nhật"],
        duration: "slow"
      
    });
    $( "#datepicker2" ).datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: ["thứ 2","thứ 3","thứ 4","thứ 5","thứ 6","thứ 7","Chủ nhật"],
        duration: "slow"
      
    });
    $(document).ready(function(){
    
    chart30day();

    var chart = new Morris.Bar({
        element: 'myfirstchart',
        parseTime: false,
        hideHover: 'auto',
        xkey: 'order_date',
        ykeys: ['total',],
        labels: ['doanh số']
    });

    $("#dates").click(function(){
        var _token = $('input[name="_token"]').val();
        var from_date = $('#datepicker').val();
        var to_date = $('#datepicker2').val();

        $.ajax({
            url: 'api/admin/dates',
            method: "GET",
            dataType: "JSON",
            data: { from_date: from_date, to_date: to_date, _token: _token },
            success: function(data){
                chart.setData(data);
            }
        });
    });

    $(".filter_date").change(function(){
        var _token = $('input[name="_token"]').val();
        var filter_date = $(this).val();

        $.ajax({
            url: 'api/admin/filter_date',
            method: "GET",
            dataType: "JSON",
            data: { filter_date: filter_date, _token: _token },
            success: function(data){
                chart.setData(data);
            }
        });
    });

    function chart30day(){
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: 'api/admin/chart30day',
            method: "GET",
            dataType: "JSON",
            data: { _token: _token },
            success: function(data){
                chart.setData(data);
            }
        });
    }
});

   
});
  </script>
</div>
@endsection
@section('js')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
@endsection



