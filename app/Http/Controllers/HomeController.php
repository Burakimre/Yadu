<?php

namespace App\Http\Controllers;

use App\Traits\DateToText;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

use App\Event;
use App\Testemonial;
use App\EventHasParticipants;
use Auth;

class HomeController extends Controller
{
    use DateToText;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::where('owner_id', auth()->user()->id)->where('isDeleted', '==', 0)->take(5)->get();

        $participation = array();        
        $part = EventHasParticipants::get()->where('account_id', '==', auth()->user()->id);

        foreach($part as $par)
		{
			$event = Event::find($par->event_id);

			if($event->isDeleted == 0)
			{
				$event->date = self::dateToShortText($event->startDate);
				$event->city = self::cityFromPostalcode($event->location->postalcode);
				array_push($participation, $event);
			}
		}
		foreach($participation as $event)
		{
			$event->date = self::dateToShortText($event->startDate);
			$event->city = self::cityFromPostalcode($event->location->postalcode);
		}

		foreach($events as $event)
		{
			$event->date = self::dateToShortText($event->startDate);
			$event->city = self::cityFromPostalcode($event->location->postalcode);
		}

        return view('home', compact('events','participation','testemonials'));
    }

    public function myEvents()
	{
		if(Auth::check())
		{
			$events = Event::all()->where('owner_id', auth()->user()->id)->where('isDeleted', '==', 0);

			foreach($events as $event)
			{
				$event->date = self::dateToShortText($event->startDate);
				$event->city = self::cityFromPostalcode($event->location->postalcode);
			}

			return view('accounts/my_events', compact('events'));
		}
		else
		{
			return redirect('/');
		}
	}

	public function participating()
	{
		if(Auth::check())
		{
			$events = array();
			$part = EventHasParticipants::get()->where('account_id', '==', auth()->user()->id);

			foreach($part as $par)
			{
				$event = Event::find($par->event_id);
				if($event->isDeleted == 0)
				{
					array_push($events, Event::find($par->event_id));
				}
			}
			foreach($events as $event)
			{
				$event->date = self::dateToShortText($event->startDate);
				$event->city = self::cityFromPostalcode($event->location->postalcode);
			}

			return view('accounts/participating', compact('events'));
		}
		else
		{
			return redirect('/');
		}
	}

    private function cityFromPostalcode($postalcode)
    {
        if (!self::isValidPostalcode($postalcode)) {
            return "Invalid postal code";
        }

        $url = "https://nominatim.openstreetmap.org/search?q={$postalcode}&format=json&addressdetails=1";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);
        if (isset($json[0]['address']['suburb'])) {
            return $json[0]['address']['suburb'];
        } else {
            return "City not found";
        }
    }

    private function isValidPostalcode($postalcode)
    {
        $regex = '/^([1-8][0-9]{3}|9[0-8][0-9]{2}|99[0-8][0-9]|999[0-9])[a-zA-Z]{2}$/';
        return preg_match($regex, $postalcode);
    }
}
