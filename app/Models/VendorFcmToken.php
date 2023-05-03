<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorFcmToken extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_id', 'token', 'type'];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
}
