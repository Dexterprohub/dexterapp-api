<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerLoginRequest;
use App\Http\Requests\CustomerRegisterRequest;
use App\Models\Customer;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    public function login(CustomerLoginRequest $request)
    {


        if (Auth::attempt($request->only('email', 'password'))) {

            $customer = Auth::customer();

            $token = $customer->createToken('customer')->accessToken;

            return ([

                'token' => $token
            ]);
        }

        return response([
            'error' => 'invalid credentials'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function register(CustomerRegisterRequest $request)
    {

        $customer = Customer::create($request->only('first_name', 'last_name', 'email', 'phone')
            + ['password' => Hash::make($request->input('password'))]);

        return response($customer, Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->customer()->tokens()->delete();

        return response()->json([
            'message' => 'Logged Out'
        ]);
    }
}
