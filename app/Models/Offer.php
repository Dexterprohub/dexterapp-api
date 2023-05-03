<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function makeup(){
        return $this->belongsTo(Makeup::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
