<?php

namespace App\Http\Controllers;

use App\Enums\CheckoutStatus;
use App\Enums\PaymentStatus;
use App\Models\Checkout;
use Paystack;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function paystack(Request $request)
    {
        $reference = $request->get('reference') ?? $request->get('trxref');

        if (!$reference) {
            abort(404);
        }

        $checkout = Checkout::where('order_number', $reference)->firstOrFail();

        // if the checkout is already completed
        if($checkout->payment_status == PaymentStatus::SUCCESSFUL) {
           return 'Payment has already been made for this order';
        }

        $payment = Paystack::transaction()->verify($reference)->response('data');

        // check payment status
        if ($payment['status'] == 'success') {
            // update checkout
            $checkout->update([
                'status' => CheckoutStatus::COMPLETED,
                'payment_status' => PaymentStatus::SUCCESSFUL,
            ]);

            // redirect to success page
            return 'Payment has been made successfully';
        } else {
            $checkout->update([
                'status' => CheckoutStatus::CANCELLED,
                'payment_status' => PaymentStatus::FAILED,
            ]);

           return'Payment failed';
        }

    }
}
