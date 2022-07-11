<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedEvent extends Model
{
    protected $fillable = ['eventid','userid', 'platform'];
}
