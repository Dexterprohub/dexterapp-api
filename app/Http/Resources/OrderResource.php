<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderResource extends JsonResource
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
            // 'email' => $this->email,
            // 'total' => $this->total,
            // 'order_item' => OrderItemResource::collection($this->orderItems)

            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->first_name.' '.$this->user->last_name,
            'food_id' => $this->food_id,
            'foods' => $this->food->name,
            'quantity' => $this->quantity,
            'total_price' => $this->total_amount,
            'address' => $this->address,
            // 'delivery_date' => Carbon::parse($this->delivery_date)->format('d/m/Y'),
            'delivery_date' => $this->delivery_date,
            'delivery_time' =>   Carbon::parse($this->delivery_time)->format('g:i A'),
            // 'instruction' => $this->instruction,
            // 'paid' => $this->paid,
            // 'delivered' => $this->delivered
        ];
    }
}
