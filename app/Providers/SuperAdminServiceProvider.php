<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class SuperAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Gate::before(function (User $user, string $ability) {
            // @note Gate::before need to return true or null, for super admins; never false.
            // This is because the policies classes wouldn't be checked for other roles so only Super Admins goes through.
            // return $user->hasRole(RoleEnum::SUPER_ADMIN->value) ? true : null;
        // });

        Gate::after(function (User $user) {
            // @note this restricts Super Admins in certain situations
            return $user->hasRole(RoleEnum::SUPER_ADMIN->value);
        });
    }
}
