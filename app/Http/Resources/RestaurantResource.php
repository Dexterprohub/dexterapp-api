<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class RestaurantResource extends JsonResource
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
            'vendor_type' => $this->service->name,
            'vendor_id' => $this->service->id,
            // 'user_id' => $this->user_id,
            // 'user_name' => $this->user->first_name.' '.$this->user->last_name,
            'restaurant_name' => $this->name,
            'description' => $this->description,
            // 'delivery_hours' => Carbon::parse($this->opened_from)->format('H:i') .' To '.Carbon::parse($this->opened_to)->format('H:i'),
            'minimum_order' => $this->min_order,
            // 'cover_image' => $this->cover_image,
            'image' => $this->image,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            // 'latitude' => $this->latitude,
            // 'longitude' => $this->longitude,
            'vat' => $this->vat,
            'delivery_fee' => $this->delivery_fee,
            'discount' => $this->discount,
            'additional_charges' => $this->additional_charge,
            // 'review' => $this->review
        ];
    }
}
