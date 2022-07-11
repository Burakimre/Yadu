<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Account;
use App\ChatMessage;
use App\Event;
use App\EventHasParticipants;
use App\EventTag;
use App\Http\Requests\GetChartDateRangeRequest;
use App\SharedEvent;
use App\SocialMediaPlatform;
use Carbon\Carbon;
use function GuzzleHttp\json_encode;
use function Opis\Closure\unserialize;


class ChartController extends Controller
{
    public function UpdateDateString(GetChartDateRangeRequest $request)
    {
        $format = __('formats.dateFormat');
        $fromDate = strtotime($request['fromDate']);
        $toDate = strtotime($request['toDate']);

        return array(__('charts.report_date', ['from' => date($format, $fromDate), 'till' => date($format, $toDate)]));
    }

    public function GetChatmessages(GetChartDateRangeRequest $request)
    {
        $data = $this->MakeDataArray($request['toDate'], $request['fromDate']);
        $messageCount = ChatMessage::whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->count();
        $data['messageData'] = array('messageCount' => $messageCount);
        return $data;
    }

    public function GetAccountsCreated(GetChartDateRangeRequest $request)
    {
        $data = $this->MakeDataArray($request['toDate'], $request['fromDate']);
        $accountCount = Account::where('isDeleted', 0)->whereBetween('created_at', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->count();
        $data['accountData'] = array('accountCount' => $accountCount);
        return $data;
    }

    public function GetTotalEventsCreated(GetChartDateRangeRequest $request)
    {
        $fromDate = Carbon::parse($request['fromDate']);
        $toDate = Carbon::parse($request['toDate'])->addDay();
        $difference = $toDate->diffInDays($fromDate);
        $data = array();
        $previousTotalEvents = 0;
        $firstRun = true;

        for ($i = 0; $i < $difference; $i++) {
            $totalEvents = Event::where('isDeleted', 0)->where('created_at', '<', $fromDate->copy()->addDays($i))->count();
            $entry = array(
                'date' => $fromDate->copy()->addDays($i)->format('c'),
                'totalEvents' => $totalEvents
            );

            if ($previousTotalEvents < $totalEvents || $firstRun) {
                array_push($data, $entry);
                $firstRun = false;
            }
            $previousTotalEvents = $totalEvents;
        }
        return $data;
    }

    public function GetShares(GetChartDateRangeRequest $request)
    {
        $data = $this->MakeDataArray($request['toDate'], $request['fromDate']);
        $platforms = SocialMediaPlatform::all();
        $data['shareData'] = array();

        foreach ($platforms as $platform) {
            $entry = array(
                'platform' => ucfirst($platform->platform),
                'shareCount' => SharedEvent::where('platform', $platform->platform)->whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->count(),
            );

            if ($entry['shareCount'] > 0) {
                array_push($data['shareData'], $entry);
            }
        }
        return $data;
    }

    public function GetCategories(GetChartDateRangeRequest $request)
    {
        $data = $this->MakeDataArray($request['toDate'], $request['fromDate']);
        $categories = EventTag::pluck('tag');
        $data['categoryData'] = array();

        for ($i = 0; $i < sizeof($categories); $i++) {
            $tag_id = EventTag::where('tag', $categories[$i])->pluck('id');
            $entry = array(
                'category' => ucfirst($categories[$i]),
                'count' => Event::where('tag_id', $tag_id)->whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->count()
            );

            if ($entry['count'] > 0) {
                array_push($data['categoryData'], $entry);
            }
        }
        return $data;
    }

    public function GetActiveEventLocations(GetChartDateRangeRequest $request)
    {
        $data = array();
        $events = Event::where('isDeleted', 0)->whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->get();

        foreach ($events as $event) {
            $entry = array(
                'lat' => $event->location->locLatitude,
                'lng' => $event->location->locLongtitude
            );
            array_push($data, $entry);
        }
        return $data;
    }

    public function GetMostActiveUser(GetChartDateRangeRequest $request)
    {
        $data = array();
        $events = Event::where('isDeleted', 0)->whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->get();

        foreach ($events as $event) {
            foreach ($event->participants as $participant) {
                if (array_key_exists($participant->id, $data)) {
                    $data[$participant->id]->amount++;
                } else {
                    $data[$participant->id] = (object)[
                        'id' => $participant->id,
                        'firstName' => $participant->firstName,
                        'middleName' => $participant->middleName,
                        'lastName' => $participant->lastName,
                        'amount' => 1
                    ];
                }
            }
        }

        usort($data, function ($a, $b) {
            if ($a->amount == $b->amount) {
                return 0;
            }
            return ($a->amount > $b->amount) ? -1 : 1;
        });

        return $data;
    }

    public function GetMostParticipants(GetChartDateRangeRequest $request)
    {
        $data = $this->MakeDataArray($request['toDate'], $request['fromDate']);
        $events = Event::where('isDeleted', 0)->whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->get();

        foreach ($events as $item) {
            $item->amountOfParticipants = $item->participants->count();
        }

        $returnEvent = $events->sortByDesc('amountOfParticipants')->first();

        $data['mostParticipantEventData'] = (object)[
            'id' => $returnEvent->id,
            'eventName' => $returnEvent->eventName,
            'amount' => $returnEvent->amountOfParticipants
        ];

        return $data;
    }

    public function GetZeroParticipants(GetChartDateRangeRequest $request)
    {
        $data = $this->MakeDataArray($request['toDate'], $request['fromDate']);

        $events = Event::select('id')->where('isDeleted', 0)->whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->get();
        $eventsWithParticipants = EventHasParticipants::select('event_id')->distinct()->get();

        $ids = array();
        foreach ($eventsWithParticipants as $event) {
            array_push($ids, $event->event_id);
        }

        $zeroParticipantEvents = 0;
        foreach ($events as $event) {
            if (!in_array($event->id, $ids)) {
                $zeroParticipantEvents++;
            }
        }

        $data['zeroParticipantEventData'] = array('zeroParticipantCount' => $zeroParticipantEvents);
        return $data;
    }

    public function GetAverageParticipants(GetChartDateRangeRequest $request)
    {
        $data = $this->MakeDataArray($request['toDate'], $request['fromDate']);

        $events = Event::select('id')->where('isDeleted', 0)->whereBetween('startDate', [$request->fromDate, Carbon::parse($request->toDate)->addDay()])->get();

        $totalParticipants = 0;
        foreach ($events as $event) {
            $totalParticipants += $event->participants()->count();
        }

        $average = round($totalParticipants / $events->count(), 1);

        $data['averageParticipantEventData'] = array("averageParticipantCount" => $average);

        return $data;
    }


    private function MakeDataArray($toDate, $fromDate)
    {
        $data = array();
        $data['dateInfo'] = array(
            'fromDate' => $fromDate->toDateString(),
            'toDate' => $toDate->toDateString()
        );
        return $data;
    }
}
