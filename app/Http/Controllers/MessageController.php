<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Event;
use App\ChatMessage;
use Auth;
use App\Rules\swearWords;

class MessageController extends Controller
{
    public function index(Event $event) {

        $messages = $event->messages;

        foreach ($messages as $message){
            $account = Account::where('id', $message->user_id)->first();
            $message->firstName = $account->firstName;
            $message->lastName = $account->lastName;
        }

        return response()->json($messages);
    }

    public function store(Request $request, Event $event) {

        $this->validate($request, [
            'body' => ['required', 'max:180', new swearWords]
        ]);
        
        $message = $event->messages()->create([
            'body' => $request->body,
            'user_id' => $request->id
        ]);

        $message = ChatMessage::where('id', $message->id)->with(['account' => function ($query) {
            return $query->select(['id', 'firstName', 'lastName']);
        }])->first();

        $account = Account::where('id', $message->user_id)->first();

        $message->lastName = $account->lastName;
        $message->firstName = $account->firstName;

        broadcast(new NewMessage($message))->toOthers();

        return $message->toJson();
    }
}
