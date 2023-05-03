<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingsStoreRequest extends FormRequest
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
            'service_id' => 'required|integer',
            'shop_id'=>'required|string',
            'address'=>'required|string',
            'time' => 'required|date',
            'address'=>'required|string',
            'total_cost'=>'required|string',
            'status'=>'required|string',
            'scheduledate'=>'required|date',
        ];
    }
}
