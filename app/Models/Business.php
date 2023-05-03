<?php

namespace App\Models;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function offer(){
        return $this->hasMany(Offer::class);
    }

    public function category(){
        $this->belongsTo(Category::class);
    }

    public function review(){
        return $this->hasMany(Review::class);
    }
    public function restaurant(){
        return $this->hasMany(Restaurant::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function rating(){
        return $this->hasMany(Rating::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

   
}
