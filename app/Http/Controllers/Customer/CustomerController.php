<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\UpdateCustomerInfoRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController 
{
    public function index(){
        $customer = Customer::paginate(10);

        return response(CustomerResource::collection($customer), Response::HTTP_ACCEPTED);
    }

    public function store(Request $request){
        $customer = Customer::create($request->only('first_name', 'last_name', 'email', 'phone') + Hash::make('password'));

        return response($customer, Response::HTTP_CREATED);
    }

    public function show($id){
        $customer = Customer::find($id);

        return response($customer, Response::HTTP_ACCEPTED);
    }

    public function update(Request $request, $id){

        $customer = Customer::find($id);
        $customer->update($request->only('first_name' , 'last_name', 'email') + Hash::make('password'));
        return response($customer, Response::HTTP_ACCEPTED);
    }

    public function destroy($id) {
        $customer = Customer::destroy($id);
        return response(NULL, Response::HTTP_NO_CONTENT);
    }


    public function customer()
    {

        $customer = Auth::customer();

        return (new CustomerResource($customer));
    }

    public function updateInfo(UpdateCustomerInfoRequest $request)
    {

        $customer = Auth::customer();

        $customer->update($request->only('first_name', 'last_name', 'email'));

        return response(new CustomerResource($customer), Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        $customer = Auth::customer();

        $customer->update(['password' => Hash::make($request->input('password'))]);

        return response(new CustomerResource($customer), Response::HTTP_ACCEPTED);
    }
}
