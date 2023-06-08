<?php

namespace App\Models;

use App\Casts\AsMoney;
use App\Enums\CheckoutStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \App\Enums\PaymentMethod;

class Checkout extends Model
{
    use HasFactory;

    protected $casts = [
        'payment_method' => PaymentMethod::class,
        'status' => CheckoutStatus::class,
        'payment_status' => PaymentStatus::class,
        'total' => AsMoney::class,
        'subtotal' => AsMoney::class,
        'discount' => AsMoney::class,
        'tax' => AsMoney::class,
        'shippingcost' => AsMoney::class,
        'additionalcharge' => AsMoney::class,
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
