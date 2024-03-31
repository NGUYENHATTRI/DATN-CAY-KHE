@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
@endsection
@section('content')
<x-notify::notify />
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Thùng rác sản phẩm</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Sản phẩm</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thùng rác sản phẩm</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header">
                    <div class="card-title">
                        Thùng rác sản phẩm
                    </div>
                </div>

                <div class="card-body">

                    <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                        <a href="{{ route('admin.product') }}">
                            <button class="btn btn-primary">trở lại</button>
                        </a>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="width:100px">Tên sản phẩm</th>
                                {{-- <th>Giá</th> --}}
                                <th>Hình ảnh</th>
                                <th>Danh mục </th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->reverse() as $row)
                                <tr>
                                    <td style="width:20px">
                                        {{ $row->productID }}
                                    </td>
                                    <td>{{ Str::limit($row->name, $limit = 30, $end = '...') }}                                    </td>
                                    {{-- <td>{{ \App\Helpers\Helper::format_cash($row->new_price) }}</td> --}}
                                    <td> <img src=" {{ asset('images/shop/' .$row->thumnail) }}" style="max-width:100px"></td>
                                    <td>{!! Helper::getNameById($row->category_id,'category') !!}</td>

                                    <td>
                                        <div>
                                            <a href="{{ route('admin.restoreProduct') }}/{{ $row->productID }}">
                                                <i class="fa fa-edit me-2 font-success"></i>
                                            </a>
                                            <a href="{{ route('admin.forceDeleteProduct') }}/{{ $row->productID }}">
                                                <i class="fa fa-trash font-danger"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
