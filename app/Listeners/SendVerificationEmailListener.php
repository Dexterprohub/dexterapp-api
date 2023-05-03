<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SendVerificationOTPEvent;
use App\Mail\SendVendorOTPEmail;
use App\Listeners\SendVerificationEmailListener;
use App\Models\Vendor;
use Illuminate\Support\Facades\Mail;


class SendVerificationEmailListener
{
 

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendVerificationOTPEvent $event)
    {
        $vendor = $event->vendor;

        Mail::to($vendor->email)->send(new SendVendorOTPEmail($vendor));
    }
}
