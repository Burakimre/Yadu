@extends('layouts/app_blank')


@section('content')
@section('main')
    @if (session('alert'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('alert') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    {{-- Carousel --}}
	<div id="welcome_carousel">
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				@foreach($events as $event)
				@if ($loop->first)
						<li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="active"></li>	
					@else
						<li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"></li>
					@endif
				@endforeach
			</ol>
			<div class="carousel-inner">
				@foreach($events as $event)
					@if ($loop->first)
						<div class="carousel-item active">	
					@else
						<div class="carousel-item">
					@endif		
							<div class="carousel_img_container">
								<img class="d-block w-100" src="data:image/png;base64,{{ chunk_split(base64_encode($event->eventPicture->picture)) }}" alt="First slide">
							</div>
							<div class="carousel-caption d-md-block">
								<h5>{{ $event->eventName }}</h5>
								<p>{{ $event->description }}</p>
								<h6>{{ $event->city }} {{ $event->writtenDate }}</h6>
								<a href="/events/{{ $event->id }}">{{ __('welcome.link_read_more') }}...</a>
							</div>
						</div>
				@endforeach
			</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">{{ __('welcome.carousel_prev') }}</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">{{ __('welcome.carousel_next') }}</span>
			</a>
		</div>
	</div>
	<div class="container" id="welcome_info">
		<h1>{{ __('welcome.welcome_header') }}</h1>
		<h4>{{ __('welcome.welcome_content1') }}</h4>
		<p>
			{{ __('welcome.welcome_content2') }}
		</p>
		<a href="/about">{{ __('welcome.link_read_more') }}...</a>
	</div>
    {{-- Highlighted events --}}
    <div class="container" id="welcome_recent">
        <a href="/events" class="recentEventsHome">
            <h2>{{ __('welcome.recent_events_header') }}</h2>
        </a>
        <div id="#eventsToDisplay" class="event_overview row">
            <?php $plus = 0; ?>
            @foreach($regular_events as $event)
                <div class='col-md-6 col-lg-4 event'>
                    <a href='/events/{{ $event->id }}'>
                        @if( $event->startDate > \Carbon\Carbon::now())
                            <div class='card mb-4 box-shadow'>
                        @else
                            <div class='card mb-4 box-shadow greyified'>
                        @endif
                                <img class='card-img-top'
                                     src="data:image/png;base64,{{ chunk_split(base64_encode($event->eventPicture->picture)) }}"
                                     alt='Card image cap'>
                                <div class='event_info'>
                                    <h3>{{ str_limit($event->eventName, $limit = 25, $end = '...') }}</h3>
                                    <p>{{ $event->writtenDate }}<br>{{ $event->city }}</p>
                                </div>
                            </div>
                    </a>
                </div>
                <?php $plus = $plus + 1 ?>
            @endforeach
            @if($plus < 3)
                <div class='col-md-6 col-lg-4 event'>
                    <a href="/events/create">
                        <div class='card mb-4 box-shadow'>
                            <img class='card-img-top' src="/images/plus.png" alt='Card image cap'>
                            <div class='event_info'>
                                <h3>{{ __('welcome.recent_events_own') }}</h3>
                                <p><br><br></p>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
        <p>{{ __('welcome.recent_events_content') }}
            <a href="/events">{{ __('welcome.link_here') }}</a>.
        </p>
        <div class="row">
            <div class="col testimonial">
                <hr>
                <h3 class="text-center"><i>&quot{{$testimonial->experience}}&quot</i></h3>
                <h5 class="text-center mb-3">-{{$testimonial->name}}</h5>
            </div>
        </div>
    </div>
@endsection
