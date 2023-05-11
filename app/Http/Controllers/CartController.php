<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductInCartCollectionResource;
use App\Http\Resources\ProductInCartResource;
use App\Http\Resources\CartProductResource;
use App\Models\Product;
use App\Models\CartProduct;

use Symfony\Component\HttpFoundation\Response;


class CartController extends Controller
{
    public function myCart(){
        
        $user = Auth::guard('api')->user(); 
        $cart = $user->cart; 
        
        if(!$cart || is_null($cart) ){
            return response()->json([
                'success' => true,
                'message' => 'user has no cart!',
                'data' => [],
            ], Response::HTTP_ACCEPTED);
        }
        
        $cartWithItems = $cart->cartProducts;
        
        return response()->json([
            'success' => true,
            'message' => 'Cart',
            'data' => $cartWithItems,
        ], Response::HTTP_ACCEPTED);
    }

    public function addToCart($id){  
        $product = Product::find($id);  
        
        if ( $product == null ) {
            return abort( 404 );
        }   
        
        $user = Auth::guard('api')->user();
        $cart = $user->cart;

        if($cart != null) {
            
            //Check whether item exists in cart
            $cartProduct = $cart->cartProducts->where('product_id', $product->id)->first();

            //if no, create a new one
            if(!$cartProduct){ 

                $cartProduct = new CartProduct();
                $cartProduct->cart_id = $cart->id;
                $cartProduct->product_id = $id;
                $cartProduct->quantity = 1;
                $cartProduct->price = $product->price;
                $cartProduct->save();
               
                return response()->json(['success' => true, 'message' => 'item added to cart successfully', 'data' => new CartProductResource($cartProduct)], Response::HTTP_ACCEPTED);
           
            }
               
            //if yes, increase quantity
            $cartProduct->quantity = $cartProduct->quantity + 1;
            $cartProduct->price = $product->price * $cartProduct->quantity;
            $cartProduct->save();  

            return response()->json(['success' => true, 'message' => 'quantity increased successfully', 'data' => new CartProductResource($cartProduct)], Response::HTTP_ACCEPTED);

        } 

        $newCart = Cart::create(["user_id" => $user->id]);
            
        $cartProduct = CartProduct::create(["cart_id" => $newCart->id, "product_id" => $id, "quantity" => 1, "price" => $product->price]);

        return response(['success' => true,'message' => 'item added successfully', 'data' => CartProductResource::collection($cartProduct)], Response::HTTP_ACCEPTED);
            
    }

    public function decreaseAQuantity($id){
        
        $product = Product::find($id);
       
        $user = Auth::guard('api')->user();

        //Check whether item exists, if yes reduce quantity
        $cart = $user->cart;

        if ($cart != null) {

            //Check whether item exists, if yes increase quantity
            $cartProduct = $cart->cartProducts->where('product_id', $id)->first();

            if($cartProduct) {
                
                if($cartProduct->quantity > 1){
                    $cartProduct->decrement('quantity');
                    $cartProduct->price = $product->price * $cartProduct->quantity;
                    $cartProduct->save();

                    return response()->json(['success' => true, 'message' => 'item reduced from cart successfully', 'data' => new CartProductResource($cartProduct)], Response::HTTP_ACCEPTED);
                   
                } 

                if($cartProduct->quantity === 1){
                    return response()->json(['success' => false, 'message' => 'can\'t further reduce item', 'data' => new CartProductResource($cartProduct)]);
                }

            }
            
            return response()->json(['success' => false, 'message' => 'item with id ' . $id . ' does not exist in cart'], 404);
            
        } 
        
        return response([
            'success' => false, 
            'message' => 'User has no cart', 
            'data' => [] 
        ], 404);
        
    }

    public function deleteAnItem($id){
        
        $product = Product::find($id);
   
        $user = Auth::guard('api')->user();

        $cart = $user->cart;
       
        if ($cart != null) {
            
            //Check whether product exist if yes increase quantity
            $cartProduct = $cart->cartProducts->where('product_id', $id)->first();
            
            if ($cartProduct){
                
                $cartProduct->delete();
               
                return response([
                    'success' => true,
                    'message' => 'item deleted from the cart successfully',
                ], Response::HTTP_ACCEPTED);
            } 
            
            return response([
                'success' => true,
                'message' => 'item with id ' . $id . ' does not exist in the cart',
            ], 404);

            
        } 
            
        return response([
            'success' => false, 
            'message' => 'User has no cart', 
            'data' => [] 
        ], 404);
    }
}
