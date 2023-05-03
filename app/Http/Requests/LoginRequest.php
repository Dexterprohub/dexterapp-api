<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required | email',
            'password' => 'required | min:8' 
        ];
    }

    // protected function authenticated() {

    //     $this->ensureIsNotRateLimited();

    //     if (!Auth::attempt($this->only('email', 'password'), $this->filled('remember'))) {
    //         RateLimiter::hit($this->throttleKey());

    //         throw ValidationException::withMessages([
    //             'email' => __('auth.failed'),
    //         ]);
    //     }

    //     $user = Auth::user();

    //     event(new LoginHistory($user));
    // }
}
