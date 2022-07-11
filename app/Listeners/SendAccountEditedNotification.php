<?php

namespace App\Listeners;

use App\Events\AccountEdited;
use Illuminate\Support\Facades\Mail;
use App\Mail\Account\AccountEdited as AccountEditedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;

class SendAccountEditedNotification
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
     * @param  AccountEdited  $event
     * @return void
     */
    public function handle(AccountEdited $event)
    {
        $currentLocale = app()->getLocale();
        switch($event->account->settings->LanguagePreference){
            case 'eng': App::setLocale('eng');
                break;
            case 'nl': App::setLocale('nl');
                break;
            default: App::setLocale('eng');
                break;
        }

        if($event->account->remember_token == $event->account->getOriginal('remember_token')
            && $event->account->email_verified_at == $event->account->getOriginal('email_verified_at')){
            Mail::to($event->account->getOriginal('email'))->send(
                new AccountEditedMail($event->account)
            );
        }
        App::setLocale($currentLocale);
    }
}
