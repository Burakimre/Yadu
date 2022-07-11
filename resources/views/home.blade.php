@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<a href="/account/participating"><i class="fas fa-calendar-alt"></i> {{__('home.participating_title')}}</a>
				</div>
				<div class="card-body">
					<table class="table table-hover">
						<thead>
						<tr>
							<th scope="col">{{__('home.participating_table_colname_name')}}</th>
							<th scope="col">{{__('home.participating_table_colname_owner')}}</th>
							<th scope="col">{{__('home.participating_table_colname_date')}}</th>
							<th scope="col">{{__('home.participating_table_colname_location')}}</th>
						</tr>
						</thead>
						<tbody>
						@foreach($participation as $par)
							<tr>
								<td><a href="/events/{{$par->id}}">{{ $par->eventName }}</a></td>
								<td>{{ $par->owner->firstName }} {{ $par->owner->middleName }} {{ $par->owner->lastName }}</td>
								<td>{{ $par->date }}</td>
								<td>{{ $par->location->postalcode }} {{ $par->city }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<a href="/account/{{  Auth::user()->id }}/profile/info"><i class="fas fa-user"></i> {{__('home.user_title')}}</a>
				</div>
				<div class="card-body">
					@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}
						</div>
					@endif
					<div id="user_avatar">
						<img src="data:image/png;base64,{{ chunk_split(base64_encode(Auth::user()->avatar)) }}">
					</div>
					<h3>
						<a href="/account/{{  Auth::user()->id }}/profile/info">{{ Auth::user()->firstName }} {{ Auth::user()->middleName }} {{ Auth::user()->lastName }}</a>
					</h3>
					<div>
						<a href="/profile/edit"><i class="fas fa-user-cog"></i> {{__('home.user_link_settings')}}</a>
					</div>
					@if(Auth::user()->accountRole == 'Admin')
					<div>
						<a href="/admin"><i class="fas fa-user-shield"></i> admin</a>
					</div>
					@endif
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<a href="/account/myevents"><i class="fas fa-calendar-alt"></i> {{__('home.my_events_title')}}</a>
					<div class="CSH_tooltip right">
						<a href="/events/create"><i class="fas fa-plus-square"></i></a>
						<span class="tooltiptext">{{__('events.index_create_event')}}</span>
					</div>
				</div>
				<div class="card-body">
					@if($events)
						@foreach($events as $event)
							<div class="dashboard_event">
								<a href="/events/{{ $event->id }}">
									<img class="card-img-top" src="data:image/png;base64,{{ chunk_split(base64_encode($event->eventPicture->picture)) }}">
									<div class="dashboard_event_info">
										<h3>{{ str_limit($event->eventName, $limit = 8, $end = '...') }}</h3>
										<p>{{ $event->date }}</p>
									</div>
								</a>
							</div>
							<hr>
						@endforeach
					@else
						{{ __('home.my_events_no_events') }}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
