<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

trait DateToText
{
    private function setLocale(){
        setlocale(LC_ALL, App::getLocale());
    }

    public function dateToShortText($timestamp)
    {
        $this->setLocale();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
        $formatted_date = ucfirst($date->formatLocalized(__('formats.writtenDateFormat_short')));
        return $formatted_date;
    }

    public function dateToLongText($timestamp)
    {
        $this->setLocale();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
        $formatted_date = ucfirst($date->formatLocalized(__('formats.writtenDateFormat_long')));
        return $formatted_date;
    }
}