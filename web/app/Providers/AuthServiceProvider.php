<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // The routes of passport.
        Passport::routes();

        Passport::personalAccessTokensExpireIn(Carbon::now()->addDay(7));//determina la duracion del token en 7 dias
        Passport::tokensExpireIn(Carbon::now()->addDay(7));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));//Se eliminan en 30 dias los tokens expirados
    }
}
