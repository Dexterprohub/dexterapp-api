<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderComplete implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $checkout;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($checkout)
    {
        $this->checkout = $checkout;
    }

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
            'message' => 'Order Completed.'
        ];
    }
}
