@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('auth.register_register_title')}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{__('auth.register_firstname')}}&nbsp;*</label>

                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" placeholder="{{__('auth.register_firstname')}}" name="firstName" value="{{ old('firstName') }}" required autofocus maxlength="45">

                                @if ($errors->has('firstName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middleName" class="col-md-4 col-form-label text-md-right">{{__('auth.register_middlename')}}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('middleName') ? ' is-invalid' : '' }}" placeholder="{{__('auth.register_middlename')}}" name="middleName" value="{{ old('middleName') }}" maxlength="45">

                                @if ($errors->has('middleName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('middleName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{__('auth.register_lastname')}}</label>

                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}" placeholder="{{__('auth.register_lastname')}}" name="lastName" value="{{ old('lastName') }}" maxlength="45">

                                @if ($errors->has('lastName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{__('auth.register_gender')}}</label>

                            <div class="col-md-6">
                                <select name="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                    <option value="-">-</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->gender }}">{{ $gender->gender }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dateOfBirth" class="col-md-4 col-form-label text-md-right">{{__('auth.register_birthday')}}</label>

                            <div class="col-md-6">
                                <input type="date" name="dateOfBirth" value="{{ old('dateOfBirth') }}">

                                @if ($errors->has('dateOfBirth'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dateOfBirth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{__('auth.register_email')}}&nbsp;*</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="example@email.com">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{__('auth.register_password')}}&nbsp;*</label>

                            <div class="col-md-6">
                                <input id="password" minlength="8" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{__('auth.register_confirm_password')}}&nbsp;*</label>

                            <div class="col-md-6">
                                <input id="password-confirm" minlength="8" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="submit" type="submit" class="btn btn-primary">
                                    {{__('auth.register_register')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="logreg" class="col-md-8 offset-md-4">{!! __('auth.register_already_registered', ['url' => "/login"]) !!}</div>
    </div>
</div>
@endsection
