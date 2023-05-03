<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Order;
use App\Models\User;
use App\Models\Vendor;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('checkouts.{orderId}', function (User $user, int $orderId) {
    return $user->id === Checkout::findOrNew($orderId)->user_id;
});
Broadcast::channel('vendors.{orderId}', function (Vendor $vendor, int $orderId) {

    return $vendor->id === Checkout::findOrNew($orderId)->vendor_id;
});

Broadcast::channel('user.{toUserId}', function ($user, $toUserId) {
    return $user->id == $toUserId;
    
});