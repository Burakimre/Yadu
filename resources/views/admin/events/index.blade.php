@extends('layouts/admin/app')

@section('custom_css')
	<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
	<link rel="stylesheet" href="{{ asset('css/filterCSS.css') }}">
@endsection

@section('custom_script')
	<script type="text/javascript" src="/js/admin_event_filter.js" defer></script>
@endsection
@section('content')

	<div class="card">
		<div class="card-header">
			<div class="search">
			<div>
				<label for="filterByTag">{{__('events.index_select_category')}}</label>
				<input class="admin-form-control" oninput="fetch_events()" list="tags" id="filterByTag" name="filterByTag" placeholder="{{__('events.index_search_category_placeholder')}}"/>
				<datalist id="tags">
					@foreach ($tags as $tag)
						<option value="{{$tag->tag}}">
					@endforeach
				</datalist>
			</div>
			<div>
				<label for="filterByName">{{__('events.index_search_name')}}</label>
				<input class="admin-form-control" oninput="fetch_events()" list="names" id="filterByName" name="filterByName" placeholder="{{__('events.index_search_placeholder')}}" autocomplete="off"/>
			</div>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-hover">
				<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col"></th>
					<th scope="col">ID</th>
					<th scope="col">{{__('events.show_category')}}</th>
					<th scope="col">{{__('events.show_title')}}</th>
					<th scope="col">{{__('events.show_initiator')}}</th>
					<th scope="col">{{__('events.show_date')}}</th>
					<th scope="col">{{__('events.show_location')}}</th>
					<th scope="col">{{__('events.show_attendees_amount')}}</th>
					<th scope="col"></th>
					<th scope="col"></th>
					<th scope="col"></th>
				</tr>
				</thead>
				<tbody id="eventsToDisplay">
					@foreach($events as $event)
					<tr>
						<td>
							@if(  $event->isHighlighted == 1)
								<i class="fas fa-star star"></i>
							@endif
						</td>
						<td>
							@php
								$startDate = date('Y-m-d', strtotime( $event->startDate ));
								$currentDate = date('Y-m-d', strtotime( $event->currentDate ));
							@endphp

							@if($startDate == $currentDate)
								<i class="fas fa-hourglass-half Hourglass_busy"></i>
							@elseif($startDate < $currentDate)
								<i class="fas fa-hourglass-end Hourglass_after"></i>
							@else
								<i class="fas fa-hourglass-start Hourglass_before"></i>
							@endif
						</td>
						<td>{{ $event->id}}</td>
						<td>{{ $event->tag->tag }}</td>
						<td>{{ $event->eventName}}</td>
						<td>{{ $event->owner->firstName }} {{ $event->owner->middleName }} {{ $event->owner->lastName }}</td>
						<td>{{ \Carbon\Carbon::parse($event->startDate)->format(__('formats.dateTimeFormat'))}}</td>
						<td>{{ $event->location->postalcode }} - {{ $event->city }}</td>
						<td>{{$event->participants->count()}}/{{$event->numberOfPeople}}</td>
						<td><a href="/events/{{$event->id}}" class="button-show button-hover">{{__('events.show')}}</a></td>
						<td><a href="/admin/events/{{$event->id}}/edit" class="button button-hover">{{__('events.show_edit')}}</a></td>
						<td>
							<form class="form_submit_ays" method="POST" id="deleteAccount{{$event->id}}" action="/admin/events/{{$event->id}}">
								@method('DELETE')
								@csrf
								<div>
									<div >
										<button type="button" class="button-remove button-hover" data-toggle="modal" data-target="#confirmDeleteAccount{{$event->id}}">{{__('events.show_delete')}}</button>

									</div>

									<div class="modal fade" id="confirmDeleteAccount{{$event->id}}" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">{{__('events.title_confirm')}}</h5>
													<button type="button" class="close" data-dismiss="modal"
															aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													{{__('events.confirm_text')}}
												</div>
												<div class="modal-footer">
													<input type="submit" form="deleteAccount{{$event->id}}" class="btn btn-danger"
														   value="{{__('events.confirm_delete')}}">
													<button type="button" class="btn btn-primary"
															data-dismiss="modal">{{__('events.dismiss_delete')}}
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</td>
					</tr>

				@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<script type="text/javascript">
		//AJAX request
		function fetch_events() {
			$('#eventsToDisplay').html("<img class='loadingSpinner' src='images/Spinner-1s-200px.gif'>");
			//var distance;
			//distance = $("#rangeValue").val();
			var inputTag = $(filterByTag).val();
			var inputName = $(filterByName).val();
			$.ajax({
				url: "{{ route('admin_events_controller.actionDistanceFilter')}}",
				method: 'POST',
				data: {
					distance: 25,
					inputTag: inputTag,
					inputName: inputName,
					_token: '{{ csrf_token() }}'
				},
				dataType: 'json',
				success: function (data) {

					if (data == "") {
						$('#eventsToDisplay').html("<tr>{{__('events.index_no_event_found')}}</tr>");
					} else {
						$('#eventsToDisplay').html("");
						data.forEach(function (element)
						{
							var highlighted = ""
							if(element['isHighlighted'] == 1){
								highlighted = '<i class="fas fa-star star"></i>';
							}
							var timeIcon = ""
							if(element['dateInt'] == 0){
								timeIcon = '<i class="fas fa-hourglass-half Hourglass_busy"></i>';
							}else if(element['dateInt'] ==1){
								timeIcon = '<i class="fas fa-hourglass-end Hourglass_after"></i>';
							}else{
								timeIcon = '<i class="fas fa-hourglass-start Hourglass_before"></i>';
							}

							var middleName = ""
							if(element['owner_middleName'] != null){
								middleName = element['owner_middleName'] + " ";
							}

							
							$('#eventsToDisplay').html($("#eventsToDisplay").html()+
									"<tr><td>"+ highlighted +"</td>" +
									"<td>"+ timeIcon +"</td>" +
									"<td>"+ element['id'] + "</td>" +
									"<td>"+ element['tag'] + "</td>" +
									"<td>"+ element['eventName'] + "</td>" +
									"<td>"+ element['owner_firstName'] + " "+ middleName +element['owner_lastName'] + "</td>" +
									"<td>"+ element['user_date'] + "</td>" +
									"<td>"+ element['location']['postalcode'] + " - " + element['loc'] + "</td>" +
									"<td>"+element['participants_ammount'] +  "/" + element['numberOfPeople'] + "</td>" +
									"<td><a href='/events/"+ element['id']+"' class='button-show button-hover'>{{__('events.show')}}</a></td>" +
									"<td><a href='/admin/events/"+ element['id']+"/edit'class='button button-hover'>{{__('events.show_edit')}}</a></td>" +
									"<td>" +
									"<form class='form_submit_ays' method='POST' id='deleteAccount' action='/admin/events/" + element['id'] + "'>" +
									'@method('DELETE')' + 
									'@csrf' + 
									"<div>" + 
										"<div class='col-md-4'>" + 
											"<button type='button' class='button-remove button-hover' data-toggle='modal' data-target='#confirmDeleteAccount'>{{__('events.show_delete')}}</button>" + 
										"</div>" +
										"<div class='modal fade' id='confirmDeleteAccount' tabindex='-1' role='dialog'><div class='modal-dialog' role='document'>" + 
											"<div class='modal-content'>" + 
												"<div class='modal-header'>" + 
													"<h5 class='modal-title'>{{__('events.title_confirm')}}</h5>" +
														"<button type='button' class='close' data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
													"</div><div class='modal-body'>{{__('events.confirm_text')}}</div>" +
													"<div class='modal-footer'>" + 
														"<input type='submit' form='deleteAccount' class='btn btn-danger'value='{{__('events.confirm_delete')}}'><button type='button' class='btn btn-primary'data-dismiss='modal'>{{__('events.dismiss_delete')}}</button>" + 
														"</div>" + 
													"</div>" + 
												"</div>" + 
											"</div>" + 
										"</div>" + 
									"</form>" + 
									"</td></tr>")
						});
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					$('#eventsToDisplay').html(
						"<div style='text-align:center; width:100%; padding-top:50px;'><h1>{{__('events.index_loading_error')}}</h1><div>"
					);
				}
			})

		}
	</script>

@endsection