<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;


class EventDeleted
{
    use Dispatchable, SerializesModels;
    public $event;
    public function __construct($event)
    {
        $this->event = $event;
    }
}
