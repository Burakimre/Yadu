<?php

namespace App\Listeners;

use App\SharedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\EventShared;
use Illuminate\Support\Facades\Auth;

class LogEventShared
{
    public function __construct()
    {
        //
    }

    public function handle(EventShared $event)
    {
        $sharedEvent = new SharedEvent();

        $sharedEvent->event_id = $event->eventid;
        $sharedEvent->platform = $event->platform;
        if(Auth::check()){
            $sharedEvent->user_id = Auth::id();
        }

        $sharedEvent->save();
    }
}
