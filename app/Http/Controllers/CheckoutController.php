<?php

namespace App\Http\Controllers;

use App\Enums\CheckoutStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Events\OrderRequestPlaced;
use App\Models\CartProduct;
use App\Models\Checkout;
use App\Models\Vendor;
use Auth;
use Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Paystack;
use Symfony\Component\HttpFoundation\Response;


class CheckoutController extends Controller
{
    public function index() {}

    public function store(Request $request)
    {
        // validate
        $validatedData = validator($request->all(), [
            'address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
        ])->validate();

        $paymentMethod = PaymentMethod::tryFrom($validatedData['payment_method']);

        // assign variables
        $user = Auth::guard('api')->user();
        $cart = $user->cart;
        $cartProducts = CartProduct::with('product.shop')->where('cart_id', $cart->id)->get();
        $vendor = Vendor::find($cartProducts->first()->product->shop->vendor_id);
        $vendor->load('shop');
        $subtotal = $cartProducts->sum('price');

        // add additional amounts
        $vatAmount = (7.5 / 100) * $subtotal;
        $shippingCost = $vendor->shop->shippingcost;
        $additionalCharge = $vendor->shop->additionalcharge;
        $discount = $vendor->shop->discount;
        $discountAmount = 0;

        // if there is a discount, remove it from the subtotal
        if ($discount > 0) {
            $discountAmount = ($discount / 100) * $subtotal;
        }

        $totalAmount = ($subtotal + $vatAmount + $shippingCost + $additionalCharge) - $discountAmount;

        $orderNumber = strtoupper(\Str::random(4)).'-'.str_pad($user->id + 1, 4, strtoupper(\Str::random()), STR_PAD_LEFT);

        $checkout = Checkout::create([
            'user_id' => $user->id,
            'vendor_id' => $vendor->id,
            'cart_id' => $cart->id,
            'phone' => $user->phone,
            'address' => $validatedData['address'],
            'payment_method' => $paymentMethod,
            'subtotal' => $subtotal,
            'discount' => $discountAmount ?? 0,
            'order_date' => Carbon::now(),
            'order_number' => $orderNumber,
            'tax' => $vatAmount ?? 0,
            'shippingcost' => $shippingCost ?? 0,
            'additionalcharge' => $additionalCharge ?? 0,
            'notes' => $validatedData['notes'],
            'total' => $totalAmount,
            'status' => CheckoutStatus::PENDING,
            'payment_status' => PaymentStatus::PENDING
        ]);

        event(new OrderRequestPlaced($checkout));

        if ($paymentMethod === PaymentMethod::PAYSTACK) {
            // handle paystack
            $paymentDetails = [
                'email' => $user->email,
                'amount' => parse_money($checkout->total),
                'reference' => $checkout->order_number,
                'callback_url' => route('callback.paystack'),
            ];

            $response = Paystack::transaction()->initialize($paymentDetails)->response();

            if (!$response['status']) {
                // update the payment method to transfer
                $checkout->update([
                    'payment_method' => PaymentMethod::CASH
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while processing your request. Please try again later., Please use an alternative payment method.'
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Checkout successful',
                'data' => [
                    ...$checkout->toArray(),
                    'authorization_url' => $response['data']['authorization_url'],
                ]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Checkout successful',
            'data' => $checkout,
        ]);
    }

    public function update(Request $request, Checkout $checkout)
    {
        $validatedData = validator($request->all(), [
            'status' => ['required', new Enum(CheckoutStatus::class)],
        ])->validate();

        $orderStatus = CheckoutStatus::tryFrom($validatedData['status']);
        $statusMessage = 'Order updated successfully';

        if ($orderStatus === CheckoutStatus::CONFIRMED) {
            $statusMessage = 'Order confirmed successfully';
            $checkout->update(['status' => CheckoutStatus::CONFIRMED]);
        } elseif ($orderStatus === CheckoutStatus::COMPLETED) {
            $statusMessage = 'Order completed successfully';
            $checkout->update(['status' => CheckoutStatus::CONFIRMED, 'payment_status' => PaymentStatus::SUCCESSFUL]);
        } elseif ($orderStatus === CheckoutStatus::CANCELLED) {
            $statusMessage = 'Order canceled successfully';
            $checkout->update(['status' => CheckoutStatus::CANCELLED, 'payment_status' => PaymentStatus::FAILED]);
        }

        return response()->json([
            'status' => 'success',
            'message' => $statusMessage,
            'data' => $checkout
        ]);
    }

    public function show(Checkout $checkout)
    {
        // retrieve the current authenticated user
        $user = Auth::guard('api')->user();

        // check if the order belongs to the current user
        if ($checkout->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to view this order'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'status' => "success",
            'message' => "Order retrieved successfully",
            'data' => $checkout
        ]);
    }

    public function pendingOrders()
    {
        $user = Auth::guard('api')->user();
        $orders = Checkout::where(['user_id' => $user->id, 'status' => CheckoutStatus::PENDING])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Pending orders retrieved successfully',
            'data' => $orders
        ]);
    }

    public function getUserActiveOrders()
    {
        $user = Auth::guard('api')->user();
        $orders = Checkout::where(['user_id' => $user->id, 'status' => CheckoutStatus::CONFIRMED])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Confirmed orders retrieved successfully',
            'data' => $orders
        ]);
    }

    public function getUserCompletedOrders()
    {
        $user = Auth::guard('api')->user();
        $orders = Checkout::where(['user_id' => $user->id, 'status' => CheckoutStatus::COMPLETED])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Completed orders retrieved successfully',
            'data' => $orders
        ]);
    }

    public function getUserRejectedOrders()
    {

        $user = Auth::guard('api')->user();
        $orders = Checkout::where(['user_id' => $user->id, 'status' => CheckoutStatus::CANCELLED])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Cancelled orders retrieved successfully',
            'data' => $orders
        ]);
    }

    public function cancelOrder(Checkout $checkout)
    {
        $now = Carbon::now();
        $cancel_time = Carbon::parse($checkout)->addMinutes(10);

        if ($now > $cancel_time) {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot cancel the checkout after 10 minutes of checkout time'
            ], Response::HTTP_BAD_REQUEST);
        }

        $checkout->update(['status' => CheckoutStatus::CANCELLED, 'payment_status' => PaymentStatus::FAILED]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order cancelled successfully',
            'data' => $checkout
        ]);
    }
}
