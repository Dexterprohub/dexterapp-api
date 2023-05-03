<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $guarded = [];

     public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    // public function orderItems(){
    //     return $this->hasMany(OrderItem::class);
    // }

    // public function getTotalAttribute(){

    //     return $this->cart->sum(function(Cart $item){
    //         return $item->price * $item->quantity;
    //     });

        
    // }
}
