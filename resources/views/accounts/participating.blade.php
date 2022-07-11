@extends('/layouts/app')

@section('content')
	<div class="col">
		<div class="backlink">
			<a href="/home"><i class="fas fa-arrow-left"></i> {{__('home.link_dashboard')}}</a>
		</div>
		<div class="card">
			<div class="card-header"><i class="fas fa-calendar-alt"></i> {{__('home.participating_title')}}</div>
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
					@foreach($events as $event)
						<tr>
							<td><a href="/events/{{$event->id}}">{{ $event->eventName }}</a></td>
							<td>{{ $event->owner->firstName }}</td>
							<td>{{ $event->date }}</td>
							<td>{{ $event->location->postalcode }} {{ $event->city }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
