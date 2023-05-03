<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FoodResource;
class FoodCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $foods = [];
        foreach ( $this->food as $food) {

            if( $food->restaurant_id == $request['id'] ) {
                $foods[] = $food;
            }
        }

        return [
            'id' => $this->id,
            'category' => $this->name,
            'foods' => FoodResource::collection(collect($foods)),
        ];
    }
}
