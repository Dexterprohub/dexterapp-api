<?php

namespace App\Http\Controllers;

use App\Enums\CheckoutStatus;
use App\Enums\PaymentStatus;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Paystack;

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
        if ($checkout->payment_status == PaymentStatus::SUCCESSFUL || $checkout->status == CheckoutStatus::COMPLETED) {
            return 'Payment has already been made for this order';
        }

        $payment = Paystack::transaction()->verify($reference)->response('data');

        // payment is successful
        if ($payment['status'] == 'success') {
            // update checkout
            $checkout->update([
                'payment_status' => PaymentStatus::SUCCESSFUL,
            ]);

            // return success message
            return 'Payment has been made successfully and awaiting vendor confirmation';
        }

        // payment failed
        $checkout->update([
            'status' => CheckoutStatus::CANCELLED,
            'payment_status' => PaymentStatus::FAILED,
        ]);

        // return error message
        return 'Payment failed';

    }
}
