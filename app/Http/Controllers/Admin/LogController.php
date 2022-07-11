<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\EventShared;

class LogController extends Controller
{
    public function LogEventShared(Request $request){

        $eventid = $request['eventid'];
        $platform = $request['platform'];

        $array = array("eventid" => $eventid, "platform" => $platform);
        event(new EventShared($array));
    }
}
