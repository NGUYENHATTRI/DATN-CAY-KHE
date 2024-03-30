@extends('layouts.admin')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Datepicker css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/vendors/date-picker.css') }}">

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css'>
@endsection
@section('content')
    <!-- Container-fluid starts-->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Mã giảm giá</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Mã giảm giá</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tạo mã giảm giá</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card tab2-card">
            <div class="card-body">
                <form class="needs-validation" method="POST">
                    <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active show" id="general-tab" data-bs-toggle="tab"
                                href="#general" role="tab" aria-controls="general" aria-selected="true"
                                data-original-title="" title="">Thông tin cơ bản</a></li>
                        <li class="nav-item"><a class="nav-link" id="restriction-tabs" data-bs-toggle="tab"
                                href="#restriction" role="tab" aria-controls="restriction" aria-selected="false"
                                data-original-title="" title="">Mục giới hạn</a></li>
                        <li class="nav-item"><a class="nav-link" id="usage-tab" data-bs-toggle="tab" href="#usage"
                                role="tab" aria-controls="usage" aria-selected="false" data-original-title=""
                                title="">Giới hạn</a></li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">

                            <h4>Thông tin cơ bản</h4>
                            <div class="row position-relative">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> Mã code giảm
                                            giá</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="code" type="text"
                                                value="{{ old('code') }}" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> Mô
                                            tả</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="description" value="{{ old('description') }}"
                                                type="text" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">Ngày bắt đầu</label>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control" id="input-date"
                                                value="{{ old('start_date') }}" name="start_date">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">Ngày kết thúc</label>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control" id="input-date"
                                                value="{{ old('end_date') }}" name="end_date">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4">Kiểu giảm giá</label>
                                        <div class="col-md-7">
                                            <select class="custom-select w-100 form-control" required=""
                                                name="discount_type">
                                                <option value="percentage" hidden>Phần trăm</option>
                                                <option value="percentage">Phần trăm</option>
                                                <option value="flat">Tiền</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> Số tiền /
                                            Phần trăm</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="discount" value="{{ old('discount') }}"
                                                type="number" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="restriction" role="tabpanel" aria-labelledby="restriction-tabs">

                            <h4>Mục giới hạn</h4>
                            <div class="form-group row">
                                <label for="validationCustom4" class="col-xl-3 col-md-4">Thanh toán tối thiểu</label>
                                <div class="col-md-7">
                                    <input class="form-control" id="validationCustom4" name="min_spend" type="number"
                                        value="{{ old('min_spend',1) }}">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="usage" role="tabpanel" aria-labelledby="usage-tab">

                            <h4>Mức sử dụng giới hạn</h4>
                            <div class="form-group row">
                                <label for="validationCustom7" class="col-xl-3 col-md-4">Số lần sử dụng / 1 người</label>
                                <div class="col-md-7">
                                    <input class="form-control" id="validationCustom7" type="number" value="{{ old('customer_usage_limit',1) }}"
                                        name="customer_usage_limit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        @csrf
                        <button type="submit" class="btn btn-primary">Tạo voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('js')
    <!--dropzone js-->
    <script src="{{ asset('assets/admin/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dropzone/dropzone-script.js') }}"></script>


    <!--Datepicker jquery-->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js'></script>
    <script src="{{ asset('assets/admin/js/datepicker/datepicker.en.js?v=1') }}"></script>
    <script>
        $('.datepicker-here').datepicker({
            language: 'vi',
            timepicker: true,
            timeFormat: 'hh:ii aa',
            multipleDates: false,
            multipleDatesSeparator: " / "
        });
    </script>
@endsection
