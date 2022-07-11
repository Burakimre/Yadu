<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventHasParticipants extends Model
{
    protected $fillable = [
        'rating',
    ];

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
    
    public function event()
    {
    	return $this->hasOne(Event::class, 'id', 'event_id');
    }
}