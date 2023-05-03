<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingsUpdateRequest extends FormRequest
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
            'user_id' => 'required|integer',
        'service_id' => 'required|integer',
        'location'=>'required|string',
        'vendor_id'=>'required|string',
        'time' => 'required|date',
        'address'=>'required|string',
        'total_cost'=>'required|string',
        'status'=>'required|string',
        'scheduledate'=>'required|date',
        'completedate'=>'required|date',
        ];
    }
}
