<?php

namespace App\Listeners;

use App\Events\EventEdited;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\EventEdited as EventEditedMail;
use App\Mail\Admin\EventDeleted as EventDeletedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class SendEventEditedNotification
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
     * @param  EventEdited  $event
     * @return void
     */
    public function handle(EventEdited $event)
    {
        if($event->event->getOriginal('owner_id') != null )
        {
	        $currentLocale = app()->getLocale();
	        if($event->event->isDeleted == 0) {
	            if($event->event->owner->settings->NotificationEventEdited ==1){
	                self::switchLang($event->event->owner);
	                Mail::to($event->event->owner->email)->send(
	                    new EventEditedMail($event->event)
	                );
	            }

	            if ($event->event->participants->count() > 0) {
	                foreach ($event->event->participants as $participant) {
	                    $event->event->owner->firstName = $participant->firstName;
	                    $event->event->userName = $participant->firstName;
	                    if($participant->settings->NotificationEventEdited == 1){
	                        self::switchLang($participant);
	                        Mail::to($participant->email)->send(
	                            new EventEditedMail($event->event)
	                        );
	                    }
	                }
	            }
	        }else{
	            $event->event->userName = $event->event->owner->firstName;
	            if($event->event->owner->settings->NotificationEventDeleted ==1) {
	                self::switchLang($event->event->owner);
	                Mail::to($event->event->owner->email)->send(
	                    new EventDeletedMail($event->event)
	                );
	            }
	            if ($event->event->participants->count() > 0) {
	                foreach ($event->event->participants as $participant) {
	                    if ($participant->id != $event->event->owner->id) {
	                        $event->event->userName = $participant->firstName;
	                        if($participant->settings->NotificationEventDeleted == 1) {
	                            self::switchLang($participant);
	                            Mail::to($participant->email)->send(
	                                new EventDeletedMail($event->event)
	                            );
	                        }
	                    }
	                }
	            }
	        }
	        App::setLocale($currentLocale);
	    }
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
