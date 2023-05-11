<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
class CartProductResource extends JsonResource
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
            'cart_id' => $this->cart_id,
            'product_id' => (int)$this->product_id,
            'product_name' => $this->product->name,
            'image' => $this->product->image,
            'quantity' => $this->quantity,
            'price' => floatval($this->price),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
