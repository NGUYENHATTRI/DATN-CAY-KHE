@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
@endsection
@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Danh sách biến thể</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Biến thể</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách biến thể</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header">
                    <div class="card-title">
                        Danh sách biến thể
                    </div>
                </div>

                <div class="card-body">

                    <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                        <a href="{{ route('admin.addVariant') }}" class="btn btn-primary mb-2 data-table-btn">Thêm biến thể</a>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Màu sắc</th>
                                <th>Kích thước</th>
                                <th>Chất liệu </th>
                                <th>Số lượng</th>
                                <th>Sản phẩm </th>
                                <th>Giá </th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $row)
                                <tr>
                                    <td style="width:20px">
                                        {{ $row->variantID }}
                                    </td>
                                    <td>{{ $row->color }}</td>
                                    <td>{!! Helper::getNameById($row->size_id,'size') !!}</td>
                                    <td>{!! Helper::getNameById($row->material_id,'material') !!}</td>
                                    <td>{{ $row->stock_quantity }}</td>
                                    <td>{!! Str::limit(Helper::getNameById($row->product_id,'product'), $limit = 30, $end = '...') !!}
                                    <td>{{ Helper::format_cash($row->price) }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('admin.editVariant') }}/{{ $row->variantID }}">
                                                <i class="fa fa-edit me-2 font-success"></i>
                                            </a>
                                            <a href="{{ route('admin.deleteVariant') }}/{{ $row->variantID }}">
                                                <i class="fa fa-trash font-danger"></i>
                                            </a>
                                            <a href="{{ route('admin.addimgVariant') }}/{{ $row->variantID }}">
                                            <i class="fa-solid fa-image"></i>
                                            </a>
                                            <a href="{{ route('admin.editimgVariant') }}/{{ $row->variantID }}">
                                            <i class="fa-solid fa-image"></i>
                                            </a>
                                            <a href="{{ route('admin.deleteimgVariant') }}/{{ $row->variantID }}">
                                            <i class="fa-regular fa-images"></i>
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
