<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class EventLeft
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $event;
    public $userId;
    public function __construct($event,$userId)
    {
        $this->event = $event;
        $this->userId = $userId;
    }
}
