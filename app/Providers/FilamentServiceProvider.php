<?php

namespace App\Providers;

use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
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
        Filament::serving(function () {
            Filament::registerTheme(
                app(Vite::class)('resources/css/app.css'),
            );

            Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder
                    ->group(
                        NavigationGroup::make()
                            ->label('General')
                            ->items([
                                NavigationItem::make('Dashboard')
                                    ->icon('heroicon-o-home')
                                    ->activeIcon('heroicon-s-home')
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                                    ->url(route('filament.pages.dashboard')),
                            ])
                    )
                    ->group(
                        NavigationGroup::make()
                            ->label('Access Management')
                            ->items([
                                ...UserResource::getNavigationItems(),
                                ...RoleResource::getNavigationItems(),
                                ...PermissionResource::getNavigationItems(),
                            ])
                    )
                    ->group(
                        NavigationGroup::make()
                            ->label('Settings')
                            ->items([
                                NavigationItem::make('My Profile')
                                    ->url(route('filament.pages.my-profile'))
                                    ->icon('heroicon-s-user-circle')
                                    ->activeIcon('heroicon-s-user-circle'),
                                NavigationItem::make('Log out')
                                    ->url(route('filament.auth.logout'))
                                    ->icon('heroicon-s-logout')
                                    ->activeIcon('heroicon-s-logout')
                            ])
                    );
            });
        });
    }
}
