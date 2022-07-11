@extends('layouts/app')

@section('content')
	<div id="http_error">
		<h1>500 :(</h1>
		<div>
			<p>{{__('httperror.500')}}</p>
			<a href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> {{__('httperror.back')}}</a>
		</div>
	</div>
@endsection