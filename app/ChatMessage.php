<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'user_id', 'body'
    ];

    public function event() {
        return $this->belongsTo('App\Event');
    }

    public function account() {
        return $this->belongsTo('App\Account', 'user_id', 'id');
    }
}
