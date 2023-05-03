<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'service_id' => 'required',
            'vendor_id' => 'required',
            'name' => 'required',
            'min_order' => 'required',
            'opened_from' => 'required',
            'opened_to' => 'required',
            'cover_image' => 'required',
            'address' => 'required',
            'delivery_fee' => 'required',
            'email' => 'required | email',
            'phone' => 'required',
            'description' => 'required',
        ];
    }
}
