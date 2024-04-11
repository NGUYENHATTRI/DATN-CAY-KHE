<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $title = 'Danh mục nhân viên';
        $data = User::where('role' , '!=', 0)->where('email', '!=', \Auth::user()->email)->get();
        return view('admin.employee.index', compact('data','title'));
    }

    public function create()
    {
        $title = 'Thêm nhân viên mới';
        return view('admin.employee.create', compact('title'));
    }

    public function create_(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $request->userID . ',userID',
            'password' => 'required|string',
            'role' => 'required|string|max:10',
        ], [
            'name.required' => 'Tên không được bỏ trống',
            'name.max' => 'Tên không được vượt quá 100 ký tự',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Vui lòng nhập email đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'role.required' => 'Vui lòng chọn vai trò',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'image_url' => 'images/user/default-avatar.jpg',
            'address' => '',
            'google_id' => '',
        ]);
        notify()->success('Tạo nhân viên thành công', 'Tạo thành công');
        return redirect()->route('admin.staff');
    }

    public function edit($userID)
    {
        $title = 'Chỉnh sửa thông tin nhân viên';
        $staff = User::find($userID);
        return view('admin.employee.edit', compact('staff','title'));
    }

    public function edit_(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $request->userID . ',userID',
            'role' => 'required|string|max:10',
        ], [
            'name.required' => 'Tên không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Vui lòng nhập email đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'role.required' => 'Vui lòng chọn vai trò',
        ]);

        User::where('userID', $request->userID)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        notify()->success('Cập nhật nhân viên thành công', 'Cập nhật thành công');
        return redirect()->route('admin.editStaff', ['id' => $request->userID]);
    }

    public function delete($userID)
    {
        User::destroy($userID);
        return redirect()->back();
    }

    public function showTrash()
    {
        $title = 'Thùng rác nhân viên';
        $data = User::onlyTrashed()->get();
        return view('admin.employee.trash', compact('data','title'));
    }

    public function restore($userID)
    {
        User::withTrashed()->find($userID)->restore();
        notify()->success('Khôi phục nhân viên thành công', 'Khôi phục thành công');
        return redirect()->back();
    }

    public function forceDelete($userID)
    {
        User::withTrashed()->find($userID)->forceDelete();
        return redirect()->back();
    }
}
