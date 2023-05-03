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



class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $checkout;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $checkout)
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
        return new PrivateChannel('checkouts.'. $this->checkout->id);
    }

    public function broadcastAs(){
        return 'order-placed';
    }

    public function broadcastWith()
    {
        return [
            'order' => [
                'id' => $this->checkout->id,
                'customer' => $this->checkout->user->first_name . ' ' . $this->checkout->user->last_name ,
                'total' => $this->checkout->total,
            ],
        ];
    }

}
