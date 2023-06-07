<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Notification;
class Vendor extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,  HasFactory, Notifiable;

    protected $hidden = ['password', 'remember_token'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class);
    }

    public function vendorFcmTokens(): HasMany
    {
        return $this->hasMany(VendorFcmToken::class);
    }

    public function basicdetail(): HasOne
    {
        return $this->hasOne(Basicdetail::class);
    }


    public function checkouts(){
        return $this->hasMany(Checkout::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function OTPDeliveryMethod(){
        return $this->hasMany('OTPDeliveryMethod');
    }

    public function vendorAddress(){
        return $this->hasMany(VendorAddress::class);
    }
}
