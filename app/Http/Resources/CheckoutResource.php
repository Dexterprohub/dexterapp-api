<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'vendor_id' => $this->vendor_id,
            'cart_id' => $this->cart_id,
            'cart_items' => $this->cart->cartProducts,
            'phone' => $this->phone,
            'address' => $this->address,
            'payment_method' => $this->payment_method,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'order_number' => $this->order_number,
            'order_date' => $this->order_date,
            'shippingcost' => $this->shippingcost,
            'additionalcharge' => $this->additionalcharge,
            'notes' => $this->notes,
            'review' => $this->review,
            'total' => $this->total,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
        ];
    }
}
