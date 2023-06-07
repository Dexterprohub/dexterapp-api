<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'float',
        'in_stock' => 'boolean',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
    public function cartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
