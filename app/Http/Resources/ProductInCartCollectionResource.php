<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
class ProductInCartCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return $user;
        // return $products;
        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'product_id' => $this->product_id,
            // 'quantity' => $this->quantity,
            // 'product_name' => $this->products->first()->name,
            // 'shopId' => $this->products->first()->shop_id,
            // 'shop_name' => $this->products->first()->shop->first()->name,
            // 'product_price' => $this->products->first()->price,
            // 'sub_total' => $this->products->first()->price * $this->quantity,

        ];
    }
}
