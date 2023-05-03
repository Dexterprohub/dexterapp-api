<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // public $timestamps = false;


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function shops(){
        return $this->hasMany(Shop::class);
    }
    
    public function vendors(){
        return $this->hasMany(Vendor::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function vendorService(){
        return $this->belongsToMany(VendorService::class);
    }

    public function serviceItems(){
        return $this->hasMany(ServiceItem::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
