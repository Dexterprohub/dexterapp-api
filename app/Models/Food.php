<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function food_category(){
        return $this->belongsTo(FoodCategory::class);
    }

    public function food_cart(){
        return $this->belongsTo(FoodCart::class);
    }

    public function favourite(){
        return $this->belongsTo(Favourite::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}
