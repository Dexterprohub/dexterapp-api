<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurant_id,
            'food_category_id' => $this->food_category_id,
            'food_category_name' =>  $this->food_category->name,
            'restaurant_name' => $this->restaurant->name,
            'food_name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price
        ];
    }
}
