@extends('/layouts/public_profile')

@section('profilecontent')
<div class="row">
	<div class="col">
		<h3>{{__('profile.info_participated_in')}}</h3>

		<div class="row">
			<div class="col">
				<table class="table table-hover">
					<thead>
					<tr>
						<th scope="col">{{__('home.participating_table_colname_name')}}</th>
						<th scope="col">{{__('home.participating_table_colname_owner')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach( $events as $event)
						<tr>
							<td><a href="/events/{{$event->id}}">{{ $event->eventName }}</a></td>
							<td>{{ $event->owner->firstName }} {{ $event->owner->middleName }} {{ $event->owner->lastName }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection