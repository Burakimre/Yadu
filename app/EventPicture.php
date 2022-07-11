<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPicture extends Model
{
    public function eventTag()
    {
        return $this->belongsTo(EventTag::class);
    }
}
