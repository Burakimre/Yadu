<?php

namespace App\Providers;


use App\Events\AccountCreatedEvent;
use App\Events\AccountCreation;
use App\Events\EventCreated;
use App\Listeners\CreateEventAccountSettings;
use App\Listeners\SendEventCreatedNotification;
use App\Events\EventShared;
use App\Events\EventEdited;
use App\Listeners\LogEventShared;
use App\Events\AccountEdited;
use App\Events\EventJoined;
use App\Events\EventLeft;
use App\Listeners\SendAccountEditedNotification;
use App\Listeners\SendEventEditedNotification;
use App\Listeners\SendEventJoinedNotification;
use App\Listeners\SendEventLeftNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        EventEdited::class => [
            SendEventEditedNotification::class,
        ],

        AccountCreation::class => [
            CreateEventAccountSettings::class,
        ],

        EventCreated::class => [
          SendEventCreatedNotification::class,
		],

        EventShared::class => [
            LogEventShared::class,

        ],

        EventJoined::class => [
            SendEventJoinedNotification::class,
        ],

        EventLeft::class => [
            SendEventLeftNotification::class,
        ],

        AccountEdited::class => [
            SendAccountEditedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
