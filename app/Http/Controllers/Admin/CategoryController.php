<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller{
//-------------------------------------------------------------------------------------------------------- 
    public function index()
    {
        $title = 'Danh mục sản phẩm';
        $data = Category::all();
        return view('admin.category.index', compact('data','title'));
    }
//-------------------------------------------------------------------------------------------------------- 
    public function view_add(){
        return view('admin.category.add');
    }

    public function add(Request $request){
        // Kiểm tra dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:catergory,name',
        ]);

        // Nếu dữ liệu không hợp lệ
        if ($validator->fails()) {
            // Trả về thông báo lỗi
            return redirect()->route('admin.addCategory')->with('error', 'Tên danh mục bị trùng lặp.');
        }

        // Tạo mới danh mục
        Category::create([
            'name' => $request->name,
        ]);

        // Chuyển hướng với thông báo thành công
        return redirect()->route('admin.category')->with('success', 'Danh mục đã được thêm thành công.');
    }

//-------------------------------------------------------------------------------------------------------- 
    public function view_edit($id){
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function edit(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:catergory,name,' .$id,
        ]);
        // $request->validate([
        //     'id' => 'required|numeric|unique:catergory,id,' .$id,
        //     'name' => 'required|unique:catergory,name,' .$id,
        // ]);
        if($validator->fails()){
            return redirect()->route('admin.editCategory', ['id' => $id])->with('error', 'ID hoặc tên danh mục bị trùng lặp');
        }

        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
        ]);
    
        return redirect()->route('admin.category', ['id' => $id])->with('success', 'Danh mục đã được sửa thành công.');
}
//-------------------------------------------------------------------------------------------------------- 
    public function delete($id){
        $delete = Category::find($id);
        $delete->delete();
        return redirect()->route('admin.category')->with('success_delete', 'Danh mục đã được xóa thành công!');
    }

}
