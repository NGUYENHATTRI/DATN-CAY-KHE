<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariationInfoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Variant_images;
use App\Models\Category;
use App\Models\MaterialModel;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // //MaterialModel
    // function shop(){
    //     $perpage= 9;
    //     $products = Product::paginate($perpage);
    //     // thêm ảnh và giá cho sản phẩm vì giá và ảnh ở table khác
    //     foreach($products as $product){
    //         $variant = Variant::where('product_id', $product->productID)->first();
    //         $product->image_url = Variant_images::where('variant_id' , $variant->variantID)->value('image_url');
    //         $product->price = $variant->price;
    //     };
    //     $categories = Category::get();
    //     return view ('client.shop' , ['products'=> $products , 'categories' => $categories]);
    // }

    public function show($slug)
    {
        // try {
            $product  = Product::query()->slug($slug)->first();
            if (empty($product)) {
                return abort(404);
            }

            $productVariant  = $product->variations()->pluck('product_id');
            $variants = Variant::where('product_id', $product->productID)->get();

            
            $materials = \DB::table('material')
                    ->join('variant', 'material.materialID', '=', 'variant.material_id')
                    ->where('variant.product_id', $product->productID)
                    ->select('material.materialID', 'material.name')
                    ->distinct()
                    ->get();

            $sizes = \DB::table('size')
                    ->join('variant', 'size.sizeID', '=', 'variant.size_id')
                    ->where('variant.product_id', $product->productID)
                    ->select('size.sizeID', 'size.name')
                    ->distinct()
                    ->get();

            // $materials = \DB::table('j')
            // $productIdsWithTheseVariant = Variant::whereIn('product_id', $productVariant->product_id)
            // ->where('product_id', '!=', $product->productID)->pluck('product_id');

            // $relatedProducts = Product::whereIn('id', $productIdsWithTheseVariant)->get();
            return view('client.products.show', ['product' => $product, 'variants' => $variants, 'materials' => $materials, 'sizes' => $sizes]);
        // } catch (\Throwable $e) {
        //     dd($e);
        //     abort(404);
        // }
    }
    public function getVariationInfo(Request $request)
    {
        $variationKey = "";
        foreach ($request->variation_id as $variationId) {
            $fieldName      = 'variation_value_for_variation_' . $variationId;
            $variationKey  .=  $variationId . ':' . $request[$fieldName] . '/';
            $id = $request[$fieldName];
        }
        $productVariation = Variant::where('variantID', $id)
        ->where('product_id', $request->product_id)->first();
        return new ProductVariationInfoResource($productVariation);
    }

    function getVariant($variantID)
    {
        $variant = Variant::where('variantID', $variantID)->first();
        $variantImages = Variant_images::where('variant_id', $variantID)->get();

        $data = [
            'variant' => $variant,
            'variantImages' => $variantImages
        ];
        return response()->json($data);
    }

    function addCart(Request $request, $productID = 0, $soluong = 1, $variantID)
    {
        $product = Product::where('productID', $productID)->first();
        $variant = Variant::where('product_id', $product->productID)->first();
        $product->image_url = Variant_images::where('variant_id', $variant->variantID)->value('image_url');
        $product->price = $variant->price;
        $product->quantity = $soluong;

        if (!$request->session()->exists('cart')) { //chưa có cart trong session
            $request->session()->put('cart', [[$productID, $variantID, $product->image_url, $product->price, $product->quantity]]);
        } else { // đã có cart, kiểm tra id_sp có trong cart không
            $cart = $request->session()->get('cart');
            $index_productID = array_search($productID, array_column($cart, 0));
            $index_variantID = array_search($variantID, array_column($cart, 1));
            if ($index_productID !== false && $index_variantID !== false) { //id_sp và variantID đều có trong giỏ hàng thì tăng số lượng
                $cart[$index_variantID][4] += $soluong; // Cộng vào số lượng của biến thể cụ thể
                $request->session()->put('cart', $cart); // Cập nhật giỏ hàng sau khi thay đổi số lượng
            } else { //sp chưa có trong arrary cart thì thêm vào
                $request->session()->push('cart', [$productID, $variantID, $product->image_url, $product->price, $product->quantity]);
            }
        }
        return redirect('/cart');
    }

    function xoagiohang(Request $request)
    {
        $request->session()->forget('cart');
        return redirect('/');
    }

    function cart(Request $request)
    {
        return view('client.cart');
    }

    function deteleCart(Request $request, $variantID = 0)
    {
        $cart =  $request->session()->get('cart');
        $index = array_search($variantID, array_column($cart, 1));
        if ($index != '') {
            array_splice($cart, $index, 1);
            $request->session()->put('cart', $cart);
        }
        return redirect('/cart');
    }

    function getProductInCategory($categoryID)
    {
        $products = DB::table('product')
            ->join('catergory', 'product.category_id', '=', 'catergory.catergoryID')
            ->where('catergory.catergoryID', $categoryID)
            ->select('product.*')
            ->get();

        foreach ($products as $product) {
            $variant = Variant::where('product_id', $product->productID)->first();
            $product->image_url = Variant_images::where('variant_id', $variant->variantID)->value('image_url');
            $product->price = $variant->price;
        };

        return response()->json($products);
    }

    public function getProductByName($productName)
    {
        $products = DB::table('product')
            ->where('name', 'like', '%' . $productName . '%')
            ->select('product.*')
            ->get();

        foreach ($products as $product) {
            $variant = Variant::where('product_id', $product->productID)->first();
            $product->image_url = Variant_images::where('variant_id', $variant->variantID)->value('image_url');
            $product->price = $variant->price;
        };
        return response()->json($products);
    }
}
