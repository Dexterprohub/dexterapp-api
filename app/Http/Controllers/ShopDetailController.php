<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ShopResource;
use App\Http\Resources\ShopdetailResource;
use App\Models\Shop;
use App\Models\Shopdetail;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Auth;

class ShopDetailController extends Controller
{
    public function show(Shop $shop){
        return response([
            'status' => 'success',
            'message' => 'Shop detail retrieved successfully',
            'data' => $shop
        ]);
    }

    public function store(Request $request){

        // Define validation rules for the input data

        $rules = [
            'shop_id' => 'required|exists:shops,id',
            'opened_from' => 'required',
            'opened_to' => 'required|max:255',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'min_order' => 'nullable',
            'shippingcost' => 'nullable',
            'additionalcharge' => 'nullable',
        ];


        // Validate the input data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->toArray()]);
        }


        $shopdetail = new Shopdetail;

        $shopdetail->opened_from = $request->opened_from;
        $shopdetail->opened_to = $request->opened_to;
        $shopdetail->address = $request->address;
        $shopdetail->email = $request->email;
        $shopdetail->phone = $request->phone;
        $shopdetail->min_order = $request->min_order;
        $shopdetail->additionalcharge = $request->additionalcharge;
        $shopdetail->shippingcost = $request->shippingcost;

        // Get the Shop from the database using their IDs
        $shop = Shop::find($request->shop_id);

        // Associate the Shop with the Service and Vendor
        $shopdetail->shop()->associate($shop);

        $shop->save();
        $shopdetail->save();


        return response([
            'success' => true,
            'message' => 'Shop information added successfully',
            'data' => new ShopdetailResource($shopdetail)
        ], Response::HTTP_ACCEPTED);


    }


    public function update(Request $request, $id){
        $edit = Shopdetail::find($id);

        if($edit){

            $edit->update($request->only('opened_from', 'opened_to', 'address'));

            return response(['success' => true, 'message' => $edit]);
        }

        return response(['success' => false, 'message' => "Shop with id {$id} does\'t exist!"], 404 );
    }
}
