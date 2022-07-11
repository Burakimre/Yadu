<?php

namespace App\Mail\Event;

use App\Event;
use DateInterval;
use Faker\Provider\DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;
use App\Traits\DateToText;

class EventCreated extends Mailable
{
    use Queueable, SerializesModels,DateToText;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $event;
    public $user;
    public function __construct($event,$user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = '';
        if($this->event->owner->id != $this->user->id){
            $title = $this->event->owner->firstName  . " ". Lang::get('mail.eventFollowerCreatedTitle');
        }else{
            $title = Lang::get('mail.eventCreatedTitle');
        }

        $this->event= Event::findOrFail($this->event->id);
        return $this->markdown('mail/tableInformationMail')
            ->subject($title)
            ->with([
                'title' => $title,
                'salutation'=> Lang::get('mail.salutation'),
                'userName'=>$this->user->firstName . ",",
                'body' => Lang::get('mail.eventCreatedText1')." "
                    .$this->event->eventName.Lang::get('mail.eventCreatedText2'),
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
