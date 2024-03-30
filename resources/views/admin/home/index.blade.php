@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            
            <p class="mb-0 text-muted">Thống kê website!</p>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- row -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
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
                            <span class="text-fixed-white">Sản phẩm</span>
                            <h3 class="text-fixed-white mb-0">{{ countTable('product') }}</h3>
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
    </div>
    <!-- row closed -->






</div>
@endsection
