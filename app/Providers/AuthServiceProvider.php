<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::routes();

        $this->registerPolicies();

        Gate::resource('post', PostPolicy::class);
        Gate::define('post.publish', PostPolicy::class . '@publish');
        Gate::define('post.draft', PostPolicy::class . '@draft');
        //
    }
}
