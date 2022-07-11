<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountSettings;
use App\BlockedUser;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\EditAvatarRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\EditPrivacySettingsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Gender;
use App\Event;
use App\EventHasParticipants;
use App\AccountHasFollowers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Str;
use Validator;
use App\Mail\Follow as FollowMail;
use App;


class AccountController extends Controller
{
	public function profileInfo($id, $contentType)
	{
		$account = Account::where('id', $id)->firstOrFail();
		if($account->id != Auth::user()->id)
		{
			$follow = AccountHasFollowers::where('account_id', $account->id)->where('follower_id', Auth::id())->first();
		}
		else
		{
			$follow = [];
		}

		switch ($contentType)
		{
			case 'events':
				$privacy = $account->eventsVisibility;

				if($account->id == Auth::id() || $privacy == 'public' || ($privacy == 'follower' && $follow->status == "accepted"))
				{
					$events = Event::all()->where('owner_id', auth()->user()->id)->where('isDeleted', '==', 0);

					return view('accounts.profile.events', compact('account','follow','events'));
				}
				else
				{
					return abort(403);
				}

				break;
			case 'participating':
				$privacy = $account->participatingVisibility;

				if($account->id == Auth::id() || $privacy == 'public' || ($privacy == 'follower' && $follow->status == "accepted"))
				{
					$events = array();
					$part = EventHasParticipants::get()->where('account_id', '==', $account->id);

					foreach($part as $par)
					{
						$event = Event::find($par->event_id);
						if($event->isDeleted == 0)
						{
							array_push($events, Event::find($par->event_id));
						}
					}

					return view('accounts.profile.participating', compact('account','follow','events'));
				}
				else
				{
					return abort(403);
				}
				break;
			case 'followers':
				$privacy = $account->followerVisibility;

				if($account->id == Auth::id() || $privacy == 'public' || ($privacy == 'follower' && $follow->status == "accepted"))
				{
					$followers = array();
					$get = AccountHasFollowers::get()->where('account_id', $account->id)->where('status', 'accepted');
					foreach($get as $fol)
					{
						array_push($followers, Account::find($fol->follower_id));
					}
					return view('accounts.profile.followers', compact('account','follow','followers'));
				}
				else
				{
					return abort(403);
				}
				break;
			case 'following':
				$privacy = $account->followingVisibility;

				if($account->id == Auth::id() || $privacy == 'public' || ($privacy == 'follower' && $follow->status == "accepted"))
				{
					$following = array();
					$get = AccountHasFollowers::get()->where('follower_id', $account->id)->where('status', 'accepted');
					foreach($get as $fol)
					{
						array_push($following, Account::find($fol->account_id));
					}
					return view('accounts.profile.following', compact('account','follow','following'));
				}
				else
				{
					return abort(403);
				}
				break;
			case 'info':
				$stats = array(0,0,0,0);

				$stats[0] = sizeof(Event::get()->where('owner_id', '==', $account->id));
				$stats[1] = sizeof(EventHasParticipants::get()->where('account_id', '==', $account->id));
				$stats[2] = sizeof(AccountHasFollowers::get()->where('account_id', '==', $account->id)->where('status', '==', 'accepted'));
				$stats[3] = sizeof(AccountHasFollowers::get()->where('follower_id', '==', $account->id)->where('status', '==', 'accepted'));

				return view('accounts.profile.info', compact('account','follow','stats'));
				break;
			default:
			return redirect('/account/'.$id.'/profile/info');
		}
	}

	public function create()
	{
		$genders = \App\Gender::all();

		return view('auth.register')->with('genders', $genders);
	}

	public function edit()
	{
		$genders = Gender::all();
		$account = Account::where('id', Auth::id())->firstOrFail();

		return view('accounts.profile.edit', compact(['account', 'genders']));
	}

	public function changePassword(ChangePasswordRequest $request)
	{
		$validated = $request->validated();

		$account = Account::where('id', Auth::id())->firstOrFail();
		$account->password = Hash::make($validated['newPassword']);
		$account->save();

		return redirect('/profile/edit');
	}

	public function activate() {
		return redirect('/')->with('activationsuccess', __('accounts.activation_message'));
	}

	public function updateProfile(EditProfileRequest $request)
	{
		$account = Account::where('id', Auth::id())->firstOrFail();

		if($request['gender'] == "-")
		{
			$account->gender = null;
		}
		else
		{
			$account->gender = $request['gender'];
		}

		$account->email = $request['email'];
		$account->firstName = $request['firstName'];
		$account->middleName = $request['middleName'];
		$account->lastName = $request['lastName'];
		$account->dateOfBirth = $request['dateOfBirth'];

		$account->save();

		return redirect('/profile/edit');
	}

	public function updatePrivacySettings(EditPrivacySettingsRequest $request)
	{
		$account = Account::where('id', Auth::id())->firstOrFail();

		$account->followerVisibility = $request['followerVisibility'];
		$account->followingVisibility = $request['followingVisibility'];
		$account->infoVisibility = $request['infoVisibility'];
		$account->eventsVisibility = $request['eventsVisibility'];
		$account->participatingVisibility = $request['participatingVisibility'];

        $account->save();

        return redirect('/profile/edit');
    }

    public function updateAvatar(EditAvatarRequest $request){
        $file = $request->file('avatar');
        $image = $file->openFile()->fread($file->getSize());

        $account = Account::where('id', $request['accountId'])->firstOrFail();
        $account->avatar = $image;
        $account->save();

		return redirect('/profile/edit');
	}

	public function deleteAccount(){

		$ID = Auth::user()->id;
		Auth::logout();

		$this->deleteAccountFromId($ID);

		return redirect('/');
	}

	public static function deleteAccountFromId($id)
	{
		$account = Account::where('id', $id)->firstOrFail();

		$account->email = $id;
		$account->password = '';
		$account->firstname = encrypt('Anonymous');
		$account->middlename = encrypt(null);
		$account->lastname = encrypt(null);
		$account->avatar = null;
		$account->isDeleted = 1;
		$account->bio = null;
		$account->remember_token = null;
		$account->doForceLogout = 1;

		$account->save();
	}
	public function follow($id) {
		if($id == Auth::id()) {
			return redirect('/');
		}
		else {
			$account = Account::where('id', $id)->first();
            if(! $account->blockedUsers->pluck('blockedAccount_id')->contains(Auth::id())) {
                try {
                    $followRequest = "";
                    $followRequest2 = AccountHasFollowers::where('account_id', $id)->where('follower_id', Auth::id())->first();
                    if ($followRequest2 == null) {
                        $followRequest = AccountHasFollowers::create([
                            'account_id' => $id,
                            'follower_id' => Auth::id(),
                            'verification_string' => Str::random(32)
                        ]);
                    } else {

                        $followRequest2->status = 'pending';
                        $followRequest2->touch();
                        $followRequest2->save();
                        $followRequest = $followRequest2;
                    }
                } catch (\Exception $exception) {

                    return back()->withError($exception->getMessage());
                }
                Mail::to($account->email)->send(new FollowMail(Auth::user(),$followRequest));
            }

		}

		return back();
	}
	public function accept($id) {
		$followRequest = AccountHasFollowers::where('verification_string', $id)->first();
        $text = "No reqeust found";
		if(!is_null($followRequest)) {
			if($followRequest->status == 'pending') {
				$followRequest->status = 'accepted';
				$followRequest->save();
                $text = Lang::get('welcome.accepted_follow_request');
			}else if($followRequest->status == 'accepted'){
                $text = Lang::get('welcome.already_accepted_follow_request');
            }else if($followRequest->status == 'rejected'){
                $text = Lang::get('welcome.already_denied_follow_request');
            }
            $account = Account::where('id',$followRequest->account_id)->first();
            self::switchLang($account);

		}

		return redirect('/')->with('alert', $text);
	}

    public function decline($id) {
        $followRequest = AccountHasFollowers::where('verification_string', $id)->first();
        $text = "No request found";
        if(!is_null($followRequest)) {
            if($followRequest->status == 'pending') {
                $followRequest->status = 'rejected';
                $followRequest->save();
                $text = Lang::get('welcome.denied_follow_request');
            }else if($followRequest->status == 'accepted'){
                $text = Lang::get('welcome.already_accepted_follow_request');
            }else if($followRequest->status == 'rejected'){
                $text = Lang::get('welcome.already_denied_follow_request');
            }
            $account = Account::where('id',$followRequest->account_id)->first();
            self::switchLang($account);

        }

        return redirect('/')->with('alert', $text);
    }
    private function switchLang($user){
        switch($user->settings->LanguagePreference){
            case 'eng': App::setLocale('eng');
                break;
            case 'nl': App::setLocale('nl');
                break;
            default: App::setLocale('eng');
                break;
        }
    }


    public function updateSettings(Request $request){
        if (Auth::check())
        {
            $validator = Validator::make($request->all(),
                [
                    'FollowNotificationCreateEvent' => 'nullable|string',
                    'FollowNotificationJoinAndLeaveEvent' => 'nullable|string',
                    'NotificationEventEdited' => 'nullable|string',
                    'NotificationEventDeleted' => 'nullable|string',
                    'NotificationJoinAndLeaveEvent' => 'nullable|string',
                ]);
            if ($validator->fails())
            {
                return redirect("")
                    ->withErrors($validator)
                    ->withInput();
            }

            $FollowNotificationCreateEvent = 0;
            if($request['FollowNotificationCreateEvent'] == "on")
            {
                $FollowNotificationCreateEvent = 1;
            }
            $FollowNotificationJoinAndLeaveEvent = 0;
            if($request['FollowNotificationJoinAndLeaveEvent'] == "on")
            {
                $FollowNotificationJoinAndLeaveEvent = 1;
            }
            $NotificationEventEdited = 0;
            if($request['NotificationEventEdited'] == "on")
            {
                $NotificationEventEdited = 1;
            }
            $NotificationEventDeleted = 0;
            if($request['NotificationEventDeleted'] == "on")
            {
                $NotificationEventDeleted = 1;
            }
            $NotificationJoinAndLeaveEvent = 0;
            if($request['NotificationJoinAndLeaveEvent'] == "on")
            {
                $NotificationJoinAndLeaveEvent = 1;
            }
            $accountSettings = AccountSettings::where('account_id', Auth::id())->firstorfail();

            $accountSettings->update(
                [
                    'FollowNotificationCreateEvent' => $FollowNotificationCreateEvent,
                    'FollowNotificationJoinAndLeaveEvent' => $FollowNotificationJoinAndLeaveEvent,
                    'NotificationEventEdited' => $NotificationEventEdited,
                    'NotificationEventDeleted' => $NotificationEventDeleted,
                    'NotificationJoinAndLeaveEvent' => $NotificationJoinAndLeaveEvent,
                ]
            );
            return back();
        }
    }


	public function unfollow($id) {
		$unfollowRequest = AccountHasFollowers::where('account_id', $id)->where('follower_id', Auth::id())->first();
		$unfollowRequest->delete();

		return back();
	}

	public function blockAccount(Request $request){
		$request->validate([
			'id' => 'required',
		]);
		if(Auth::id()!=$request['id']){

			if(Auth::user()->followers->pluck('id')->contains($request->id)){
				AccountHasFollowers::where('account_id', '=', Auth::id())->where('follower_id', '=', $request->id)->delete();
			}

			if(Auth::user()->following->pluck('id')->contains($request->id)){
				AccountHasFollowers::where('follower_id', '=', Auth::id())->where('account_id', '=', $request->id)->delete();
			}

			BlockedUser::create([
				'account_id' => Auth::id(),
				'blockedAccount_id' => $request->id,
			]);
			return back();
		}
		return abort(404);
	}

	public function unblockAccount(Request $request){
		$request->validate([
			'id' => 'required',
		]);
		if(Auth::id()!=$request['id']){
			BlockedUser::where('account_id','=',Auth::id())->where('blockedAccount_id','=',$request->id)->firstOrFail()->delete();
			return back();
		}
		return abort(404);
	}

	public function setMailLanguage(Request $request){
	    if (Auth::check())
        {
            $validator = Validator::make($request->all(),
                [
                    'LanguagePreference' => 'required|string',
                ]);
            if ($validator->fails())
            {
                return redirect("")
                    ->withErrors($validator)
                    ->withInput();
            }
            $lang = '';
            switch($request['LanguagePreference']){
                case 'English': $lang = 'eng';
                break;
                case 'Dutch': $lang = 'nl';
                break;
                default:$lang = 'eng';
                break;
            }
            $accountSettings = AccountSettings::where('account_id', Auth::id())->firstorfail();
            $accountSettings->update(
                [
                    'LanguagePreference' => $lang
                ]
            );
            return back();
        }
    }
}
