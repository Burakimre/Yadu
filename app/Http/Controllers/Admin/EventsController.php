<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Event;
use App\EventPicture;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\EventTag;
use App\Account;
use Validator;
use Illuminate\Support\Carbon;
use App\Location;
use Auth;


class EventsController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
            if (Auth::user()->accountRole == 'Admin')
            {
                $events = Event::where('isDeleted', 0)->orderBy('startDate','desc')->get();

                $tags = EventTag::all();
                $names = Event::distinct('eventName')->pluck('eventName');
                $currentDate = Carbon::now();
                foreach($events as $event){
                    $event->city = $event->location->locality;
                    $event->currentDate = $currentDate;
                }
                return view('admin/events.index', compact(['tags', 'names'],'events'));
            }
            else
            {
                abort(403);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    public function create()
    {
        if (Auth::check())
        {
            if (Auth::user()->accountRole == 'Admin')
            {
                if(Auth::user()->hasVerifiedEmail())
                {
                    $Tags = EventTag::all();
                    $Picture = EventPicture::all();
                    return view('events.create')->withtags($Tags)->withpictures($Picture);
                }
                return redirect('/events');
            }
            else
            {
                abort(403);
            }
        }
        else
        {
            return redirect('/login');
        }
    }

    public function action(Request $request)
    {
        $Picture = EventPicture::where('tag_id', '=', $request->input('query'))->get();
        foreach ($Picture as $x) {
            $x->picture = base64_encode($x->picture);
        }
        return json_encode($Picture);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activityName' => 'required|max:30',
            'description' => 'required|max:150',
            'people' => 'required', //min en max nog doen
            'tag' => 'required',
            'startDate' => 'required|date',
            'location' => 'required',
            'picture' => 'required'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($this->isPictureValid($request['tag'], $request['picture'])) {
                $validator->errors()->add('picture', 'Something is wrong with this field!');
            }
        });

        if ($validator->fails()) {
            return redirect('/events/create')
                ->withErrors($validator)
                ->withInput();
        }

        Event::create(
            [
                'eventName' => $request['activityName'],
                'status' => 'created',
                'description' => $request['description'],
                'startDate' => $request['startDate'],
                'numberOfPeople' => $request['people'],
                'tag_id' => $request['tag'],
                'location_id' => '1',
                'owner_id' => auth()->user()->id,
                'event_picture_id'=> $request['picture']
            ]
        );
        return redirect('/events');
    }

    public function isPictureValid($tag, $picture){
        if (!EventPicture::where('id','=',  $picture)->exists()) {
            return true;
        } else {
            $eventPicture = EventPicture::all()->where('id','=',  $picture)->pluck('tag_id');
            if ($eventPicture[0] != $tag) {
                return true;
            }
            return false;
        }
    }

    public function show(Event $event)
    {
        if (Auth::check())
        {
            return view('events.show', compact('event'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public function edit(Event $event)
    {
        if (Auth::check())
        {
            if (Auth::user()->accountRole == 'Admin')
            {
                $data = array(
                    'event' => $event,
                    'tags' => EventTag::all(),
                    'picture' => EventPicture::all()
                );

                $datetime = explode(' ', $event->startDate);

                $event->startDate = $datetime[0];
                $event->startTime = $datetime[1];

                return view('admin/events.edit', compact('data'));
            }
            else
            {
                abort(403);
            }
        }
        else
        {
            return redirect('/login');
        }

        //TODO: Should find a better way
        $account = Account::where('id',Auth::id())->get();
        if ($event->owner_id == Auth::id() || $account[0]->accountRole == 'Admin')
        {

        }
        else
        {
            abort(403);
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::check())
        {
            if (Auth::user()->accountRole == 'Admin')
            {
                $validator = Validator::make($request->all(), [
                    'activityName' => 'required|max:30',
                    'description' => 'required|max:150',
                    'numberOfPeople' => 'required', //TODO: min en max nog doen
                    'tag' => 'required',
                    'startDate' => 'required|date|after:now',
                    'startTime' => 'required',
                    'lng' => 'required|max:45',
                    'lat' => 'required|max:45',
                    'houseNumber' => 'required|max:10',
                    'postalCode' => 'required|max:45',
                    'route'=> 'required',
                    'locality' => 'required',
                    'numberOfPeople' => 'required',
                    'isHighlighted' => 'nullable|string'
                ]);

                $highlight = 0;
                if($request['isHighlighted'] == "on")
                {
                    $highlight = 1;
                }

                $request['startDate'] = $request['startDate'] . ' ' . $request['startTime'];

                $validator->after(function ($validator) use ($request)
                {
                    if ($this->isPictureValid($request['tag'], $request['picture']))
                    {
                        $validator->errors()->add('picture', 'Something is wrong with this field!');
                    }
                });

                if ($validator->fails())
                {
                    return redirect("/admin/events/$id/edit")
                        ->withErrors($validator)
                        ->withInput();
                }

                $event = Event::where('id', $id)->firstorfail();
                $location = Location::where('id', $event->location_id)->firstorfail();

                $location->update([
                    'locLongtitude' => $request['lng'],
                    'locLatitude' => $request['lat'],
                    'houseNumber' => $request['houseNumber'],
                    'postalcode' => str_replace(' ', '', $request['postalCode']),
                    'route'=> $request['route'],
                    'locality' => $request['locality'],
                ]);

                $event->update(
                    [
                        'eventName' => $request['activityName'],
                        'description' => $request['description'],
                        'startDate' => $request['startDate'],
                        'numberOfPeople' => $request['numberOfPeople'],
                        'tag_id' => $request['tag'],
                        'event_picture_id' => $request['picture'],
                        'isHighlighted' => $highlight
                    ]
                );
                return redirect('/admin/events');
            }
            else
            {
                abort(403);
            }
        }
    }


    public function destroy(Event $event)
    {
        if (Auth::check())
        {
            $event = Event::findOrFail($event->id);

            $event->update([
                'isDeleted' => 1
            ]);

            return redirect('admin/events');
        }
    }

    public function join($id)
    {

        if(Auth::user()->hasVerifiedEmail()) {
            $event = Event::findOrFail($id);
            if (!$event->participants->contains(auth()->user()->id) && ($event->owner->id != auth()->user()->id)) {
                $event->participants()->attach(auth()->user()->id);
            }
            //TODO: Add error 'You already joined!'
        }
        //TODO: Add error 'You are not logged in!'
        return redirect('/events/' . $id);
    }

   public function leave($id)
    {
        if(Auth::check()) {
            $event = Event::findOrFail($id);
            if ($event->participants->contains(auth()->user()->id) && ($event->owner->id != auth()->user()->id)) {
                $event->participants()->detach(auth()->user()->id);
            }
            //TODO: Add error 'You are not joined!'
        }
    }

     private function formatDate()
    {
        $date = getdate();
        $formatted_date = $date['year'] . "/";
        $formatted_date .= $date['mon'] . "/";
        $formatted_date .= $date['mday'];
        return $formatted_date;
    }

    private function areEvenstInRange($events)
    {
        $locationController = new LocationController();
        return  $events = $locationController->areWithinReach($events, $this->distance);
    }

    private $distance = 0;

    public function actionDistanceFilter(Request $request)
    {

        $tags = EventTag::where('tag', 'like', '%' . $request->inputTag .'%')->pluck('id');
        $names = Event::where('eventName', 'like', '%' . $request->inputName .'%')->pluck('id');
        $this->distance = $request->input('distance');
        $unfiltered_events = Event::where('isDeleted', '==', 0)
            ->whereIn('id', $names)
            ->whereIn('tag_id', $tags)
            ->orderBy('startDate', 'des')
            ->get();

        $events = new Collection();

        foreach ($unfiltered_events as $event) {
            $postalcode =  $event->location->locality;

            $Picture = eventPicture::where('id', '=', $event->event_picture_id)->get();
            $Pic = (base64_encode($Picture[0]->picture));

            $owner = Account::where('id', '=', $event->owner_id)->get();
            $eventInfo = Event::where('id', '=', $event->id)->get();
            $ammount = 0;
            if($eventInfo[0]->participants->count() != 0){
                $ammount = $eventInfo[0]->participants->count();
            }
            $userDate = "";
            if($request->session()->get('locale') == 'nl'){
                $userDate = \Carbon\Carbon::parse($event->startDate)->format('d/m/Y - H:i');
            }else{
                $userDate = \Carbon\Carbon::parse($event->startDate)->format('m/d/Y - H:i');
            }
            $eventTag = EventTag::where('id', '=', $event->tag_id)->get();

            $startDate = date('Y-m-d', strtotime($event->startDate));
            $currentDate = date('Y-m-d', strtotime(Carbon::now()));
            $dateInt =2;
            if($startDate == $currentDate){
                $dateInt =0;
            }else if($startDate < $currentDate){
                $dateInt =1;
            }

            $event->setAttribute('dateInt', $dateInt);
            $event->setAttribute('tag', $eventTag[0]['tag']);
            $event->setAttribute('user_date', $userDate);
            $event->setAttribute('participants_ammount',$ammount);
            $event->setAttribute('owner_firstName', $owner[0]['firstName']);
            $event->setAttribute('owner_middleName', $owner[0]['middleName']);
            $event->setAttribute('owner_lastName', $owner[0]['lastName']);
            $event->setAttribute('picture', $Pic);
            $event->setAttribute('loc', $postalcode);
            $events->push($event);
        }
        return json_encode($events);
    }

    public function dateToText($timestamp)
    {
        setlocale(LC_ALL, 'nl_NL.utf8');
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
        $formatted_date = ucfirst($date->formatLocalized('%a %d %B %Y'));
        return $formatted_date;
    }
}
