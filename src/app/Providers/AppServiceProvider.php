<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Definir paginação Bootstrap 5 como padrão
        \Illuminate\Pagination\Paginator::defaultView('pagination.bootstrap-5');
        \Illuminate\Pagination\Paginator::defaultSimpleView('pagination.bootstrap-5');
    }
}
