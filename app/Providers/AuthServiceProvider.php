<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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

        \Auth::provider('custom_auth', function ($app, $config) {
            return new CustomAuthProvider($this->app['hash'], $config['model']);
        });
        \Auth::provider('custom_auth_admin', function ($app, $config) {
            return new CustomAuthAdminProvider($this->app['hash'], $config['model']);
        });
    }
}
