<?php namespace App\Http\Middleware;

use Closure, Session, Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['en', 'nl'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('locale')) {

            if(Cookie::get('language') != null){
                $language = Cookie::get('language');
            }
            else
            {
                $language = $request->getPreferredLanguage($this->languages);
            }

            Session::put('locale', $language);
        }

        App::setLocale(Session::get('locale'));

        return $next($request);
    }
}