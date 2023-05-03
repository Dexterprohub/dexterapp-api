<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
// use Carbon\Carbon;
use App\Models\FoodCart;
use App\Models\User;
use App\Models\Cart;
use App\Models\Restaurant;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;
use App\Events\OrderPlaced;
use App\Notifications\OrderPlacedNotification;
use App\Listeners\SendOrderConfirmationNotification;
use Illuminate\Support\Facades\Notification;
 



class OrderController
{

    public function myOrder()
    {
        // $order = Auth::user()->order->where('delivered', 0);
        $order = Auth::user()->order;

        $data = OrderResource::collection($order);

        return response(['message' => 'successful', 'data' => $data], Response::HTTP_ACCEPTED);
        // return $this->responser($data, $data, 'Orders');

    }


    public function orderByUser($id){

        $order = Order::where('user_id', $id)->get();

        $data = OrderResource::collection($order);

        return response()->json([
            'success' => true,
            'data' => $data,
            
        ]);
        // return response($order, $data, 'Orders');

    }

    

    public function store(Request $request)
    {
        // $message = new Message();
        // $message->setNotification(new Notification('Order Confirmed', 'Your order has been confirmed!'));
        // $message->setToken($deviceToken);
        // $messaging = app(FirebaseMessaging::class);
        // $messaging->send($message);



        $user = Auth::user();
        $cart = Cart::where('user_id', \Auth::user()->id)->get();

        // $cart = $user->cart()->with('products')->get();
        $order_number = strtoupper(\Str::random(4)) . '-' . str_pad($user->id + 1, 4 , strtoupper(\Str::random()), STR_PAD_LEFT);
        
        $delivery_date = Carbon::now()->format('Y:m:d');
        
        $validator = \Validator::make($request->all(),[
                'address' => 'required', 
            ]
        );
        
        if ($validator->fails()){
            return response(['error' => $validator->errors()->first()], 401);
        }
        
        if ($cart == NULL) {
            return response(['message' => 'No Item In Cart', 'data' => $food_cart], Response::HTTP_NO_CONTENT); 
        } else {

            foreach ($cart as $c) {
                
                // $latest = Order::orderBy('created_at', 'desc')->first();
                //$order = Order
                $order = Order::create([
                    'user_id' => $c->user_id,
                    'vendor_id' => $c->vendor_id,
                    'order_number' => $order_number,
                    'order_date' => Carbon::now(),
                    'order_status' => 1,
                    'payment_status' => 0,
                    'address' => $request->address,
                    'delivery_date' => $delivery_date,
                    // 'delivery_time' => Carbon::parse($request->delivery_time)->format('H:i:s'),
                    'notes' => $request->notes,
                    'total_amount' => $c->price,
                    'feedback' => $request->feedback
                ]);
                
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $request->product_id,
                    'quantity' => $c->quantity,
                    'tax' => 7.5,
                    'additionalcharge' => $request->additionalcharge,
                    'shipping_cost' => $request->shipping_cost,
                    // 'sub_total' => ,
                    // 'total' => ,
                ]);
                // $order = Order::create([
                //     'user_id' => $c->user_id,
                //     'product_id' => $c->food_id,
                //     'order_number' => $order_number,
                //     'address' => $request->address,
                //     'quantity' => $c->quantity,
                //     'delivery_date' => $delivery_date,
                //     // 'delivery_time' => Carbon::parse($request->delivery_time)->format('H:i:s'),
                //     'delivery_time' => Carbon::now(),
                //     'instruction' => $request->instruction,
                //     'total_amount' => $c->price
                // ]);
                
                // $fc->delete();
               
                // event(new OrderPlaced($order));
                // OrderPlaced::dispatch($order);
                //OrderShipmentStatusUpdated::dispatch($order);
                
                $user->notify(new OrderPlacedNotification($order));
                //$delay = now()->addMinutes(0.15);
                //Notification::send($user, new UserNotification($order))->delay($delay);
                $detail[] = $order;

            }
            $data = OrderResource::collection(collect($detail));
            //return $order;
            
        // return $this->responser(collect($detail), $data, 'Food Ordered and');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        /// Check if order id is exists
        if (Order::find($id)) {

            /// Set new order status
            $order = Order::find($id);
            $order->update(['order_status' => $request->order_status]);

            /// Generate success response
            return response()->json(['success' => true, 'message' => "Successfully Update Status Order", 'order' => $order], Respnse::HTTP_ACCEPTED);

        } else {
            /// Generate not found response
            return response()->json([ 'success' => false, 'message' => 'Order with id ' . $id . ' not found!']);
        }
    }

    public function deleteOrder($id)
    {
        $now = Carbon::now();
        $order = Order::where('id', $id)->get();

        $num = count($order);

        if ($num == 0) {
            return $this->responser($order, $order, 'Order');
        } else {
            foreach ($order as $o) {
                $order_time = $o->created_at;
                $cancel_time = Carbon::parse($order_time)->addMinutes(10);

                if ($now > $cancel_time) {
                    return response()->json(['status' => 406, 'message' => 'You cannot cancel the order after 10 minutes of order time'], 406);
                } else {
                    $o->delete();
                    return response()->json(['status' => 200, 'message' => 'Order has been cancelled'], 200);
                }
            }
        }
    }

     public function price($product_id)
    {
        $product = Product::where('id', $product_id)->first();
        //price without additional charge and vat
        $withoutcharges = $product->price;

        //price with additional va


        if ($vat == 0) {
            $vatprice = 0;
        } else {
            $vatprice = ($vat / 100) * $withoutcharges;
        }

        //price with additional service charge
        $addtionalcharge = $product->shop->shopdetail->first()->additional_charge;
        if ($addtionalcharge == 0) {
            $addtionalprice = 0;
        } else {
            $addtionalprice = ($addtionalcharge / 100) * $withoutcharges;
        }
        //Total price with addtional vat and service charge
        $total_price = $withoutcharges + $vatprice + $addtionalprice;
        return $total_price;

    }
}
