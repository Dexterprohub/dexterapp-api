<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class AddressController extends Controller
{

    public function myAddress() {

        $address = Auth::user()->address;

        if(!$address){
            return response()->json(['status' => 404, 'message' => 'Address not found'],404);
        }

        return response([
            'success' => true,
            'data' => AddressResource::collection($address)], Response::HTTP_ACCEPTED);
    }

    public function addAddress(Request $request){

        $user = Auth::user();

        $address = Address::create([
            'user_id' => $user->id,
            'address' => $request->address
        ]);

        $data = new AddressResource($address);

        return response()->json([
            'message' => 'Address added successfully',
            'success' => true,
            'data' => $data,
        ], Response::HTTP_CREATED);

    }
    public function addressByUser($id){
        $address = Address::where('user_id', $id)->get();

        return response(AddressResource::collection($address), Response::HTTP_ACCEPTED);
    }



    public function removeAddress($id){

        $address = Address::where('user_id', Auth::id())->where('id', $id)->first();

        if(!$address){
            abort(404);
        }

        $address->delete();

        return response()->json(['status' => 200,'message' => 'Address deleted successfully'],200);

    }

}
