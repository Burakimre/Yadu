@extends('/layouts/public_profile')

@section('profilecontent')
<div class="row">
	<div class="col">
		<h3>{{__('profile.head_following')}}</h3>

		@foreach( $following as $following)
			<div class="profile_related_user ">
				<a href="/account/{{ $following->id }}/profile/info">
					<div class="row">
						<div class="col-4">
							<div class="profile_image">
								<img src="data:image/png;base64,{{ chunk_split(base64_encode($following->avatar)) }}">
							</div>
						</div>
						<div class="col-8">
							<h6>{{ $following->firstName }} {{ $following->middleName }} {{ $following->lastName }}</h6>
						</div>
					</div>
				</a>
			</div>
		@endforeach
	</div>
</div>

@endsection