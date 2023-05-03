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

class OrderCanceled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $checkout;
    // public $me
    public function __construct($checkout)
    {
        $this->checkout = $checkout;
    }

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
        return 'OrderCanceled';
    }

    public function broadcastWith(){
        return [
            // 'message' => 'Order confirmed. Sit back while' . $this->checkout->shop->name . ' we prepare your order.'
            'message' => 'Order Canceled by vendor.'
        ];
    }
}
