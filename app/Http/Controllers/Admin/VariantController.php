<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Variant;
use App\Models\MaterialModel;
use App\Models\Variant_images;
use App\Models\SizeModel;
use App\Models\Product;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index(){
        $title ='Biến thể';
        $data = Variant::all();
        return view("admin.variant.index",compact("title","data"));
    }

    public function create()
    {
        $title = 'Thêm biến thể';
        $products=Product::all();
        $sizes = SizeModel::all();
        $materials = MaterialModel::all();
        return view('admin.variant.create', compact('products', 'materials','sizes','title'));
    }
    public function create_(Request $request)
    {
        $request->validate([
            'color' => 'required|string|max:100',
            'stock' => 'required|string',
            'price' => 'required|string|max:10',
        ], [
            'color.required' => 'Màu sắc không được bỏ trống',
            'color.max' => 'Màu sắc không được vượt quá 100 ký tự',
            'stock.required' => 'Số lượng tồn kho không được bỏ trống',
            'price.required' => 'Giá thành không được bỏ trống',
        ]);
        Variant::create([
            'color'=> $request->color,
            'size_id'=> $request->size_id,
            'material_id'=> $request->material,
            'stock_quantity'=> $request->stock,
            'product_id'=> $request->pro_id,
            'price'=> $request->price,
        ]);
        notify()->success('Tạo biến thể thành công', 'Tạo thành công');
        return redirect()->route('admin.variant');
    }
    public function edit($variantID)
    {
        $title = 'Chỉnh sửa biến thể';
        $products=Product::all();
        $sizes = SizeModel::all();
        $materials = MaterialModel::all();
        $variant = Variant::find($variantID);
        return view('admin.variant.edit', compact('variant','products','materials','sizes','title'));
    }
    public function edit_(Request $request)
    {
        $request->validate([
            'color' => 'required|string|max:100',
            'stock' => 'required|string',
            'price' => 'required|string|max:10',
        ], [
            'color.required' => 'Màu sắc không được bỏ trống',
            'color.max' => 'Màu sắc không được vượt quá 100 ký tự',
            'stock.required' => 'Số lượng tồn kho không được bỏ trống',
            'price.required' => 'Giá thành không được bỏ trống',
        ]);
        Variant::where('variantID', $request->variantID)->update([
            'color'=> $request->color,
            'size_id'=> $request->size_id,
            'material_id'=> $request->material,
            'stock_quantity'=> $request->stock,
            'product_id'=> $request->pro_id,
            'price'=> $request->price,
        ]);
        return redirect()->route('admin.editVariant', ['id' => $request->variantID]);
    }

    public function delete($variantID)
    {
        Variant::destroy($variantID);
        notify()->success('Sửa biến thể thành công', 'Xóa thành công');
        return redirect()->back();
    }
//HINH ANH BIẾN THỂ
    public function createimg($variantID)
    {
        $title = 'Thêm hình biến thể';
        $proid= DB::table('product')->join('variant','productID', '=','variant.product_id')
        ->select('name')->where('variantID', '=', $variantID)->get();
        $imgvariants=  DB::table('varient_images')
                    ->select('*')
                    ->where('variant_id', '=', $variantID)
                    ->get();
        return view('admin.variant.createimg', compact('imgvariants','proid'));
    }

    public function createimg_(Request $request)
    {
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = rand(0,99) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product'), $imageName);
            return redirect()->route('admin.variant'); 
        }
        Variant_images::create([
            'image_url'=> $request->image,
            'variant_id'=>$request->variantID,
        ]);
        notify()->success('Thêm ảnh thành công', 'Thêm thành công');
        return redirect()->route('admin.variant');
    }
    public function editimg($variantID)
    {
        $titleimg = 'Chỉnh sửa hình biến thể';
        $proid= DB::table('product')->join('variant','productID', '=','variant.product_id')
        ->select('name')->where('variantID', '=', $variantID)->get();
        $imgvariants=  DB::table('varient_images')
                    ->select('*')
                    ->where('variant_id', '=', $variantID)
                    ->get();
        return view('admin.variant.editimg', compact('imgvariants','proid'));
    }
    public function editimg_(Request $request)
    {
        
        Variant_images::where('imageID', $request->imageID)->update([
            'image_url'=> $request->image,
        ]);
        notify()->success('Sửa ảnh thành công', 'Sửa thành công');
        return redirect()->route('admin.variant', ['id' => $request->variantID]);
    }
    public function deleteimg($variantID)
    {

        Variant_images::where('variant_id',$variantID)->delete();
        notify()->success('Xóa ảnh thành công', 'Xóa thành công');

        return redirect()->back();
    }
}
