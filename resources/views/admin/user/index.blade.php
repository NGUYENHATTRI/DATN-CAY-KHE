@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
@endsection
@section('content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Danh sách khách hàng</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Khách hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách khách hàng</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header">
                    <div class="card-title">
                        Danh sách khách hàng
                    </div>
                    <div class="card-title">
                    <a href="{{route('admin.addUser')}}" class="btn btn-primary mb-2 data-table-btn">Thêm khách hàng</a>
                    </div>
                </div>

                <div class="card-body">

<table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Hình ảnh</th>
            <th>Địa chỉ</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->userID }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
                <td> <img src="{{ getImage($row->image_url) }}" style="max-width:100px"></td>
                <td>{{ $row->address }}</td>

                <td>
                    <div>
                        <a href="{{ route('admin.editUser') }}/{{ $row->userID }}">
                            <i class="fa fa-edit me-2 font-success"></i>
                        </a>
                        <a href="{{ route('admin.deleteUser') }}/{{ $row->userID }}">
                            <i class="fa fa-trash font-danger"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('success_delete'))
<div class="alert alert-success">{{ session('success_delete') }}</div>
@endif
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
