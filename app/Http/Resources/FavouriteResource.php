<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
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
            'restaurant' => $this->checkres(),
            'food' => $this->checkfood()
        ];
    }

    public function checkres(){
        if($this->restaurant_id != null){
            return (
                [
                    'restaurant_id' => $this->restaurant_id,
                    'name' => $this->restaurant->restaurant_name
                ]
            );
        }
    }


    public function checkfood(){
        if($this->food_id != null){
            return (['food_id' => $this->food_id,
                'food_name' => $this->food->food_name
            ]);
        }
    }
}
