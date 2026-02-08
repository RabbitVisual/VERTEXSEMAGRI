<?php

namespace Modules\Materiais\Providers;

use Modules\Materiais\App\Models\Material;
use Modules\Materiais\App\Observers\MaterialObserver;
use Modules\Materiais\Console\SyncNcmCommand; // Import the command
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;

class MateriaisServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string  = 'Materiais';
    protected string  = 'materiais';

    public function boot(): void
    {
        ->registerCommands();
        ->registerCommandSchedules();
        ->registerTranslations();
        ->registerConfig();
        ->registerViews();
        ->loadMigrationsFrom(module_path(->name, 'database/migrations'));
        
        // Registrar Observer para Materiais
        Material::observe(MaterialObserver::class);
    }

    public function register(): void
    {
        ->app->register(RouteServiceProvider::class);
    }

    protected function registerCommands(): void { $this->commands([\Modules\Materiais\App\Console\SyncMateriaisCommand::class]); }

    protected function registerCommandSchedules(): void {}

    public function registerTranslations(): void
    {
         = resource_path('lang/modules/'.->nameLower);
        if (is_dir()) {
            ->loadTranslationsFrom(, ->nameLower);
            ->loadJsonTranslationsFrom();
        } else {
            ->loadTranslationsFrom(module_path(->name, 'lang'), ->nameLower);
            ->loadJsonTranslationsFrom(module_path(->name, 'lang'));
        }
    }

    public function registerConfig(): void
    {
        ->mergeConfigFrom(module_path(->name, 'config/config.php'), ->nameLower);
    }

    public function registerViews(): void
    {
         = resource_path('views/modules/'.->nameLower);
         = module_path(->name, 'resources/views');
        ->publishes([ => ], ['views', ->nameLower.'-module-views']);
        ->loadViewsFrom(array_merge(->getPublishableViewPaths(), []), ->nameLower);

        Blade::componentNamespace(config('modules.namespace').'\' . ->name . '\View\Components', ->nameLower);
    }

    private function getPublishableViewPaths(): array
    {
         = [];
        foreach (\Config::get('view.paths') as ) {
            if (is_dir(.'/modules/'.->nameLower)) {
                [] = .'/modules/'.->nameLower;
            }
        }
        return ;
    }
}
