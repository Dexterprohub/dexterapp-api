<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Notification;

/**
 * App\Models\Vendor
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vendor extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,  HasFactory, Notifiable; 

    protected $table = 'vendors';

    protected $guard = 'vendor';
    
    protected $guarded = [];
    
    protected $hidden = ['password', 'remember_token'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
   
    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function shop(){
        return $this->hasOne(Shop::class);
    }

    public function vendorFcmTokens(){
        return $this->hasMany(VendorFcmToken::class);
    }

    public function basicdetail(){
        return $this->hasOne(Basicdetail::class);
    }


    public function checkouts(){
        return $this->hasMany(Checkout::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function OTPDeliveryMethod(){
        return $this->hasMany('OTPDeliveryMethod');
    }

    public function vendorAddress(){
        return $this->hasMany(VendorAddress::class);
    }
}
