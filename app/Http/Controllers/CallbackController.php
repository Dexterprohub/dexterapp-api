<?php

namespace App\Http\Controllers;

use Iamolayemi\Paystack\Paystack;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function paystack(Request $request)
    {
        $reference = $request->get('reference') ?? $request->get('trxref');

        if (!$reference) {
            abort(404);
        }

        $payment = Paystack::transaction()->verify($reference)->response('data');

        // check payment status
        if ($payment['status'] == 'success') {
            // payment is successful
            // code your business logic here
        } else {
            // payment is not successful
        }

    }
}
