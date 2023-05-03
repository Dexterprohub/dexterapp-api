<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FoodCartResource;
use Auth;
use App\Models\FoodCart;
use App\Models\Food;
use Symfony\Component\HttpFoundation\Response;

class FoodCartController extends Controller
{
    public function myCart()
    {
        $fc = Auth::user()->food_cart;
        return $fc;
        $data = new FoodCartResource(Auth::user()->food_cart);
        return response($data, Response::HTTP_ACCEPTED);
    }

    public function addToCart($id)
    {
        $food = Food::find($id);
        
        if ( $food == null ) {
            return abort( 404 );
        }
        $user = Auth::user();
        //Check whether food exists in cart. if yes increase quantity
        $entry = FoodCart::where('user_id', $user->id)->get();
        if ($entry != null) {
            $f = FoodCart::where(['user_id' => $user->id,'food_id' => $id])->first();
            if(!$f){
                FoodCart::create([
                    "food_id" => $id,
                    "quantity" => 1,
                    "price" => $this->price($food->id),
                    "user_id" => $user->id,
                    "restaurant_id" => $food->restaurant->id      
                ]);
            } else {
                $f->quantity = $f->quantity + 1;
                $f->price = $this->price($food->id) * $f->quantity;
                $f->save();
            }
        } else {
            FoodCart::create([
                "food_id" => $id,
                "quantity" => 1,
                "price" => $this->price($food->id),
                "user_id" => $user->id,
                "restaurant_id" => $food->restaurant->id
            ]);
        }
        
        $data = collect( FoodCart::where( [ 'user_id' => $user->id, 'food_id' => $id ] )->get());
        return response([
            'data' => $data, 
            'status' => 200, 
            'message' => 'Food Item Added to cart successfully'], Response::HTTP_ACCEPTED
        );
    }

    public function decreaseAQuantity($id)
    {
        $food = Food::find($id);
        if ( $food == null ) {
            return abort( 404 );
        }
        $user = Auth::user();
        //CHeck whether food item exist in cart. if yes increase quantity
        $entry = FoodCart::where('user_id', $user->id)->get();
        if ($entry != null) {
            $f = FoodCart::where(['user_id' => $user->id, 'food_id' => $id])->first();
            if ($f) {
                if($f->quantity > 1){
                    $f->quantity = $f->quantity - 1;
                    $f->price = $food->price * $f->quantity;
                    $f->save();
                    return response()->json(['success' => true, 'message' => 'food item quantity decreased from the cart', 'item reduced' => $f], Response::HTTP_ACCEPTED);
                } else {
                    $f->delete();
                    return response()->json(['status' => 404, 'message' => 'No food item in the cart'], 404);
                }
            }else{
                return response()->json(['status' => 404, 'message' => 'User has no food in the cart'], 404);
            }
        } else {
            return response()->json(['status' => 404, 'message' => 'User has no cart'], 404);
        }
    }

    public function deleteAnItem($id)
    {  
        $food = Food::find($id);
        if ( $food == null ) {
            return abort( 404 );
        }

        $user = Auth::user();
        //CHeck whether product exist if yes increase quantity
        $entry = FoodCart::where('user_id', $user->id)->get();
        if ($entry != null) {
            $f = FoodCart::where(['user_id' => $user->id, 'food_id' => $id])->first();
            $data = collect( FoodCart::where( [ 'user_id' => $user->id, 'food_id' => $id ] )->get());
            
            if ($f){
                $f->delete();
                return response(['success' => true, 'message' => 'Food Item deleted from the cart successfully', 'item_deleted' => $data], Response::HTTP_ACCEPTED);
            } else{
                return response(['success' => true, 'message' => 'User has no food in the cart', 'data' => $data, ], 404);
            }
        } else {
            return response(['success' => true, 'message' => 'User has no cart', 'data' => $entry], 404);
        }
    }
}
