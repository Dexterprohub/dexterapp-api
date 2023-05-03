<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShopResource;


class TopRatedShopResource extends JsonResource
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
            'id' => $this->shop->id,
            'rating' => $this->rating,
            'vendor_id' => $this->shop->vendor_id,
            'service_id' => $this->shop->service_id,
            'service_category' => $this->shop->service->name,
            'name' => $this->shop->name,
            'bio' => $this->shop->bio,
            'address' => $this->address,
            'opened_from' => $this->opened_from,
            'opened_to' => $this->opened_to,
            'discount' => $this->discount,
            'vat' => $this->vat,
            'delivery_fee' => $this->delivery_fee,
            // 'delivery_fee' => $this->when($this->delivery_fee !== NULL, $this->delivery_fee),
            'additional_charge' => $this->additional_charge,
            'jobs_completed' => $this->jobs_completed,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'image' => $this->shop->cover_image,
          
        ];
    }
}
