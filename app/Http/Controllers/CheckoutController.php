<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Vendor;
use App\Events\OrderUpdated;
use App\Events\OrderCanceled;
use App\Http\Resources\CheckoutResource;
use Carbon;
use App\Notifications\OrderPlacedNotification;
use App\Events\OrderRequestPlaced;
use Symfony\Component\HttpFoundation\Response;
// use Unicodeveloper\Paystack\Facades\Paystack;
use Paystack;

class CheckoutController extends Controller
{
    public function index(){
        
    }
    
    public function store(Request $request){
        
        $user = Auth::guard('api')->user(); 
        $cart = $user->cart;
        $vendor  = $cart->cartProducts->first()->product->shop->vendor;

        $cartProducts = $cart->cartProducts;
       
        //total of cart items without vat, additional charge, and delivery fee
        $subtotal = 0;
        foreach ($cartProducts as $cartProduct) {

            $subtotal += $cartProduct->price;
        }
        
        //total with vat  
        $withvat = (7.5 / 100) * $subtotal;

        //delivery fee
        $shippingcost =  $cartProducts->first()->product->shop->shippingcost;
        
        if($shippingcost == 0) {
            $shippingcost = 0;
        } else {
            $shippingcost = $shippingcost;
        }
               
        //additional charge
        $additionalcharge = $cartProducts->first()->product->shop->additionalcharge;
        
        if ($additionalcharge == 0) {
            $additionalprice = 0;
        } else {
            $additionalprice = $additionalcharge;
        }   

        $discount = $cartProducts->first()->product->shop->discount;

        if ($discount == 0) {
            $withdiscount = 0;
        } else {
            $discount = $discount / 100 * $subtotal;
            $withdiscount = $discount;
        } 

        $totalBeforeDiscount = $withvat + $additionalprice + $shippingcost + $subtotal;
        
        $total = $totalBeforeDiscount - $withdiscount;
        
        $status = 1;
        $order_number = strtoupper(\Str::random(4)) . '-' . str_pad($user->id+ 1, 4 , strtoupper(\Str::random()), STR_PAD_LEFT);
        
        $validatedData = $request->validate(
            [
                'payment_method' => 'required',
            ]
        );

        $checkout = new Checkout(); 
        
        $checkout->user_id = $user->id; 
        $checkout->vendor_id = $vendor->id;
        $checkout->cart_id = $cart->id; 
        $checkout->phone = $user->phone; 
        $checkout->address = $request->address; 
        $checkout->payment_method = $validatedData['payment_method']; 
        $checkout->subtotal = $subtotal;
        $checkout->discount = $withdiscount; 
        $checkout->order_date = Carbon::now();
        $checkout->order_number = $order_number;
        $checkout->tax = $withvat;
        $checkout->shippingcost = $shippingcost; 
        $checkout->additionalcharge = $additionalcharge;
        $checkout->notes = $request->notes; 
        $checkout->review = $request->review; 
        $checkout->total = $total;
        $checkout->status = $status;
        $checkout->payment_status = 0;
        $checkout->save();
       
        // Check if user wants to pay with Paystack
        if ($request->payment_method === 'paystack') {
            
            $reference = \Str::uuid()->toString();

            $paymentData = array(

                'amount' => $checkout->total * 100, // Amount in kobo
                'email' => $user->email,
                'reference' => $reference,
                'order_id' => $checkout->id,
            );

            try{
                return Paystack::getAuthorizationUrl($paymentData)->redirectNow();
            }catch(\Exception $e) {
                return response()->json(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
            }    
          
        }
           
        //notify
        event(new OrderRequestPlaced($checkout));

        return response()->json(
            [
                'success' => true, 
                'message' => 'checkout successful', 
                'data' => new CheckoutResource($checkout) 
            ]
        );
    }

    public function updateOrder(Request $request, $checkoutId){
       
        // Retrieve the order by ID
        $checkout = checkout::find($checkoutId);

        $validatedData = $request->validate([ 'status' => 'required']);

        // Update the order status to "accepted"
        $checkout->status = $validatedData['status'];
        return $checkout->status;
        if($checkout->status){}

        $checkout->update(['status' => $validatedData['status']]);

        if ($checkout->status = 2) {
            event(new OrderUpdated($checkout));
            // event(new OrderAcceptedEmail($user));
            return response()->json(['success' => true, 'message' => 'order confirmed']);

        } elseif ($checkout->status = 3) {
            event(new OrderComplete($checkout));
            
            return response()->json(['success' => true, 'message' => 'order completed']);

        }elseif ($checkout->status = 0) {
            event(new OrderCanceled($checkout));
            // event(new OrderCanceledEmail($checkout));
            return response()->json(['success' => true, 'message' => 'order canceled']);

        }
        

        // Broadcast the updated order to all subscribed clients
        // event(new OrderUpdated($checkout));
        
        return response()->json(['message' => 'Order updated successfully', 'data' => $checkout], Response::HTTP_ACCEPTED);
    }

    public function show($id){
        
        // retrieve the current authenticated user
        $user = Auth::guard('api')->user();
        
        // cetrieve the order by its ID
        $checkout = Checkout::find($id);
        
        // check if the order belongs to the current user
        if ($checkout->user_id != $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Return the order to the view
        return response()->json(['success' => true, 'order' => $checkout]);
    }

    public function getUserPendingOrders(){

        $user = Auth::guard('api')->user();
        $pending = Checkout::where(['user_id' => $user->id, 'status' => 1])->get();

        if(($pending)->isEmpty()){
            return response()->json(['success' => false, 'message' => 'user has no pending orders'],404);
        }

        return response()->json(['success' => true, 'message' => 'user pending orders', 'data' => $pending], Response::HTTP_ACCEPTED);
    }

    public function getUserActiveOrders(){
        
        $user = Auth::guard('api')->user();

        $active = Checkout::where(['user_id' => $user->id, 'status' => 2])->get();
        
        if(($active)->isEmpty()){
            return response()->json(['success' => false, 'message' => 'user as no active order'], 404);
        }

        return response()->json(['success' => true, 'message' => 'User active orders', 'data' => $active], Response::HTTP_ACCEPTED);
    }

    public function getUserCompletedOrders(){
        $completed = Checkout::where(['user_id' => \Auth::id(), 'status' => 3])->get();
        
        if(($completed)->isEmpty()){
            return response()->json(['success' => true, 'message' => 'user as no completed order', 'data' => []]);
        }

        return response()->json(['success' => true, 'message' => 'User completed orders', 'data' => $completed], Response::HTTP_ACCEPTED);
    }
    
    public function getUserRejectedOrders()
    {
        // Retrieve the current authenticated user
        $user = Auth::guard('api')->user();
        
        // Retrieve all orders that have a status of "canceled" and belong to the current user
        $canceledOrders = Checkout::where('user_id', $user->id, 'status', 0);
        
        // Return the canceled orders
        return response()->json(['success' => true, 'orders' => $canceledOrders]);
    }

    //User cancel order
    public function cancelOrder($id)
    {
        $now = Carbon::now();
        $checkout = Checkout::where('id', $id)->get();

        $num = count($checkout);

        if ($num == 0) {
            return response([]);
        } else {
            foreach ($checkout as $checkout) {
                $checkout = $checkout->created_at;
                $cancel_time = Carbon::parse($checkout)->addMinutes(10);

                if ($now > $cancel_time) {
                    return response()->json(['success' => false, 'message' => 'You cannot cancel the checkout after 10 minutes of checkout time'], 406);
                } else {
                    $checkout->delete();
                    return response()->json(['success' => true, 'message' => 'Order has been cancelled'], 200);
                }
            }
        }
    }

    public function price($product_id)
    {
        $product = Product::where('id', $product_id)->first();
        // $additionalcharge = $product->shop->shopdetail->additionalcharge;
        
        //price without additional charge and vat
        $withoutcharges = $product->price;
        
        //price with delivery fee
        $shippingcost = $product->shop->shopdetail->first()->shippingcost;
        
        if ($shippingcost == 0) {
            $deliveryfee = 0;
        } else {
            $deliveryfee = $shippingcost + $withoutcharges;
        }
               
        //price with vat  
        $withvat = (7.5 / 100) * $withoutcharges;

        //price with additional charge
        $additionalcharge = $product->shop->shopdetail->first()->additionalcharge;
    
        if ($addtionalcharge == 0) {
            $addtionalprice = 0;
        } else {
            $addtionalprice = $addtionalcharge + $withoutcharges;
        }
        
        //Total price with addtional charge, vat and delivery fee
        $total_price = $withoutcharges + $withvat + $additionalprice;
        return $total_price;
    }

}
