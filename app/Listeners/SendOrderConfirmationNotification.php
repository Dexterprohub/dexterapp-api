<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderConfirmationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    //   public function via($notifiable)
    // {
    //     return ['database'];
    // }
    
    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
       $orderinfo = $event->vendor;
       Notification::send($checkout, new NewUserNotification($event->vendor));
        return [
            'data' => $orderinfo
        ];

    }
}
