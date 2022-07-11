<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;
use Illuminate\Support\Facades\Auth;

class ForceLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $forceLogout = Account::where('id', Auth::id())->pluck('doForceLogout')->first();
            if($forceLogout == 1){
                Account::where('id', Auth::id())->update(['doForceLogout' => 0]);
                Auth::logout();
            }
        }
        return $next($request);
    }
}
