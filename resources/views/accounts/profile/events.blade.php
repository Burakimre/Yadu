@extends('/layouts/public_profile')

@section('profilecontent')
<div class="row">
	<div class="col">
		<h3>{{__('profile.info_hosted_by')}} {{ $account->firstName }}</h3>
		<div class="row">
			<div class="col">
				<table class="table table-hover">
					<thead>
					<tr>
						<th scope="col">{{__('home.participating_table_colname_name')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach( $events as $event)
						<tr>
							<td><a href="/events/{{$event->id}}">{{ $event->eventName }}</a></td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection