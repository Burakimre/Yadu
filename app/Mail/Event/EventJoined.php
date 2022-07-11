<?php

namespace App\Mail\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class EventJoined extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $event;
    public $user;
    public $executor;
    public $type;
    public function __construct($event,$user,$executor,$type)
    {
        $this->event = $event;
        $this->user = $user;
        $this->executor = $executor;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $headText = "";
        $bodyText = "";
        if($this->type == 1){
            $bodyText = Lang::get('mail.joinedEvent') ." ". $this->event->eventName ." ". Lang::get('mail.event'). ".";
            $headText = $this->user->firstName." ".Lang::get('mail.youJoinedEventHeader');
        }else if($this->event->owner->id == $this->user->id){
            $headText = $this->user->firstName." ".Lang::get('mail.eventJoinedYourHeader');
            $bodyText =
                $this->executor->firstName ." ". Lang::get('mail.joinedYourEvent') . " " . $this->event->eventName. ".";
        }else {
            $headText = $this->user->firstName." ".Lang::get('mail.eventJoinedHeader');
            $bodyText =
                $this->executor->firstName ." ".Lang::get('mail.participantJoinedEvent') . " " . $this->event->eventName. ".";
        }

        return $this->markdown('mail/shortInformationMail')
            ->subject($headText)
            ->with([
            'headText' =>  $headText,
            'salutation'=> Lang::get('mail.salutation'),
            'name'=>$this->user->firstName . ",",
            'bodyText'=>$bodyText
        ]);
    }
}
