@extends('layouts/app')

@section('custom_script')

@endsection

@section('content')
<div class="row">
	<div class="col">
		<h1>{{$event->eventName}}</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div>
			<img class="img-fluid w-100 rounded event_img mb-3" src="data:image/jpeg;base64, {{base64_encode($event->eventPicture->picture)}}" /><br>
		</div>
		<div class="row">
			<div class="col">
				<h3>{{__('events.show_initiator')}}</h3>
				@if($event->owner_id)
				<div class="row my-1">
					<a href="/account/{{$event->owner->id}}/profile/info">
						<img class="img-fluid rounded-circle my-auto avatar" src="data:image/jpeg;base64, {{base64_encode($event->owner->avatar)}}" />
					</a>
					<h5 class="my-auto ml-2"><a href="/account/{{$event->owner->id}}/profile/info">{{$event->owner->firstName .' '. $event->owner->middleName .' '. $event->owner->lastName}}</a></h5>
				</div>
				@else
				<div class="row my-1">
					<h5 class="my-auto ml-2">{{__('events.show_no_initiator')}}</h5>
				</div>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col">
				<h3>{{__('events.show_attendees')}}</h3>
				<div class="row">
					<div class="col">
						@if(Auth::check())
						@if($event->owner_id != null)
						@if($event->owner->id != auth()->user()->id)
						@if($event->participants->contains(auth()->user()->id))
						<a href="/events/{{$event->id}}/leave" class="btn btn-danger btn-sm my-auto mx-2">{{__('events.show_leave')}}</a>
						@elseif($event->participants->count()+1 < $event->numberOfPeople)
							<a href="/events/{{$event->id}}/join" class="btn btn-success btn-sm my-auto mx-2">{{__('events.show_join')}}</a>
							@endif
							@endif
							@else
							<a href="/events/{{$event->id}}/join" class="btn btn-success btn-sm my-auto mx-2">{{__('events.show_join')}}</a>
							@endif
							@endif
					</div>
					<div class="col">
						@if($event->owner_id)
						<p class="text-md-right">{{__('events.show_number_of_attendees', ['amount' => $event->participants->count()+1, 'max' => $event->numberOfPeople])}}</p>
						@else
						<p class="text-md-right">{{__('events.show_number_of_attendees', ['amount' => $event->participants->count(), 'max' => $event->numberOfPeople])}}</p>
						@endif
					</div>
				</div>
				<div class="progress">
					@if($event->owner_id)
					<div class="progress-bar" role="progressbar" style="width: {{($event->participants->count()+1) / $event->numberOfPeople * 100}}%" aria-valuemin="0" aria-valuenow="{{$event->participants->count()+1}}" aria-valuemax="{{$event->numberOfPeople}}">
					</div>
					@else
					<div class="progress-bar" role="progressbar" style="width: {{($event->participants->count()) / $event->numberOfPeople * 100}}%" aria-valuemin="0" aria-valuenow="{{$event->participants->count()}}" aria-valuemax="{{$event->numberOfPeople}}">
					</div>
					@endif
				</div>
				@foreach($event->participants as $participant)
				<div class="row my-1">
					<a href="/account/{{$participant->id}}/profile/info">
						<img class="img-fluid rounded-circle my-auto avatar" src="data:image/jpeg;base64, {{base64_encode($participant->avatar)}}" />
					</a>
					<p>
						<h5 class="my-auto ml-2">
							<a href="/account/{{$participant->id}}/profile/info">{{$participant->firstName .' '. $participant->middleName .' '. $participant->lastName}}</a>
						</h5>
					</p>

				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div id="map" class="rounded event_map"></div>
		<script>
			var map;

			function initMap() {
				map = new google.maps.Map(document.getElementById('map'), {
					center: {
						lat: {{$event->location()->first()->locLatitude}}, 
						lng: {{$event->location()->first()->locLongtitude}}
					},
					zoom: 12
				});

				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(
						{{$event->location()->first()->locLatitude}}, 
						{{$event->location()->first()->locLongtitude}}),
					map: map,
					title: '{{$event->eventName}}'
				});

			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&callback=initMap" async defer></script>
		<div class="mb-5">
			<div class="row">
				<div class="col-5">
					<h3>{{__('events.show_postalcode')}}</h3>
				</div>
				<div class="col-7">
					<h5>{{$event->location()->first()->postalcode}}</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<h3>{{__('events.show_city')}}</h3>
				</div>
				<div class="col-7">
					<h5>{{$event->location()->first()->locality}}</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<h3>{{__('events.show_adres')}}</h3>
				</div>
				<div class="col-7">
					<h5>{{$event->location()->first()->route}} {{$event->location()->first()->houseNumber}}{{$event->location()->first()->houseNumberAddition}}</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<h3>{{__('events.show_date')}}</h3>
				</div>
				<div class="col-7">
					@php($timestamp = strtotime($event->startDate))
					<h5>{{$event->writtenDate}} {{__('events.show_datetime_at')}} {{date(__('formats.timeFormat'), $timestamp)}}</h5>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h3>{{__('events.show_description')}}</h3>
					<p>{{$event->description}}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				{{--Start section Share buttons--}}
				<div class="mb-5">
					<h3>{{__('events.show_share')}}</h3>
					<div>
						<a id="share-whatsapp" class="fab fa-whatsapp event-media-icons"></a>
						<a id="share-facebook" class="fab fa-facebook event-media-icons"></a>
						<a id="share-twitter" class="fab fa-twitter event-media-icons"></a>
						<a id="share-link" class="fa fa-link event-media-icons" data-toggle="modal" data-target="#confirmDeleteAccount"></a>
						<script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
						<div title="Add to Calendar" class="addeventatc addevent">
							{{__('events.add_to_calendar')}}
							<span class="start">{{date('m/d/Y h:i A', strtotime($event->startDate))}}</span>
							<span class="end">{{date('m/d/Y h:i A', strtotime($event->startDate))}}</span>
							<span class="timezone">Europe/Amsterdam</span>
							<span class="title">{{$event->eventName}}</span>
							<span class="description">{{$event->description}}</span>
							<span class="location">{{ $event->location()->first()->route }} {{ $event->location()->first()->houseNumber }}, {{ $event->location()->first()->locality }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="confirmDeleteAccount" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{__('events.show_share_link')}}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<a id="page-url"></a>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{{__('events.show_share_close')}}
						</button>
					</div>
				</div>
			</div>
		</div>


		<script>
			function LogEventShared(platform) {
				$.ajax({
					url: "{{route('LogEventShared')}}",
					method: 'POST',
					data: {
						eventid: "{{$event->id}}",
						platform: platform,
						_token: '{{ csrf_token() }}'
					},
					dataType: 'json',
				});
			}

			document.getElementById("share-link").addEventListener('click', function() {
				LogEventShared("link");
				let clipboard = document.createElement('input'),
					url = window.location.href;

				document.body.appendChild(clipboard);
				clipboard.value = url;
				clipboard.select();
				document.execCommand('copy');
				document.body.removeChild(clipboard);

				document.getElementById("page-url").innerHTML = url;
			});

			document.getElementById("share-facebook").addEventListener('click', function() {
				LogEventShared("facebook");
				let url = `https://www.facebook.com/sharer/sharer.php?u=${window.location.href}`;
				window.open(url, 'popUpWindow', 'height=500,width=700,left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

			});

			document.getElementById("share-twitter").addEventListener('click', function() {
				LogEventShared("twitter");
				let url = `https://twitter.com/intent/tweet?text={{$event->eventName}}: ${window.location.href} %23Yadu`;
				window.open(url, 'popUpWindow', 'height=500,width=700,left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
			});

			document.getElementById("share-whatsapp").addEventListener('click', function() {
				LogEventShared("whatsapp");
				let url = `https://wa.me/?text={{$event->eventName}}: ${window.location.href}`;
				window.open(url, 'popUpWindow', 'height=500,width=700,left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
			});
		</script>

		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v3.2"></script>
		{{--End section Share buttons--}}

	</div>
</div>
<div class="row">
	@if(Auth::check())
	@if((!empty($event->participants()->where('account_id', Auth::id())->first()) || !empty($event->owner_id == Auth::id())) || Auth::user()->accountRole == "Admin")
	<!-- BEGIN CHAT TEMPLATE -->
	<div id="app" class="message-container clearfix" v-if="account">

		<div class="chat">
			<div class="chat-header clearfix">
				<div class="chat-about">
					<h1 class="chat-with">Chat</h1>
				</div>
			</div>
			<!-- end chat-header -->

			<div id="chat" class="chat-history" v-chat-scroll>
				<ul>

					<li v-for="message in messages" v-bind:class="{'clearfix':(message.user_id !== {{ Auth::id() }})}">
						<div v-if="message.user_id === {{ Auth::id() }}">
							<div class="message-data">
								<span class="message-data-name"><i class="fa fa-circle online"></i> @{{ message.firstName + ' ' + message.lastName }}</span>
								<span class="message-data-time">@{{ message.created_at }}</span>
							</div>
							<div class="message my-message">
								@{{ message.body }}
							</div>
						</div>
						<div v-else-if="message.user_id !== {{ Auth::id() }}">
							<div class="message-data align-right">
								<span class="message-data-time">@{{ message.created_at }}</span>
								<span class="message-data-name"></i> @{{ message.firstName + ' ' + message.lastName }}</span> <i class="fa fa-circle me"></i>
							</div>
							<div class="message other-message float-right">
								@{{ message.body }}
							</div>
						</div>
					</li>

				</ul>

			</div>
			<!-- end chat-history -->

			<div class="chat-message clearfix">
				<textarea name="message-to-send" id="message-to-send" placeholder="{{ __('events.show_chat_typemessage') }}" rows="3" v-model.trim="messageBox" v-on:keyup.enter="postMessage" required></textarea>

				<button id="sendButton" @click.prevent="postMessage">{{ __('events.show_chat_send') }}</button>

			</div>
			<!-- end chat-message -->

		</div>
		<!-- end chat -->

	</div>
	<!-- end container -->

	<!-- END CHAT TEMPLATE -->
	@endif
	@else
	<div class="col-md-6">
		<h3 style="margin-top:30px;">
			{{__('events.show_chat_login')}}
		</h3>
	</div>
	@endif
</div>

@endsection
@if(Auth::check())
@if((!empty($event->participants()->where('account_id', Auth::id())->first()) || !empty($event->owner_id == Auth::id())) || Auth::user()->accountRole == "Admin")
@section('scripts')
<script>
	let warning = document.createElement("strong");
	warning.style.color = "red";
	warning.innerHTML = "{{ __('events.show_chat_swearword') }}";

	function insertAfter(referenceNode, newNode) {
		referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
	}

	const app = new Vue({
		el: '#app',
		data: {
			messages: {},
			messageBox: '',
			event: {!!json_encode($event->getAttributes())!!},
			account: {!!Auth::check() ? json_encode(Auth::user()->only(['id', 'firstName', 'lastName', 'api_token'])) : 'null'!!}
		},
		mounted() {
			console.log("test");
			this.getMessages();
			this.listen();
		},
		methods: {
			getMessages() {
				axios.get(`/api/events/${this.event.id}/messages`)
					.then((response) => {
						this.messages = response.data
					})
					.catch(function(error) {
						console.log(error);
					});
			},
			postMessage() {
				let btn = $("#sendButton");
				setTimeout(function() {
					btn.prop('disabled', true);
					setTimeout(function() {
						btn.prop('disabled', false);
					}, 1000);
				})
				if (this.timer) {
                        clearTimeout(this.timer);
                        this.timer = null;
                    }
                    this.timer = setTimeout(() => {
				axios.post(`/api/events/${this.event.id}/message`, {
						api_token: this.account.api_token,
						body: this.messageBox,
						id: this.account.id

					})
					.then((response) => {
						this.messageBox = '';
						warning.remove();
					})
					.catch((error) => {
                            if(error.response.data.errors.body[0] == 'body is not allowed because it contains a swearword.' || error.response.data.errors.body[0] == 'body is niet toegestaan omdat deze een scheldwoord bevat.') {
                                warning.innerHTML = "{{ __('events.show_chat_swearword') }}";
                            } else if(error.response.data.errors.body[0] == 'The body field is required.' || error.response.data.errors.body[0] == 'body is verplicht.') {
                                warning.innerHTML = "{{ __('events.show_chat_entertext') }}";
                            } else if(error.response.data.errors.body[0] == 'The body may not be greater than 180 characters.' || error.response.data.errors.body[0] == 'body mag niet uit meer dan 180 tekens bestaan.') {
                                warning.innerHTML = "{{ __('events.show_chat_characterlimit') }}";
                            }
							insertAfter(document.getElementById("message-to-send"), warning);
						});
                    }, 300);
		},
		listen() {
			Echo.private('event.' + this.event.id)
				.listen('NewMessage', (message) => {
					this.messages.push(message)
					 notifyMe('{{$event->eventName}}', message);
				})
		}
	}
	});

	// Disable newline on enter(except when holding shift)
	$('textarea').keydown(function(e) {
		if (e.keyCode == 13 && !e.shiftKey) {
			// prevent default behavior
			e.preventDefault();
		}
	});
</script>

<script>
                // request permission on page load
                document.addEventListener('DOMContentLoaded', function () {
                    if (!Notification) {
                        alert('Desktop notifications not available in your browser. Try Chromium.');
                        return;
                    }

                    if (Notification.permission !== 'granted')
                        Notification.requestPermission();
                });

                // Show notification
                function notifyMe(event, message) {
                    if (Notification.permission !== "granted")
                        Notification.requestPermission();
                    else {
                        let notification = new Notification(event, {
                            icon: `{{ asset('images/logoCircle.png')}}`,
                            body: `${message.firstName} ${message.lastName}: ${message.body}`,
                        });

                        // open link by clicking notification
                        notification.onclick = function () {
                            window.open(window.location.href);
                        };
                    }
                }
            </script>
@endsection
@endif
@endif