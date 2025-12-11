<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config; // <--- ¡IMPORTANTE! Agrega esta línea

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
        // Forzar HTTPS
        URL::forceScheme('https');

        // Forzar PostgreSQL (La Solución Nuclear)
        Config::set('database.default', 'pgsql'); 
    }
}
