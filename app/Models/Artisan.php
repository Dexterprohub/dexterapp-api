<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    use HasFactory;

    
    public function electricalServices(){
        return $this->belongsToMany(ElectricalService::class)->withPivot('price');
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

   
}
