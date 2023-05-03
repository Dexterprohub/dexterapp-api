<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPDeliveryMethod extends Model
{
    use HasFactory;

    protected $table = 'otp_delivery_methods';
    protected $guarded = [];

    public function vendor(){
        
        return $this->belongsTo(Vendor::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }
}
