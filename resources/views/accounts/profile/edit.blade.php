@extends('layouts/app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">

			<div class="col-md-8">
				<div class="backlink">
					<a href="/home"><i class="fas fa-arrow-left"></i> Dashboard</a>
				</div>

				<div class="card">
					<div class="card-header">{{__('profile.edit_avatar_title')}}</div>

					<div class="row px-3 pb-3">
						<div class="col-xl-5 mt-3">
							<img class="w-100"
								 src="data:image/png;base64,{{ chunk_split(base64_encode(Auth::user()->avatar)) }}">
						</div>
						<div class="col-xl-7 mt-3">
							<form method="POST" action="/profile/updateAvatar" enctype="multipart/form-data">
								@csrf

								<input type="hidden" id="accountId" name="accountId" value="{{$account->id}}">
								<div class="form-group row w-100">
									<div class="input-group">
										<div class="input-group-prepend">
                                                <span class="input-group-text"
													  id="inputGroupFileAddon01">{{__('profile.edit_edit_avatar_upload')}}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="avatar" id="avatar" accept="image/*" aria-describedby="inputGroupFileAddon01">
											<label id="custom-file-label" class="custom-file-label lineClamp"
												   for="avatar">{{__('profile.edit_edit_avatar_choose_image')}}</label>
										</div>
									</div>
									<span class="tiny-text">{{__('profile.edit_avatar_info')}}</span>

									@if ($errors->has('avatar'))
										<span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                        </span>
									@endif
								</div>
								<input class="btn btn-primary" type="submit"
									   value="{{__('profile.edit_update_avatar')}}" name="submit">
							</form>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header">{{__('profile.edit_edit_profile_title')}}</div>

					<div class="card-body">
						<form method="POST" action="/profile/updateProfile">
							@csrf
							<input type="hidden" id="accountId" name="accountId" value="{{$account->id}}">
							<div class="form-group row">
								<label for="firstName"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_firstname')}}
									&nbsp;*</label>

								<div class="col-md-6">
									<input id="firstName" type="text"
										   class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}"
										   placeholder="{{__('profile.edit_firstname')}}" name="firstName"
										   value="{{$account->firstName}}"
										   required
										   autofocus maxlength="45">

									@if ($errors->has('firstName'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('firstName') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="middleName"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_middlename')}}</label>

								<div class="col-md-6">
									<input id="middleName" type="text"
										   class="form-control{{ $errors->has('middleName') ? ' is-invalid' : '' }}"
										   placeholder="{{__('profile.edit_middlename')}}" name="middleName"
										   value="{{$account->middleName}}"
										   maxlength="45">

									@if ($errors->has('middleName'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('middleName') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="lastName"
									   class="col-md-4 col-form-label text-md-right">{{ __('profile.edit_lastname')}}</label>

								<div class="col-md-6">
									<input id="lastName" type="text"
										   class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}"
										   placeholder="{{ __('profile.edit_lastname')}}" name="lastName"
										   value="{{$account->lastName}}"
										   maxlength="45">

									@if ($errors->has('lastName'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('lastName') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="gender"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_gender')}}</label>
								<div class="col-md-6">
									<select name="gender" selected="{{$account->gender}}"
											class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
										<option value="-" selected>-</option>
										@foreach($genders as $gender)
											@if($gender->gender == $account->gender)
												<option value="{{ $gender->gender }}" selected>{{ $gender->gender }}</option>
											@else
												<option value="{{ $gender->gender }}">{{ $gender->gender }}</option>
											@endif
										@endforeach
									</select>
									@if ($errors->has('gender'))

										<span class="invalid-feedback force-show" role="alert">
										<strong>{{ $errors->first('gender') }}</strong>
									</span>
									@endif
								</div>

							</div>

							<div class="form-group row">
								<label for="dateOfBirth"
									   class="col-md-4 col-form-label text-md-right">{{ __('profile.edit_birthday')}}</label>

								<div class="col-md-6">
									<input type="date" name="dateOfBirth" value="{{$account->dateOfBirth}}"
										   class="form-control{{ $errors->has('dateOfBirth') ? ' is-invalid' : '' }}">

									@if ($errors->has('dateOfBirth'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('dateOfBirth') }}</strong>
									</span>
									@endif
								</div>
							</div>


							<div class="form-group row">
								<label for="email"
									   class="col-md-4 col-form-label text-md-right">{{ __('profile.edit_email')}}&nbsp;*</label>

								<div class="col-md-6">
									<input id="email" type="email"
										   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
										   name="email" value="{{$account->email}}" required
										   placeholder="example@example.com">

									@if ($errors->has('email'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button id="submit" type="submit" class="btn btn-primary">
										{{__('profile.edit_update_profile')}}
									</button>
								</div>
							</div>

						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-header">{{__('profile.edit_privacy_head')}}</div>

					<div class="card-body">
						<form method="POST" action="/profile/updatePrivacySettings">
							@csrf
							<input type="hidden" id="accountId" name="accountId" value="{{$account->id}}">

							<div class="form-group row">
								<label for="followerVisibility"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_privacy_followerVisibility')}}</label>
								<div class="col-md-6">
									<select name="followerVisibility" selected="{{$account->followerVisibility}}"
											class="form-control{{ $errors->has('followerVisibility') ? ' is-invalid' : '' }}">
										@if( $account->followerVisibility == 'private' )
											<option value="private" selected>Private</option>
											<option value="follower">Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->followerVisibility == 'follower' )
											<option value="private">Private</option>
											<option value="follower" selected>Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->followerVisibility == 'public' )
											<option value="private">Private</option>
											<option value="follower">Followers only</option>
											<option value="public" selected>Public</option>
										@endif
									</select>
									@if ($errors->has('followerVisibility'))
										<span class="invalid-feedback force-show" role="alert">
										<strong>{{ $errors->first('followerVisibility') }}</strong>
									</span>
									@endif
								</div>
								<div class="CSH_tooltip">
									<i class="fas fa-question-circle"></i>
									<span class="tooltiptext">{{__('profile.CSH_privacy_follower')}}</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="followingVisibility"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_privacy_followingVisibility')}}</label>
								<div class="col-md-6">
									<select name="followingVisibility" selected="{{$account->followingVisibility}}" class="form-control{{ $errors->has('followingVisibility') ? ' is-invalid' : '' }}">
										@if( $account->followingVisibility == 'private' )
											<option value="private" selected>Private</option>
											<option value="follower">Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->followingVisibility == 'follower' )
											<option value="private">Private</option>
											<option value="follower" selected>Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->followingVisibility == 'public' )
											<option value="private">Private</option>
											<option value="follower">Followers only</option>
											<option value="public" selected>Public</option>
										@endif
									</select>
									@if ($errors->has('followingVisibility'))
										<span class="invalid-feedback force-show" role="alert">
										<strong>{{ $errors->first('followingVisibility') }}</strong>
									</span>
									@endif
								</div>
								<div class="CSH_tooltip">
									<i class="fas fa-question-circle"></i>
									<span class="tooltiptext">{{__('profile.CSH_privacy_following')}}</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="infoVisibility"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_privacy_infoVisibility')}}</label>
								<div class="col-md-6">
									<select name="infoVisibility" selected="{{$account->infoVisibility}}"
											class="form-control{{ $errors->has('infoVisibility') ? ' is-invalid' : '' }}">
										@if( $account->infoVisibility == 'private' )
											<option value="private" selected>Private</option>
											<option value="follower">Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->infoVisibility == 'follower' )
											<option value="private">Private</option>
											<option value="follower" selected>Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->infoVisibility == 'public' )
											<option value="private">Private</option>
											<option value="follower">Followers only</option>
											<option value="public" selected>Public</option>
										@endif
									</select>
									@if ($errors->has('infoVisibility'))
										<span class="invalid-feedback force-show" role="alert">
										<strong>{{ $errors->first('infoVisibility') }}</strong>
									</span>
									@endif
								</div>
								<div class="CSH_tooltip">
									<i class="fas fa-question-circle"></i>
									<span class="tooltiptext">{{__('profile.CSH_privacy_info')}}</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="eventsVisibility"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_privacy_eventsVisibility')}}</label>
								<div class="col-md-6">
									<select name="eventsVisibility" selected="{{$account->eventsVisibility}}"
											class="form-control{{ $errors->has('eventsVisibility') ? ' is-invalid' : '' }}">
										@if( $account->eventsVisibility == 'private' )
											<option value="private" selected>Private</option>
											<option value="follower">Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->eventsVisibility == 'follower' )
											<option value="private">Private</option>
											<option value="follower" selected>Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->eventsVisibility == 'public' )
											<option value="private">Private</option>
											<option value="follower">Followers only</option>
											<option value="public" selected>Public</option>
										@endif
									</select>
									@if ($errors->has('eventsVisibility'))
										<span class="invalid-feedback force-show" role="alert">
										<strong>{{ $errors->first('eventsVisibility') }}</strong>
									</span>
									@endif
								</div>
								<div class="CSH_tooltip">
									<i class="fas fa-question-circle"></i>
									<span class="tooltiptext">{{__('profile.CSH_privacy_events')}}</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="participatingVisibility"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_privacy_participatingVisibility')}}</label>
								<div class="col-md-6">
									<select name="participatingVisibility" selected="{{$account->participatingVisibility}}"
											class="form-control{{ $errors->has('participatingVisibility') ? ' is-invalid' : '' }}">
										@if( $account->participatingVisibility == 'private' )
											<option value="private" selected>Private</option>
											<option value="follower">Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->participatingVisibility == 'follower' )
											<option value="private">Private</option>
											<option value="follower" selected>Followers only</option>
											<option value="public">Public</option>
										@elseif( $account->participatingVisibility == 'public' )
											<option value="private">Private</option>
											<option value="follower">Followers only</option>
											<option value="public" selected>Public</option>
										@endif
									</select>
									@if ($errors->has('participatingVisibility'))
										<span class="invalid-feedback force-show" role="alert">
										<strong>{{ $errors->first('participatingVisibility') }}</strong>
									</span>
									@endif
								</div>
								<div class="CSH_tooltip">
									<i class="fas fa-question-circle"></i>
									<span class="tooltiptext">{{__('profile.CSH_privacy_participating')}}</span>
								</div>
							</div>
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button id="submit" type="submit" class="btn btn-primary">
										{{__('profile.edit_update_profile')}}
									</button>
								</div>
							</div>

						</form>
					</div>
				</div>


				<!-- Email language preference settings -->
				<div class="card">
					<div class="card-header">
						{{__('profile.edit_change_account_settings_language_preference_title')}}
					</div>
					<div class="card-body">
						<form method="POST" action="/profile/setMailLanguage">
						@csrf
							<div class="form-group row justify-content-md-center">
								<label for="FollowNotificationCreateEvent"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_change_account_settings_language_preference')}}
								</label>

								<div class="col-md-6">
									<select name="LanguagePreference" selected="{{$account->LanguagePreference}}"
											class="form-control{{ $errors->has('LanguagePreference') ? ' is-invalid' : '' }}">
										@if($account->settings->LanguagePreference == 'eng')
											<option value="English" selected>{{__('profile.English')}}</option>
											<option value="Dutch">{{__('profile.Dutch')}}</option>
										@elseif($account->settings->LanguagePreference == 'nl')
											<option value="English">{{__('profile.English')}}</option>
											<option value="Dutch" selected>{{__('profile.Dutch')}}</option>
										@endif
									</select>
									@if ($errors->has('LanguagePreference'))
										<span class="invalid-feedback force-show" role="alert">
                							<strong>{{ $errors->first('LanguagePreference') }}</strong>
            							</span>
									@endif
								</div>
							</div>

							<div class="col-md-6 offset-md-4">
								<div class="col">
									<button id="submit" type="submit" class="btn btn-primary">
										{{__('profile.edit_change_account_setting')}}
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- Notification settings -->
				<div class="card">
					<div class="card-header">
						{{__('profile.edit_change_account_settings_title')}}
					</div>
					<div class="card-body">
						<form method="POST" action="/profile/updateAccountSettings">
							@csrf
							<div class="form-group row justify-content-md-center">
								<h5>{{__('profile.edit_change_account_settings_follow_notification_title')}}</h5>
							</div>
							<div class="form-group row justify-content-md-center">
								<label for="FollowNotificationCreateEvent"
									   class="col col-form-label text-md-right">{{__('profile.edit_change_account_settings_follow_notification_creation')}}
								</label>

								<div class="col">
									<div class="custom-control custom-switch">
										@if($account->settings->FollowNotificationCreateEvent == 0)
											<input type="checkbox" name="FollowNotificationCreateEvent" class="custom-control-input" id="customSwitches">
										@else
											<input type="checkbox" name="FollowNotificationCreateEvent" class="custom-control-input" id="customSwitches" checked>
										@endif
										<label class="custom-control-label" for="customSwitches"></label>
										<div class="CSH_tooltip">
											<i class="fas fa-question-circle"></i>
											<span class="tooltiptext">{{__('profile.CSH_notifications_eventCreated')}}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row justify-content-md-center">
								<label for="FollowNotificationJoinEvent"
									   class="col col-form-label text-md-right">{{__('profile.edit_change_account_settings_follow_notification_join')}}
								</label>
								<div class="col">
									<div class="custom-control custom-switch">
										@if($account->settings->FollowNotificationJoinAndLeaveEvent == 0)
											<input type="checkbox" name="FollowNotificationJoinAndLeaveEvent" class="custom-control-input" id="customSwitches1">
										@else
											<input type="checkbox" name="FollowNotificationJoinAndLeaveEvent" class="custom-control-input" id="customSwitches1" checked>
										@endif
										<label class="custom-control-label" for="customSwitches1"></label>
										<div class="CSH_tooltip">
											<i class="fas fa-question-circle"></i>
											<span class="tooltiptext">{{__('profile.CSH_notifications_follower')}}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row justify-content-md-center">
								<h5>{{__('profile.edit_change_account_settings_event_notification_title')}}</h5>
							</div>
							<div class="form-group row justify-content-md-center">
								<label for="NotificationEventEdited"
									   class="col col-form-label text-md-right">{{__('profile.edit_change_account_settings_event_edited')}}
								</label>
								<div class="col">
									<div class="custom-control custom-switch">
										@if($account->settings->NotificationEventEdited == 0)
											<input type="checkbox" name="NotificationEventEdited" class="custom-control-input" id="customSwitches3">
										@else
											<input type="checkbox" name="NotificationEventEdited" class="custom-control-input" id="customSwitches3" checked>
										@endif
										<label class="custom-control-label" for="customSwitches3"></label>
										<div class="CSH_tooltip">
											<i class="fas fa-question-circle"></i>
											<span class="tooltiptext">{{__('profile.CSH_notifications_eventEdited')}}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row justify-content-md-center">
								<label for="NotificationEventDeleted"
									   class="col col-form-label text-md-right">{{__('profile.edit_change_account_settings_event_deleted')}}
								</label>
								<div class="col">
									<div class="custom-control custom-switch">
										@if($account->settings->NotificationEventDeleted == 0)
											<input type="checkbox" name="NotificationEventDeleted" class="custom-control-input" id="customSwitches4">
										@else
											<input type="checkbox" name="NotificationEventDeleted" class="custom-control-input" id="customSwitches4" checked>
										@endif
										<label class="custom-control-label" for="customSwitches4"></label>
										<div class="CSH_tooltip">
											<i class="fas fa-question-circle"></i>
											<span class="tooltiptext">{{__('profile.CSH_notifications_eventDeleted')}}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row justify-content-md-center">
								<h5>{{__('profile.edit_change_account_settings_notification_title')}}</h5>
							</div>
							<div class="form-group row justify-content-md-center">
								<label for="FollowNotificationJoinEvent"
									   class="col col-form-label text-md-right">{{__('profile.edit_change_account_settings_notification_join')}}
								</label>
								<div class="col">
									<div class="custom-control custom-switch">
										@if($account->settings->NotificationJoinAndLeaveEvent == 0)
											<input type="checkbox" name="NotificationJoinAndLeaveEvent" class="custom-control-input" id="customSwitches5">
										@else
											<input type="checkbox" name="NotificationJoinAndLeaveEvent" class="custom-control-input" id="customSwitches5" checked>
										@endif
										<label class="custom-control-label" for="customSwitches5"></label>
										<div class="CSH_tooltip">
											<i class="fas fa-question-circle"></i>
											<span class="tooltiptext">{{__('profile.CSH_notifications_eventJoinedLeft')}}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button id="submit" type="submit" class="btn btn-primary">
										{{__('profile.edit_change_account_settings')}}
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-header">{{__('profile.edit_change_password_title')}}</div>
					<div class="card-body">
						<form method="POST" action="/profile/changePassword">
							@csrf
							<div class="form-group row">
								<label for="currentPassword"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_current_password')}}
									*</label>

								<div class="col-md-6">
									<input id="currentPassword" minlength="8" type="password"
										   class="form-control{{ $errors->has('currentPassword') ? ' is-invalid' : '' }}"
										   name="currentPassword" required>

									@if ($errors->has('currentPassword'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('currentPassword') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="newPassword"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_new_password')}}
									*</label>

								<div class="col-md-6">
									<input id="newPassword" minlength="8" type="password"
										   class="form-control{{ $errors->has('newPassword') ? ' is-invalid' : '' }}"
										   name="newPassword" required>

									@if ($errors->has('newPassword'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('newPassword') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label for="newPassword_confirmation"
									   class="col-md-4 col-form-label text-md-right">{{__('profile.edit_confirm_new_password')}}
									*</label>

								<div class="col-md-6">
									<input id="newPassword_confirmation" minlength="8" type="password"
										   class="form-control"
										   name="newPassword_confirmation" required>

									@if ($errors->has('confirmNewPassword'))
										<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('confirmNewPassword') }}</strong>
									</span>
									@endif

								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button id="submit" type="submit" class="btn btn-primary">
										{{__('profile.edit_change_password')}}
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-header"> {{__('profile.edit_unblock_account_title')}}</div>
					<div class="card-body">
						@foreach ( $account->blockedUsers as $blockedUser )
							<form method="POST" id="unblock{{$blockedUser->blockedAccount->firstName}}" action="/profile/unblockUser">
								@csrf
								<input type="hidden" name="id" value="{{$blockedUser->blockedAccount->id}}">
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-md-right">{{$blockedUser->blockedAccount->firstName}} {{ $blockedUser->blockedAccount->middleName }} {{ $blockedUser->blockedAccount->lastName }}</label>
									<div class="col-md-4">
										<button type="button" class="btn btn-primary float-right" data-toggle="modal"
												data-target="#confirmUnblockAccount{{$blockedUser->blockedAccount->firstName}}">
											{{__('profile.edit_unblock_account_button')}}
										</button>
									</div>

									<div class="modal fade" id="confirmUnblockAccount{{$blockedUser->blockedAccount->firstName}}" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">{{__('profile.edit_delete_account_confirm_title')}}</h5>
													<button type="button" class="close" data-dismiss="modal"
															aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													{{__('profile.edit_unblock_account_areYouSure', ['name' => $blockedUser->blockedAccount->firstName])}}

												</div>
												<div class="modal-footer">
													<input type="submit" form="unblock{{$blockedUser->blockedAccount->firstName}}" class="btn btn-danger"
														   value="{{__('profile.edit_unblock_account_positive', ['name' => $blockedUser->blockedAccount->firstName])}}">
													<button type="button" class="btn btn-primary"
															data-dismiss="modal">{{__('profile.edit_unblock_account_negative', ['name' => $blockedUser->blockedAccount->firstName])}}
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						@endforeach
					</div>
				</div>

				<div class="card">
					<div class="card-header">{{__('profile.edit_delete_account_title')}}</div>
					<div class="card-body">
						<form method="POST" id="deleteAccount" action="/profile/deleteAccount">
							@csrf
							<div class="form-group row">
								<label for="currentPassword"
									   class="col-md-8 col-form-label text-md-left">
									{{__('profile.edit_delete_account_content')}}</br>
									<strong>{{__('profile.edit_delete_account_cannot_be_undone')}}</strong>
								</label>

								<div class="col-md-4 mt-2">
									<button type="button" class="btn btn-danger float-right" data-toggle="modal"
											data-target="#confirmDeleteAccount">
										{{__('profile.edit_delete_account')}}
									</button>
								</div>

								<div class="modal fade" id="confirmDeleteAccount" tabindex="-1" role="dialog">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">{{__('profile.edit_delete_account_confirm_title')}}</h5>
												<button type="button" class="close" data-dismiss="modal"
														aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												{{__('profile.edit_delete_account_confirm_content')}}
											</div>
											<div class="modal-footer">
												<input type="submit" form="deleteAccount" class="btn btn-danger"
													   value="{{__('profile.edit_delete_account_positive')}}">
												<button type="button" class="btn btn-primary"
														data-dismiss="modal">{{__('profile.edit_delete_account_negative')}}
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
