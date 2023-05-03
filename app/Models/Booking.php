<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'bookings';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    // public function optionalServiceItem(){
    //     return $this->belongsTo();
    // }

    // public function message(){
    //     return $this->belongsTo(M);
    // }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function review(){
        return $this->belongsTo(Review::class);
    }
}
