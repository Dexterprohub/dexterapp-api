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
            return response()->json(['success' => true, 'message' => 'Address not found', 'address' => []],404);
        }

        return response([
            'success' => true,
            'data' => AddressResource::collection($address)], Response::HTTP_ACCEPTED);
    }

    public function store(Request $request){

        $user = Auth::guard('api')->user();

        $validatedData = $request->validate([
            'address' => 'required',
        ]);

        $address = new Address();
        $address->user_id = $user->id;
        $address->address = $validatedData['address'];
        $address->save();

        // $data = new AddressResource($address);
        
        return response()->json(
            [
                'success' => true, 
                'message' => 'user address stored successfully', 
                'data' => [new AddressResource($address)],
            ], Response::HTTP_CREATED
        );
    }

    public function addressByUser($id){

        $address = Address::where('user_id', $id)->get();

        return response()->json(
            [
                'success' => true, 
                'message' => 'user addresses',
                'data' => AddressResource::collection($address),
            ], Response::HTTP_ACCEPTED
        );
    }

    public function removeAddress($id){

        $address = Address::where('user_id', Auth::id())->where('id', $id)->first();

        if(!$address){
            abort(404);
        }

        $address->delete();

        return response()->json(
            [
                'success' => true,
                'message' => 'Address deleted successfully',
                'data' => []
            ], Response::HTTP_ACCEPTED
        );

    }

}
