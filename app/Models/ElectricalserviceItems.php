<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalserviceItems extends Model
{
    use HasFactory;

    public function electricalServiceItems(){
        return $thiis->belongsTo(ElectricalService::class);
    }
}
