<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        Gate::define('subs-only', function($user){
            if ($user->name =="wind"){
                return true;
            }
                return false;
        });
        Gate::define('subs-only2', function($user){
            if ($user->name =="wind muser" ){
                return true;
            }
                return false;
        });
        Gate::define('subs-only3', function($user){
            if ($user->name =="Super Admin" ){
                return true;
            }
                return false;
        });
        //
    }
}
