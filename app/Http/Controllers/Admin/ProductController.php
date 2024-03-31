<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function index()
    {
        $title = 'Sản phẩm';
        $data = Product::orderBy('productID', 'DESC')->get();
        return view('admin.product.index', compact('data','title'));
    }

    public function create()
    {
        $title = 'Thêm sản phẩm';
        $categorys = Category::all();
        return view('admin.product.create', compact('categorys','title'));
    }

    public function create_(Request $request)
{   
    $request->validate([
        'name' => 'required|string|max:100',
        'categoryID' => 'required|exists:catergory,catergoryID',
        'description' => 'required|string|max:255',
        'thumnail' => 'required|image',
    ], [
        'name.required' => 'Tên không được để trống',
        'name.max' => 'Tên không được vượt quá 100 ký tự',
        'categoryID.required' => 'Vui lòng chọn danh mục',
        'categoryID.exists' => 'Danh mục không tồn tại',
        'description.required' => 'Mô tả không được để trống',
        'description.max' => 'Nội dung mô tả không được vượt quá 255 ký tự',
        'thumnail.required' => 'Hình không được để trống',
        'thumnail.image' => 'Hình ảnh không hợp lệ',
    ]);
    
    $data = [
        'name' => $request->name,
        'category_id' => $request->categoryID,
        'description' => $request->description,
        'thumnail' => '',
    ];

    // Kiểm tra xem có file ảnh được tải lên hay không
    if ($request->hasFile('thumnail')) {
        $image = $request->file('thumnail');
        $imageName = rand(0,99) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/product'), $imageName);
        $data['thumnail'] = $imageName;
    }

    Product::create($data);
    notify()->success('Thêm sản phẩm thành công', 'Thêm sản phẩm thành công');
    return redirect()->route('admin.product');
}

    
    public function edit($productID)
    {
        $title = 'Chỉnh sửa sản phẩm';
        $product = Product::find($productID);
        $categorys = Category::all();

        $categoryID = $product->category_id;
        $category_id = $categorys->firstWhere('catergoryID', $categoryID);
        return view('admin.product.edit', compact('product','category_id','categorys','title'));
    }

    public function edit_(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'categoryID' => 'required|exists:catergory,catergoryID',
            'description' => 'required|string|max:255',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được vượt quá 100 ký tự',
            'categoryID.exists' => 'Danh mục không tồn tại',
            'description.required' => 'Mô tả không được để trống',
            'description.max' => 'Nội dung mô tả không được vượt quá 255 ký tự',
        ]);

    $product = Product::find($request->productID);
    $data = [
        'name' => $request->name,
        'category_id' => $request->categoryID,
        'description' => $request->description,
    ];

    if ($request->hasFile('thumnail')) {
        $image = $request->file('thumnail');
        $imageName = rand(0,99) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/product'), $imageName);
        $data['thumnail'] = $imageName;
    }
    $product->update($data);
    notify()->success('Cập nhật sản phẩm thành công', 'Cập nhật thành công');
    return redirect()->route('admin.editProduct', ['id' => $request->productID]);
    }


    public function delete($productID)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::where('productID', $productID)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->back();
    }

    public function showTrash()
    {
        $title = 'Thùng rác sản phẩm';
        $data = Product::onlyTrashed()->get();
        return view('admin.product.trash', compact('data','title'));
    }

    public function restore($productID)
    {
        Product::withTrashed()->find($productID)->restore();
        notify()->success('Khôi phục sản phẩm thành công', 'Khôi phục thành công');
        return redirect()->back();
    }

    public function forceDelete($productID)
    {
        Product::withTrashed()->find($productID)->forceDelete();
        return redirect()->back();
    }
}
