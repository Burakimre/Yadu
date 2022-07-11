<?php

namespace App\Listeners;

use App\AccountSettings;
use App\Events\AccountCreation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateEventAccountSettings
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccountCreation  $event
     * @return void
     */
    public function handle(AccountCreation $event)
    {
        AccountSettings::create(
            ['account_id' => $event->account->id]
        );
    }
}
