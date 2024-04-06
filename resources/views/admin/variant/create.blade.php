@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
@endsection
@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">{{ $title }}</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Biến thể</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm Biến thể</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header">
                    <div class="card-title">
                        Biến thể
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.postAddVariant') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Màu sắc</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" id="exampleInputPassword1"  name="color">
                            @error('color')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kích thước</label>
                            <select class="form-select" name="size_id" id="">
                                @foreach($sizes as $size)
                                    <option value="{{ $size->sizeID }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sản phẩm</label>
                            <select class="form-select" name="pro_id" id="">
                                @foreach($products as $product)
                                    <option value="{{ $product->productID }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chất liệu</label>
                            <select class="form-select" name="material" id="">
                                @foreach($materials as $material)
                                    <option value="{{ $material->materialID }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleInputPassword1">Số lượng tồn kho</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="exampleInputPassword1"  name="stock">
                            @error('stock')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Giá</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="exampleInputPassword1"  name="price">
                            @error('price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Internal Datatables JS -->
    <script src="{{ asset('assets/admin/js/datatables.js') }}"></script>
@endsection
