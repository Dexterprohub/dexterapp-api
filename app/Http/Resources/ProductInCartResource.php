<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductInCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $cart = auth()->user()->cart();
        // return $cart;
        // $user = \Auth::user()->cart()->get();
        // $product = Product::where();
        // return $user;
        return [
            // 'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'product_id' => $this->product_id,
            // 'shop_name' => $this->products->shop->first()->name,
            // 'quantity' => $this->quantity,
            // 'product_price' => $this->products->first()->price,
            // 'sub_total' => $this->products->first()->price * $this->quantity,

        ];
    }
}
