<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodCartResource extends JsonResource
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
            'user_name' => $this->user->first_name.' '.$this->user->last_name,
            'restaurant_id' => $this->food->restaurant->id,
            'restaurant_name' => $this->food->restaurant->name,
            'food_id' => $this->food_id,
            'food_name' => $this->food->name,
            'food_price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->quantity * $this->food->price
        ];
    }
}
