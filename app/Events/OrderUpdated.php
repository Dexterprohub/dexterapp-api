<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checkout;


class OrderUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $checkout;

    public function __construct($checkout)
    {
        $this->checkout = $checkout;
    }


    // public function broadcastAs(){
    //     return 'order-placed';
    // }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('vendors.'. $this->checkout->id);
    }

    public function broadcastAs(){
        return 'order-updated';
    }

    public function broadcastWith(){
        return [
            // 'message' => 'Order confirmed. Sit back while' . $this->checkout->shop->name . ' we prepare your order.'
            'message' => 'Order confirmed. Sit back while we prepare your order.'
        ];
    }
}

