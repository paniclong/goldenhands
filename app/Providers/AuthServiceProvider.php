<?php

namespace App\Providers;

use App\Modules\Auth\Services\JwtGuard;
use App\Modules\Auth\Services\JwtTokenService;
use App\Modules\Auth\Services\UserSessionService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('jwt', static function (Application $app, $name, array $config) {
            return new JwtGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request'),
                $app->make(JwtTokenService::class),
                $app->make(UserSessionService::class),
            );
        });
    }
}
