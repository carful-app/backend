<?php

namespace App\Providers;

use App\Events\ParkCarCreated;
use App\Events\Stripe\SubscriptionUpdated;
use App\Events\TransactionCreated;
use App\Listeners\SendNotificationWithUpdates;
use App\Listeners\Stripe\HandleSubscriptionUpdated;
use App\Listeners\UpdateUserBalance;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        TransactionCreated::class => [
            UpdateUserBalance::class,
        ],

        ParkCarCreated::class => [
            SendNotificationWithUpdates::class,
        ],

        SubscriptionUpdated::class => [
            HandleSubscriptionUpdated::class,
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
