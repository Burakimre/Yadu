<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class EventEdited extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $event;
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = '';
        if($this->event->userName == $this->event->owner->firstName){
            $title = $this->event->owner->firstName . " " . Lang::get('mail.editTitle2') . " "
                .$this->event->eventName." ". Lang::get('mail.editTitle21');
        }else {
            $title = $this->event->userName ." ".Lang::get('mail.editTitle');
        }

        return $this->markdown('mail/shortInformationMail')
            ->subject($title)
            ->with([
                'headText' => $title,
            'salutation'=> Lang::get('mail.salutation'),
            'name'=>$this->event->owner->firstName . ",",
                'bodyText' => Lang::get('mail.editText1').$this->event->eventName . Lang::get('mail.editText2'),
        ]);
    }
}
