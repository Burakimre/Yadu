@extends('layouts/app')

@section('content')
	<div id="http_error">
		<h1>401 :(</h1>
		<div>
			<h2>{{ $exception->getMessage() }}</h2>
			<p>{{__('httperror.401')}}</p>
			<a href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> {{__('httperror.back')}}</a>
		</div>
	</div>
@endsection