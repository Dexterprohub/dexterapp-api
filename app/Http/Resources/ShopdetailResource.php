<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopdetailResource extends JsonResource
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
            'shop_id' => $this->shop_id,
            'shop_name' => $this->shop->name,
            'shop_bio' => $this->shop->bio,
            'discount' => $this->discount,
            'opened_from' => $this->opened_from,
            'opened_to' => $this->opened_to,
            'address' => $this->address,
            'additionalcharge' => $this->additionalcharge,
            'shippingcost' => $this->shippingcost,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ];
    }
}
