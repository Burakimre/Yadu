<?php

namespace App\Providers;
use App\Services\IpApi;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IpApi::class, function(){
            return new IpApi(config('services.location_API.IP_API_KEY'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
