<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopdetail extends Model
{
    use HasFactory;
    protected $fillable = [''];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
