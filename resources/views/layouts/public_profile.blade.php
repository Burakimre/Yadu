@extends('/layouts/app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="user_header" class="row">
                        <div class="col-md-auto">
                            <div id="user_avatar">
                                <img src="data:image/png;base64,{{ chunk_split(base64_encode($account->avatar)) }}">
                                <div>
                                    {{ $account->firstName }} {{ $account->middleName }} {{ $account->lastName }}
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div id="user_header_interactable" class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-md-auto">
                                            @if(! $account->blockedUsers->pluck('blockedAccount_id')->contains(Auth::user()->id))
                                                @if($account->id != Auth::user()->id)
                                                    @if(is_null($follow))
                                                        <a href="/profile/{{$account->id}}/follow" class="btn btn-primary">
                                                            <i class="fas fa-user-plus"></i> {{ __('profile.follow') }}
                                                        </a>
                                                    @endif
                                                    @if (! is_null($follow))
                                                        @if(((strtotime(Carbon\Carbon::now()->toDayDateTimeString()) - strtotime($follow->updated_at)) >= 10)&& !($follow->status == "accepted"))
                                                                <a href="/profile/{{$account->id}}/follow" class="btn btn-primary">
                                                                    <i class="fas fa-user-plus"></i> {{ __('profile.follow') }}
                                                                </a>
                                                         @elseif(($follow->status == "accepted")==1)
                                                            <a href="/profile/{{$account->id}}/unfollow" class="btn btn-primary">
                                                                <i class="fas fa-user-minus"></i> {{ __('profile.follow_accepted') }}
                                                            </a>
                                                        @endif
                                                        @if(((strtotime(Carbon\Carbon::now()->toDayDateTimeString()) - strtotime($follow->updated_at) ) < 10) && ($follow->status != "accepted"))
                                                            <a href="#" class="btn btn-primary" disabled>
                                                                <i class="fas fa-hourglass-end"></i> {{ __('profile.follow_pending') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                        @if($account->id != Auth::user()->id)
                                        <div class="col-md-auto">
                                                    @if(Auth::user()->blockedUsers->pluck('blockedAccount_id')->contains($account->id))
                                                    <form action="/profile/unblockUser" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$account->id}}">
                                                        <button type="submit"
                                                            class="btn btn-primary">{{__('profile.edit_unblock_account_button')}}</button>
                                                    </form>
                                                    @else
                                                    <form action="/profile/blockUser" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$account->id}}">
                                                        <button type="submit"
                                                            class="btn btn-primary">{{__('profile.edit_block_account_button')}}</button>
                                                    </form>
                                                    @endif
										</div> 
										@endif
                                    </div>
                                </div>
                            </div>
                            <div id="user_header_tabs" class="row align-items-end">
                                <div class="col">
                                    <div id="account_tabs">
                                        <ul>
                                            <!--nav nav-tabs-->
                                            @if( $account->id == Auth::user()->id )
                                            <li><a href="/account/{{ $account->id }}/profile/info"><i
                                                        class="fas fa-user"></i> {{__('profile.head_me_info')}}</a>
                                            </li>
                                            <li><a href="/account/{{ $account->id }}/profile/events"><i
                                                        class="fas fa-calendar-alt"></i>
                                                    {{__('profile.head_my_events')}}</a></li>
                                            <li><a href="/account/{{ $account->id }}/profile/participating"><i
                                                        class="fas fa-calendar-alt"></i>
                                                    {{__('profile.head_participating')}}</a></li>
                                            <li><a href="/account/{{ $account->id }}/profile/followers"><i
                                                        class="fas fa-users"></i>
                                                    {{__('profile.head_followers')}}</a></li>
                                            <li><a href="/account/{{ $account->id }}/profile/following"><i
                                                        class="fas fa-user-friends"></i>
                                                    {{__('profile.head_following')}}</a></li>
                                            @else
                                            @if($account->infoVisibility == 'public' || ($account->infoVisibility ==
                                            'follower' && $follow->status == "accepted"))
                                            <li><a href="/account/{{ $account->id }}/profile/info"><i
                                                        class="fas fa-user"></i> {{__('profile.head_info')}}</a>
                                            </li>
                                            @endif

                                            @if($account->eventsVisibility == 'public' ||
                                            ($account->eventsVisibility == 'follower' && $follow->status ==
                                            "accepted"))
                                            <li><a href="/account/{{ $account->id }}/profile/events"><i
                                                        class="fas fa-calendar-alt"></i>
                                                    {{__('profile.head_events')}}</a></li>
                                            @endif

                                            @if($account->participatingVisibility == 'public' ||
                                            ($account->participatingVisibility == 'public' && $follow->status ==
                                            "accepted"))
                                            <li><a href="/account/{{ $account->id }}/profile/participating"><i
                                                        class="fas fa-calendar-alt"></i>
                                                    {{__('profile.head_participating')}}</a></li>
                                            @endif

                                            @if($account->followerVisibility == 'public' ||
                                            ($account->followerVisibility == 'follower' && $follow->status ==
                                            "accepted"))
                                            <li><a href="/account/{{ $account->id }}/profile/followers"><i
                                                        class="fas fa-users"></i>
                                                    {{__('profile.head_followers')}}</a></li>
                                            @endif

                                            @if($account->followingVisibility == 'public' ||
                                            ($account->followingVisibility == 'follower' && $follow->status ==
                                            "accepted"))
                                            <li><a href="/account/{{ $account->id }}/profile/following"><i
                                                        class="fas fa-user-friends"></i>
                                                    {{__('profile.head_following')}}</a></li>
                                            @endif
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @yield('profilecontent')

            </div>
        </div>
    </div>
</div>
@endsection