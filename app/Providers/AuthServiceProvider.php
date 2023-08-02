<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /* define a admin user role */
        Gate::define('isAdmin', function($user) {
            return $user->role == 'super_admin';
        });

        /* define a recruiter user role */
        Gate::define('isRecruiter', function($user) {
            return $user->role == 'recruiter';
        });

        /* define a account manager role */
        Gate::define('isAccountManager', function($user) {
            return $user->role == 'account_manager';
        });

        /* define a account manager role */
        Gate::define('isTeamLead', function($user) {
            return $user->role == 'team_lead';
        });
    }
}
