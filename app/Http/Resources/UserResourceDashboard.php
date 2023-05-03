<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Address;
class UserResourceDashboard extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $address = Address::where('user_id', $this->id)->first();
        return [
            // 'id' => $this->id,
            // 'name' => $this->first_name .  ' ' . $this->last_name,
            // 'email' => $this->email,
            // 'phone' => $this->phone,
            // 'address' => $this->address,
            // 'category' => $this->service
            // 'date_joined' => $this->created_at,
            // 'service_requested' => [],
        ];
    }
}
