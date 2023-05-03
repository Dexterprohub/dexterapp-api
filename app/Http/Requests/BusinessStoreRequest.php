<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessStoreRequest extends FormRequest
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
            'vendor_id' => 'required',
            'service_id' => 'required',
            'name' => 'required',
            'bio' => 'required',
            'cover_image' => 'required|image|max: 2999',
            // 'opened_from' => 'required',
            'address' => 'required',
            
        ];
    }
}
