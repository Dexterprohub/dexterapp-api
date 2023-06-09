<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorService extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'vendor_id'];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }


}
