<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electrical extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
