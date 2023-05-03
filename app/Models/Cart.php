<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $guarded = [];
    // public $timestamps = false;
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function cartProducts(){
        return $this->hasMany(CartProduct::class);
    }

    
    // public function products()
    // {
    //     return $this->hasManyThrough(Product::class, CartProduct::class);
    // }


    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }


}
