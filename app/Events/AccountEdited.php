<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;


class AccountEdited
{
    use Dispatchable,  SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $account;
    public function __construct($account)
    {
        $this->account = $account;
    }
}
