<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShopdetailResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return
        [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'service_id' => $this->vendor->service_id,
            'name' => $this->name,
            'bio' => $this->bio,
            'image' => $this->cover_image,
            'opened_from' => $this->opened_from,
            'opened_to' => $this->opened_to,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'discount' => $this->discount,
            'shippingcost' => $this->shippingcost,
            'additionalcharge' => $this->additionalcharge,
            'min_order' => $this->min_order,
//            'jobscompleted' => $this->jobscompleted,
            // 'shop_detail' => $this->when($this->shopdetail !== NULL, $this->shopdetail),

        ];
    }
}
