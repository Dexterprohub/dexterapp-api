<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Notification;
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property int $role_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @property string|null $email_verified_at
 * @property string|null $remember_token
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 */
class User extends Authenticatable implements MustVerifyEmail
// class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    protected $hidden = ['password'];

    public function services(){

    }
    public function shop(){
        
        return $this->hasOne(Shop::class);
    }
    public function order(){
        return $this->hasOne(Order::class);
    }

    // public function cartProducts(){
    //     return $this->hasMany(CartProduct::class);
    // }

    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }
    public function favourites(){
        return $this->hasMany(Favourite::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function permissions(){
        return $this->role->permissions->pluck('name');
    }

    public function hasAccess($access){
        return $this->permissions()->contains($access);
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function is_superAdmin($id){
        $user = User::where('id' , $id)->first();
        if($user->role_id == 1 ){
            return true;
        } else {
            return false;
        }
    }
    public function sosaxbrodie($id){
        $user = User::where('id' , $id)->first();
        if($user->role_id == 1 ){
            return true;
        } else {
            return false;
        }
    }

    public function is_manager($id){
        $user = User::where('id' , $id)->first();
        if($user->role_id == 2 ){
            return true;
        } else {
            return false;
        }
    }

    public function OTPDeliveryMethod(){
        return $this->hasMany('OTPDeliveryMethod');
    }

    public function sendPasswordResetNotification($token)
    {
        $url = "https://dexterprolimited.com/reset-password?token=" . $token;

        $this->notify(new ResetPasswordNotification($url));
    }

 
}
