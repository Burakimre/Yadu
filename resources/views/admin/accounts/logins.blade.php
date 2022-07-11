@extends('layouts/admin/app')

@section('content')
    <div class="row ml-3 mb-3">
        <div class="backlink">
            <a href="{{url('admin/accounts/'.$account->id)}}"><i class="fas fa-arrow-left"></i> {{__('accounts.back')}}
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <img class="img-fluid rounded-circle my-auto mr-3 avatar-lg"
                     src="data:image/jpeg;base64, {{base64_encode($account->avatar)}}"/>
                <h1 class="my-auto">{{$account->firstName .' '. $account->middleName .' '. $account->lastName}}</h1>
                <div class="ml-auto my-auto mr-3">
                    <button type="button" class="btn btn-danger my-auto" data-toggle="modal"
                            data-target="#confirmDeleteAccount">
                        {{__('accounts.edit_delete_account')}}
                    </button>
                    <div class="modal fade" id="confirmDeleteAccount" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('accounts.edit_delete_account_confirm_title')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{__('accounts.edit_delete_account_confirm_content')}}
                                </div>
                                <div class="modal-footer">
                                    <button type="submit"
                                            onclick="window.location.href='{{url('/admin/accounts/'. $account->id .'/delete')}}'"
                                            class="btn btn-danger">
                                        {{__('accounts.edit_delete_account_positive')}}</button>
                                    <button type="button" class="btn btn-primary"
                                            data-dismiss="modal">{{__('accounts.edit_delete_account_negative')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3>{{__('bans.logins_per_ip')}}</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">{{__('bans.ip')}}</th>
                            <th scope="col">{{__('bans.amount_of_logins')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($countedLogins as $ip => $amount)
                            <tr>
                                <th scope="col">{{ $ip }}</th>
                                <th scope="col">{{ $amount }}</th>
                                <td scope="col">
                                    @if(in_array($ip, $bannedIps))
                                        <a href="/admin/ip/{{$ip}}/unblock"><i class="fas fa-unlock"></i>&nbsp;{{__('bans.unblock')}}</a>
                                    @else
                                        <a href="/admin/ip/{{$ip}}/user/{{$account->id}}/block"><i class="fas fa-user-slash"></i>&nbsp;{{__('bans.block')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <h3>{{__('bans.logins')}}</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">{{__('bans.ip')}}</th>
                            <th scope="col">{{__('bans.login_date')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recentLogins as $login)
                            <tr>
                                <td>{{ $login['ip'] }}</td>
                                <td>{{ $login['created_at'] }}</td>
                                <td scope="col">
                                    @if(in_array($ip, $bannedIps))
                                        <a href="/admin/ip/{{$ip}}/unblock"><i class="fas fa-unlock"></i>&nbsp;{{__('bans.unblock')}}</a>
                                    @else
                                        <a href="/admin/ip/{{$ip}}/user/{{$account->id}}/block"><i class="fas fa-user-slash"></i>&nbsp;{{__('bans.block')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
@endsection