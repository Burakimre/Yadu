<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;
use App\Traits\DateToText;

class EventDeleted extends Mailable
{
    use Queueable, SerializesModels,DateToText;

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
        if($this->event->userName != $this->event->owner->firstName){
            $title = Lang::get('mail.deleteTitleParticipant');
        }else {
            $title = Lang::get('mail.deleteTitle1'). " ". $this->event->eventName . " " . Lang::get('mail.deleteTitle2');
        }

        return $this->markdown('mail/tableInformationMail')
            ->subject($title)
            ->with([
                'title' => $title,
            'salutation'=> Lang::get('mail.salutation'),
            'userName'=>$this->event->userName . ",",
                'body' => Lang::get('mail.deleteText1').$this->event->eventName . Lang::get('mail.deleteText2'),
                'infoTitle' => Lang::get('mail.eventInfoTitle'),
                'eventName' => Lang::get('events.show_title'). ": " . $this->event->eventName,
                'eventDate' => Lang::get('events.show_date').": " . self::dateToLongText($this->event->startDate),
                'ownerName' => Lang::get('mail.eventOwner').": " . $this->event->owner->firstName,
                'numberOfPeople' => Lang::get('events.show_attendees_amount').": " . $this->event->participants->count(),
                'description' => Lang::get('events.show_description').": " . $this->event->description,
                'closing' => Lang::get('mail.closing')
        ]);
    }
}
