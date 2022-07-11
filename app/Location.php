<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['locLongtitude', 'locLatitude', 'houseNumber', 'postalcode', 'route', 'locality' ];

}
