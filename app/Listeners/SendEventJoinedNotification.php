<?php

namespace App\Listeners;

use App\Events\EventJoined;
use Illuminate\Support\Facades\Mail;
use App\Mail\Event\EventJoined as EventJoinedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Account;
use Illuminate\Support\Facades\App;

class SendEventJoinedNotification
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
     * @param  EventJoined  $event
     * @return void
     */
    public function handle(EventJoined $event)
    {
        $currentLocale = app()->getLocale();
        $executor = Account::findOrFail($event->userId);
        $this->sendMailToExecutor($event,$executor);
        $this->sendMailToOwner($event,$executor);
        $this->sendMailToParticipants($event,$executor);
        $this->sendMailToFollowers($event,$executor);
        App::setLocale($currentLocale);
    }

    private function sendMailToExecutor($event, $executor){
        self::switchLang($executor);
        Mail::to($executor->email)->send(
            new EventJoinedMail($event->event,$executor,$executor,1)
        );
    }

    private function sendMailToOwner($event, $executor){
        self::switchLang($event->event->owner);
        Mail::to($event->event->owner->email)->send(
            new EventJoinedMail($event->event,$event->event->owner,$executor,0)
        );
    }

    private function sendMailToParticipants($event, $executor){
        if($event->event->participants->count() >0){
            foreach($event->event->participants as $participant){
                $isNotAFollower = true;
                foreach($executor->followers as $follower){
                    if($follower->follower_id == $participant->id){
                        if($follower->status == 'accepted' && $follower->follower->settings->FollowNotificationJoinAndLeaveEvent != 1) {
                            $isNotAFollower = false;
                        }
                    }
                }
                if($participant->id != $executor->id && $participant->id != $event->event->owner->id && $isNotAFollower
                    && $participant->settings->NotificationJoinAndLeaveEvent == 1){
                    self::switchLang($participant);
                    Mail::to($participant->email)->send(
                        new EventJoinedMail($event->event,$participant,$executor,0)
                    );
                }
            }
        }
    }

    private function sendMailToFollowers($event, $executor){
        if($executor->followers->count() >0){
            foreach($executor->followers as $follower){
                if($follower->status == 'accepted'){
                    $follower = $follower->follower;
                    if($follower->id != $executor->id && $follower->id != $event->event->owner->id && $follower->settings->FollowNotificationJoinAndLeaveEvent == 1){
                        self::switchLang($follower);
                        Mail::to($follower->email)->send(
                            new EventJoinedMail($event->event,$follower,$executor,0)
                        );
                    }
                }
            }
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
