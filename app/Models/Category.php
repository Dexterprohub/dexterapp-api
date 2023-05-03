<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;


class Category extends Model
{
    use HasFactory, MediaAlly;

    protected $table = "categories";
    protected $fillable = ['id', 'shop_id', 'name', 'cover_image'];

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

}
