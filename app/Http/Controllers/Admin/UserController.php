<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller{
    //-------------------------------------------------------------------------------------------------------- 
    public function index()
    {
        $title = 'Danh sách khách hàng';
        $data = User::where('role' , '==', 0)->get();
        return view('admin.user.index', compact('data','title'));
    }
    //-------------------------------------------------------------------------------------------------------- 

    public function view_add()
    {
        $title = 'Thêm khách hàng mới';
        return view('admin.user.add', compact('title'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $request->userID . ',userID',
            'password' => 'required|string',
            'image_url' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            // 'google_id' => 'required|numeric',
        ], [
            'name.required' => 'Tên không được bỏ trống',
            'name.max' => 'Tên không được vượt quá 100 ký tự',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Vui lòng nhập email đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'image_url.required' => 'Yêu cầu thêm file hình ảnh',
            'address.required' => 'Địa chỉ không được để trống',
            'address.max' => 'Địa chỉ không vượt quá 100 ký tự',
            // 'google_id.required' => 'Google_id không được để trống', 
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image_url' => $request->image_url,
            'address' => $request->address,
            // 'google_id' => $request->google_id,
        ]);
        notify()->success('Tạo khách hàng thành công', 'Tạo thành công');
        return redirect()->route('admin.user');
    }

//-------------------------------------------------------------------------------------------------------- 

    public function view_edit($userID)
    {
        $title = 'Chỉnh sửa thông tin khách hàng';
        $user = User::find($userID);
        return view('admin.user.edit', compact('user','title'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $request->userID . ',userID',
            'password' => 'required|string',
            'image_url' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            // 'google_id' => 'required|numeric',
        ], [
            'name.required' => 'Tên không được bỏ trống',
            'name.max' => 'Tên không được vượt quá 100 ký tự',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Vui lòng nhập email đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'image_url.required' => 'Yêu cầu thêm file hình ảnh',
            'address.required' => 'Địa chỉ không được để trống',
            'address.max' => 'Địa chỉ không vượt quá 100 ký tự',
            // 'google_id.required' => 'Google_id không được để trống', 
        ]);

        User::where('userID', $request->userID)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'image_url' => $request->image_url,
            'address' => $request->address,
            // 'google_id' => $request->google_id,
        ]);
        notify()->success('Cập nhật khách hàng thành công', 'Cập nhật thành công');
        return redirect()->route('admin.user');
}
//-------------------------------------------------------------------------------------------------------- 
    public function delete($id){
        User::destroy($id);
        return redirect()->back();
    }     
//-------------------------------------------------------------------------------------------------------- 
    public function showTrash()
    {
        $title = 'Thùng rác khách hàng';
        $data = User::onlyTrashed()->where('role' , '==', 0)->get();
        return view('admin.user.trash', compact('data','title'));
    }
//-------------------------------------------------------------------------------------------------------- 
    public function restore($userID)
    {
        User::withTrashed()->find($userID)->restore();
        notify()->success('Khôi phục khách hàng thành công', 'Khôi phục thành công');
        return redirect()->back();
    }
//-------------------------------------------------------------------------------------------------------- 
    public function forceDelete($userID)
    {
        User::withTrashed()->find($userID)->forceDelete();
        return redirect()->back();
    }
}
