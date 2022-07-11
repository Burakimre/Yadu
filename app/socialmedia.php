<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class socialmedia extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'name';
    // protected $fillable = ['link'];
}
