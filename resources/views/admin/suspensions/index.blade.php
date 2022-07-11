@extends('layouts/admin/app')

@section('custom_css')
	<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@endsection

@section('custom_script')

@endsection
@section('content')

	<div class="card">
		<div class="card-header">
			<h2>IP</h2>
		</div>
		<div class="card-body">
			<div>
				{{$ips->links() }}
				<table class="table">
					<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">IP</th>
						<th scope="col"></th>
					</tr>
					</thead>

					<tbody>
					@foreach($ips as $ip)
						<tr>
							<td>{{$ip->id}}</td>
							<td>{{$ip->ip}}</td>
							<td>
								<form method="POST" action="/admin/suspensions/ip/{{$ip->id}}/destroy" class="btn_inline">
									@csrf
									<input hidden name="ip" value="{{$ip->ip}}">
									<button type="submit" class="button-remove button-hover">{{__('ProhibitedWords.show_delete')}}</button>
								</form>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection