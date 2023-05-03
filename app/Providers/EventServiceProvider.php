<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\LoginHistory;
use App\Events\OrderPlaced;
use App\Listeners\StoreUserLoginHistory;
use App\Listeners\SendOrderConfirmationNotification;
use App\Events\UserWelcomeEmail;
use App\Listeners\SendUserWelcomeEmail;
use App\Events\SendVerificationOTPEvent;
use App\Listeners\SendVerificationEmailListener;
use App\Events\VendorWelcomeEmailEvent;
use App\Listeners\SendVendorWelcomeEmailListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        LoginHistory::class => [
            StoreUserLoginHistory::class,
        ],

        OrderPlaced::class => [
            SendOrderConfirmationNotification::class,
        ],

        UserWelcomeEmail::class => [
            SendUserWelcomeEmail::class,
        ],
        SendVerificationOTPEvent::class => [
            SendVerificationEmailListener::class,
        ],
        VendorWelcomeEmailEvent::class => [
            SendVendorWelcomeEmailListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
