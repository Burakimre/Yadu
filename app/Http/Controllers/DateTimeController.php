<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DateTimeController extends Controller
{
    public static function getDayNames($dayNumber)
    {
        switch ($dayNumber) {
            case 1:
                return __('global.days_monday');
                break;
            case 2:
                return __('global.days_tuesday');
                break;
            case 3:
                return __('global.days_wednesday');
                break;
            case 4:
                return __('global.days_thursday');
                break;
            case 5:
                return __('global.days_friday');
                break;
            case 6:
                return __('global.days_saturday');
                break;
            case 7:
                return __('global.days_sunday');
                break;
        }
    }
}
