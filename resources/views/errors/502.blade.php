@extends('layouts/app')

@section('content')
	<div id="http_error">
		<h1>502 :(</h1>
		<div>
			<h2>{{ $exception->getMessage() }}</h2>
			<p>{{__('httperror.502')}}</p>
			<a href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> {{__('httperror.back')}}</a>
		</div>
	</div>
@endsection