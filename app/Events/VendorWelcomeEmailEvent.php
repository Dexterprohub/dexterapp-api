<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Vendor;


class VendorWelcomeEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   
    public $vendor;
    
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }
}
