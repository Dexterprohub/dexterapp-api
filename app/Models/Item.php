<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function vendors(){
        return $this->belongsToMany(Vendor::class);
    }
}
