<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VoucherModel;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $title = 'Danh sách mã giảm giá';
        $data = VoucherModel::all();
        return view('admin.voucher.index', compact('data','title'));
    }
    public function add()
    {
        $title = 'Thêm voucher';
        return view('admin.voucher.add');
    }

}
