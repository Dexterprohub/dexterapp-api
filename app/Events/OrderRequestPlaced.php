<?php

namespace App\Events;

use App\Models\Checkout;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderRequestPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected readonly Checkout $checkout) {}

    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('checkouts.'. $this->checkout->id);
    }

    public function broadcastAs(): string
    {
        return 'order-placed';
    }

    public function broadcastWith(): array
    {
        return [
            'order' => [
                'message' => 'New order request from '. $this->checkout->user->first_name. ' ' . $this->checkout->user->last_name,
                'total' => $this->checkout->total,
            ],
        ];
    }
}
