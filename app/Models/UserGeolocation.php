<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGeolocation extends Model
{
    use HasFactory;

    protected $table = "users_geolocation";

    protected $guarded = ['id'];
}
