<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Auth;


class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        //Horizon::routeMailNotificationsTo('paulosanda@gmail.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
        // Horizon::night();
       // Horizon::auth(function ($request) {
            //return true;
           // return auth()->user()->isAdmin;
       // });
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user) {
            return in_array($user->email, [
                'paulosanda@gmail.com',
            ]);
            
        });
       
    }
}
