@extends('/layouts/public_profile')

@section('profilecontent')
<div class="row">
	@if($account->id == Auth::id() || $account->eventsVisibility == 'public' || ($account->eventsVisibility == 'follower' && $follow->status == "accepted"))

		<div class="col">
			<h3>{{__('profile.head_info')}}</h3>
			<p>
				{{__('profile.info_name')}}: {{ $account->firstName }} {{ $account->middleName }} {{ $account->lastName }}<br>
				{{__('profile.info_rol')}}: {{ $account->accountRole }}
			</p>
		</div>
		<div class="col">
			<h3>{{__('profile.info_stats')}}</h3>
			<p>
				{{__('profile.info_hosted')}}: {{ $stats[0] }}<br>
				{{__('profile.info_participated')}}: {{ $stats[1] }}<br>
				{{__('profile.head_followers')}}: {{ $stats[2] }}<br>
				{{__('profile.head_following')}}: {{ $stats[3] }}
			</p>
		</div>
	@else
		<div class="col">
			<h3>{{__('profile.head_hidden')}}</h3>
		</div>
	@endif
</div>
@endsection