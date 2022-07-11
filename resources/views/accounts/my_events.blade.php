@extends('/layouts/app')

@section('content')
	<div class="col">
		<div class="backlink">
			<a href="/home"><i class="fas fa-arrow-left"></i> {{__('home.link_dashboard')}}</a>
		</div>
		@if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{{ $message }}&nbsp;</strong>
            </div>
		@endif
		<div class="card">
			<div class="card-header"><i class="fas fa-calendar-alt"></i> {{__('home.my_events_title')}}</div>
			<div class="card-body">
				<table class="table table-hover">
					<thead>
					<tr>
						<th scope="col">{{__('home.participating_table_colname_name')}}</th>
						<th scope="col">{{__('home.participating_table_colname_date')}}</th>
						<th scope="col">{{__('home.participating_table_colname_location')}}</th>
						<th scope="col"></th>
					</tr>
					</thead>
					<tbody>
					@foreach($events as $event)
						<tr>
							<td><a href="/events/{{$event->id}}">{{ $event->eventName }}</a></td>
							<td>{{ $event->date }}</td>
							<td>{{ $event->location->postalcode }} {{ $event->city }}</td>
							<td>
								@if($event->startDate > date('Y-m-d H:i:s'))
									<a class="editButton" href="/events/{{$event->id}}/edit"><i class="fas fa-edit"></i></a>
									<button type="submit" class="deleteButton" data-toggle="modal" data-target="#confirmDeleteEvent{{$event->id}}"><i class="fas fa-trash-alt"></i></button>
									<div class="modal fade" id="confirmDeleteEvent{{$event->id}}" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">{{__('accounts.edit_delete_account_confirm_title')}}</h5>
													<button type="button" class="close" data-dismiss="modal"
															aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													{{__('accounts.edit_delete_event_confirm_content')}}
												</div>
												<div class="modal-footer">
													<form id="deleteEvent{{$event->id}}" method="POST" action="/events/{{$event->id}}">
													@method('DELETE')
													@csrf
														<button type="submit" class="btn btn-danger" form="deleteEvent{{$event->id}}">{{__('accounts.edit_delete_event_positive')}}</button>
														<button type="button" class="btn btn-primary" data-dismiss="modal">{{__('accounts.edit_delete_event_negative')}}</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								@endif
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
