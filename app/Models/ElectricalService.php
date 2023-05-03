<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalService extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function artisan(){
        return $this->belongsToMany(Artisan::class)->withPivot('price');
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function serviceItems(){
        return $this->hasMany(ServiceItem::class);
    }
}
