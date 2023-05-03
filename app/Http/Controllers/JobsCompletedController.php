<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;


class JobsCompletedController extends Controller
{
    public function complete(Request $request, Checkout $checkout){

        $shop = $checkout->shop;
        return '';

    }
}
