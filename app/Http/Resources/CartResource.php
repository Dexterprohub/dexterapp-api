<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // $shop  = $cart->cartProducts->first()->product->shop;
        $cartProducts = \Auth::user()->cart()->first()->cartProducts()->get();
        //total of cart items without vat, additional charge, and delivery fee
        $subtotal = 0;
        foreach ($cartProducts as $cartProduct) {

            $subtotal += $cartProduct->price;
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->first_name.' '. $this->user->last_name,
            'total' => $this->price,
            'cart' => $this->cartProducts
            // 'product_id' => $this->product_id,
            // 'product_name' => $this->products->first()->name,
            // 'quantity' => $this->quantity,
            // 'product_price' => $this->products->first()->price,
            // 'total_amount' => $this->price
        ];
    }
}
