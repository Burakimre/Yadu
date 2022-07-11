@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__('auth.login_banned_title')}}</div>
                    <div class="card-body">
                        {{__('auth.login_banned_content')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
