<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Gate::define('admin', function (UserRole $user) {
            return $user->role_id == '1';
        });

        Gate::define('company', function (UserRole $user) {
            return $user->role_id == '2';
        });

        Gate::define('user', function (UserRole $user) {
            return $user->role_id == '3';
        });

        Blade::if('admin', function () {
            return request()->user()->can('admin');
        });

        Blade::if('company', function () {
            return request()->user()->can('company');
        });

        Blade::if('user', function () {
            return request()->user()->can('user');
        });
    }
}
