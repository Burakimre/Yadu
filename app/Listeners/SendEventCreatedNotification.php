<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Mail\Event\EventCreated as EventCreatedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

class SendEventCreatedNotification
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
     * @param  EventCreated  $event
     * @return void
     */
    public function handle(EventCreated $event)
    {
        $currentLocale = app()->getLocale();

        if($event->event->owner_id != null )
        {
	        Mail::to($event->event->owner->email)->send(
	            new EventCreatedMail($event->event,$event->event->owner)
	        );

	        //TODO: for when followers is merged - test this

	        foreach($event->event->owner->followers as $follower){
	            if($follower->status == 'accepted' && $follower->follower->settings->FollowNotificationCreateEvent == 1){
	                self::switchLang($follower->follower);
	                Mail::to($follower->follower->email)->send(
	                    new EventCreatedMail($event->event,$follower->follower)
	                );
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
