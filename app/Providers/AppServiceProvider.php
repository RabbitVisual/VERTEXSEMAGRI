<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\CampoOrdensComposer;

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
        // Configurar paginação para usar Tailwind CSS
        \Illuminate\Pagination\Paginator::defaultView('pagination::tailwind');
        \Illuminate\Pagination\Paginator::defaultSimpleView('pagination::simple-tailwind');

        // Registrar View Composer para compartilhar ordens pendentes no painel Campo
        View::composer('campo.*', CampoOrdensComposer::class);
    }
}
