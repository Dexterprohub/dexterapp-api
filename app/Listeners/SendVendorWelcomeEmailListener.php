<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\VendorWelcomeEmailEvent;
use App\Mail\VendorWelcomeEmail;
use Illuminate\Support\Facades\Mail;


class SendVendorWelcomeEmailListener
{
    

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VendorWelcomeEmailEvent $event)
    {
        $vendor = $event->vendor;

        Mail::to($vendor->email)->send(new VendorWelcomeEmail($vendor));
    }
}
