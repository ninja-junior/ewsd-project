<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Using Vite
            // Filament::registerViteTheme('resources/css/filament.css');   
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Dashboard')
                    ->url(route('dashboard'))
                    ->icon('heroicon-s-chat-alt-2'),        
                    'logout' => UserMenuItem::make()->label('Log out'),
            ],
            
        );            
        });
    }
}
