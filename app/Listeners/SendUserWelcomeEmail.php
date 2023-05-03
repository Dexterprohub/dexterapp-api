<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeEmail;
use App\Events\UserWelcomeEmail as UserWelcomeEmailEvent;
use App\Listeners\SendUserWelcomeEmail;
use App\Models\User;

class SendUserWelcomeEmail
{
 

    public function handle(UserWelcomeEmailEvent $event)
    {
         // Access user and OTP from event properties
        $user = $event->user;

        Mail::to($user->email)->send(new UserWelcomeEmail($user));
    }
}
