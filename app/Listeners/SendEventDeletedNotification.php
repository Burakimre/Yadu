<?php

namespace App\Listeners;

use App\Events\EventDeleted;
use App\Events\EventEdited;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\EventDeleted as EventDeletedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;


class SendEventDeletedNotification
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
     * @param  EventDeleted  $event
     * @return void
     */
    public function handle(EventEdited $event)
    {
        $currentLocale = app()->getLocale();
        if($event->event->isDeleted == 1) {
            $event->event->userName = $event->event->owner->firstName;
            self::switchLang($event->event->owner);
            Mail::to($event->event->owner->email)->send(
                new EventDeletedMail($event->event)
            );
            if ($event->event->participants->count() > 0) {
                foreach ($event->event->participants as $participant) {
                    if ($participant->id != $event->event->owner->id) {
                        $event->event->userName = $participant->firstName;
                        self::switchLang($participant);
                        Mail::to($participant->email)->send(
                            new EventDeletedMail($event->event)
                        );
                    }
                }
            }
        }
        App::setLocale($currentLocale);
    }
    private function switchLang($user){
        switch($user->settings->LanguagePreference){
            case 'eng': App::setLocale('eng');
                break;
            case 'nl': App::setLocale('nl');
                break;
            default: App::setLocale('eng');
                break;
        }
    }
}
