<?php

namespace App\Http\Controllers\Auth;

use App\Account;
use App\BannedIp;
use App\Login;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // redirect user to previous page after logging in.
    public function showLoginForm()
    {
        if(BannedIp::where('ip', \request()->ip())->exists()){
            return view('auth.ipbanned');
        }

        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        return view('auth.login');
    }

    public function authenticated(Request $request, $user)
    {
        $login = new Login();
        $login->account_id = $user->id;
        $login->ip = $request->ip();

        $login->save();
    }
}
