<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function shopdetail(){
        return $this->hasOne(Shopdetail::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function offers(){
        return $this->hasMany(Offer::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function checkouts(){
        return $this->hasMany(Checkout::class);
    }
}
