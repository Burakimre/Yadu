<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannedIp extends Model
{
    protected $fillable = ['ip'];
}
