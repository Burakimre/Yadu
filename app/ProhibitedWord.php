<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProhibitedWord extends Model
{
    protected $fillable = ['word', 'created_at', 'updated_at'];
}
