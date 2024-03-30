<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Variant_images;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
<<<<<<< HEAD
use Illuminate\Support\Facades\Request as FacadesRequest;
=======

>>>>>>> 9567bff15f0db99f6408af068a59f4bdbf5001b1

class ShopController extends Controller
{
    // public function index()
    // {
    //     $perpage = 9;
    //     $products = Product::Paginate($perpage);
    //     // thêm ảnh và giá cho sản phẩm vì giá và ảnh ở table khác
    //     foreach ($products as $product) {
    //         $variant = Variant::where('product_id', $product->productID)->first();
    //         $product->image_url = Variant_images::where('variant_id', $variant->variantID)->value('image_url');

    //         $product->price = $variant->price;
    //     };
    //     $categories = Category::get();
    //     // $idsp = $shop->pluck('productID')->toArray();
    //     // $variant = Variant::whereIn('product_id',$idsp)->get();
    //     return view('client.shop', ['products' => $products, 'categories' => $categories]);
    // }
    public function index(Request $request)
    {
        $searchKey = null;
        $per_page = 9;
        $sort_by = $request->sort_by ? $request->sort_by : "new";
        $maxRange = Variant::max('price');
        $min_value = 0;
        $max_value = $maxRange;

        $products = Product::query();

        # conditional - search by
        if ($request->search != null) {
            $products = $products->where('product.name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        # pagination
        if ($request->per_page != null) {
            $per_page = $request->per_page;
        }
        # sort by
        if ($sort_by == 'new') {
            $products = $products->latest();
        } else if ($sort_by == 'desc') {
            $products = $products->join('variant as v', 'product.productID', '=', 'v.product_id')
                ->orderBy('v.price', 'desc');
        } else if ($sort_by == 'asc') {
            $products = $products->join('variant as v', 'product.productID', '=', 'v.product_id')
                ->orderBy('v.price', 'asc');
        }

        # category
        if ($request->category) {
            $category = Category::where('catergory.slug', $request->category)->first();
            if ($category) {
                $products = $products->join('catergory as c', 'product.category_id', '=', 'c.catergoryID')
                    ->where('c.catergoryID', $category->catergoryID);
            }
        }

        # by price
        if ($request->price) {
            $products = $products->join('variant as p', 'product.productID', '=', 'p.product_id')
                ->where('p.price', '<=', $request->price);
        }

        # Select the columns from the product table
        $products = $products->select('product.*');




        $products = $products->paginate($per_page);
        foreach ($products as $product) {
            $variant = Variant::where('product_id', $product->productID)->first();
            $product->image_url = Variant_images::where('variant_id', $variant->variantID)->value('image_url');
            $product->price = $variant->price;
            $product->product_variation_id = $variant->variantID;
        };
        $categories = Category::get();

        // $tags = Tag::all();
        return view('client.shop', [
            'products'      => $products,
            'searchKey'     => $searchKey,
            'per_page'      => $per_page,
            'sort_by'       => $sort_by,
            'max_range'     => $maxRange,
            'min_value'     => $min_value,
            'max_value'     => $max_value,
            'categories' => $categories,
            // 'tags'          => $tags,
        ]);
    }
    public function pro_cate(Request $request, $slug)
    {
        $perpage = 9;
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }

        $products = Product::where('category_id', $category->catergoryID)->paginate($perpage);

        foreach ($products as $product) {
            $variant = Variant::where('product_id', $product->productID)->first();
            if ($variant) {
                $product->image_url = Variant_images::where('variant_id', $variant->variantID)->value('image_url');
                $product->price = $variant->price;
            } else {
                // Nếu không tìm thấy biến thể, bạn có thể xử lý tùy ý tại đây
            }
        }
        $categories = Category::all();
        return view('client.category', ['products' => $products, 'categories' => $categories,'category'=>$category]);
    }
    public function pro_cate($idloai)
    {
        $perpage= 9;
        $products = Product::where('category_id',$idloai)->paginate($perpage);
        foreach($products as $product){ 
            $variant = Variant::where('product_id', $product->productID)->first();
            $product->image_url = Variant_images::where('variant_id' , $variant->variantID)->value('image_url');
            
            $product->price = $variant->price;
        };
        $categories = Category::get();
        return view('client.shop',['products'=>$products,'categories'=>$categories]);
    }
}
