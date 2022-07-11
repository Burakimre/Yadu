@extends('/layouts/public_profile')

@section('profilecontent')
<div class="row">
	<div class="col">
		<h3>{{__('profile.head_followers')}}</h3>

		@foreach( $followers as $follower)
			<div class="profile_related_user ">
				<a href="/account/{{ $follower->id }}/profile/info">
					<div class="row">
						<div class="col-4">
							<div class="profile_image">
								<img src="data:image/png;base64,{{ chunk_split(base64_encode($follower->avatar)) }}">
							</div>
						</div>
						<div class="col-8">
							<h6>{{ $follower->firstName }} {{ $follower->middleName }} {{ $follower->lastName }}</h6>
						</div>
					</div>
				</a>
			</div>
		@endforeach
	</div>
</div>

@endsection