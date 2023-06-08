<?php

namespace App\Enums;

enum CheckoutStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';

    case CANCELLED = 'cancelled';

    case COMPLETED = 'completed';
}
