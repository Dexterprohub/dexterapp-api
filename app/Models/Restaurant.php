<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Notifications;
/**
 * App\Models\Restaurant
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string|null $latitude
 * @property string|null $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RestaurantFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Restaurant extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function menus(){
        return $this->belongsTo(Menu::class);
    }

    public function branch(){
        return $this->hasMany(Branch::class);
    }

    public function review(){
        return $this->hasMany(Review::class);
    }

    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function food(){
        return $this->hasMany(Food::class);
    }

    public function foodCategory(){
        return $this->hasMany(FoodCategory::class);
    }

    public function followedBy(){
        return $this->belongsToMany(User::class);
    }

    public function address(){
        return $this->hasOne(Address::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }


}
