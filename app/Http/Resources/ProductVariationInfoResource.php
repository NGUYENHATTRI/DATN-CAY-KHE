<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = Product::where('productID',$this->product_id)->first();
        return [
            'id'                        =>  (int) $this->variantID,
            'price'                     =>  getRender('client.partials.products.variation-pricing', [
                'product'               =>  $product,
                'price'                 =>  (float) variationPrice($product, $this),
                // 'discounted_price'      =>  (float) variationDiscountedPrice($this->product, $this)
            ]),
            'stock'                     =>  $this->stock_quantity ? (int) $this->stock_quantity : 0,
        ];
    }
}
