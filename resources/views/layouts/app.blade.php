@extends('layouts/app_blank')

@section('main')
	<div id="body" class="container">
		@yield('content')
		@yield('scripts')
	</div>
@endsection